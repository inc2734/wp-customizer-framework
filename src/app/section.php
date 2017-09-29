<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * Object of Section
 */
class Inc2734_WP_Customizer_Framework_Section {

	/**
	 * @var string
	 */
	protected $section_id;

	/**
	 * @var array
	 */
	protected $args = array();

	/**
	 * @var Inc2734_WP_Customizer_Framework_Panel
	 */
	protected $panel;

	/**
	 * @param string $section_id
	 * @param array $args
	 */
	public function __construct( $section_id, $args = array() ) {
		$this->section_id = $section_id;
		$this->args       = $args;
	}

	/**
	 * Return section id
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->section_id;
	}

	/**
	 * Return section args
	 *
	 * @return array
	 */
	public function get_args() {
		return $this->args;
	}

	/**
	 * Section joined to Panel
	 *
	 * @param Inc2734_WP_Customizer_Framework_Panel $panel
	 * @return Inc2734_WP_Customizer_Framework_Panel
	 */
	public function join( Inc2734_WP_Customizer_Framework_Panel $panel ) {
		$this->panel = $panel;
		return $this->panel;
	}

	/**
	 * Return Panel that Section joined to
	 *
	 * @return Inc2734_WP_Customizer_Framework_Panel
	 */
	public function panel() {
		return $this->panel;
	}
}
