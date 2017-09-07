<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

class Inc2734_WP_Customizer_Framework_Panel {

	/**
	 * @var string
	 */
	protected $id;

	/**
	 * @var array
	 */
	protected $args = array();

	/**
	 * @param string $id
	 * @param array $args
	 */
	public function __construct( $id, $args = array() ) {
		$this->id   = $id;
		$this->args = $args;
	}

	/**
	 * Return panel id
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->id;
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
