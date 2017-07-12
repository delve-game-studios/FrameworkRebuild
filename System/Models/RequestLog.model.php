<?php

namespace Application\Models;
use \System\Model;
use \System\Connection;

class RequestLog extends Model {
	public function tableName() {
		return 'sys_request_log';
	}

	public function primaryKey() {
		return 'srl_id';
	}

	public function save() {}
}

?>