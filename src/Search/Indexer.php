<?php


namespace WOF\Search;


use Algolia\AlgoliaSearch\SearchIndex;
use WP_Post;
use WP_Query;

defined( 'ABSPATH' ) || exit;

abstract class Indexer {

	protected $postType = 'post';
	protected $indexType = 'content';

	public function __construct() {
		add_action('save_post', array($this, 'on_save_post'), 100, 3);
	}

	public function getPostType () : string {
		return $this->postType;
	}

	public function getIndexType () : string {
		return $this->indexType;
	}

	public function indexAll (SearchIndex $index, int $batchSize) {

		$index->clearObjects()->wait();

		$paged = 1;
		$count = 0;

		do {
			$posts = new \WP_Query([
				'posts_per_page' => $batchSize,
				'paged' => $paged,
				'post_type' => $this->postType

			]);

			if (!$posts->have_posts()) {
				break;
			}

			$records = [];

			foreach ($posts->posts as $post) {
				$record = $this->serializePost($post);
				$records[] = $record;
				$count++;
			}

			$index->saveObjects( $records );

			$paged++;

		} while (true);

	}

	public function indexSingle (SearchIndex $index, WP_Post $post) {
		$record = $this->serializePost($post);

		// Remove from index if this update trashes the post
		if ($post->post_status === 'trash') {
			$index->deleteObject($record['objectID']);
		} else {
			$index->saveObject($record);
		}
	}

	public function serializePost ( WP_Post $post) : array {

		return [
			'objectID' => implode('#', [$post->post_type, $post->ID]),
			'title' => $post->post_title,
			'published' => $post->post_date,
			'author' => [
				'id' => $post->post_author,
				'name' => get_user_by('ID', $post->post_author)->display_name,
			],
			'excerpt' => $post->post_excerpt,
			'content' => strip_tags($post->post_content),
			'url' => get_post_permalink($post->ID)
		];
	}

	public function on_save_post ($id, WP_Post $post, $update) {
		if (wp_is_post_revision($id) || wp_is_post_autosave($id)) {
			return $post;
		}

		$index = Indices::getIndex($this->getIndexType())->getAlgoliaIndex();

		$this->indexSingle($index, $post);

		return $post;
	}

}