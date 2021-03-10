<?php

/**
 *  * You are allowed to use this API in your web application.
 *
 * Copyright (C) 2018 by customweb GmbH
 *
 * This program is licenced under the customweb software licence. With the
 * purchase or the installation of the software in your application you
 * accept the licence agreement. The allowed usage is outlined in the
 * customweb software licence which can be found under
 * http://www.sellxed.com/en/software-license-agreement
 *
 * Any modification or distribution is strictly forbidden. The license
 * grants you the installation in one application. For multiuse you will need
 * to purchase further licences at http://www.sellxed.com/shop.
 *
 * See the customweb software licence agreement for more details.
 *
 */

require_once 'Customweb/Payment/Document/DocumentIdentifier.php';



/**
 * @Index(columnNames = {'transactionId'})
 *
 * @Filter(name = 'loadByTransactionId', where = 'transactionId = >transactionId', orderBy = 'documentId')
 * @Filter(name = 'loadByTransactionIdAndMachineName', where = 'transactionId LIKE >transactionId AND machineName LIKE >machineName', orderBy = 'documentId')
 */
abstract class Customweb_Payment_Entity_AbstractDocument {
	private $documentId;
	private $transactionId;
	private $name;
	private $machineName;
	private $fileExtension;
	private $updateOn;
	private $createdOn;
	private $versionNumber;

	/**
	 * @PrimaryKey
	 */
	public function getDocumentId(){
		return $this->documentId;
	}

	public function setDocumentId($documentId){
		$this->documentId = $documentId;
		return $this;
	}

	/**
	 * @Column(type = 'integer')
	 */
	public function getTransactionId(){
		return $this->transactionId;
	}

	public function setTransactionId($transactionId){
		$this->transactionId = $transactionId;
		return $this;
	}

	/**
	 * @Column(type = 'varchar', size = '100')
	 */
	public function getMachineName(){
		return $this->machineName;
	}

	public function setMachineName($machineName){
		$this->machineName = $machineName;
		return $this;
	}

	/**
	 * @Column(type = 'object')
	 */
	public function getName(){
		return $this->name;
	}

	public function setName($name){
		$this->name = $name;
		return $this;
	}

	/**
	 * @Column(type = 'varchar')
	 */
	public function getFileExtension(){
		return $this->fileExtension;
	}

	public function setFileExtension($fileExtension){
		$this->fileExtension = $fileExtension;
		return $this;
	}

	/**
	 * @Column(type = 'datetime')
	 *
	 * @return DateTime
	 */
	public function getUpdatedOn(){
		return $this->updatedOn;
	}

	public function setUpdatedOn($updatedOn){
		$this->updatedOn = $updatedOn;
		return $this;
	}

	/**
	 * @Column(type = 'datetime')
	 *
	 * @return DateTime
	 */
	public function getCreatedOn(){
		return $this->createdOn;
	}

	public function setCreatedOn($createdOn){
		$this->createdOn = $createdOn;
		return $this;
	}

	/**
	 * @Version
	 */
	public function getVersionNumber(){
		return $this->versionNumber;
	}

	public function setVersionNumber($version){
		$this->versionNumber = $version;
		return $this;
	}

	/**
	 * Set CreatedOn and updatedOn
	 *
	 * @param Customweb_Database_Entity_IManager $entityManager
	 */
	public function onBeforeSave(Customweb_Database_Entity_IManager $entityManager){
		if ($this->getDocumentId() === null) {
			$this->setCreatedOn(new DateTime());
		}
		$this->setUpdatedOn(new DateTime());
	}

	public function setIdentifier(Customweb_Payment_Document_IDocumentIdentifier $identifier){
		$this->setMachineName($identifier->getMachineName());
		$this->setTransactionId($identifier->getTransactionId());
	}

	public function getIdentifier(){
		return new Customweb_Payment_Document_DocumentIdentifier($this->getTransactionId(), $this->getMachineName());
	}
}