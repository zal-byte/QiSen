<?php

	require_once '_handler.php';
	Handler::getInstance();

	class CONNECTION{
		private static $instance = null;
		private static $host = 'localhost';
		private static $username = 'blyatblyatqisen';
		private static $password = 'zalbyte00';
		private static $dbname = 'blyatblyatqisen';

		public static function getInstance()
		{
			if( self::$instance == null )
			{
				self::$instance = new CONNECTION();
			}
			return self::$instance;
		}
		static $con = null;
		public function __construct()
		{
			Handler::$context = 'Connection';
		}
		public static function getConnection()
		{
			self::$con = new PDO('mysql:host='.self::$host.';dbname=' . self::$dbname,self::$username,self::$password);
			try{
				self::$con = new PDO('mysql:host='.self::$host.';dbname=' . self::$dbname,self::$username,self::$password);
			}catch(PDOException $s)
			{
				Handler::HandlerError('Connection error');
			}
			return self::$con;
		}
	}
	

?>