<?php


namespace WOF\Org\Theme;


class BlockRegistrar {

	/**
	 * @var string The theme text domain
	 */
	private $textDomain;

	/**
	 * NavMenus constructor.
	 *
	 * @param string $textDomain The localization text domain to use
	 */
	public function __construct(string $textDomain) {
		$this->textDomain = $textDomain;
	}

	public function registerHooks() {
		add_filter( 'block_categories', array($this, 'addBlockCategories'), 5, 2 );
		add_action('acf/init', array($this, 'registerAcfBlocks'));
		add_filter( 'block_editor_settings' , array($this, 'removeEditorStyles') );
	}

	public function removeEditorStyles( $settings ) {
		unset($settings['styles'][0]);

		return $settings;
	}

	public function addBlockCategories( $categories ) {
		$category_slugs = wp_list_pluck( $categories, 'slug' );
		return in_array( 'wof-blocks', $category_slugs, true ) ? $categories : array_merge(
			$categories,
			array(
				array(
					'slug'  => 'wof-blocks',
					'title' => __( 'Word on Fire', $this->textDomain ),
					'icon'  => 'bank',
				),
			)
		);
	}

	public function registerAcfBlocks () {
		// Register the category block
		acf_register_block_type(array(
			'name' => 'category-block',
			'title' => 'Category Block',
			'description' => 'A content block that shows the most recent post from a category.',
			'category' => 'wof-blocks',
			'render_template' => 'template-parts/blocks/category-block.php',
			'enqueue_style'     => get_template_directory_uri() . '/dist/css/blocks/content-block.css?' . WOFORG_THEME_VERSION,
			'icon' => 'category',
			'supports'		=> [
				'anchor'		=> true,
				'customClassName'	=> true
			]
		));

		// Register the category block
		acf_register_block_type(array(
			'name' => 'grid-block',
			'title' => 'Grid Block',
			'description' => 'A block that displays all inner blocks in a responsive grid.',
			'category' => 'wof-blocks',
			'render_template' => 'template-parts/blocks/grid-block.php',
			'enqueue_style'     => get_template_directory_uri() . '/dist/css/blocks/grid-block.css?' . WOFORG_THEME_VERSION,
			'icon' => 'grid-view',
			'supports'		=> [
				'anchor'		=> true,
				'customClassName'	=> true,
				'jsx' 			=> true,
			]
		));

		// Register the design system
		acf_register_block_type(array(
			'name' => 'design-system',
			'title' => 'Design System',
			'description' => 'A block for designers to perfect the CSS values.',
			'category' => 'wof-blocks',
			'render_template' => 'template-parts/blocks/design-system.php',
			'enqueue_style'     => get_template_directory_uri() . '/dist/css/blocks/design-system.css?' . WOFORG_THEME_VERSION,
			'icon' => 'admin-customizer',
			'supports'		=> [
				'anchor'		=> true,
				'customClassName'	=> true,
				'jsx' 			=> true,
			]
		));

		// Register the Latest Content block
		acf_register_block_type(array(
			'name' => 'latest-content',
			'title' => 'Latest Content',
			'description' => 'Displays the latest content from WOF by category.',
			'category' => 'wof-blocks',
			'render_template' => 'template-parts/blocks/latest-content.php',
			'enqueue_style'     => get_template_directory_uri() . '/dist/css/blocks/latest-content.css?' . WOFORG_THEME_VERSION,
			'enqueue_script' => get_template_directory_uri() . '/dist/js/latest-content.min.js?' . WOFORG_THEME_VERSION,
			'icon' => 'admin-customizer',
			'mode' => 'auto',
			'supports'		=> [
				'anchor'		=> true,
				'customClassName'	=> true
			]
		));

		// Register the category block
		acf_register_block_type(array(
			'name' => 'about-wof',
			'title' => 'About Word on Fire',
			'description' => 'Summary of Bishop Barron, Word on Fire, and the latest.',
			'category' => 'wof-blocks',
			'render_template' => 'template-parts/blocks/about-wof.php',
			'enqueue_style'     => get_template_directory_uri() . '/dist/css/blocks/about-wof.css?' . WOFORG_THEME_VERSION,
			'icon' => 'category',
			'supports'		=> [
				'anchor'		=> true,
				'customClassName'	=> true
			]
		));
	}

}