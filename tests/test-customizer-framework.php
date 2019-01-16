<?php
use Inc2734\WP_Customizer_Framework\Customizer_Framework;

class Customizer_Framework_Test extends WP_UnitTestCase {

	public function setup() {
		parent::setup();
	}

	public function tearDown() {
		parent::tearDown();
	}

	/**
	 * @test
	 */
	public function init() {
		$customizer_framework = Customizer_Framework::init();
		$this->assertTrue( is_a( $customizer_framework, '\Inc2734\WP_Customizer_Framework\Customizer_Framework' ) );
	}

	/**
	 * @test
	 */
	public function styles() {
		$cfs = Customizer_Framework::styles();
		$this->assertTrue( is_a( $cfs, '\Inc2734\WP_Customizer_Framework\App\Styles' ) );
	}

	/**
	 * @test
	 */
	public function panel() {
		$customizer_framework = Customizer_Framework::init();
		$panel = $customizer_framework->panel(
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
		$customizer_framework = Customizer_Framework::init();
		$section = $customizer_framework->section(
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
		$customizer_framework = Customizer_Framework::init();
		$control = $customizer_framework->Control(
			'color',
			'control-name',
			[
				'label'   => 'Header Color',
				'default' => '#f00',
			]
		);
		$this->assertTrue( is_a( $control, '\Inc2734\WP_Customizer_Framework\App\Control\Abstract_Control' ) );
	}

	/**
	 * @test
	 */
	public function get_panel() {
		$customizer_framework = Customizer_Framework::init();
		$panel = $customizer_framework->get_panel( 'panel-name' );
		$this->assertTrue( is_a( $panel, '\Inc2734\WP_Customizer_Framework\App\Panel' ) );
	}

	/**
	 * @test
	 */
	public function get_section() {
		$customizer_framework = Customizer_Framework::init();
		$section = $customizer_framework->get_section( 'section-name' );
		$this->assertTrue( is_a( $section, '\Inc2734\WP_Customizer_Framework\App\Section' ) );
	}

	/**
	 * @test
	 */
	public function get_control() {
		$customizer_framework = Customizer_Framework::init();
		$control = $customizer_framework->get_control( 'control-name' );
		$this->assertTrue( is_a( $control, '\Inc2734\WP_Customizer_Framework\App\Control\Color' ) );
	}
}
