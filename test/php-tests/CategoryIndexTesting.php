<?php
use PHPUnit\Framework\TestCase;
use WOF\Search\Indexers\PostIndexer;
//require('./wordpress/wp-includes/post.php');

class CategoryIndexTesting extends TestCase{
    public function testIsraelChosenArticle(){
        $post = get_post(109);
        $pi = new PostIndexer();
        $serialized = $pi->serializePost($post);
        $this->assertEquals($serialized['categories.lv10'], 'Watch');
        $this->assertEquals($serialized['categories.lv11'], 'Shows');
        $this->assertEquals($serialized['categories.lv12'], "Bishop Barron's Sermons");
    }
}

