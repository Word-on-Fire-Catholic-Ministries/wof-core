<?php


namespace WOF\Org\Theme\Models;


use WP_Post;

class Content {

	private WP_Post $post;

	private Author $author;

	public function __construct( WP_Post $post) {
		$this->post = $post;
		$this->attach_author($post->post_author);
	}

	private function attach_author (int $user_id) {
		$user = get_userdata($user_id);

		if (!$user) {
			return;
		}

		$this->author = new Author($user);
	}

}