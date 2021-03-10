<?php

require_once 'UnzerCw/BackendFormRenderer.php';
require_once 'Customweb/Util/Url.php';
require_once 'Customweb/Payment/Authorization/DefaultInvoiceItem.php';
require_once 'Customweb/Payment/BackendOperation/Adapter/Service/ICapture.php';
require_once 'Customweb/Form/Control/IEditableControl.php';
require_once 'Customweb/Payment/BackendOperation/Adapter/Service/ICancel.php';
require_once 'Customweb/IForm.php';
require_once 'Customweb/Form.php';
require_once 'Customweb/Core/Http/ContextRequest.php';
require_once 'Customweb/Form/Control/MultiControl.php';
require_once 'Customweb/Util/Currency.php';
require_once 'Customweb/Payment/Authorization/IInvoiceItem.php';
require_once 'Customweb/Payment/BackendOperation/Adapter/Service/IRefund.php';
require_once 'Customweb/Licensing/UnzerCw/License.php';



// Make sure we don't expose any info if called directly 
if (!function_exists('add_action')) {
	echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
	exit();
}

// Add some CSS and JS for admin 
function woocommerce_unzercw_admin_add_setting_styles_scripts($hook){
	if($hook != 'post.php' && $hook != 'dashboard_page_wpsc-purchase-logs' && stripos($hook,'woocommerce-unzercw') === false){
		return;
	}
	wp_register_style('woocommerce_unzercw_admin_styles', plugins_url('resources/css/settings.css', __FILE__));
	wp_enqueue_style('woocommerce_unzercw_admin_styles');
	
	wp_register_script('woocommerce_unzercw_admin_js', plugins_url('resources/js/settings.js', __FILE__));
	wp_enqueue_script('woocommerce_unzercw_admin_js');
}
add_action('admin_enqueue_scripts', 'woocommerce_unzercw_admin_add_setting_styles_scripts');

function woocommerce_unzercw_admin_notice_handler(){
	if (get_transient(get_current_user_id() . '_unzercw_am') !== false) {
		
		foreach (get_transient(get_current_user_id() . '_unzercw_am') as $message) {
			$cssClass = '';
			if (strtolower($message['type']) == 'error') {
				$cssClass = 'error';
			}
			else if (strtolower($message['type']) == 'info') {
				$cssClass = 'updated';
			}
			
			echo '<div class="' . $cssClass . '">';
			echo '<p>Unzer: ' . $message['message'] . '</p>';
			echo '</div>';
		}
		delete_transient(get_current_user_id() . '_unzercw_am');
	}
}
add_action('admin_notices', 'woocommerce_unzercw_admin_notice_handler');

function woocommerce_unzercw_admin_show_message($message, $type){
	$existing = array();
	if (get_transient(get_current_user_id() . '_unzercw_am') === false) {
		$existing = get_transient(get_current_user_id() . '_unzercw_am');
	}
	$existing[] = array(
		'message' => $message,
		'type' => $type 
	);
	set_transient(get_current_user_id() . '_unzercw_am', $existing);
}

/**
 * Add the configuration menu
 */
function woocommerce_unzercw_menu(){
	add_menu_page('Unzer', __('Unzer', 'woocommerce_unzercw'), 
			'manage_woocommerce', 'woocommerce-unzercw', 'woocommerce_unzercw_options');
	
	if (isset($_REQUEST['page']) && strpos($_REQUEST['page'], 'woocommerce-unzercw') !== false) {
		$container = UnzerCw_Util::createContainer();
		if ($container->hasBean('Customweb_Payment_BackendOperation_Form_IAdapter')) {
			$adapter = $container->getBean('Customweb_Payment_BackendOperation_Form_IAdapter');
			foreach ($adapter->getForms() as $form) {
				add_submenu_page('woocommerce-unzercw', 'Unzer ' . $form->getTitle(), $form->getTitle(), 
						'manage_woocommerce', 'woocommerce-unzercw-' . $form->getMachineName(), 
						'woocommerce_unzercw_extended_options');
			}
		}
	}
	
	add_submenu_page(null, 'Unzer Capture', 'Unzer Capture', 'manage_woocommerce', 
			'woocommerce-unzercw_capture', 'woocommerce_unzercw_render_capture');
	add_submenu_page(null, 'Unzer Cancel', 'Unzer Cancel', 'manage_woocommerce', 
			'woocommerce-unzercw_cancel', 'woocommerce_unzercw_render_cancel');
	add_submenu_page(null, 'Unzer Refund', 'Unzer Refund', 'manage_woocommerce', 
			'woocommerce-unzercw_refund', 'woocommerce_unzercw_render_refund');
}
add_action('admin_menu', 'woocommerce_unzercw_menu');

