<?php

use Mocks\Wofi_Term;
use PHPUnit\Framework\TestCase;
use WOF\Search\Indexers\PostIndexer;

class CategoryIndexTest extends TestCase
{
    public function testIsraelChosenArticle()
    {
        $categories = Wofi_Term::make_array(Wofi_Term::test_data());
        $pi = new PostIndexer();

        $serialized = $pi->serialize_hierarchical_categories($categories);
        $this->assertEquals('Read, Watch', $serialized['categories.lv10']);
        $this->assertEquals('Articles, Shows', $serialized['categories.lv11']);
        $this->assertEquals("daily gospel reflections, word on fire show, sermons",
            $serialized['categories.lv12']);
    }
}

