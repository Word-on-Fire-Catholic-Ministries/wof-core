<?php

use Mocks\Wofi_Term;
use PHPUnit\Framework\TestCase;
use WOF\Search\Indexers\PostIndexer;

//require('./wordpress/wp-includes/post.php');

class CategoryIndexTest extends TestCase
{
    public function testIsraelChosenArticle()
    {
        $categories = Wofi_Term::make_array(Wofi_Term::test_data());
        $pi = new PostIndexer();

        $serialized = $pi->serialize_categories($categories);
        $this->assertEquals('read, watch', $serialized['categories.lv10']);
        $this->assertEquals('articles, shows', $serialized['categories.lv11']);
        $this->assertEquals("daily gospel reflections, word on fire show, sermons",
            $serialized['categories.lv12']);
    }
}

