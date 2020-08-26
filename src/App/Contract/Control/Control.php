<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Customizer_Framework\App\Contract\Control;

use Inc2734\WP_Customizer_Framework\App\Section;
use Inc2734\WP_Customizer_Framework\App\Partial;

abstract class Control {

	/**
	 * @var string
	 */
	protected $control_id;

	/**
	 * @see https://core.trac.wordpress.org/browser/trunk/src/wp-includes/class-wp-customize-control.php#L210
	 *
	 * @var array
	 *  @var int instance_number
	 *  @var WP_Customize_Manager manager
	 *  @var string id
	 *  @var array settings
	 *  @var string setting
	 *  @var string capability
	 *  @var int priority
	 *  @var string section
	 *  @var string label
	 *  @var string description
	 *  @var array choices
	 *  @var array input_attrs
	 *  @var boolean allow_addition
	 *  @var array json
	 *  @var string text
	 *  @var string active_callback
	 */
	protected $args = [
		'instance_number' => null,
		'manager'         => null,
		'id'              => null,
		'settings'        => null,
		'setting'         => 'default',
		'capability'      => null,
		'priority'        => 10,
		'section'         => '',
		'label'           => '',
		'description'     => '',
		'choices'         => [],
		'input_attrs'     => [],
		'allow_addition'  => false,
		'json'            => [],
		'type'            => 'text',
		'active_callback' => '',
	];

	/**
	 * @see https://core.trac.wordpress.org/browser/trunk/src/wp-includes/class-wp-customize-setting.php#L210
	 *
	 * @var array
	 *  @var string type
	 *  @var string capability
	 *  @var string|array theme_supports
	 *  @var string default
	 *  @var string transport
	 *  @var callback validate_callback
	 *  @var callback sanitize_callback
	 *  @var callback sanitize_js_callback
	 *  @var boolean dirty
	 */
	protected $setting_args = [
		'type'                 => 'theme_mod',
		'capability'           => 'edit_theme_options',
		'theme_supports'       => '',
		'default'              => '',
		'transport'            => 'refresh',
		'validate_callback'    => '',
		'sanitize_callback'    => '',
		'sanitize_js_callback' => '',
		'dirty'                => false,
	];

	/**
	 * @var Section
	 */
	protected $section;

	/**
	 * @var Partial
	 */
	protected $partial;

	/**
	 * @param string $control_id
	 * @param array $args
	 */
	public function __construct( $control_id, $args = [] ) {
		foreach ( $args as $key => $value ) {
			if ( array_key_exists( $key, $this->setting_args ) ) {
				$this->set_setting_arg( $key, $value );
			} elseif ( array_key_exists( $key, $this->args ) ) {
				$this->set_arg( $key, $value );
			}
		}

		$this->control_id = $control_id;

		if ( ! $this->get_arg( 'sanitize_callback' ) ) {
			$this->set_arg( 'sanitize_callback', $this->sanitize_callback() );
		}

		if ( 'theme_mod' === $this->get_setting_arg( 'type' ) ) {
			add_filter( 'theme_mod_' . $control_id, [ $this, '_set_default_value' ] );
		} elseif ( 'option' === $this->get_setting_arg( 'type' ) ) {
			add_filter( 'default_option_' . $control_id, [ $this, '_set_default_option' ], 10, 2 );
		}
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
	 * Return specific control arg
	 */
	public function get_arg( $key ) {
		return array_key_exists( $key, $this->args )
			? $this->args[ $key ]
			: false;
	}

	/**
	 * Return setting args
	 *
	 * @return array
	 */
	public function get_setting_args() {
		return $this->setting_args;
	}

	/**
	 * Return specific setting arg
	 */
	public function get_setting_arg( $key ) {
		return array_key_exists( $key, $this->setting_args )
			? $this->setting_args[ $key ]
			: false;
	}

	/**
	 * Set control arg
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	public function set_arg( $key, $value ) {
		$this->args[ $key ] = $value;
	}

	/**
	 * Set setting arg
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	public function set_setting_arg( $key, $value ) {
		$this->setting_args[ $key ] = $value;
	}

	/**
	 * Control joined to Section
	 *
	 * @param Section $section
	 * @return Section
	 */
	public function join( Section $section ) {
		$this->section = $section;
		return $this->section;
	}

	/**
	 * Return Section that Control joined to
	 *
	 * @return Section
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
			$this->partial = new Partial( $this->get_id(), $args );
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
			if ( '' !== $this->get_setting_arg( 'default' ) ) {
				return $this->get_setting_arg( 'default' );
			}
		}
		return $value;
	}

	/**
	 * Set default option
	 *
	 * @param mixed $value
	 * @param string $option Control ID
	 * @return mixed
	 */
	public function _set_default_option( $value, $option ) {
		return $this->_set_default_value( $value );
	}

	/**
	 * Add control
	 *
	 * @param WP_Customize_Manager $wp_customize
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
	 */
	abstract public function register_control( \WP_Customize_Manager $wp_customize );

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
