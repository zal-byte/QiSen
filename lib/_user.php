<?php

	require_once '_con.php';
	require_once '_handler.php';
	require_once '_pub_interface.php';

	class USER implements query{
		private static $instance = null;
		private static $response = null;

		public static function getInstance()
		{
			if(self::$instance == null)
			{
				self::$instance = new USER();
			}
			return self::$instance;
		}
		private static $con = null;
		public function __construct()
		{
			self::$con = self::$con == null ? self::$con = Connection::getConnection() : self::$con;
		}


		//Admin and teacher only
		public static function guruLogin( $data )
		{
			self::$response['guruLogin'] = array();

			Handler::$context = 'guruLogin';

			$username = Handler::VALIDATE( $data, 'username' );
			$password = Handler::VALIDATE( $data, 'password' );

			$prepare = Handler::PREPARE( USER::guruLogin, array('GUsername'=>$username));

			if( $prepare )
			{
			
				$data = Handler::fetchAssoc( $prepare );
				empty($data) ? Handler::HandlerError( 'no_data' ) : null;
				$data = $data[0];
				
				if( $data['GPassword'] == $password )
				{
					$re['res'] = true;
					$re['GNIK'] = $data['GNIK'];
					$re['GUsername'] = $data['GUsername'];
					$re['GNama'] = $data['GNama'];
					$re['GAlamat'] = $data['GAlamat'];
					$re['GNo_hp'] = $data['GNo_hp'];
					$re['GKelas'] = $data['GKelas'];
					$re['GFoto'] = $data['GFoto'];

				}else
				{
					Handler::HandlerError( 'Invalid password' );
				}

			}else
			{
				Handler::HandlerError( 'Something went wrong' );
			}

			array_push(self::$response['guruLogin'], $re);
			Handler::print(self::$response);

		}

		public static function adminLogin( $data )
		{
			Handler::$context = 'adminLogin';
			self::$response['adminLogin'] = array();

			$username = Handler::VALIDATE( $data, 'username' );
			$password = Handler::VALIDATE( $data, 'password' );

			$prepare = Handler::PREPARE( USER::adminLogin, array('AUsername'=>$username));


			if($prepare)
			{
				$data = Handler::fetchAssoc( $prepare );
				empty($data) ? Handler::HandlerError( 'no_data' ) : null;

				$data = $data[0];

				if($data['APassword'] == $password )
				{
					$re['res'] = true;
					$re['AUsername'] = $data['AUsername'];
					$re['ANama'] = $data['ANama'];
					$re['AAlamat'] = $data['AAlamat'];
					$re['ANIK'] = $data['ANIK'];

				}else{
					Handler::HandlerError( 'invalid_password' );
				}

			}else
			{
				Handler::HandlerError( 'something went wrong' );
			}


			array_push(self::$response['adminLogin'], $re);
			Handler::print( self::$response);


		}

		public static function myProfile( $username, $whoami )
		{
			$query = $whoami == 'guru' ? USER::infoGuru : ( $whoami == 'admin' ? USER::infoAdmin : null ) : null;
			$array = $whoami == 'guru' ? array('GUsername'=>$username) : array('AUsername'=>$username);

			self::$response['myProfile'] = array();

			Handler::$context = 'myProfile';

			$prepare = Handler::PREPARE(  $query, $array );

			if($prepare)
			{
				$data = Handler::fetchAssoc($prepare);
				empty($data) ? Handler::HandlerError('no_data') : null;

				
			}


		}



	}

?>