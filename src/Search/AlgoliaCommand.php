<?php


namespace WOF\Search;

use Algolia\AlgoliaSearch\Exceptions\MissingObjectId;
use WP_CLI;

defined( 'ABSPATH' ) || exit;

class AlgoliaCommand {

	public function reindex($args, $assoc_args) {

		if (!isset($args[0]) || !Indices::isIndex($args[0])) {
			WP_CLI::error('First argument must be the index type.');
			return;
		}

		$index = Indices::getIndex($args[0]);

		try {
			$index->indexAll();
		} catch ( MissingObjectId $e ) {
			WP_CLI::error('Missing Object ID.', false);
		}

		WP_CLI::success("Posts indexed in Algolia");
	}

}


