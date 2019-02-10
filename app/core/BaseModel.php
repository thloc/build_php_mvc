<?php
/**
 * BaseModel
 */
namespace app\core;

use app\core\DBConnect;

class BaseModel extends DBConnect {
	private $columns;
	private $from;
	private $distinct = false;
	private $query;

	public function __construct($tableName)	{
		parent::__construct();
		$this->from = $tableName;
	}

	public static function table($tableName) {
		return new self($tableName);
	}

	public function select($columns) {
		$this->columns = is_array($columns) ? $columns : func_get_args();
		return $this;
	}

	public function distinct() {
		$this->distinct = true;
		return $this;
	}

	public function sqlQuery($sqlQuery) {
		$this->query = $sqlQuery;
		return $this;
	}

	public function get() {
		if (!isset($this->from) || empty($this->from)) {
			return false;
		}
		$sql = $this->distinct ? 'SELECT DISTINCT ' : 'SELECT ';

		if (isset($this->columns) || is_array($this->columns)) {
			$sql .= implode(',', $this->columns);
		} else {
			$sql = '*';
		}

		$sql .= ' FROM '. $this->from .' '. $this->query;
		return $this->selectQuery($sql);
	}
}
?>
