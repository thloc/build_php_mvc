<?php
	Router::get('/',function() {
		echo 'hello';
	});

	Router::get('/home', 'HomeController@index', 'HomePage');

	Router::get('*',function() {
		echo '404 page';
	});
?>