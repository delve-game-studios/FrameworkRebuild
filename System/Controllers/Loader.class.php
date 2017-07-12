<?php

namespace System;

// basic methods for controllers
class Loader extends Application {
	const TYPE_CONTROLLER = 'Controllers';
	const TYPE_MODEL = 'Models';
	const TYPE_VIEW = 'Views';
	const TYPE_LIB = 'Libraries/Init';

	const TYPE_SUB_CONTROLLER 	= 'controller';
	const TYPE_SUB_MODEL		= 'model';
	const TYPE_SUB_VIEW			= 'view';
	const TYPE_SUB_LIB			= 'lib';

	public $lastFile = '';
	public $loadedFiles = array();
	public $types = array(
		self::TYPE_CONTROLLER,
		self::TYPE_MODEL,
		self::TYPE_VIEW,
		self::TYPE_LIB
	);
	public $subTypes = array(
		self::TYPE_CONTROLLER 	=> 'controller',
		self::TYPE_MODEL		=> 'model',
		self::TYPE_VIEW			=> 'view',
		self::TYPE_LIB			=> 'lib'
	);
	public $typeNamespaces = array(
		self::TYPE_SUB_CONTROLLER	=> 'Application\Controllers',
		self::TYPE_SUB_MODEL		=> 'Application\Models',
		self::TYPE_SUB_VIEW			=> 'Application\Views',
		self::TYPE_SUB_LIB			=> 'Application\Libraries',
	);

	public function __construct(&$app) {
		$this->app = $app;
	}

	private function loadFile($path, $relative = false) {
		if(!$relative) {
			$path = $this->config->rootPath . '' . $path;
		}

		$path_r = explode('/', $path);
		$name = substr(end($path_r), 0, strpos(end($path_r), '.'));

		if(!class_exists($name)) {
			require_once $path;
		}
	}

	public function loadFolder($path) {
		$this->__load($path);
	}

	public function __call($name, $arguments) {
		$possible = get_class_methods(__CLASS__);

		if(in_array($name, $possible)) {
			call_user_func_array(array($this, $name), $arguments);
		} else {
			$type = substr($name, 4) . 's';
			if(in_array($type, array(
				self::TYPE_CONTROLLER,
				self::TYPE_MODEL,
				self::TYPE_VIEW,
				self::TYPE_LIB,
				'Librarys'
			))) {
				if($type == 'Librarys') $type = self::TYPE_LIB;

				$this->loadFile('' . $type . '/' . $arguments[0] . '.' . $this->subTypes[$type] . '.php');
				return $this->getNewInstance($arguments[0], $this->subTypes[$type], $arguments[1]);
			}
			return;
		}
	}

	private function getNewInstance($objName, $objType, $params) {
		$namespace = $this->typeNamespaces[$objType];
		$objName = "{$namespace}\\{$objName}";
		$obj = new $objName($params, $this->app);
		return $obj;
	}
}

?>