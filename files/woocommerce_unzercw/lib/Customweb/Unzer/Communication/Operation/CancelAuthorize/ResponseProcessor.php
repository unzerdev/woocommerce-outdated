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

require_once 'Customweb/Unzer/Communication/Operation/AbstractCancelProcessor.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Payment/Authorization/DefaultTransactionHistoryItem.php';


/**
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Communication_Operation_CancelAuthorize_ResponseProcessor extends Customweb_Unzer_Communication_Operation_AbstractCancelProcessor {

	protected function processCancel(){
		if (!$this->transaction->isCaptured()) {
			parent::processCancel();
		}
		else {
			$this->processPartialCancel();
		}
	}

	/**
	 * Partial cancels are not supported by sellxed by default, add custom history item and add to processed ids.
	 */
	protected function processPartialCancel(){
		if ($this->data['isSuccess']) {
			$this->transaction->addProcessed($this->data['id']);
			$this->transaction->addHistoryItem(
					new Customweb_Payment_Authorization_DefaultTransactionHistoryItem(
							Customweb_I18n_Translation::__("Processed partial cancel on authorize for amount @amount with id @id.",
									array(
										'@amount' => $this->data['amount'],
										'@id' => $this->data['id']
									)), Customweb_Payment_Authorization_DefaultTransactionHistoryItem::ACTION_CANCELLATION));
		}
		else {
			$this->getLogger()->logDebug("Skipping processing partial cancel.", $this->data);
		}
	}

	protected function getValidResponseCodes(){
		return array(
			200,
			201
		);
	}
}