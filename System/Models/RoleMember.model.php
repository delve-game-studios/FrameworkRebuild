<?php

namespace Application\Models;
use \System\Model;
use \System\Connection;

class RoleMember extends Model {
	public function tableName() {
		return 'sys_role_members';
	}

	public function primaryKey() {
		return 'srm_id';
	}

	public function save() {}
}

?>