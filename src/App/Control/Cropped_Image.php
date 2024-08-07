<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Customizer_Framework\App\Control;

use Inc2734\WP_Customizer_Framework\App\Control\Image;
use WP_Customize_Cropped_Image_Control;
use WP_Customize_Manager;

class Cropped_Image extends Image {

	/**
	 * Add control.
	 *
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
	 *
	 * @param WP_Customize_Manager $wp_customize WP_Customize_Manager object.
	 */
	public function register_control( WP_Customize_Manager $wp_customize ) {
		$default_args = get_class_vars( 'WP_Customize_Cropped_Image_Control' );
		foreach ( $default_args as $key => $value ) {
			if ( ! array_key_exists( $key, $this->args ) ) {
				$this->set_arg( $key, $value );
			}
		}

		if ( 'theme_mod' === $this->get_setting_arg( 'type' ) ) {
			add_filter( 'theme_mod_' . $this->get_id(), array( $this, '_url_to_id' ) );
		} elseif ( 'option' === $this->get_setting_arg( 'type' ) ) {
			add_filter( 'default_option_' . $this->get_id(), array( $this, '_url_to_id' ) );
		}

		$wp_customize->add_control(
			new WP_Customize_Cropped_Image_Control(
				$wp_customize,
				$this->get_id(),
				$this->_generate_register_control_args()
			)
		);
	}
}
