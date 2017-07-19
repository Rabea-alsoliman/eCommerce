<?php  
// #16 
/* 
	Categories => [ manage | Edite | Update | Add | Insert | Delete | State ]
*/  $do = isset($_GET['action']) ? $_GET['action'] : 'manage' ;
	/* 
	$do = '';
	if (isset($_GET['action']) ) { // يعني اذا انا جيت عن طريق الجيت اكشن نف الاوامر التي تحت

			$do = $_GET['action'] ;
	}
	else {
		$do = 'manage';
	}
    */
// if the page is main page 

	if ($do == 'manage') {
		
		echo 'welcome page manage';
		echo '<a href="page.php?action=add"> Add new category + </a>';
	} elseif ( $do == 'add' ) {
		
		echo 'welcome page add';
		

	} elseif ( $do == 'delete' ) {
		
		echo 'welcome page delete';
	} else {
		
		echo 'error there\'s no page with this name ';
	}

?>