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
### Customizer
```
// When Using composer auto loader
require_once( get_theme_file_path( '/vendor/autoload.php' ) );
$Customizer = \Inc2734\WP_Customizer_Framework\Customizer_Framework::init();

$customizer->panel( 'panel-id', [
  'title' => 'panel-name',
] );

$customizer->section( 'section-id', [
  'title' => 'section-name',
] );

$customizer->control( 'type' 'control-id', [
  'label'   => 'Header Color',
  'default' => '#f00',
] );

$panel = $customizer->panel( 'panel-id' );
$section = $customizer->section( 'section-id' );
$control = $customizer->control( 'control-id' );
$control->join( $section )->join( $panel );
$control->partial( [
	'selector' => '.blogname',
] );
```

### Set styles
```
add_action( 'wp_loaded', function() {
  $Customizer = \Inc2734\WP_Customizer_Framework\Customizer_Framework::init();
  $cfs = Customizer->styles();

  $accent_color = get_theme_mod( 'accent-color' );

  $cfs->register(
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
});
```
