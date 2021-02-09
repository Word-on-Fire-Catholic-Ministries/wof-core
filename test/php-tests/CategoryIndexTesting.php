<?php
use PHPUnit\Framework\TestCase;
use WOF\Search\Indexers\PostIndexer;
//require('./wordpress/wp-includes/post.php');

class CategoryIndexTesting extends TestCase{
    public function testIsraelChosenArticle(){
        $post_num = 109;
        $post = get_post($post_num);
        $post = WP_Post::get_instance($post_num);

        $indexer = new PostIndexer();
        $serialized = $indexer->serializePost($post);
        $this->assertEquals($serialized['categories.lv10'], 'Watch');
        $this->assertEquals($serialized['categories.lv11'], 'Shows');
        $this->assertEquals($serialized['categories.lv12'], "Bishop Barron's Sermons");
    }
}

