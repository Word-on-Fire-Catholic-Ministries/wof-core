<?php


namespace WOF\Search\Indexers;

use WOF\Search\Category;
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

		// Serialize tags
		$serialized['tags'] = parent::serialize_tags(wp_get_post_terms($post->ID, 'post_tag'));

		// Serialize categories
		$cats = wp_get_post_categories($post->ID,array('fields' => array('names', 'parents', 'term_ids')));
		$serialized_cats = parent::serialize_categories($cats);
		$serialized = array_merge($serialized, $serialized_cats);

		return $serialized;
	}

}
