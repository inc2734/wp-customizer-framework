<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Customizer_Framework\App;

use Inc2734\WP_Customizer_Framework\Style;
use Inc2734\WP_Customizer_Framework\Color;

/**
 * Old style class
 *
 * @deprecated
 */
class Styles {

	/**
	 * @var Styles
	 */
	protected static $instance;

	/**
	 * Constructor.
	 */
	protected function __construct() {
	}

	/**
	 * Initialie.
	 *
	 * @return Styles
	 */
	public static function init() {
		if ( is_null( static::$instance ) ) {
			static::$instance = new self();
		}
		return static::$instance;
	}

	/**
	 * Registers style setting.
	 *
	 * @param string|array $selectors   Target selectors.
	 * @param string|array $properties  Properties.
	 * @param string       $media_query Media query.
	 * @return void
	 */
	public function register( $selectors, $properties, $media_query = null ) {
		Style::register( $selectors, $properties, $media_query );
	}

	/**
	 * A little bit brighter.
	 *
	 * @param hex $hex The hex.
	 * @return hex
	 */
	public function light( $hex ) {
		return Color::light( $hex );
	}

	/**
	 * A little brighter.
	 *
	 * @param hex $hex The hex.
	 * @return hex
	 */
	public function lighter( $hex ) {
		return Color::lighter( $hex );
	}

	/**
	 * A brighter.
	 *
	 * @param hex $hex The hex.
	 * @return hex
	 */
	public function lightest( $hex ) {
		return Color::lightest( $hex );
	}

	/**
	 * A little bit dark.
	 *
	 * @param hex $hex The hex.
	 * @return hex
	 */
	public function dark( $hex ) {
		return Color::dark( $hex );
	}

	/**
	 * A little dark.
	 *
	 * @param hex $hex The hex.
	 * @return hex
	 */
	public function darker( $hex ) {
		return Color::darker( $hex );
	}

	/**
	 * A dark.
	 *
	 * @param hex $hex The hex.
	 * @return hex
	 */
	public function darkest( $hex ) {
		return Color::darkest( $hex );
	}

	/**
	 * hex to rgba.
	 *
	 * @param hex $hex     The hex.
	 * @param int $percent Percentage of alpha.
	 * @return rgba
	 */
	public function rgba( $hex, $percent ) {
		return Color::rgba( $hex, $percent );
	}
}
