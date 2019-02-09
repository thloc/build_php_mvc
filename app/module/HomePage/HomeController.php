<?php 
	/**
	 * HomePage
	 */
	namespace app\module\HomePage;

	use app\core\BaseController;
	use \App;

	class HomeController extends BaseController {
		function __construct() {
			parent::__construct();
		}
	
		public function index() {
			$this->render('HomeView', ['num01' => 1, 'num02' => 2]);
		}
	}

?>