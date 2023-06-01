<?php
use Inc2734\WP_Customizer_Framework\Framework;

class Framework_Test extends WP_UnitTestCase {

	public function set_up() {
		parent::set_up();
	}

	public function tear_down() {
		parent::tear_down();
	}

	/**
	 * @test
	 */
	public function panel() {
		$panel = Framework::panel(
			'panel-name',
			[
				'title' => 'panel-name',
			]
		);
		$this->assertTrue( is_a( $panel, '\Inc2734\WP_Customizer_Framework\App\Panel' ) );
	}

	/**
	 * @test
	 */
	public function section() {
		$section = Framework::section(
			'section-name',
			[
				'title' => 'section-name',
			]
		);
		$this->assertTrue( is_a( $section, '\Inc2734\WP_Customizer_Framework\App\Section' ) );
	}

	/**
	 * @test
	 */
	public function control() {
		$control = Framework::Control(
			'color',
			'control-name',
			[
				'label'   => 'Header Color',
				'default' => '#f00',
			]
		);
		$this->assertTrue( is_a( $control, '\Inc2734\WP_Customizer_Framework\App\Control\Color' ) );
	}

	/**
	 * @test
	 */
	public function get_panel() {
		$panel = Framework::get_panel( 'panel-name' );
		$this->assertTrue( is_a( $panel, '\Inc2734\WP_Customizer_Framework\App\Panel' ) );
	}

	/**
	 * @test
	 */
	public function get_section() {
		$section = Framework::get_section( 'section-name' );
		$this->assertTrue( is_a( $section, '\Inc2734\WP_Customizer_Framework\App\Section' ) );
	}

	/**
	 * @test
	 */
	public function get_control() {
		$control = Framework::get_control( 'control-name' );
		$this->assertTrue( is_a( $control, '\Inc2734\WP_Customizer_Framework\App\Control\Color' ) );
	}
}
