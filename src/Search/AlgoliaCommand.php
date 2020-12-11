<?php


namespace WOF\Search;

use Algolia\AlgoliaSearch\Exceptions\MissingObjectId;

defined( 'ABSPATH' ) || exit;

if (!(defined('WP_CLI') && WP_CLI)) {
	return;
}


class AlgoliaCommand {

	public function  reindex_post($args, $assoc_args) {
		global $algolia;
		$index = $algolia->initIndex('dev_WOF');

		$paged = 1;
		$count = 0;

		do {
			$posts = new \WP_Query([
				'posts_per_page' => 100,
				'paged' => $paged,
				'post_type' => 'post'

			]);

			if (!$posts->have_posts()) {
				break;
			}

			$records = [];

			foreach ($posts->posts as $post) {
				if ($assoc_args['verbose']) {
					\WP_CLI::line('Serializing ['.$post->post_title.']');
				}
				$record = (array) apply_filters('post_to_record', $post);

				if (!isset($record['objectID'])) {
					$record['objectID'] = implode('#', [$post->post_type, $post->ID]);
				}

				$records[] = $record;
				$count++;
			}

			if ($assoc_args['verbose']) {
				\WP_CLI::line('Sending batch');
			}

			try {
				$index->saveObjects( $records );
			} catch ( MissingObjectId $e ) {

			}

			$paged++;

		} while (true);

		WP_CLI::success("$count posts indexed in Algolia");
	}

}


