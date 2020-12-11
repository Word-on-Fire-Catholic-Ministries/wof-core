<?php


namespace WOF\Tools;

defined( 'ABSPATH' ) || exit;


class WpCli {

	public function init () {
		add_action('cli_init', array( $this,  ));
	}

	public function registerCommands () {
		\WP_CLI::add_command('algolia', '\WOF\Search\AlgoliaCommand');
	}

}