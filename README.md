# WP Customizer Framework

[![Build Status](https://travis-ci.org/inc2734/wp-customizer-framework.svg?branch=master)](https://travis-ci.org/inc2734/wp-customizer-framework)
[![Latest Stable Version](https://poser.pugx.org/inc2734/wp-customizer-framework/v/stable)](https://packagist.org/packages/inc2734/wp-customizer-framework)
[![License](https://poser.pugx.org/inc2734/wp-customizer-framework/license)](https://packagist.org/packages/inc2734/wp-customizer-framework)

A Framework of WordPress Customizer API.

## Install

In your theme directory.

```
$ composer require inc2734/wp-customizer-framework
```

## How to use
### Initialize
```
require_once( get_theme_file_path( '/vendor/autoload.php' ) );

new \Inc2734\WP_Customizer_Framework\Bootstrap();
```

### Customizer
```
use Inc2734\WP_Customizer_Framework\Framework;

Framework::panel( 'panel-id', [
  'title' => 'panel-name',
] );

Framework::section( 'section-id', [
  'title' => 'section-name',
] );

Framework::control( 'type' 'control-id', [
  'label'   => 'Header Color',
  'default' => '#f00',
] );

$panel   = Framework::get_panel( 'panel-id' );
$section = Framework::get_section( 'section-id' );
$control = Framework::get_control( 'control-id' );

$control->join( $section )->join( $panel );
$control->partial( [
	'selector' => '.blogname',
] );
```

### Set styles
```
use Inc2734\WP_Customizer_Framework\Style;

add_action(
  'inc2734_wp_customizer_framework_load_styles',
  function() {
    $accent_color = get_theme_mod( 'accent-color' );

    Style::register(
      [
        '.page-title',
        '.strong',
      ],
      [
        "color: {$accent_color}",
        "border-bottom-color: {$accent_color}",
      ],
      '@media (min-width: 768px)' // Optional
    );
  }
);
```

#### Using placeholder
```
use Inc2734\WP_Customizer_Framework\Style;

add_action(
  'inc2734_wp_customizer_framework_load_styles',
  function() {
    /**
     * Extend "btn-base" placeholder
     *
     * Style::extend( 'btn-base', [ '.btn-a' ] );
     */
    include_once( get_theme_file_path( '/css/btn-a.php' ) );

    /**
     * Extend "btn-base" placeholder
     *
     * Style::extend( 'btn-base', [ '.btn-b' ] );
     */
    include_once( get_theme_file_path( '/css/btn-b.php' ) );

    /**
     * Extend "btn-base" placeholder
     *
     * Style::extend( 'btn-base', [ '.btn-c' ] );
     */
    include_once( get_theme_file_path( '/css/btn-c.php' ) );
  }
);

add_action(
  'inc2734_wp_customizer_framework_after_load_styles',
  function() {
    Style::placeholder(
      'btn-base',
      function( $selectors ) {
        $accent_color = get_theme_mod( 'accent-color' );

        Style::register(
          $selectors,
          'border-color: ' . $accent_color
        );
      }
    );
  }
);
```
