<?php
namespace app\module\HomePage;

use app\core\BaseModel;

class HomeModel extends BaseModel {
	function __construct() {
		parent::__construct();
	}

	public function getInfor() {
		// $user = BaseModel::table('user')->distinct()->select('id', 'user_name')->sqlQuery()->get();
		
		// $user = BaseModel::table('user')
		// 	->insertDB([
		// 		['id' => 8, 'user_name' => 'john@example.com'],
		// 		['id' => 9, 'user_name' => 'john04@example.com']
		// 	]);
		
		// $user = BaseModel::table('user')->updateDB();

		$num01 = 10;
		return $num01;
	}
}

?>