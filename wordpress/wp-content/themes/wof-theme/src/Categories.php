<?php

namespace WOF\Org\Theme;

class Categories
{
    private array $categories; // array of category objects ordered by term_id

    public function build_category_hierarchy(): void
    {
        $this->get_list_of_cats();
        $this->connect_categories();
        $this->set_category_depths();
    }

    private function get_list_of_cats(): void{
        $wp_categories = get_categories();
        foreach ($wp_categories as $wp_cat) {
            $category = new Category($wp_cat);
            $this->categories[$category->get_term_id()] = $category;
        }
    }

    //Connect the nodes of the tree
    private function connect_categories(): void{
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

    public function turn_category_list_to_json(){
        $collection = array();
        foreach ($this->categories as $category){
            $collection[] = $category->jsonify();
        }
        Debug::print_var(json_encode($collection));
        //($collection);
    }
}


