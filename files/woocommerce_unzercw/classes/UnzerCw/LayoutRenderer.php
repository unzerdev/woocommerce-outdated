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

require_once 'Customweb/Mvc/Layout/IRenderer.php';



class UnzerCw_LayoutRenderer implements Customweb_Mvc_Layout_IRenderer{
	
	public function render(Customweb_Mvc_Layout_IRenderContext $context) {
		
		$title = $context->getTitle();
		
		if(!empty($title)) {
			$GLOBALS['woo_unzercwTitle'] = $title;
		}
		
		$cssFiles = $context->getCssFiles();
		$cssString = '';
		foreach ($cssFiles as $url) {
			$cssString .= '<link rel="stylesheet" href="'.$url.'" type="text/css"/>';
		}
		$GLOBALS['woo_unzercwCSS'] = $cssString;		

		$jsFiles = $context->getJavaScriptFiles();
		$jsString = '';
		foreach ($jsFiles as $url) {
			$jsString .= '<script type="text/javascript" src="'.$url.'"></script>';
		}
		$GLOBALS['woo_unzercwJS'] = $jsString;
		$GLOBALS['woo_unzercwContent'] = $context->getMainContent();

		wp();
		do_action('template_redirect');
		$template = get_page_template();
		$template = apply_filters('template_include', $template);
		if (empty($template)) {
			$template = $this->force_single_template_filter();
		}
		ob_start();
		include($template);
		$page = ob_get_clean();
		return $page;
	}

	/**
	 * Look for theme template file to render
	 *
	 * @return string
	 * @throws \Exception
	 */
	public static function force_single_template_filter() {
		$possible_templates = array(
			'page',
			'singular',
			'single',
			'index',
		);
		foreach ( $possible_templates as $possible_template ) {
			$path = get_query_template( $possible_template );
			if ($path) {
				return $path;
			}
		}

		throw new \Exception('Unable to find template');
	}

}