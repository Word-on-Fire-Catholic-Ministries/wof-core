<?php
use PHPUnit\Framework\TestCase;
use WOF\Search\Indexers\PostIndexer;
//use WP_Mock\Tools\TestCase;

//require('./wordpress/wp-includes/post.php');

class CategoryIndexTesting extends TestCase
{
    public function testIsraelChosenArticle()
    {
        $categories = $this->set_up();

        $pi = new PostIndexer();
        $serialized = $pi->serializeCategoriesForPost($categories, null);
        $this->assertEquals($serialized['categories.lv10'], 'watch');
        $this->assertEquals($serialized['categories.lv11'], 'shows');
        $this->assertEquals($serialized['categories.lv12'], "word on fire show, sermons");
    }

    public function set_up(): array
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
}

