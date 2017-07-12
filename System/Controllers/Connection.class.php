<?php
namespace System;

class Connection extends Application {

	public $connection;
	public function __construct($ADONewConnection) {
		$this->connection = $ADONewConnection;
		return $this;
	}
}
?>