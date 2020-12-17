<?php


namespace WOF\Search;

use Algolia\AlgoliaSearch\SearchClient;
use Exception;

class Indices {

	protected static $client;

	protected static $indices = array();

	private static $appId;

	private static $algoliaApiKey;

	public static function init (string $appId, string $algoliaApiKey) {
		self::$appId = $appId;
		self::$algoliaApiKey = $algoliaApiKey;
	}

	public static function getClient () : SearchClient {
		if (!isset(self::$appId) || !isset(self::$algoliaApiKey)) {
			throw new Exception('Need Algolia API credentials to instantiate client');
		}

		if (!isset(self::$client)) {
			SearchClient::create(self::$appId, self::$algoliaApiKey);
		}

		return self::$client;
	}

	public static function getIndex (string $indexType) : Index {
		return self::$indices[$indexType];
	}

	public static function isIndex (string $indexType): bool {
		return isset(self::$indices[$indexType]);
	}

	public static function addIndex (Index $index) {
		self::$indices[$index->getType()] = $index;
	}

	public static function getIndices () : array {
		return self::$indices;
	}

}