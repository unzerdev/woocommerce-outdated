<?php 

require_once 'Customweb/Database/Driver/AbstractStatement.php';
require_once 'Customweb/Database/Driver/Test/Parser/PHPSQLParser.php';



class Customweb_Database_Driver_Test_Statement extends Customweb_Database_Driver_AbstractStatement {
	
	const SELECT_WORD = 'SELECT';
	const INSERT_WORD = 'INSERT';
	const UPDATE_WORD = 'UPDATE';
	
	private $queryExecuted = false;
	
	private static $storage = array();
	
	private $insertId = 0;
	
	private $rowCount = 0;
	
	private $resultSet = array();
	
	public function getInsertId() {
		$this->executeQuery();
		return $this->insertId;
	}
	
	public function getRowCount() {
		$this->executeQuery();
		return $this->rowCount;
	}
	
	public function fetch() {
		$this->executeQuery();
		$rs = current($this->resultSet);
		next($this->resultSet);
		
		if (is_array($rs)) {
			return $rs;
		}
		else {
			return null;
		}
	}
	
	final protected function executeQuery() {
		if (!$this->isQueryExecuted()) {
			
			$query = $this->prepareQuery();
			$sqlParser = new Customweb_Database_Driver_Test_Parser_PHPSQLParser();
			$parsedQuery = $sqlParser->parse($query);
			
			if (isset($sqlParser->parsed[self::SELECT_WORD])) {
				$this->processSelectQuery($parsedQuery);
			}
			else if (isset($sqlParser->parsed[self::UPDATE_WORD])) {
				$this->processUpdateQuery($parsedQuery);
			}
			else if (isset($sqlParser->parsed[self::INSERT_WORD])) {
				$this->processInsertQuery($parsedQuery);
			}
			//echo $query;
			//echo "\n";
			
			$this->setQueryExecuted();
		}
	}
	
	protected function processSelectQuery($parsedQuery) {
		
		// TODO: How to handle Joins and selects over multiple tables
		$tableName = $parsedQuery['FROM'][0]['table'];
		
// 		$columns = array();
// 		foreach ($parsedQuery[self::SELECT_WORD] as $column) {
// 			$columns[$column['base_expr']] = $column['base_expr'];
// 		}
		
		// Evaluate WHERE 
		// TODO: Add more support and not only selects on primary id
		if (isset($parsedQuery['WHERE'])) {
			$primaryId = null;
			foreach ($parsedQuery['WHERE'] as $exp) {
				if ($exp['expr_type'] == 'const') {
					$primaryId = $exp['base_expr'];
				}
			}
			if (isset(self::$storage[$tableName][$primaryId])) {
				$this->resultSet[] = self::$storage[$tableName][$primaryId];
			}
			else {
				$this->resultSet = array();
			}
			
		}
		else {
			$this->resultSet = self::$storage[$tableName];
		}
	}
	
	protected function processInsertQuery($parsedQuery) {
		$tableName = $parsedQuery[self::INSERT_WORD]['table'];
		
		if (!isset(self::$storage[$tableName])) {
			self::$storage[$tableName] = array();
		}
		
		end(self::$storage[$tableName]);
		$lastInsertId = key(self::$storage[$tableName]);
		
		if ($lastInsertId === null) {
			$lastInsertId = 0;
		}
		$primaryKey = $lastInsertId + 1;
		
		$values = array();
		if (isset($parsedQuery['SET'])) {
			foreach ($parsedQuery['SET'] as $set) {
				$columName = $set['sub_tree'][0]['base_expr'];
				$value = trim($set['sub_tree'][2]['base_expr'], '\'"');
				$values[$columName] = $value;
			}
		}
		
		// TODO: Handle Case when 'VALUES' syntax was used.
		
		self::$storage[$tableName][$primaryKey] = $values;
		$this->insertId = $primaryKey;
	}
	
	protected function processUpdateQuery($parsedQuery) {
		
	}

}