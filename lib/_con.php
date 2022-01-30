<?php

	require_once '_handler.php';
	Handler::getInstance();

	class CONNECTION{
		private static $instance = null;
		public static function getInstance()
		{
			if( self::$instance == null )
			{
				self::$instance = new CONNECTION();
			}
			return self::$instance;
		}
		static $con = null;
		public static function getConnection()
		{
			Handler::$context = 'connection';
			try{
				self::$con = new PDO('mysql:host=localhost;dbname=qisen','database','root');
			}catch(PDOException $s)
			{
				Handler::HandlerError('Connection error');
			}
			return self::$con;
		}
	}
	

?>