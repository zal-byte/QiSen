<?php


	require_once '_handler.php';
	require_once '_con.php';
	require_once '_pub_interface.php';

	Handler::getInstance();

	class USER implements query{
		private static $arr;
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

		public static function userLogin( $data )
		{
			$context__ = $data['user'] == 'guru' ? 'guru' : ($data['user'] == 'admin' ? 'adminLogin' : ($data['user'] == 'siswa' ? 'siswa' : Handler::HandlerError('Invalid `user` parameter.')));

			Handler::$context = $context__;

			$data['user'] == 'siswa' ? Handler::VALIDATE( $data, 'nis') : ($data['user'] == 'guru' || $data['user'] == 'admin' ? Handler::VALIDATE( $data, 'nik') : Handler::HandlerError("Invalid `user` parameter."));


			self::$arr[$context__] = array();

			$identifier = $data['user'] == 'guru' || $data['user'] == 'admin' ? $data['nik'] : $data['nis']; 
			$password = Handler::VALIDATE( $data, 'password');

			$query = $data['user'] == 'guru' ? USER::guru : ($data['user'] == 'admin' ? USER::adminLogin : ($data['user'] == 'siswa' ? USER::siswa : Handler::HandlerError('Invalid `user` parameter.')));

			$param = $data['user'] == 'guru' || $data['user'] == 'admin' ? array('NIK'=>$identifier) : ($data['user'] == 'siswa' ? array('NIS'=>$identifier) : Handler::HandlerError('Invalid `user` parameter.'));

			$prepare = Handler::PREPARE( $query , $param);
			if($prepare)
			{
				$datas = Handler::fetchAssoc($prepare)[0];
				!empty($datas) ? null : Handler::HandlerError('No_data');
				 

				$re['res'] = true;
				if( $data['user'] == 'guru' || $data['user'] == 'admin' )
				{
					$re['nik'] = $datas['NIK'];
				}
				$re['nama'] = $datas['Nama'];
				$re['tanggal_lahir'] = $datas['Tanggal_lahir'];
				$re['tempat_lahir'] = $datas['Tempat_lahir'];
				$re['alamat'] = $datas['Alamat'];
				$re['jenis_kelamin'] = $datas['Jenis_kelamin'];
				$re['agama'] = $datas['Agama'];
				if($data['user'] == 'siswa')
				{
					$re['kelas'] = $datas['Kelas'];
				}
				$re['foto'] = $datas['Foto'];

			}else
			{
				Handler::HandlerError('Something went wrong');
			}

			array_push(self::$arr[$context__], $re);
			Handler::print(self::$arr);


		}

		public static function userProfile( $param )
		{


			$user_context__ = Handler::VALIDATE( $param, 'user');
			Handler::$context = $user_context__ == 'siswa' ? 'siswa' : ($user_context__ == 'guru' ? 'guru' : ($user_context__ =='admin' ? 'admin' : Handler::HandlerError('Invalid `user` parameter.')));

			self::$arr[$user_context__] = array();
			

			$identifier = $user_context__ == 'siswa' ? Handler::VALIDATE( $param, 'NIS' ) : ($user_context__ == 'guru' || $user_context__ == 'admin' ? Handler::VALIDATE( $param, 'NIK') : Handler::HandlerError('something went wroong'));

			$query = $user_context__ == 'siswa' ? USER::siswa : ($user_context__ == 'admin' ? USER::admin : ($user_context__ ? USER::guru : Handler::HandlerError('Invalid `user` parameter.')));

			$parameter = $user_context__ == 'siswa' ? array('NIS'=>$identifier) : ($user_context__=='guru' || $user_context__ == 'admin' ? array('NIK'=>$identifier) : Handler::HandlerError("Invalid `user` parameter."));

			$prepare = Handler::PREPARE( $query, $parameter );
			if( $prepare )
			{

				$data = Handler::fetchAssoc($prepare)[0];
				!empty($data) ? null : Handler::HandlerError('no_data');

				$re['res'] = true;
				if( $user_context__ == 'siswa')
				{
					$re['NIS'] = $data['NIS'];
				}else if($user_context__ == 'guru' || $user_context__ =='admin')
				{
					$re['NIK'] = $data['NIK'];
				}
				$re['nama'] = $data['Nama'];
				$re['tanggal_lahir'] = $data['Tanggal_lahir'];
				$re['tempat_lahir'] = $data['Tempat_lahir'];
				$re['alamat'] = $data['Alamat'];
				$re['jenis_kelamin'] = $data['Jenis_kelamin'];

				if( $user_context__ == 'siswa' )
				{
					$re['kelas'] = $data['Kelas'];
				}
				$re['foto'] = $data['Foto'];


			}else{
				Handler::HandlerError("Something went wrong");
			}

			array_push(self::$arr[$user_context__], $re);
			Handler::print( self::$arr );

		}
		

	}

?>