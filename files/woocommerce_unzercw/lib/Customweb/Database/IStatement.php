<?php



interface Customweb_Database_IStatement {

	/**
	 * Returns the last insert of the statement.
	 * 
	 * @return int
	 */
	public function getInsertId();

	/**
	 * Sets a parameter of the statement.
	 * 
	 * @param string $name
	 * @param string $value
	 * @return Customweb_Database_IStatement
	 */
	public function setParameter($name, $value);

	/**
	 * Returns the list of parameters set on the statement.
	 * 
	 * @return array
	 */
	public function getParameters();

	/**
	 * Sets a list of parameters replaced in the query.
	 * 
	 * @param array $parameters
	 * @return Customweb_Database_IStatement
	 */
	public function setParameters(array $parameters);

	/**
	 * Returns the number of rows of the query.
	 *
	 * @return int
	 */
	public function getRowCount();

	/**
	 * Fetch the result. The method returns the next row. In case no more
	 * rows are present in the result set the method returns FALSE.
	 *
	 * @return array
	 */
	public function fetch();

	/**
	 * Runs the query again with the given input parameters.
	 *
	 * @param array $parameters
	 * @throws Exception In case the execution failed this method throws an exception
	 * @return void
	 */
	public function execute(array $parameters = null);

}