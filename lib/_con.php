<?php


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
			self::$con = new PDO('mysql:host=localhost;dbname=qisen','database','root');
			return self::$con;
		}
	}
	

?>