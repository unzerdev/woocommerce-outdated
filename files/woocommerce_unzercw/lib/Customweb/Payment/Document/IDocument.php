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
 * Defines a document object.
 * The transactionID and the machineName identify a document.
 *
 * @author Nico Eigenmann
 *
 */
interface Customweb_Payment_Document_IDocument {

	/**
	 * Returns the identifier for this Document 
	 *
	 * @return Customweb_Payment_Document_IDocumentIdentifier
	 */
	public function getIdentifier();

	/**
	 * Returns the name of the Document.
	 * This name will be shown to the merchant. Keep this clipped and precise, e.g. "Invoice", "Delivery Note" as this can mess with the shop layout
	 * otherwise
	 *
	 * @return Customweb_I18n_ILocalizableString Name of the document
	 */
	public function getName();

	/**
	 * Returns the file extension of this document. Without the leading dot
	 * @return string the file extension
	 */
	public function getFileExtension();
	
	
	/**
	 * Returns the actual data for this document
	 */
	public function getFileData();
	
		
}