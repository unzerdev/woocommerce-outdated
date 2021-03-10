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
UnzerCw_Util::bootstrap();

require_once 'UnzerCw/Database/LinkAccessor.php';
require_once 'UnzerCw/EntityManager.php';
require_once 'Customweb/Database/Driver/MySQL/Driver.php';
require_once 'Customweb/DependencyInjection/Container/Default.php';
require_once 'Customweb/Asset/Resolver/Composite.php';
require_once 'UnzerCw/ContextCleanUpBean.php';
require_once 'UnzerCw/ContextRequest.php';
require_once 'Customweb/Cache/Backend/Memory.php';
require_once 'Customweb/Asset/Resolver/Simple.php';
require_once 'UnzerCw/TransactionCleanUpBean.php';
require_once 'UnzerCw/Util.php';
require_once 'Customweb/Core/Url.php';
require_once 'UnzerCw/Entity/PaymentCustomerContext.php';
require_once 'UnzerCw/LayoutRenderer.php';
require_once 'Customweb/Payment/Authorization/DefaultPaymentCustomerContext.php';
require_once 'Customweb/Database/Driver/MySQLi/Driver.php';
require_once 'Customweb/Core/DateTime.php';
require_once 'Customweb/DependencyInjection/Bean/Provider/Annotation.php';
require_once 'Customweb/Database/Migration/Manager.php';
require_once 'Customweb/DependencyInjection/Bean/Provider/Editable.php';
require_once 'Customweb/Storage/Backend/Database.php';
require_once 'UnzerCw/ConfigurationAdapter.php';
require_once 'Customweb/Payment/Authorization/IAdapterFactory.php';

class UnzerCw_Util {

	private function __construct(){}
	private static $methods = array();
	private static $basePath = null;
	private static $container = null;
	private static $entityManager = null;
	private static $driver = null;
	private static $paymentCustomerContexts = array();


	public static function bootstrap(){
		set_include_path(
				implode(PATH_SEPARATOR, 
						array(
							get_include_path(),
							realpath(dirname(__FILE__)),
							realpath(dirname(dirname(__FILE__))) 
						)));
		require_once dirname(dirname(dirname(__FILE__))) . '/lib/loader.php';
		add_action('switch_blog', array(__CLASS__, 'switch_blog_reset'), 10, 2);
	}
	
	/**
	 * Reset static instances and cache
	 */
	public static function switch_blog_reset($newBlog, $oldId){
		self::$container = null;
		self::$entityManager = null;
		self::$driver = null;
		$cache = new Customweb_Cache_Backend_Memory();
		$cache->clear();
	}

	/**
	 * This method returns the base path to the plugin.
	 *
	 * @return string Base Path
	 */
	public static function getBasePath(){
		if (self::$basePath === null) {
			self::$basePath = dirname(dirname(dirname(__FILE__)));
		}
		return self::$basePath;
	}

	public static function addPaymentMethods($gateways = array()){
		$methods = self::getPaymentMethods();
		foreach ($methods as $class_name) {
			$gateways[] = $class_name;
		}
		return $gateways;
	}

	public static function getPaymentMethods($includeClass = true){
		if (count(self::$methods) <= 0) {
			if ($handle = opendir(self::getBasePath() . '/payment_methods')) {
				while (false !== ($file = readdir($handle))) {
					if (!is_dir(self::getBasePath() . '/' . $file) && $file !== '.' && $file !== '..' && substr($file, -4, 4) == '.php') {
						$class_name = substr($file, 0, -4);
						self::$methods[] = $class_name;
					}
				}
				closedir($handle);
			}
		}		
		if ($includeClass) {
			foreach (self::$methods as $method) {
				self::includePaymentMethod($method);
			}
		}
		return self::$methods;
	}

	public static function includePaymentMethod($methodClassName){
		$methodClassName = strip_tags($methodClassName);
		if (!class_exists($methodClassName)) {
			$fileName = self::getBasePath() . '/payment_methods/' . $methodClassName . '.php';
			if (!file_exists($fileName)) {
				throw new Exception(
						"The payment method class could not be included, because it was not found. Payment Method Name: '" . $methodClassName .
								 "' File Path: " . $fileName);
			}
			require_once $fileName;
		}
	}