function woocommerce_unzercw_render_cancel(){
	
	
	
	

	$request = Customweb_Core_Http_ContextRequest::getInstance();
	$query = $request->getParsedQuery();
	$post = $request->getParsedBody();
	$transactionId = $query['cwTransactionId'];
	
	if (empty($transactionId)) {
		wp_redirect(get_option('siteurl') . '/wp-admin');
		exit();
	}
	
	$transaction = UnzerCw_Util::getTransactionById($transactionId);
	$orderId = $transaction->getPostId();
	$url = str_replace('>orderId', $orderId, get_admin_url() . 'post.php?post=>orderId&action=edit');
	if ($request->getMethod() == 'POST') {
		if (isset($post['cancel'])) {
			$adapter = UnzerCw_Util::createContainer()->getBean('Customweb_Payment_BackendOperation_Adapter_Service_ICancel');
			if (!($adapter instanceof Customweb_Payment_BackendOperation_Adapter_Service_ICancel)) {
				throw new Exception("No adapter with interface 'Customweb_Payment_BackendOperation_Adapter_Service_ICancel' provided.");
			}
			
			try {
				$adapter->cancel($transaction->getTransactionObject());
				woocommerce_unzercw_admin_show_message(
						__("Successfully cancelled the transaction.", 'woocommerce_unzercw'), 'info');
			}
			catch (Exception $e) {
				woocommerce_unzercw_admin_show_message($e->getMessage(), 'error');
			}
			UnzerCw_Util::getEntityManager()->persist($transaction);
		}
		wp_redirect($url);
		exit();
	}
	else {
		if (!$transaction->getTransactionObject()->isCancelPossible()) {
			woocommerce_unzercw_admin_show_message(__('Cancel not possible', 'woocommerce_unzercw'), 'info');
			wp_redirect($url);
			exit();
		}
		if (isset($_GET['noheader'])) {
			require_once (ABSPATH . 'wp-admin/admin-header.php');
		}
		
		echo '<div class="wrap">';
		echo '<form method="POST" class="unzercw-line-item-grid" id="cancel-form">';
		echo '<table class="list">
				<tbody>';
		echo '<tr>
				<td class="left-align">' . __('Are you sure you want to cancel this transaction?', 'woocommerce_unzercw') . '</td>
			</tr>';
		echo '<tr>
				<td colspan="1" class="left-align"><a class="button" href="' . $url . '">' . __('No', 'woocommerce_unzercw') . '</a></td>
				<td colspan="1" class="right-align">
					<input class="button" type="submit" name="cancel" value="' . __('Yes', 'woocommerce_unzercw') . '" />
				</td>
			</tr>
								</tfoot>
			</table>
		</form>';
		
		echo '</div>';
	}
	
	
}

