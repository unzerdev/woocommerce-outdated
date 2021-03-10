<?php 

require_once 'Customweb/Database/Driver/AbstractStatement.php';


class Customweb_Database_Driver_MySQLi_Statement extends Customweb_Database_Driver_AbstractStatement {
	
	/**
	 * 
	 * @var result resource
	 */
	private $result;
	
	public function getInsertId() {
		$this->executeQuery();
		return mysqli_insert_id($this->getDriver()->getLink());
	}
	
	public function getRowCount() {
		$this->executeQuery();
		if ($this->result === false) {
			return 0;
		}
		else if($this->result === true) {
			return mysqli_affected_rows($this->getDriver()->getLink());
		}
		else {
			return mysqli_num_rows($this->result);
		}
	}
	
	public function fetch() {
		$this->executeQuery();
		$rs = mysqli_fetch_array($this->result, MYSQLI_ASSOC);
		if ($rs === null) {
			return false;
		}
		else {
			return $rs;
		}
	}
	
	final protected function executeQuery() {
		if (!$this->isQueryExecuted()) {
			$this->result = mysqli_query($this->getDriver()->getLink(), $this->prepareQuery());
				
			if ($this->result === false) {
				throw new Exception(mysqli_error($this->getDriver()->getLink()));
			}
			$this->setQueryExecuted();
		}
	}

	protected function getResult(){
		return $this->result;
	}
}