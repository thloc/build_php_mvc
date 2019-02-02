<?php
	/**
	 * App
	 */
	
	require_once(dirname(__FILE__).'\Router.php');
	require_once(dirname(__FILE__).'\Autoload.php');

	use app\core\Router;

	class App {

		private $router;
		public static $config;

		function __construct() {
			new Autoload;
			$this->router = new Router;

			// new app\HomePage\HomeControler;

			$this->router->get('/:a/:b', 'HomeController@index');

			$this->router->get('/news/:category/:page', function($cat, $page) {
				echo $cat. "<br/>";
				echo $page. "<br/>";
			});
			
			$this->router->post('/news', function() {
				echo "NEWS";
			});

			$this->router->any('/category', function() {
				echo "category";
			});

			$this->router->any('*', function() {
				echo "404 page";
			});
		}

		public static function setConfig($config) {
			self::$config = $config;
		}

		public static function getConfig() {
			return self::$config;
		}

		public function run() {
			$this->router->run();
		}
	}
?>
