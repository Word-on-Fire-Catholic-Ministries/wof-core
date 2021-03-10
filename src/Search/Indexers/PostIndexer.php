<?php


namespace WOF\Search\Indexers;

use WOF\Core\Debug;
use WOF\Search\Indexer;
use WOF\Taxonomy\Categories;
use WP_Post;

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

        $serialized['tags'] = parent::serialize_tags(wp_get_post_terms($post->ID ));

        $post_cats = Categories::get_all_for_post($post->ID);

        $serialized['hierarchicalCategories'] = parent::serialize_hierarchical_categories($post_cats);

        $serialized['categories'] = parent::serialize_categories($post_cats);

		return $serialized;
	}
}
