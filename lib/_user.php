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
			$context__ = $data['user'] == 'guru' ? 'guruLogin' : ($data['user'] == 'admin' ? 'adminLogin' : ($data['user'] == 'siswa' ? 'siswaLogin' : Handler::HandlerError('Invalid `user` parameter.')));

			Handler::$context = $context__;

			$data['user'] == 'siswa' ? Handler::VALIDATE( $data, 'nis') : ($data['user'] == 'guru' || $data['user'] == 'admin' ? Handler::VALIDATE( $data, 'nik') : Handler::HandlerError("Invalid `user` parameter."));


			self::$arr[$context__] = array();

			$identifier = $data['user'] == 'guru' || $data['user'] == 'admin' ? $data['nik'] : $data['nis']; 
			$password = Handler::VALIDATE( $data, 'password');

			$query = $data['user'] == 'guru' ? USER::guruLogin : ($data['user'] == 'admin' ? USER::adminLogin : ($data['user'] == 'siswa' ? USER::siswaLogin : Handler::HandlerError('Invalid `user` parameter.')));

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

	}

?>