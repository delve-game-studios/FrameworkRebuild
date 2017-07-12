<?php

namespace Application\Models;
use \System\Model;
use \System\Connection;

class Module extends Model {
	public function tableName() {
		return 'sys_modules';
	}

	public function primaryKey() {
		return 'sm_id';
	}

	public function save() {}
}

?>