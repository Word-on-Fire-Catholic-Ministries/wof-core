<?php


namespace WOF\Org\Theme;


class Blocks {

	public static function parse_block_name(string $block_name) : string {
		list($pre, $name) = explode('/', $block_name);
		return $name;
	}

	public static function get_anchor(array $block) : string {
		$block_name = self::parse_block_name($block['name']);
		if( !empty($block['anchor']) ) {
			return $block['anchor'];
		} else {
			return $block_name . '-' . $block['id'];
		}
	}

	public static function get_post_unique_css_class (string $block_name, int $post_id = -1) : string {
		$class = "";
		if ($post_id > 0) {
			$class = "$block_name-$post_id";

			if (is_admin()) {
				$class .= ' .block-editor-block-list__layout';
			}
		}
		return $class;
	}

	public static function get_block_unique_css_class (string $block_name, string $block_id) : string {
		return "$block_name-$block_id";
	}

	public static function get_css_classes(array $block, int $post_id = -1) : string {
		$block_name = self::parse_block_name($block['name']);
		$classes = $block_name;

		$classes .= ' ' . self::get_block_unique_css_class($block_name, $block['id']);

		if ($post_id > 0) {
			$classes .= ' ' . self::get_post_unique_css_class($block_name, $post_id);
		}

		if( !empty($block['className']) ) {
			$classes .= ' ' . $block['className'];
		}

		if( !empty($block['align']) ) {
			$classes .= ' align' . $block['align'];
		}
		return $classes;
	}


}