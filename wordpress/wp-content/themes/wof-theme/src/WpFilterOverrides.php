<?php


namespace WOF\Org\Theme;

defined( 'ABSPATH' ) || exit;

class WpFilterOverrides {

	public function registerFilters() {
		add_filter( 'get_the_archive_title', array($this, 'removeArchiveTaxType') );
	}

	public function removeArchiveTaxType ( $title ) {
		if ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		} elseif ( is_author() ) {
			$title = '<span class="vcard">' . get_the_author() . '</span>';
		} elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		} elseif ( is_tax() ) {
			$title = single_term_title( '', false );
		}

		return $title;
	}

}