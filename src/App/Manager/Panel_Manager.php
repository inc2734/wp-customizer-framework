<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Customizer_Framework\App\Manager;

use Inc2734\WP_Customizer_Framework\Customizer_Framework;
use Inc2734\WP_Customizer_Framework\App\Panel;

class Panel_Manager {

	/**
	 * @var Inc2734\WP_Customizer_Framework\Customizer_Framework
	 */
	protected $customizer;

	/**
	 * @var array
	 */
	protected $panels = array();

	/**
	 * @param Customizer_Framework $customizer
	 */
	public function __construct( Customizer_Framework $customizer ) {
		$this->customizer = $customizer;
	}

	/**
	 * Get Panel
	 *
	 * @param string $panel_id
	 * @return Panel|null
	 */
	public function get( $panel_id ) {
		if ( isset( $this->panels[ $panel_id ] ) ) {
			return $this->panels[ $panel_id ];
		} else {
			return $this->_panel( $panel_id, [] );
		}
	}

	/**
	 * Add Panel
	 *
	 * @param string $panel_id
	 * @param array $args
	 * @return Panel
	 */
	public function add( $panel_id, $args ) {
		$panel = $this->_panel( $panel_id, $args );
		$this->panels[ $panel->get_id() ] = $panel;
		return $panel;
	}

	/**
	 * Create panel
	 *
	 * @param string $panel_id
	 * @param array $args
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_panel/
	 */
	protected function _panel( $panel_id, array $args = array() ) {
		return new Panel( $panel_id, $args );
	}
}
