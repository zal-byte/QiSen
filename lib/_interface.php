<?php

	interface query{
		const userLogin = 'SELECT * FROM pengguna WHERE username=:username';
		const addUser = 'INSERT INTO pengguna (`username`,`password`,`name`,`grade`,`user_img`) VALUES (:username, :password, :name, :grade, :user_img)';
		const updateUserImage = 'UPDATE pengguna SET `user_img`=:user_img WHERE username=:username';

		const putAbsen = 'INSERT INTO absen (`username`,`absen_tanggal`,`absen_jam`,`status`,`absen_keterangan`,`gambar_id`) VALUES (:username, :absen_tanggal, :absen_jam, :status, :absen_keterangan, :gambar_id)';
		const putImageInformation = 'INSERT INTO informasi_gambar (`gambar_id`,`tanggal`,`jam`,`filesize`,`device`,`path`) VALUES (:gambar_id, :tanggal, :jam, :filesize, :device, :path)';

		const getAbsen = 'SELECT * FROM absen LEFT JOIN pengguna ON pengguna.username = absen.username LEFT JOIN informasi_gambar ON informasi_gambar.gambar_id = absen.gambar_id WHERE absen.absen_tanggal = :absen_tanggal AND pengguna.grade = :grade ORDER BY absen.absen_tanggal DESC LIMIT :page, :limit';
		const getPengguna = 'SELECT pengguna.name, pengguna.username, pengguna.grade, pengguna.user_img FROM pengguna WHERE username=:username';  
		const myProfile = 'SELECT * FROM pengguna WHERE username=:username';

		
	}
	

?>