function woocommerce_unzercw_render_capture(){
	
	
	
	$request = Customweb_Core_Http_ContextRequest::getInstance();
	$query = $request->getParsedQuery();
	$post = $request->getParsedBody();
	$transactionId = $query['cwTransactionId'];
	
	if (empty($transactionId)) {
		wp_redirect(get_option('siteurl') . '/wp-admin');
		exit();
	}
	
	$transaction = UnzerCw_Util::getTransactionById($transactionId);
	$orderId = $transaction->getPostId();
	$url = str_replace('>orderId', $orderId, get_admin_url() . 'post.php?post=>orderId&action=edit');
	if ($request->getMethod() == 'POST') {
		
		if (isset($post['quantity'])) {
			
			$captureLineItems = array();
			$lineItems = $transaction->getTransactionObject()->getUncapturedLineItems();
			foreach ($post['quantity'] as $index => $quantity) {
				if (isset($post['price_including'][$index]) && floatval($post['price_including'][$index]) != 0) {
					$originalItem = $lineItems[$index];
					if ($originalItem->getType() == Customweb_Payment_Authorization_IInvoiceItem::TYPE_DISCOUNT) {
						$priceModifier = -1;
					}
					else {
						$priceModifier = 1;
					}
					$captureLineItems[$index] = new Customweb_Payment_Authorization_DefaultInvoiceItem($originalItem->getSku(), 
							$originalItem->getName(), $originalItem->getTaxRate(), $priceModifier * floatval($post['price_including'][$index]), 
							$quantity, $originalItem->getType());
				}
			}
			if (count($captureLineItems) > 0) {
				$adapter = UnzerCw_Util::createContainer()->getBean('Customweb_Payment_BackendOperation_Adapter_Service_ICapture');
				if (!($adapter instanceof Customweb_Payment_BackendOperation_Adapter_Service_ICapture)) {
					throw new Exception("No adapter with interface 'Customweb_Payment_BackendOperation_Adapter_Service_ICapture' provided.");
				}
				
				$close = false;
				if (isset($post['close']) && $post['close'] == 'on') {
					$close = true;
				}
				try {
					$adapter->partialCapture($transaction->getTransactionObject(), $captureLineItems, $close);
					woocommerce_unzercw_admin_show_message(
							__("Successfully added a new capture.", 'woocommerce_unzercw'), 'info');
				}
				catch (Exception $e) {
					woocommerce_unzercw_admin_show_message($e->getMessage(), 'error');
				}
				UnzerCw_Util::getEntityManager()->persist($transaction);
			}
		}
		
		wp_redirect($url);
		exit();
	}
	else {
		if (!$transaction->getTransactionObject()->isPartialCapturePossible()) {
			woocommerce_unzercw_admin_show_message(__('Capture not possible', 'woocommerce_unzercw'), 'info');
			
			wp_redirect($url);
			exit();
		}
		if (isset($_GET['noheader'])) {
			require_once (ABSPATH . 'wp-admin/admin-header.php');
		}
		
		echo '<div class="wrap">';
		echo '<form method="POST" class="unzercw-line-item-grid" id="capture-form">';
		echo '<input type="hidden" id="unzercw-decimal-places" value="' .
				 Customweb_Util_Currency::getDecimalPlaces($transaction->getTransactionObject()->getCurrencyCode()) . '" />';
		echo '<input type="hidden" id="unzercw-currency-code" value="' . strtoupper($transaction->getTransactionObject()->getCurrencyCode()) .
				 '" />';
		echo '<table class="list">
					<thead>
						<tr>
						<th class="left-align">' . __('Name', 'woocommerce_unzercw') . '</th>
						<th class="left-align">' . __('SKU', 'woocommerce_unzercw') . '</th>
						<th class="left-align">' . __('Type', 'woocommerce_unzercw') . '</th>
						<th class="left-align">' . __('Tax Rate', 'woocommerce_unzercw') . '</th>
						<th class="right-align">' . __('Quantity', 
				'woocommerce_unzercw') . '</th>
						<th class="right-align">' . __('Total Amount (excl. Tax)', 'woocommerce_unzercw') . '</th>
						<th class="right-align">' . __('Total Amount (incl. Tax)', 'woocommerce_unzercw') . '</th>
						</tr>
				</thead>
				<tbody>';
		foreach ($transaction->getTransactionObject()->getUncapturedLineItems() as $index => $item) {
			
			$amountExcludingTax = Customweb_Util_Currency::formatAmount($item->getAmountExcludingTax(), 
					$transaction->getTransactionObject()->getCurrencyCode());
			$amountIncludingTax = Customweb_Util_Currency::formatAmount($item->getAmountIncludingTax(), 
					$transaction->getTransactionObject()->getCurrencyCode());
			if ($item->getType() == Customweb_Payment_Authorization_IInvoiceItem::TYPE_DISCOUNT) {
				$amountExcludingTax = $amountExcludingTax * -1;
				$amountIncludingTax = $amountIncludingTax * -1;
			}
			echo '<tr id="line-item-row-' . $index . '" class="line-item-row" data-line-item-index="' . $index, '" >
						<td class="left-align">' . $item->getName() . '</td>
						<td class="left-align">' . $item->getSku() . '</td>
						<td class="left-align">' . $item->getType() . '</td>
						<td class="left-align">' . round($item->getTaxRate(), 2) . ' %<input type="hidden" class="tax-rate" value="' . $item->getTaxRate() . '" /></td>
						<td class="right-align"><input type="text" class="line-item-quantity" name="quantity[' . $index . ']" value="' . $item->getQuantity() . '" /></td>
						<td class="right-align"><input type="text" class="line-item-price-excluding" name="price_excluding[' . $index . ']" value="' .
					 $amountExcludingTax . '" /></td>
						<td class="right-align"><input type="text" class="line-item-price-including" name="price_including[' . $index . ']" value="' .
					 $amountIncludingTax . '" /></td>
					</tr>';
		}
		echo '</tbody>
				<tfoot>
					<tr>
						<td colspan="6" class="right-align">' . __('Total Capture Amount', 'woocommerce_unzercw') . ':</td>
						<td id="line-item-total" class="right-align">' . Customweb_Util_Currency::formatAmount(
				$transaction->getTransactionObject()->getCapturableAmount(), $transaction->getTransactionObject()->getCurrencyCode()) .
				 strtoupper($transaction->getTransactionObject()->getCurrencyCode()) . '
					</tr>';
		
		if ($transaction->getTransactionObject()->isCaptureClosable()) {
			
			echo '<tr>
					<td colspan="7" class="right-align">
						<label for="close-transaction">' . __('Close transaction for further captures', 'woocommerce_unzercw') . '</label>
						<input id="close-transaction" type="checkbox" name="close" value="on" />
					</td>
				</tr>';
		}
		
		echo '<tr>
				<td colspan="2" class="left-align"><a class="button" href="' . $url . '">' . __('Back', 'woocommerce_unzercw') . '</a></td>
				<td colspan="5" class="right-align">
					<input class="button" type="submit" value="' . __('Capture', 'woocommerce_unzercw') . '" />
				</td>
			</tr>
			</tfoot>
			</table>
		</form>';
		
		echo '</div>';
	}
	
	
}

