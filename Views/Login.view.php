<?php

namespace System\Views;
use \System\View;
use \System\Html;
use \System\Template;

class Login extends View {

	public function Login(\System\Parameter $params) {
		$html = '';

		$form = Html::form('index.php', Html::FORM_METHOD_POST, array(
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
	}

}