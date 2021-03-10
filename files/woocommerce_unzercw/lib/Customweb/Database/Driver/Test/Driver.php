<?php

require_once 'Customweb/Database/Driver/AbstractDriver.php';
require_once 'Customweb/Database/Driver/Test/Statement.php';
require_once 'Customweb/Database/IDriver.php';


/**
 * This driver can be used to test things. It logs every query executed and store the data in memory
 * to be retrived later.
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Database_Driver_Test_Driver extends Customweb_Database_Driver_AbstractDriver implements Customweb_Database_IDriver {


	public function beginTransaction(){}

	public function commit(){}

	public function rollBack(){}

	public function query($query){
		$statement = new Customweb_Database_Driver_Test_Statement($query, $this);
		return $statement;
	}

	public function quote($string){
		return '"' . addslashes($string) . '"';
	}


	public function getLink(){
		return $this->link;
	}
	
	
}
