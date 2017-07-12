<?php
namespace System\Libraries;
use \System\Application;
use \System\Connection;

require_once Application::$root . '/System/Assets/adodb5/adodb.inc.php';
Application::initConn(new Connection(ADONewConnection('mysql')));
?>