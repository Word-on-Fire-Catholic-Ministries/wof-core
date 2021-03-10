<?php


namespace WOF\Taxonomy;


use WOF\Core\Exceptions\WofException;
use WP_Term;

defined( 'ABSPATH' ) || exit;

class AuthorGroup {

	private WP_Term $term;

	private static string $taxonomy = 'author_groups';

	public function __construct(WP_Term $term) {
		$this->term = $term;
	}

	public static function create_from_term(WP_Term $term) {
		if ($term->taxonomy !== self::$taxonomy) {
			return false;
		}
		return new AuthorGroup($term);
	}

	public function get_users (): array {
		return get_objects_in_term($this->term->term_id, self::$taxonomy);
	}

	public function get_name (): string {
		return $this->term->name;
	}

}
