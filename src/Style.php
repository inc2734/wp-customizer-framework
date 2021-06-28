<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Customizer_Framework;

use Inc2734\WP_Customizer_Framework\App\Style\Extender;

class Style {

	/**
	 * Style settings
	 *
	 * @var array
	 *  array selectors
	 *  array properties
	 *  string media_query
	 */
	protected static $styles = [];

	/**
	 * Registers style setting.
	 *
	 * @param string $handle The handle of enqueued style.
	 * @param array  $styles Array of style data.
	 *   @var string|array $selectors Target selectors.
	 *   @var string|array $properties Properties.
	 *   @var string       $media_query Media query.
	 */
	public static function attach( $handle, array $styles ) {
		foreach ( $styles as $style ) {
			$selectors = isset( $style['selectors'] ) ? $style['selectors'] : [];
			if ( ! is_array( $style['selectors'] ) ) {
				$selectors = explode( ',', $style['selectors'] );
			}
			if ( ! $selectors ) {
				continue;
			}

			$properties = isset( $style['properties'] ) ? $style['properties'] : [];
			if ( ! is_array( $style['properties'] ) ) {
				$properties = explode( ';', $style['properties'] );
			}
			if ( ! $properties ) {
				continue;
			}

			$sanitized_properties = [];

			// $key ... index or property
			// @value ... property value or property: property value
			foreach ( $properties as $key => $value ) {
				if ( is_int( $key ) ) {
					if ( preg_match( '/:\s*$/', $value ) ) {
						continue;
					}
				} else {
					if ( is_null( $value ) || '' === $value ) {
						continue;
					}
				}

				$sanitized_properties[ $key ] = $value;
			}
			if ( ! $sanitized_properties ) {
				continue;
			}

			$media_query = isset( $style['media_query'] ) ? $style['media_query'] : '';

			$new_style = [
				'selectors'   => $selectors,
				'properties'  => $sanitized_properties,
				'media_query' => $media_query,
			];

			ob_start();
			if ( ! $new_style['media_query'] ) {
				printf(
					'%1$s { %2$s }',
					// @codingStandardsIgnoreStart
					strip_tags( implode( ',', $new_style['selectors'] ) ),
					str_replace( '&quot;', '"', esc_textarea( implode( ';', $new_style['properties'] ) ) )
					// @codingStandardsIgnoreEnd
				);
			} else {
				printf(
					'%1$s { %2$s { %3$s } }',
					esc_html( $new_style['media_query'] ),
					// @codingStandardsIgnoreStart
					strip_tags( implode( ',', $new_style['selectors'] ) ),
					str_replace( '&quot;', '"', esc_textarea( implode( ';', $new_style['properties'] ) ) )
					// @codingStandardsIgnoreEnd
				);
			}

			$css = ob_get_clean();

			// For front
			if ( $handle ) {
				add_action(
					'wp_enqueue_scripts',
					function() use ( $handle, $css ) {
						wp_styles()->add_inline_style( $handle, $css );
					},
					11
				);

				add_action(
					'enqueue_block_assets',
					function() use ( $handle, $css ) {
						wp_styles()->add_inline_style( $handle, $css );
					},
					11
				);
			} else {
				add_action(
					'wp_print_scripts',
					function() use ( $css ) {
						if ( is_admin() ) {
							return;
						}

						echo '<style data-id="wp-customizer-framework-print-styles">';
						echo $css; // xss ok.
						echo '</style>';
					}
				);
			}

			// For editor
			add_action(
				'enqueue_block_editor_assets',
				function() use ( $handle, $css ) {
					wp_styles()->add_inline_style( $handle, $css );
				},
				11
			);

			// For classic editor
			add_filter(
				'tiny_mce_before_init',
				function( $mce_init ) use ( $new_style ) {
					if ( ! isset( $mce_init['content_style'] ) ) {
						$mce_init['content_style'] = '';
					}

					foreach ( $new_style['selectors'] as $i => $selector ) {
						$selector = trim( $selector );
						if ( preg_match( '|^[\.#>]|', $selector ) ) {
							$new_style['selectors'][ $i ] = '.mce-content-body.mceContentBody ' . $selector;
						} else {
							$new_style['selectors'][ $i ] = $selector;
						}
					}

					$selectors  = addslashes( implode( ',', $new_style['selectors'] ) );
					$properties = addslashes( implode( ';', $new_style['properties'] ) );

					if ( ! $new_style['media_query'] ) {
						$mce_init['content_style'] .= "{$selectors} { {$properties} }";
					} else {
						$mce_init['content_style'] .= "{$new_style['media_query']} { {$selectors} { {$properties} } }";
					}

					return $mce_init;
				},
				11
			);

			// For AMP
			add_action(
				'amp_post_template_css',
				function() use ( $css ) {
					$css = str_replace( '!important', '', $css );
					echo $css; // xss ok.
				}
			);
		}
	}

	/**
	 * Registers style setting.
	 *
	 * @param string|array $selectors Target selectors.
	 * @param string|array $properties Properties.
	 * @param string       $media_query Media query.
	 */
	public static function register( $selectors, $properties, $media_query = null ) {
		_deprecated_function(
			'\Inc2734\WP_Customizer_Framework\Style::register',
			'inc2734/wp-customizer-framework 9.0.0',
			'\Inc2734\WP_Customizer_Framework\Style::attach'
		);

		if ( ! is_array( $selectors ) ) {
			$selectors = explode( ',', $selectors );
		}

		if ( ! is_array( $properties ) ) {
			$properties = explode( ';', $properties );
		}

		$sanitized_properties = [];

		// $key ... index or property
		// @value ... property value or property: property value
		foreach ( $properties as $key => $value ) {
			if ( is_int( $key ) ) {
				if ( preg_match( '/:\s*$/', $value ) ) {
					continue;
				}
			} else {
				if ( is_null( $value ) || '' === $value ) {
					continue;
				}
			}

			$sanitized_properties[ $key ] = $value;
		}

		if ( ! $sanitized_properties ) {
			return;
		}

		$styles = [
			[
				'selectors'   => $selectors,
				'properties'  => $sanitized_properties,
				'media_query' => $media_query,
			],
		];

		static::attach( null, $styles );
	}

	/**
	 * Return registerd styles.
	 *
	 * @return array
	 *  @var array selectors
	 *  @var array properties
	 *  @var string media_query
	 */
	public static function get_registerd_styles() {
		_deprecated_function(
			'\Inc2734\WP_Customizer_Framework\Style::get_registerd_styles',
			'inc2734/wp-customizer-framework 9.0.0'
		);

		return static::$styles;
	}

	/**
	 * Set selectors. Styles of these selectors output like extend of Sass.
	 *
	 * @param string $placeholder Sass placeholder.
	 * @param array  $selectors Target selectors.
	 * @return void
	 */
	public static function extend( $placeholder, array $selectors ) {
		Extender::extend( $placeholder, $selectors );
	}

	/**
	 * Register styles.
	 * You use Customizer_Framework->register method in $callback.
	 *
	 * @param string   $placeholder Sass placeholder.
	 * @param function $callback The callback function.
	 * @return void
	 */
	public static function placeholder( $placeholder, $callback ) {
		Extender::placeholder( $placeholder, $callback );
	}
}
