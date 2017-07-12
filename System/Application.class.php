<?php

namespace System;

class Application {

	public static $app;
	public static $root;
	public static $_db;

	private $timestamp;

	public $data = array(
		'constant' => array(),
		'variable' => array(),
		'system' => array(),
		'debug' => '',
		'default' => array(
			'app',
			'controller',
			'loader',
			'model',
			'module',
			'request',
			'template',
			'route',
			'view',
			'config'
		)
	);

	public static $error = array();

	public static $currentRoute;

	public function __construct() {
		self::$app = &$this;
		$this->timestamp = time();
	}

	public function __get($name) {
		if(in_array($name, $this->data['default'])) return $this->data['system'][$name];
		if(!empty($this->data['variable'][$name])) return $this->data['variable'][$name];
		return $this->{$name};
	}

	public function __set($name, $value) {
		if(in_array($name, $this->data['default'])) {$this->data['system'][$name] = $value;return;}
		if(preg_match('/^[A-Z_]+[A-Z0-9_]+$/', $name)) {$this->data['constant'][$name] = $value;return;}
		$this->data['variable'][$name] = $value;
	}

	public function __debugInfo() {
		return $this->data['variable'];
	}

	public function __load($path) {
		$dir = scandir($path);

		$filePatterns = array(
			'Controllers' => 'class',
			'Config' => 'cfg',
			'Models' => 'model',
			'Modules' => 'module',
			'Views' => 'view',
			'Libraries' => 'lib',
		);

		foreach($dir as $file) {
			if(preg_match('/(\.' . $filePatterns[end(explode('/', $path))] . '\.php)$/', $file)) {				
				include_once "{$path}/{$file}";
			}
		}
	}

	public static function init($rootPath = '', $debug = false) {
		self::$root = $rootPath;
		$app = new Application;
		$app->debug = $debug;

		$app->__load("{$rootPath}/System/Controllers");
		$app->__load("{$rootPath}/System/Models");
		$app->__load("{$rootPath}/System/Views");
		$app->__load("{$rootPath}/System/Config");
		$app->__load("{$rootPath}/System/Modules");
		$app->__load("{$rootPath}/System/Libraries");

		$app->config = new Config($rootPath);
		$app->loader = new Loader($app);
		$app->route = new Route($rootPath);
		$app->request = new Request();
		$app->template = new Template();
		$app->module = new Module();

		$app->request->updateAllParams();
		$app->route->executeRoute($app);
		return $app;
	}

	public static function initConn(Connection $con) {
		$config = new Config(self::$root);
		$con->debug = false;
		$server   = $config->get('db.server');
		$username = $config->get('db.username');
		$password = $config->get('db.password');
		$database = $config->get('db.db_name');

		$con->connection->Connect('localhost', 'vfwsinfo_sys', 'UXwv]B?PzCG)', 'vfwsinfo_system');
		self::$_db = $con->connection;
		return $con->connection;
	}

	public static function CONTROLLER($name, $params = array()) {
		global $app;
		$params = new Parameter($params);
		return $app->loader->loadController($name, $params);
	}

	public static function MODEL($name, $params = array()) {
		global $app;
		$params = new Parameter($params);
		return $app->loader->loadModel($name, $params);
	}

	public function VIEW($name, $params = array()) {
		global $app;
		$params = new Parameter($params);
		return $this->loader->loadView($name, $params);
	}

	public static function show404() {
        echo file_get_contents(self::$error["404"]);
        exit;
    }

    public static function showError($error_code) {
        echo file_get_contents(self::$error[$error_code]);
        exit;
    }

}



?>