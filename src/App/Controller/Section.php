<?php
namespace Inc2734\CustomizerFramework\App\Controller;

class Section {

	protected $id;
	protected $args = [];
	protected $Panel;

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

	public function join( Panel $Panel ) {
		$this->Panel = $Panel;
		return $this->Panel;
	}

	public function Panel() {
		return $this->Panel;
	}
}
