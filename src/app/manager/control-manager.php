<?php
/**
 * @package inc2734/wp-customizer-framework
 * @author inc2734
 * @license GPL-2.0+
 */

class Inc2734_WP_Customizer_Framework_Control_Manager {

	/**
	 * @var Inc2734_WP_Customizer_Framework
	 */
	protected $customizer;

	/**
	 * @var array
	 */
	protected $controls = array();

	/**
	 * @param Inc2734_WP_Customizer_Framework $customizer
	 */
	public function __construct( Inc2734_WP_Customizer_Framework $customizer ) {
		$this->customizer = $customizer;
	}

	/**
	 * Get Control
	 *
	 * @param string $control_id
	 * @return Inc2734_WP_Customizer_Framework_Control|null
	 */
	public function get( $control_id ) {
		if ( isset( $this->controls[ $control_id ] ) ) {
			return $this->controls[ $control_id ];
		}
	}

	/**
	 * Get all Controls
	 *
	 * @return array Array of Inc2734_WP_Customizer_Framework_Control
	 */
	public function get_controls() {
		return $this->controls;
	}

	/**
	 * Add Control
	 *
	 * @param string $type
	 * @param string $control_id
	 * @param array $args
	 * @return Inc2734_WP_Customizer_Framework_Control
	 */
	public function add( $type, $control_id, $args ) {
		$control = $this->_control( $type, $control_id, $args );
		$this->controls[ $control->get_id() ] = $control;
		return $control;
	}

	/**
	 * Create panel
	 *
	 * @param string $type
	 * @param string $id
	 * @param array $args
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
	 * @see https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
	 */
	protected function _control( $type, $id, $args ) {
		$type = ucfirst( $type );
		$type = str_replace( '-', '_', $type );
		$class = 'Inc2734_WP_Customizer_Framework_Control_' . $type;
		if ( class_exists( $class ) ) {
			return new $class( $id, $args );
		}
		echo $class . ' is not found.';
		exit;
	}
}
