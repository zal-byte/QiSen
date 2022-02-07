<?php


	require_once 'lib/_handler.php';
	require_once 'lib/_user.php';
	require_once 'lib/_absen.php';
	require_once 'lib/_siswa.php';

	Handler::getInstance();
	USER::getInstance();
	ABSEN::getInstance();

	Handler::$context = 'API';

	!empty($_SERVER['REQUEST_METHOD']) ? ( $_SERVER['REQUEST_METHOD'] == 'POST' ? post($_POST) : ($_SERVER['REQUEST_METHOD'] == 'GET' ? get($_GET) : die("request_method error") ) ) : Handler::HandlerError("API Error");


	function post( $post )
	{
		$request = Handler::VALIDATE( $post, 'request' );
		if( $request == 'userLogin')
		{

			USER::userLogin( $post );

		}else if($request == 'addAbsen')
		{
			/*
			Parameter
			- NIS ( 10 digit )
			- NIK ( 16 digit )
			- img_date ( Y-m-d )
			- img_time ( H:m:s )
			- imageData ( base64 )
			*/
			ABSEN::checkAccess( $post );

		}else if( $request == 'deleteSiswa' )
		{
			SISWA::deleteSiswa( $post );
		}

	}

	function get( $get )
	{
		$request = Handler::VALIDATE( $get, 'request' );

		if($request=='userProfile')
		{

			USER::userProfile( $get );

		}else if($request=='getAbsen')
		{

			ABSEN::getAbsen( $get );
			
		}

	}

?>