	/**
	 *
	 * @param string $methodClassName
	 * @return UnzerCw_PaymentMethod
	 */
	public static function getPaymentMehtodInstance($methodClassName){
		self::includePaymentMethod($methodClassName);
		return new $methodClassName();
	}

	public static function getPluginUrl($controller, array $params = array(), $action = null){
		
		if (isset($_REQUEST['woo-unzercw-lang'])) {
			$params['woo-unzercw-lang'] = $_REQUEST['woo-unzercw-lang'];
		}		
		else if (defined('ICL_LANGUAGE_CODE')) {
			$params['woo-unzercw-lang'] = ICL_LANGUAGE_CODE;
		}
		else {
			$tmpLang = apply_filters( 'wpml_current_language', '' );
			if(!empty($tmpLang)){
				$params['woo-unzercw-lang'] = $tmpLang;
			}
		}
		$params['cwcontroller'] = $controller;
		if (!empty($action)) {
			$params['cwaction'] = $action;
		}
		$urlString = get_permalink(get_option('woocommerce_unzercw_page'));
		if(isset($params['woo-unzercw-lang'])){
			$urlString = apply_filters('wpml_permalink', $urlString, $params['woo-unzercw-lang']);
		}
		$url = new Customweb_Core_Url($urlString);
		$shopForceSSLCheckout = self::getShopOption('woocommerce_force_ssl_checkout');
		if (($shopForceSSLCheckout == 'yes' || $shopForceSSLCheckout == 'true') && is_checkout()) {
			$url->setScheme('https')->setPort(443);
		}
		$url->appendQueryParameters($params);
		$complete = $url->toString();		
		return apply_filters('woocommerce_unzercw_plugin_url', $complete, $url->getBaseUrl() . $url->getPath(), 
				$url->getQueryAsArray());
	}

	public static function getResourcesUrl($path){
		return plugins_url(null, dirname(dirname(__FILE__))) . '/resources/' . $path;
	}

	public static function getPermalinkIdModified($id){
		$language = get_bloginfo('language');
		if (isset($_REQUEST['woo-unzercw-lang'])) {
			$language = $_REQUEST['woo-unzercw-lang'];
		}
		else if (defined('ICL_LANGUAGE_CODE')) {
			$language = ICL_LANGUAGE_CODE;
		}
		else {
			$tmpLang = apply_filters( 'wpml_current_language', '' );
			if(!empty($tmpLang)){
				$language = $tmpLang;
			}
		}
		$id = apply_filters('wpml_object_id', $id, 'page', true, $language);
		return $id;
	}
	
	/**
	 * Checks if the system requirements are met
	 *
	 * calls wp_die f requirements not met
	 */
	private static function checkRequirements() {
		require_once( ABSPATH . '/wp-admin/includes/plugin.php' ) ;
		
		$errors = array();
	
		if (!is_plugin_active('woocommerce/woocommerce.php')){
			$errors[] = sprintf(__("Woocommerce has to be active.", "woocommerce_unzercw"));
		}
		else{
			$woocommerce_data = get_plugin_data(WP_PLUGIN_DIR .'/woocommerce/woocommerce.php', false, false);			
			if (version_compare ($woocommerce_data['Version'] , '3.0.0', '<')){
				$errors[] = sprintf(__("Woocommerce %s+ is required. (You're running version %s)", "woocommerce_unzercw"), '3.0.0', $woocommerce_data['Version']);
			}
		}		
		if(!empty($errors)){
			$title = __('Could not activate plugin WooCommerce UnzerCw', 'woocommerce_unzercw');
			$message = '<h1><strong>'.$title.'</strong></h1><br/>'.
					'<h3>'.__('Please check the following requirements before activating:', 'woocommerce_unzercw').'</h3>'.
					'<ul><li>'.
					implode('</li><li>', $errors).
					'</li></ul>';
					wp_die($message, $title, array('back_link' => true));
					return;
		}
	}

