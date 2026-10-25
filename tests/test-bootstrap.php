<?php
use Inc2734\WP_Customizer_Framework\Bootstrap;
use Inc2734\WP_Customizer_Framework\Framework;

class Bootstrap_Test extends WP_UnitTestCase {

	protected $manager;

	public function set_up() {
		parent::set_up();

		require_once ABSPATH . WPINC . '/class-wp-customize-manager.php';
		wp_set_current_user( self::factory()->user->create( array( 'role' => 'administrator' ) ) );

		$this->manager           = new WP_Customize_Manager();
		$GLOBALS['wp_customize'] = $this->manager;

		$panel   = Framework::panel( 'integration-panel', array( 'title' => 'Integration panel' ) );
		$section = Framework::section( 'integration-section', array( 'title' => 'Integration section' ) );
		$section->join( $panel );

		$color = Framework::control(
			'color',
			'integration-color',
			array(
				'label'   => 'Integration color',
				'default' => '#123456',
			)
		);
		$color->join( $section );
		$color->partial( array( 'selector' => '#integration-preview' ) );

		Framework::control(
			'text',
			'integration-text',
			array( 'label' => 'Integration text' )
		)->join( $section );

		$bootstrap = new Bootstrap( array( 'handle' => 'integration-style' ) );
		$this->assertSame( 10, has_action( 'customize_register', array( $bootstrap, '_customize_register' ) ) );
		$bootstrap->_customize_register( $this->manager );
	}

	public function tear_down() {
		$this->manager = null;
		unset( $GLOBALS['wp_customize'] );
		wp_set_current_user( 0 );

		parent::tear_down();
	}

	public function test_registers_controls_panels_sections_and_partials() {
		$this->assertInstanceOf( WP_Customize_Panel::class, $this->manager->get_panel( 'integration-panel' ) );
		$this->assertSame( 'integration-panel', $this->manager->get_section( 'integration-section' )->panel );

		$control = $this->manager->get_control( 'integration-color' );
		$this->assertInstanceOf( WP_Customize_Color_Control::class, $control );
		$this->assertSame( 'integration-section', $control->section );
		$this->assertSame( 'integration-color', $control->setting->id );
		$this->assertSame( '#integration-preview', $this->manager->selective_refresh->get_partial( 'integration-color' )->selector );

		ob_start();
		$this->manager->get_control( 'integration-text' )->maybe_render();
		$html = ob_get_clean();

		$this->assertStringContainsString( 'Integration text', $html );
		$this->assertStringContainsString( 'data-customize-setting-link="integration-text"', $html );
	}

	public function test_preview_does_not_persist_theme_mod() {
		set_theme_mod( 'integration-color', '#123456' );
		$this->manager->set_post_value( 'integration-color', '#654321' );
		$this->manager->get_setting( 'integration-color' )->preview();

		$this->assertSame( '#654321', get_theme_mod( 'integration-color' ) );
		$stored_mods = get_option( 'theme_mods_' . get_stylesheet() );
		$this->assertSame( '#123456', $stored_mods['integration-color'] );
	}

	public function test_save_persists_valid_theme_mod() {
		$this->manager->set_post_value( 'integration-color', '#654321' );

		$this->manager->get_setting( 'integration-color' )->save();
		$this->assertSame( '#654321', get_theme_mod( 'integration-color' ) );
		$stored_mods = get_option( 'theme_mods_' . get_stylesheet() );
		$this->assertSame( '#654321', $stored_mods['integration-color'] );
	}

	public function test_invalid_color_is_not_saved() {
		set_theme_mod( 'integration-color', '#123456' );
		$this->manager->set_post_value( 'integration-color', 'not-a-color' );

		$this->assertFalse( $this->manager->get_setting( 'integration-color' )->save() );
		$this->assertSame( '#123456', get_theme_mod( 'integration-color' ) );
	}
}
