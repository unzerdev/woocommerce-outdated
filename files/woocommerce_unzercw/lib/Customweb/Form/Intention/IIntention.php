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
 * The intention describs the elements usage and meta data. Currently only a CSS 
 * class can be retrieved from it.
 * 
 * @author Thomas Hunziker
 *
 */
interface Customweb_Form_Intention_IIntention {
	
	/**
	 * The CSS class of this intention.
	 * 
	 * @return string
	 */
	public function getCssClass();
	
}
