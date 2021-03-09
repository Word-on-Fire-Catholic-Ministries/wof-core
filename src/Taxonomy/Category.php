<?php
namespace WOF\Search;

/*
 * Tree of Categories. Each category holds a reference to it's parent as
 * well as a list of children along with term ids for both
 * For Algolia, it holds a depth property which is its depth
 * in the Categories tree
 */
class Category
{
    private string $name;

    private array $children;
    private array $children_term_ids;
    private Category $parent;
    private int $parent_term_id;

    private int $term_id;

    private int $depth;

    public function __construct($wp_category)
    {
        $this->name = $wp_category->name;
        $this->parent_term_id = $wp_category->parent;
        $this->term_id = $wp_category->term_id;
    }

    public function get_depth(): int
    {
        return $this->depth;
    }

    public function get_name(): string
    {
        return $this->name;
    }

    public function set_parent(Category $par): void
    {
        $this->parent = $par;
    }

    public function add_child(Category $child): void
    {
        $this->children[] = $child;
        $this->children_term_ids[] = $child->get_term_id();
    }

    public function get_term_id(): int
    {
        return $this->term_id;
    }

    public function get_parent(): Category{
        return $this->parent;
    }

    public function get_parent_term_id(): int
    {
        return $this->parent_term_id;
    }

    //Recursively find out where the node is in the tree
    public function set_depth(): int
    {
        //Base case, no parent, default depth of 10 for Algolia
        if ($this->parent_term_id === 0) {
            $this->depth = 10;
            return 10;
        } //Recurse
        else {
            $this->depth = $this->parent->set_depth() + 1;
            return $this->depth;
        }
    }

    public function get_parent_string_list ($return_string) {
        $return_string .= $this->name;
        if($this->parent){
            $return_string .= ' > ';
            $return_string .= $this->get_parent_string_list($return_string);
        }
        //base case no parent
        return $return_string;
    }

    public function jsonify(){
        $rv = array("name" => $this->name);

        if($this->parent_term_id === 0){
            return ($rv);
        }
        else{
            $temp_depth = $this->parent->get_depth();
            $temp_parent = $this->parent;
            while($temp_depth >= 10){
                //check for last level
                if($temp_parent->get_parent_term_id() === 0){
                    $rv['categories.lv'.strval($temp_depth)] = $temp_parent->get_name();
                    break;
                }
                $rv['categories.lv'.strval($temp_depth)] = $temp_parent->get_name();
//                Debug::print_var($temp_parent);
//                Debug::print_var($temp_depth);
                $temp_depth--;
                $temp_parent = $temp_parent->get_parent();
            }
            return ($rv);
        }
    }
}
