<?php
namespace WOF\Taxonomy;


class Categories {

    /**
     * @param int $post_id
     * @return array of categories as WP_Term objects
     * Returns an array of WP_Terms for all categories for a post including parents
     * It first fetches all direct parent terms for a post and then iterates through
     * all of those term parents
     */
    public static function get_all_for_post($post_id): array{
        $initial_terms = wp_get_post_categories($post_id,array('fields' => 'all'));
        $return_list = array(); // return value
        foreach($initial_terms as $term){
            $return_list[$term->term_id] = $term; // add the initial terms
            $current_term = $term;
            //find each terms entire list of parents and add them
            while($current_term->parent !== 0){
                $current_term = get_term($current_term->parent);
                $return_list[$current_term->term_id] = $current_term;
            }
        }
        return $return_list;
    }
}
