<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * Abstract customize control class
 */
abstract class Inc2734_WP_Customizer_Framework_Abstract_Control {

	/**
	 * @var string
	 */
	protected $control_id;

	/**
	 * @var array
	 */
	protected $args = array();

	/**
	 * @var Inc2734_WP_Customizer_Framework_Section
	 */
	protected $section;

	/**
	 * @var Inc2734_WP_Customizer_Framework_Partial
	 */
	protected $partial;

	/**
	 * @param string $control_id
	 * @param array $args
	 */
	public function __construct( $control_id, $args = array() ) {
		$this->control_id = $control_id;
		$this->args       = $args;

		if ( ! isset( $this->args['sanitize_callback'] ) ) {
			$this->args['sanitize_callback'] = $this->sanitize_callback();
		}

		add_filter( 'theme_mod_' . $control_id, array( $this, '_set_default_value' ) );
		add_filter( 'default_option_' . $control_id, array( $this, '_set_default_value' ) );
	}

	/**
	 * Return control id
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->control_id;
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
	 * @param Inc2734_WP_Customizer_Framework_Section $section
	 * @return Inc2734_WP_Customizer_Framework_Section
	 */
	public function join( Inc2734_WP_Customizer_Framework_Section $section ) {
		$this->section = $section;
		return $this->section;
	}

	/**
	 * Return Section that Control joined to
	 *
	 * @return Inc2734_WP_Customizer_Framework_Section
	 */
	public function section() {
		return $this->section;
	}

	/**
	 * Control joined to Partial
	 *
	 * @param array|null $args
	 */
	public function partial( $args = null ) {
		if ( is_null( $args ) ) {
			return $this->partial;
		} elseif ( is_array( $args ) ) {
			$this->partial = new Inc2734_WP_Customizer_Framework_Partial( $this->get_id(), $args );
		}
	}

	/**
	 * Set default theme_mod
	 *
	 * @param mixed $value
	 * @return mixed
	 */
	public function _set_default_value( $value ) {
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
				'section'  => $this->section->get_id(),
				'settings' => $this->get_id(),
			)
		);
	}

	/**
	 * Sanitize callback function
	 *
	 * @return string|function Function name or function for sanitize
	 */
	public function sanitize_callback() {
		return '';
	}
}
