<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Customizer_Framework\App\Style;

use Inc2734\WP_Customizer_Framework;

class Outputer {

	public function __construct() {
		add_action( 'inc2734_wp_customizer_framework_print_styles', [ $this, '_print_front_styles' ] );
		add_action( 'amp_post_template_css', [ $this, '_amp_post_template_css' ] );
		add_filter( 'tiny_mce_before_init', [ $this, '_enqueue_classic_editor_style' ], 11 );
		add_filter( 'block_editor_settings', [ $this, '_enqueue_block_editor_style' ], 11 );
	}

	/**
	 * Styles for front-end
	 *
	 * @return void
	 */
	public function _print_front_styles() {
		$styles = WP_Customizer_Framework\Style::get_registerd_styles();

		$this->_print_styles( $styles );
	}

	/**
	 * Styles for AMP
	 *
	 * @return void
	 */
	public function _amp_post_template_css() {
		ob_start();
		$this->_print_front_styles();
		$css = ob_get_clean();
		$css = str_replace( '!important', '', $css );
		// @codingStandardsIgnoreStart
		echo $css;
		// @codingStandardsIgnoreEnd
	}

	/**
	 * Styles for TinyMCE
	 *
	 * @param array $mce_init
	 * @return array
	 */
	public function _enqueue_classic_editor_style( $mce_init ) {
		$styles = WP_Customizer_Framework\Style::get_registerd_styles();

		if ( ! isset( $mce_init['content_style'] ) ) {
			$mce_init['content_style'] = '';
		}

		foreach ( $styles as $style ) {
			foreach ( $style['selectors'] as $i => $selector ) {
				$selector = trim( $selector );
				if ( preg_match( '|^[\.#>]|', $selector ) ) {
					$style['selectors'][ $i ] = '.mce-content-body.mceContentBody ' . $selector;
				} else {
					$style['selectors'][ $i ] = $selector;
				}
			}

			$selectors  = addslashes( implode( ',', $style['selectors'] ) );
			$properties = addslashes( implode( ';', $style['properties'] ) );

			if ( ! $style['media_query'] ) {
				$mce_init['content_style'] .= "{$selectors} { {$properties} }";
			} else {
				$mce_init['content_style'] .= "{$style['media_query']} { {$selectors} { {$properties} } }";
			}
		}
		return $mce_init;
	}

	/**
	 * Styles for block editor
	 *
	 * @param array $mce_init
	 * @return array
	 */
	public function _enqueue_block_editor_style( $settings ) {
		do_action( 'inc2734_wp_customizer_framework_after_load_styles' );

		$styles = WP_Customizer_Framework\Style::get_registerd_styles();
		ob_start();
		$this->_print_styles( $styles );
		$css = ob_get_clean();
		$settings['styles'][] = [
			'css'     => $css,
			'baseURL' => null,
		];

		return $settings;
	}

	/**
	 * Print styles in head
	 *
	 * @param array $styles
	 * @return void
	 */
	protected function _print_styles( $styles ) {
		foreach ( $styles as $style ) {
			$selectors  = implode( ',', $style['selectors'] );
			$properties = implode( ';', $style['properties'] );

			if ( ! $style['media_query'] ) {
				printf(
					'%1$s { %2$s }',
					// @todo
					// @codingStandardsIgnoreStart
					strip_tags( $selectors ),
					str_replace( '&quot;', '"', esc_textarea( $properties ) )
					// @codingStandardsIgnoreEnd
				);
			} else {
				printf(
					'%1$s { %2$s { %3$s } }',
					esc_html( $style['media_query'] ),
					// @todo
					// @codingStandardsIgnoreStart
					strip_tags( $selectors ),
					str_replace( '&quot;', '"', esc_textarea( $properties ) )
					// @codingStandardsIgnoreEnd
				);
			}
		}
	}
}
