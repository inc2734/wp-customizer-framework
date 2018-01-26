<?php
use Inc2734\WP_Customizer_Framework\App\Panel;

class Inc2734_WP_Customizer_Framework_Panel_Test extends WP_UnitTestCase {

	public function setup() {
		parent::setup();
	}

	public function tearDown() {
		parent::tearDown();
	}

	/**
	 * @test
	 */
	public function get_id() {
		$panel = new Panel( 'panel-name', [
			'title' => 'panel-name',
		] );
		$this->assertEquals( 'panel-name', $panel->get_id() );
	}

	/**
	 * @test
	 */
	public function get_args() {
		$panel = new Panel( 'panel-name', [
			'title' => 'panel-name',
		] );
		$this->assertEquals( [
			'title' => 'panel-name',
		], $panel->get_args() );
	}
}
