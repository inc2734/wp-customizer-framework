<?php
namespace Inc2734\CustomizerFramework\App\Controller;

abstract class Control {

	protected $id;
	protected $args = [];
	protected $Section;

	public function __construct( $id, $args = [] ) {
		$this->id   = $id;
		$this->args = $args;
	}

	public function get_id() {
		return $this->id;
	}

	public function get_args() {
		return $this->args;
	}

	public function join( Section $Section ) {
		$this->Section = $Section;
		return $this->Section;
	}

	public function Section() {
		return $this->Section;
	}

	abstract public function register_control( \WP_Customize_Manager $wp_customize );

	protected function _generate_register_control_args() {
		return array_merge(
			$this->get_args(),
			[
				'section'  => $this->Section->get_id(),
				'settings' => $this->get_id(),
			]
		);
	}
}
