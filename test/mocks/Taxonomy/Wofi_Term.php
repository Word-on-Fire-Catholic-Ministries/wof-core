<?php
namespace WOF\Mocks\Taxonomy;
class Wofi_Term{

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
            $term_array[] = new Wofi_Term($test['name'], $test['term_id'], $test['parent']);
        }

        return $term_array;
    }

    public static function test_data () : array {
        return array(
            array( 'name' => 'read', 'term_id' => 2, 'parent' => 0 ),
            array( 'name' => 'articles', 'term_id' => 5, 'parent' => 2 ),
            array( 'name' => 'daily gospel reflections', 'term_id' => 19, 'parent' => 5 ),
            array( 'name' => 'watch', 'term_id' => 4, 'parent' => 0 ),
            array( 'name' => 'shows', 'term_id' => 8, 'parent' => 4 ),
            array( 'name' => 'word on fire show', 'term_id' => 11, 'parent' => 8 ),
            array( 'name' => 'sermons', 'term_id' => 14, 'parent' => 8 ),
        );
    }


}
