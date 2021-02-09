<?php
class WP_Term {

    public string $name;
    public int $term_id;
    public int $parent;

    public function __construct(string $name, int $term_id, int $parent) {
        $this->name = $name;
        $this->term_id = $term_id;
        $this->parent = $parent;
    }

    public static function make_array (array $test_data) : array {
        $term_array = array();

        foreach ($test_data as $test) {
            $term_array[] = new WP_Term($test['name'], $test['term_id'], $test['parent']);
        }

        return $term_array;
    }

    public static function test_data () : array {
        return array(
            array( 'name' => 'watch', 'term_id' => 4, 'parent' => 0 ),
            array( 'name' => 'shows', 'term_id' => 8, 'parent' => 4 ),
            array( 'name' => 'word on fire show', 'term_id' => 11, 'parent' => 8 ),
            array( 'name' => 'sermons', 'term_id' => 14, 'parent' => 8 ),
        );
    }


}
