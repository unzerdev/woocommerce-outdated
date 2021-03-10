<?php 


class Customweb_Database_Entity_SchemaGenerator {
	
	const CHARSET_NONE = 0x0001;
	const CHARSET_UTF8 = 0x0002;
	const CHARSET_LATIN1 = 0x0003;
	
	
	/**
	 * @var Customweb_Database_Entity_Meta_IEntity
	 */
	private $entity;
	
	/**
	 * @var boolean
	 */
	private $checkExistence = true;
	
	private $defaultCharset = self::CHARSET_UTF8;
	
	public function __construct(Customweb_Database_Entity_Meta_IEntity $entity) {
		$this->entity = $entity;
	}

	public function getDefaultCharset(){
		return $this->defaultCharset;
	}

	public function setDefaultCharset($defaultCharset){
		$this->defaultCharset = $defaultCharset;
		return $this;
	}

	public function isCheckExistenceActive(){
		return $this->checkExistence;
	}

	public function setCheckExistenceActive($checkExistence = true){
		$this->checkExistence = $checkExistence;
		return $this;
	}
	
	
	public function generate() {
		$sql = 'CREATE TABLE ';
		
		if ($this->isCheckExistenceActive()) {
			$sql .= 'IF NOT EXISTS ';
		}
		
		$sql .= $this->getEntity()->getTableName() . " (\n\t";
		$sql .= implode(",\n\t", $this->getColumnSqlArray());
		
		$indices = $this->getIndexSqlArray();
		if (count($indices) > 0) {
			$sql .= ",\n\t" . implode(",\n\t", $indices);
		}
		
		$primaryKeyColumn = $this->getEntity()->getPrimaryKeyColumnName();
		$sql .= ",\n\tPRIMARY KEY (" . $primaryKeyColumn . ")\n";
		
		$sql .= ')';
		
		if ($this->getDefaultCharset() === self::CHARSET_UTF8) {
			$sql .= ' DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci';
		}
		elseif ($this->getDefaultCharset() === self::CHARSET_LATIN1) {
			$sql .= ' DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci';
		}
		
		// We need always the InnoDB, because otherwise we can't use transactions
		$sql .= ' ENGINE=InnoDB ';
		
		return $sql;
	}
	
	protected function getColumnSqlArray() {
		$result = array();
		foreach ($this->getEntity()->getColumns() as $column) {
			$result[] = $this->generateColumnSQL($column);
		}
		
		return $result;
	}
	
	protected function getIndexSqlArray() {
		$result = array();
		foreach ($this->getEntity()->getIndices() as $index) {
			$result[] = $index->getIndexSchema();
		}
		
		return $result;
	}
	
	protected function generateColumnSQL(Customweb_Database_Entity_Meta_IColumn $column) {
		return $column->getColumnType()->getColumnSchema($column);
	}

	/**
	 * @return Customweb_Database_Entity_Meta_IEntity
	 */
	public function getEntity(){
		return $this->entity;
	}
	
	
	
}


