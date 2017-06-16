<?php
class SampleTest extends WP_UnitTestCase {

	public function setup() {
		parent::setup();
	}

	public function tearDown() {
		parent::tearDown();
	}

	public function test_sample() {
		$Customizer_Framework = \Inc2734\WP_Customizer_Framework\Customizer_Framework::init();
	}
}
