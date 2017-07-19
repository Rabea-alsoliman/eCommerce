<?php  // #49
		/* 
		================================================
		==  Template Page 
		================================================
		*/

		ob_start();

		session_start();

		$pageTitle = '';

		if ( isset ( $_SESSION['Username'] )) {
		
		include 'init.php';

 		$do = isset($_GET['action']) ? $_GET['action'] : 'manage' ; 

 		
 		if ($do == 'manage') {  

 			echo "welcome";

 		} elseif ($do == 'add') {

 		} elseif ($do == 'insert') {

 		} elseif ($do == 'edit') {

 		} elseif ($do == 'update') {

 		} elseif ($do == 'delete') {

 		} elseif ($do == 'approve') {

 		}

 		include $tpl . 'footer.php';

 	} else { 

 		header('location: index.php');

 		exit();

 	}

 		ob_end_flush(); // release output

 		?>