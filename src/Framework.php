<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Customizer_Framework;

use Inc2734\WP_Customizer_Framework\App\Manager\Panel_Manager;
use Inc2734\WP_Customizer_Framework\App\Manager\Section_Manager;
use Inc2734\WP_Customizer_Framework\App\Manager\Control_Manager;

class Framework {

	/**
	 * Add Panel.
	 *
	 * @param string $panel_id The Panel ID.
	 * @param array  $args Array of argment.
	 * @return Panel
	 */
	public static function panel( $panel_id, $args ) {
		return Panel_Manager::add( $panel_id, $args );
	}

	/**
	 * Add Section.
	 *
	 * @param string $section_id The Section ID.
	 * @param array  $args Array of argment.
	 * @return Section
	 */
	public static function section( $section_id, $args ) {
		return Section_Manager::add( $section_id, $args );
	}

	/**
	 * Add Control.
	 *
	 * @param string $type The Control type.
	 * @param string $control_id The Control ID.
	 * @param array  $args Array of argment.
	 * @return Control
	 */
	public static function control( $type, $control_id, $args ) {
		return Control_Manager::add( $type, $control_id, $args );
	}

	/**
	 * Get Panel.
	 *
	 * @param string $panel_id The Panel ID.
	 * @return Panel|null
	 */
	public static function get_panel( $panel_id ) {
		return Panel_Manager::get( $panel_id );
	}

	/**
	 * Get Section.
	 *
	 * @param string $section_id The Section ID.
	 * @return Section|null
	 */
	public static function get_section( $section_id ) {
		return Section_Manager::get( $section_id );
	}

	/**
	 * Get Control.
	 *
	 * @param string $control_id The Control ID.
	 * @return Control|null
	 */
	public static function get_control( $control_id ) {
		return Control_Manager::get( $control_id );
	}
}
