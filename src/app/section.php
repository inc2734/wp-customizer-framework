<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

class Inc2734_WP_Customizer_Framework_Section {

	/**
	 * @var string
	 */
	protected $id;

	/**
	 * @var array
	 */
	protected $args = array();

	/**
	 * @var Inc2734_WP_Customizer_Framework_Panel
	 */
	protected $Panel;

	/**
	 * @param string $id
	 * @param array $args
	 */
	public function __construct( $id, $args = array() ) {
		$this->id   = $id;
		$this->args = $args;
	}

	/**
	 * Return section id
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->id;
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
	 * @param Inc2734_WP_Customizer_Framework_Panel $Panel
	 * @return Inc2734_WP_Customizer_Framework_Panel
	 */
	public function join( Inc2734_WP_Customizer_Framework_Panel $Panel ) {
		$this->Panel = $Panel;
		return $this->Panel;
	}

	/**
	 * Return Panel that Section joined to
	 *
	 * @return Inc2734_WP_Customizer_Framework_Panel
	 */
	public function Panel() {
		return $this->Panel;
	}
}
