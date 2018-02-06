<?php
class Inc2734_WP_Customizer_Framework_Styles_Test extends WP_UnitTestCase {

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
		$cfs = Inc2734\WP_Customizer_Framework\Customizer_Framework::styles();
		$this->assertEquals( '#7ed5d7', $cfs->light( '#38b3b7' ) );
		$this->assertEquals( '#ffffff', $cfs->light( '#ffffff' ) );
	}

	/**
	 * @test
	 */
	public function lighter() {
		$cfs = Inc2734\WP_Customizer_Framework\Customizer_Framework::styles();
		$this->assertEquals( '#b2e6e8', $cfs->lighter( '#38b3b7' ) );
	}

	/**
	 * @test
	 */
	public function lightest() {
		$cfs = Inc2734\WP_Customizer_Framework\Customizer_Framework::styles();
		$this->assertEquals( '#c0eaec', $cfs->lightest( '#38b3b7' ) );
	}

	/**
	 * @test
	 */
	public function dark() {
		$cfs = Inc2734\WP_Customizer_Framework\Customizer_Framework::styles();
		$this->assertEquals( '#206769', $cfs->dark( '#38b3b7' ) );
		$this->assertEquals( '#000000', $cfs->dark( '#000000' ) );
	}

	/**
	 * @test
	 */
	public function darker() {
		$cfs = Inc2734\WP_Customizer_Framework\Customizer_Framework::styles();
		$this->assertEquals( '#103334', $cfs->darker( '#38b3b7' ) );
	}

	/**
	 * @test
	 */
	public function darkest() {
		$cfs = Inc2734\WP_Customizer_Framework\Customizer_Framework::styles();
		$this->assertEquals( '#0c2627', $cfs->darkest( '#38b3b7' ) );
	}
}
