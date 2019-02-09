<?php 
	namespace app\module\HomePage;
	use app\core\BaseController;
	use \App;

	/**
	 * HomePage
	 */
	class HomeController extends BaseController {
		
		function __construct() {
			// emty;
		}

		// public function index($a, $b) {
		// 	echo $a;
		// 	echo $b;
		// }
	
		public function index() {
			$this->render('HomeView');
			// $this->redirect('http://google.com');
			// print_r(App::getAction());
		}
	}

?>