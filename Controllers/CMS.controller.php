<?php

namespace Application\Controllers;
use \System\Application;
use \System\Controller;
use \System\Model;
use \System\View;
use \System\Html;

class CMS extends Controller {
	public function showIndex() {
		$params = [];
		$username = $this->request->getParam('username', false);
		$password = $this->request->getParam('password', false);

		if($username && $password) {
			$params = array(
				'username' => $username,
				'password' => $password
			);
		}
		$this->render('cms', $params);
	}

	public function showLogin() {
		$this->render('cms');
	}
}

?>