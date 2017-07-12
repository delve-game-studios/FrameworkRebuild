<?php

namespace System;

// basic methods for models
abstract class Model extends Application {
	private static $_instance;

	public $db;

	public function __construct() {
		$this->db = Application::$_db;
	}

	// returns the table name of the model
	abstract public function tableName();

	// returns the primary key of the table
	abstract public function primaryKey();

	// saves the given data from the controller thru the model to the database
	abstract public function save();

    public static function model()
    {
        $rv = new static();  
    	return $rv;
    }

	// select all records in the model's table filtered by the parameters
	protected function findAll($params = array()) {
		$params = new Parameter($params);
		$tableName = $this->tableName();

		$from = $params->from ?: array();

		$select = $params->select ?: array();

		$where = $params->where ?: array();

		$order = $params->order ?: 'ORDER BY ' . $this->primaryKey() . ' ASC';

		$pageSize = $params->pageSize ?: 'LIMIT 0, 50';

		$query = $this->createQuery($from, $select, $where, $order, $pageSize);

		$rows = $this->db->GetAll($query);

		$result = array();
		foreach($rows as $key => $data) {
			$result[$key] = array();
			foreach($data as $k => $value) {
				if(!\is_numeric($k)) $result[$key][$k] = $value;
			}
		}

		return $result;
	}

	public function createQuery($from, $select, $where = array(), $order = array(), $pageSize = false) {
		$tableName = $this->tableName();
		$tableNameAlias = $this->getTableAlias();

		$sql = '';

		$query = array('select' => "SELECT",'from' => "FROM {$tableName} AS {$tableNameAlias}",'where' => '','order' => '','pageSize' => '');

		if(!empty($select)) {
			foreach($select as $key => $value) {
				$query['select'] .= "\n{$value} AS {$key}";
			}
		} else {
			$query['select'] .= ' ' . $tableNameAlias . '.*';
		}
		
		foreach($from as $alias => $join) {
			$joint = ' ';

			$joint .= strtoupper($join['type']) . ' JOIN ' . $join['table'] . ' AS ' . $alias . "\n\t\t ON";
			
			foreach($join['filters'] as $key => $filter) {
				if($key > 0) $joint .= " AND ";
				$joint .= $filter;
			}

			$query['from'] .= $joint;
		}

		foreach ($where as $key => $value) {
			if($key > 0) $query['where'] .= ' AND ';
			$query['where'] .= '(' . $value . ')';
		}

		if($order) { $query['order'] .= 'ORDER BY ';
			if(!is_array($order)) {
				$query['order'] = $order;
			} else {
				foreach($order as $key => $value) {
					if($key > 0) $query['order'] .= ',';
					$query['order'] .= $value;
				}
			}
		}

		foreach($query as $key => $value) {
			$sql .= "{$value}\n";
		}

		return $sql;
	}

	private function getTableAlias() {
		$tableName = $this->tableName();
		$tableName = implode('_', explode(' ', ucwords(implode(' ', explode('_', $tableName)))));
		$matches = array();
		preg_match_all('/[A-Z][a-z]+/', $tableName, $matches);
		$alias = '';

		foreach($matches[0] as $match) {
			$alias .= substr($match, 0, 1);
		}

		return strtolower($alias);
	}


}

?>