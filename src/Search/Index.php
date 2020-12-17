<?php


namespace WOF\Search;


use Algolia\AlgoliaSearch\SearchIndex;

class Index {

	private $type;

	private $name;

	private $algoliaIndex;

	private $indexers = array();

	/**
	 * @return string
	 */
	public function getType(): string {
		return $this->type;
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}

	public function getAlgoliaIndex(): SearchIndex {
		if (!isset($this->algoliaIndex)) {
			$client = Indices::getClient();
			$this->algoliaIndex = $client->initIndex($this->getName());
		}
		return $this->algoliaIndex;
	}

	public function __construct(string $type, string $name) {
		$this->type = $type;
		$this->name = $name;
	}


	public function addIndexer (Indexer $indexer) {
		$this->indexers[] = $indexer;
	}

	public function indexAll () {
		$index = $this->getAlgoliaIndex();

		foreach ($this->indexers as $indexer) {
			$indexer->indexAll($index);
		}
	}
}