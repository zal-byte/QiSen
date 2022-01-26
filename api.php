<?php


	require_once 'lib/_handler.php';
	require_once 'lib/_user.php';
	require_once 'lib/_absen.php';

	Handler::getInstance();
	USER::getInstance();
	ABSEN::getInstance();
	Handler::$context = 'API';

	!empty($_SERVER['REQUEST_METHOD']) ? ( $_SERVER['REQUEST_METHOD'] == 'POST' ? post($_POST) : ($_SERVER['REQUEST_METHOD'] == 'GET' ? get($_GET) : die("request_method error") ) ) : die("Error");


	function post( $post )
	{
		$request = Handler::VALIDATE( $post, 'request' );
		$request == 'guruLogin' ? USER::guruLogin( $post ) : null;
	}

	function get( $get )
	{
		$request = Handler::VALIDATE( $get, 'request' );



	}

?>