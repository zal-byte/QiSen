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


		public static function lihatAbsens( $data )
		{
			Handler::$context = 'lihatAbsens';

			$tanggal = Handler::HandlerError( $data, 'tanggal');

		}

		public static function Absens( $param )
		{

			Handler::$context = 'Absens';
			self::$response['Absens'] = array();

			$NIS = Handler::VALIDATE( $param, 'NIS');
			$NIK = Handler::VALIDATE( $param, 'NIK');
			$tanggal = date('Y-m-d');
			$jam = date('H:m:s');

			$gambar_tanggal = Handler::VALIDATE( $param, 'img_date');
			$gambar_jam = Handler::VALIDATE( $param , 'img_time');

			$kelas = Handler::VALIDATE ( $param , 'kelas');

			$img_data = Handler::VALIDATE( $param, 'imageData');

			
			$identifier = 'img_info_' . uniqid() . "_" . date('Y-m-d');
			$filename = $identifier . "_img.jpg";

			$path = ABSEN::absenPath . $filename;
			if( self::up( $filename, $img_data) != false )
			{
				if( self::addToAbsensTable($identifier, $NIS, $NIK, $tanggal, $jam, $kelas) != false )
				{
					if( self::addToInformasiGambarTable( $identifier, $gambar_tanggal, $gambar_jam, $path) != false )
					{
						$re['res'] = true;
						$re['msg'] = 'Absens berhasil ditambahkan.';
					}else{
						Handler::Error('Input data `informasi gambar` error');
					}
				}else{
					Handler::HandlerError('Input data `Absens` error');
				}
			}else{
				Handler::HandlerError('ImgUpload error');
			}

			array_push(self::$response['Absens'], $re);
			Handler::print( self::$response );
			
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
			
			$start_time = "06:00";
			$final_time = "06:45";

			$server_date = date('Y-m-d');

			if( $img_time < $start_time ){
				//Belum bisa Absens
				Handler::HandlerError("Belum bisa Absens");
			}else{
				if( $img_time >= $start_time )
				{
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