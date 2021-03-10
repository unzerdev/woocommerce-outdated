<?php

require_once 'Customweb/Database/Driver/PDO/Statement.php';
require_once 'Customweb/Database/Driver/AbstractDriver.php';
require_once 'Customweb/Database/IDriver.php';


class Customweb_Database_Driver_PDO_Driver extends Customweb_Database_Driver_AbstractDriver 
implements Customweb_Database_IDriver {

	/**
	 * @var PDO
	 */
	private $pdo;
	
	public function __construct(PDO $pdo) {
		$this->pdo = $pdo;
	}
	
	public function beginTransaction() {
		$this->setTransactionRunning(true);
		$this->pdo->beginTransaction();
	}
	
	public function isTransactionRunning() {
		if (method_exists($this->pdo, 'inTransaction')) {
			return $this->pdo->inTransaction();
		}
		else {
			return parent::isTransactionRunning();
		}
	}

	public function commit() {
		$this->pdo->commit();
		$this->setTransactionRunning(false);
	}

	public function rollBack() {
		$this->pdo->rollBack();
		$this->setTransactionRunning(false);
	}

	public function query($query) {
		return new Customweb_Database_Driver_PDO_Statement($query, $this);
	}

	public function quote($string) {
		return $this->pdo->quote($string);
	}

	public function getPdo() {
		return $this->pdo;
	}
	
}