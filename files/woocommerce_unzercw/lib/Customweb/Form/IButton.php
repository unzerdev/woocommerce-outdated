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

/**
 * Represents a button inside of a form.
 */
interface Customweb_Form_IButton {
	const TYPE_DEFAULT = 'default';
	const TYPE_SUCCESS = 'success';
	const TYPE_CANCEL = 'cancel';
	const TYPE_INFO = 'info';

	/**
	 * The ID of the button.
	 * It should be globally unique.
	 *
	 * @return string
	 */
	public function getId();

	/**
	 * The name of the button.
	 * The ID should be unique
	 * per form. This is used as the identifier of the
	 * button.
	 *
	 * @return string
	 */
	public function getMachineName();

	/**
	 * Returns the translated title of the button.
	 * The title is
	 * visible for the user.
	 *
	 * @return Customweb_I18n_LocalizableString
	 */
	public function getTitle();

	/**
	 * Returns the type of the button.
	 * The type is used to indicate
	 * the kind of action exectued by the button.
	 *
	 * It should be one of self::TYPE_*
	 *
	 * @return string
	 */
	public function getType();

	/**
	 * Returns true, if the Javascript validation should be executed,
	 * when this button is clicked
	 * 
	 * @return boolean
	 */
	public function isJSValidationExecuted();
}