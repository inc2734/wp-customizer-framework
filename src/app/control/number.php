<?php
/**
 * @package inc2734/wp-view-controller
 * @author inc2734
 * @license GPL-2.0+
 */

class Inc2734_WP_Customizer_Framework_Control_Number extends Inc2734_WP_Customizer_Framework_Abstract_Control {

	/**
	 * Add control
	 *
	 * @param WP_Customize_Manager $wp_customize
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
	 */
	public function register_control( WP_Customize_Manager $wp_customize ) {
		$this->args = array_merge(
			$this->args, array(
				'type' => 'number',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				$this->get_id(),
				array_merge(
					[
						'sanitize_callback' => function( $value ) {
							if ( preg_match( '/^\d+$/', $value ) ) {
								return $value;
							}
						},
					],
					$this->_generate_register_control_args()
				)
			)
		);
	}
}
