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
require_once 'Customweb/Payment/Document/IDocument.php';

/**
 * Default implementation of a document.
 *
 * @author Nico Eigenmann
 *
 */
class Customweb_Payment_Document_Document implements Customweb_Payment_Document_IDocument{

	private $identifier;
	private $name;
	private $fileExtension;
	private $fileData;
	
	
	public function __construct(Customweb_Payment_Document_IDocumentIdentifier $identifier, Customweb_I18n_ILocalizableString $name, $fileExtension, $fileData){
		$this->identifier = $identifier;
		$this->name = $name;
		$this->fileExtension = $fileExtension;
		$this->fileData = $fileData;
		
	}
		
	public function getName(){
		return $this->name;
	}

	public function getFileExtension(){
		return $this->fileExtension;
	}
	
	
	public function getIdentifier(){
		return $this->identifier;
	}
	
	
	public function getFileData(){
		return $this->fileData;	
	}
		
}