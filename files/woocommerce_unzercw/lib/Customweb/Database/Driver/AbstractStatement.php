<?php

require_once 'Customweb/Database/IStatement.php';


abstract class Customweb_Database_Driver_AbstractStatement implements Customweb_Database_IStatement {
	private $parameters = array();

	private $driver = null;

	private $query;

	private $executed = false;

	public function __construct($query, Customweb_Database_IDriver $driver) {
		if (empty($query)) {
			throw new InvalidArgumentException("Parameter query can not be empty.");
		}
		$this->driver = $driver;
		$this->query = $query;
	}

	public function setParameter($name, $value){
		$this->parameters[$name] = $value;
		return $this;
	}

	public function getParameters(){
		return $this->parameters;
	}

	public function setParameters(array $parameters){
		$this->parameters = $parameters;
		return $this;
	}

	protected function prepareQuery() {
		return $this->replaceQueryWithParameters($this->getQuery(), $this->getParameters());
	}

	final protected function replaceQueryWithParameters($query, $parameters){

		$parameters = $this->executeTypeCast($parameters);
		$parameters = $this->escapeParameters($parameters);
		$keys = array_keys($parameters);
		$values = array_values($parameters);

		return str_replace($keys, $values, $query);
	}

	protected function escapeParameters($parameters) {
		foreach($parameters as $key => $value) {
			$firstChar = substr($key, 0, 1);
			if ($firstChar == '>' || $firstChar == '?') {
				$parameters[$key] = $this->getDriver()->quote($value);
			}
		}

		return $parameters;
	}

	/**
	 * This method converts the given parameters to the type indicated by the first letter of the key name.
	 *
	 * Types:
	 * - >test -> converts the value to a string
	 * - !test -> converts the value to an integer
	 * - :test -> converts the value to a float / decimal
	 * - ?test -> Expects that the value is DateTime and converts it to a date field
	 *
	 * @param array $parameters
	 */
	protected function executeTypeCast($parameters){
		$result = array();

		foreach ($parameters as $key => $value) {
			$firstChar = substr($key, 0, 1);
			switch ($firstChar) {
				case '>':
					$result[$key] = (string) $value;
					break;
				case '!':
					$result[$key] = intval($value);
					break;
				case ':':
					$result[$key] = floatval($value);
					break;
				case '?':
					$format = 'Y-m-d H:i:s';
					if (is_object($value) && $value instanceof DateTime) {
						$result[$key] = $value->format($format);
					} else if (is_string($value)) {
						$phpdate = strtotime(value);
						$result[$key] = date($format, $phpdate);
					}
					else if (is_int($value)) {
						$result[$key] = date($format, $value);
					}
					else {
						throw new Exception("The parameter with key '" + $key + "' could not be convert to a database type.");
					}
					break;

			}
		}

		return $result;
	}

	public function execute(array $parameters = null) {
		if ($parameters !== null) {
			$this->setParameters($parameters);
		}
		$this->queryExecuted = false;
		$this->executeQuery();
	}

	public function getDriver(){
		return $this->driver;
	}

	protected function getQuery(){
		return $this->query;
	}

	protected function isQueryExecuted() {
		return $this->executed;
	}

	protected function setQueryExecuted($executed = true) {
		$this->executed = $executed;
		return $this;
	}

	abstract protected function executeQuery();
}