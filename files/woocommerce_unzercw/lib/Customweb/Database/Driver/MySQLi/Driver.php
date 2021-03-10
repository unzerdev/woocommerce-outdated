<?php

require_once 'Customweb/Database/Driver/AbstractDriver.php';
require_once 'Customweb/Database/Driver/MySQLi/Statement.php';
require_once 'Customweb/Database/IDriver.php';


/**
 * This driver implementation allows the handling MySQLi. The driver requires a valid
 * connection to the database.
 *
 * @author Thomas Hunziker
 *
 */
class Customweb_Database_Driver_MySQLi_Driver extends Customweb_Database_Driver_AbstractDriver implements Customweb_Database_IDriver {
	
	private $link;
	private $autoCommitActive = false;

	/**
	 * The resource link is the connection link to the database.
	 *
	 * @param resource $resourceLink
	 */
	public function __construct($resourceLink){
		$this->link = $resourceLink;
	}

	public function beginTransaction(){
		
		if(version_compare(PHP_VERSION, '5.5') < 0){
			if ($result = $this->link->query("SELECT @@autocommit")) {
				$row = $result->fetch_row();
				$this->autoCommitActive = $row[0];
				$result->free();
			}
			else{
				throw new Exception('Could not start DB transaction, as the autocommit state can not be read.');
			}
			$this->link->autocommit(false);
		}
		else{
			$this->link->begin_transaction();
		}
		
		$this->setTransactionRunning(true);
	}

	public function commit(){
		$this->link->commit();
		if(version_compare(PHP_VERSION, '5.5') < 0){
			$this->link->autocommit($this->autoCommitActive);
		}
		$this->setTransactionRunning(false);
	}

	public function rollBack(){
		$this->link->rollback();
		if(version_compare(PHP_VERSION, '5.5') < 0){
			$this->link->autocommit($this->autoCommitActive);
		}
		$this->setTransactionRunning(false);
	}

	public function query($query){
		$statement = new Customweb_Database_Driver_MySQLi_Statement($query, $this);
		return $statement;
	}

	public function quote($string){
		if (function_exists('mysqli_real_escape_string')) {
			$string = mysqli_real_escape_string($this->getLink(), $string);
		} elseif (function_exists('mysqli_escape_string')) {
			$string = mysqli_escape_string($string);
		}
		else {
			throw new Exception('Can not escape MYSQL string. mysqli_real_escape_string and mysqli_escape_string are not avaialable.');
		}

		return '"' . $string . '"';
	}

	public function getLink(){
		return $this->link;
	}


	final protected function isServerSupportingSavePoints() {
		if ($this->supportsSavePoints === null) {
			$version = mysqli_get_server_info($this->link);
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
