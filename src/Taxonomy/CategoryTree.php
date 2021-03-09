<?php


namespace WOF\Taxonomy;

use WOF\Core\Debug;

defined( 'ABSPATH' ) || exit;

class CategoryTree {

    /**
     * @var array original array of WP_Term objects
     */
    private array $terms;

    /**
     * @var array of Category objects
     */
    private array $categories = array();

    public function __construct( array $terms ) {
        $this->terms = $terms;

        $this->make_tree();
        $this->connect_nodes();
        $this->set_category_depths();
    }

    private function make_tree () : void {
        foreach($this->terms as $term){
            $category = new Category($term);
            $this->categories[$category->get_term_id()] = $category;
        }
        //add parents to the categories list
        foreach($this->terms as $term){
            $this->add_parent_nodes_to_tree($term);
        }
    }

    // Adds the parents of a category to a tree
    private function add_parent_nodes_to_tree($term): void{
        $parent_id = $term->parent;
        //base case, top of tree, return
        if($parent_id === 0){
            return;
        }
        else{
            $parent_term = $this->get_term($parent_id);
            $parent_cat = new Category($parent_term);
            //Debug::printVar($parent_cat);
            $this->categories[$parent_id] = $parent_cat;
            //Debug::printVar($this->categories);
            $this->add_parent_nodes_to_tree($parent_term);
        }
    }

    private function get_term ($term_id) {
    	foreach ($this->terms as $term) {
    		if ($term->term_id === $term_id) {
    			return $term;
		    }
	    }
    	return null;
    }

    private function connect_nodes () {
        //Debug::printVar($this->categories);
        foreach ($this->categories as $cat) {
            if ($cat->get_parent_term_id() === 0) {
                continue; //top of the tree, no parent
            } else {
                $cat_parent = $this->categories[$cat->get_parent_term_id()];
                $cat_parent->add_child($cat);
                $cat->set_parent($cat_parent);
            }
        }
    }

    //set the depths of the nodes in the tree
    private function set_category_depths(): void{
        foreach ($this->categories as $cat) {
            $cat->set_depth();
        }
    }

    /*
     * Returns an array of depths with the list of category names at those depths
     * given a list of categories associated with a post
     */
    public function get_depth_array(): array{
        $depths = array(); // [depth (int) => [cat, cat, cat]
        foreach($this->categories as $cat){
            if(isset($depths[$cat->get_depth()])){
                $depths[$cat->get_depth()][]  = $cat->get_name();
            }
            else{
                $depths[$cat->get_depth()] = array($cat->get_name());
            }
        }
        return $depths;
    }

    public function get_category_list(): array {
        $list = array();
        $depth_array = $this->get_depth_array();
        foreach($depth_array as $depth => $names){
            foreach($names as $name){
                $list[] = $name;
            }
        }
        return $list;
    }

    public function get_hierarchical_list(): array {
        $list = array();
        foreach($this->categories as $cat){
            if(isset($list[$cat->get_depth()])){
                $list[$cat->get_depth()][] = $cat->get_parent_string_list();
            }
            else{
                $list[$cat->get_depth()] = array($cat->get_parent_string_list());
            }
        }
        return $list;
    }
}
