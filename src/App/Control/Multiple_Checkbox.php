<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Customizer_Framework\App\Control;

use Inc2734\WP_Customizer_Framework\App\Contract\Control\Control as Base;
use Inc2734\WP_Customizer_Framework\App\Customize_Control;

class Multiple_Checkbox extends Base {

	/**
	 * Add control
	 *
	 * @param WP_Customize_Manager $wp_customize
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
	 */
	public function register_control( \WP_Customize_Manager $wp_customize ) {
		$this->args['type'] = 'multiple-checkbox';

		$wp_customize->add_control(
			new Customize_Control\Multiple_Checkbox_Control(
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
		return function( $value ) {
			if ( ! is_array( $value ) ) {
				$value = explode( ',', $value );
			}

			$sanitized_values = [];

			foreach ( $value as $v ) {
				if ( ! array_key_exists( $v, $this->args['choices'] ) ) {
					continue;
				}
				$sanitized_values[] = $v;
			}

			$sanitized_values = array_map( 'sanitize_text_field', $sanitized_values );
			return implode( ',', $sanitized_values );
		};
	}
}
