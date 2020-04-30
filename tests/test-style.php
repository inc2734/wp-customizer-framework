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
				'color: #000',
				'background-color' => '',
				'font-style: ',
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
						'color: #000',
					],
					'media_query' => '@media (min-width: 1024px)',
				],
			],
			Style::get_registerd_styles()
		);
	}
}
