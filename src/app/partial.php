<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * Object of Partial
 * @see https://developer.wordpress.org/reference/classes/wp_customize_selective_refresh/
 */
class Inc2734_WP_Customizer_Framework_Partial {

	/**
	 * @var string
	 */
	protected $partial_id;

	/**
	 * @var array
	 */
	protected $args = array();

	/**
	 * @param string $partial_id
	 * @param array $args
	 */
	public function __construct( $partial_id, $args = array() ) {
		$this->partial_id = $partial_id;
		$this->args       = $args;
	}

	/**
	 * Return partial id
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->partial_id;
	}

	/**
	 * Return partial args
	 *
	 * @return array
	 */
	public function get_args() {
		return $this->args;
	}
}
