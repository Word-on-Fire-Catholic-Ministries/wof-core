<?php


namespace WOF\Search;

use WP_Post;
use WP_Term;

defined( 'ABSPATH' ) || exit;

class PostIndexer extends Indexer {

	public function __construct() {
		$this->postType = 'post';
	}

	public function serializePost( WP_Post $post ): array {
		$serialized = parent::serializePost( $post );

		$serialized['tags'] = array_map(function (WP_Term $term) {
			return $term->name;
		}, wp_get_post_terms($post->ID, 'post_tag'));

		$serialized['categories'] = wp_get_post_categories(
			$post->ID, array('fields' => 'names'));

		return $serialized;
	}
}