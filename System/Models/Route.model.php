<?php

namespace Application\Models;
use \System\Model;
use \System\Connection;

class Route extends Model {

	public function tableName() {
		return 'sys_routes';
	}

	public function primaryKey() {
		return 'sr_id';
	}

	public function getCustomRoutes() {
		$rows = $this->findAll();
		$routes = array();
		foreach($rows as $row) {
			$routes[$row['route']] = array("{$row['controller']}::{$row['action']}");
		}
		
		return $routes;
	}

	public function save() {}
}

?>