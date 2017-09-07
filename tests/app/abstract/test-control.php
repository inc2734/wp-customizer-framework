<?php
class Inc2734_WP_Customizer_Framework_Abstract_Control_Test extends WP_UnitTestCase {

	public function setup() {
		include_once( __DIR__ . '/../../../src/app/abstract/control.php' );
		include_once( __DIR__ . '/../../../src/app/control/color.php' );
		include_once( __DIR__ . '/../../../src/app/section.php' );
		parent::setup();
	}

	public function tearDown() {
		parent::tearDown();
	}

	/**
	 * @test
	 */
	public function get_id() {
		$control = new Inc2734_WP_Customizer_Framework_Control_Color( 'control-id', [
			'label'   => 'Header Color',
			'default' => '#f00',
		] );
		$this->assertEquals( 'control-id', $control->get_id() );
	}

	/**
	 * @test
	 */
	public function get_args() {
		$control = new Inc2734_WP_Customizer_Framework_Control_Color( 'control-id', [
			'label'   => 'Header Color',
			'default' => '#f00',
		] );
		$this->assertEquals( [
			'label'   => 'Header Color',
			'default' => '#f00',
			'sanitize_callback' => 'sanitize_hex_color',
		], $control->get_args() );
	}

	/**
	 * @test
	 */
	public function join() {
		$customizer_framework = \Inc2734\WP_Customizer_Framework\Customizer_Framework::init();
		$section = $customizer_framework->Section(
			'section-name',
			[
				'title' => 'section-name',
			]
		);
		$control = new Inc2734_WP_Customizer_Framework_Control_Color( 'control-id', [
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
		$section = $customizer_framework->Section(
			'section-name',
			[
				'title' => 'section-name',
			]
		);
		$control = new Inc2734_WP_Customizer_Framework_Control_Color( 'control-id', [
			'label'   => 'Header Color',
			'default' => '#f00',
		] );
		$control->join( $section );
		$this->assertEquals( $section, $control->Section() );
	}

	/**
	 * @test
	 */
	public function _set_default_value__theme_mod() {
		$control = new Inc2734_WP_Customizer_Framework_Control_Color( 'control-id', [
			'label'   => 'Header Color',
			'default' => '#f00',
		] );

		$this->assertEquals( 'value-1', $control->_set_default_value( 'value-1' ) );
		$this->assertEquals( '#f00', $control->_set_default_value( null ) );
		$this->assertEquals( '#f00', $control->_set_default_value( false ) );

		$control = new Inc2734_WP_Customizer_Framework_Control_Color( 'control-id', [
			'label' => 'Header Color',
		] );
		$this->assertEquals( null, $control->_set_default_value( null ) );
		$this->assertEquals( false, $control->_set_default_value( false ) );
	}

	/**
	 * @test
	 */
	public function _set_default_value__option() {
		$control = new Inc2734_WP_Customizer_Framework_Control_Color( 'control-id', [
			'label'   => 'Header Color',
			'default' => '#f00',
			'type'    => 'option',
		] );

		$this->assertEquals( 'value-1', $control->_set_default_value( 'value-1' ) );
		$this->assertEquals( '#f00', $control->_set_default_value( null ) );
		$this->assertEquals( '#f00', $control->_set_default_value( false ) );

		$control = new Inc2734_WP_Customizer_Framework_Control_Color( 'control-id', [
			'label' => 'Header Color',
			'type'  => 'option',
		] );
		$this->assertEquals( null, $control->_set_default_value( null ) );
		$this->assertEquals( false, $control->_set_default_value( false ) );
	}

	/**
	 * @test
	 */
	public function get_theme_mod() {
		$control = new Inc2734_WP_Customizer_Framework_Control_Color( 'control-id', [
			'label' => 'Header Color',
		] );
		$this->assertEquals( false, get_theme_mod( 'control-id' ) );

		$control = new Inc2734_WP_Customizer_Framework_Control_Color( 'control-id', [
			'label'   => 'Header Color',
			'default' => '#f00',
		] );
		$this->assertEquals( '#f00', get_theme_mod( 'control-id' ) );

		set_theme_mod( 'control-id', '#fff' );
		$this->assertEquals( '#fff', get_theme_mod( 'control-id' ) );
	}
}
