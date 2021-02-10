<?php


namespace WOF\Org\Theme;

defined( 'ABSPATH' ) || exit;


/**
 * Class ThemeSupports
 *
 * Manages the turning on and off of WordPress theme supports. Encapsulates logic related to theme supports.
 *
 * @package WOF
 */
class ThemeSupports {

    /**
     * Register the theme setups with after_setup_theme
     */
    public function registerHooks() {
        add_action('after_setup_theme', array($this, 'enableSupports'));
    }

    /**
     * Function for the WP hook to call to enable the supports.
     */
    public function enableSupports () {
        $this->addThumbnailSupport(1920, 9999);
        $this->addTitleSupport();
        $this->addHtml5Support();
        $this->addWideAlignmentSupport();
        $this->addCustomUnitSupport('rem', 'em');
	    add_theme_support( 'editor-styles' );
    }

    /**
     * Add support for post thumbnails.
     *
     * @param int $width width in pixels of the thumbnails
     * @param int $height height in pixels of the thumbnails
     */
    private function addThumbnailSupport (int $width, int $height) {
        /*
        * Enable support for Post Thumbnails on posts and pages.
        */
        add_theme_support( 'post-thumbnails' );

        // Set post thumbnail size.
        set_post_thumbnail_size( $width, $height );
    }

    /**
     * Add support for a custom logo.
     *
     * @param int $width The width in pixels of the logo
     * @param int $height The height in pixels of the logo.
     */
   public function addLogoSupport (int $width, int $height) {
       add_theme_support(
           'custom-logo',
           array(
               'height'      => $height,
               'width'       => $width,
               'flex-height' => true,
               'flex-width'  => true,
           )
       );
    }

    /**
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    public function addTitleSupport () {
        add_theme_support( 'title-tag' );
    }

    /**
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    public function addHtml5Support () {
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'script',
                'style',
            )
        );
    }

    /**
     * Add support for the wide alignment Block style
     */
    public function addWideAlignmentSupport () {
        add_theme_support( 'align-wide' );
    }

    /**
     * Add support for the Block editor to support additional units
     *
     * @param mixed ...$units Strings for the CSS unit types to support.
     */
    public function addCustomUnitSupport ( ...$units ) {
        add_theme_support( 'custom-units', $units );

    }
}