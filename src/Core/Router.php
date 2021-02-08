<?php
namespace WOF\Core;


defined( 'ABSPATH' ) || exit;

/**
 * A component that can hold routes which route an endpoint to a specific callback function
 * @package WOF\Core
 */
class Router extends Component {
    /**
     * @var array A collection of stored routes
     */
    private array $routes;


	/**
	 * @var array string array of WP hooks for when to automatically flush the rewrites. Usually when the plugin or theme is deactivated.
	 */
	private array $flushRewriteHooks;

	/**
	 * Create the router component
	 *
	 * @param Hooks $hooks The WP hooks dependency
	 * @param array $flushRewriteHooks Array of strings of WP hooks when flush rewrite should run.
	 */
    public function __construct(Hooks $hooks, array $flushRewriteHooks) {
        parent::__construct($hooks);
        $this->routes = array();
	    $this->flushRewriteHooks = $flushRewriteHooks;
    }

    /**
     * Add a route to the router
     *
     * @param string $endpoint A string representing the endpoint that triggers the route
     * @param string $queryVar A query var to add to WP. Will not add duplicate query vars
     * @param string $param A parameter the query var matches to trigger the route. Ensure this is unique!
     * @param callable $callback A callback that can be triggered with call_user_func
     */
    public function addRoute (string $endpoint, string $queryVar, string $param, callable $callback) {
        $this->routes[$endpoint] =  [
            'endpoint' => $endpoint,
            'queryVar' => $queryVar,
            'param' => $param,
            'callback' => $callback
        ];
    }

    /**
     * Flush the rewrites on key hooks
     */
    public function flushRewrites() {
        flush_rewrite_rules();
    }


    /**
     * Add rewrite for the custom endpoint to rewrite as a custom query var parameter
     */
    public function addRewrites () {
        foreach ($this->routes as $route) {
            add_rewrite_rule($route['endpoint'], 'index.php?' . $route['queryVar'] . '=' . $route['param'], 'top');
        }
    }

    /**
     * Adds the query vars during the WP query_vars filter
     *
     * @param $vars array Query var array passed in by WP
     * @return array The same array with the uery vars
     */
    public function addQueryVars ($vars) {
        foreach ($this->routes as $route) {
            if (!in_array($route['queryVar'], $vars)) {
                $vars[] = $route['queryVar'];
            }
        }
        return $vars;
    }

    /**
     * Match any routes to if any of the registered route query vars match and call the callback.
     * Exits after the callback completes.
     */
    public function matchRoutes () {
        foreach ($this->routes as $route) {
            if (strcasecmp(get_query_var($route['queryVar']),$route['param']) === 0) {
                call_user_func($route['callback']);
            }
        }
    }

    /**
     * Adds the add rewrites to the activation hook and flush rewrites to all key hooks
     * Also adds the rewrites to init, adds the query vars, and template_redirects
     *
     * @param Hooks $hooks Hooks to register with WP
     */
    protected function defineHooks(Hooks $hooks) {
        $hooks->add_action('init', $this, 'addRewrites', 11);

        foreach ($this->flushRewriteHooks as $hook) {
	        $hooks->add_action($hook, $this, 'flushRewrites', 12);
        }

        $hooks->add_action('init', $this, 'addRewrites');
        $hooks->add_filter('query_vars', $this, 'addQueryVars');
        $hooks->add_filter('template_redirect', $this, 'matchRoutes',0);
    }
}
