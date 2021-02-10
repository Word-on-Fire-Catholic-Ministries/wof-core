<?php


namespace WOF\Org\Theme\Models;


use WP_User;

class Author {

	private WP_User $user;

	public function __construct( WP_User $user) {
		$this->user = $user;
	}

}