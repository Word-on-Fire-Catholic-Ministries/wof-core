<?php

namespace WOF\Tests\Search;

use WOF\Mocks\Taxonomy\Wofi_Term;
use PHPUnit\Framework\TestCase;
use WOF\Search\Index;
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

    public function testSerializeCategoriesReturnsArrayInOrder() {
	    $categories = Wofi_Term::make_array(Wofi_Term::test_data());
	    $pi = new PostIndexer();
	    $serialized = $pi->serialize_categories($categories);
	    $this->assertEquals(['read', 'watch', 'articles', 'shows', 'daily gospel reflections', 'word on fire show', 'sermons'], $serialized);
    }

    public function testSerializeHierarchicalCategoriesReturnsArray() {
	    $categories = Wofi_Term::make_array(Wofi_Term::test_data());
	    $pi = new PostIndexer();
	    $serialized = $pi->serialize_hierarchical_categories($categories);
	    $this->assertIsArray($serialized);
    }

	public function testSerializeHierarchicalCategoriesReturnsCorrectLength() {
		$categories = Wofi_Term::make_array(Wofi_Term::test_data());
		$pi = new PostIndexer();
		$serialized = $pi->serialize_hierarchical_categories($categories);
		$this->assertEquals(3 , sizeof($serialized));
	}

	public function testSerializeHierarchicalCategoriesReturnsArrayInOrder() {
		$categories = Wofi_Term::make_array(Wofi_Term::test_data());
		$pi = new PostIndexer();
		$serialized = $pi->serialize_hierarchical_categories($categories);
		$this->assertEquals([
			'lvl0' => ['read', 'watch'],
			'lvl1' => ['articles > read', 'shows > watch'],
			'lvl2' => [
				'daily gospel reflections > articles > read',
				'word on fire show > shows > watch',
				'sermons > shows > watch'
				]
			], $serialized);
	}

	public function testGetAllPostCategoriesSonFatherArraySize() {
        $postIndexer = new PostIndexer();
        //Should my son be my father
        $categories = $postIndexer->get_entire_list_of_post_categories(59);
        $this->assertEquals(2, sizeof($categories));
    }

    public function testGetAllPostCategoriesSonFatherProperList() {
        $postIndexer = new PostIndexer();
        // should my son be my father
        $categories = $postIndexer->get_entire_list_of_post_categories(59);
        $this->assertEquals('Read', $categories[2]->name);
        $this->assertEquals('Articles', $categories[5]->name);
    }

    public function testGetAllPostCategoriesRockStarArraySize() {
        $postIndexer = new PostIndexer();
        //When a Christian Rock star stops...
        $categories = $postIndexer->get_entire_list_of_post_categories(45);
        $this->assertEquals(3, sizeof($categories));
    }

    public function testGetAllPostCategoriesRockStarProperList() {
        $postIndexer = new PostIndexer();
        // When a Christian Rock Start stops...
        $categories = $postIndexer->get_entire_list_of_post_categories(45);
        $this->assertEquals('Word on Fire Show', $categories[11]->name);
        $this->assertEquals('Shows', $categories[8]->name);
        $this->assertEquals('Watch', $categories[4]->name);
    }
}

