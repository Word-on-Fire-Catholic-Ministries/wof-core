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

}
