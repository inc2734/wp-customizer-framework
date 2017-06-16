<?php
/**
 * @package inc2734/wp-view-controller
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Customizer_Framework;

class Customizer_Framework {

	protected function __construct() {
	}

	/**
	 * Create instance
	 *
	 * @return Inc2734_WP_Customizer_Framework
	 */
	public static function init() {
		include_once( __DIR__ . '/wp-customizer-framework.php' );
		return \Inc2734_WP_Customizer_Framework::init();
	}
}
