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

require_once 'Customweb/Util/Currency.php';
require_once 'Customweb/Unzer/Communication/Operation/Authorize/RequestBuilder.php';


/**
 * Used for backend operation capture requests.
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Communication_Operation_Charge_RequestBuilder extends Customweb_Unzer_Communication_Operation_Authorize_RequestBuilder {
	private $amount;
	
	public function __construct($amount, Customweb_Unzer_Authorization_Transaction $transaction, Customweb_DependencyInjection_IContainer $container){ 
		parent::__construct($transaction, $container);
		$this->amount = $amount;
	}
	
	protected function getPayload(){
		return array(
			'amount' => Customweb_Util_Currency::formatAmount($this->amount, $this->getTransaction()->getCurrencyCode(), '.')
		);
	}
		
	protected function getUrlPath(){
		return str_replace("{authorizationId}", $this->getTransaction()->getUnzPaymentId(), "payments/{authorizationId}/charges");
	}
}