<?php



	date_default_timezone_set("Asia/Jakarta");
	require_once 'lib/_handler.php';
	require_once 'lib/_user.php';
	require_once 'lib/_absen.php';

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

			/*
			Parameter

			- user='siswa atau guru'
			contoh `user=siswa`
			- nis / nik
			- password='Kata sandi'
			- request='userLogin'

			*/

		}else if($request == 'addAbsen')
		{
			
			/*
			Parameter
			- NIS ( 10 digit )
			- img_date ( Y-m-d )
			- img_time ( H:m:s )
			- imageData ( base64 )
			- kelas 
			*/

			ABSEN::checkAccess( $post );

		}else if( $request == 'deleteSiswa' )
		{
			USER::deleteSiswa( $post );
		}else if( $request == 'addSiswa' )
		{
			USER::addSiswa( $post );
		}else if( $request == 'editSiswa' )
		{
			USER::editSiswa( $post );
		}


		else if ($request=='addGuru')
		{
			USER::addGuru( $post );
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
			
		}else if( $request=='getSiswa')
		{

			USER::getSiswa( $get );
		
		}

		else if( $request == 'myStudent')
		{

			ABSEN::myStudent( $get );

		}

		else if( $request =='myAbsen')
		{
			ABSEN::myAbsen( $get );
		}

		else if( $request == 'cekDisini')
		{
			ABSEN::cekDisini( $get );
		}

		else if ( $request == 'cekDisiniHadir')
		{
			ABSEN::cekDisiniHadir( $get );
		}
		

	}

?>