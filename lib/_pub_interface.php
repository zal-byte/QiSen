<?php

	interface query{
		
		const guru = 'SELECT * FROM guru WHERE NIK=:NIK';
		const admin = 'SELECT * FROM admin WHERE NIK=:NIK';
		const siswa = 'SELECT * FROM siswa WHERE NIS =:NIS';


		const absenImgUpload = 'INSERT INTO informasi_gambar (`Info_gambar`,`Tanggal_info`,`Jam_info`,`Path`) VALUES (:Info_gambar, :Tanggal_info, :Jam_info, :Path)';

	}

?>