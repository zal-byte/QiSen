<?php


	require_once '_handler.php';
	require_once '_con.php';
	require_once '_pub_interface.php';

	Handler::getInstance();

	class USER implements query{
		private static $instance = null;
		public static function getInstance()
		{
			if( self::$instance == null)
			{
				self::$instance = new USER();
			}
			return self::$instance;
		}
		private static $con = null;
		public function __construct()
		{
			self::$con = CONNECTION::getConnection();
		}

		public static function guruLogin( $data )
		{

			$username = Handler::VALIDATE( $data, 'username');
			$password = Handler::VALIDATE( $data, 'password');

		}
	}

?>