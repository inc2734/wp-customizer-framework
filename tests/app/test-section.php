<?php
class Inc2734_WP_Customizer_Framework_Section_Test extends WP_UnitTestCase {

	public function setup() {
		include_once( __DIR__ . '/../../src/app/section.php' );
		include_once( __DIR__ . '/../../src/app/panel.php' );
		parent::setup();
	}

	public function tearDown() {
		parent::tearDown();
	}

	/**
	 * @test
	 */
	public function get_id() {
		$section = new Inc2734_WP_Customizer_Framework_Section( 'section-name', [
			'title' => 'section-name',
		] );
		$this->assertEquals( 'section-name', $section->get_id() );
	}

	/**
	 * @test
	 */
	public function get_args() {
		$section = new Inc2734_WP_Customizer_Framework_Section( 'section-name', [
			'title' => 'section-name',
		] );
		$this->assertEquals( [
			'title' => 'section-name',
		], $section->get_args() );
	}

	/**
	 * @test
	 */
	public function join() {
		$section = new Inc2734_WP_Customizer_Framework_Section( 'section-name', [
			'title' => 'section-name',
		] );
		$panel = new Inc2734_WP_Customizer_Framework_Panel( 'panel-name', [
			'title' => 'panel-name',
		] );
		$this->assertEquals( $panel, $section->join( $panel ) );
	}

	/**
	 * @test
	 */
	public function Panel() {
		$section = new Inc2734_WP_Customizer_Framework_Section( 'section-name', [
			'title' => 'section-name',
		] );
		$panel = new Inc2734_WP_Customizer_Framework_Panel( 'panel-name', [
			'title' => 'panel-name',
		] );
		$section->join( $panel );
		$this->assertEquals( $panel, $section->panel() );
	}
}
