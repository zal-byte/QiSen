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
				self::$instance = new Absen();
			}
			return self::$instance;
		}

		public static function lihatAbsen( $data )
		{
			Handler::$context = 'lihatAbsen';

			$tanggal = Handler::HandlerError( $data, 'tanggal');

		}

		public static function tambahAbsen( $param )
		{

			Handler::$context = 'tambahAbsen';
			self::$response['tambahAbsen'] = array();

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

			$path = ABSEN::userImg . $filename;
			if( self::up( $filename, $img_data) != false )
			{
				if( self::addToAbsenTable($identifier, $NIS, $NIK, $tanggal, $jam, $kelas) != false )
				{
					if( self::addToInformasiGambarTable( $identifier, $gambar_tanggal, $gambar_jam, $path) != false )
					{
						$re['res'] = true;
						$re['msg'] = 'Absen berhasil ditambahkan.';
					}else{
						Handler::Error('Input data `informasi gambar` error');
					}
				}else{
					Handler::HandlerError('Input data `absen` error');
				}
			}else{
				Handler::HandlerError('ImgUpload error');
			}

			array_push(self::$response['tambahAbsen'], $re);
			Handler::print( self::$response );
			
		}


		//Yyyy-mm-dd

		//Important !
		private static function imgCheck( $img_date, $img_time)
		{
			
			//Tanggal pada server (ASIA/JAKARTA)
			$server_date = date('Y-m-d');

			if( $img_date < $server_date )
			{
				//Tanggal pengambilan gambar kemarin
				return [false, 'kemarin'];
			}else{
				if( $img_date > $server_date )
				{
					//Tanggal di hp pengguna error
					return [false, 'tanggal_pengguna_error'];
				}else{
					//Tanggal sama dengan tanggal server
					return [true, 'lanjut'];
				}
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

		private static function addToAbsenTable( $identifier, $NIS, $NIK, $tanggal, $jam, $kelas )
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

			return file_put_contents( $filename, $d_base64) ? true : false;
		}

	}


?>