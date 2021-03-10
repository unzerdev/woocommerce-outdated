<?php

require_once 'Customweb/Database/Driver/MySQL/Statement.php';
require_once 'Customweb/Database/Driver/AbstractDriver.php';
require_once 'Customweb/Core/Assert.php';
require_once 'Customweb/Database/IDriver.php';


/**
 * This driver implementation allows the handling MySQL. The driver requires a valid
 * connection to the database.
 *
 * @author Thomas Hunziker
 *
 */
class Customweb_Database_Driver_MySQL_Driver extends Customweb_Database_Driver_AbstractDriver implements Customweb_Database_IDriver {
	private $link;
	private $supportsSavePoints = null;
	private $autoCommitActive = 0;

	/**
	 * The resource link is the connection link to the database.
	 *
	 * @param resource $resourceLink
	 */
	public function __construct($resourceLink){
		Customweb_Core_Assert::notNull($resourceLink);
		$this->link = $resourceLink;
	}

	public function beginTransaction(){
		if ($result = mysql_query("SELECT @@autocommit", $this->getLink())) {
			$row = mysql_fetch_row($result);
			$this->autoCommitActive = $row[0];
			mysql_free_result($result);
		}
		else{
			throw new Exception('Could not start DB transaction, as the autocommit state can not be read.');
		}
		mysql_query("SET autocommit = 0;", $this->getLink());
		mysql_query("START TRANSACTION;", $this->getLink());
		$this->setTransactionRunning(true);
	}

	public function commit(){
		mysql_query("COMMIT;", $this->getLink());
		mysql_query(sprintf("SET autocommit = %d;", $this->autoCommitActive), $this->getLink());
		$this->setTransactionRunning(false);
	}

	public function rollBack(){
		mysql_query("ROLLBACK;", $this->getLink());
		mysql_query(sprintf("SET autocommit = %d;", $this->autoCommitActive), $this->getLink());
		$this->setTransactionRunning(false);
	}

	public function query($query){
		$statement = new Customweb_Database_Driver_MySQL_Statement($query, $this);
		return $statement;
	}

	public function quote($string){
		if (function_exists('mysql_real_escape_string')) {
			$string = mysql_real_escape_string($string, $this->getLink());
		} elseif (function_exists('mysql_escape_string')) {
			$string = mysql_escape_string($string);
		}
		else {
			throw new Exception('Can not escape MYSQL string. mysql_real_escape_string and mysql_escape_string are not available.');
		}

		return '"' . $string . '"';
	}

	public function getLink(){
		return $this->link;
	}

	final protected function isServerSupportingSavePoints() {
		if ($this->supportsSavePoints === null) {
			$version = mysql_get_server_info($this->link);
			if (version_compare($version, '5.0.3') >= 0) {
				$this->supportsSavePoints = true;
			}
			else {
				$this->supportsSavePoints = false;
			}
		}
		return $this->supportsSavePoints;
	}

}
