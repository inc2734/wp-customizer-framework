<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Customizer_Framework\App\Manager;

class Control_Manager {

	/**
	 * @var array
	 */
	protected static $controls = [];

	/**
	 * Get Control.
	 *
	 * @param string $control_id The Control ID.
	 * @return Control|null
	 */
	public static function get( $control_id ) {
		if ( isset( static::$controls[ $control_id ] ) ) {
			return static::$controls[ $control_id ];
		}
	}

	/**
	 * Get all Controls.
	 *
	 * @return array Array of Control.
	 */
	public static function get_controls() {
		return static::$controls;
	}

	/**
	 * Add Control.
	 *
	 * @param string $type       The Control type.
	 * @param string $control_id The Control ID.
	 * @param array  $args       Array of argment.
	 * @return Control
	 */
	public static function add( $type, $control_id, $args ) {
		$control = static::_control( $type, $control_id, $args );
		if ( $control ) {
			static::$controls[ $control->get_id() ] = $control;
		}
		return $control;
	}

	/**
	 * Create control.
	 *
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
	 *
	 * @param string $type       The Control type.
	 * @param string $control_id The Control ID.
	 * @param array  $args       Array of argment.
	 * @return Control
	 */
	protected static function _control( $type, $control_id, $args ) {
		$_type = explode( '-', $type );
		foreach ( $_type as $key => $value ) {
			$_type[ $key ] = ucfirst( $value );
		}
		$type  = implode( '_', $_type );
		$class = '\Inc2734\WP_Customizer_Framework\App\Control\\' . $type;
		if ( class_exists( $class ) ) {
			return new $class( $control_id, $args );
		}
		echo esc_html( $class . ' is not found.' );
	}
}
