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
	 * Registers style setting
	 *
	 * @param string|array $selectors
	 * @param string|array $properties
	 * @param string $media_query
	 * @return void
	 */
	public static function register( $selectors, $properties, $media_query = null ) {
		if ( ! is_array( $selectors ) ) {
			$selectors = explode( ',', $selectors );
		}

		if ( ! is_array( $properties ) ) {
			$properties = explode( ';', $properties );
		}

		static::$styles[] = [
			'selectors'   => $selectors,
			'properties'  => $properties,
			'media_query' => $media_query,
		];
	}

	/**
	 * Return registerd styles
	 *
	 * @return array
	 *  @var array selectors
	 *  @var array properties
	 *  @var string media_query
	 */
	public static function get_registerd_styles() {
		return static::$styles;
	}

	/**
	 * Set selectors. Styles of these selectors output like extend of Sass.
	 *
	 * @param string $placeholder
	 * @param array $selectors
	 * @return void
	 */
	public static function extend( $placeholder, array $selectors ) {
		Extender::extend( $placeholder, $selectors );
	}

	/**
	 * Register styles.
	 * You use Customizer_Framework->register method in $callback.
	 *
	 * @param string $placeholder
	 * @param function $callback
	 * @return void
	 */
	public static function placeholder( $placeholder, $callback ) {
		Extender::placeholder( $placeholder, $callback );
	}
}
