<?php


namespace WOF\Search\Indexers;

use WOF\Search\Category;
use WOF\Search\Indexer;
use WP_Post;
use WP_Term;

defined( 'ABSPATH' ) || exit;

class PostIndexer extends Indexer {

	public function __construct() {
		$this->postType = 'post';
	}

	public function serializePost( WP_Post $post ): array {
		$serialized = parent::serializePost( $post );

		if (has_post_thumbnail($post)) {
			$serialized['thumbnail'] = get_the_post_thumbnail_url($post);
		}

		$serialized['tags'] = array_map(function (WP_Term $term) {
			return $term->name;
		}, wp_get_post_terms($post->ID, 'post_tag'));

//		$serialized['categories'] = wp_get_post_categories(
//			$post->ID, array('fields' => 'names'));
        $serialized = $this->serializeCategoriesForPost($post->ID, $serialized);

		return $serialized;
	}

	private function serializeCategoriesForPost($post_id, $serialized): array{

	    $post_cats = wp_get_post_categories($post_id,array('fields' => array('names', 'parents', 'term_ids')));
        $categories = $this->putCategoriesIntoList($post_cats);
        //make a tree of categories
        $this->connect_categories($categories);
        $this->set_category_depths($categories);
        //add the categories hierarchically
        foreach($this->getDepthArray($categories) as $depth => $cats){
            $serialized['categories.lv'.strval($depth)] = $cats;
        }
        return $serialized;
    }

    private function putCategoriesIntoList($wp_cats): array{
	    $categories = array();
        foreach($wp_cats as $wp_cat){
            $category = new Category($wp_cat);
            $categories[$category->get_term_id()] = $category;
        }
        return $categories;
    }

    //Connect the nodes of the tree
    private function connect_categories($categories): void{
        foreach ($categories as $cat) {
            if ($cat->get_parent_term_id() === 0) {
                continue; //top of the tree, no parent
            } else {
                $cat_parent = $categories[$cat->get_parent_term_id()];
                $cat_parent->add_child($cat);
                $cat->set_parent($cat_parent);
            }
        }
    }

    //set the depths of the nodes in the tree
    private function set_category_depths($categories): void{
        foreach ($categories as $cat) {
            $cat->set_depth();
        }
    }

    /*
     * Returns an array of depths with the list of category names at those depths
     * given a list of categories associated with a post
     */
    private function getDepthArray($categories): array{
	    $depths = array(); // [depth (int) => "cat, cat, cat"]
	    foreach($categories as $cat){
	        if(isset($depths[$cat->get_depth()])){
	            $depths[$cat->get_depth()] = $depths[$cat->get_depth()].', '.$cat->get_name();
            }
	        else{
	            $depths[$cat->get_depth()] = $cat->get_name();
            }
        }
	    return $depths;
    }
}