	public static function installPlugin(){
		self::checkRequirements();
		global $wpdb;
		$manager = new Customweb_Database_Migration_Manager(self::getDriver(), dirname(__FILE__) . '/Migration/', 
				$wpdb->prefix . 'woocommerce_unzercw_schema_version');
		$manager->migrate();
		
		//Create Page
		$optionValue = get_option('woocommerce_unzercw_page');
		$pageContent = '[woocommerce_unzercw]';
		$pageSlug = 'woo_unzercw';
		$pageTitle = 'Unzer Checkout';
		
		if ($optionValue > 0) {
			$pageObject = get_post($optionValue);
			if ('page' === $pageObject->post_type && $pageObject->post_status == 'publish') {
				// Valid page is already in place
				return;
			}
			else if ('page' === $pageObject->post_type && $pageObject->post_status != 'publish') {
				//Page available in false state
				$pageId = $optionValue;
				$pageData = array(
					'ID' => $pageId,
					'post_status' => 'publish' 
				);
				remove_action('pre_post_update', 'wp_save_post_revision');
				wp_update_post($pageData);
				add_action('pre_post_update', 'wp_save_post_revision');
				return;
			}
		}
		
		$pageData = array(
			'post_status' => 'publish',
			'post_type' => 'page',
			'post_name' => $pageSlug,
			'post_title' => $pageTitle,
			'post_content' => $pageContent,
			'comment_status' => 'closed' 
		);
		$pageId = wp_insert_post($pageData);
		
		update_option('woocommerce_unzercw_page', $pageId);
	}

	public static function uninstallPlugin(){
		$optionValue = get_option('woocommerce_unzercw_page');
		if ($optionValue) {
			wp_trash_post($optionValue);
		}
	}

	public static function includeTemplateFile($templateName, $variables = array()){
		if (empty($templateName)) {
			throw new Exception("The given template name is empty.");
		}
		$templateName = 'unzercw_' . $templateName;
		$templatesCandidates = array(
			$templateName . '.php' 
		);
		$templatePath = locate_template($templatesCandidates, false, false);
		extract($variables);
		if (!empty($templatePath)) {
			require_once $templatePath;
		}
		else {
			require_once self::getBasePath() . '/theme/' . $templateName . '.php';
		}
	}

	/**
	 * This action is executed, when the form is rendered.
	 *
	 * @param WC_Checkout $checkout
	 */
	public static function actionBeforeCheckoutBillingForm(WC_Checkout $checkout){
		if (UnzerCw_ConfigurationAdapter::isReviewFormInputActive()) {
			$fieldsToForceUpdate = array(
				'billing_first_name',
				'billing_last_name',
				'billing_company',
				'billing_email',
				'billing_phone' 
			);
			if(property_exists($checkout, 'checkout_fields')){
				$checkout->checkout_fields['billing'] = self::addCssClassToForceAjaxReload($checkout->checkout_fields['billing'], $fieldsToForceUpdate);
			}
		}
	}

	/**
	 * This action is executed, when the form is rendered.
	 *
	 * @param WC_Checkout $checkout
	 */
	public static function actionBeforeCheckoutShippingForm(WC_Checkout $checkout){
		if (UnzerCw_ConfigurationAdapter::isReviewFormInputActive()) {
			$fieldsToForceUpdate = array(
				'shipping_first_name',
				'shipping_last_name',
				'shipping_company' 
			);
			if(property_exists($checkout, 'checkout_fields')){
				$checkout->checkout_fields['shipping'] = self::addCssClassToForceAjaxReload($checkout->checkout_fields['shipping'], $fieldsToForceUpdate);
			}
		}
	}

	private static function addCssClassToForceAjaxReload($fields, $forceFields){
		foreach ($fields as $key => $data) {
			if (in_array($key, $forceFields)) {
				if (isset($data['class']) && is_array($data['class']) && !in_array('address-field', $data['class'])) {
					$fields[$key]['class'][] = 'address-field';
				}
			}
		}
		
		return $fields;
	}

	/**
	 *
	 * @return Customweb_DependencyInjection_Container_Default
	 */
	public static function createContainer(){
		if (self::$container === null) {
			$packages = array(
			0 => 'Customweb_Unzer',
 			1 => 'Customweb_Payment_Authorization',
 		);
			$packages[] = 'UnzerCw_';
			$packages[] = 'Customweb_Mvc_Template_Php_Renderer';
			$packages[] = 'Customweb_Payment_Update_ContainerHandler';
			$packages[] = 'Customweb_Payment_TransactionHandler';
			$packages[] = 'Customweb_Payment_SettingHandler';
			$provider = new Customweb_DependencyInjection_Bean_Provider_Editable(new Customweb_DependencyInjection_Bean_Provider_Annotation($packages));
			// @formatter:off
			$storage = new Customweb_Storage_Backend_Database(self::getEntityManager(), self::getDriver(), 'UnzerCw_Entity_Storage');
			$provider->addObject(UnzerCw_ContextRequest::getInstance())
				->addObject(self::getEntityManager())
				->addObject(self::getDriver())
				->addObject(new UnzerCw_LayoutRenderer())
				->addObject(new Customweb_Cache_Backend_Memory())
				->add('databaseTransactionClassName', 'UnzerCw_Entity_Transaction')
				->addObject(self::getAssetResolver())
				->addObject($storage)
				->addObject(new UnzerCw_ContextCleanUpBean(self::getEntityManager()))
				->addObject(new UnzerCw_TransactionCleanUpBean(self::getEntityManager()));
			// @formatter:om
			self::$container = new Customweb_DependencyInjection_Container_Default($provider);
		}		
		return self::$container;
	}

