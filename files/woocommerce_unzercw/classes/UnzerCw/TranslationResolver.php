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

require_once 'Customweb/I18n/Translation.php';
require_once 'UnzerCw/TranslationResolver.php';
require_once 'Customweb/I18n/ITranslationResolver.php';


class UnzerCw_TranslationResolver implements Customweb_I18n_ITranslationResolver {
	public function getTranslation($string) {
		$string = preg_replace("/\s+/", " ", $string);
		$rs = __($string, 'woocommerce_unzercw');
		if ($rs === $string) {
			return null;
		}
		else {
			return $rs;
		}
	}
}

Customweb_I18n_Translation::getInstance()->addResolver(new UnzerCw_TranslationResolver());
