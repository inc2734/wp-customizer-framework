<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * Section manager
 */
class Inc2734_WP_Customizer_Framework_Section_Manager {

	/**
	 * @var Inc2734_WP_Customizer_Framework
	 */
	protected $customizer;

	/**
	 * @var array
	 */
	protected $sections = array();

	/**
	 * @param Inc2734_WP_Customizer_Framework $customizer
	 */
	public function __construct( Inc2734_WP_Customizer_Framework $customizer ) {
		$this->customizer = $customizer;
	}

	/**
	 * Get Section
	 *
	 * @param string $section_id
	 * @return Inc2734_WP_Customizer_Framework_Section|null
	 */
	public function get( $section_id ) {
		if ( isset( $this->sections[ $section_id ] ) ) {
			return $this->sections[ $section_id ];
		}
	}

	/**
	 * Add Section
	 *
	 * @param string $section_id
	 * @param array $args
	 * @return Inc2734_WP_Customizer_Framework_Section
	 */
	public function add( $section_id, $args ) {
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
	protected function _section( $section_id, array $args = array() ) {
		return new Inc2734_WP_Customizer_Framework_Section( $section_id, $args );
	}
}
