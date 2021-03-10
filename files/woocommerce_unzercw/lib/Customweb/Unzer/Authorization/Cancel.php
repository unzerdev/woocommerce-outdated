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

require_once 'Customweb/I18n/Translation.php';
require_once 'Customweb/Payment/Authorization/DefaultTransactionCancel.php';


/**
 *
 * @author Sebastian Bossert
 */
class Customweb_Unzer_Authorization_Cancel extends Customweb_Payment_Authorization_DefaultTransactionCancel {
	protected $unzCancelId = null;

	/**
	 *
	 * @return mixed
	 */
	public function getUnzCancelId(){
		return $this->unzCancelId;
	}

	/**
	 *
	 * @param mixed $cancelAuthorizeId
	 */
	public function setUnzCancelID($unzCancelId){
		$this->unzCancelId = $unzCancelId;
	}

	protected function getTransactionSpecificLables(){
		return array(
			'unzid' => array(
				'label' => Customweb_I18n_Translation::__("Cancel ID")->toString(),
				'value' => $this->getUnzCancelId()
			)
		);
	}
}