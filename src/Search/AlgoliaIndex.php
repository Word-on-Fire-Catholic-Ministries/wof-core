<?php


namespace WOF\Search;

use Algolia\AlgoliaSearch\SearchClient;

class AlgoliaIndex {

	public static $client;

	protected $indexName;

	public function __construct($appId, $algoliaApiKey, $indexName) {
		if (!isset(self::$client)) {
			SearchClient::create($appId, $algoliaApiKey);
		}

		$this->indexName = $indexName;
	}

}