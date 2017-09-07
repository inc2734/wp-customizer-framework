<?php
class Inc2734_WP_Customizer_Framework_Panel_Test extends WP_UnitTestCase {

	public function setup() {
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
		$panel = new Inc2734_WP_Customizer_Framework_Panel( 'panel-name', [
			'title' => 'panel-name',
		] );
		$this->assertEquals( 'panel-name', $panel->get_id() );
	}

	/**
	 * @test
	 */
	public function get_args() {
		$panel = new Inc2734_WP_Customizer_Framework_Panel( 'panel-name', [
			'title' => 'panel-name',
		] );
		$this->assertEquals( [
			'title' => 'panel-name',
		], $panel->get_args() );
	}
}
