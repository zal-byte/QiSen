<?php

	require_once '_con.php';

	date_default_timezone_set("Asia/Jakarta");
	
	class Handler{
		private static $instance = null;
		public static $context = null;
		public static function getInstance()
		{
			if ( self::$instance == null )
			{
				self::$instance = new Handler();
			}
			return self::$instance;
		}
		
		public static $con;
		public function __construct()
		{
			self::$con = CONNECTION::getConnection();
		}
		public static function VALIDATE( $data, $name )
		{
			$result = isset($data[$name]) ? $data[$name] : self::validateError( $name );
			return $result;
		}
		public static function fetchAssoc( $PDO )
		{
			return $PDO->fetchAll(PDO::FETCH_ASSOC);
		}
		public static function validateError( $name )
		{
			$err[self::$context] = array();
			$re['res'] = false;
			$re['msg'] = "Missing '" . $name ."'";
			array_push($err[self::$context], $re);
			self::printt($err);
			die();
		}
		public static function HandlerError( $msg )
		{
			$err[self::$context] = array();
			$re['res'] = false;
			$re['msg'] = $msg;
			array_push($err[self::$context], $re);
			self::printt($err);
			die();
		}
		public static function printt( $data )
		{
			header('Content-Type: application/json');
			echo json_encode($data);
		}
		public static function PREPARE( $query, $param = null )
		{
			if( $param != null )
			{

				$pre = self::$con->prepare( $query );
				if( $pre->execute($param) )
				{
					return $pre;
				}else
				{
					return false;
				}

			}else{

				$pre = self::$con->prepare($query);
				if( $pre->execute() )
				{
					return $pre;
				}else
				{
					return false;
				}

			}
		}
	}

?>