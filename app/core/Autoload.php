<?php

	/**
	 * Autoload
	 */
	class Autoload {
		private $rootDir;
		
		function __construct($rootDir) {
			$this->rootDir = ($rootDir);
			spl_autoload_register([$this, 'autoLoad']);
			$this->autoLoadFile();
		}

		private function autoLoad($class) {
			$tmp = explode('\\', $class);
			$className = end($tmp);
			$pathName = str_replace($className,'', $class);
			$filePath = $this->rootDir.'\\'.$pathName.$className.'.php';

			if (file_exists($filePath)) {
				require_once($filePath);
			}
		}

		private function autoLoadFile() {
			foreach ($this->defaultFileLoad() as $file) {
				require_once( $this->rootDir . '/' . $file);
			}
		}

		private function defaultFileLoad() {
			return [
				'app/core/Router.php',
				'app/routers.php'
			];
		}
	}

?>