function woocommerce_unzercw_render_refund(){
	
	
	
	$request = Customweb_Core_Http_ContextRequest::getInstance();
	$query = $request->getParsedQuery();
	$post = $request->getParsedBody();
	$transactionId = $query['cwTransactionId'];
	
	if (empty($transactionId)) {
		wp_redirect(get_option('siteurl') . '/wp-admin');
		exit();
	}
	
	$transaction = UnzerCw_Util::getTransactionById($transactionId);
	$orderId = $transaction->getPostId();
	$url = str_replace('>orderId', $orderId, get_admin_url() . 'post.php?post=>orderId&action=edit');
	if ($request->getMethod() == 'POST') {
		
		if (isset($post['quantity'])) {
			
			$refundLineItems = array();
			$lineItems = $transaction->getTransactionObject()->getNonRefundedLineItems();
			foreach ($post['quantity'] as $index => $quantity) {
				if (isset($post['price_including'][$index]) && floatval($post['price_including'][$index]) != 0) {
					$originalItem = $lineItems[$index];
					if ($originalItem->getType() == Customweb_Payment_Authorization_IInvoiceItem::TYPE_DISCOUNT) {
						$priceModifier = -1;
					}
					else {
						$priceModifier = 1;
					}
					$refundLineItems[$index] = new Customweb_Payment_Authorization_DefaultInvoiceItem($originalItem->getSku(), 
							$originalItem->getName(), $originalItem->getTaxRate(), $priceModifier * floatval($post['price_including'][$index]), 
							$quantity, $originalItem->getType());
				}
			}
			if (count($refundLineItems) > 0) {
				$adapter = UnzerCw_Util::createContainer()->getBean('Customweb_Payment_BackendOperation_Adapter_Service_IRefund');
				if (!($adapter instanceof Customweb_Payment_BackendOperation_Adapter_Service_IRefund)) {
					throw new Exception("No adapter with interface 'Customweb_Payment_BackendOperation_Adapter_Service_IRefund' provided.");
				}
				
				$close = false;
				if (isset($post['close']) && $post['close'] == 'on') {
					$close = true;
				}
				try {
					$adapter->partialRefund($transaction->getTransactionObject(), $refundLineItems, $close);
					woocommerce_unzercw_admin_show_message(
							__("Successfully added a new refund.", 'woocommerce_unzercw'), 'info');
				}
				catch (Exception $e) {
					woocommerce_unzercw_admin_show_message($e->getMessage(), 'error');
				}
				UnzerCw_Util::getEntityManager()->persist($transaction);
			}
		}
		wp_redirect($url);
		exit();
	}
	else {
		if (!$transaction->getTransactionObject()->isPartialRefundPossible()) {
			woocommerce_unzercw_admin_show_message(__('Refund not possible', 'woocommerce_unzercw'), 'info');
			wp_redirect($url);
			exit();
		}
		if (isset($query['noheader'])) {
			require_once (ABSPATH . 'wp-admin/admin-header.php');
		}
		
		echo '<div class="wrap">';
		echo '<form method="POST" class="unzercw-line-item-grid" id="refund-form">';
		echo '<input type="hidden" id="unzercw-decimal-places" value="' .
				 Customweb_Util_Currency::getDecimalPlaces($transaction->getTransactionObject()->getCurrencyCode()) . '" />';
		echo '<input type="hidden" id="unzercw-currency-code" value="' . strtoupper($transaction->getTransactionObject()->getCurrencyCode()) .
				 '" />';
		echo '<table class="list">
					<thead>
						<tr>
						<th class="left-align">' . __('Name', 'woocommerce_unzercw') . '</th>
						<th class="left-align">' . __('SKU', 'woocommerce_unzercw') . '</th>
						<th class="left-align">' . __('Type', 'woocommerce_unzercw') . '</th>
						<th class="left-align">' . __('Tax Rate', 'woocommerce_unzercw') . '</th>
						<th class="right-align">' . __('Quantity', 
				'woocommerce_unzercw') . '</th>
						<th class="right-align">' . __('Total Amount (excl. Tax)', 'woocommerce_unzercw') . '</th>
						<th class="right-align">' . __('Total Amount (incl. Tax)', 'woocommerce_unzercw') . '</th>
						</tr>
				</thead>
				<tbody>';
		foreach ($transaction->getTransactionObject()->getNonRefundedLineItems() as $index => $item) {
			$amountExcludingTax = Customweb_Util_Currency::formatAmount($item->getAmountExcludingTax(), 
					$transaction->getTransactionObject()->getCurrencyCode());
			$amountIncludingTax = Customweb_Util_Currency::formatAmount($item->getAmountIncludingTax(), 
					$transaction->getTransactionObject()->getCurrencyCode());
			if ($item->getType() == Customweb_Payment_Authorization_IInvoiceItem::TYPE_DISCOUNT) {
				$amountExcludingTax = $amountExcludingTax * -1;
				$amountIncludingTax = $amountIncludingTax * -1;
			}
			echo '<tr id="line-item-row-' . $index . '" class="line-item-row" data-line-item-index="' . $index, '" >
					<td class="left-align">' . $item->getName() . '</td>
					<td class="left-align">' . $item->getSku() . '</td>
					<td class="left-align">' . $item->getType() . '</td>
					<td class="left-align">' . round($item->getTaxRate(), 2) . ' %<input type="hidden" class="tax-rate" value="' . $item->getTaxRate() . '" /></td>
					<td class="right-align"><input type="text" class="line-item-quantity" name="quantity[' . $index . ']" value="' . $item->getQuantity() . '" /></td>
					<td class="right-align"><input type="text" class="line-item-price-excluding" name="price_excluding[' . $index . ']" value="' .
					 $amountExcludingTax . '" /></td>
					<td class="right-align"><input type="text" class="line-item-price-including" name="price_including[' . $index . ']" value="' .
					 $amountIncludingTax . '" /></td>
				</tr>';
		}
		echo '</tbody>
				<tfoot>
					<tr>
						<td colspan="6" class="right-align">' . __('Total Refund Amount', 'woocommerce_unzercw') . ':</td>
						<td id="line-item-total" class="right-align">' . Customweb_Util_Currency::formatAmount(
				$transaction->getTransactionObject()->getRefundableAmount(), $transaction->getTransactionObject()->getCurrencyCode()) .
				 strtoupper($transaction->getTransactionObject()->getCurrencyCode()) . '
						</tr>';
		
		if ($transaction->getTransactionObject()->isRefundClosable()) {
			echo '<tr>
					<td colspan="7" class="right-align">
						<label for="close-transaction">' . __('Close transaction for further refunds', 'woocommerce_unzercw') . '</label>
						<input id="close-transaction" type="checkbox" name="close" value="on" />
					</td>
				</tr>';
		}
		
		echo '<tr>
				<td colspan="2" class="left-align"><a class="button" href="' . $url . '">' . __('Back', 'woocommerce_unzercw') . '</a></td>
				<td colspan="5" class="right-align">
					<input class="button" type="submit" value="' . __('Refund', 'woocommerce_unzercw') . '" />
				</td>
			</tr>
		</tfoot>
		</table>
		</form>';
		
		echo '</div>';
	}
	
	
}

