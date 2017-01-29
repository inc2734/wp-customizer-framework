# Customizer Framework

A Framework of WordPress Customizer API.

## Install

In your theme directory.

```
$ composer require inc2734/customizer_framework;
```

## How to use
```
$Customizer = new \Inc2734\CustomizerFramework\CustomizerFramework();

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
