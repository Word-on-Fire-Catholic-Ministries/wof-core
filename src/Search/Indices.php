<?php


namespace WOF\Search;

use Algolia\AlgoliaSearch\SearchClient;
use Exception;

class Indices {

	protected $client;

	protected $indices;

	private $appId;

	private $algoliaApiKey;

	public function __construct (string $appId, string $algoliaApiKey) {
		$this->indices = array();
		$this->appId = $appId;
		$this->algoliaApiKey = $algoliaApiKey;
	}

	public function getClient () : SearchClient {
		if (!isset($this->client)) {
			$this->client = SearchClient::create($this->appId, $this->algoliaApiKey);
		}
		return $this->client;
	}

	public function getIndex (string $indexType) : Index {
		return $this->indices[$indexType];
	}

	public function isIndex (string $indexType): bool {
		return isset($this->indices[$indexType]);
	}

	public function addIndex (Index $index) {

		$this->indices[$index->getType()] = $index;
	}

	public function getIndices () : array {
		return $this->indices;
	}

}