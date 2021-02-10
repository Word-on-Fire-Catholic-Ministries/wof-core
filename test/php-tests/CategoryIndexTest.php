<?php
use PHPUnit\Framework\TestCase;
use WOF\Search\Indexers\PostIndexer;
//use WP_Mock\Tools\TestCase;

//require('./wordpress/wp-includes/post.php');

class CategoryIndexTest extends TestCase
{
    public function testIsraelChosenArticle()
    {
        $categories = WP_Term::make_array(WP_Term::test_data());
        $this->assertEquals(false, true);
        $pi = new PostIndexer();

//        $serialized = $pi->serialize_categories($categories);
//        $this->assertEquals('watch', $serialized['categories.lv10']);
//        $this->assertEquals('shows', $serialized['categories.lv11']);
//        $this->assertEquals("word on fire show, sermons", $serialized['categories.lv12']);
    }

    /*public function set_up_cats(): array
    {
        //WP_Mock::setUp();
        $cat1 = new WP_Term(new stdClass());
        $cat2 = new WP_Term(new stdClass());
        $cat3 = new WP_Term(new stdClass());
        $cat4 = new WP_Term(new stdClass());

        $cat1->name = 'watch';
        $cat2->name = 'shows';
        $cat3->name = 'word on fire show';
        $cat4->name = 'sermons';

        $cat1->term_id = 4;
        $cat2->term_id = 8;
        $cat3->term_id = 11;
        $cat4->term_id = 14;

        $cat1->parent = 0;
        $cat2->parent = 4;
        $cat3->parent = 8;
        $cat4->parent = 8;

        $cats = array();
        $cats[] = $cat1;
        $cats[] = $cat2;
        $cats[] = $cat3;
        $cats[] = $cat4;

        return $cats;
    }

    private function set_up_post(): WP_Post{
        $post = new WP_Post(new stdClass());
        $post->
    }*/
}

