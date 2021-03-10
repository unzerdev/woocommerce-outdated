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

require_once 'Customweb/Payment/Authorization/IInvoiceItem.php';

/**
 * Default implementation for an invoice item.
 * 
 * @author Thomas Huniker
 *
 */
class Customweb_Payment_Authorization_DefaultInvoiceItem implements Customweb_Payment_Authorization_IInvoiceItem{
	
	private $sku;
	private $name;
	private $taxRate;
	private $quantity;
	private $amountIncludingTax;
	private $originalSku = null;
	private $requiresShipping = null;
	private $type = null;
	
	public function __construct($sku, $name = null, $taxRate = null, $amountIncludingTax = null, $quantity = 1 , $type = self::TYPE_PRODUCT, $originalSku = null, $requiresShipping = null){
		if ($sku instanceof Customweb_Payment_Authorization_IInvoiceItem) {
			$item = $sku;
			$this->sku = $item->getSku();
			$this->name = $item->getName();
			$this->taxRate = $item->getTaxRate();
			$this->amountIncludingTax = $item->getAmountIncludingTax();
			$this->quantity = $item->getQuantity();
			$this->type = $item->getType();
			$this->originalSku = $item->getOriginalSku();
			$this->requiresShipping = $item->isShippingRequired();
		}
		else {
			$this->sku = $sku;
			$this->name = $name;
			$this->taxRate = $taxRate;
			$this->amountIncludingTax = $amountIncludingTax;
			$this->quantity = $quantity;
			$this->type = $type;
			$this->originalSku = $originalSku;
			$this->requiresShipping = $requiresShipping;
		}
	}
	
	public function getSku()
	{
		return $this->sku;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function getTaxRate(){
		return $this->taxRate;
	}
	
	public function getQuantity(){
		return $this->quantity;
	}
	
	public function getAmountIncludingTax()
	{
		return $this->amountIncludingTax;
	}
	
	public function getAmountExcludingTax() {
		return $this->getAmountIncludingTax() / ($this->getTaxRate()/100 + 1);
	}
	
	public function getTaxAmount() {
		return $this->getAmountIncludingTax() - $this->getAmountExcludingTax();
	}
	
	public function getType(){
		
		// We changed the visibility from public to private. This fix prevents 
		// the loosing of the type variable.
		if ($this->type === null) {
			$data = (array)$this;
			if (isset($data['type'])) {
				$this->type = $data['type'];
			}
		}
		
		return $this->type;
	}
	
	public function getOriginalSku() {
		if ($this->originalSku !== null) {
			return $this->originalSku;
		}
		else {
			return $this->getSku();
		}
	}
	
	public function isShippingRequired() {
		if ($this->requiresShipping === null) {
			if ($this->getType() === self::TYPE_PRODUCT) {
				return true;
			}
			else {
				return false;
			}
		}
		else {
			return $this->requiresShipping;
		}
	}
}