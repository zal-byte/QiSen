<?php

	interface query{
		
		const guru = 'SELECT * FROM guru WHERE NIK=:NIK';
		const admin = 'SELECT * FROM admin WHERE NIK=:NIK';
		const siswa = 'SELECT * FROM siswa WHERE NIS =:NIS';


		const absenImgUpload = 'INSERT INTO informasi_gambar (`Info_gambar`,`Tanggal_info`,`Jam_info`,`Path`) VALUES (:Info_gambar, :Tanggal_info, :Jam_info, :Path)';
		const tambahAbsen = 'INSERT INTO absen (`NIS`,`NIK`,`Tanggal_absen`,`Jam_absen`,`Kelas_absen`,`Info_gambar`) VALUES (:NIS, :NIK, :Tanggal_absen, :Jam_absen, :Kelas_absen, :Info_gambar)';
		const tambahInformasiGambar = 'INSERT INTO informasi_gambar (`Info_gambar`,`Tanggal_info`,`Jam_info`,`Path`) VALUES (:Info_gambar, :Tanggal_info, :Jam_info, :Path)';

		const checkAbsen = 'SELECT NIS FROM absen WHERE Tanggal_absen=:Tanggal_absen AND NIS=:NIS';
		const getAbsen = 'SELECT siswa.NIS, siswa.Nama AS NamaSiswa, siswa.Tanggal_lahir AS SiswaTanggal_lahir, siswa.Tempat_lahir AS SiswaTempat_lahir, siswa.Alamat AS SiswaAlamat, siswa.Jenis_kelamin AS SiswaJenis_kelamin, siswa.Agama AS SiswaAgama, siswa.kelas AS SiswaKelas, siswa.Foto AS SiswaFoto, guru.NIK, guru.Nama AS GuruNama, guru.Tanggal_lahir AS GuruTanggal_lahir, guru.Tempat_lahir AS GuruTempat_lahir, guru.Alamat AS GuruAlamat, guru.Agama AS GuruAgama, guru.Foto AS GuruFoto, absen.NIS AS AbsenNIS, absen.NIK AS AbsenNIK, absen.Tanggal_absen, absen.Kelas_absen, absen.Info_gambar FROM absen LEFT JOIN siswa ON siswa.NIS = absen.NIS LEFT JOIN guru ON guru.NIK = absen.NIK WHERE guru.NIK = :NIK AND Tanggal_absen=:tanggal AND Kelas_absen=:kelas';
	}

	interface dir{
		const defaultUserImg = 'img/user/default.jpg';
		const userImg = 'img/user/';
		const absenPath = 'img/absen/';
	}

?>