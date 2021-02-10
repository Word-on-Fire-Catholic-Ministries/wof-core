<?php


namespace WOF\Org\Theme;


class CustomPostTypes {

	public function registerHooks () {
		add_action('init', array($this, 'registerCustomPostTypes'));
	}

	public function registerCustomPostTypes () {
		$this->registerReflections();
		$this->registerTestimonials();
	}

	public function registerReflections () {

	}

	public function registerTestimonials () {

	}

}