<?php
namespace app\module\HomePage;

use app\core\BaseModel;

class HomeModel extends BaseModel {
	function __construct() {
		parent::__construct();
	}

	public function getInfor() {
		// $user = BaseModel::table('user')->distinct()->select('id', 'user_name')->get();
		
		// $user = BaseModel::table('user')
		// 	->insertDB([
		// 		['id' => 3, 'user_name' => 'john@example.com'],
		// 		['id' => 4, 'user_name' => 'john04@example.com']
		// 	]);

		$num01 = 10;
		return $num01;
	}
}

?>