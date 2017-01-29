<?php
namespace Inc2734\CustomizerFramework;

class CustomizerFramework {

	protected $controls = [];

	public function __construct() {
		add_action( 'customize_register', [ $this, 'customize_register' ] );
	}

	public function customize_register( \WP_Customize_Manager $wp_customize ) {
		foreach ( $this->controls as $Control ) {
			$wp_customize->add_setting( $Control->get_id(), $Control->get_args() );
			$Control->register_control( $wp_customize );
			$Section = $Control->Section();
			$Panel = $Section->Panel();
			$wp_customize->add_section( $Section->get_id(), array_merge(
				$Section->get_args(), [
					'panel' => $Panel->get_id(),
				]
			) );
			$wp_customize->add_panel( $Panel->get_id(), $Panel->get_args() );
		}
	}

	public function register( App\Controller\Control $Control ) {
		$this->controls[ $Control->get_id() ] = $Control;
		return $this->controls[ $Control->get_id() ];
	}

	public function Panel( $id, $args ) {
		return new App\Controller\Panel( $id, $args );
	}

	public function Section( $id, $args ) {
		return new App\Controller\Section( $id, $args );
	}

	public function Control( $type, $id, $args ) {
		$class = '\Inc2734\CustomizerFramework\App\Controller\Control\\' . ucfirst( $type );
		if ( class_exists( $class ) ) {
			return new $class( $id, $args );
		}
		echo $class . ' is not found.';
		exit;
	}
}
