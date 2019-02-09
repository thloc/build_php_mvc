<?php
	/**
	 * Router
	 */
	use app\core\Registry;

	class Router {
		private static $router = [];
		private $basePath;

		function __construct($basePath) {
			$this->basePath = $basePath;
		}

		private function getRequestURL() {
			$url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
			$url = str_replace($this->basePath, '', $url);
			$url = $url === '' || empty($url) ? '/' : $url;
			return $url;  
		}

		private function getRequestMethod() {
			$method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
			return $method;
		}

		private static function addRouter($method, $url, $action, $module) {
			self::$router[] = [$method, $url, $action, $module];
		}

		public static function get($url, $action, $module = null) {
			self::addRouter('GET', $url, $action, $module);
		}

		public static function post($url, $action, $module = null) {
			self::addRouter('POST', $url, $action, $module);
		}

		public static function any($url, $action, $module = null) {
			self::addRouter('GET|POST', $url, $action, $module);
		}

		public function map() {
			$params = [];
			$checkRoute = false;
			$requestURL = $this->getRequestURL();
			$requestMethod = $this->getRequestMethod();
			$routers = self::$router;

			foreach ($routers as $route) {
				list($method, $url, $action, $module) = $route;

				if (strpos($method, $requestMethod) === FALSE) {
					continue;
				}

				if ($url === '*') {
					$checkRoute = true;
				} elseif (strpos($url, ':') === FALSE) {
					if (strcmp(strtolower($url), strtolower($requestURL)) === 0) {
						$checkRoute = true;
					} else {
						continue;
					}
				} else {
					$routeParams = explode('/', $url);
					$requestParams = explode('/', $requestURL);
					if (count($routeParams) !== count($requestParams)) {
						continue;
					}
					foreach ($routeParams as $k => $rp) {
						if (preg_match('/^:\w+$/', $rp)) {
							$params[] = $requestParams[$k];
						}
					}
					$checkRoute = true;
				}

				if ($checkRoute === true) {
					if (is_callable($action)) {
						call_user_func_array($action, $params);
					} elseif (is_string($action)) {
						$this->compieRoute($action, $params, $module);
					}
					return;
				}
			}
			return;
		}

		private function compieRoute($action, $params, $module) {
			$data = explode('@', $action);

			if (count($data) !== 2) {
				die('Router error');
			}

			$className = $data[0];
			$methodName = $data[1];
			$classNamespace = 'app\\module\\'.$module.'\\'.$className;

			if (class_exists($classNamespace) && method_exists($classNamespace, $methodName)) {
				$object = new $classNamespace;			
				Registry::getIntance()->controller = $className; 
				Registry::getIntance()->action = $methodName;
				Registry::getIntance()->module = $module;
				call_user_func_array([$object, $methodName], $params);
			} else {
				die('Class <strong>'.$classNamespace.'</strong> or Method <strong>'.$methodName.'()</strong> not found');
			}
		}

		public function run() {
			$this->map();
		}
	}
?>
