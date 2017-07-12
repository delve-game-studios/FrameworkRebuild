<?php

namespace Application\Models;
use \System\Model;
use \System\Connection;

class UserGroup extends Model {
	public function tableName() {
		return 'sys_user_groups';
	}

	public function primaryKey() {
		return 'sug_id';
	}

	public function save() {}
}

?>