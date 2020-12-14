<?php


namespace WOF\Search\Algolia;

defined( 'ABSPATH' ) || exit;


interface Serializable {

	public function serialize(\WP_Post $post) : array;

}