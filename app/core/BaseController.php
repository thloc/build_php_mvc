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

		public function renderPartial($view , $data = null) {
			$rootDir = App::getConfig()['rootDir'];

			if (is_array($data)) {
				extract($data, EXTR_PREFIX_SAME, 'data');
			} else {
				$data = $data;
			}

			$viewPath = $rootDir.'/app/module/'.$view.'.php';
			if (file_exists($viewPath)) {
				require($viewPath);
			}
		}

		public function getViewContent($view, $data) {
			$controller = App::getController();
			$fileView = str_replace('Controller', 'View', $controller);
			$rootDir = App::getConfig()['rootDir'];
			$module = App::getModule();

			if (is_array($data)) {
				extract($data, EXTR_PREFIX_SAME, 'data');
			} else {
				$data = $data;
			}

			if ($module) {
				$viewPath = $rootDir.'/app/module/'.$module.'/'.$fileView.'.php';
			} else {
				$viewPath = $rootDir.'/app/module/layout/'.$view.'.php';
			}

			if (file_exists($viewPath)) {
				ob_start();
				require($viewPath);
				return ob_get_clean();
			}
		}
	}
?>