<?php
	/**
	 * Registry
	 */
	namespace app\core;

	class Registry {
		private static $intance;
		private $storage;
		
		private function __construct() {
			# code...
		}

		public static function getIntance() {
			if (!isset(self::$intance))
				self::$intance = new self;
			return self::$intance;
		}

		public function __set($name, $value) {
			if (!isset($this->storage[$name]))
				$this->storage[$name] = $value;
			else
				die("Cannot set \"$value\" to \"$name");
		}

		public function __get($name) {
			if (isset($this->storage[$name]))
				return $this->storage[$name];
			return null;
		}
	}
?>
