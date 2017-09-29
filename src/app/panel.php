<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * Object of Panel
 */
class Inc2734_WP_Customizer_Framework_Panel {

	/**
	 * @var string
	 */
	protected $panel_id;

	/**
	 * @var array
	 */
	protected $args = array();

	/**
	 * @param string $panel_id
	 * @param array $args
	 */
	public function __construct( $panel_id, $args = array() ) {
		$this->panel_id = $panel_id;
		$this->args     = $args;
	}

	/**
	 * Return panel id
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->panel_id;
	}

	/**
	 * Return panel args
	 *
	 * @return array
	 */
	public function get_args() {
		return $this->args;
	}
}
