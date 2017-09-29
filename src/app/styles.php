<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * Output styles based Customizer
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class Inc2734_WP_Customizer_Framework_Styles {

	/**
	 * Style settings
	 * @var array
	 *        - array selectors
	 *        - array properties
	 *        - string media_query
	 */
	protected $styles = [];

	public function __construct() {
		add_filter( 'tiny_mce_before_init', function( $mce_init ) {
			if ( ! isset( $mce_init['content_style'] ) ) {
				$mce_init['content_style'] = '';
			}
			return $mce_init;
		}, 9 );

		add_action( 'wp_print_styles', [ $this, '_wp_print_styles' ] );
		add_filter( 'tiny_mce_before_init', [ $this, '_tiny_mce_before_init' ] );
	}

	/**
	 * Styles for front-end
	 *
	 * @return void
	 */
	public function _wp_print_styles() {
		echo '<style>';
		foreach ( $this->styles as $style ) {
			foreach ( $style['selectors'] as $i => $selector ) {
				$style['selectors'][ $i ] = 'body ' . $selector;
			}

			$selectors  = implode( ',', $style['selectors'] );
			$properties = implode( ';', $style['properties'] );

			if ( ! $style['media_query'] ) {
				printf(
					'%1$s { %2$s }',
					// @todo
					// @codingStandardsIgnoreStart
					strip_tags( $selectors ),
					// @codingStandardsIgnoreEnd
					esc_textarea( $properties )
				);
			} else {
				printf(
					'%1$s { %2$s { %3$s } }',
					esc_html( $style['media_query'] ),
					// @todo
					// @codingStandardsIgnoreStart
					strip_tags( $selectors ),
					// @codingStandardsIgnoreEnd
					esc_textarea( $properties )
				);
			}
		}
		echo '</style>';
	}

	/**
	 * Styles for TinyMCE
	 *
	 * @param array $mce_init
	 * @return array
	 */
	public function _tiny_mce_before_init( $mce_init ) {
		foreach ( $this->styles as $style ) {
			foreach ( $style['selectors'] as $i => $selector ) {
				$style['selectors'][ $i ] = '.mce-content-body.wp-editor ' . $selector;
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
	 * Registers style setting
	 *
	 * @param string|array $selectors
	 * @param string|array $properties
	 * @param string $media_query
	 * @return void
	 */
	public function register( $selectors, $properties, $media_query = null ) {
		if ( ! is_array( $selectors ) ) {
			$selectors = explode( ',', $selectors );
		}

		if ( ! is_array( $properties ) ) {
			$properties = explode( ';', $properties );
		}

		$this->styles[] = [
			'selectors'   => $selectors,
			'properties'  => $properties,
			'media_query' => $media_query,
		];
	}

	/**
	 * A little bit brighter
	 *
	 * @param hex $hex
	 * @return hex
	 */
	public function light( $hex ) {
		return $this->_color_luminance( $hex, 0.2 );
	}

	/**
	 * A little brighter
	 *
	 * @param hex $hex
	 * @return hex
	 */
	public function lighter( $hex ) {
		return $this->_color_luminance( $hex, 0.335 );
	}

	/**
	 * A brighter
	 *
	 * @param hex $hex
	 * @return hex
	 */
	public function lightest( $hex ) {
		return $this->_color_luminance( $hex, 0.37 );
	}

	/**
	 * A little bit dark
	 *
	 * @param hex $hex
	 * @return hex
	 */
	public function dark( $hex ) {
		return $this->_color_luminance( $hex, -0.2 );
	}

	/**
	 * A little dark
	 *
	 * @param hex $hex
	 * @return hex
	 */
	public function darker( $hex ) {
		return $this->_color_luminance( $hex, -0.335 );
	}

	/**
	 * A dark
	 *
	 * @param hex $hex
	 * @return hex
	 */
	public function darkest( $hex ) {
		return $this->_color_luminance( $hex, -0.37 );
	}

	/**
	 * To brighten up
	 *
	 * @param hex $hex
	 * @param int $percent
	 * @return hex
	 */
	public function lighten( $hex, $percent ) {
		return $this->_color_luminance( $hex, $percent );
	}

	/**
	 * To make it dark
	 *
	 * @param hex $hex
	 * @param int $percent
	 * @return hex
	 */
	public function darken( $hex, $percent ) {
		return $this->_color_luminance( $hex, $percent * -1 );
	}

	/**
	 * Change brightness
	 *
	 * @param hex $hex
	 * @param int $percent
	 * @return hex
	 */
	protected function _color_luminance( $hex, $percent ) {
		$hex = $this->_hex_normalization( $hex );
		$new_hex = '#';

		for ( $i = 0; $i < 3; $i ++ ) {
			$dec = hexdec( substr( $hex, $i * 2, 2 ) );
			$dec = round( $dec * ( 100 + ( $percent * 100 * 2 ) ) / 100 );
			$new_hex .= str_pad( dechex( $dec ) , 2, 0, STR_PAD_LEFT );
		}

		return $new_hex;
	}

	/**
	 * hex to rgba
	 *
	 * @param hex $hex
	 * @param int $percent
	 * @return rgba
	 */
	public function rgba( $hex, $percent ) {
		$hex = $this->_hex_normalization( $hex );
		$rgba = [];

		for ( $i = 0; $i < 3; $i ++ ) {
			$dec = hexdec( substr( $hex, $i * 2, 2 ) );
			$rgba[] = $dec;
		}

		$rgba = implode( ',', $rgba );
		$rgba = "rgba({$rgba}, $percent)";

		return $rgba;
	}

	/**
	 * Normalize hex
	 * .e.g  #000000 -> 000000
	 * .e.g  #000 -> 000000
	 *
	 * @param hex $hex
	 * @return hex
	 */
	protected function _hex_normalization( $hex ) {
		$hex = preg_replace( '/[^0-9a-f]/i', '', ltrim( $hex, '#' ) );

		if ( strlen( $hex ) < 6 ) {
			$hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
		}

		return $hex;
	}
}
