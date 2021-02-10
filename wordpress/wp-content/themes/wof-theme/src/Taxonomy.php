<?php


namespace WOF\Org\Theme;

defined( 'ABSPATH' ) || exit;


class Taxonomy {
	/**
	 * Register the custom taxonomies during init
	 */
	public function register_hooks() {
		add_action('init', array($this, 'on_init_add_author_group_tax'));
		add_action('admin_menu', array($this, 'on_admin_menu_add_author_groups'));
		add_filter( 'submenu_file', array($this, 'on_submenu_set_user_submenu_active'));
	}

	public function on_init_add_author_group_tax () {
		register_taxonomy(
			'author_groups', //taxonomy name
			'user', //object for which the taxonomy is created
			array( //taxonomy details
				'public' => true,
				'labels' => array(
					'name'		=> 'Author Groups',
					'singular_name'	=> 'Author Group',
					'menu_name'	=> 'Author Groups',
					'search_items'	=> 'Search Author Groups',
					'popular_items' => 'Popular Author Groups',
					'all_items'	=> 'All Author Groups',
					'edit_item'	=> 'Edit Author Group',
					'update_item'	=> 'Update Author Group',
					'add_new_item'	=> 'Add New Author Group',
					'new_item_name'	=> 'New User Author Group',
				),
				'update_count_callback' => function() {
					return; //important
				}
			)
		);
	}

	function on_admin_menu_add_author_groups() {
		$taxonomy = get_taxonomy( 'author_groups');
		add_users_page(
			esc_attr( $taxonomy->labels->menu_name ),//page title
			esc_attr( $taxonomy->labels->menu_name ),//menu title
			$taxonomy->cap->manage_terms,//capability
			'edit-tags.php?taxonomy=' . $taxonomy->name//menu slug
		);
	}



	function on_submenu_set_user_submenu_active( $submenu_file ) {
		global $parent_file;
		if( 'edit-tags.php?taxonomy=' . 'author_groups' == $submenu_file ) {
			$parent_file = 'users.php';
		}
		return $submenu_file;
	}
}