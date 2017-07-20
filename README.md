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

```
// When Using composer auto loader
// $Customizer = \Inc2734\WP_Customizer_Framework\Customizer_Framework::init();

// When not Using composer auto loader
include_once( get_theme_file_path( '/vendor/inc2734/wp-customizer-framework/src/wp-customizer-framework.php' ) );
$customizer = Inc2734_WP_Customizer_Framework::init();

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
```
