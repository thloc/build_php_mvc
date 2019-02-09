<?php
	/**
	 * Router
	 */
	class Router {

		private static $router = [];
		private $basePath;

		function __construct($basePath) {
			$this->basePath = $basePath;
		}

		private function getRequestURL() {
			$basePath = \App::getConfig()['basePath'];

			$url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
			$url = str_replace($this->basePath, '', $url);

			$url = $url === '' || empty($url) ? '/' : $url;
			return $url;  
		}

		private function getRequestMethod() {
			$method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
			return $method;
		}

		private static function addRouter($method, $url, $action) {
			self::$router[] = [$method, $url, $action];
		}

		public static function get($url, $action) {
			self::addRouter('GET', $url, $action);
		}

		public static function post($url, $action) {
			self::addRouter('POST', $url, $action);
		}

		public static function any($url, $action) {
			self::addRouter('GET|POST', $url, $action);
		}

		public function map() {
			$checkRoute = false;
			$params = [];
			$requestURL = $this->getRequestURL();
			$requestMethod = $this->getRequestMethod();

			$routers = self::$router;

			foreach ($routers as $route) {
				list($method, $url, $action) = $route;

				if (strpos($method, $requestMethod) === FALSE) {
					continue;
				}

				if ($url === '*') {
					$checkRoute = true;
				} elseif(strpos($url, ':') === FALSE) {
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
						$this->compieRoute($action, $params);
					}
					return;
				}
			}

			return;
		}

		private function compieRoute($action, $params) {
			$data = explode('@', $action);

			if (count($data) !== 2) {
				die('Router error');
			}

			$className = $data[0];
			$methodName = $data[1];

			$classNamespace = 'app\\HomePage\\'.$className;

			if (class_exists($classNamespace) && method_exists($classNamespace, $methodName)) {
				$object = new $classNamespace;
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
