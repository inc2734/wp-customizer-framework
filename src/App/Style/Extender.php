<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Customizer_Framework\App\Style;

class Extender {

	/**
	 * Placeholders.
	 *
	 * @var array
	 */
	protected static $placeholders = [];

	/**
	 * Set selectors. Styles of these selectors output like extend of Sass.
	 *
	 * @param string $placeholder Sass placeholder.
	 * @param array  $selectors   Target selectors.
	 * @return void
	 */
	public static function extend( $placeholder, array $selectors ) {
		if ( ! isset( static::$placeholders[ $placeholder ] ) ) {
			static::$placeholders[ $placeholder ] = [];
		}

		static::$placeholders[ $placeholder ] = array_merge(
			static::$placeholders[ $placeholder ],
			$selectors
		);
	}

	/**
	 * Register styles.
	 * You use Customizer_Framework->register method in $callback.
	 *
	 * @param string   $placeholder Sass placeholder.
	 * @param function $callback    Callback function.
	 * @return void
	 */
	public static function placeholder( $placeholder, $callback ) {
		if ( ! isset( static::$placeholders[ $placeholder ] ) ) {
			return;
		}

		$callback( static::$placeholders[ $placeholder ] );
	}
}
