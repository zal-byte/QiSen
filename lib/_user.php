<?php
	require_once '_interface.php';
	require_once '_handler.php';


	class USER implements query{
		private static $response = null;
		private static $instance = null;
		public static function getInstance(){
			if(self::$instance == null)
			{
				self::$instance = new USER();
			}
			return self::$instance;

		}

		public static function MyProfile( $data )
		{
			Handler::$context = 'MyProfile';

		}



		private static function CheckUser( $username )
		{
			$prepare = Handler::PREPARE( USER::getPengguna, array('username'=>$username));
			if($prepare)
			{
				$data = Handler::fetchAssoc( $prepare );
				if( count($data) > 0)
				{
					return false;
				}else
				{
					return true;
				}
			}else
			{
				Handler::HandlerError('Kueri error');
			}
		}

		public static function AddUser( $data )
		{
			self::$response['AddUser'] = array();
			Handler::$context = 'AddUser';

			$username = Handler::VALIDATE( $data ,'username');
			$password = Handler::VALIDATE( $data, 'password');
			$name = Handler::VALIDATE( $data, 'name');
			$grade = Handler::VALIDATE( $data, 'grade');
			$user_img = 'img/user/default.jpg';

			$user_input = Handler::VALIDATE( $data, 'user_input');
			

			if( self::CheckUser( $username) != false )
			{
				$prepare = Handler::PREPARE( USER::addUser, array('username'=>$username,'password'=>$password,'name'=>$name,'grade'=>$grade,'user_img'=>$user_img));
				if($prepare)
				{
					$re['status'] = true;
					$re['msg'] = 'Menambahkan pengguna berhasil';
				}else{
					$re['status'] = false;
					$re['msg'] = 'Kueri error';
				}
			}else
			{
				$re['status'] = false;
				$re['msg'] = 'Pengguna ini sudah ada';
			}

			array_push(self::$response['AddUser'], $re);
			Handler::print(self::$response);

		}

		public static function UserLogin( $data )
		{
			Handler::$context = 'UserLogin';

			$username = Handler::VALIDATE( $data, 'username');
			$password = Handler::VALIDATE( $data, 'password');
			self::$response['UserLogin'] = array();

			$result = Handler::PREPARE( USER::userLogin, array('username'=>$username) );
			if($result)
			{
				$response = $result->fetchAll(PDO::FETCH_ASSOC)[0];
				if( $response['password'] == $password )
				{
					//Login berhasil
					$re['status'] = true;
					$re['name'] = $response['name'];
					$re['username'] = $response['username'];
					$re['password'] = $response['password'];
					$re['user_img'] = $response['user_img'];
					$re['grade'] = $response['grade'];

				}else
				{
					$re['status'] = false;
					$re['msg'] = 'Kata sandi salah';
			

					//Kata sandi salah
				}
			}else
			{
				$re['status'] = false;
				$re['msg'] = 'Kueri error';
			}

			array_push(self::$response['UserLogin'], $re);
			Handler::print(self::$response);

		}	

	}

?>