<?php

namespace Application\Models;
use \System\Model;
use \System\Connection;

class Role extends Model {
	public function tableName() {
		return 'sys_roles';
	}

	public function primaryKey() {
		return 'sr_id';
	}

	public function save() {}
}

?>