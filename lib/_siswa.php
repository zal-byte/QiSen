<?php

    require_once '_handler.php';
    require_once '_pub_interface.php';

    Handler::getInstance();

    class SISWA implements query, dir{
        private static $instance = null;
        private static $response = null;
        public static function getInstance()
        {
            if( self::$instance == null )
            {
                self::$instance = new SISWA();
            }
            return self::$instance;
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