<?php
use Inc2734\WP_Customizer_Framework\Color;

class Color_Test extends WP_UnitTestCase {

	public function setup() {
		parent::setup();
	}

	public function tearDown() {
		parent::tearDown();
	}

	/**
	 * @test
	 */
	public function light() {
		$this->assertEquals( '#7ed5d7', Color::light( '#38b3b7' ) );
		$this->assertEquals( '#ffffff', Color::light( '#ffffff' ) );
	}

	/**
	 * @test
	 */
	public function lighter() {
		$this->assertEquals( '#b2e6e8', Color::lighter( '#38b3b7' ) );
	}

	/**
	 * @test
	 */
	public function lightest() {
		$this->assertEquals( '#c0eaec', Color::lightest( '#38b3b7' ) );
	}

	/**
	 * @test
	 */
	public function dark() {
		$this->assertEquals( '#206769', Color::dark( '#38b3b7' ) );
		$this->assertEquals( '#000000', Color::dark( '#000000' ) );
	}

	/**
	 * @test
	 */
	public function darker() {
		$this->assertEquals( '#103334', Color::darker( '#38b3b7' ) );
	}

	/**
	 * @test
	 */
	public function darkest() {
		$this->assertEquals( '#0c2627', Color::darkest( '#38b3b7' ) );
	}
}
