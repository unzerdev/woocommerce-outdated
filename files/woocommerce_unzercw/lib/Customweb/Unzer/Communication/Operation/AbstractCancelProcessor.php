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

require_once 'Customweb/Unzer/Communication/AbstractTransactionProcessor.php';
require_once 'Customweb/Payment/Authorization/ITransactionHistoryItem.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Payment/Authorization/ITransactionCancel.php';
require_once 'Customweb/Payment/Authorization/DefaultTransactionHistoryItem.php';


/**
 * Cancel processor
 *
 * @author Sebastian Bossert
 */
abstract class Customweb_Unzer_Communication_Operation_AbstractCancelProcessor extends Customweb_Unzer_Communication_AbstractTransactionProcessor {
	private $doCancel;

	public function __construct(Customweb_Unzer_Authorization_Transaction $transaction, Customweb_DependencyInjection_IContainer $container, $doCancel = true){
		parent::__construct($transaction, $container);
		$this->doCancel = $doCancel;
	}

	public function process(Customweb_Core_Http_IResponse $response){
		$result = parent::process($response);
		$this->processCancel();
		return $result;
	}

	protected function processCancel(){
		if ($this->doCancel) {
			$this->createCancel();
		}
		else {
			$this->transaction->addProcessed($this->data['id']);
			$this->transaction->addHistoryItem(
					new Customweb_Payment_Authorization_DefaultTransactionHistoryItem(
							Customweb_I18n_Translation::__("Cancelled @amount using id @id.",
									array(
										'@amount' => $this->data['amount'],
										'@id' => $this->data['id']
									)), Customweb_Payment_Authorization_ITransactionHistoryItem::ACTION_LOG));
		}
	}

	protected function createCancel(){
		/**
		 *
		 * @var Customweb_Unzer_Authorization_Cancel $cancel
		 */
		$cancel = $this->transaction->cancel();
		$cancel->setCancelId($this->data['id']);
		$this->transaction->addProcessed($this->data['id']);
		if ($this->data['isSuccess']) {
			$cancel->setStatus(Customweb_Payment_Authorization_ITransactionCancel::STATUS_SUCCEED);
		}
		else if ($this->data['isPending']) {
			$cancel->setStatus(Customweb_Payment_Authorization_ITransactionCancel::STATUS_PENDING);
		}
	}
}