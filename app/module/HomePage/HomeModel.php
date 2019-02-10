<?php
namespace app\module\HomePage;

use app\core\BaseModel;

class HomeModel extends BaseModel {
	function __construct() {
		parent::__construct();
	}

	public function getInfor() {
		// $user = BaseModel::table('user')->distinct()->select('id', 'user_name')->get();
		$num01 = 10;
		return $num01;
	}
}

?>