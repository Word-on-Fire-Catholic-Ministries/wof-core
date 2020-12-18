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

defined( 'ABSPATH' ) || exit;


define('WOF_CORE_DIR', __DIR__);
require_once WOF_CORE_DIR . '/vendor/autoload.php';
