<?php


namespace WOF\Search;

defined( 'ABSPATH' ) || exit;


class PostSerializer implements Serializable {

	public function serialize( \WP_Post $post ): array {
		// TODO: Implement serialize() method.
		return array();
	}
}