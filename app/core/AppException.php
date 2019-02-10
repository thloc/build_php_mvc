<?php
/**
 * AppException
 */
namespace app\core;

use \Exception;

class AppException extends Exception {
	public function __construct($message, $code = null) {
		if ( error_reporting() == 0 ) {
			return false;
		}

		set_exception_handler([$this, 'errorHandle']);
		parent::__construct($message, $code);
	}

	public function errorHandle($e) {
		echo "<pre>";
		print_r($e);
	}
}
?>
