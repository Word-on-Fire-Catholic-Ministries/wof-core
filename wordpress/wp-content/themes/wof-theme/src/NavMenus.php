<?php


namespace WOF\Org\Theme;

defined( 'ABSPATH' ) || exit;

/**
 * Class NavMenus
 * @package WOF
 */
class NavMenus {

    /**
     * @var string The theme text domain
     */
    private $textDomain;

    /**
     * NavMenus constructor.
     * @param string $textDomain The localization text domain to use
     */
    public function __construct(string $textDomain) {
        $this->textDomain = $textDomain;
    }

    /**
     * Register the menu with the after_setup_theme hook
     */
    public function registerHooks() {
        add_action('after_setup_theme', array($this, 'registerMenus'));
    }

    /**
     * Function for the WP Hook to call to register the nav menu
     */
    public function registerMenus () {
        register_nav_menu('primary-nav', __('Primary Navigation', $this->textDomain));
    }
}