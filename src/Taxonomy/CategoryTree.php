<?php


namespace WOF\Taxonomy;


class CategoryTree {

	/**
	 * @var array original array of WP_Term objects
	 */
	private array $terms;

	/**
	 * @var array of Category objects
	 */
	private array $categories;

	public function __construct( array $terms ) {
		$this->terms = $terms;

		$this->categories = $this->make_tree();
		$this->connect_nodes();
		$this->set_category_depths();
	}

	private function make_tree () : array {
		$categories = array();
		foreach($this->terms as $term){
			$category = new Category($term);
			$categories[$category->get_term_id()] = $category;
		}
		return $categories;
	}

	private function connect_nodes () {
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
		$depths = array(); // [depth (int) => "cat, cat, cat"]
		foreach($this->categories as $cat){
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
