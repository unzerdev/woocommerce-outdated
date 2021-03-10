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

/**
 * This interface represents a HTML form. The form consists of a list of 
 * form elements and a list of form submit buttons.
 */
interface Customweb_IForm
{	
	const REQUEST_METHOD_POST = 'post';
	const REQUEST_METHOD_GET = 'get';
	
	const TARGET_WINDOW_NEW = '_blank';
	const TARGET_WINDOW_SAME = '_self';
	const TARGET_WINDOW_PARENT = '_parent';
	const TARGET_WINDOW_TOP = '_top';
	
	/**
	 * The ID identifies the form. It should be globally unique.
	 * 
	 * @return string ID of the form
	 */
	public function getId();
	
	/**
	 * Returns a name which consists only of ASCII chars and it
	 * should be unique with in a collection of forms. The machine 
	 * name should not be changed.
	 * 
	 * @return string
	 */
	public function getMachineName();
	
	/**
	 * The URL to which the form should be sent to.
	 * 
	 * @return string Target URL.
	 */
	public function getTargetUrl();
	
	/**
	 * Returns the target window in which the response should be shown. Either 
	 * the frame ID or then one of TARGET_WINDOW_*
	 * 
	 * @return string
	 */
	public function getTargetWindow();
	
	/**
	 * Returns the request method which should be used. One of REQUEST_METHOD_*
	 * 
	 * @return string Request Method Type
	 */
	public function getRequestMethod();
	
	/**
	 * This method returns a title of the form.
	 * 
	 * @return Customweb_I18n_LocalizableString Title of the form
	 */
	public function getTitle();
	
	/**
	 * Return a list of form element groups.
	 * 
	 * @return Customweb_Form_IElementGroup[]
	 */
	public function getElementGroups();
	
	/**
	 * Return a list of form elements. This is used when processing the form.
	 * 
	 * @return Customweb_Form_IElement[]
	 */
	public function getElements();
	
	/**
	 * Returns a lit of form buttons. The buttons can 
	 * be used by the user to submit the form.
	 * 
	 * @return Customweb_Form_IButton
	 */
	public function getButtons();
}