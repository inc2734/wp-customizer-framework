<?php
use Inc2734\WP_Customizer_Framework\Style;

class Style_Test extends WP_UnitTestCase {

	public function setup() {
		parent::setup();
	}

	public function tearDown() {
		parent::tearDown();
	}

	/**
	 * @test
	 * @runInSeparateProcess
	 */
	public function register() {
		Style::register(
			[
				'body',
			],
			[
				'font-size' => '16px',
				'color' => '#000',
			],
			'@media (min-width: 1024px)'
		);

		$this->assertEquals(
			[
				[
					'selectors' => [
						'body',
					],
					'properties' => [
						'font-size' => '16px',
						'color'     => '#000',
					],
					'media_query' => '@media (min-width: 1024px)',
				],
			],
			Style::get_registerd_styles()
		);
	}

	/**
	 * @test
	 */
	public function light() {
		$this->assertEquals( '#7ed5d7', Style::light( '#38b3b7' ) );
		$this->assertEquals( '#ffffff', Style::light( '#ffffff' ) );
	}

	/**
	 * @test
	 */
	public function lighter() {
		$this->assertEquals( '#b2e6e8', Style::lighter( '#38b3b7' ) );
	}

	/**
	 * @test
	 */
	public function lightest() {
		$this->assertEquals( '#c0eaec', Style::lightest( '#38b3b7' ) );
	}

	/**
	 * @test
	 */
	public function dark() {
		$this->assertEquals( '#206769', Style::dark( '#38b3b7' ) );
		$this->assertEquals( '#000000', Style::dark( '#000000' ) );
	}

	/**
	 * @test
	 */
	public function darker() {
		$this->assertEquals( '#103334', Style::darker( '#38b3b7' ) );
	}

	/**
	 * @test
	 */
	public function darkest() {
		$this->assertEquals( '#0c2627', Style::darkest( '#38b3b7' ) );
	}
}
