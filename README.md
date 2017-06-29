# WP Customizer Framework

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
$Customizer = Inc2734_WP_Customizer_Framework::init();

$Panel = $Customizer->Panel(
	'panel-name',
	[
		'title' => 'panel-name',
	]
);

$Section = $Customizer->Section(
	'section-name',
	[
		'title' => 'section-name',
	]
);

$Customizer->register( $Customizer->Control(
	'color', // Control type
	'control-id',
	[
		'label'   => 'Header Color',
		'default' => '#f00',
	]
) )->join( $Section )->join( $Panel );
```
