<?php

use WOF\Org\Theme\CustomPostTypes;
use WOF\Org\Theme\Taxonomy;
use WOF\Org\Theme\Views\Searchbar;
use WOF\Tools\Environment;
use WOF\Org\Theme\Assets;
use WOF\Org\Theme\BlockRegistrar;
use WOF\Org\Theme\NavMenus;
use WOF\Org\Theme\ThemeSupports;
use WOF\Org\Theme\WpFilterOverrides;
use WOF\Org\Theme\Categories;

// Boot the PS-4 Autoloader from Composer
require_once( WOF_SITE_ROOT . '/vendor/autoload.php');

@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '65M');
@ini_set( 'max_execution_time', '300' );
@ini_set( 'memory_limit', '512M' );

// Declare constants
$wpTheme = wp_get_theme();
define('WOFORG_THEME_TXT_DOMAIN', $wpTheme->get( 'TextDomain' ));
define('WOFORG_THEME_DIR', __DIR__);
define('WOFORG_THEME_URI', get_stylesheet_directory_uri()); // No trailing slash

// Dev mode enables debugging and busts caches
$env = new Environment();
$version = $env->setEnv($wpTheme->get( 'Version' ));
define('WOFORG_THEME_VERSION', $version);


// Define the theme setup
function wofSetupTheme () {

	$cpts = new CustomPostTypes();
	$cpts->registerHooks();

    // Setup Theme Supports
    $supports = new ThemeSupports();
    $supports->registerHooks();

    // Setup Nav Menus
    $navs = new NavMenus(WOFORG_THEME_TXT_DOMAIN);
    $navs->registerHooks();

    // Setup Assets
    $assets = new Assets(WOFORG_THEME_URI . '/dist', WOFORG_THEME_VERSION);
    $assets->registerHooks();

    // Blocks
    $blocks = new BlockRegistrar(WOFORG_THEME_TXT_DOMAIN);
    $blocks->registerHooks();

    $tax = new Taxonomy();
    $tax->register_hooks();

    $filters = new WpFilterOverrides();
    $filters->registerFilters();

    $searchbar = new Searchbar();
    $searchbar->registerHooks();

    $cats = new Categories();
    $cats->build_category_hierarchy();
    $cats->turn_category_list_to_json();
}

// Execute the Theme Setup
wofSetupTheme();
