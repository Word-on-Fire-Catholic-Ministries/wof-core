<?php


namespace WOF\Search\Indexers;

use WOF\Search\Indexer;
use WP_Post;
use WP_Term;

defined( 'ABSPATH' ) || exit;

class PostIndexer extends Indexer {

	public function __construct() {
		$this->postType = 'post';
	}

	public function serializePost( WP_Post $post ): array {
		$serialized = parent::serializePost( $post );

		if (has_post_thumbnail($post)) {
			$serialized['thumbnail'] = get_the_post_thumbnail_url($post);
		}

		$serialized['tags'] = array_map(function (WP_Term $term) {
			return $term->name;
		}, wp_get_post_terms($post->ID, 'post_tag'));

		$serialized['categories'] = wp_get_post_categories(
			$post->ID, array('fields' => 'names'));

		return $serialized;
	}
}