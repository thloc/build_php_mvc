<?php
/**
 * DBConnect
 */
namespace app\core;

use PDO;
use app\core\Registry;

class DBConnect {
	private $_numRow;
	protected $conn=null;
	
	function __construct() {
		$this->connect(Registry::getIntance()->config['database']);
	}

	public function connect($config) {
       $driver="mysql:host=".$config['host']."; dbname=". $config['dbname'];
		try {
			$this->conn = new PDO($driver, $config['username'], $config['password']);
			$this->conn->query("set names '{$config['charset']}'");
		} catch(PDOException $e) {
			echo "Err:". $e->getMessage();	exit();
		}
    }

    public function selectQuery($sql) {
		$stm=$this->conn->prepare($sql);
		$rs = $stm->execute();
		if (!$rs) {
			echo "General Error SQL ERROR You have an error in your SQL syntax.<br/>" . $sql;
		}
		$this->_numRow = $stm->rowCount();
		return $stm->fetchAll(PDO::FETCH_ASSOC);
	}

    public function __destruct() {
		$this->conn=null;
	}
}
?>
