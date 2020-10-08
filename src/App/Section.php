<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Customizer_Framework\App;

class Section {

	/**
	 * @var string
	 */
	protected $section_id;

	/**
	 * @var array
	 */
	protected $args = array();

	/**
	 * @var Panel
	 */
	protected $panel;

	/**
	 * Constructor.

	 * @param string $section_id The Section ID.
	 * @param array  $args       Array of argment.
	 */
	public function __construct( $section_id, array $args = [] ) {
		$this->section_id = $section_id;
		$this->args       = $args;
	}

	/**
	 * Return Section ID.
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->section_id;
	}

	/**
	 * Return section args.
	 *
	 * @return array
	 */
	public function get_args() {
		return $this->args;
	}

	/**
	 * Section joined to Panel.
	 *
	 * @param Panel $panel Panel object to join.
	 * @return Panel
	 */
	public function join( Panel $panel ) {
		$this->panel = $panel;
		return $this->panel;
	}

	/**
	 * Return Panel that Section joined to.
	 *
	 * @return Panel
	 */
	public function panel() {
		return $this->panel;
	}
}
