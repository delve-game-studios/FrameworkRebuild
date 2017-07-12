<?php

namespace System;

class Request extends Application {

	public $all = array();

	public static $params = array(
		'get' => '_GET',
		'post' => '_POST',
		'files' => '_FILES',
		'cookies' => '_COOKIE',
        'session' => '_SESSION'
	);

    public $isPost = false;

    public function __construct() {
        if(isset($_POST) && !empty($_POST)) {
            $this->isPost = true;
        }
		$this->_init();
    }

    public function __debugInfo() {
        return $this->all;
    }

    private function _init() {

    	$old = $this->all;
    	$this->all['_all'] = $_REQUEST;
    	// $this->updateAllParams();
    	$this->all['_old'] = $old;
    }

    public function getParam($paramName, $default = null) {
        if (!empty($paramName) && is_string($paramName)) {
            if(isset($this->all['_all'][$paramName])) {
                return $this->all['_all'][$paramName];
            } else {
                return $default;
            }
        } else {
            throw new Exception("Error Processing Request. Param Name is not been set or is not a valid type!", 1);
        }
    }

    public function setParam($paramName, $paramValue) {
        if (!empty($paramName) && is_string($paramName)) {
            $this->all['_all'][$paramName] = $paramValue;
        } else {
            throw new Exception("Error Processing Request. Param Name is not been set or is not a valid type!", 1);
        }
    }

    public function updateAllParams() {
		foreach(self::$params as $paramKey => $paramName) {
			$this->all[$paramKey] = $GLOBALS[$paramName];
			${$paramName} = array();
		}
    }
}
