<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Customizer_Framework;

use Inc2734\WP_Customizer_Framework\App\Manager\Control_Manager;
use Inc2734\WP_Customizer_Framework\App\Style\Outputer;

/**
 * Framework for WordPress Theme Customization API
 *
 * @see https://codex.wordpress.org/Theme_Customization_API
 */
class Bootstrap {

	public function __construct() {
		add_action( 'wp_loaded', [ $this, '_load_styles' ], 11 );
		add_action( 'admin_enqueue_scripts', [ $this, '_admin_enqueue_scripts' ] );
		add_action( 'wp_head', [ $this, '_print_styles' ] );
		add_action( 'admin_head', [ $this, '_print_gutenberg_styles' ] );
		add_action( 'customize_register', array( $this, '_customize_register' ) );

		new Outputer();
	}

	/**
	 * The action hook for loading PHP files for styles.
	 * Customizer init on wp_loaded, so this action hook need to be after that.
	 *
	 * @return void
	 */
	public function _load_styles() {
		do_action( 'inc2734_wp_customizer_framework_load_styles' );
		do_action( 'inc2734_wp_customizer_framework_after_load_styles' );
	}

	/**
	 * Enqueue assets for admin page
	 *
	 * @return void
	 */
	public function _admin_enqueue_scripts() {
		$relative_path = '/vendor/inc2734/wp-customizer-framework/src/assets/js/wp-customizer-framework.js';
		$src  = get_template_directory_uri() . $relative_path;
		$path = get_template_directory() . $relative_path;

		wp_enqueue_script(
			'inc2734-wp-customizer-framework',
			$src,
			[ 'jquery' ],
			filemtime( $path ),
			true
		);
	}

	/**
	 * Print styles from registerd styles
	 *
	 * @return void
	 */
	public function _print_styles() {
		echo '<style id="wp-customizer-framework-print-styles">';
		do_action( 'inc2734_wp_customizer_framework_print_styles' );
		echo '</style>';
	}

	/**
	 * Print styles from registerd styles
	 *
	 * @return void
	 */
	public function _print_gutenberg_styles() {
		$screen = get_current_screen();
		if ( ! $screen || 'post' !== $screen->base ) {
			return;
		}

		$post = get_post();
		$use_gutenberg_plugin = function_exists( '\is_gutenberg_page' ) && \is_gutenberg_page();
		$use_block_editor     = function_exists( '\use_block_editor_for_post' ) && \use_block_editor_for_post( $post );

		if ( ! $post || ! $use_gutenberg_plugin && ! $use_block_editor ) {
			return;
		}

		echo '<style id="wp-customizer-framework-print-styles">';
		do_action( 'inc2734_wp_customizer_framework_print_gutenberg_styles' );
		echo '</style>';
	}

	/**
	 * Setup customizer
	 *
	 * @param WP_Customize_Manager $wp_customize
	 * @return void
	 */
	public function _customize_register( \WP_Customize_Manager $wp_customize ) {
		$controls = Control_Manager::get_controls();
		foreach ( $controls as $control ) {
			$wp_customize->add_setting( $control->get_id(), $control->get_setting_args() );

			if ( ! $control->section() ) {
				continue;
			}

			$control->register_control( $wp_customize );
			$section = $control->section();
			$panel   = $section->panel();

			$args = $section->get_args();
			if ( ! empty( $panel ) ) {
				$args = array_merge(
					$args,
					[
						'panel' => $panel->get_id(),
					]
				);
			}

			if ( ! $wp_customize->get_section( $section->get_id() ) && $args ) {
				$wp_customize->add_section( $section->get_id(), $args );
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
}
