<?php

namespace Application\Views;
use \System\Application;
use \System\View;
use \System\Html;
use \System\Template;
use \System\Parameter;

class cms extends View {

	public function index() {
		$html = '';

		$title = Html::createElement('title');
		$title = Html::appendElements($title, array('Hello World!'));
		$html .= $title;

		$formParams = array(
			Html::appendElements(
				Html::createElement('h2', array('style' => 'width:100%;text-align:center;')),
				array('Hello World!')
			)
		);

		if($username = parent::$params->getParam('username')) {
			$formParams[] = Html::createElement('br');
			$formParams[] = Html::appendElements(Html::createElement('span'), array('Username: <b>' . $username . '</b>'));
		}

		if($password = parent::$params->getParam('password')) {
			$formParams[] = Html::createElement('br');
			$formParams[] = Html::appendElements(Html::createElement('span'), array('Password: <b>' . $password . '</b>'));
			$formParams[] = Html::createElement('br');
		}

		$formParams[] = Html::createElement('input', array(
			'type' => 'submit',
			'value' => 'Go To Login Page ->'
		));

		$form = Html::form('/login', Html::FORM_METHOD_POST, $formParams);
		$html .= $form;

		return $html;
	}

	public function login() {
		$result = '';

		$title = Html::createElement('title');
		$title = Html::appendElements($title, array('Login'));
		$result .= $title;

		$form = Html::form('/', Html::FORM_METHOD_POST, array(
			Html::createElement('input', array(
				'type' 	=> 'text',
				'name' 	=> 'username',
				'id'	=> 'username',
				'placeholder' => 'Username'
			)),
			Html::createElement('input', array(
				'type'	=> 'password',
				'name'	=> 'password',
				'id'	=> 'password',
				'placeholder' => 'Password'
			)),
			Html::createElement('input', array(
				'type' 	=> 'submit',
				'value'	=> 'Login',
				'class'	=> 'submit'
			))
		));
		$result .= $form;

		// This view should return already built template, but for now it's ok!

		return $result;
	}

}