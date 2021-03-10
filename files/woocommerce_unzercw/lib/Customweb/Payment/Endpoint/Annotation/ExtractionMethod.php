<?php 
/**
  * You are allowed to use this API in your web application.
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

require_once 'Customweb/Payment/Endpoint/Annotation/ExtractionMethod.php';
require_once 'Customweb/IAnnotation.php';



/**
 * A method annotated with this annotation allows the extraction different ids from the 
 * request to load the transaction. 
 * 
 * The method has to return a array with a id identifer and the id it self.
 * 
 * e.g. array(
 * 	'id' => '123',
 *  'key' => Customweb_Payment_Endpoint_Annotation_ExtractionMethod::TRANSACTION_ID_KEY,
 * )
 * 
 * This annotation can only be applied once per controller.
 * 
 * @author Thomas Hunziker
 *
 */
class Customweb_Payment_Endpoint_Annotation_ExtractionMethod implements Customweb_IAnnotation{
	
	const TRANSACTION_ID_KEY = 'transactionId';
	
	const EXTERNAL_TRANSACTION_ID_KEY = 'externalTransactionId';
	
	const PAYMENT_ID_KEY = 'paymentId';
	
}