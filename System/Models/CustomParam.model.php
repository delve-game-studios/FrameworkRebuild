<?php

namespace Application\Models;
use \System\Model;
use \System\Connection;

class CustomParam extends Model {
	public function tableName() {
		return 'sys_parameters';
	}

	public function primaryKey() {
		return 'sp_id';
	}

	public function save() {}
}

?>