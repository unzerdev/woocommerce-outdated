<?php 

require_once 'Customweb/Database/Util.php';
require_once 'Customweb/Database/IDriver.php';


abstract class Customweb_Database_Driver_AbstractDriver implements Customweb_Database_IDriver {
	
	private $transactionRunning = false;
	
	public function isTransactionRunning() {
		return $this->transactionRunning;
	}
	
	protected function setTransactionRunning($running) {
		if ($running) {
			$this->transactionRunning = true;
		}
		else {
			$this->transactionRunning = false;
		}
	}
	
	public function insert($tableName, $data){
		$sql = 'INSERT INTO ' . $tableName . ' SET ';
		$sql .= implode(',', $this->getDataPairs($data));
		$statement = $this->query($sql);
		$statement->setParameters($data);
		return $statement->getInsertId();
	}
	
	
	public function update($tableName, $data, $whereClause){
		$sql = 'UPDATE ' . $tableName . ' SET ';
		$sql .= implode(',', $this->getDataPairs($data));
		$sql .= $this->getWhereClause($whereClause);
		$statement = $this->query($sql);
		if (is_array($whereClause)) {
			$statement->setParameters(array_merge($data, $whereClause));
		}
		else {
			$statement->setParameters($data);
		}
		return $statement->getRowCount();
	}
	
	public function remove($tableName, $whereClause){
		$sql = 'DELETE FROM ' . $tableName . ' ';
		$sql .= $this->getWhereClause($whereClause);
		$statement = $this->query($sql);
		if (is_array($whereClause)) {
			$statement->setParameters($whereClause);
		}
		return $statement->getRowCount();
	}
	

	protected function getDataPairs($data) {
		return Customweb_Database_Util::getDataPairs($data);
	}
	
	protected function getWhereClause($whereClause) {
		return Customweb_Database_Util::getWhereClause($whereClause);
	}
	
}