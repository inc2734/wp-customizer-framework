<?php
class Inc2734_WP_Customizer_Framework_Abstract_Control_Test extends WP_UnitTestCase {

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
		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Color( 'control-id', [
			'label'   => 'Header Color',
			'default' => '#f00',
		] );
		$this->assertEquals( 'control-id', $control->get_id() );
	}

	/**
	 * @test
	 */
	public function get_args() {
		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Color( 'control-id', [
			'label'   => 'Header Color',
			'default' => '#f00',
		] );
		$this->assertEquals( 'Header Color', $control->get_arg( 'label' ) );
		$this->assertEquals( 'sanitize_hex_color', $control->get_arg( 'sanitize_callback' ) );
	}

	/**
	 * @test
	 */
	public function get_setting_args() {
		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Color( 'control-id', [
			'label'   => 'Header Color',
			'default' => '#f00',
		] );
		$this->assertEquals( '#f00', $control->get_setting_arg( 'default' ) );
		$this->assertEquals( 'theme_mod', $control->get_setting_arg( 'type' ) );

		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Color( 'control-id', [
			'label'   => 'Header Color',
			'default' => '#f00',
			'type'    => 'option',
		] );
		$this->assertEquals( '#f00', $control->get_setting_arg( 'default' ) );
		$this->assertEquals( 'option', $control->get_setting_arg( 'type' ) );
	}

	/**
	 * @test
	 */
	public function join() {
		$customizer_framework = \Inc2734\WP_Customizer_Framework\Customizer_Framework::init();
		$section = $customizer_framework->section(
			'section-name',
			[
				'title' => 'section-name',
			]
		);
		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Color( 'control-id', [
			'label'   => 'Header Color',
			'default' => '#f00',
		] );
		$this->assertEquals( $section, $control->join( $section ) );
	}

	/**
	 * @test
	 */
	public function Section() {
		$customizer_framework = \Inc2734\WP_Customizer_Framework\Customizer_Framework::init();
		$section = $customizer_framework->section(
			'section-name',
			[
				'title' => 'section-name',
			]
		);
		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Color( 'control-id', [
			'label'   => 'Header Color',
			'default' => '#f00',
		] );
		$control->join( $section );
		$this->assertEquals( $section, $control->section() );
	}

	/**
	 * @test
	 */
	public function _set_default_value__theme_mod() {
		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Color( 'control-id', [
			'label'   => 'Header Color',
			'default' => '#f00',
		] );

		$this->assertEquals( 'value-1', $control->_set_default_value( 'value-1' ) );
		$this->assertEquals( '#f00', $control->_set_default_value( null ) );
		$this->assertEquals( '#f00', $control->_set_default_value( false ) );

		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Color( 'control-id', [
			'label' => 'Header Color',
		] );
		$this->assertEquals( null, $control->_set_default_value( null ) );
		$this->assertEquals( false, $control->_set_default_value( false ) );
	}

	/**
	 * @test
	 */
	public function _set_default_value__option() {
		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Color( 'control-id', [
			'label'   => 'Header Color',
			'default' => '#f00',
			'type'    => 'option',
		] );

		$this->assertEquals( 'value-1', $control->_set_default_value( 'value-1' ) );
		$this->assertEquals( '#f00', $control->_set_default_value( null ) );
		$this->assertEquals( '#f00', $control->_set_default_value( false ) );

		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Color( 'control-id', [
			'label' => 'Header Color',
			'type'  => 'option',
		] );
		$this->assertEquals( null, $control->_set_default_value( null ) );
		$this->assertEquals( false, $control->_set_default_value( false ) );
	}

	/**
	 * @test
	 * @group hoge
	 */
	public function get_theme_mod() {
		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Color( 'control-id', [
			'label' => 'Header Color',
		] );
		$this->assertEquals( false, get_theme_mod( 'control-id' ) );

		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Color( 'control-id', [
			'label'   => 'Header Color',
			'default' => '#f00',
		] );
		$this->assertEquals( '#f00', get_theme_mod( 'control-id' ) );

		set_theme_mod( 'control-id', '#fff' );
		$this->assertEquals( '#fff', get_theme_mod( 'control-id' ) );
	}
}