	/**
	 *
	 * @return Customweb_Database_Entity_Manager
	 */
	public static function getEntityManager(){
		if (self::$entityManager === null) {
			$cache = new Customweb_Cache_Backend_Memory();
			self::$entityManager = new UnzerCw_EntityManager(self::getDriver(), $cache);
		}
		return self::$entityManager;
	}
	
	
	/**
	 * 
	 * @return Customweb_Payment_ITransactionHandler
	 */
	public static function getTransactionHandler(){
		$container = self::createContainer();
		$handler = $container->getBean('Customweb_Payment_ITransactionHandler');
		return $handler;		
	}

	public static function getAssetResolver(){
		$simple = array();
		$simple[] = new Customweb_Asset_Resolver_Simple(get_template_directory(). '/woocommerce_unzercw/', null,
				array(
					'application/x-phtml'
				));
		$simple[] = new Customweb_Asset_Resolver_Simple(self::getBasePath() . '/assets/', null, 
				array(
					'application/x-phtml' 
				));
		$simple[] = new Customweb_Asset_Resolver_Simple(get_template_directory(). '/woocommerce_unzercw/', get_stylesheet_directory_uri() . '/woocommerce_unzercw/');
		$simple[] = new Customweb_Asset_Resolver_Simple(self::getBasePath() . '/assets/', plugins_url(null, dirname(dirname(__FILE__))) . '/assets/');
		return new Customweb_Asset_Resolver_Composite($simple);
	}

	/**
	 *
	 * @return Customweb_Database_IDriver
	 */
	public static function getDriver(){
		if (self::$driver === null) {
			global $wpdb;
			$link = UnzerCw_Database_LinkAccessor::getUnzerCwLink($wpdb);
			if( $link instanceof mysqli){
				self::$driver = new Customweb_Database_Driver_MySQLi_Driver($link);
			}
			else{
				self::$driver = new Customweb_Database_Driver_MySQL_Driver($link);
			}
		}
		return self::$driver;
	}

	private static function getAuthorizationAdapterFactory(){
		$container = self::createContainer();
		$factory = $container->getBean('Customweb_Payment_Authorization_IAdapterFactory');		
		if (!($factory instanceof Customweb_Payment_Authorization_IAdapterFactory)) {
			throw new Exception("The payment api has to provide a class which implements 'Customweb_Payment_Authorization_IAdapterFactory' as a bean.");
		}
		
		return $factory;
	}

	public static function getAuthorizationAdapter($authorizationMethodName){
		return self::getAuthorizationAdapterFactory()->getAuthorizationAdapterByName($authorizationMethodName);
	}

	public static function getAuthorizationAdapterByContext(Customweb_Payment_Authorization_IOrderContext $orderContext){
		return self::getAuthorizationAdapterFactory()->getAuthorizationAdapterByContext($orderContext);
	}


	/**
	 *
	 * @param int $customerId
	 * @return Customweb_Payment_Authorization_IPaymentCustomerContext
	 */
	public static function getPaymentCustomerContext($customerId){
		// Handle guest context. This context is not stored.
		if ($customerId === null || $customerId == 0) {
			if (!isset(self::$paymentCustomerContexts['guestContext'])) {
				self::$paymentCustomerContexts['guestContext'] = new Customweb_Payment_Authorization_DefaultPaymentCustomerContext(array());
			}
			
			return self::$paymentCustomerContexts['guestContext'];
		}
		if (!isset(self::$paymentCustomerContexts[$customerId])) {
			$entities = self::getEntityManager()->searchByFilterName('UnzerCw_Entity_PaymentCustomerContext', 'loadByCustomerId', 
					array(
						'>customerId' => $customerId 
					));
			if (count($entities) > 0) {
				self::$paymentCustomerContexts[$customerId] = current($entities);
			}
			else {
				$context = new UnzerCw_Entity_PaymentCustomerContext();
				$context->setCustomerId($customerId);
				self::$paymentCustomerContexts[$customerId] = $context;
			}
		}
		return self::$paymentCustomerContexts[$customerId];
	}

