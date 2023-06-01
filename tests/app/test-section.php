<?php
use Inc2734\WP_Customizer_Framework\App\Panel;
use Inc2734\WP_Customizer_Framework\App\Section;

class Inc2734_WP_Customizer_Framework_Section_Test extends WP_UnitTestCase {

	public function set_up() {
		parent::set_up();
	}

	public function tear_down() {
		parent::tear_down();
	}

	/**
	 * @test
	 */
	public function get_id() {
		$section = new Section( 'section-name', [
			'title' => 'section-name',
		] );
		$this->assertEquals( 'section-name', $section->get_id() );
	}

	/**
	 * @test
	 */
	public function get_args() {
		$section = new Section( 'section-name', [
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
		$section = new Section( 'section-name', [
			'title' => 'section-name',
		] );
		$panel = new Panel( 'panel-name', [
			'title' => 'panel-name',
		] );
		$this->assertEquals( $panel, $section->join( $panel ) );
	}

	/**
	 * @test
	 */
	public function Panel() {
		$section = new Section( 'section-name', [
			'title' => 'section-name',
		] );
		$panel = new Panel( 'panel-name', [
			'title' => 'panel-name',
		] );
		$section->join( $panel );
		$this->assertEquals( $panel, $section->panel() );
	}
}
