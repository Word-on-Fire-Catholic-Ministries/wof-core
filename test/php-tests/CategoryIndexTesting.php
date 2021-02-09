<?php
use PHPUnit\Framework\TestCase;
use WOF\Search\Indexers\PostIndexer;
//use WP_Mock\Tools\TestCase;

//require('./wordpress/wp-includes/post.php');

require_once ('../mocks/WP_Term.php');

class CategoryIndexTesting extends TestCase
{
	public function testIsraelChosenArticle()
	{
		$categories = WP_Term::make_array(WP_Term::test_data());

		$pi = new PostIndexer();
		$serialized = $pi->serialize_categories($categories);
		$this->assertEquals( 'watch', $serialized['categories.lv10'] );
		$this->assertEquals( 'shows', $serialized['categories.lv11'] );
		$this->assertEquals( "word on fire show, sermons", $serialized['categories.lv12'] );
	}
}

