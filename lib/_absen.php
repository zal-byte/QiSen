<?php

	date_default_timezone_set("Asia/Jakarta");

	require_once '_handler.php';
	require_once '_pub_interface.php';


	class ABSEN implements query{

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
			
			$NIS = Handler::VALIDATE( $param, 'NIS');
			$NIK = Handler::VALIDATE( $param, 'NIK');
			$tanggal = date('Y-m-d');
			$jam = date('H:m:s');
			$kelas = Handler::VALIDATE ( $param , 'kelas');

			$img_data = Handler::VALIDATE( $param, 'imageData');

			$filename = $tanggal . "_" . $jam . ".jpg";

			self::up( $filename, $img_data ) != false ? null : Handler::HandlerError('img upload error');

		}
		
		private static function up($filename, $data )
		{
			$d_base64 = base64_decode( $data );

			return file_put_contents( $filename, $d_base64) ? true : false;
		}

	}


?>