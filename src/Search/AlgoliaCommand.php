<?php


namespace WOF\Search;

use Algolia\AlgoliaSearch\Exceptions\MissingObjectId;
use WP_CLI;

defined( 'ABSPATH' ) || exit;

class AlgoliaCommand {

	private $indices;

	public function __construct(Indices $indices) {
		$this->indices = $indices;
	}

	public function reindex($args, $assoc_args) {

		if (!isset($args[0]) || !$this->indices->isIndex($args[0])) {
			WP_CLI::error('First argument must be the index type.');
			return;
		}

		$index = $this->indices->getIndex($args[0]);
		$count = 0;

		try {
			$count = $index->indexAll();
		} catch ( MissingObjectId $e ) {
			WP_CLI::error('Missing Object ID.', false);
		}

		WP_CLI::success($count . " posts indexed in Algolia");
	}

	public function clear($args, $assoc_args) {
		if (!isset($args[0]) || !$this->indices->isIndex($args[0])) {
			WP_CLI::error('First argument must be the index type.');
			return;
		}

		$index = $this->indices->getIndex($args[0]);

		$index->getAlgoliaIndex()->clearObjects()->wait();

		WP_CLI::success($args[0] . " index cleared in Algolia");
	}

}


