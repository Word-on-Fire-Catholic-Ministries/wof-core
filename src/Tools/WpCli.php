<?php


namespace WOF\Tools;

defined( 'ABSPATH' ) || exit;

class WpCli {

	private $commandRegistry;

	public function __construct() {
		$this->commandRegistry = array();
		add_action('cli_init', array( $this, 'on_cli_init' ));
	}

	public function on_cli_init () {
		if (!(defined('WP_CLI') && WP_CLI)) {
			return;
		}

		foreach ($this->commandRegistry as $command) {
			\WP_CLI::add_command($command['command'], $command['path']);
		}
	}

	public function registerCommand ($command, $path) {
		$this->commandRegistry[] = array('command' => $command, 'path' => $path);
	}

}