function woocommerce_unzercw_extended_options(){
	$container = UnzerCw_Util::createContainer();
	$request = Customweb_Core_Http_ContextRequest::getInstance();
	$query = $request->getParsedQuery();
	$formName = substr($query['page'], strlen('woocommerce-unzercw-'));
	
	$renderer = new UnzerCw_BackendFormRenderer();
	
	if ($container->hasBean('Customweb_Payment_BackendOperation_Form_IAdapter')) {
		$adapter = $container->getBean('Customweb_Payment_BackendOperation_Form_IAdapter');
		
		foreach ($adapter->getForms() as $form) {
			if ($form->getMachineName() == $formName) {
				$currentForm = $form;
				break;
			}
		}
		if ($currentForm === null) {
			if (isset($query['noheader'])) {
				require_once (ABSPATH . 'wp-admin/admin-header.php');
			}
			return;
		}
		
		if ($request->getMethod() == 'POST') {
			
			$pressedButton = null;
			$body = stripslashes_deep($request->getParsedBody());
			foreach ($form->getButtons() as $button) {
				
				if (array_key_exists($button->getMachineName(), $body['button'])) {
					$pressedButton = $button;
					break;
				}
			}
			$formData = array();
			foreach ($form->getElements() as $element) {
				$control = $element->getControl();
				if (!($control instanceof Customweb_Form_Control_IEditableControl)) {
					continue;
				}
				$dataValue = $control->getFormDataValue($body);
				if ($control instanceof Customweb_Form_Control_MultiControl) {
					foreach (woocommerce_unzercw_array_flatten($dataValue) as $key => $value) {
						$formData[$key] = $value;
					}
				}
				else {
					$nameAsArray = $control->getControlNameAsArray();
					if (count($nameAsArray) > 1) {
						$tmpArray = array(
							$nameAsArray[count($nameAsArray) - 1] => $dataValue 
						);
						$iterator = count($nameAsArray) - 2;
						while ($iterator > 0) {
							$tmpArray = array(
								$nameAsArray[$iterator] => $tmpArray 
							);
							$iterator--;
						}
						if (isset($formData[$nameAsArray[0]])) {
							$formData[$nameAsArray[0]] = array_merge_recursive($formData[$nameAsArray[0]], $tmpArray);
						}
						else {
							$formData[$nameAsArray[0]] = $tmpArray;
						}
					}
					else {
						$formData[$control->getControlName()] = $dataValue;
					}
				}
			}
			$adapter->processForm($currentForm, $pressedButton, $formData);
			wp_redirect(Customweb_Util_Url::appendParameters(get_admin_url(null,'admin.php'), $request->getParsedQuery()));
			die();
		}
		
		if (isset($query['noheader'])) {
			require_once (ABSPATH . 'wp-admin/admin-header.php');
		}
		
		$currentForm = null;
		foreach ($adapter->getForms() as $form) {
			if ($form->getMachineName() == $formName) {
				$currentForm = $form;
				break;
			}
		}
		
		if ($currentForm->isProcessable()) {
			$currentForm = new Customweb_Form($currentForm);
			$currentForm->setRequestMethod(Customweb_IForm::REQUEST_METHOD_POST);
			$currentForm->setTargetUrl(
					Customweb_Util_Url::appendParameters(get_admin_url(null,'admin.php'), 
							array_merge($request->getParsedQuery(), array(
								'noheader' => 'true' 
							))));
		}
		echo '<div class="wrap">';
		echo $renderer->renderForm($currentForm);
		echo '</div>';
	}
}

