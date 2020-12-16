<?php


namespace WOF\Tools;


class Environment {

	protected $version;

	public function setEnv ($assetVersion) {

		switch ( wp_get_environment_type() ) {
			case 'local':
			case 'development':
				$this->setDevelopmentEnv();
				break;

			case 'staging':
				$this->setStagingEnv();
				break;

			case 'production':
			default:
				$this->setProductionEnv($assetVersion);
				break;
		}
	}

	public function getAssetVersion () {
		if (isset($this->version)) {
			return $this->version;
		}
		return time();
	}

	protected function setDevelopmentEnv () {
		if (!defined('WP_DEBUG')) {
			define( 'WP_DEBUG', true );
		}

		if ( !defined( 'WP_DEBUG_LOG') ) {
			define( 'WP_DEBUG_LOG', true );
		}

		if (!defined( 'WP_DEBUG_DISPLAY')) {
			define( 'WP_DEBUG_DISPLAY', true );
		}

		$this->version = time();
	}

	protected function setStagingEnv () {
		$this->setDevelopmentEnv();
	}

	protected function setProductionEnv ($assetVersion) {
		$this->version = $assetVersion;
	}

}