<?php

namespace System;

class Config extends Application {

	public $data = array();

	public function __construct($rootPath) {
		require_once $rootPath . '/config.php';
		if(!isset($_SERVER['config'])) $_SERVER['config'] = array();
		$this->_init($_SERVER['config']);
		$this->data['rootPath'] = $rootPath;
	}

	public function __debugInfo() {
		return $this->data;
	}

	private function _init($options = array()) {
		foreach($options as $key => $value) {
			$this->data[$key] = $value;
		}
		unset($_SERVER['config']);
	}

	public function getAll() {
		return $this->data;
	}

	private function lookup($array,$lookup,$delimeter = '.'){
        if(!is_array($lookup)){
                $lookup=explode($delimeter,$lookup);
        }
        $key = array_shift($lookup);
        if(gettype($array) == 'array') {
    		if(isset($array[$key])){
	            $val = $array[$key];
	            if(count($lookup)){
	                    return $this->lookup($val,$lookup);
	            }
	            return $val;
	        }
	    } else {
	        if(isset($array->{$key})){
	            $val = $array->{$key};
	            if(count($lookup)){
	                    return $this->lookup($val,$lookup);
	            }
	            return $val;
	        }
	    }
	}

	public function get($name) {
		if(preg_match('/\./', $name)) {
			return $this->lookup($this->data, $name);
		}
		return $this->data[$name];
	}

	public function set($name, $value = null) {
		$this->data[$name] = $value;
	}

}

?>