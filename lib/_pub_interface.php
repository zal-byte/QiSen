<?php

	interface query{
		
		const guruLogin = 'SELECT * FROM guru WHERE NIK=:NIK';
		const adminLogin = 'SELECT * FROM admin WHERE NIK=:NIK';
		const siswaLogin = 'SELECT * FROM siswa WHERE NIS =:NIS';


		const lihatAbsen = 'SELECT '

	}

?>