	public static function persistPaymentCustomerContext(Customweb_Payment_Authorization_IPaymentCustomerContext $context){
		if ($context instanceof UnzerCw_Entity_PaymentCustomerContext) {
			$storedContext = self::getEntityManager()->persist($context);
			self::$paymentCustomerContexts[$storedContext->getCustomerId()] = $storedContext;
		}
	}

	/**
	 * This function has to echo the additional payment information received from the transaction object.
	 * This function has to check if the order was paid with this module.
	 *
	 * @param int $orderId woocommerce orderId
	 * @return void
	 */
	public static function thankYouPageHtml($orderId){
		$transaction = self::getAuthorizedTransactionByPostId($orderId);
		if($transaction == null){
			return;
		}
		$transactionObject = $transaction->getTransactionObject();
		$paymentInformation = trim($transactionObject->getPaymentInformation());
		if (!empty($paymentInformation)) {
			echo '<div class="woocommerce_unzercw-payment-information" id="woocommerce_unzercw-payment-information">';
			echo "<h2>" . __('Payment Information', 'woocommerce_unzercw') . "</h2>";
			echo $paymentInformation;
			echo '</div>';
		}
	}
	
	/**
	 * This function has to echo the additional payment information received from the transaction object.
	 * This function has to check if the order was paid with this module.
	 *
	 * @param WC_Order $order
	 * @param boolean $sent_to_admin
	 * @param boolean $plain_text
	 * @return void
	 */
	public static function orderEmailHtml($order, $sent_to_admin, $plain_text = false){		
		$transactionObject = null;
		$orderId = $order->get_id();
		$transaction = self::getAuthorizedTransactionByPostId($orderId);
		if($transaction == null){
			return;
		}
		$transactionObject = $transaction->getTransactionObject();
		$paymentInformation = trim($transactionObject->getPaymentInformation());		
		if(!empty($paymentInformation)) {
			echo '<div class="woocommerce_unzercw-email-payment-information" id="woocommerce_unzercw-email-payment-information">';
			echo "<h2>" . __('Payment Information', 'woocommerce_unzercw') . "</h2>";
			echo $paymentInformation;
			echo '</div>';
		}
	}
	
	/**
	 * Returns the transaction specified by the transactionId
	 *
	 * @param integer $id The transaction Id
	 * @param boolean $cache load from cache
	 * @return UnzerCw_Entity_Transaction The matching transactions for the given transaction id
	 */
	public static function getTransactionById($id, $cache = true){
		return self::getEntityManager()->fetch('UnzerCw_Entity_Transaction', $id, $cache);
	}

	/**
	 * Returns the transaction specified by the transaction number (externalId)
	 *
	 * @param integer $number The transactionNumber
	 * @param boolean $cache load from cache
	 * @return UnzerCw_Entity_Transaction The matching transactions for the given transactionNumber
	 */
	public static function getTransactionByTransactionNumber($number, $cache = true){
		$transactions = self::getEntityManager()->searchByFilterName('UnzerCw_Entity_Transaction', 'loadByExternalId', 
				array(
					'>transactionExternalId' => $number 
				), $cache);
		if (empty($transactions)) {
			throw new Exception("No transaction found, for the given transaction number: " . $number);
		}
		return reset($transactions);
	}

	/**
	 * Return all transactions given by the order id
	 *
	 * @param integer $orderId The id of the order
	 * @param boolean $cache load from cache
	 * @return UnzerCw_Entity_Transaction[] The matching transactions for the given order id
	 */
	public static function getTransactionsByOrderId($orderId, $cache = true){
		self::getPaymentMethods(true);
		return self::getEntityManager()->searchByFilterName('UnzerCw_Entity_Transaction', 'loadByOrderId', 
				array(
					'>orderId' => $orderId 
				), $cache);
	}
	