function woocommerce_unzercw_array_flatten($array){
	$return = array();
	foreach ($array as $key => $value) {
		if (is_array($value)) {
			$return = array_merge($return, woocommerce_unzercw_array_flatten($value));
		}
		else {
			$return[$key] = $value;
		}
	}
	return $return;
}

/**
 * Setup the configuration page with the callbacks to the configuration API.
 */
function woocommerce_unzercw_options(){
	if (!current_user_can('manage_woocommerce')) {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}
	
	if (false) {
		$reason = Customweb_Licensing_UnzerCw_License::getValidationErrorMessage();
		if ($reason === null) {
			$reason = 'Unknown error.';
		}
		$token = Customweb_Licensing_UnzerCw_License::getCurrentToken();
		echo '<div class="wrap">';
		echo '<h3>UnzerCw License Error</h3>';
		echo '<div style="border: 1px solid #ff0000; background: #ffcccc; font-weight: bold; padding: 5px;">' . __(
				'There is a problem with your license. Please contact us (www.sellxed.com/support). Reason: ' . $reason. ' Current Token: '.$token, 
				'woocommerce_unzercw') . '</div>';
		echo '</div>';
		return;
	}
	
	echo '<div class="wrap">';
	
	echo '<form method="post" action="options.php" enctype="multipart/form-data">';
	settings_fields('woocommerce-unzercw');
	do_settings_sections('woocommerce-unzercw');
	
	echo '<p class="submit">';
	echo '<input type="submit" name="submit" id="submit" class="button-primary" value="' . __('Save Changes') . '" />';
	echo '</p>';
	
	echo '</form>';
	echo '</div>';
}



/**
 * Register Settings
 */
