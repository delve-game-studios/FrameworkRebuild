<?php

namespace Application\Models;
use \System\Model;
use \System\Connection;

class Config extends Model {
	public function tableName() {
		return 'sys_config';
	}

	public function primaryKey() {
		return 'sc_id';
	}

	public function save() {}
}

?>