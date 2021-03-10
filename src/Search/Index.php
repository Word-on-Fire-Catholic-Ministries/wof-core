<?php


namespace WOF\Search;


use Algolia\AlgoliaSearch\SearchClient;
use Algolia\AlgoliaSearch\SearchIndex;
use WP_Post;

class Index {

	private $type;

	private $name;

	private $algoliaIndex;

	private $indexers;

	private $client;

	private $idPrefix;

	private $siteName;

	public function __construct(string $type, string $name, SearchClient $client, string $idPrefix, string $siteName) {
		$this->indexers = array();
		$this->type = $type;
		$this->name = $name;
		$this->client = $client;
		$this->idPrefix = $idPrefix;
		$this->siteName = $siteName;
		add_action('save_post', array($this, 'on_save_post'), 100, 3);
	}

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
			$this->algoliaIndex = $this->client->initIndex($this->getName());
		}
		return $this->algoliaIndex;
	}


	public function addIndexer (Indexer $indexer) {
		$indexer->setIndexType($this->type);
		$indexer->setIdPrefix($this->idPrefix);
		$indexer->setSiteName(($this->siteName));
		$this->indexers[$indexer->getPostType()] = $indexer;
	}

	public function indexAll () : int {
		$index = $this->getAlgoliaIndex();

		$count = 0;

		foreach ($this->indexers as $indexer) {
			$count =+ $indexer->indexAll($index);
		}

		return $count;
	}

	public function on_save_post ($id, WP_Post $post, $update) {
		if (wp_is_post_revision($id)
		    || wp_is_post_autosave($id)
		    || !isset($this->indexers[$post->post_type])) {
			return $post;
		}

		$this->indexers[$post->post_type]->indexSingle($this->getAlgoliaIndex(), $post);

		return $post;
	}
}
