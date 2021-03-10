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
 * This implementation allows the editing of the line item.
 * 
 * @author Thomas Huniker
 *
 */
class Customweb_Payment_Authorization_EditableInvoiceItem implements Customweb_Payment_Authorization_IInvoiceItem{
	
	private $sku;
	private $name;
	private $taxRate;
	private $quantity;
	private $amountIncludingTax;
	private $originalSku = null;
	private $requiresShipping = null;
	private $type = null;
	
	public function __construct(Customweb_Payment_Authorization_IInvoiceItem $item = null){
		if ($item !== null) {
			$this->sku = $item->getSku();
			$this->name = $item->getName();
			$this->taxRate = $item->getTaxRate();
			$this->amountIncludingTax = $item->getAmountIncludingTax();
			$this->quantity = $item->getQuantity();
			$this->type = $item->getType();
			$this->originalSku = $item->getOriginalSku();
			$this->requiresShipping = $item->isShippingRequired();
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

	public function setSku($sku){
		$this->sku = $sku;
		return $this;
	}

	public function setName($name){
		$this->name = $name;
		return $this;
	}

	public function setTaxRate($taxRate){
		$this->taxRate = $taxRate;
		return $this;
	}

	public function setQuantity($quantity){
		$this->quantity = $quantity;
		return $this;
	}

	public function setAmountIncludingTax($amountIncludingTax){
		$this->amountIncludingTax = $amountIncludingTax;
		return $this;
	}

	public function setOriginalSku($originalSku){
		$this->originalSku = $originalSku;
		return $this;
	}

	public function setRequiresShipping($requiresShipping){
		$this->requiresShipping = $requiresShipping;
		return $this;
	}

	public function setType($type){
		$this->type = $type;
		return $this;
	}
	
}