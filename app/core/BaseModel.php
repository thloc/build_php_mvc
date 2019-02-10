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

	public function insertDB(array $params) {
		if (empty($params)) {
			return false;
		}

        if (! is_array(reset($params))) {
            $params = [$params];
        } else {
            foreach ($params as $key => $value) {
                ksort($value);
                $params[$key] = $value;
            }
        }

        $sql = $this->compileInsert($params);

		echo "<pre>";
		print_r($sql);
		die;
	}


	public function compileInsert(array $values) {
	    if (! is_array(reset($values))) {
	        $values = [$values];
	    }

	    $columns = $this->columnize(array_keys(reset($values)));
	    $parameters = $this->parameterize($values);
	    return "INSERT INTO $this->from ($columns) values $parameters";
	}

	public function columnize(array $columns) {
        return implode(', ', $columns);
    }

    public function parameterize(array $values) {
    	$dataInsert = '';
    	$countValues = count($values);

    	foreach ($values as $keyRecord => $record) {
    		$data = array_values($record);
    		$dataInsert .= '(';
    		$countData = count($data);
    		foreach ($data as $key => $value) {
    			if (is_string($value)) {
    				$dataInsert .= '"'.$value.'"';
    			} else {
    				$dataInsert .= $value;
    			}

    			if ($key < $countData - 1) {
    				$dataInsert .= ', ';
    			}
    		}
    		$dataInsert .= ')';

    		if ($keyRecord < $countValues - 1) {
    			$dataInsert .= ', ';
    		}
    	}
    	return $dataInsert;
    }
}
?>
