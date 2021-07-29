<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Customizer_Framework\App\Control;

use Inc2734\WP_Customizer_Framework\App\Contract\Control\Control as Base;
use WP_Customize_Media_Control;
use WP_Customize_Manager;

class Image extends Base {

	/**
	 * Add control.
	 *
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
	 *
	 * @param WP_Customize_Manager $wp_customize WP_Customize_Manager object.
	 */
	public function register_control( WP_Customize_Manager $wp_customize ) {
		$default_args = get_class_vars( 'WP_Customize_Media_Control' );
		foreach ( $default_args as $key => $value ) {
			if ( ! array_key_exists( $key, $this->args ) ) {
				$this->set_arg( $key, $value );
			}
		}

		$this->set_extend_arg( 'type', 'media' );
		$this->set_extend_arg( 'mime_type', 'image' );

		if ( 'theme_mod' === $this->get_setting_arg( 'type' ) ) {
			add_filter( 'theme_mod_' . $this->get_id(), [ $this, '_url_to_id' ] );
		} elseif ( 'option' === $this->get_setting_arg( 'type' ) ) {
			add_filter( 'default_option_' . $this->get_id(), [ $this, '_url_to_id' ] );
		}

		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				$this->get_id(),
				$this->_generate_register_control_args()
			)
		);
	}

	/**
	 * The attachment url to the attachment id.
	 *
	 * @param mixed $value The value of the current theme modification.
	 * @return string
	 */
	public function _url_to_id( $value ) {
		$wp_upload_dir = wp_upload_dir();
		$value         = is_object( $value ) || is_array( $value ) ? '' : $value;

		if ( 0 === strpos( $value, $wp_upload_dir['baseurl'] ) ) {
			$attachment_id = attachment_url_to_postid( $value );
			if ( $attachment_id ) {
				return $attachment_id;
			}
		}
		return $value;
	}

	/**
	 * Sanitize callback function
	 *
	 * @return string|function Function name or function for sanitize
	 */
	public function sanitize_callback() {
		return function( $value ) {
			return $value;
			return 'esc_url_raw';
		};
	}
}
