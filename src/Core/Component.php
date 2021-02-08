<?php
/**
 * This provides the basic interface for a WOF module.
 *
 * @since      1.0.0
 */
namespace WOF\Core;

defined( 'ABSPATH' ) || exit;

/**
 * Base class for defining basic behaviours that are tied to WordPress hooks
 * @package WOF\Plugin\Core
 */
abstract class Component {
    /**
     * @var
     */
    protected Hooks $hooks;

    /**
     * Construct a component with the supplied dependency hooks
     *
     * @param Hooks $hooks A hook dependency object fot the component
     */
    protected function __construct(Hooks $hooks) {
        $this->hooks = $hooks;
        $this->defineHooks($hooks);
    }

    /**
     * Function to define which hooks the component will need. Executes before the hooks are registered on each request.
     *
     * @param Hooks $hooks The injected dependencies
     */
    protected abstract function defineHooks (Hooks $hooks);
}
