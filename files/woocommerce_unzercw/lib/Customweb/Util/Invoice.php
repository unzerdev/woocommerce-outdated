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

/**
 * This util provides utility methods for invoice item handling.
 */
final class Customweb_Util_Invoice {

	/**
	 *
	 * @param Customweb_Payment_Authorization_IInvoiceItem[] $items
	 */
	public static function getTotalAmountIncludingTax($items){
		$sum = 0;
		foreach ($items as $item) {
			if ($item->getType() == Customweb_Payment_Authorization_DefaultInvoiceItem::TYPE_DISCOUNT) {
				$sum -= $item->getAmountIncludingTax();
			}
			else {
				$sum += $item->getAmountIncludingTax();
			}
		}
		return $sum;
	}

	/**
	 *
	 * @param Customweb_Payment_Authorization_IInvoiceItem[] $items
	 */
	public static function getTotalAmountExcludingTax($items){
		$sum = 0;
		foreach ($items as $item) {
			if ($item->getType() == Customweb_Payment_Authorization_DefaultInvoiceItem::TYPE_DISCOUNT) {
				$sum -= $item->getAmountExcludingTax();
			}
			else {
				$sum += $item->getAmountExcludingTax();
			}
		}
		return $sum;
	}

	/**
	 *
	 * @param Customweb_Payment_Authorization_IInvoiceItem[] $items
	 */
	public static function getTotalTaxAmount($items){
		$sum = 0;
		foreach ($items as $item) {
			if ($item->getType() == Customweb_Payment_Authorization_DefaultInvoiceItem::TYPE_DISCOUNT) {
				$sum -= $item->getTaxAmount();
			}
			else {
				$sum += $item->getTaxAmount();
			}
		}
		return $sum;
	}
	
	/**
	 * This method produces a list of line item which are cleaned up. This means the amounts of the line items are rounded 
	 * correctly. The line items only contains items with unique SKUs. If there is a difference between the expected sum and 
	 * the actual sum an adjustment line item will be added. 
	 * 
	 * @param array $originalLineItems The line items to clean.
	 * @param float $expectedSum The sum which should be met with this line items.
	 * @param string $currencyCode The currency to use when the amounts are rounded.
	 */
	public static function cleanupLineItems(array $originalLineItems, $expectedSum, $currencyCode) {
		
		$expectedSum = Customweb_Util_Currency::roundAmount($expectedSum, $currencyCode);
		
		$result = array();
		foreach ($originalLineItems as $lineItem) {
			$type = $lineItem->getType();
			$amount = $lineItem->getAmountIncludingTax();
			if ($type == Customweb_Payment_Authorization_IInvoiceItem::TYPE_DISCOUNT && $amount < 0) {
				$type = Customweb_Payment_Authorization_IInvoiceItem::TYPE_FEE;
				$amount = $amount * -1;
			}
			$result[] = new Customweb_Payment_Authorization_DefaultInvoiceItem($lineItem->getSku(), $lineItem->getName(), $lineItem->getTaxRate(),
					Customweb_Util_Currency::roundAmount($amount, $currencyCode), $lineItem->getQuantity(), $type, 
					$lineItem->getOriginalSku(), $lineItem->isShippingRequired());
		}
		
		$realSum = self::getTotalAmountIncludingTax($result);
		$diff = Customweb_Util_Currency::compareAmount($realSum, $expectedSum, $currencyCode);
		if ($diff > 0) {
			$amountDifferenceWithTax = $realSum - $expectedSum;
			$result[] = new Customweb_Payment_Authorization_DefaultInvoiceItem('rounding-adjustment', Customweb_I18n_Translation::__("Rounding Adjustment")->toString(), 0,
					Customweb_Util_Currency::roundAmount($amountDifferenceWithTax, $currencyCode), 1, Customweb_Payment_Authorization_IInvoiceItem::TYPE_DISCOUNT);
		}
		else if($diff < 0) {
			$amountDifferenceWithTax = $expectedSum - $realSum;
			$result[] = new Customweb_Payment_Authorization_DefaultInvoiceItem('rounding-adjustment', Customweb_I18n_Translation::__("Rounding Adjustment")->toString(), 0,
					Customweb_Util_Currency::roundAmount($amountDifferenceWithTax, $currencyCode), 1, Customweb_Payment_Authorization_IInvoiceItem::TYPE_FEE);
		}
		
		return self::ensureUniqueSku($result);
	}

