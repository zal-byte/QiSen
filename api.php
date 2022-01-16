<?php


	require_once 'lib/_handler.php';
	require_once 'lib/_user.php';
	require_once 'lib/_absen.php';

	Handler::getInstance();
	USER::getInstance();
	ABSEN::getInstance();

	isset($_SERVER['REQUEST_METHOD']) ? define('METHOD', $_SERVER['REQUEST_METHOD']) : die("Error");

	METHOD == 'GET' ? define('getData', $_GET) : (METHOD == 'POST' ? define('postData', $_POST) : die("Error"));

	
	METHOD == 'GET' ? ( isset(getData['request']) ? get() : die("Missing 'request' parameter") ) : null;
	METHOD == 'POST' ? ( isset(postData['request']) ? post() : die("Missing 'request' parameter") ) : null;

	function get()
	{
		getData['request'] == 'myprofile' ? USER::MyProfile( getData ) : ( getData['request'] == 'getabsen' ? ABSEN::GetAbsen( getData ));
	}

	function post()
	{
		postData['request'] == 'login' ? USER::UserLogin(postData) : ( postData['request'] == 'adduser' ? USER::addUser( postData ) : null );	
	}


?>