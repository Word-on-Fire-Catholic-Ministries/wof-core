<?php
//define('WP_PLUGIN_DIR', '/home/justin/otherdev/wof-core');
//define('WP_DEVELOP_DIR', 'home/justin/otherdev/wof-core/wordpress/tests/phpunit/includes/bootstrap.php');
//require '/home/justin/otherdev/wof-core/wordpress-develop/tests/phpunit/includes/bootstrap.php';

if ( false !== getenv( 'WP_PLUGIN_DIR' ) ) {
define( 'WP_PLUGIN_DIR', getenv( 'WP_PLUGIN_DIR' ) );
}

if ( false !== getenv( 'WP_DEVELOP_DIR' ) ) {
require getenv( 'WP_DEVELOP_DIR' ) . 'tests/phpunit/includes/bootstrap.php';

}

