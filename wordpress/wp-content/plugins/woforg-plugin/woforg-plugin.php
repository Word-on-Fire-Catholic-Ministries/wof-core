<?php
/**
 * Word on Fire Plugin
 *
 * @package           WOF\Org
 * @author            Sean Davis
 * @copyright         2020 Word on Fire
 * @license           Proprietary
 *
 * @wordpress-plugin
 * Plugin Name:       Word on Fire Org Plugin
 * Plugin URI:        https://github.com/Word-on-Fire-Catholic-Ministries/woforg-plugin
 * Description:       A plugin for backend functionality on wordonfire.org
 * Version:           1.0.0
 * Requires at least: 5.5
 * Requires PHP:      7.3
 * Author:            Sean Davis
 * Author URI:        https://github.com/Word-on-Fire-Catholic-Ministries/
 * Text Domain:       wof-core
 * License:           None
 */

namespace WOF\Org;

use WOF\Search\AlgoliaCommand;
use WOF\Search\Index;
use WOF\Search\Indices;
use WOF\Search\Indexers\PostIndexer;
use WOF\Tools\Environment;
use WOF\Tools\WpCli;

defined( 'ABSPATH' ) || exit;

require_once( WOF_SITE_ROOT . '/vendor/autoload.php');

function woforg_setup_search () {
	$env = new Environment();
	$version = $env->setEnv('1.0.0');
	define('WOFORG_PLUGIN_VERSION', $version);

	$indices = new Indices(ALGOLIA_APP_ID, ALGOLIA_API_KEY);
	$client = $indices->getClient();
	$contentIndex = new Index('content', ALGOLIA_INDEX_CONTENT, $client, 'woforg');
	$contentIndex->addIndexer(new PostIndexer());
	$indices->addIndex($contentIndex);

	//test

	$wpcli = new WpCli();
	$algoliaCommand = new AlgoliaCommand($indices);
	$wpcli->registerCommand('algolia', $algoliaCommand);
	$wpcli->addCommands();
}

add_action('plugins_loaded', 'WOF\Org\woforg_setup_search');
