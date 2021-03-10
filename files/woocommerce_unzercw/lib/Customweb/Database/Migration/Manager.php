<?php 
/**
  * You are allowed to use this API in your web application.
 *
 * Copyright (C) 2018 by customweb GmbH
 *
 * This program is licenced under the customweb software licence. With the
 * purchase or the installation of the software in your application you
 * accept the licence agreement. The allowed usage is outlined in the
 * customweb software licence which can be found under
 * http://www.sellxed.com/en/software-license-agreement
 *
 * Any modification or distribution is strictly forbidden. The license
 * grants you the installation in one application. For multiuse you will need
 * to purchase further licences at http://www.sellxed.com/shop.
 *
 * See the customweb software licence agreement for more details.
 *
 */

require_once 'Customweb/Database/Migration/IManager.php';
require_once 'Customweb/Database/Migration/IScript.php';


/**
 * This implementation of the migration manager executes a set of scripts. The order
 * of the execution is controlled by the naming of the scripts. 
 * 
 * The manager expects to read the scripts from a folder.
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Database_Migration_Manager implements Customweb_Database_Migration_IManager {
	
	private $migrationScriptFolder = null;
	private $driver = null;
	private $versions = null;
	private $schemaVersionTableName = null;
	
	private static $migrated = false;
	
	const MIGRATION_SCRIPT_TYPE_PHP = 'PHP';
	const MIGRATION_SCRIPT_TYPE_SQL = 'SQL';
	
	
	/**
	 * The $migrationScriptFolder should contains a set of scripts which migrate the database schema. The version
	 * number to which the migration should be done must be in the file name of the script. 
	 * The file name may contain also a comment. This must be separated by two underlines. Sample names:
	 * <ul>
	 *  <li>1.0.0__Initial_Version.sql</li>
	 *  <li>1.0.1__Minor_Update.php</li>
	 *  <li>2.0__Major_Update.php</li>
	 * </ul>
	 * 
	 * In case the script ends with '.sql' then it will be executed as SQL. In case it ends with '.php' then it is threaded
	 * as PHP code. The PHP code must provide a class which implements Customweb_Database_Migration_IScript. The Name of the 
	 * class must contain the version number (point should be replaced by underlines).
	 * 
	 * @param Customweb_Database_IDriver $driver The database driver.
	 * @param string $migrationScriptFolder Folder of the scripts used to migrate between versions.
	 * @param string $schemaVersionTableName The table name to store information about the schema versions.
	 */
	public function __construct(Customweb_Database_IDriver $driver, $migrationScriptFolder, $schemaVersionTableName) {
		
		if (!file_exists($migrationScriptFolder)) {
			throw new InvalidArgumentException("The dir '" . strip_tags($migrationScriptFolder) . "' does not exists.");
		}
		
		if (!is_dir($migrationScriptFolder)) {
			throw new InvalidArgumentException("The path '" . strip_tags($migrationScriptFolder) . "' is not a dir.");
		}
		
		$this->migrationScriptFolder = $migrationScriptFolder;
		$this->driver = $driver;
		$this->schemaVersionTableName = $schemaVersionTableName;
	}
	
	
	public function migrate() {
		if (self::$migrated === false) {
			$versions = $this->getVersions();
			$lastVersion = end($versions);
			$lastVersionNumber = $lastVersion['versionNumber'];
			if (version_compare($this->getCurrentSchemaVersion(), $lastVersionNumber) < 0) {
				$this->runMigrationScripts();
			}
		}
	}
	
	public function isMigrationRequired(){
		$versions = $this->getVersions();
		$lastVersion = end($versions);
		$lastVersionNumber = $lastVersion['versionNumber'];
		if (version_compare($this->getCurrentSchemaVersion(), $lastVersionNumber) < 0) {
			return true;
		}
		return false;
	}
	
	protected function runMigrationScripts() {
		$hasStartedTransaction = false;
		if (!$this->getDriver()->isTransactionRunning()) {
			$this->getDriver()->beginTransaction();
			$hasStartedTransaction = true;
		}
		try {
			$this->createSchemaVersionTable();
			$versions = $this->getVersions();
			$currentVersion = $this->getCurrentSchemaVersion();
			foreach ($versions as $versionNumber => $version) {
				if (version_compare($this->getCurrentSchemaVersion(), $version['versionNumber']) < 0) {
					if ($version['type'] == self::MIGRATION_SCRIPT_TYPE_PHP) {
						$this->runPHPMigrationScript($version['filePath'], $version['versionNumber']);
					}
					else {
						$this->runSQLMigrationScript($version['filePath'], $version['versionNumber']);
					}
					$this->updateCurrentSchemaVersion($version['versionNumber'], $version['comment']);
				}
			}
			if ($hasStartedTransaction) {
				$this->getDriver()->commit();
			}
		}
		catch(Exception $e) {
			$this->getDriver()->rollBack();
			throw $e;
		}
	}
	
	protected function runPHPMigrationScript($scriptPath, $versionNumber) {
		$classesBeforeLoad = get_declared_classes();
		require_once $scriptPath;
		$versionNumberInClassName = str_replace('.', '_', $versionNumber);
		$diff = array_diff(get_declared_classes(), $classesBeforeLoad);
		foreach ($diff as $class) {
			$reflectionA = new ReflectionClass($class);
			if (strstr($class, $versionNumberInClassName) !== false && $reflectionA->implementsInterface('Customweb_Database_Migration_IScript')) {
				$object = new $class();
				if (!($object instanceof Customweb_Database_Migration_IScript)) {
					throw new Exception("Clould not cast to 'Customweb_Database_Migration_IScript'.");
				}
				$object->execute($this->getDriver());
				return;
			}
		}
		
		throw new Exception("Could not run script '" . $scriptPath . "', because either the script does not declare a class which implements Customweb_Database_Migration_IScript or the class name does not contain the version number.");
	}
	
	protected function runSQLMigrationScript($scriptPath, $versionNumber) {
		$sql = file_get_contents($scriptPath);
		$queries = preg_split("/;+(?=([^'|^\\\']*['|\\\'][^'|^\\\']*['|\\\'])*[^'|^\\\']*[^'|^\\\']$)/", $sql);
		foreach ($queries as $query){
			$query = trim($query);
			if (!empty($query)) {
				$this->getDriver()->query($query)->execute();
			}
		}
	}
	
	protected function getCurrentSchemaVersion() {
		try {
			$row = $this->getDriver()->query('SELECT version_number FROM ' . $this->getSchemaVersionTableName() . ' ORDER BY installed_on DESC, version_id DESC LIMIT 0,1')->fetch();
		}
		catch(Exception $e) {
			$this->createSchemaVersionTable();
			return '0';
		}
		
		if ($row === false) {
			return '0';
		}
		else {
			return $row['version_number'];
		}
	}
	
	protected function updateCurrentSchemaVersion($versionNumber, $comment) {
		$this->getDriver()->insert($this->getSchemaVersionTableName(), array(
			'>version_number' => $versionNumber,
			'>comment' => $comment,
		));
	}
	
	protected function createSchemaVersionTable() {
		$sql = "CREATE TABLE IF NOT EXISTS " . $this->getSchemaVersionTableName() . " (
			`version_id` int(10) NOT NULL AUTO_INCREMENT,
			`version_number` varchar(20) NOT NULL,
			`comment` varchar(255) default '',
			`installed_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (`version_id`),
			UNIQUE (`version_number`)
		) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
		
		$this->getDriver()->query($sql)->execute();
	}
	
	protected function getVersions() {
		if ($this->versions !== null) {
			return $this->versions;
		}
		
		if ($handle = opendir($this->getMigrationScriptFolder())) {
			$versions = array();
			while (false !== ($file = readdir($handle))) {
				if (strstr($file, '.php') !== false || strstr($file, '.sql')) {
					$fileNameWithoutExtension = substr($file, 0, strrpos($file, '.'));
					if (strstr($fileNameWithoutExtension, '__') !== false) {
						list($version, $comment) = explode('__', $fileNameWithoutExtension);
					}
					else {
						$version = $fileNameWithoutExtension;
						$comment = '';
					}
					if (strstr($file, '.php')) {
						$type = self::MIGRATION_SCRIPT_TYPE_PHP;
					}
					else {
						$type = self::MIGRATION_SCRIPT_TYPE_SQL;
					}
					
					$versions[$version] = array(
						'versionNumber' => $version,
						'comment' => $comment,
						'filePath' => $this->getMigrationScriptFolder() . $file,
						'type' => $type,
					);
				}
			}
			closedir($handle);
			
			uksort($versions, 'version_compare');
			$this->versions = $versions;
			return $this->versions;
		}
		else {
			throw new Exception("Failed to open migration dir: " . strip_tags($this->getMigrationScriptFolder()));
		}
		
	}
	
	/**
	 * @return string
	 */
	protected function getMigrationScriptFolder() {
		return $this->migrationScriptFolder;
	}
	
	/**
	 * @return Customweb_Database_IDriver
	 */
	protected function getDriver() {
		return $this->driver;
	}
	
	protected function getSchemaVersionTableName() {
		return $this->schemaVersionTableName;
	}
	
}