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

require_once 'Customweb/Payment/ExternalCheckout/ICheckout.php';


abstract class Customweb_Payment_ExternalCheckout_AbstractCheckout implements Customweb_Payment_ExternalCheckout_ICheckout {
	
	private $container;
	
	public function __construct(Customweb_DependencyInjection_IContainer $container) {
		$this->container = $container;
	}
	
	public function getSortOrder() {
		$sortOrder = $this->getContainer()->getBean('Customweb_Payment_SettingHandler')->getSettingValue($this->getMachineName() . '_sort_order');
		if ($sortOrder == null) {
			return $this->getDefaultSortOrder();
		}
		return $sortOrder;
	}
	
	public function isActive() {
		return $this->getContainer()->getBean('Customweb_Payment_SettingHandler')->getSettingValue($this->getMachineName() . '_active') == 'yes';
	}
	
	public function getMinimalOrderTotal() {
		return $this->getContainer()->getBean('Customweb_Payment_SettingHandler')->getSettingValue($this->getMachineName() . '_minimal_order_total');
	}
	
	public function getMaximalOrderTotal() {
		return $this->getContainer()->getBean('Customweb_Payment_SettingHandler')->getSettingValue($this->getMachineName() . '_maximal_order_total');
	}
	
	public function checkMinimalOrderTotal($totalAmount) {
		$minimalOrderTotal = $this->getMinimalOrderTotal();
		if (!empty($minimalOrderTotal)) {
			if ($minimalOrderTotal > $totalAmount) {
				return false;
			}
		}
		return true;
	}
	
	public function checkMaximalOrderTotal($totalAmount) {
		$maximalOrderTotal = $this->getMaximalOrderTotal();
		if (!empty($maximalOrderTotal)) {
			if ($maximalOrderTotal < $totalAmount) {
				return false;
			}
		}
		return true;
	}
	
	/**
	 * @return int default sort order
	 */
	protected function getDefaultSortOrder() {
		return 0;
	}
	
	/**
	 * @return Customweb_DependencyInjection_IContainer
	 */
	protected function getContainer() {
		return $this->container;
	}
	
}