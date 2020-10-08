<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

namespace Inc2734\WP_Customizer_Framework;

class Color {

	/**
	 * A little bit brighter.
	 *
	 * @param hex $hex The hex.
	 * @return hex
	 */
	public static function light( $hex ) {
		return static::lighten( $hex, 0.2 );
	}

	/**
	 * A little brighter.
	 *
	 * @param hex $hex The hex.
	 * @return hex
	 */
	public static function lighter( $hex ) {
		return static::lighten( $hex, 0.335 );
	}

	/**
	 * A brighter.
	 *
	 * @param hex $hex The hex.
	 * @return hex
	 */
	public static function lightest( $hex ) {
		return static::lighten( $hex, 0.37 );
	}

	/**
	 * A little bit dark.
	 *
	 * @param hex $hex The hex.
	 * @return hex
	 */
	public static function dark( $hex ) {
		return static::darken( $hex, 0.2 );
	}

	/**
	 * A little dark.
	 *
	 * @param hex $hex The hex.
	 * @return hex
	 */
	public static function darker( $hex ) {
		return static::darken( $hex, 0.335 );
	}

	/**
	 * A dark.
	 *
	 * @param hex $hex The hex.
	 * @return hex
	 */
	public static function darkest( $hex ) {
		return static::darken( $hex, 0.37 );
	}

	/**
	 * To brighten up.
	 *
	 * @param hex $hex     The hex.
	 * @param int $percent Percentage of luminance.
	 * @return hex
	 */
	public static function lighten( $hex, $percent ) {
		return static::_color_luminance( $hex, $percent );
	}

	/**
	 * To make it dark.
	 *
	 * @param hex $hex     The hex.
	 * @param int $percent Percentage of luminance.
	 * @return hex
	 */
	public static function darken( $hex, $percent ) {
		return static::_color_luminance( $hex, $percent * -1 );
	}

	/**
	 * hex to rgba.
	 *
	 * @param hex $hex     The hex.
	 * @param int $percent Percentage of alpha.
	 * @return rgba
	 */
	public static function rgba( $hex, $percent ) {
		$hex  = static::_hex_normalization( $hex );
		$rgba = [];

		for ( $i = 0; $i < 3; $i ++ ) {
			$dec    = hexdec( substr( $hex, $i * 2, 2 ) );
			$rgba[] = $dec;
		}

		$rgba = implode( ',', $rgba );
		$rgba = "rgba({$rgba}, $percent)";

		return $rgba;
	}

	/**
	 * Change brightness.
	 *
	 * @param hex $hex     The hex.
	 * @param int $percent Percentage of luminance.
	 * @return hex
	 */
	protected static function _color_luminance( $hex, $percent ) {
		$hex        = static::_hex_normalization( $hex );
		$hue        = static::_get_hue( $hex );
		$saturation = static::_get_saturation( $hex );
		$luminance  = static::_get_luminance( $hex );

		// Add luminance.
		$luminance += $percent * 100;
		$luminance  = ( 100 < $luminance ) ? 100 : $luminance;
		$luminance  = ( 0 > $luminance ) ? 0 : $luminance;

		$hex = static::_convert_hsl_to_hex( $hue, $saturation, $luminance );
		return $hex;
	}

	/**
	 * Normalize hex.
	 *
	 * .e.g  #000000 -> 000000
	 * .e.g  #000 -> 000000
	 *
	 * @param hex $hex The hex.
	 * @return hex
	 */
	protected static function _hex_normalization( $hex ) {
		$hex = preg_replace( '/[^0-9a-f]/i', '', ltrim( $hex, '#' ) );

		if ( ! $hex ) {
			return $hex;
		}

		if ( strlen( $hex ) < 6 ) {
			$hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
		}

		return $hex;
	}

	/**
	 * Return hue from hex.
	 *
	 * @param hex $hex The hex.
	 * @return hue
	 */
	private static function _get_hue( $hex ) {
		$red   = hexdec( substr( $hex, 0, 2 ) );
		$green = hexdec( substr( $hex, 2, 2 ) );
		$blue  = hexdec( substr( $hex, 4, 2 ) );

		if ( $red === $green && $red === $blue ) {
			return 0;
		}

		$hue = static::_get_hue_based_max_rgb( $red, $green, $blue );

		if ( 0 > $hue ) {
			$hue += 360;
		}

		return $hue;
	}