	/**
	 * This method generates a set of line items, which represents the delta of the amount change.
	 *
	 *
	 * @param Customweb_Payment_Authorization_IInvoiceItem[] $originalLineItems List of line items on which the delta based on.
	 * @param float $amount The reduction amount.
	 * @return Customweb_Payment_Authorization_IInvoiceItem[] The set of line items, which represents the delta.
	 */
	public static function getItemsByReductionAmount(array $originalLineItems, $amount, $currencyCode){
		if (count($originalLineItems) <= 0) {
			throw new Exception("No line items provided.");
		}
		$total = self::getTotalAmountIncludingTax($originalLineItems);
		$factor = Customweb_Util_Currency::roundAmount($amount, $currencyCode) / Customweb_Util_Currency::roundAmount($total, $currencyCode);
		
		if($factor-1 > 0.0001) {
			throw new Exception("The reduction amount can not be bigger, than the total amount of all involved line items.");
		}
			
		$appliedTotal = 0;
		$newItems = array();
		$itemCopy = array();
		foreach ($originalLineItems as $item) {
			/* @var $item Customweb_Payment_Authorization_IInvoiceItem */
			$newAmount = Customweb_Util_Currency::roundAmount($item->getAmountIncludingTax() * $factor, $currencyCode);
			$newItem = new Customweb_Payment_Authorization_DefaultInvoiceItem($item->getSku(), $item->getName(), $item->getTaxRate(), $newAmount, 
					$item->getQuantity(), $item->getType(), $item->getOriginalSku(), $item->isShippingRequired());
			$newItems[] = $newItem;
			$itemCopy[] = $item;
			if ($item->getType() == Customweb_Payment_Authorization_DefaultInvoiceItem::TYPE_DISCOUNT) {
				$appliedTotal -= $newAmount;
			}
			else {
				$appliedTotal += $newAmount;
			}
		}		
		// Fix rounding error
		$roundingDifference = $amount - $appliedTotal;
		
		$newItems = self::distributeRoundingDifference($newItems,  0, $roundingDifference, $itemCopy, $currencyCode);		
		return $newItems;
	}
	
	
	private static function distributeRoundingDifference($items, $index, $remainder, $originalLineItems, $currencyCode){
		
		$digits = Customweb_Util_Currency::getDecimalPlaces($currencyCode);
		$currentItem  = $items[$index];
		$delta = $remainder;
		$change = false;
		$positive = $delta > 0;		
		while($delta != 0){
			$newAmount = $currentItem->getAmountIncludingTax()+$delta;
			if($currentItem->getType() == Customweb_Payment_Authorization_DefaultInvoiceItem::TYPE_DISCOUNT){
				$newAmount = $currentItem->getAmountIncludingTax()-$delta;
			}
			if(Customweb_Util_Currency::compareAmount($newAmount, $originalLineItems[$index]->getAmountIncludingTax(), $currencyCode) <= 0){
				$change = true;
				break;
			}
			//rounding because float
			$newDelta = round((abs($delta) - pow(0.1, $digits+1)) * ($positive ? 1 : -1), 10);
			if(($positive xor $newDelta > 0) && $delta != 0){
				break;
			}
			$delta=$newDelta;
		}

		if($change){
			$items[$index] = new Customweb_Payment_Authorization_DefaultInvoiceItem($currentItem->getSku(), $currentItem->getName(), $currentItem->getTaxRate(), $newAmount,
					$currentItem->getQuantity(), $currentItem->getType(), $currentItem->getOriginalSku(), $currentItem->isShippingRequired());
			$newRemainder = $remainder-$delta;
		}
		else{
			$newRemainder = $remainder;
		}		
		if($index + 1 < count($items) && $newRemainder != 0){
			return self::distributeRoundingDifference($items, $index+1, $newRemainder, $originalLineItems, $currencyCode);
		}
		else{
			if($newRemainder != 0){
				throw new Exception("Could not distribute rounding difference");
			}
			return $items;
		}
	}

	/**
	 * This method ensures that all invoice items have a unique sku.
	 *
	 * @param Customweb_Payment_Authorization_IInvoiceItem[] $lineItems
	 * @return Customweb_Payment_Authorization_IInvoiceItem[]
	 */
	public static function ensureUniqueSku(array $lineItems){
		$newLineItems = array();
		$skus = array();
		foreach ($lineItems as $item) {
			$sku = $item->getSku();
			if (empty($sku)) {
				$sku = preg_replace("/[^a-z0-9]/", '', strtolower($item->getName()));
			}
			if (empty($sku)) {
				throw new Exception("There is an invoice item without SKU and name.");
			}
			
			if (isset($skus[$sku])) {
				$back = $sku;
				while(($sku = $sku . '_' . $skus[$sku]) && isset($skus[$sku])){
					$back = $sku;
				}
				$skus[$back]++;
			}
			$skus[$sku] = 1;
			
			$newLineItems[] = new Customweb_Payment_Authorization_DefaultInvoiceItem($sku, $item->getName(), $item->getTaxRate(), 
					$item->getAmountIncludingTax(), $item->getQuantity(), $item->getType(), $item->getOriginalSku(), $item->isShippingRequired());
		}
		
		return $newLineItems;
	}