function woocommerce_unzercw_admin_init(){
	add_settings_section('woocommerce_unzercw', 'Unzer Basics', 
			'woocommerce_unzercw_section_callback', 'woocommerce-unzercw');
	register_setting('woocommerce-unzercw', 'woocommerce_unzercw_operating_mode');
	
	add_settings_field('woocommerce_unzercw_operating_mode', __("Operation Mode", 'woocommerce_unzercw'), 'woocommerce_unzercw_option_callback_operating_mode', 'woocommerce-unzercw', 'woocommerce_unzercw');
	register_setting('woocommerce-unzercw', 'woocommerce_unzercw_public_key_live');
	
	add_settings_field('woocommerce_unzercw_public_key_live', __("Public Key (Live)", 'woocommerce_unzercw'), 'woocommerce_unzercw_option_callback_public_key_live', 'woocommerce-unzercw', 'woocommerce_unzercw');
	register_setting('woocommerce-unzercw', 'woocommerce_unzercw_private_key_live');
	
	add_settings_field('woocommerce_unzercw_private_key_live', __("Private Key (Live)", 'woocommerce_unzercw'), 'woocommerce_unzercw_option_callback_private_key_live', 'woocommerce-unzercw', 'woocommerce_unzercw');
	register_setting('woocommerce-unzercw', 'woocommerce_unzercw_public_key_test');
	
	add_settings_field('woocommerce_unzercw_public_key_test', __("Public Key (Test)", 'woocommerce_unzercw'), 'woocommerce_unzercw_option_callback_public_key_test', 'woocommerce-unzercw', 'woocommerce_unzercw');
	register_setting('woocommerce-unzercw', 'woocommerce_unzercw_private_key_test');
	
	add_settings_field('woocommerce_unzercw_private_key_test', __("Private Key (Test)", 'woocommerce_unzercw'), 'woocommerce_unzercw_option_callback_private_key_test', 'woocommerce-unzercw', 'woocommerce_unzercw');
	register_setting('woocommerce-unzercw', 'woocommerce_unzercw_order_id_schema');
	
	add_settings_field('woocommerce_unzercw_order_id_schema', __("OrderId Schema", 'woocommerce_unzercw'), 'woocommerce_unzercw_option_callback_order_id_schema', 'woocommerce-unzercw', 'woocommerce_unzercw');
	register_setting('woocommerce-unzercw', 'woocommerce_unzercw_payment_reference_schema');
	
	add_settings_field('woocommerce_unzercw_payment_reference_schema', __("PaymentReference Schema", 'woocommerce_unzercw'), 'woocommerce_unzercw_option_callback_payment_reference_schema', 'woocommerce-unzercw', 'woocommerce_unzercw');
	register_setting('woocommerce-unzercw', 'woocommerce_unzercw_invoice_id_schema');
	
	add_settings_field('woocommerce_unzercw_invoice_id_schema', __("InvoiceID Schema", 'woocommerce_unzercw'), 'woocommerce_unzercw_option_callback_invoice_id_schema', 'woocommerce-unzercw', 'woocommerce_unzercw');
	register_setting('woocommerce-unzercw', 'woocommerce_unzercw_review_input_form');
	
	add_settings_field('woocommerce_unzercw_review_input_form', __("Review Input Form", 'woocommerce_unzercw'), 'woocommerce_unzercw_option_callback_review_input_form', 'woocommerce-unzercw', 'woocommerce_unzercw');
	register_setting('woocommerce-unzercw', 'woocommerce_unzercw_order_identifier');
	
	add_settings_field('woocommerce_unzercw_order_identifier', __("Order Identifier", 'woocommerce_unzercw'), 'woocommerce_unzercw_option_callback_order_identifier', 'woocommerce-unzercw', 'woocommerce_unzercw');
	register_setting('woocommerce-unzercw', 'woocommerce_unzercw_log_level');
	
	add_settings_field('woocommerce_unzercw_log_level', __("Log Level", 'woocommerce_unzercw'), 'woocommerce_unzercw_option_callback_log_level', 'woocommerce-unzercw', 'woocommerce_unzercw');
	
}
add_action('admin_init', 'woocommerce_unzercw_admin_init');

function woocommerce_unzercw_section_callback(){}



