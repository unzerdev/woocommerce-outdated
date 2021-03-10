<?php 




interface Customweb_Database_Entity_Meta_IIndex {
	
	public function getName();
	
	public function getColumnNames();
	
	public function isUnique();
	
	public function getIndexSchema();
	
}