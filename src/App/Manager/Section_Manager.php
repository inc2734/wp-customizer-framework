<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Customizer_Framework\App\Manager;

use Inc2734\WP_Customizer_Framework\Customizer_Framework;
use Inc2734\WP_Customizer_Framework\App\Section;

class Section_Manager {

	/**
	 * @var Customizer_Framework
	 */
	protected $customizer;

	/**
	 * @var array
	 */
	protected $sections = array();

	/**
	 * @param Customizer_Framework $customizer
	 */
	public function __construct( Customizer_Framework $customizer ) {
		$this->customizer = $customizer;
	}

	/**
	 * Get Section
	 *
	 * @param string $section_id
	 * @return Section
	 */
	public function get( $section_id ) {
		if ( isset( $this->sections[ $section_id ] ) ) {
			return $this->sections[ $section_id ];
		} else {
			return $this->_section( $section_id, [] );
		}
	}

	/**
	 * Add Section
	 *
	 * @param string $section_id
	 * @param array $args
	 * @return Section
	 */
	public function add( $section_id, array $args ) {
		$section = $this->_section( $section_id, $args );
		$this->sections[ $section->get_id() ] = $section;
		return $section;
	}

	/**
	 * Create section
	 *
	 * @param string $section_id
	 * @param array $args
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_section/
	 */
	protected function _section( $section_id, array $args = [] ) {
		return new Section( $section_id, $args );
	}
}
