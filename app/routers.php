<?php
	Router::get('/',function() {
		echo 'hello';
	});

	Router::get('/home', 'HomeController@index');

	Router::get('*',function() {
		echo '404 page';
	});
?>