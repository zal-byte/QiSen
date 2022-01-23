<?php

	interface query{

		const userLogin = 'SELECT * FROM pengguna WHERE username=:username';
		const addUser = 'INSERT INTO pengguna (`username`,`password`,`name`,`kelas`,`user_img`) VALUES (:username, :password, :name, :kelas, :user_img)';
		const updateUserImage = 'UPDATE pengguna SET `user_img`=:user_img WHERE username=:username';

		const putAbsen = 'INSERT INTO absen (`username`,`absen_tanggal`,`absen_jam`,`status`,`absen_keterangan`,`gambar_id`) VALUES (:username, :absen_tanggal, :absen_jam, :status, :absen_keterangan, :gambar_id)';
		const putImageInformation = 'INSERT INTO informasi_gambar (`gambar_id`,`tanggal`,`jam`,`filesize`,`device`,`path`) VALUES (:gambar_id, :tanggal, :jam, :filesize, :device, :path)';

		const getAbsen = 'SELECT * FROM absen LEFT JOIN siswa ON siswa.NIS = absen.NIS LEFT JOIN informasi_gambar ON informasi_gambar.gambar_identifier = absen.gambar_identifier WHERE kelas=:kelas AND absen_tanggal=:absen_tanggal';
		const getPengguna = 'SELECT pengguna.name, pengguna.username, pengguna.kelas, pengguna.user_img FROM pengguna WHERE username=:username';  
		const myProfile = 'SELECT * FROM pengguna WHERE username=:username';

	}
	

?>