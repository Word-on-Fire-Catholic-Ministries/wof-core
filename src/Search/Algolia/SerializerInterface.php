<?php


namespace WOF\Search\Algolia;

defined( 'ABSPATH' ) || exit;


interface SerializerInterface {

	public function serialize(\WP_Post $post) : array;

}