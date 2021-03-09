<?php

namespace WOF\Tests\Search;

use WOF\Mocks\Taxonomy\Wofi_Term;
use PHPUnit\Framework\TestCase;
use WOF\Search\Indexers\PostIndexer;

class IndexerTest extends TestCase
{
    public function testSerializeCategoryReturnsFlatArray()
    {
        $categories = Wofi_Term::make_array(Wofi_Term::test_data());
        $pi = new PostIndexer();
        $serialized = $pi->serialize_hierarchical_categories($categories);
        $this->assertEquals('Read, Watch', $serialized['categories.lv10']);
        $this->assertEquals('Articles, Shows', $serialized['categories.lv11']);
        $this->assertEquals("daily gospel reflections, word on fire show, sermons",
            $serialized['categories.lv12']);
    }

    public function testSerializeHierarchicalCategoriesReturnsCorrectLength() {
	    $categories = Wofi_Term::make_array(Wofi_Term::test_data());
	    $pi = new PostIndexer();
	    $serialized = $pi->serialize_hierarchical_categories($categories);
	    $this->assertEquals('Read, Watch', $serialized['categories.lv10']);
	    $this->assertEquals('Articles, Shows', $serialized['categories.lv11']);
	    $this->assertEquals("daily gospel reflections, word on fire show, sermons",
		    $serialized['categories.lv12']);
    }

    public function testSerializeHierarchicalCategoriesReturnsCorrectFormat() {

    }
}

