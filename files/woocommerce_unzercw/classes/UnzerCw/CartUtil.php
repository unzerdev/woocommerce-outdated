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
require_once 'Customweb/Core/String.php';
require_once 'Customweb/Payment/Authorization/DefaultInvoiceItem.php';
require_once 'Customweb/Payment/Authorization/IInvoiceItem.php';
require_once 'Customweb/Util/Invoice.php';


/**
 *
 * @author eigenmann
 */
class UnzerCw_CartUtil {

	private function __construct(){}

	public static function getInoviceItemsFromCart(WC_Cart $cart){
		$wooCommerceItems = $cart->get_cart();
		if (empty($wooCommerceItems)) {
			return array();
		}
		$items = array();
		
		foreach ($wooCommerceItems as $wooItem) {
			/*
			 * @var $product WC_Product
			 */
			$product = $wooItem['data'];			
			$sku = $product->get_sku();
			$name = $product->get_title();
			if (empty($sku)) {
				$sku = Customweb_Core_String::_($name)->replace(" ", "")->replace("\t", "")->convertTo('ASCII')->toLowerCase()->toString();
			}
			
			if (isset($wooItem['line_subtotal']) && isset($wooItem['quantity']) && isset($wooItem['line_subtotal_tax'])) {
				$amountExclTax = $wooItem['line_subtotal'];
				$amountIncludingTax = $wooItem['line_subtotal'] + $wooItem['line_subtotal_tax'];
				$taxRate = 0;
				if ($amountExclTax != 0) {
					$taxRate = ($amountIncludingTax - $amountExclTax) / $amountExclTax * 100;
				}
				$quantity = $wooItem['quantity'];
			}
			else {
				$quantity = 1;
				$amountExclTax = $wooItem['line_total'];
				$amountIncludingTax = $wooItem['line_total'] + $wooItem['line_tax'];
				$taxRate = 0;
				if ($amountExclTax != 0) {
					$taxRate = ($amountIncludingTax - $amountExclTax) / $amountExclTax * 100;
				}
			}
			$item = new Customweb_Payment_Authorization_DefaultInvoiceItem($sku, $name, $taxRate, $amountIncludingTax, $quantity);
			$items[] = $item;
			if (version_compare(WOOCOMMERCE_VERSION, '3.2') < 0) {
				$discountAmount = ($item->getAmountExcludingTax() / $quantity -
						 $cart->get_discounted_price($wooItem, $item->getAmountExcludingTax() / $quantity)) * $quantity;
				 if ($discountAmount > 0) {
				 	$discountItem = new Customweb_Payment_Authorization_DefaultInvoiceItem($sku . '-discount',
				 			__("Discount", "woocommerce_unzercw") . ' ' . $name, $taxRate, $discountAmount * ($taxRate / 100 + 1), $quantity,
				 			Customweb_Payment_Authorization_IInvoiceItem::TYPE_DISCOUNT);
				 	$items[] = $discountItem;
				 }
			}			
			else {
				$discountAmount = $wooItem['line_subtotal'] - $wooItem['line_total'] + $wooItem['line_subtotal_tax'] - $wooItem['line_tax'];
				if ($discountAmount > 0) {
					$discountItem = new Customweb_Payment_Authorization_DefaultInvoiceItem($sku . '-discount',
							__("Discount", "woocommerce_unzercw") . ' ' . $name, $taxRate, $discountAmount, $quantity,
							Customweb_Payment_Authorization_IInvoiceItem::TYPE_DISCOUNT);
					$items[] = $discountItem;
				}
			}
		}
		// Add Shipping
		if ($cart->shipping_total > 0) {
			$shippingExclTax = $cart->shipping_total;
			$shippingTax = $cart->shipping_tax_total;
			$taxRate = 0;
			if ($shippingExclTax != 0) {
				$taxRate = $shippingTax / $shippingExclTax * 100;
			}
			$items[] = new Customweb_Payment_Authorization_DefaultInvoiceItem('shipping', __("Shipping", "woocommerce_unzercw"),
					$taxRate, $shippingExclTax + $shippingTax, 1, Customweb_Payment_Authorization_DefaultInvoiceItem::TYPE_SHIPPING);
		}
		//Add Fees
		if (count($cart->get_fees()) > 0) {
			foreach ($cart->get_fees() as $fee) {
				if ($fee->amount == 0) {
					continue;
				}
				$name = $fee->name;
				$sku = Customweb_Core_String::_($name)->replace(" ", "")->replace("\t", "")->convertTo('ASCII')->toString();
				if (empty($sku)) {
					$sku = "fee" . rand();
				}
				$amountExcludingTax = $fee->amount;
				$taxAmount = $fee->tax;
				$taxRate = ((($amountExcludingTax + $taxAmount) / $amountExcludingTax) - 1) * 100;
				
				$items[] = new Customweb_Payment_Authorization_DefaultInvoiceItem($sku, $name, $taxRate, $amountExcludingTax + $taxAmount, 1,
						Customweb_Payment_Authorization_DefaultInvoiceItem::TYPE_FEE);
			}
		}
		return Customweb_Util_Invoice::cleanupLineItems($items, $cart->total, get_woocommerce_currency());
	}
}