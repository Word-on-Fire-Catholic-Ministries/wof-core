<?php
/**
 * Main header file for the Word on Fire Theme
 */

use WOF\Org\Theme\Tags;

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >

    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php if ( get_field('do_not_index') ) : ?>
        <meta name="robots" content="noindex">
    <?php endif ?>

    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<?php
wp_body_open();
?>

<?php
// Get a menu array and print the items manually
// $menu_locations = get_nav_menu_locations();
// $primary_nav_items = wp_get_nav_menu_items( $menu_locations['primary-nav']);

?>
<?= get_search_form() ?>
<header class="primary-header">
    <div class="header__bar">
        <a class="header__logo" href="<?= home_url(); ?>">
            <?= wp_get_attachment_image(344, 'large'); ?>
        </a>
        <button id="searchbar-open-btn" class="header__search-btn">
            <?php Tags::print_search_icon_svg(); ?>
        </button>
        <div class="header__open-btn slide-menu__open">
            <div class="header__open-btn-bar btn-bar-top"></div>
            <div class="header__open-btn-bar btn-bar-middle"></div>
            <div class="header__open-btn-bar btn-bar-bottom"></div>
        </div>
    </div>
    <nav class="primary-nav">
        <?php
        wp_nav_menu( array(
            'menu' => 'primary-nav',
            'menu_class' => 'top-menu-list',
            'container_class' => 'top-menu slide-menu',
            'depth' => 1
        ) );
        ?>

        <?php
        wp_nav_menu( array(
            'menu' => 'primary-nav',
            'menu_class' => 'sub-menus-list',
            'container_class' => 'sub-menus'
        ) );

        ?>
    </nav>
</header>
