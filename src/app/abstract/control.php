<?php
/**
 * @package inc2734/wp-view-controller
 * @author inc2734
 * @license GPL-2.0+
 */

abstract class Inc2734_WP_Customizer_Framework_Abstract_Control {

	/**
	 * @var string
	 */
	protected $id;

	/**
	 * @var array
	 */
	protected $args = array();

	/**
	 * @var Inc2734_WP_Customizer_Framework_Section
	 */
	protected $Section;

	/**
	 * @param string $id
	 * @param array $args
	 */
	public function __construct( $id, $args = array() ) {
		$this->id   = $id;
		$this->args = $args;
		add_filter( 'theme_mod_' . $id , array( $this, '_theme_mod' ) );
	}

	/**
	 * Return control id
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Return control args
	 *
	 * @return array
	 */
	public function get_args() {
		return $this->args;
	}

	/**
	 * Control joined to Section
	 *
	 * @param Inc2734_WP_Customizer_Framework_Section $Section
	 * @return Inc2734_WP_Customizer_Framework_Section
	 */
	public function join( Inc2734_WP_Customizer_Framework_Section $Section ) {
		$this->Section = $Section;
		return $this->Section;
	}

	/**
	 * Return Section that Control joined to
	 *
	 * @return Inc2734_WP_Customizer_Framework_Section
	 */
	public function Section() {
		return $this->Section;
	}

	/**
	 * Set default theme_mod
	 *
	 * @param mixed $value
	 * @return mixed
	 */
	public function _theme_mod( $value ) {
		if ( is_null( $value ) || false === $value ) {
			if ( isset( $this->args['default'] ) ) {
				return $this->args['default'];
			}
		}
		return $value;
	}

	/**
	 * Add control
	 *
	 * @param WP_Customize_Manager $wp_customize
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
	 */
	abstract public function register_control( WP_Customize_Manager $wp_customize );

	/**
	 * Generate register control args that added section, settings
	 *
	 * @return array
	 */
	protected function _generate_register_control_args() {
		return array_merge(
			$this->get_args(),
			array(
				'section'  => $this->Section->get_id(),
				'settings' => $this->get_id(),
			)
		);
	}
}
