<?php

	require_once '_handler.php';
	require_once '_interface.php';


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

		public static function GetAbsen( $data )
		{
			Handler::$context = 'GetAbsen';

			self::$response['GetAbsen'] = array();

			$kelas = Handler::VALIDATE( $data, 'kelas');
			$absen_tanggal = Handler::VALIDATE( $data, 'absen_tanggal');

			$prepare = Handler::PREPARE( ABSEN::getAbsen, array('kelas'=>$kelas,'absen_tanggal'=>$absen_tanggal) );

			if($prepare)
			{



				$result = Handler::fetchAssoc($prepare);

				$result = !empty($result) ? $result : Handler::HandlerError( 'Empty!' );

				$re['res'] = true;
				for($i = 0; $i < count($result); $i++)
				{
					
					$re['nis'] = $result[$i]['NIS'];
					$re['nama'] = $result[$i]['nama'];
					$re['user_img'] = $result[$i]['user_img'];
					$re['kelas'] = $result[$i]['kelas'];

					$re['absen_status'] = $result[$i]['absen_status'];
					$re['absen_tanggal'] = $result[$i]['absen_tanggal'];
					$re['absen_jam'] = $result[$i]['absen_jam'];
					$re['absen_keterangan'] = $result[$i]['absen_keterangan'];

					$re['tanggal'] = $result[$i]['tanggal'];
					$re['jam'] = $result[$i]['jam'];
					$re['filesize'] = $result[$i]['filesize'];
					$re['device'] = $result[$i]['device'];
					$re['path'] = $result[$i]['path'];
				}


			}else
			{
				$re['res'] = false;
				$re['msg'] = 'Query error';
			}

			array_push(self::$response['GetAbsen'], $re);
			Handler::print(self::$response);

		}
	}


?>