<?php


namespace WOF\Tools;

use WP_CLI;

defined( 'ABSPATH' ) || exit;

class WpCli {

	private $commandRegistry;

	public function __construct() {
		$this->commandRegistry = array();
	}

	public function addCommands () {
		if (!(defined('WP_CLI') && WP_CLI)) {
			return;
		}

		foreach ($this->commandRegistry as $key => $value) {
			WP_CLI::add_command($key, $value);
		}
	}

	public function registerCommand ($command, $path) {
		$this->commandRegistry[$command] = $path;
	}

}