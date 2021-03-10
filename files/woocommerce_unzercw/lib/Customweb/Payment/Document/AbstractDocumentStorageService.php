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

require_once 'Customweb/Payment/Entity/AbstractDocument.php';
require_once 'Customweb/Payment/Document/Document.php';
require_once 'Customweb/Core/Stream/Input/File.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Core/Stream/Output/File.php';
require_once 'Customweb/Payment/Document/IDocumentStorageService.php';



/**
 * Abstract implementaion of storage service.
 *
 * @author Nico Eigenmann
 *
 */
abstract class Customweb_Payment_Document_AbstractDocumentStorageService implements Customweb_Payment_Document_IDocumentStorageService {
	
	/**
	 *
	 * @var Customweb_Database_Entity_IManager
	 */
	private $entityManager;
	
	/**
	 *
	 * @var Customweb_DependencyInjection_IContainer
	 */
	private $container;

	public function __construct(Customweb_DependencyInjection_IContainer $container){
		$this->container = $container;
		$this->entityManager = $container->getBean('Customweb_Database_Entity_IManager');
	}

	protected function getContainer(){
		return $this->container;
	}

	protected function getEntityManager(){
		return $this->entityManager;
	}
	
	/**
	 * This function returns the classname of the entity extending the Customweb_Payment_Entity_AbstractDocument
	 * @return string
	 */
	abstract protected function getDocumentEntityClassName();

	/**
	 * This methods returns the full path to the folder where the documents wil be stored.
	 *
	 * @return string
	 */
	abstract protected function getBaseFolderPath();

	/**
	 * This function gets the entity for the document.

	 * @param Customweb_Payment_Document_IDocument $document
	 * @return Customweb_Payment_Entity_AbstractDocument
	 */
	protected function getDocumentEntity(Customweb_Payment_Document_IDocumentIdentifier $identififer){
		$documentEntities = $this->getEntityManager()->searchByFilterName($this->getDocumentEntityClassName(), 'loadByTransactionIdAndMachineName',
				array(
					'>transactionId' => $identififer->getTransactionId(),
					'>machineName' => $identififer->getMachineName()
				));
		$entity = null;
		if(!empty($documentEntities)){
			$entity = current($documentEntities);
		}
		return $entity;
	}

	public function store(Customweb_Payment_Document_IDocument $document){
		$entityDocument = $this->getDocumentEntity($document->getIdentifier());
		if($entityDocument === null){
			$className = $this->getDocumentEntityClassName();
			$entityDocument = new $className();
			if(!($entityDocument instanceof Customweb_Payment_Entity_AbstractDocument)){
					throw new Exception("Document must be of type Customweb_Payment_Entity_AbstractDocument");
			}
			$entityDocument->setIdentifier($document->getIdentifier());
			$entityDocument->setFileExtension($document->getFileExtension());
			$entityDocument->setName($document->getName());
			$entityDocument = $this->getEntityManager()->persist($entityDocument);
		}
		else{
			$entityDocument->setFileExtension($document->getFileExtension());
			$entityDocument->setName($document->getName());
			$entityDocument = $this->getEntityManager()->persist($entityDocument);
			
		}
		
		$this->checkBaseFolderExistsOrCreate();
		$outputStream = new Customweb_Core_Stream_Output_File(
				$this->getBaseFolderPathCleaned() . $entityDocument->getDocumentId() .'.'. $entityDocument->getFileExtension());
		$outputStream->write($document->getFileData());
	}
	
	

	public function retrieve(Customweb_Payment_Document_IDocumentIdentifier $identifier){
		$entityDocument = $this->getDocumentEntity($identifier);
		if ($entityDocument === null) {
			throw new Exception(Customweb_I18n_Translation::__('The document could not be found.'));
		}
		$this->checkBaseFolderExistsOrCreate();
		$filePath = $this->getBaseFolderPathCleaned() . $entityDocument->getDocumentId() .'.'. $entityDocument->getFileExtension();
		if (!file_exists($filePath)) {
			throw new Exception(Customweb_I18n_Translation::__('The file was deleted from the filesystem'));
		}
		$inputStream = new Customweb_Core_Stream_Input_File($filePath);
		$fileData = $inputStream->read();
		return new Customweb_Payment_Document_Document($identifier, $entityDocument->getName(), $entityDocument->getFileExtension(), $fileData);
	}

	public function remove(Customweb_Payment_Document_IDocumentIdentifier $identifier){
		$entityDocument = $this->getDocumentEntity($identifier);
		if ($entityDocument === null) {
			//no file stored nothing to delete
			return;
		}
		$this->checkBaseFolderExistsOrCreate();
		$filePath = $this->getBaseFolderPathCleaned() . $entityDocument->getDocumentId() .'.'. $entityDocument->getFileExtension();
		if (file_exists($filePath)) {
			unlink($filePath);
		}
		$this->getEntityManager()->remove($entityDocument);
	}

	private function checkBaseFolderExistsOrCreate(){
		if (!file_exists($this->getBaseFolderPathCleaned())) {
			mkdir($this->$this->getBaseFolderPathCleaned(), 0777, true);
		}
	}

	private function getBaseFolderPathCleaned(){
		$path = $this->getBaseFolderPath();
		if (substr($path, -1) != '/') {
			$path = $path . '/';
		}
		return $path;
	}
}
	