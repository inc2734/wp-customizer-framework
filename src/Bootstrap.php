<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Customizer_Framework;

use Inc2734\WP_Customizer_Framework\App\Manager\Control_Manager;
use Inc2734\WP_Customizer_Framework\App\Style\Outputer;
use Inc2734\WP_Customizer_Framework\App\Contract\Control\Control;
use Inc2734\WP_Customizer_Framework\App\Section;
use Inc2734\WP_Customizer_Framework\App\Panel;
use WP_Customize_Manager;

/**
 * Framework for WordPress Theme Customization API
 *
 * @see https://codex.wordpress.org/Theme_Customization_API
 */
class Bootstrap {

	/**
	 * @var array $args Array of argment.
	 */
	protected $args = [];

	/**
	 * Constructor.
	 *
	 * @param array $args Array of argment.
	 *   @var string $handle The main style handle.
	 */
	public function __construct( $args = [] ) {
		$this->args = $args;

		add_action( 'wp_loaded', [ $this, '_load_styles' ], 11 );
		add_action( 'customize_register', array( $this, '_customize_register' ) );
		add_action( 'admin_enqueue_scripts', [ $this, '_admin_enqueue_scripts' ] );
	}

	/**
	 * The action hook for loading PHP files for styles.
	 * Customizer init on wp_loaded, so this action hook need to be after that.
	 *
	 * @return void
	 */
	public function _load_styles() {
		do_action( 'inc2734_wp_customizer_framework_load_styles' );
	}

	/**
	 * Enqueue assets for admin page.
	 *
	 * @return void
	 */
	public function _admin_enqueue_scripts() {
		$relative_path = '/vendor/inc2734/wp-customizer-framework/src/assets/js/wp-customizer-framework.js';
		$src           = get_template_directory_uri() . $relative_path;
		$path          = get_template_directory() . $relative_path;

		wp_enqueue_script(
			'inc2734-wp-customizer-framework',
			$src,
			[ 'jquery' ],
			filemtime( $path ),
			true
		);
	}

	/**
	 * Print styles from registerd style tag with handle.
	 *
	 * @return void
	 */
	public function _enqueued_main_style() {
		do_action( 'inc2734_wp_customizer_framework_after_load_styles' );

		ob_start();
		$this->_print_styles();
		wp_add_inline_style( $this->args['handle'], ob_get_clean() );
	}

	/**
	 * Print styles from registerd style tag without handle.
	 *
	 * @return void
	 */
	public function _wp_print_scripts() {
		if ( is_admin() ) {
			return;
		}

		do_action( 'inc2734_wp_customizer_framework_after_load_styles' );

		echo '<style id="wp-customizer-framework-print-styles">';
		$this->_print_styles();
		echo '</style>';
	}

	/**
	 * Print styles from registerd styles.
	 *
	 * @return void
	 */
	protected function _print_styles() {
		do_action( 'inc2734_wp_customizer_framework_print_styles' );
	}

	/**
	 * Setup customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize WP_Customize_Manager object.
	 * @return void
	 */
	public function _customize_register( WP_Customize_Manager $wp_customize ) {
		$controls = Control_Manager::get_controls();
		foreach ( $controls as $control ) {
			$wp_customize->add_setting( $control->get_id(), $control->get_setting_args() );

			if ( ! $control->section() ) {
				continue;
			}

			$control->register_control( $wp_customize );
			$section      = $control->section();
			$section_args = $section->get_args();
			if ( ! $section_args ) {
				continue;
			}

			$panel = $section->panel();
			if ( ! empty( $panel ) && ! $panel->get_args() ) {
				continue;
			}

			$this->_join( $wp_customize, $control, $section, $panel );
		}
	}

	/**
	 * Join control to section and panel.
	 *
	 * @param WP_Customize_Manager $wp_customize WP_Customize_Manager object.
	 * @param Control              $control      Control object to join.
	 * @param Section              $section      Section object to join.
	 * @param Panel                $panel        Panel object to join.
	 * @return void
	 */
	protected function _join( WP_Customize_Manager $wp_customize, Control $control, Section $section, Panel $panel = null ) {
		$section_args = $section->get_args();

		if ( ! empty( $panel ) && $panel->get_args() ) {
			$section_args = array_merge(
				$section_args,
				[
					'panel' => $panel->get_id(),
				]
			);
		}

		if ( ! $wp_customize->get_section( $section->get_id() ) && $section_args ) {
			$wp_customize->add_section( $section->get_id(), $section_args );
		}

		if ( ! empty( $panel ) && ! $wp_customize->get_panel( $panel->get_id() ) ) {
			$wp_customize->add_panel( $panel->get_id(), $panel->get_args() );
		}

		$partial = $control->partial();
		if ( $partial ) {
			$wp_customize->selective_refresh->add_partial( $partial->get_id(), $partial->get_args() );
		}
	}
}
