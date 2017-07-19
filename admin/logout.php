<?php 
	session_start();
	session_unset(); // Unset the data 
	session_destroy(); 
	header('location: index.php'); // أحوله الى صفحة النديكس
	exit();
	?>