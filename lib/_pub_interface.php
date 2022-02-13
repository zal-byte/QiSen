<?php

	interface query{
		
		const guru = 'SELECT * FROM guru WHERE NIK=:NIK';
		const admin = 'SELECT * FROM admin WHERE NIK=:NIK';
		const siswa = 'SELECT * FROM siswa WHERE NIS =:NIS';


		const absenImgUpload = 'INSERT INTO informasi_gambar (`Info_gambar`,`Tanggal_info`,`Jam_info`,`Path`) VALUES (:Info_gambar, :Tanggal_info, :Jam_info, :Path)';
		const tambahAbsen = 'INSERT INTO absen (`NIS`,`NIK`,`Tanggal_absen`,`Jam_absen`,`Kelas_absen`,`Info_gambar`) VALUES (:NIS, :NIK, :Tanggal_absen, :Jam_absen, :Kelas_absen, :Info_gambar)';
		const tambahInformasiGambar = 'INSERT INTO informasi_gambar (`Info_gambar`,`Tanggal_info`,`Jam_info`,`Path`) VALUES (:Info_gambar, :Tanggal_info, :Jam_info, :Path)';

		const checkAbsen = 'SELECT NIS FROM absen WHERE Tanggal_absen=:Tanggal_absen AND NIS=:NIS';
		const getAbsen = 'SELECT siswa.NIS AS SiswaNIS, siswa.Nama AS SiswaNama, siswa.Tanggal_lahir AS SiswaTanggal_lahir, siswa.Tempat_lahir AS SiswaTempat_lahir, siswa.Alamat AS SiswaAlamat, siswa.Jenis_kelamin AS SiswaJenis_kelamin, siswa.Agama AS SiswaAgama, siswa.kelas AS SiswaKelas, siswa.Foto AS SiswaFoto, guru.NIK AS GuruNIK, guru.Nama AS GuruNama, guru.Tanggal_lahir AS GuruTanggal_lahir, guru.Tempat_lahir AS GuruTempat_lahir, guru.Alamat AS GuruAlamat, guru.Jenis_kelamin AS GuruJenis_kelamin, guru.Agama AS GuruAgama, guru.Foto AS GuruFoto, absen.NIS AS AbsenNIS, absen.NIK AS AbsenNIK, absen.Tanggal_absen, absen.Kelas_absen, absen.Info_gambar, informasi_gambar.Tanggal_info, informasi_gambar.Jam_info, informasi_gambar.Path FROM absen LEFT JOIN siswa ON siswa.NIS = absen.NIS LEFT JOIN guru ON guru.NIK = absen.NIK LEFT JOIN informasi_gambar ON informasi_gambar.Info_gambar = absen.Info_gambar WHERE guru.NIK = :NIK AND Tanggal_absen=:Tanggal_absen AND Kelas_absen=:Kelas_absen';
		
		const isTodayAbsen = 'SELECT Absen_id FROM absen WHERE Tanggal_absen = :Tanggal_absen';

		const deleteSiswaData = 'DELETE FROM siswa WHERE NIS=:NIS';
		const deleteAbsenData = 'DELETE FROM absen WHERE NIS=:NIS';

		const addSiswa = 'INSERT INTO siswa (`NIS`,`Nama`,`Tanggal_lahir`,`Tempat_lahir`,`Alamat`,`Jenis_kelamin`,`Agama`,`Kelas`,`Foto`,`Password`) VALUES (:NIS, :Nama, :Tanggal_lahir, :Tempat_lahir, :Alamat, :Jenis_kelamin, :Agama, :Kelas, :Foto, :Password)';
	
		const editSiswa = 'UPDATE siswa SET `NIS`=:NIS, `Nama`=:Nama,`Tanggal_lahir`=:Tanggal_lahir, `Tempat_lahir`=:Tempat_lahir, `Alamat`=:Alamat, `Jenis_kelamin`=:Jenis_kelamin, `Agama`=:Agama, `Kelas`=:Kelas, `Foto`=:Foto, `Password`=:Password WHERE `NIS`=:NIS';
	
	
		const addGuru = 'INSERT INTO guru (`NIK`,`Nama`,`Tanggal_lahir`,`Tempat_lahir`,`Alamat`,`Jenis_kelamin`,`Agama`,`Foto`,`Password`) VALUES (:NIK, :Nama, :Tanggal_lahir, :Tempat_lahir, :Alamat, :Jenis_kelamin, :Agama, :Foto, :Password)';

		const myStudent = 'SELECT * FROM siswa WHERE Kelas=:Kelas';
		const myTeacher = 'SELECT * FROM guru WHERE Walikelas=:Walikelas';

	}

	interface dir{
		const defaultUserImg = 'img/user/default.jpg';
		const userImg = 'img/user/';
		const absenPath = 'img/absen/';
	}

?>