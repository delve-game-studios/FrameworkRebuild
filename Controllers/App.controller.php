<?php

namespace Application\Controllers;
use \System\Application;
use \System\Controller;
use \System\Model;
use \System\View;
use \System\Html;

class App extends Controller {

	public function showIndex() {
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

?>