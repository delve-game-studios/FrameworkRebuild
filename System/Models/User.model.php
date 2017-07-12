<?php

namespace Application\Models;
use \System\Model;
use \System\Connection;

class User extends Model {
	public function tableName() {
		return 'sys_users';
	}

	public function primaryKey() {
		return 'su_id';
	}

	public function save() {}
}

?>