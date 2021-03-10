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
require_once 'Customweb/Payment/Authorization/ErrorMessage.php';
require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Unzer/Util/Message.php';


/**
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Communication_Metadata_ResponseProcessor extends Customweb_Unzer_Communication_AbstractTransactionProcessor {

	public function process(Customweb_Core_Http_IResponse $response){
		try {
			parent::process($response);
			$this->transaction->setUnzMetadataId($this->data['id']);
		}
		catch (Customweb_Unzer_Communication_Exception $commExc) {
			$this->transaction->addErrorMessage(
					Customweb_Unzer_Util_Message::prependToError($this->getFailedMessage(), $commExc->getErrorMessage()));
		}
		catch (Exception $e) {
			$this->transaction->addErrorMessage(
					new Customweb_Payment_Authorization_ErrorMessage(
							Customweb_I18n_Translation::__("@prepend: @error",
									array(
										'@prepend' => $this->getFailedMessage(),
										'@error' => $e->getMessage()
									))));
			$this->getLogger()->logException($e);
		}
	}

	private function getFailedMessage(){
		return Customweb_I18n_Translation::__("Processing metadata failed");
	}

	protected function getValidResponseCodes(){
		return array(
			201
		);
	}
}