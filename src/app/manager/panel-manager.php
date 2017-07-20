<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

class Inc2734_WP_Customizer_Framework_Panel_Manager {

	/**
	 * @var Inc2734_WP_Customizer_Framework
	 */
	protected $customizer;

	/**
	 * @var array
	 */
	protected $panels = array();

	/**
	 * @param Inc2734_WP_Customizer_Framework $customizer
	 */
	public function __construct( Inc2734_WP_Customizer_Framework $customizer ) {
		$this->customizer = $customizer;
	}

	/**
	 * Get Panel
	 *
	 * @param string $panel_id
	 * @return Inc2734_WP_Customizer_Framework_Panel|null
	 */
	public function get( $panel_id ) {
		if ( isset( $this->panels[ $panel_id ] ) ) {
			return $this->panels[ $panel_id ];
		}
	}

	/**
	 * Add Panel
	 *
	 * @param string $panel_id
	 * @param array $args
	 * @return Inc2734_WP_Customizer_Framework_Panel
	 */
	public function add( $panel_id, $args ) {
		$panel = $this->_panel( $panel_id, $args );
		$this->panels[ $panel->get_id() ] = $panel;
		return $panel;
	}

	/**
	 * Create panel
	 *
	 * @param string $id
	 * @param array $args
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_panel/
	 */
	protected function _panel( $id, array $args = array() ) {
		return new Inc2734_WP_Customizer_Framework_Panel( $id, $args );
	}
}
