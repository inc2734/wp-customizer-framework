<?php
use Inc2734\WP_Customizer_Framework\Style;

class Style_Test extends WP_UnitTestCase {

	public function set_up() {
		parent::set_up();
	}

	public function tear_down() {
		parent::tear_down();
	}

	/**
	 * @test
	 */
	public function register() {
		Style::attach(
			'',
			[
				[
					'selectors'   => [ 'body' ],
					'properties'  => [ 'font-size: 16px' ],
					'media_query' => '@media (min-width: 1024px)',
				],
			],
		);

		ob_start();
		do_action( 'wp_print_scripts' );
		$css = ob_get_clean();

		$this->assertEquals(
			'<style data-id="wp-customizer-framework-print-styles">@media (min-width: 1024px) { body { font-size: 16px } }</style>',
			$css
		);
	}
}
