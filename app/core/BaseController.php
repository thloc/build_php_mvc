<?php
	/**
	 * BaseController
	 */
	namespace app\core;
	use \App;

	class BaseController {
		private $layout = null;
		
		function __construct() {
			$this->layout = App::getConfig()['layout'];
		}

		private function setLayout($layout) {
			$this->layout = $layout;
		}

		public function redirect($url, $isEnd = true, $responseCode = 302) {
			header('Location:' . $url, true, $responseCode);
			if ($isEnd)
				die;
		}

		public function render($view, $data = null) {
			$controller = App::getController();
			$fileView = str_replace('Controller', 'View', $controller);

			if ($fileView !== $view) {
				die('Check view filename');
			}

			$rootDir = App::getConfig()['rootDir'];
			$module = App::getModule();
			$viewPath = $rootDir.'/app/module/'.$module.'/'.$fileView.'.php';

			if (file_exists($viewPath)) {
				require($viewPath);
			}
		}

		public function renderPartial() {

		}
	}
?>