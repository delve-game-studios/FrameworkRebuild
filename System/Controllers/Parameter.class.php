<?php

namespace System;

// basic methods for views
class Parameter extends Application {
	public function __construct($params) {
		foreach($params as $key => $value) {
			if(!is_int($key)) {
				$this->{$key} = $value;
			}
		}
	}

	public function getParam($name, $default = null) {
		if(!isset($this->data['variable'][$name])) return $default;
		return $this->data['variable'][$name];
	}
}

?>