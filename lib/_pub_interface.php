<?php

	interface query{
		
		const guruLogin = 'SELECT * FROM guru WHERE GUsername = :GUsername';
		const adminLogin = 'SELECT APassword FROM admin WHERE AUsername = :AUsername';



	}

?>