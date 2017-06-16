<?php
/**
 * @package inc2734/wp-view-controller
 * @author inc2734
 * @license GPL-2.0+
 */

$includes = array(
	'/app/abstract',
	'/app/control',
	'/app/panel',
	'/app/section',
);
foreach ( $includes as $include ) {
	foreach ( glob( __DIR__ . $include . '/*.php' ) as $file ) {
		require_once( $file );
	}
}

class Inc2734_WP_Customizer_Framework {

	/**
	 * @var Inc2734_WP_Customizer_Framework
	 */
	protected static $instance;

	/**
	 * @var array
	 */
	protected static $controls = array();

	/**
	 * @var array
	 */
	protected static $removed_default_controls = array();

	protected function __construct() {
		add_action( 'customize_register', array( $this, '_customize_register' ) );
	}

	/**
	 * Create instance
	 *
	 * @return Inc2734_WP_Customizer_Framework
	 */
	public static function init() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Setup customizer
	 *
	 * @param WP_Customize_Manager $wp_customize
	 * @return void
	 */
	public function _customize_register( WP_Customize_Manager $wp_customize ) {
		foreach ( self::$removed_default_controls as $control_name ) {
			$wp_customize->remove_control( $control_name );
		}

		foreach ( self::$controls as $Control ) {
			$wp_customize->add_setting( $Control->get_id(), $Control->get_args() );
			$Control->register_control( $wp_customize );
			$Section = $Control->Section();
			$Panel   = $Section->Panel();

			$args = $Section->get_args();
			if ( ! empty( $Panel ) ) {
				$args = array_merge( $args, array(
					'panel' => $Panel->get_id(),
				) );
			}

			if ( ! $wp_customize->get_section( $Section->get_id() ) && $args ) {
				$wp_customize->add_section( $Section->get_id(), $args );
			}

			if ( ! empty( $Panel ) ) {
				$wp_customize->add_panel( $Panel->get_id(), $Panel->get_args() );
			}
		}
	}

	/**
	 * Register control
	 *
	 * @param Inc2734_WP_Customizer_Framework_Abstract_Control $Control
	 * @return Inc2734_WP_Customizer_Framework_Abstract_Control
	 */
	public function register( Inc2734_WP_Customizer_Framework_Abstract_Control $Control ) {
		if ( is_a( $Control, 'Inc2734_WP_Customizer_Framework_Abstract_Control' ) ) {
		}
		self::$controls[ $Control->get_id() ] = $Control;
		return self::$controls[ $Control->get_id() ];
	}

	/**
	 * Deregister control
	 *
	 * @param Inc2734_WP_Customizer_Framework_Abstract_Control|string $Control
	 */
	public function deregister( $Control ) {
		if ( is_a( $Control, 'Inc2734_WP_Customizer_Framework_Abstract_Control' ) ) {
			$control_name = $Control->get_id();
			if ( isset( self::$controls[ $control_name ] ) ) {
				unset( self::$controls[ $control_name ] );
			}
		} else {
			$control_name = $Control;
			self::$removed_default_controls[] = $control_name;
		}
	}

	/**
	 * Create panel
	 *
	 * @param string $id
	 * @param array $args
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_panel/
	 */
	public function Panel( $id, array $args = array() ) {
		return new Inc2734_WP_Customizer_Framework_Panel( $id, $args );
	}

	/**
	 * Create panel
	 *
	 * @param string $id
	 * @param array $args
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_section/
	 */
	public function Section( $id, array $args = array() ) {
		return new Inc2734_WP_Customizer_Framework_Section( $id, $args );
	}

	/**
	 * Create panel
	 *
	 * @param string $type
	 * @param string $id
	 * @param array $args
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
	 */
	public function Control( $type, $id, $args ) {
		$class = 'Inc2734_WP_Customizer_Framework_Control_' . ucfirst( $type );
		if ( class_exists( $class ) ) {
			return new $class( $id, $args );
		}
		echo $class . ' is not found.';
		exit;
	}
}
