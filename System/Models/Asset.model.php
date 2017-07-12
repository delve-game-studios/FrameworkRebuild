<?php

namespace Application\Models;
use \System\Model;
use \System\Connection;

class Asset extends Model {
	public function tableName() {
		return 'sys_assets';
	}

	public function primaryKey() {
		return 'sa_id';
	}

	public function save() {}
}

?>