<?php

namespace System;

// basic methods for HTML creation
class Html extends Application {

	private static $indexes = array();
	private static $shortTags = array('input', 'img');

	const FT_INPUT = 'input';
	const FT_SELECT = 'select';
	const FORM_METHOD_POST = 'POST';
	const FORM_METHOD_GET = 'GET';
	// const FT_

	public function __construct() {}

	public static function appendElements($parent, $children) {
		$parents = explode('></', $parent);
		$parents[0] = "{$parents[0]}>";
		$parents[1] = "</{$parents[1]}";

		$result = array("{$parents[0]}\n");

		foreach($children as $child) {
			$result[] = "{$child}\n";
		}

		$result[] = "{$parents[1]}\n";

		return implode('', $result);
	}

	public static function form($action, $method, $fields, $htmlOptions = array()) {

		$htmlOptions['method'] = $method;
		$htmlOptions['action'] = $action;

		$result = self::createElement('form', $htmlOptions);

		$result = self::appendElements($result, $fields);

		return $result;
	}

	public static function getAttribute($element, $attrName) {
		$matches = array();
		preg_match('/^.*?' . $attrName . '\=[\'|"](.*?)[\'|"].*?$/', $element, $matches);
		$result = $matches[1];

		return $result;
	}

	public static function setAttribute($element, $attrName, $attrValue = '') {
		$haveAttr = self::getAttribute($element, $attrName);

		if($haveAttr) {
			$result = preg_replace('/^(.*?' . $attrName . '\=[\'|"]).*?([\'|"].*?)$/', '$1' . $attrValue . '$2', $element);
		} else {
			$result = preg_replace('/^(\<([A-Za-z-_]+))(.*?(\>|\\\>|\>.*?<\/\2\>))$/', '$1 ' . $attrName . '="' . $attrValue . '"$3', $element);
		}

		return $result;
	}

	public static function removeAttribute($element, $attrName) {
		$result = preg_replace('/^(.*?)' . $attrName . '\=[\'|"].*?[\'|"](.*?)$/', '$1$2', $element);

		return $result;
	}

	public static function createElement($tag, $htmlOptions = array())  {
		$tag = preg_replace('/(\<|\>|\\\>|\s)+/', '', $tag);

		$result = "<{$tag}></{$tag}>";

		if(in_array($tag, self::$shortTags)) $result = "<{$tag}/>";

		$htmlOptions = array_reverse($htmlOptions, true);

		foreach($htmlOptions as $key => $value) {
			$result = self::setAttribute($result, $key, $value);
		}

		return $result;
	}


}

?>