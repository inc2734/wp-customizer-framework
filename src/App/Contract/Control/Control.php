<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Customizer_Framework\App\Contract\Control;

use Inc2734\WP_Customizer_Framework\App\Section;
use Inc2734\WP_Customizer_Framework\App\Partial;
use WP_Customize_Manager;

abstract class Control {

	/**
	 * @var string
	 */
	protected $control_id;

	/**
	 * @var boolean
	 */
	protected $overridden_default = false;

	/**
	 * @see https://core.trac.wordpress.org/browser/trunk/src/wp-includes/class-wp-customize-control.php#L210
	 *
	 * @var array
	 */
	protected $args_keys = [
		'instance_number',
		'manager',
		'id',
		'settings',
		'setting',
		'capability',
		'priority',
		'section',
		'label',
		'description',
		'choices',
		'input_attrs',
		'allow_addition',
		'json',
		'type',
		'active_callback',
	];

	/**
	 * @see https://core.trac.wordpress.org/browser/trunk/src/wp-includes/class-wp-customize-control.php#L210
	 *
	 * @var array
	 */
	protected $args = [];

	/**
	 * @see https://core.trac.wordpress.org/browser/trunk/src/wp-includes/class-wp-customize-setting.php#L210
	 *
	 * @var array
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
	 * @var array
	 */
	protected $extend_args = [];

	/**
	 * @var Section
	 */
	protected $section;

	/**
	 * @var Partial
	 */
	protected $partial;

	/**
	 * @param string $control_id The Control ID.
	 * @param array  $args       Array of argment.
	 */
	public function __construct( $control_id, $args = [] ) {
		foreach ( $args as $key => $value ) {
			if ( array_key_exists( $key, $this->setting_args ) ) {
				$this->set_setting_arg( $key, $value );
			} elseif ( in_array( $key, $this->args_keys, true ) ) {
				$this->set_arg( $key, $value );
			} else {
				$this->set_extend_arg( $key, $value );
			}
		}

		$this->control_id = $control_id;

		if ( ! $this->get_setting_arg( 'sanitize_callback' ) ) {
			$this->set_setting_arg( 'sanitize_callback', $this->sanitize_callback() );
		}

		if ( isset( $args['default'] ) ) {
			$this->overridden_default = true;

			if ( 'theme_mod' === $this->get_setting_arg( 'type' ) ) {
				add_filter( 'theme_mod_' . $control_id, [ $this, '_set_default_value' ] );
			} elseif ( 'option' === $this->get_setting_arg( 'type' ) ) {
				add_filter( 'default_option_' . $control_id, [ $this, '_set_default_option' ] );
			}
		}
	}

	/**
	 * Return control id.
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->control_id;
	}

	/**
	 * Return control args.
	 *
	 * @return array
	 */
	public function get_args() {
		return $this->args;
	}

	/**
	 * Return specific control arg.
	 *
	 * @param string $key The control name.
	 * @return mixed
	 */
	public function get_arg( $key ) {
		return array_key_exists( $key, $this->args )
			? $this->args[ $key ]
			: false;
	}

	/**
	 * Return setting args.
	 *
	 * @return array
	 */
	public function get_setting_args() {
		return $this->setting_args;
	}

	/**
	 * Return specific setting arg.
	 *
	 * @param string $key The setting name.
	 * @return mixed
	 */
	public function get_setting_arg( $key ) {
		return array_key_exists( $key, $this->setting_args )
			? $this->setting_args[ $key ]
			: false;
	}

	/**
	 * Return extend args.
	 *
	 * @return array
	 */
	public function get_extend_args() {
		return $this->extend_args;
	}

	/**
	 * Return specific extend arg.
	 *
	 * @param string $key The setting name.
	 * @return mixed
	 */
	public function get_extend_arg( $key ) {
		return array_key_exists( $key, $this->extend_args )
			? $this->extend_args[ $key ]
			: false;
	}

	/**
	 * Set control arg.
	 *
	 * @param string $key   The control name.
	 * @param mixed  $value The control value.
	 */
	public function set_arg( $key, $value ) {
		$this->args[ $key ] = $value;
	}

	/**
	 * Set setting arg.
	 *
	 * @param string $key   The setting name.
	 * @param mixed  $value The setting value.
	 */
	public function set_setting_arg( $key, $value ) {
		$this->setting_args[ $key ] = $value;
	}

	/**
	 * Set extend arg.
	 *
	 * @param string $key   The extend name.
	 * @param mixed  $value The extend value.
	 */
	public function set_extend_arg( $key, $value ) {
		$this->extend_args[ $key ] = $value;
	}

	/**
	 * Control joined to Section.
	 *
	 * @param Section $section Section object.
	 * @return Section
	 */
	public function join( Section $section ) {
		$this->section = $section;
		return $this->section;
	}

	/**
	 * Return Section that Control joined to.
	 *
	 * @return Section
	 */
	public function section() {
		return $this->section;
	}

	/**
	 * Control joined to Partial.
	 *
	 * @param array|null $args Array of argment.
	 */
	public function partial( $args = null ) {
		if ( is_null( $args ) ) {
			return $this->partial;
		} elseif ( is_array( $args ) ) {
			$this->partial = new Partial( $this->get_id(), $args );
		}
	}

	/**
	 * Set default theme_mod.
	 *
	 * @param mixed $value The value you want to set as the default value.
	 * @return mixed
	 */
	public function _set_default_value( $value ) {
		if ( is_null( $value ) || false === $value ) {
			if ( $this->overridden_default ) {
				return $this->get_setting_arg( 'default' );
			}
		}
		return $value;
	}

	/**
	 * Set default option
	 *
	 * @param mixed $value The value you want to set as the default value.
	 * @return mixed
	 */
	public function _set_default_option( $value ) {
		return $this->_set_default_value( $value );
	}

	/**
	 * Add control.
	 *
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
	 *
	 * @param WP_Customize_Manager $wp_customize WP_Customize_Manager object.
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
			$this->get_extend_args(),
			array(
				'section'  => $this->section->get_id(),
				'settings' => $this->get_id(),
			)
		);
	}

	/**
	 * Sanitize callback function.
	 *
	 * @return string|function Function name or function for sanitize
	 */
	public function sanitize_callback() {
		return '';
	}
}
