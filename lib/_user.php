<?php


	require_once '_handler.php';
	require_once '_con.php';
	require_once '_pub_interface.php';

	Handler::getInstance();

	class USER implements query, dir{
		private static $response;
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


			self::$response[$context__] = array();

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

			array_push(self::$response[$context__], $re);
			Handler::print(self::$response);


		}

		public static function userProfile( $param )
		{


			$user_context__ = Handler::VALIDATE( $param, 'user');
			Handler::$context = $user_context__ == 'siswa' ? 'siswa' : ($user_context__ == 'guru' ? 'guru' : ($user_context__ =='admin' ? 'admin' : Handler::HandlerError('Invalid `user` parameter.')));

			self::$response[$user_context__] = array();
			

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

			array_push(self::$response[$user_context__], $re);
			Handler::print( self::$response );

		}





		public static function deleteSiswa( $data )
        {
            Handler::$context = "deleteSiswa";

            $NIS = Handler::VALIDATE( $data, 'NIS');

            self::$response[Handler::$context] = array();

            $param = array("NIS"=>$NIS);

            self::isHere( $NIS ) != false ? null : Handler::HandlerError("Siswa tidak ada");

            $prepare = Handler::PREPARE( SISWA::deleteSiswaData , $param );


            if( self::deleteSiswaAbsen( $NIS ) )
            {
                if( $prepare )
                {

                    $re['res'] = true;
                    $re['msg'] = 'Siswa has been deleted';
        

                }else{

                    Handler::HandlerError("Couldn't execute the query.");
                    
                }                
            }else{
                Handler::HandlerError("Couldn't delete absen data");
            }


            array_push(self::$response[Handler::$context], $re);
            Handler::print( self::$response );

        }

        private static function deleteSiswaAbsen( $NIS )
        {

            $prepare = Handler::PREPARE( SISWA::deleteAbsenData, array("NIS"=>$NIS));

            if( $prepare )
            {
                return true;
            }else
            {
                return false;
            }

        }

        private static function isHere( $NIS )
        {

            $prepare = Handler::PREPARE( SISWA::siswa, array("NIS"=>$NIS));

            if( $prepare )
            {

                if( $prepare->rowCount() > 0 )
                {
                    return true;
                }else{
                    return false;
                }

            }else{
                Handler::HandlerError( "Couldn't execute the query..");
            }

        }

        public static function editSiswa( $post )
        {
            Handler::$context = 'editSiswa';

            self::$response[Handler::$context] = array();

            $NIS = Handler::VALIDATE( $post, "NIS");
            $nama = Handler::VALIDATE( $post, "nama");
            $tanggal_lahir = Handler::VALIDATE( $post, "tanggal_lahir");
            $tempat_lahir = Handler::VALIDATE( $post, "tempat_lahir");
            $alamat = Handler::VALIDATE( $post, "alamat");
            $jenis_kelamin = Handler::VALIDATE( $post, "jenis_kelamin");
            $kelas = Handler::VALIDATE( $post, 'kelas');
            $agama = Handler::VALIDATE( $post, "agama");
            $foto = Handler::VALIDATE( $post, "foto");
            $password = Handler::VALIDATE($post, "password");

            $param = array("NIS"=>$NIS,
            "Nama"=>$nama,
            "Tanggal_lahir"=>$tanggal_lahir,
            "Tempat_lahir"=>$tempat_lahir,
            "Alamat"=>$alamat,
            "Jenis_kelamin"=>$jenis_kelamin,
            "Agama"=>$agama,
            "Kelas"=>$kelas,
            "Foto"=>$foto,
            "Password"=>md5($password));


            self::isHere( $NIS ) == false ? Handler::HandlerError("Siswa tidak ada") : null;
            
            $prepare = Handler::PREPARE( SISWA::editSiswa, $param );

            if( $prepare )
            {

                $re['res'] = true;
                $re['msg'] = 'Data Siswa berhasil diperbarui.';

            }else{
                Handler::HandlerError("Couldn't execute the query, something went wrong");
            }
            
            array_push(self::$response[Handler::$context], $re);
            Handler::print( self::$response );

        }

        public static function getSiswa( $get )
        {
            Handler::$context = 'getSiswa';

            self::$response[Handler::$context] = array();

            $NIS = Handler::VALIDATE( $get, 'NIS');


            $prepare = Handler::PREPARE( SISWA::siswa, array("NIS"=>$NIS));

            if($prepare){
                
                $data = Handler::fetchAssoc( $prepare );
                !empty($data) ? null : Handler::HandlerError("No_data");
                print_r($data);

            }else{

            }

        }

        public static function addSiswa( $post )
        {
            Handler::$context = 'addSiswa';

            self::$response[Handler::$context] = array();

            $NIS = Handler::VALIDATE( $post, "NIS");
            $nama = Handler::VALIDATE( $post, "nama");
            $tanggal_lahir = Handler::VALIDATE( $post, "tanggal_lahir");
            $tempat_lahir = Handler::VALIDATE( $post, "tempat_lahir");
            $alamat = Handler::VALIDATE( $post, "alamat");
            $jenis_kelamin = Handler::VALIDATE( $post, "jenis_kelamin");
            $kelas = Handler::VALIDATE( $post, 'kelas');
            $agama = Handler::VALIDATE( $post, "agama");
            $foto = Handler::VALIDATE( $post, "foto");
            $password = Handler::VALIDATE($post, "password");

            $param = array("NIS"=>$NIS,
            "Nama"=>$nama,
            "Tanggal_lahir"=>$tanggal_lahir,
            "Tempat_lahir"=>$tempat_lahir,
            "Alamat"=>$alamat,
            "Jenis_kelamin"=>$jenis_kelamin,
            "Agama"=>$agama,
            "Kelas"=>$kelas,
            "Foto"=>$foto,
            "Password"=>md5($password));


            if(self::isHere( $NIS ) == false)
            { 
                $prepare = Handler::PREPARE( SISWA::addSiswa, $param );

                if( $prepare )
                {

                    $re["res"] = true;
                    $re['msg'] = 'Siswa berhasil ditambahkan.';


                }else{
                    Handler::HandlerError("Couldn't execute the query");
                }
            }else{

                Handler::HandlerError("Siswa sudah ada");

            }



            array_push(self::$response[Handler::$context] , $re);
            Handler::print( self::$response );
        }

		

	}

?>