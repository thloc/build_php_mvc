<?php
/**
 * BaseController
 */
namespace app\core;

use \App;
use app\core\Registry;

class BaseController {
	private $layout = null;
	private $config;
	
	function __construct() {
		$this->config = Registry::getIntance()->config;
		$this->layout = $this->config['layout'];
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
		$rootDir = $this->config['rootDir'];
		$content = $this->getViewContent($view, $data);

		if ($this->layout !== null) {
			$layoutPath = $rootDir.'/app/module/'.$this->layout.'.php';
			if (file_exists($layoutPath)) {
				require($layoutPath);
			}
		}
	}

	public function renderPartial($view , $data = null) {
		$rootDir = $this->config['rootDir'];

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
		$controller = Registry::getIntance()->controller;
		$fileView = str_replace('Controller', 'View', $controller);
		$rootDir = $this->config['rootDir'];
		$module = Registry::getIntance()->module;

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