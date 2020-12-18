<?php


namespace WOF\Search;


use WP_Post;
use WP_Term;

defined( 'ABSPATH' ) || exit;

class CourseIndexer extends Indexer {

	public function __construct() {
		$this->postType = 'sfwd-courses';
	}

	public function serializePost( WP_Post $post ): array {
		$serialized = parent::serializePost( $post );

		$serialized['tags'] = array_map(function ( WP_Term $term) {
			return $term->name;
		}, wp_get_post_terms($post->ID, 'post_tag'));

		$serialized['categories'] = wp_get_post_categories(
			$post->ID, array('fields' => 'names'));

		$serialized['lessons'] = learndash_get_course_steps($post->ID);

		return $serialized;
	}
}