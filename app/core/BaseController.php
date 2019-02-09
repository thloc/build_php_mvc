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
			$rootDir = App::getConfig()['rootDir'];
			$content = $this->getViewContent($view, $data);

			if ($this->layout !== null) {
				$layoutPath = $rootDir.'/app/module/'.$this->layout.'.php';

				if (file_exists($layoutPath)) {
					require($layoutPath);
				}
			}
		}

		public function renderPartial() {

		}

		public function getViewContent($view, $data) {
			$controller = App::getController();
			$fileView = str_replace('Controller', 'View', $controller);
			$rootDir = App::getConfig()['rootDir'];
			$module = App::getModule();

			if ($fileView !== $view) {
				die('Check view filename');
			}

			if (is_array($data)) {
				extract($data, EXTR_PREFIX_SAME, 'data');
			} else {
				$data = $data;
			}

			$viewPath = $rootDir.'/app/module/'.$module.'/'.$fileView.'.php';

			if (file_exists($viewPath)) {
				ob_start();
				require($viewPath);
				return ob_get_clean();
			}
		}
	}
?>