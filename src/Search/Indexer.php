<?php


namespace WOF\Search;


use Algolia\AlgoliaSearch\SearchIndex;
use Exception;
use WOF\Core\Debug;
use WOF\Taxonomy\CategoryTree;
use WP_Post;
use WP_Query;
use WP_Term;

defined( 'ABSPATH' ) || exit;

abstract class Indexer {

	protected $postType = 'post';
	protected $indexType = 'content';
	protected $idPrefix = 'nil';
	protected $siteName = 'wordonfire';

	public function getPostType () : string {
		return $this->postType;
	}

	public function getIndexType () : string {
		return $this->indexType;
	}

	public function setIndexType (string $type) {
		$this->indexType = $type;
	}

	public function setIdPrefix (string $prefix) {
		$this->idPrefix = $prefix;
	}

	public function setSiteName (string $siteName) {
	    $this->siteName = $siteName;
    }

	public function indexAll (SearchIndex $index, int $batchSize = 100) : int {

		$paged = 1;
		$count = 0;

		do {
			$posts = new WP_Query([
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

		return $count;
	}

	public function indexSingle (SearchIndex $index, WP_Post $post) {
		$record = $this->serializePost($post);

		$no_index = get_field('do_not_index', $post->ID);

		// Remove from index if this update trashes the post
		if ($post->post_status !== 'publish' || $no_index === true) {
			$index->deleteObject($record['objectID']);
		} else {
			$index->saveObject($record);
		}
	}

	public function serializePost ( WP_Post $post) : array {
		if ($post->post_type !== $this->getPostType()) {
			throw new Exception('Attempting to serialize wrong post type');
		}

		return [
			'objectID' => "{$this->idPrefix}_{$post->post_type}#{$post->ID}",
			'title' => $post->post_title,
			'published' => $post->post_date,
			'site' => $this->siteName,
			'author' => [
				'id' => $post->post_author,
				'name' => get_user_by('ID', $post->post_author)->display_name,
				'url' => esc_url( get_author_posts_url( $post->post_author ) )
			],
			'excerpt' => wp_strip_all_tags( get_the_excerpt($post->ID) ),
			'content' => wp_strip_all_tags($post->post_content),
			'url' => esc_url( get_permalink($post->ID) )
		];
	}

	public function serialize_categories ( array $terms ) : array {
		$names = array();

		foreach ($terms as $term) {
			$names[] = $term->name;
		}

		return $names;
	}

    public function serialize_hierarchical_categories( array $terms ) : array {
        $cats = new CategoryTree($terms);
        $list = $cats->get_hierarchical_list();
        $json = array();

        foreach($list as $depth => $cat){
            $json['lvl' . strval($depth)] = $cat;
        }
	    ksort($json);
        return $json;
    }

    public function serialize_tags ( array $terms ): array {
        return array_map(function (WP_Term $term) {
            return $term->name;
        }, $terms);
    }
}
