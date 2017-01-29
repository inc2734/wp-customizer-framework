<?php
namespace Inc2734\CustomizerFramework\App\Controller;

class Panel {

	protected $id;
	protected $args = [];

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
}