	/**
	 * Return hue from max rgb.
	 *
	 * @param dec $red   The red.
	 * @param dec $green The green.
	 * @param dec $blue  The blue.
	 * @return hue
	 */
	private static function _get_hue_based_max_rgb( $red, $green, $blue ) {
		$max_rgb = max( $red, $green, $blue );
		$min_rgb = min( $red, $green, $blue );

		$diff_max_min_rgb = $max_rgb - $min_rgb;

		if ( $red === $max_rgb ) {
			$hue = 60 * ( $diff_max_min_rgb ? ( $green - $blue ) / $diff_max_min_rgb : 0 );
		} elseif ( $green === $max_rgb ) {
			$hue = 60 * ( $diff_max_min_rgb ? ( $blue - $red ) / $diff_max_min_rgb : 0 ) + 120;
		} elseif ( $blue === $max_rgb ) {
			$hue = 60 * ( $diff_max_min_rgb ? ( $red - $green ) / $diff_max_min_rgb : 0 ) + 240;
		}

		return $hue;
	}

	/**
	 * Return saturation from hex.
	 *
	 * @param hex $hex The hex.
	 * @return saturation
	 */
	private static function _get_saturation( $hex ) {
		$red     = hexdec( substr( $hex, 0, 2 ) );
		$green   = hexdec( substr( $hex, 2, 2 ) );
		$blue    = hexdec( substr( $hex, 4, 2 ) );
		$max_rgb = max( $red, $green, $blue );
		$min_rgb = min( $red, $green, $blue );

		$cnt = round( ( $max_rgb + $min_rgb ) / 2 );
		if ( 127 >= $cnt ) {
			$tmp        = ( $max_rgb + $min_rgb );
			$saturation = $tmp ? ( $max_rgb - $min_rgb ) / $tmp : 0;
		} else {
			$tmp        = ( 510 - $max_rgb - $min_rgb );
			$saturation = ( $tmp ) ? ( ( $max_rgb - $min_rgb ) / $tmp ) : 0;
		}
		return $saturation * 100;
	}

	/**
	 * Return luminance from hex.
	 *
	 * @param hex $hex The hex.
	 * @return luminance
	 */
	private static function _get_luminance( $hex ) {
		$red     = hexdec( substr( $hex, 0, 2 ) );
		$green   = hexdec( substr( $hex, 2, 2 ) );
		$blue    = hexdec( substr( $hex, 4, 2 ) );
		$max_rgb = max( $red, $green, $blue );
		$min_rgb = min( $red, $green, $blue );

		return ( $max_rgb + $min_rgb ) / 2 / 255 * 100;
	}

	/**
	 * Convert hsl to hex.
	 *
	 * @param hue        $hue        The heu.
	 * @param saturation $saturation The saturation.
	 * @param luminance  $luminance  The luminance.
	 * @return hex
	 */
	private static function _convert_hsl_to_hex( $hue, $saturation, $luminance ) {
		if ( 49 >= $luminance ) {
			$max_hsl = 2.55 * ( $luminance + $luminance * ( $saturation / 100 ) );
			$min_hsl = 2.55 * ( $luminance - $luminance * ( $saturation / 100 ) );
		} else {
			$max_hsl = 2.55 * ( $luminance + ( 100 - $luminance ) * ( $saturation / 100 ) );
			$min_hsl = 2.55 * ( $luminance - ( 100 - $luminance ) * ( $saturation / 100 ) );
		}

		if ( 60 >= $hue ) {
			$red   = $max_hsl;
			$green = ( $hue / 60 ) * ( $max_hsl - $min_hsl ) + $min_hsl;
			$blue  = $min_hsl;
		} elseif ( 120 >= $hue ) {
			$red   = ( ( 120 - $hue ) / 60 ) * ( $max_hsl - $min_hsl ) + $min_hsl;
			$green = $max_hsl;
			$blue  = $min_hsl;
		} elseif ( 180 >= $hue ) {
			$red   = $min_hsl;
			$green = $max_hsl;
			$blue  = ( ( $hue - 120 ) / 60 ) * ( $max_hsl - $min_hsl ) + $min_hsl;
		} elseif ( 240 >= $hue ) {
			$red   = $min_hsl;
			$green = ( ( 240 - $hue ) / 60 ) * ( $max_hsl - $min_hsl ) + $min_hsl;
			$blue  = $max_hsl;
		} elseif ( 300 >= $hue ) {
			$red   = ( ( $hue - 240 ) / 60 ) * ( $max_hsl - $min_hsl ) + $min_hsl;
			$green = $min_hsl;
			$blue  = $max_hsl;
		} else {
			$red   = $max_hsl;
			$green = $min_hsl;
			$blue  = ( ( 360 - $hue ) / 60 ) * ( $max_hsl - $min_hsl ) + $min_hsl;
		}

		$red   = sprintf( '%02s', dechex( round( $red ) ) );
		$green = sprintf( '%02s', dechex( round( $green ) ) );
		$blue  = sprintf( '%02s', dechex( round( $blue ) ) );

		return '#' . $red . $green . $blue;
	}
}
