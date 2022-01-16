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

			self::$response['GetAbsen'] = array();
			$grade = Handler::VALIDATE( $data, 'grade');
			$absen_tanggal = Handler::VALIDATE( $data, 'absen_tanggal');

			$prepare = Handler::PREPARE( ABSEN::getAbsen, array('grade'=>$grade,'absen_tanggal'=>$absen_tanggal) );

			if($prepare)
			{

				$result = Handler::fetchAssoc($prepare)[0];

				$re['res'] = true;
				
				$re['username'] = $result['username'];
				$re['name']= $result['name'];
				$re['user_img'] = $result['user_img'];
				$re['grade'] = $result['grade'];

				$re['status'] = $result['status'];
				$re['absen_tanggal'] = $result['absen_tanggal'];
				$re['absen_jam'] = $result['absen_jam'];
				$re['absen_keterangan'] = $result['absen_keterangan'];

				$re['tanggal'] = $result['tanggal'];
				$re['jam'] = $result['jam'];
				$re['filesize'] = $result['filesize'];
				$re['device'] = $result['device'];
				$re['path'] = $result['path'];


			}else
			{
				$re['res'] = false;
				$re['msg'] = 'Kueri error';
			}

			array_push(self::$response['GetAbsen'], $re);
			Handler::print(self::$response);

		}
	}


?>