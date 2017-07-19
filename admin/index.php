<?php 
	session_start();
	$noNavbar = '';
	$pageTitle = 'Login';
	if (isset ($_SESSION['Username'])) {

		 header('Location: dashboard.php');
	}
	include 'init.php';

	// check if user coming from HTTP post request 

	if($_SERVER['REQUEST_METHOD'] == 'POST') {

		$username = $_POST['user'];
		$password = $_POST['pass'];
		$hashedPass = sha1($password);// for eشfer the password
		
		// check if the user exist database 
		// statement
		/* prepare statment is ist3lam be3ml 7esabat befor ma inter the database 
		  for securty man3 very much from thakharat	*/
		$stmt = $con->prepare(" SELECT 
									UserID, Username, Password 
								FROM 
									users 
								WHERE 
									Username =? 
								AND 
									Password =? 
								AND 
									GropID = 1
								LIMIT 1 "	);
		$stmt->execute(array($username, $hashedPass));
		$row = $stmt->fetch();
		$count = $stmt->rowCount(); 

		// if count > 0 this mean the database contain record about this username
		
		if ($count > 0 ) {

			$_SESSION['Username'] = $username; // register session name 
			$_SESSION['ID'] = $row['UserID']; // #19
			header('Location: dashboard.php'); // redirect to dashboard page 
			exit(); // for stoped and no complete the script
		}
		

	}
	
?>
	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method='POST' > 
		<h4 class="text-center ">Admin Login</h4>	
		<input class="form-control input-lg" type="text" name="user" placeholder="Username" autocomplete="off" />
		<input class="form-control input-lg" type="password" name="pass" placeholder="Password" autocomplete="new-password"/>
		<input class="btn btn-lg btn-primary btn-block" type="submit"  value="login" />
	</form>
	


<?php include $tpl . 'footer.php';?>