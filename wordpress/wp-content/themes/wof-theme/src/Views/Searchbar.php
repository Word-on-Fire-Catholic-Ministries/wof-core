<?php


namespace WOF\Org\Theme\Views;


class Searchbar {

	public function registerHooks() {
		add_action( 'wp_print_footer_scripts', array( $this, 'on_print_footer_scrtips_add_search_js' ), 700 );

	}

	public function on_print_footer_scrtips_add_search_js() {
		$appId  = ALGOLIA_APP_ID;
		$apiKey = ALGOLIA_PUBLIC_KEY;
		$index  = ALGOLIA_INDEX_CONTENT;

		echo "<script> var mainSearch = window.wofSearchbar(
			  '{$appId}',
			  '{$apiKey}',
			  '{$index}',
			  {
			    searchBoxContainer: 'searchbar-searchbox',
			    hitsContainer: 'searchbar-hits'
			  }
			) </script>";

		if ( is_search() ) {
			echo "<script> var searchPage = window.wofSearchpage(
			  '{$appId}',
			  '{$apiKey}',
			  '{$index}',
			  {
			    searchBoxContainer: 'searchpage-searchbox',
			    hitsContainer: 'searchpage-hits'
			  }
			) </script>";
		}

	}
}