	/**
	 * This method calculates the resulting line items based on a list of items and the delta line items.
	 * This
	 * method can be used to determine the resulting line items from a set of delta line items.
	 *
	 * @param Customweb_Payment_Authorization_IInvoiceItem[] $originalItems
	 * @param Customweb_Payment_Authorization_IInvoiceItem[] $deltaLineItems
	 * @return Customweb_Payment_Authorization_IInvoiceItem[]
	 */
	public static function getResultingLineItemsByDeltaItems(array $originalItems, array $deltaLineItems){
		$deltaKeys = array();
		foreach ($deltaLineItems as $key => $item) {
			$deltaKeys[self::getIdentifier($item)] = $item;
		}
		
		$resultingLineItems = array();
		foreach ($originalItems as $item) {
			$identifier = self::getIdentifier($item);
			if (isset($deltaKeys[$identifier])) {
				$deltaItem = $deltaKeys[$identifier];
				/* @var $deltaItem Customweb_Payment_Authorization_IInvoiceItem */
				$newAmount = $item->getAmountIncludingTax() - $deltaItem->getAmountIncludingTax();
				$newQuantity = $item->getQuantity() - $deltaItem->getQuantity();
				$resultingLineItems[] = new Customweb_Payment_Authorization_DefaultInvoiceItem($item->getSku(), $item->getName(), 
						$deltaItem->getTaxRate(), $newAmount, $newQuantity, $item->getType(), $item->getOriginalSku(), $item->isShippingRequired());
				unset($deltaKeys[$identifier]);
			}
			else {
				$resultingLineItems[] = $item;
			}
		}
		
		// Add additional capture items
		foreach ($deltaKeys as $item) {
			$resultingLineItems[] = $item;
		}
		
		return $resultingLineItems;
	}

	/**
	 * This method removes the given $itemsToRemove from the $originalItems.
	 * The resulting
	 * list does only contain items from $originalItems.
	 *
	 * @param array $originalItems
	 * @param array $itemsToRemove
	 * @return Customweb_Payment_Authorization_IInvoiceItem[]
	 */
	public static function substractLineItems(array $originalItems, array $itemsToRemove){
		$deltaKeys = array();
		foreach ($itemsToRemove as $key => $item) {
			$deltaKeys[self::getIdentifier($item)] = $item;
		}
		
		$resultingLineItems = array();
		foreach ($originalItems as $item) {
			$identifier = self::getIdentifier($item);
			if (isset($deltaKeys[$identifier])) {
				$deltaItem = $deltaKeys[$identifier];
				/* @var $deltaItem Customweb_Payment_Authorization_IInvoiceItem */
				$newAmount = $item->getAmountIncludingTax() - $deltaItem->getAmountIncludingTax();
				$newQuantity = $item->getQuantity() - $deltaItem->getQuantity();
				if ($newAmount > 0) {
					$resultingLineItems[] = new Customweb_Payment_Authorization_DefaultInvoiceItem($item->getSku(), $item->getName(), 
							$deltaItem->getTaxRate(), $newAmount, $newQuantity, $item->getType(), $item->getOriginalSku(), $item->isShippingRequired());
				}
				unset($deltaKeys[$identifier]);
			}
			else {
				$resultingLineItems[] = $item;
			}
		}
		
		return $resultingLineItems;
	}

	/**
	 * This method adds the given $itemsToAdd to the $originalItems.
	 * The resulting list
	 * may contains also items which are only present in $itemsToAdd.
	 *
	 * @param array $originalItems
	 * @param array $itemsToAdd
	 * @return Customweb_Payment_Authorization_IInvoiceItem[]
	 */
	public static function addLineItems(array $originalItems, array $itemsToAdd){
		$deltaKeys = array();
		foreach ($itemsToAdd as $key => $item) {
			$deltaKeys[self::getIdentifier($item)] = $item;
		}
		
		$resultingLineItems = array();
		foreach ($originalItems as $item) {
			$identifier = self::getIdentifier($item);
			if (isset($deltaKeys[$identifier])) {
				$deltaItem = $deltaKeys[$identifier];
				/* @var $deltaItem Customweb_Payment_Authorization_IInvoiceItem */
				$newAmount = $item->getAmountIncludingTax() + $deltaItem->getAmountIncludingTax();
				$newQuantity = $item->getQuantity() + $deltaItem->getQuantity();
				$resultingLineItems[] = new Customweb_Payment_Authorization_DefaultInvoiceItem($item->getSku(), $item->getName(), 
						$deltaItem->getTaxRate(), $newAmount, $newQuantity, $item->getType(), $item->getOriginalSku(), $item->isShippingRequired());
				unset($deltaKeys[$identifier]);
			}
			else {
				$resultingLineItems[] = $item;
			}
		}
		
		// Add additional capture items
		foreach ($deltaKeys as $item) {
			$resultingLineItems[] = $item;
		}
		
		return $resultingLineItems;
	}

	private static function getIdentifier(Customweb_Payment_Authorization_IInvoiceItem $item){
		$key = $item->getSku();
		if (empty($key)) {
			$key = '';
		}
		$name = $item->getName();
		if (!empty($name)) {
			$key .= $name;
		}
		
		return $key;
	}
}