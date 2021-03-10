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

// Make sure we don't expose any info if called directly 
if (!function_exists('add_action')) {
	echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
	exit();
}

require_once dirname(__FILE__) . '/lib/loader.php';
require_once 'classes/UnzerCw/Util.php';

require_once 'UnzerCw/Util.php';
require_once 'Customweb/Util/Url.php';
require_once 'Customweb/Core/Util/Xml.php';



// Get all general wordpress settings functionality
require_once plugin_dir_path(__FILE__) . 'settings.php';


function woocommerce_unzercw_meta_boxes(){
	global $post;
	if ($post->post_type != 'shop_order') {
		return;
	}
	$transactions = array();
	try{
		$transactions = UnzerCw_Util::getTransactionsByPostId($post->ID);
	}
	catch(Exception $e){
		//Ignore
	}
	if (count($transactions) > 0) {
		add_meta_box('woocommerce-unzercw-information', 
				__('Unzer Transactions', 'woocommerce_unzercw'), 
				'woocommerce_unzercw_transactions', 'shop_order', 'normal', 'default');
	}
}
add_action('add_meta_boxes', 'woocommerce_unzercw_meta_boxes');

function woocommerce_unzercw_transactions($post){
	$transactions = UnzerCw_Util::getTransactionsByPostId($post->ID);

	echo '<table class="wp-list-table widefat table unzercw-transaction-table">';
	echo '<thead><tr>';
	echo '<th>#</th>';
	echo '<th>' . __('Transaction Number', 'woocommerce_unzercw') . '</th>';
	echo '<th>' . __('Date', 'woocommerce_unzercw') . '</th>';
	echo '<th>' . __('Payment Method', 'woocommerce_unzercw') . '</th>';
	echo '<th>' . __('Is Authorized', 'woocommerce_unzercw') . '</th>';
	echo '<th>' . __('Amount', 'woocommerce_unzercw') . '</th>';
	echo '<th>&nbsp;</th>';
	echo '</tr></thead>';
	
	foreach ($transactions as $transaction) {
		echo '<tr class="unzercw-main-row"  id="unzercw-main_row_' . $transaction->getTransactionId() . '">';
		echo '<td>' . $transaction->getTransactionId() . '</td>';
		echo '<td>' . $transaction->getTransactionExternalId() . '</td>';
		echo '<td>' . $transaction->getCreatedOn()->format("Y-m-d H:i:s") . '</td>';
		echo '<td>';
		if ($transaction->getTransactionObject() != null) {
			echo $transaction->getTransactionObject()->getPaymentMethod()->getPaymentMethodDisplayName();
		}
		else {
			echo '--';
		}
		echo '</td>';
		echo '<td>';
		if ($transaction->getTransactionObject() != null && $transaction->getTransactionObject()->isAuthorized()) {
			echo __('Yes');
		}
		else {
			echo __('No');
		}
		echo '</td>';
		echo '<td>';
		if ($transaction->getTransactionObject() != null) {
			echo number_format($transaction->getTransactionObject()->getAuthorizationAmount(), 2);
		}
		else {
			echo '--';
		}
		echo '</td>';
		echo '<td>
				<a class="unzercw-more-details-button button">' . __('More Details', 'woocommerce_unzercw') . '</a>
				<a class="unzercw-less-details-button button">' . __('Less Details', 'woocommerce_unzercw') . '</a>
			</td>';
		echo '</tr>';
		echo '<tr class="unzercw-details-row" id="unzercw_details_row_' . $transaction->getTransactionId() . '">';
		echo '<td colspan="7">';
		echo '<div class="unzercw-box-labels">';
		if ($transaction->getTransactionObject() !== null) {
			foreach ($transaction->getTransactionObject()->getTransactionLabels() as $label) {
				echo '<div class="label-box">';
				echo '<div class="label-title">' . $label['label'] . ' ';
				if (isset($label['description']) && !empty($label['description'])) {
					echo woocommerce_unzercw_get_help_box($label['description']);
				}
				echo '</div>';
				echo '<div class="label-value">' . Customweb_Core_Util_Xml::escape($label['value']) . '</div>';
				echo '</div>';
			}
		}
		else {
			echo __("No more details available.", 'woocommerce_unzercw');
		}
		echo '</div>';
		
		if ($transaction->getTransactionObject() !== null && $transaction->getTransactionObject()->isAuthorized()) {
			$instructions = trim($transaction->getTransactionObject()->getPaymentInformation());
			if(!empty($instructions)){
				echo '<div class="unzercw-payment-information">';
				echo '<b>'.__('Payment Information', 'woocommerce_unzercw').'</b><br />';
				echo $instructions;
				echo '</div>';
			}
		}
		
		if ($transaction->getTransactionObject() !== null) {
			
			
			
			if ($transaction->getTransactionObject()->isCapturePossible()) {
				
				$url = Customweb_Util_Url::appendParameters(get_admin_url() . 'admin.php', 
						array(
							'page' => 'woocommerce-unzercw_capture',
							'cwTransactionId' => $transaction->getTransactionId(),
							'noheader' => 'true' 
						));
				echo '<p><a href="' . $url . '" class="button">Capture</a></p>';
				echo '</div>';
			}
			
			
			if ($transaction->getTransactionObject()->isCancelPossible()) {
				echo '<div class="cancel-box box">';
				$url = Customweb_Util_Url::appendParameters(get_admin_url() . 'admin.php', 
						array(
							'page' => 'woocommerce-unzercw_cancel',
							'cwTransactionId' => $transaction->getTransactionId(),
							'noheader' => 'true' 
						));
				echo '<p><a href="' . $url . '" class="button">Cancel</a></p>';
				echo '</div>';
			}
			
			
									
			if ($transaction->getTransactionObject()->isRefundPossible()) {
				echo '<div class="refund-box box">';
				$url = Customweb_Util_Url::appendParameters(get_admin_url() . 'admin.php', 
						array(
							'page' => 'woocommerce-unzercw_refund',
							'cwTransactionId' => $transaction->getTransactionId(),
							'noheader' => 'true' 
						));
				echo '<p><a href="' . $url . '" class="button">Refund</a></p>';
				echo '</div>';
			}
			
			

			
			if (count($transaction->getTransactionObject()->getCaptures())) {
				echo '<div class="capture-history-box box">';
				echo '<h4>' . __('Captures', 'woocommerce_unzercw') . '</h4>';
				echo '<table class="table" cellpadding="0" cellspacing="0" width="100%">';
				echo '<thead>';
				echo '<tr>';
				echo '<th>' . __('Date', 'woocommerce_unzercw') . '</th>';
				echo '<th>' . __('Amount', 'woocommerce_unzercw') . '</th>';
				echo '<th>' . __('Status', 'woocommerce_unzercw') . '</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
				foreach ($transaction->getTransactionObject()->getCaptures() as $capture) {
					echo '<tr>';
					echo '<td>' . $capture->getCaptureDate()->format("Y-m-d H:i:s") . '</td>';
					echo '<td>' . $capture->getAmount() . '</td>';
					echo '<td>' . $capture->getStatus() . '</td>';
					echo '</tr>';
				}
				echo '</tbody>';
				echo '</table>';
				echo '</div>';
			}
			
			

			
			if (count($transaction->getTransactionObject()->getRefunds())) {
				echo '<div class="refund-history-box box">';
				echo '<h4>' . __('Refunds', 'woocommerce_unzercw') . '</h4>';
				echo '<table class="table" cellpadding="0" cellspacing="0" width="100%">';
				echo '<thead>';
				echo '<tr>';
				echo '<th>' . __('Date', 'woocommerce_unzercw') . '</th>';
				echo '<th>' . __('Amount', 'woocommerce_unzercw') . '</th>';
				echo '<th>' . __('Status', 'woocommerce_unzercw') . '</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
				foreach ($transaction->getTransactionObject()->getRefunds() as $refund) {
					echo '<tr>';
					echo '<td>' . $refund->getRefundedDate()->format("Y-m-d H:i:s") . '</td>';
					echo '<td>' . $refund->getAmount() . '</td>';
					echo '<td>' . $refund->getStatus() . '</td>';
					echo '</tr>';
				}
				echo '</tbody>';
				echo '</table>';
				echo '</div>';
			}
			
			

			if (count($transaction->getTransactionObject()->getHistoryItems())) {
				echo '<div class="previous-actions box">';
				echo '<h4>' . __('Previous Actions', 'woocommerce_unzercw') . '</h4>';
				echo '<table class="table" cellpadding="0" cellspacing="0" width="100%">';
				echo '<thead>';
				echo '<tr>';
				echo '<th>' . __('Date', 'woocommerce_unzercw') . '</th>';
				echo '<th>' . __('Action', 'woocommerce_unzercw') . '</th>';
				echo '<th>' . __('Message', 'woocommerce_unzercw') . '</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
				foreach ($transaction->getTransactionObject()->getHistoryItems() as $historyItem) {
					echo '<tr>';
					echo '<td>' . $historyItem->getCreationDate()->format("Y-m-d H:i:s") . '</td>';
					echo '<td>' . $historyItem->getActionPerformed() . '</td>';
					echo '<td>' . $historyItem->getMessage() . '</td>';
					echo '</tr>';
				}
				echo '</tbody>';
				echo '</table>';
				echo '</div>';
			}
		}
		echo '</td>';
		echo '</tr>';
	}
	echo '</table>';
	
}

function woocommerce_unzercw_get_help_box($text){
	return '<img class="help_tip" data-tip="' . $text . '" src="' . UnzerCw_Util::getResourcesUrl('image/help.png') . '" height="16" width="16" />';
}

