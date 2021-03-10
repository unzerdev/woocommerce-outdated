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

/**
 * This interface defines a file storage service. 
 * The service provides method to store data to the filesystem
 *
 *
 * <p>
 * This interface is implemented by the shop system. The 
 * implementation must be added to the container.
 *
 * @author Nico Eigenmann
 *
 */
interface Customweb_Payment_Document_IDocumentStorageService {
	
	/**
	 * This function stores the document. If there is alreasy a document with the same identifier available, 
	 * it will be overwritten, with the new one
	 * 
	 * @param Customweb_Payment_Document_IDocument $document
	 */
	public function store(Customweb_Payment_Document_IDocument $document);
	
	
	/**
	 * This function returns the document for this identifier
	 * This function throws an expetion if no document is found, or its filedata got deleted
	 * 
	 * @param Customweb_Payment_Document_IDocumentIdentifier $documentIdentifier
	 * @return Customweb_Payment_Document_IDocument
	 * @throws Exception
	 */
	public function retrieve(Customweb_Payment_Document_IDocumentIdentifier $documentIdentifier);
	
	/**
	 * This function removes the stored data for this documentidentifier
	 * 
	 * @param Customweb_Payment_Document_IDocumentIdentifier $documentIdentifier
	 */
	public function remove(Customweb_Payment_Document_IDocumentIdentifier $documentIdentifier);
	
	
}