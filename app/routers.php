<?php
	use app\core\BaseController;

	Router::get('/',function() {
		$ct = new BaseController();
		$ct->render('main');
	});

	Router::get('/home', 'HomeController@index', 'HomePage');

	Router::get('*',function() {
		echo '404 page';
	});
?>