	public static function getTransactionsByPostId($postId, $cache = true){
		self::getPaymentMethods(true);
		return self::getEntityManager()->searchByFilterName('UnzerCw_Entity_Transaction', 'loadByPostId',
				array(
					'>postId' => $postId
				), $cache);
	}
	
	public static function getAuthorizedTransactionByPostId($postId){
		$transactions = self::getTransactionsByPostId($postId);
		foreach ($transactions as $transaction) {
			if ($transaction->getTransactionObject() != null && $transaction->getTransactionObject()->isAuthorized()) {
				return $transaction;
			}
		}
		return null;
	}

	public static function getAliasTransactions($userId, $paymentMethod){
		if (empty($userId)) {
			return array();
		}		
		$aliases = array();
		$entities = self::getEntityManager()->search('UnzerCw_Entity_Transaction', 
				'customerId LIKE >customerId AND LOWER(paymentMachineName) LIKE LOWER(>paymentMethod) AND aliasActive LIKE >active AND aliasForDisplay IS NOT NULL AND aliasForDisplay != ""', 
				'createdOn ASC', array(
					'>paymentMethod' => $paymentMethod,
					'>customerId' => $userId,
					'>active' => 'y' 
				));
		
		$knownAlias = array();
		foreach ($entities as $entity) {
			if (!in_array($entity->getAliasForDisplay(), $knownAlias)) {
				$aliases[$entity->getTransactionId()] = $entity;
				$knownAlias[] = $entity->getAliasForDisplay();
			}
		}
		return $aliases;
	}
	
	public static function getAliasTransactionObject($aliasTransactionId, $userId) {
		if ($aliasTransactionId === 'new') {
			return 'new';
		}
		
		if ($aliasTransactionId !== null && !empty($aliasTransactionId)) {
			$transcation = self::getTransactionById($aliasTransactionId);
			if ($transcation !== null && $transcation->getTransactionObject() !== null && $transcation->getCustomerId() == $userId && $userId != 0) {
				return $transcation->getTransactionObject();
			}
		}
		
		return null;
	}

	public static function getFailedTransactionObject($failedTransactionId, $failedValidate) {
		if ($failedTransactionId !== null) {
			$dbFailedTransaction = self::getTransactionById($failedTransactionId);
			if ($failedValidate == self::computeTransactionValidateHash($dbFailedTransaction)) {
				return $dbFailedTransaction->getTransactionObject();
			}
		}
		return null;
	}
	
	public static function getShopOption($optionname){
		$option = get_option($optionname);
		return $option;
	}

	public static function computeTransactionValidateHash(UnzerCw_Entity_Transaction $transaction) {
		return substr(sha1($transaction->getCreatedOn()->format("U")), 0, 10);
	}
	
	public static function computeOrderValidationHash($orderId) {
		$wpPost	= get_post($orderId);
		return substr(sha1($wpPost->post_date_gmt.$wpPost->post_password), 0, 10);
	}
		
	
	
	public static function getCheckoutUrlPageId() {
		return wc_get_page_id('checkout');
	}
	
	public static function cleanUpStateField($state, $country){
		$state = trim($state);
		if (!empty($state)) {
			$stateCode = array();
			$toMatch = '/'.$country.'-?(\d+)\z/';
			if(preg_match($toMatch, $state, $stateCode)){
				return $stateCode[1];
			}
			return $state;
		}
		return null;
	}

	
	public static function tryToParseDate($date_string){
		$date_of_birth = false;
		$custom_date_of_birth_format = apply_filters('woocommerce_unzercw_custom_date_of_birth_format', '');
		if(!empty($custom_date_of_birth_format)){
			$date_of_birth =  DateTime::createFromFormat($custom_date_of_birth_format, $date_string);
		}
		else{
			$date_of_birth = DateTime::createFromFormat('d.m.Y', $date_string);
			if(!$date_of_birth){
				$date_of_birth = DateTime::createFromFormat('d-m-Y', $date_string);
			}
			if(!$date_of_birth){
				$date_of_birth = DateTime::createFromFormat('m/d/Y', $date_string);
			}
			if(!$date_of_birth){
				$date_of_birth = DateTime::createFromFormat('Y-m-d', $date_string);
			}
			if(!$date_of_birth){
				$date_of_birth = DateTime::createFromFormat('Y/m/d', $date_string);
			}
		}
		return $date_of_birth;
	}
}
