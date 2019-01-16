<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Customizer_Framework\App\Manager;

use Inc2734\WP_Customizer_Framework\App\Section;

class Section_Manager {

	/**
	 * @var array
	 */
	protected static $sections = [];

	/**
	 * Get Section
	 *
	 * @param string $section_id
	 * @return Section
	 */
	public static function get( $section_id ) {
		if ( isset( static::$sections[ $section_id ] ) ) {
			return static::$sections[ $section_id ];
		} else {
			return static::_section( $section_id, [] );
		}
	}

	/**
	 * Add Section
	 *
	 * @param string $section_id
	 * @param array $args
	 * @return Section
	 */
	public static function add( $section_id, array $args ) {
		$section = static::_section( $section_id, $args );
		static::$sections[ $section->get_id() ] = $section;
		return $section;
	}

	/**
	 * Create section
	 *
	 * @param string $section_id
	 * @param array $args
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_section/
	 */
	protected static function _section( $section_id, array $args = [] ) {
		return new Section( $section_id, $args );
	}
}
