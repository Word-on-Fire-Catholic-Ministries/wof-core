<?php


namespace WOF\Tools;


class Environment {

	protected $version;

	public function setEnv (string  $assetVersion) : string {

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
		return $this->getAssetVersion();
	}

	public function getAssetVersion () : string {
		if (isset($this->version)) {
			return $this->version;
		}
		return time();
	}

	protected function setDevelopmentEnv () {
		$this->version = time();
	}

	protected function setStagingEnv () {
		$this->setDevelopmentEnv();
	}

	protected function setProductionEnv ($assetVersion) {
		$this->version = $assetVersion;
	}

}