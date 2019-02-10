<?php 
/**
 * HomePage
 */
namespace app\module\HomePage;

use app\core\BaseController;
use \App;
use app\module\HomePage;

class HomeController extends BaseController {
	function __construct() {
		parent::__construct();
	}

	public function index() {
		$num01 = HomeModel::getInfor();
		$this->render('HomeView', ['num01' => $num01, 'num02' => 2]);
	}
}
?>
