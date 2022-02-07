<?php

	interface query{
		
		const guru = 'SELECT * FROM guru WHERE NIK=:NIK';
		const admin = 'SELECT * FROM admin WHERE NIK=:NIK';
		const siswa = 'SELECT * FROM siswa WHERE NIS =:NIS';


		const absenImgUpload = 'INSERT INTO informasi_gambar (`Info_gambar`,`Tanggal_info`,`Jam_info`,`Path`) VALUES (:Info_gambar, :Tanggal_info, :Jam_info, :Path)';
		const tambahAbsen = 'INSERT INTO absen (`NIS`,`NIK`,`Tanggal_absen`,`Jam_absen`,`Kelas_absen`,`Info_gambar`) VALUES (:NIS, :NIK, :Tanggal_absen, :Jam_absen, :Kelas_absen, :Info_gambar)';
		const tambahInformasiGambar = 'INSERT INTO informasi_gambar (`Info_gambar`,`Tanggal_info`,`Jam_info`,`Path`) VALUES (:Info_gambar, :Tanggal_info, :Jam_info, :Path)';

		const checkAbsen = 'SELECT NIS FROM absen WHERE Tanggal_absen=:Tanggal_absen AND NIS=:NIS';
		const getAbsen = 'SELECT * FROM absen WHERE ';
	}

	interface dir{
		const defaultUserImg = 'img/user/default.jpg';
		const userImg = 'img/user/';
		const absenPath = 'img/absen/';
	}

?>