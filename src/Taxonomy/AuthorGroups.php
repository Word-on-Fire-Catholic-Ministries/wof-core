<?php


namespace WOF\Taxonomy;


defined( 'ABSPATH' ) || exit;


class AuthorGroups {
	/**
	 * Register the custom taxonomies during init
	 */
	public function register_hooks() {
		add_action('init', array($this, 'on_init_add_author_group_tax'));
		add_action('admin_menu', array($this, 'on_admin_menu_add_author_groups'));
		add_filter( 'submenu_file', array($this, 'on_submenu_set_user_submenu_active'));
		add_action('show_user_profile', array($this, 'edit_user_profile'), 0);
		add_action('edit_user_profile', array($this, 'edit_user_profile'), 0);
		add_action('personal_options_update', array($this, 'save_author_group_terms'));
		add_action('edit_user_profile_update', array($this, 'save_author_group_terms'));
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
				'rewrite' => array(
					'with_front' => true,
					'slug' => 'author/group' // Use 'author' (default WP user slug).
				),
				'capabilities' => array(
					'manage_terms' => 'edit_users', // Using 'edit_users' cap to keep this simple.
					'edit_terms'   => 'edit_users',
					'delete_terms' => 'edit_users',
					'assign_terms' => 'read',
				),
				'update_count_callback' => 'WOF\Taxonomy\author_group_update_count'
			)
		);
	}

	public function on_admin_menu_add_author_groups() {
		$taxonomy = get_taxonomy( 'author_groups');
		add_users_page(
			esc_attr( $taxonomy->labels->menu_name ),//page title
			esc_attr( $taxonomy->labels->menu_name ),//menu title
			$taxonomy->cap->manage_terms,//capability
			'edit-tags.php?taxonomy=' . $taxonomy->name//menu slug
		);
	}

	public function edit_user_profile( $user ) {
		$tax = get_taxonomy( 'author_groups' );

		if ( !current_user_can( $tax->cap->assign_terms ) ) {
			return;
		}

		$terms = get_terms( 'author_groups', array( 'hide_empty' => false ) );

		?>

		<h3><?php _e( 'Author Group' ); ?></h3>
		<table class="form-table">
			<tr>
				<th>
					<label for="author_groups"><?php _e('Select Author Group') ?></label>
				</th>
				<td>
					<?php if (!empty($terms)) :  foreach ($terms as $term) : ?>
						<input
							type="radio"
							name="author_groups"
							id="author-groups-<?= esc_attr($term->slug) ?>"
							value="<?= esc_attr($term->slug) ?>"
							<?php checked( true, is_object_in_term( $user->ID, 'author_groups', $term )) ?>
						/>
						<label for="author-groups-<?= esc_attr($term->slug) ?>"><?= $term->name ?></label><br>
					<?php endforeach; else:
						_e('There are no author groups available');
					endif; ?>
				</td>
			</tr>
		</table>

		<?php
	}

	public function save_author_group_terms( $user_id ) {
		$tax = get_taxonomy('author_groups');

		if ( !current_user_can('edit_user', $user_id) && !current_user_can( $tax->cap->assign_terms ) ) {
			return false;
		}

		$term = esc_attr( $_POST['author_groups'] );

		wp_set_object_terms( $user_id, array($term), 'author_groups', false);

		clean_object_term_cache($user_id, 'author_groups');
	}


	public function on_submenu_set_user_submenu_active( $submenu_file ) {
		global $parent_file;
		if( 'edit-tags.php?taxonomy=' . 'author_groups' == $submenu_file ) {
			$parent_file = 'users.php';
		}
		return $submenu_file;
	}
}

function author_group_update_count ( $terms, $taxonomy ) {
	global $wpdb;

	foreach ( (array) $terms as $term ) {

		$count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->term_relationships WHERE term_taxonomy_id = %d", $term ) );

		do_action( 'edit_term_taxonomy', $term, $taxonomy );
		$wpdb->update( $wpdb->term_taxonomy, compact( 'count' ), array( 'term_taxonomy_id' => $term ) );
		do_action( 'edited_term_taxonomy', $term, $taxonomy );
	}
}
