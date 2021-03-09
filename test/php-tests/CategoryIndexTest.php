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

    public function testSerializePostIsraelChosenSermon(){
        $post = get_post(109); //Israel is Chosen for the World Test
        $postIndexer = new PostIndexer();
        $serialized = $postIndexer->serializePost($post);
        $this->assertEquals('Watch',$serialized['categories.lv10']);
        $this->assertEquals('Shows', $serialized['categories.lv11']);
        $this->assertEquals("Bishop Barron's Sermons", $serialized['categories.lv12']);
    }

    public function testSerializePostShouldMySonBeMyFather(){
        $post = get_post(59); //Should my Son be my Father
        $postIndexer = new PostIndexer();
        $serialized = $postIndexer->serializePost($post);
        $this->assertEquals('Read',$serialized['categories.lv10']);
        $this->assertEquals('Articles', $serialized['categories.lv11']);
        $this->assertEquals(null, $serialized['categories.lv12']);
    }
}

