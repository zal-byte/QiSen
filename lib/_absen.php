<?php

	date_default_timezone_set("Asia/Jakarta");

	require_once '_handler.php';
	require_once '_pub_interface.php';


	class ABSEN implements query, dir{

		private static $instance = null;
		private static $response = null;

		public static function getInstance()
		{
			if( self::$instance == null)
			{
				self::$instance = new ABSEN();
			}
			return self::$instance;
		}

		public static function myStudent( $get )
		{
			Handler::$context = 'myStudent';
			self::$response[Handler::$context] = array();


			//Walikelas
			$kelas = Handler::VALIDATE( $get, 'kelas');


			$prepare = Handler::PREPARE( ABSEN::myStudent, array("Kelas"=>$kelas));


			if($prepare)
			{

				$data = Handler::fetchAssoc( $prepare );

				!empty($data) ? null : Handler::HandlerError('no_data');


				for( $i = 0; $i < count($data); $i++)
				{
					
					$re['res'] = true;
					$re['nis'] = $data[$i]['NIS'];
					$re['nama'] = $data[$i]['Nama'];
					$re['tanggal_lahir'] = $data[$i]['Tanggal_lahir'];
					$re['tempat_lahir'] = $data[$i]['Tempat_lahir'];
					$re['alamat'] = $data[$i]['Alamat'];
					$re['jenis_kelamin'] = $data[$i]['Jenis_kelamin'];
					$re['agama'] = $data[$i]['Agama'];
					$re['foto'] = $data[$i]['Foto'];
					$re['kelas'] = $data[$i]['Kelas'];
					array_push(self::$response[Handler::$context], $re);

				}

				

			}else{
				Handler::HandlerError("Couldn't execute the query.");
			}

			//



			Handler::printt(self::$response);

		}

		

		public static function myTeacher( $walikelas )
		{


			$prepare = Handler::PREPARE(ABSEN::myTeacher, array('Walikelas'=>$walikelas));

			if( $prepare) 
			{
				
				if( $prepare->rowCount() > 0 )
				{
					$data = Handler::fetchAssoc( $prepare )[0];
					return $data['NIK'];
				}else{
					Handler::HandlerError('guru_not_found');
				}

			}else{
				Handler::HandlerError("Couldnt' execute the query.");
			}


		}

		public static function getAbsen( $data )
		{
			Handler::$context = 'getAbsen';
			self::$response[Handler::$context] = array();

			$tanggal = Handler::VALIDATE( $data, 'tanggal');
			$kelas = Handler::VALIDATE($data, 'kelas');

			$nik = Handler::VALIDATE($data, 'nik');

			$param = array("NIK"=>$nik, "Tanggal_absen"=>$tanggal, "Kelas_absen"=>$kelas);

			$prepare = Handler::PREPARE( ABSEN::getAbsen, $param );
			if( $prepare )
			{
				
				$datas = Handler::fetchAssoc( $prepare )[0];
				
				!empty($datas) ? null : Handler::HandlerError("no_data");

				$re['res'] = true;

				$re['SiswaNIS'] = $datas['SiswaNIS'];
				$re['SiswaNama'] = $datas['SiswaNama'];
				$re['SiswaTanggal_lahir'] = $datas['SiswaTanggal_lahir'];
				$re['SiswaTempat_lahir'] = $datas['SiswaTempat_lahir'];
				$re['SiswaAlamat'] = $datas['SiswaAlamat'];
				$re['SiswaJenis_kelamin'] = $datas['SiswaJenis_kelamin'];
				$re['SiswaAgama'] = $datas['SiswaAgama'];
				$re['SiswaKelas'] = $datas['SiswaKelas'];
				$re['SiswaFoto'] = $datas['SiswaFoto'];

				$re['GuruNIK'] = $datas['GuruNIK'];
				$re['GuruNama'] = $datas['GuruNama'];
				$re['GuruTanggal_lahir'] = $datas['GuruTanggal_lahir'];
				$re['GuruTempat_lahir'] = $datas['GuruTempat_lahir'];
				$re['GuruAlamat'] = $datas['GuruAlamat'];
				$re['GuruJenis_kelamin'] = $datas['GuruJenis_kelamin'];
				$re['GuruAgama'] = $datas['GuruAgama'];
				$re['GuruFoto'] = $datas['GuruFoto'];

				$re['AbsenNIS'] = $datas['AbsenNIS'];
				$re['AbsenNIK'] = $datas['AbsenNIK'];
				$re['Tanggal_absen'] = $datas['Tanggal_absen'];
				$re['Kelas_absen'] = $datas['Kelas_absen'];
				
				$re['Info_gambar'] = $datas['Info_gambar'];

				$re['Tanggal_info'] = $datas['Tanggal_info'];
				$re['Jam_info'] = $datas['Jam_info'];
				$re['Path'] = $datas['Path'];


			}else{	
				Handler::HandlerError("Couldn't execute the query");
			}

			array_push(self::$response[Handler::$context], $re);
			Handler::printt( self::$response );

		}

		public static function Absens( $param )
		{

			Handler::$context = 'Absens';
			self::$response['Absens'] = array();

			$NIS = Handler::VALIDATE( $param, 'NIS');
			
			$img_date = Handler::VALIDATE( $param, "img_date");
			$img_time = Handler::VALIDATE( $param, "img_time");

			$tanggal = date('Y-m-d');
			$jam = date('H:i:s');


			$gambar_tanggal = Handler::VALIDATE( $param, 'img_date');
			$gambar_jam = Handler::VALIDATE( $param , 'img_time');

			$kelas = Handler::VALIDATE ( $param , 'kelas');
			$NIK = self::myTeacher($kelas);
			
			$img_data = Handler::VALIDATE( $param, 'imageData');

			
			$identifier = 'img_info_' . uniqid() . "_" . date('Y-m-d') . "_" . str_replace(":", "_", $jam);
			$filename = $identifier . "_img.jpg";

			$path = ABSEN::absenPath . $filename;


			if( self::imgCheck($img_date) != false )
			{
				if( self::up( $filename, $img_data) != false )
				{


					if( self::addToInformasiGambarTable( $identifier, $gambar_tanggal, $gambar_jam, $path ) != false )
					{
						if( self::addToAbsensTable( $identifier, $NIS, $NIK, $tanggal, $jam, $kelas) != false )
						{
							$re['res'] = true;
							$re['msg'] = 'Absen berhasil ditambahkan. ';
						}else{
							Handler::HandlerError('Input data `Absens` error');
						}
					}else{
						Handler::HandlerError('Input data `informasi gambar` error');
					}



					//Unused but no problem

					// if( self::addToAbsensTable($identifier, $NIS, $NIK, $tanggal, $jam, $kelas) != false )
					// {
					// 	if( self::addToInformasiGambarTable( $identifier, $gambar_tanggal, $gambar_jam, $path) != false )
					// 	{
					// 		$re['res'] = true;
					// 		$re['msg'] = 'Absens berhasil ditambahkan.';
					// 	}else{
					// 		Handler::Error('Input data `informasi gambar` error');
					// 	}
					// }else{
					// 	Handler::HandlerError('Input data `Absens` error');
					// }


				}else{
					unlink( $path );
					Handler::HandlerError('ImgUpload error');
				}				
			}else{
				Handler::HandlerError("Foto yang kamu upload tidak sesuai dengan tanggal!");
			}



			array_push(self::$response['Absens'], $re);
			Handler::printt( self::$response );
			
		}


		//Yyyy-mm-dd

		//Important !

		public static function checkAbsens( $nis, $tanggal ){
			$arr = array('NIS'=>$nis, 'Tanggal_absen'=>$tanggal);

			$prepare = Handler::PREPARE( ABSEN::checkAbsen, $arr );
			if( $prepare )
			{

				if( $prepare->rowCount() > 0 )
				{

					//Sudah absen
					return false;
				
				}else{

					return true;

				}

			}else{
				Handler::HandlerError("Couldn't execute the query.");
			}

		}

		public static function checkAccess( $data )
		{

			Handler::$context = "Absens";

			$NIS = Handler::VALIDATE( $data, "NIS");
			$img_time = Handler::VALIDATE( $data, 'img_time');

			

			$img_date = Handler::VALIDATE( $data, 'img_date');
			
			$start_time = "06:00:00";
			$final_time = "06:45:00";

			$server_date = date('Y-m-d');

			if( $img_time < $start_time ){
				//Belum bisa Absens
				Handler::HandlerError("Belum bisa Absens");
			}else{
				if( $img_time >= $start_time )
				{
					if( $img_time > $final_time )
					{
						Handler::HandlerError("Kamu telat");
					}else{
						//Bisa Absens
						if( self::checkAbsens( $NIS, $server_date ) != false )
						{
							//Siswa belum Absens, bisa Absens;
							self::Absens( $data );
						}else
						{
							//Siswa sudah Absens, tidak bisa Absens lagi;
							Handler::HandlerError("Kamu sudah Absen");
						}
					}
				}else{
					if( $img_time > $final_time )
					{
						//telat
						Handler::HandlerError("Kamu telat");
					}
				}
			}

		}

		private static function imgCheck( $img_date )
		{
			
			//Tanggal pada server (ASIA/JAKARTA)
			$server_date = date('Y-m-d');

			if( $img_date < $server_date )
			{
				//Gambar kemarin
				return false;
			}else{
				return true;
			}

		}

		private static function addToInformasiGambarTable( $identifier , $tanggal, $jam, $path )
		{
			
			$data = array('Info_gambar'=>$identifier, 'Tanggal_info'=>$tanggal, 'Jam_info'=>$jam, 'Path'=>$path);

			$prepare = Handler::PREPARE( ABSEN::tambahInformasiGambar, $data );

			if( $prepare )
			{
				return true;
			}else{
				return false;
			}
		}

		private static function addToAbsensTable( $identifier, $NIS, $NIK, $tanggal, $jam, $kelas )
		{

			$data = array('NIS'=>$NIS, 'NIK'=>$NIK, 'Tanggal_absen'=>$tanggal, 'Jam_absen'=>$jam, 'Kelas_absen'=>$kelas, 'Info_gambar'=>$identifier);
			$prepare = Handler::PREPARE( ABSEN::tambahAbsen, $data );
			if($prepare)
			{
				return true;
			}else{
				return false;
			}
		}
		
		private static function up($filename, $data )
		{
			$d_base64 = base64_decode( $data );

			return file_put_contents( ABSEN::absenPath . $filename, $d_base64) ? true : false;
		}


	}


?>