function woocommerce_unzercw_option_callback_operating_mode() {
	echo '<select name="woocommerce_unzercw_operating_mode">';
		echo '<option value="test"';
		 if (get_option('woocommerce_unzercw_operating_mode', "test") == "test"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Test", 'woocommerce_unzercw'). '</option>';
	echo '<option value="live"';
		 if (get_option('woocommerce_unzercw_operating_mode', "test") == "live"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Live", 'woocommerce_unzercw'). '</option>';
	echo '</select>';
	echo '<br />';
	echo __("Operation mode of the shop.", 'woocommerce_unzercw');
}

function woocommerce_unzercw_option_callback_public_key_live() {
	echo '<input type="text" name="woocommerce_unzercw_public_key_live" value="' . htmlspecialchars(get_option('woocommerce_unzercw_public_key_live', ''),ENT_QUOTES) . '" />';
	
	echo '<br />';
	echo __("Public Key for live requests, provided by Unzer.", 'woocommerce_unzercw');
}

function woocommerce_unzercw_option_callback_private_key_live() {
	echo '<input type="text" name="woocommerce_unzercw_private_key_live" value="' . htmlspecialchars(get_option('woocommerce_unzercw_private_key_live', ''),ENT_QUOTES) . '" />';
	
	echo '<br />';
	echo __("Private Key for live requests, provided by Unzer.", 'woocommerce_unzercw');
}

function woocommerce_unzercw_option_callback_public_key_test() {
	echo '<input type="text" name="woocommerce_unzercw_public_key_test" value="' . htmlspecialchars(get_option('woocommerce_unzercw_public_key_test', ''),ENT_QUOTES) . '" />';
	
	echo '<br />';
	echo __("Public Key for test requests, provided by Unzer.", 'woocommerce_unzercw');
}

function woocommerce_unzercw_option_callback_private_key_test() {
	echo '<input type="text" name="woocommerce_unzercw_private_key_test" value="' . htmlspecialchars(get_option('woocommerce_unzercw_private_key_test', ''),ENT_QUOTES) . '" />';
	
	echo '<br />';
	echo __("Private Key for test requests, provided by Unzer.", 'woocommerce_unzercw');
}

function woocommerce_unzercw_option_callback_order_id_schema() {
	echo '<input type="text" name="woocommerce_unzercw_order_id_schema" value="' . htmlspecialchars(get_option('woocommerce_unzercw_order_id_schema', '{id}'),ENT_QUOTES) . '" />';
	
	echo '<br />';
	echo __("Here you can set a schema for the orderId parameter transmitted to identify the payment. If left empty it is not transmitted. The following placeholders can be used: {oid} for the order id, which may not be unique or set; {tid} for the sellxed transaction id which is a unique number, or {id} which contains the order id and is guaranteed to be unique.", 'woocommerce_unzercw');
}

function woocommerce_unzercw_option_callback_payment_reference_schema() {
	echo '<input type="text" name="woocommerce_unzercw_payment_reference_schema" value="' . htmlspecialchars(get_option('woocommerce_unzercw_payment_reference_schema', '{id}'),ENT_QUOTES) . '" />';
	
	echo '<br />';
	echo __("Here you can set a schema for the paymentReference parameter transmitted to identify the payment. If left empty it is not transmitted. The following placeholders can be used: {oid} for the order id, which may not be unique or set; {tid} for the sellxed transaction id which is a unique number, or {id} which contains the order id and is guaranteed to be unique.", 'woocommerce_unzercw');
}

function woocommerce_unzercw_option_callback_invoice_id_schema() {
	echo '<input type="text" name="woocommerce_unzercw_invoice_id_schema" value="' . htmlspecialchars(get_option('woocommerce_unzercw_invoice_id_schema', '{id}'),ENT_QUOTES) . '" />';
	
	echo '<br />';
	echo __("Here you can set a schema for the invoiceId parameter transmitted to identify the payment. If left empty it is not transmitted. The following placeholders can be used: {oid} for the order id, which may not be unique or set; {tid} for the sellxed transaction id which is a unique number, or {id} which contains the order id and is guaranteed to be unique.", 'woocommerce_unzercw');
}

function woocommerce_unzercw_option_callback_review_input_form() {
	echo '<select name="woocommerce_unzercw_review_input_form">';
		echo '<option value="active"';
		 if (get_option('woocommerce_unzercw_review_input_form', "active") == "active"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Activate input form in review pane.", 'woocommerce_unzercw'). '</option>';
	echo '<option value="deactivate"';
		 if (get_option('woocommerce_unzercw_review_input_form', "active") == "deactivate"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Deactivate input form in review pane.", 'woocommerce_unzercw'). '</option>';
	echo '</select>';
	echo '<br />';
	echo __("Should the input form for credit card data rendered in the review pane? To work the user must have JavaScript activated. In case the browser does not support JavaScript a fallback is provided. This feature is not supported by all payment methods.", 'woocommerce_unzercw');
}

function woocommerce_unzercw_option_callback_order_identifier() {
	echo '<select name="woocommerce_unzercw_order_identifier">';
		echo '<option value="postid"';
		 if (get_option('woocommerce_unzercw_order_identifier', "ordernumber") == "postid"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Post ID of the order", 'woocommerce_unzercw'). '</option>';
	echo '<option value="ordernumber"';
		 if (get_option('woocommerce_unzercw_order_identifier', "ordernumber") == "ordernumber"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Order number", 'woocommerce_unzercw'). '</option>';
	echo '</select>';
	echo '<br />';
	echo __("Set which identifier should be sent to the payment service provider. If a plugin modifies the order number and can not guarantee it's uniqueness, select Post Id.", 'woocommerce_unzercw');
}

function woocommerce_unzercw_option_callback_log_level() {
	echo '<select name="woocommerce_unzercw_log_level">';
		echo '<option value="error"';
		 if (get_option('woocommerce_unzercw_log_level', "error") == "error"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Error", 'woocommerce_unzercw'). '</option>';
	echo '<option value="info"';
		 if (get_option('woocommerce_unzercw_log_level', "error") == "info"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Info", 'woocommerce_unzercw'). '</option>';
	echo '<option value="debug"';
		 if (get_option('woocommerce_unzercw_log_level', "error") == "debug"){
			echo ' selected="selected" ';
		}
	echo '>' . __("Debug", 'woocommerce_unzercw'). '</option>';
	echo '</select>';
	echo '<br />';
	echo __("Messages of this or a higher level will be logged.", 'woocommerce_unzercw');
}

