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
	 * Add Panel
	 *
	 * @param string $panel_id
	 * @param array $args
	 * @return Panel
	 */
	public static function panel( $panel_id, $args ) {
		return Panel_Manager::add( $panel_id, $args );
	}

	/**
	 * Add Section
	 *
	 * @param string $section_id
	 * @param array $args
	 * @return Section
	 */
	public static function section( $section_id, $args ) {
		return Section_Manager::add( $section_id, $args );
	}

	/**
	 * Add Control
	 *
	 * @param string $type
	 * @param string $control_id
	 * @param array $args
	 * @return Control
	 */
	public static function control( $type, $control_id, $args ) {
		return Control_Manager::add( $type, $control_id, $args );
	}

	/**
	 * Get Panel
	 *
	 * @param string $panel_id
	 * @return Panel|null
	 */
	public static function get_panel( $panel_id ) {
		return Panel_Manager::get( $panel_id );
	}

	/**
	 * Get Section
	 *
	 * @param string $section_id
	 * @return Section|null
	 */
	public static function get_section( $section_id ) {
		return Section_Manager::get( $section_id );
	}

	/**
	 * Get Control
	 *
	 * @param string $control_id
	 * @return Control|null
	 */
	public static function get_control( $control_id ) {
		return Control_Manager::get( $control_id );
	}
}
