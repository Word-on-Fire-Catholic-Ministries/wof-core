<?php
/**
 * Word on Fire Core
 *
 * @package           WOF\Core
 * @author            Sean Davis
 * @copyright         2020 Word on Fire
 * @license           Proprietary
 *
 * @wordpress-plugin
 * Plugin Name:       Word on Fire Core
 * Plugin URI:        https://github.com/Word-on-Fire-Catholic-Ministries/wof-core
 * Description:       A collection of libraries, tools, and shared functionality across WOF WordPress sites.
 * Version:           1.0.0
 * Requires at least: 5.5
 * Requires PHP:      7.3
 * Author:            Sean Davis
 * Author URI:        https://github.com/Word-on-Fire-Catholic-Ministries/
 * Text Domain:       wof-core
 * License:           None
 */

namespace WOF;

use WOF\Tools\WpCli;

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/vendor/autoload.php';

global $algolia;

$algolia = \Algolia\AlgoliaSearch\SearchClient::create(ALGOLIA_APP_ID, ALGOLIA_API_KEY);

$wp_cli = new WpCli();
$wp_cli->init();