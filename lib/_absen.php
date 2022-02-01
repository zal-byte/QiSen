<?php

	require_once '_handler.php';
	require_once '_pub_interface.php';


	class ABSEN implements query{

		private static $instance = null;
		private static $response = null;

		public static function getInstance()
		{
			if( self::$instance == null)
			{
				self::$instance = new Absen();
			}
			return self::$instance;
		}

		public static function lihatAbsen( $data )
		{
			Handler::$context = 'lihatAbsen';

			$tanggal = Handler::HandlerError( $data, 'tanggal');

		}



	}


?>