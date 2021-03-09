<?php

namespace WOF\Tests\Search;

use WOF\Mocks\Taxonomy\Wofi_Term;
use PHPUnit\Framework\TestCase;
use WOF\Search\Indexers\PostIndexer;

class IndexerTest extends TestCase
{
    public function testSerializeCategoryReturnsArray()
    {
        $categories = Wofi_Term::make_array(Wofi_Term::test_data());
        $pi = new PostIndexer();
        $serialized = $pi->serialize_categories($categories);
        $this->assertIsArray($serialized);
    }

	public function testSerializeCategoryReturnsArrayOfCorrectLength()
	{
		$categories = Wofi_Term::make_array(Wofi_Term::test_data());
		$pi = new PostIndexer();
		$serialized = $pi->serialize_categories($categories);
		$this->assertEquals(7 , sizeof($serialized));
	}

    public function testSerializeHierarchicalCategoriesReturnsArrayInOrder() {
	    $categories = Wofi_Term::make_array(Wofi_Term::test_data());
	    $pi = new PostIndexer();
	    $serialized = $pi->serialize_categories($categories);
	    $this->assertIsArray($serialized);
	    $this->assertEquals(['read', 'watch', 'articles', 'shows', 'daily gospel reflections', 'word on fire show', 'sermons'], $serialized);
    }

//    public function testSerializeHierarchicalCategoriesReturnsCorrectFormat() {
//
//    }
}

