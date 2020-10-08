<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Customizer_Framework\App\Manager;

use Inc2734\WP_Customizer_Framework\App\Panel;

class Panel_Manager {

	/**
	 * @var array
	 */
	protected static $panels = [];

	/**
	 * Get Panel.
	 *
	 * @param string $panel_id The Panel ID.
	 * @return Panel|null
	 */
	public static function get( $panel_id ) {
		if ( isset( static::$panels[ $panel_id ] ) ) {
			return static::$panels[ $panel_id ];
		} else {
			return static::_panel( $panel_id, [] );
		}
	}

	/**
	 * Add Panel.
	 *
	 * @param string $panel_id The Panel ID.
	 * @param array  $args     Array of argment.
	 * @return Panel
	 */
	public static function add( $panel_id, $args ) {
		$panel                              = static::_panel( $panel_id, $args );
		static::$panels[ $panel->get_id() ] = $panel;
		return $panel;
	}

	/**
	 * Create panel.
	 *
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_panel/
	 *
	 * @param string $panel_id The Panel ID.
	 * @param array  $args     Array of argment.
	 */
	protected static function _panel( $panel_id, array $args = array() ) {
		return new Panel( $panel_id, $args );
	}
}
