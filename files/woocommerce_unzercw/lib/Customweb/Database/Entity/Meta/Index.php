<?php 

require_once 'Customweb/Database/Entity/Meta/IIndex.php';



class Customweb_Database_Entity_Meta_Index implements Customweb_Database_Entity_Meta_IIndex{
	
	/**
	 * @var string
	 */
	private $name;
	
	/**
	 * @var array
	 */
	private $columnNames = array();
	
	/**
	 * @var boolean
	 */
	private $unique = false;

	public function getName(){
		return $this->name;
	}

	public function setName($name){
		$this->name = $name;
		return $this;
	}

	public function getColumnNames(){
		return $this->columnNames;
	}

	public function setColumnNames(array $names){
		$this->columnNames = $names;
		return $this;
	}

	public function isUnique(){
		return $this->unique;
	}

	public function setUnique($unique){
		$this->unique = $unique;
		return $this;
	}
	
	public function getIndexSchema() {
		$sql = '';
		if ($this->isUnique()) {
			$sql .= 'UNIQUE ';
		}
		$sql .= 'KEY ' . $this->getName() . ' (' . implode(',', $this->getColumnNames()) . ')';
		return $sql;
	}
	
	
}