<?php 

require_once 'Customweb/Database/Entity/Meta/IFilter.php';


class Customweb_Database_Entity_Meta_Filter implements Customweb_Database_Entity_Meta_IFilter {
	
	private $name;
	
	private $where;
	
	private $orderBy;

	public function getName(){
		return $this->name;
	}

	public function setName($name){
		$this->name = $name;
		return $this;
	}

	public function getWhere(){
		return $this->where;
	}

	public function setWhere($where){
		$this->where = $where;
		return $this;
	}

	public function getOrderBy(){
		return $this->orderBy;
	}

	public function setOrderBy($orderBy){
		$this->orderBy = $orderBy;
		return $this;
	}
	
	
	
}