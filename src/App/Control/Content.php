<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Customizer_Framework\App\Control;

use Inc2734\WP_Customizer_Framework\App\Contract\Control\Control as Base;
use Inc2734\WP_Customizer_Framework\App\Customize_Control;
use WP_Customize_Manager;

class Content extends Base {

	/**
	 * Add control.
	 *
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
	 *
	 * @param WP_Customize_Manager $wp_customize WP_Customize_Manager object.
	 */
	public function register_control( WP_Customize_Manager $wp_customize ) {
		$default_args = get_class_vars( '\Inc2734\WP_Customizer_Framework\App\Customize_Control\Content_Control' );
		foreach ( $default_args as $key => $value ) {
			if ( ! array_key_exists( $key, $this->args ) ) {
				$this->set_arg( $key, $value );
			}
		}

		$wp_customize->add_control(
			new Customize_Control\Content_Control(
				$wp_customize,
				$this->get_id(),
				$this->_generate_register_control_args()
			)
		);
	}

	/**
	 * Sanitize callback function
	 *
	 * @return string|function Function name or function for sanitize
	 */
	public function sanitize_callback() {
		return 'sanitize_text_field';
	}
}
