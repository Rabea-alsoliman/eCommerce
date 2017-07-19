<?php 
	
include 'connect.php';
 	// Routes 

	$tpl = 	'includs/templates/' ; // templarte directory
	$lang=	'includs/languages/'; // lang directory
	$func =	'includs/functions/'; // functions directory
	$css =  'layout/css/'; // css directory 
	$js  =  'layout/js/'; // js directory 
	
	// include the important files
	include  $func . 'functions.php';
	include  $lang . 'english.php'; // must that is file english in the first 
	include  $tpl . 'header.php';
	// include navbar on all pages expect the one with $noNavbar variable
	//يعني اذا ما لقيت المتغير يلي اسمه نافبار في الصفحة اعمل انكلد لصفحة النافبار 
	// page navebar me cut from header for navbare is not in all page ie : page logn
	if (!isset($noNavbar)) {include  $tpl . 'navbar.php';}
	
?>