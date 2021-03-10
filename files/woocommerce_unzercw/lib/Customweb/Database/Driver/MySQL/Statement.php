<?php 

require_once 'Customweb/Database/Driver/AbstractStatement.php';


class Customweb_Database_Driver_MySQL_Statement extends Customweb_Database_Driver_AbstractStatement {
	
	/**
	 * 
	 * @var result resource
	 */
	private $result;
	
	public function getInsertId() {
		$this->executeQuery();
		return mysql_insert_id($this->getDriver()->getLink());
	}
	
	public function getRowCount() {
		$this->executeQuery();
		if ($this->result === false) {
			return 0;
		}
		else if($this->result === true) {
			return mysql_affected_rows($this->getDriver()->getLink());
		}
		else {
			return mysql_num_rows($this->result);
		}
	}
	
	public function fetch() {
		$this->executeQuery();
		$rs = mysql_fetch_array($this->result, MYSQL_ASSOC);
		if ($rs === null) {
			return false;
		}
		else {
			return $rs;
		}
	}
	
	final protected function executeQuery() {
		if (!$this->isQueryExecuted()) {
			$this->result = mysql_query($this->prepareQuery(), $this->getDriver()->getLink());
				
			if ($this->result === false) {
				throw new Exception(mysql_error($this->getDriver()->getLink()));
			}
			$this->setQueryExecuted();
		}
	}

	protected function getResult(){
		return $this->result;
	}
}