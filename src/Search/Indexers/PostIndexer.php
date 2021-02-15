<?php


namespace WOF\Search\Indexers;

use WOF\Core\Debug;
use WOF\Search\Indexer;
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

        $serialized['tags'] = parent::serialize_tags(wp_get_post_terms($post->ID, 'post_tag'));

//		$serialized['categories'] = wp_get_post_categories(
//			$post->ID, array('fields' => 'names'));
        $post_cats = wp_get_post_categories($post->ID,array('fields' => 'all'));
        //Debug::printVar($post_cats);
        $serialized_cats = parent::serialize_categories($post_cats);
        $serialized = array_merge($serialized, $serialized_cats);

		return $serialized;
	}
}
