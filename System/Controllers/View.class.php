<?php

namespace System;

// basic methods for views
abstract class View extends Application {
	public static $params;
	public $result;
	public $_app;
	public $request;

	public function __construct($params, $app, $second = false) {
		$this->_app = $app;
		$this->request = new Request();
		static::$params = new Parameter($params);
		$action_dyn = $this->request->getParam('action', false);
		$action_stl = strtolower(substr(Application::$currentRoute['action'], 4));

		$action = $action_stl ? $action_stl : $action_dyn;
		echo $this->$action();
	}
}

?>