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
		$this->assertSame( 'control-id', $control->get_id() );
	}

	/**
	 * @test
	 */
	public function get_args() {
		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Color( 'control-id', [
			'label'   => 'Header Color',
			'default' => '#f00',
		] );
		$this->assertSame( 'Header Color', $control->get_arg( 'label' ) );
		$this->assertSame( 'sanitize_hex_color', $control->get_setting_arg( 'sanitize_callback' ) );
	}

	/**
	 * @test
	 */
	public function get_setting_args() {
		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Color( 'control-id', [
			'label'   => 'Header Color',
			'default' => '#f00',
		] );
		$this->assertSame( '#f00', $control->get_setting_arg( 'default' ) );
		$this->assertSame( 'theme_mod', $control->get_setting_arg( 'type' ) );

		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Color( 'control-id-2', [
			'label'   => 'Header Color',
			'default' => '#f00',
			'type'    => 'option',
		] );
		$this->assertSame( '#f00', $control->get_setting_arg( 'default' ) );
		$this->assertSame( 'option', $control->get_setting_arg( 'type' ) );
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
		$this->assertSame( $section, $control->join( $section ) );
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
		$this->assertSame( $section, $control->section() );
	}

	/**
	 * @test
	 */
	public function _set_default_value__theme_mod() {
		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Color( 'control-id', [
			'label'   => 'Header Color',
			'default' => '#f00',
		] );

		$this->assertSame( 'value-1', $control->_set_default_value( 'value-1' ) );
		$this->assertSame( '#f00', $control->_set_default_value( null ) );
		$this->assertSame( '#f00', $control->_set_default_value( false ) );

		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Color( 'control-id-2', [
			'label' => 'Header Color',
		] );
		$this->assertSame( null, $control->_set_default_value( null ) );
		$this->assertSame( false, $control->_set_default_value( false ) );

		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Text( 'control-id-3', [
			'label'   => 'Text',
			'default' => '',
		] );
		$this->assertSame( 'value-1', $control->_set_default_value( 'value-1' ) );
		$this->assertSame( '', $control->_set_default_value( null ) );
		$this->assertSame( '', $control->_set_default_value( false ) );
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

		$this->assertSame( 'value-1', $control->_set_default_value( 'value-1' ) );
		$this->assertSame( '#f00', $control->_set_default_value( null ) );
		$this->assertSame( '#f00', $control->_set_default_value( false ) );

		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Color( 'control-id-2', [
			'label' => 'Header Color',
			'type'  => 'option',
		] );
		$this->assertSame( null, $control->_set_default_value( null ) );
		$this->assertSame( false, $control->_set_default_value( false ) );

		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Text( 'control-id-3', [
			'label'   => 'Text',
			'default' => '',
			'type'    => 'option',
		] );
		$this->assertSame( 'value-1', $control->_set_default_value( 'value-1' ) );
		$this->assertSame( '', $control->_set_default_value( null ) );
		$this->assertSame( '', $control->_set_default_value( false ) );
	}

	/**
	 * @test
	 */
	public function get_theme_mod() {
		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Color( 'control-id', [
			'label' => 'Header Color',
		] );
		$this->assertSame( false, get_theme_mod( 'control-id' ) );

		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Color( 'control-id-2', [
			'label'   => 'Header Color',
			'default' => '#f00',
		] );
		$this->assertSame( '#f00', get_theme_mod( 'control-id-2' ) );

		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Text( 'control-id-3', [
			'label'   => 'Text',
			'default' => '',
		] );
		$this->assertSame( '', get_theme_mod( 'control-id-3' ) );

		set_theme_mod( 'control-id', '#fff' );
		$this->assertSame( '#fff', get_theme_mod( 'control-id' ) );
	}

	/**
	 * @test
	 */
	public function get_option() {
		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Color( 'control-id', [
			'label' => 'Header Color',
			'type'  => 'option',
		] );
		$this->assertSame( false, get_option( 'control-id' ) );

		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Color( 'control-id-2', [
			'label'   => 'Header Color',
			'default' => '#f00',
			'type'    => 'option',
		] );
		$this->assertSame( '#f00', get_option( 'control-id-2' ) );

		$control = new \Inc2734\WP_Customizer_Framework\App\Control\Text( 'control-id-3', [
			'label'   => 'Text',
			'default' => '',
			'type'    => 'option',
		] );
		$this->assertSame( '', get_option( 'control-id-3' ) );

		update_option( 'control-id', '#fff' );
		$this->assertSame( '#fff', get_option( 'control-id' ) );
	}
}
