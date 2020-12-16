<?php


namespace WOF\Search;

defined( 'ABSPATH' ) || exit;


interface Serializable {

	public function serialize(\WP_Post $post) : array;

}