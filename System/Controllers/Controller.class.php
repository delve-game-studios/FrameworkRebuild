<?php

namespace System;

// basic methods for controllers
abstract class Controller extends Application {
	public $_app;
	public $request;
	
	public function __construct($app, $dynamic = false) {
		$this->_app = $app;
		$this->request = new Request();

		// if($dynamic) {
		// 	$this->dynamic();
		// }
	}

	private function dynamic() {
		$params = array(
			'_controller' => $this->request->getParam('controller', false),
			'controller' => '\\Application\\Controllers\\' . $this->request->getParam('controller', false),
			'_action' => 'show' . ucfirst($this->request->getParam('action', false)),
			'action' => 'show' . $this->request->getParam('action', false)
		);

		$g_route_path = "{$params['_controller']}/{$params['_action']}";
		if(empty(Route::$_route[$g_route_path])) {

			if(!class_exists($params['controller'])) {
				require_once parent::$root . "Controllers/{$params['_controller']}.controller.php";
			}

			if($params['controller'] && class_exists($params['controller'])) {
				(new $params['controller']($this->_app, true))->$params['action']();
			} elseif($params['controller']) {
				echo '<title>Error: 404</title><center><h1>Error 404 - Not Found!</h1></center>';
			}
		}
	}

	public function render($viewName, $params = array()) {
		$this->_app->VIEW($viewName, $params);
	}
}

?>