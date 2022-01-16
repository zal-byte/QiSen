<?php

	interface query{
		const userLogin = 'SELECT password FROM pengguna WHERE username=:username';
	}

	class DB implements query{
		private static $instance = null;
		public static function getInstance()
		{
			if(self::$instance == null)
			{
				self::$instance = new DB();
			}
			return self::$instance;
		}
		public static function login($username)
		{

		}
	}

	DB::getInstance();


?>