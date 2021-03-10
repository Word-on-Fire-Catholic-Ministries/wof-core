<?php

namespace WOF\Tests\Taxonomy;

use PHPUnit\Framework\TestCase;
use WOF\Taxonomy\Categories;

class CategoriesTest extends TestCase {
    public function testGetAllPostCategoriesSonFatherArraySize() {
        //Should my son be my father
        $categories = Categories::get_all_for_post(59);
        $this->assertEquals(2, sizeof($categories));
    }

    public function testGetAllPostCategoriesSonFatherProperList() {
        // Should my son be my father
        $categories = Categories::get_all_for_post(59);
        $this->assertEquals('Read', $categories[2]->name);
        $this->assertEquals('Articles', $categories[5]->name);
    }

    public function testGetAllPostCategoriesRockStarArraySize() {
        // When a Christian Rock star stops...
        $categories = Categories::get_all_for_post(45);
        $this->assertEquals(3, sizeof($categories));
    }

    public function testGetAllPostCategoriesRockStarProperList() {
        // When a Christian Rock Start stops...
        $categories = Categories::get_all_for_post(45);
        $this->assertEquals('Word on Fire Show', $categories[11]->name);
        $this->assertEquals('Shows', $categories[8]->name);
        $this->assertEquals('Watch', $categories[4]->name);
    }
}
