<?php


namespace WOF\Tools;

defined( 'ABSPATH' ) || exit;

class WpCli {

	public function init () {
		add_action('cli_init', array( $this, 'registerCommands' ));
	}

	public function registerCommands () {
		if (!(defined('WP_CLI') && WP_CLI)) {
			return;
		}

		\WP_CLI::add_command('algolia', '\WOF\Search\Algolia\AlgoliaCommand');
	}

}