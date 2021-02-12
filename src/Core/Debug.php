<?php


namespace WOF\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Utility class for debugging errors
 * @package WOF\Core
 */
class Debug {

    /**
     * A debug tool for rendering a var to the browser with a message header
     *
     * Uses print_r under the hood
     *
     * @param $var mixed Any var to print to the browser
     * @param string|null $message Optional message to appear before the var in red bold text.
     */
    public static function printVar ($var, string $message = null) {
        if (isset($message)) {
            echo '<p style="color:#ff0000; font-weight: bold;">' . $message . '</p>';
        }

        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }

    public static function show_queued_sripts() {
	    if (!is_admin()) {
		    add_action( 'wp_print_scripts', array(__CLASS__, 'inspect_scripts') );
	    }
    }

	public static function inspect_scripts() {
		global $wp_scripts;
		Debug::printVar($wp_scripts->queue, 'Scripts');
	}

    public static function show_queued_styles() {
	    if (!is_admin()) {
		    add_action( 'wp_print_styles', array(__CLASS__, 'inspect_styles') );
	    }
    }

	public static function inspect_styles() {
		global $wp_styles;
		Debug::printVar($wp_styles->queue, 'Style');
	}

    public static function show_hook_contents(string $hook) {
	    global $wp_filter;

	    if (isset($wp_filter[$hook])) {
		    Debug::printVar($wp_filter[$hook], 'HOOK: ' . $hook);
	    }
    }

}
