<?php


namespace WOF\Core;

defined( 'ABSPATH' ) || exit;

/**
 * A static registry to store and get components at runtime.
 * @package WOF\Core
 */
class Registry {
    /**
     * The modules array stores a list of modules that the manager can use to perform bulk operaitons
     *
     * @since    1.0.0
     * @access   protected
     * @var      array    $components  Maintains an array of modules to perform mass operations
     */
    private static array $components = array();

	/**
	 * Get a component by class name
	 *
	 * @param string $key The name of the class without the .php
	 *
	 * @return Component The registered instance if found
	 */
    public static function getComponent (string $key) : Component {
        return self::$components[$key];
    }

    /**
     * Registers an array of components by their class name.
     *
     * @param array $components An array of component objects
     */
    public static function registerComponents(array $components)  {
        foreach ($components as $component) {
            self::$components[get_class($component)] = $component;
        }
    }
}
