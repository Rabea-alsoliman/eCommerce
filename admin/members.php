<?php  // #19
		/* 
		================================================
		== manage members page
		== you can add | edit | delete member from here 
		================================================
		*/
		session_start();

		$pageTitle = 'Members';

	if ( isset ( $_SESSION['Username'] )) {
		
		include 'init.php';

 		$do = isset($_GET['action']) ? $_GET['action'] : 'manage' ; 

 		// start manage page 
 		
 		if ($do == 'manage') {   // manage members page

 			//#42 manage pending  

 			$query = '';

 			if (isset($_GET['page']) && $_GET['page'] == 'pending' ) {

 				$query = 'AND RrgStatus = 0';
 			} 

 			// select all users except admin # 30

 			$stmt = $con->prepare("SELECT * FROM users WHERE GropID != 1 $query");

 			// execute this statement
 			
 			$stmt->execute(); 

 			// assign to variable

 			$rows = $stmt->fetchAll();
 		?>

 			<h1 class="text-center">Manage Members</h1> <!-- Start ======= #29 ======= -->

		 			<div class="container"> 
		 				<div class="table-responsive text-center">
		 				<table class="main-table table-center table table-bordered">
		 					<tr>
		 						<td>#ID</td>
		 						<td>Username</td>
		 						<td>Email</td>
		 						<td>Full Name</td>
		 						<td>Registerd Data</td>
		 						<td>Control</td>
		 					</tr>
								<?php  // ========== #30
									foreach($rows as $row) {

									echo "<tr>";
										echo "<td>".$row['UserID']."</td>"	;
										echo "<td>".$row['Username']."</td> "	;
										echo "<td>".$row['Email']."</td>"	;
										echo "<td>".$row['FullName']."</td>"	;
										echo "<td>".$row['Date']."</td> "	;
										echo " <td>
												<a href='members.php?action=edit&userid=".$row['UserID']." ' class='btn btn-success '>
												<i class='fa fa-edit'></i> Edit </a> 
												<a href='members.php?action=delete&userid=".$row['UserID']." ' class='btn btn-danger confirm'>
												<i class='fa fa-close'></i> Delete </a> ";	

												// #42 start
												if ($row['RrgStatus'] == 0) {

													echo "<a href='members.php?action=activate&userid=".$row['UserID']." ' class='btn btn-info '>
												<i class='fa fa-check'></i> Activate </a> ";
												// #42 end

												}	
											    echo "</td> "	; 
									echo "</tr>";
										
										}
								?>
		 				</table>	
		 				</div>
		 				<a href="members.php?action=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Members</a>
		 			</div> 
		 			<!-- End ======= #29 ======= -->
 		<?php  
 		} elseif ($do == 'Add') { // Add members page  
 		?>

 			<h1 class="text-center">Add New Member</h1> <!-- Start ======= #26 ======= -->
		 			<div class="container">
		 				<form class="form-horizontal" action="?action=insert" method="POST">
		 					
		 					<!-- start username filed -->
		 					<div class="form-group form-group-lg">
		 						<label class="col-sm-2 control-label">Username</label>
		 						<div class="col-sm-10 col-md-6">
		 							<input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="Username to login into shop">
		 						</div>
		 					</div>
		 					<!-- start username filed -->

		 					<!-- start Password filed -->
		 					<div class="form-group form-group-lg">
		 						<label class="col-sm-2 control-label">Password</label>
		 						<div class="col-sm-10 col-md-6">
		 							<input type="Password" name="password" class="password form-control" required="required" autocomplete="new-password" placeholder="Password must be hard & complex">
		 							<i class="show-pass fa fa-eye fa-2x"></i>
		 						</div>
		 					</div>
		 					<!-- start Password filed -->

		 					<!-- start Email filed -->
		 					<div class="form-group form-group-lg">
		 						<label class="col-sm-2 control-label">Email</label>
		 						<div class="col-sm-10 col-md-6">
		 							<input type="email" name="email" class="form-control" required="required" placeholder="Email must be valid">
		 						</div>
		 					</div>
		 					<!-- start Email filed -->

							<!-- start Full Name filed -->
		 					<div class="form-group form-group-lg">
		 						<label class="col-sm-2 control-label">Full Name</label>
		 						<div class="col-sm-10 col-md-6">
		 							<input type="text" name="full" class="form-control" required="required" placeholder="Full name appear in your profile page ">
		 						</div>
		 					</div>
		 					<!-- start Full Name filed -->	

		 					<!-- start submit filed -->
		 					<div class="form-group">
		 						<div class="col-sm-offset-2 col-sm-10">
		 							<input type="submit" value="Add Members" class="btn btn-primary btn-lg">
		 						</div>
		 					</div>
		 					<!-- start submit filed -->
		 				</form>
		 			</div> <!-- End ======= #26 ======= -->

 		<?php

 		} elseif ($do == 'insert') { // Insert members page  

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo '<h1 class="text-center">Insert Member</h1> ';
			
				echo "<div class='container'>";

				// Get the variable from the FORM

				$user 	= $_POST['username'];
				$pass 	= $_POST['password'];
				$email 	= $_POST['email'];
				$name 	= $_POST['full'];

				$hashpass = sha1($_POST['password']);

				// #27 validate the form 

				$formErrors = array( );

				if (strlen($user) < 4) {

					$formErrors[] = 'Username can\'t be less than <strong>4 characters</strong>';
				}

				if (strlen($user) > 20 ) {

					$formErrors[] = 'Username can\'t be more than <strong>20 characters</strong>';
				}

				if (empty($user)) {

					$formErrors[] = 'Password can\'t be <strong>Empty</strong>'; 
				}

				if (empty($pass)) {

					$formErrors[] = 'Username can\'t be <strong>Empty</strong>'; 
				}  

				if (empty($name)) {

					$formErrors[] = 'Full name can\'t be <strong>Empty</strong>'; 
				}

				if (empty($email)) {

					$formErrors[] = 'Email can\'t be <strong>Empty</strong> '; 
				}

				foreach ($formErrors as $error) {
					
					echo '<div class="alert alert-danger">'. $error . '</div>  ';
				}

				// Check if there's no error proceed the update operation 

				if (empty($formErrors)) { 

					// #34 check if user exist in database 

					$check = checkItem("Username", "users" , $user );

					if ($check == 1) {

						$theMsg = "<div class=' alert alert-danger'> Sorry this user is exist  </div>";
						redirectHome($theMsg, 'back');

					} else {

						// Insert info in database 
						
						$stmt = $con->prepare("INSERT INTO 
												users (Username, Password, Email, FullName, RrgStatus, Date ) 
												VALUES (:zuser, :zpass, :zmail, :zfull, 1, now() ) ");
						$stmt->execute(array(

							'zuser' => $user 	 ,
							'zpass' => $hashpass ,
							'zmail' => $email 	 ,
							'zfull' => $name  ));

						// echo success message 

						$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . '  Record inserted </div>';
						redirectHome($theMsg, 'back');
					}
				}

			} else {
				// #32 // #35
				
				echo " <div class='container'> ";	
				$theMsg = '<div class="container alert alert-danger"> sorry you can\'t browse page directly </div>';
				
				redirectHome($theMsg);
				echo "</div>";
			}
			
			echo "</div>";

 		} elseif ($do == 'edit') { // edit page  

			$userid = isset ($_GET['userid']) && is_numeric($_GET['userid']) ? intval ($_GET['userid']) : 0; //#21
			
				$stmt = $con->prepare(" SELECT * FROM users WHERE UserID = ? LIMIT 1");
				$stmt->execute(array($userid));
				$row = $stmt->fetch();
				$count = $stmt->rowCount(); 

				if ($stmt->rowCount() > 0) { ?>
			
		 			<h1 class="text-center">Edit Member</h1> <!-- Start ======= #20 ======= -->
		 			<div class="container">
		 				<form class="form-horizontal" action="?action=update" method="POST">
		 					<input type="hidden" name="userid" value="<?php echo $userid ?>">
		 					<!-- start username filed -->
		 					<div class="form-group form-group-lg">
		 						<label class="col-sm-2 control-label">Username</label>
		 						<div class="col-sm-10 col-md-6">
		 							<input type="text" name="username" class="form-control"  value="<?php echo $row['Username'] ?>" autocomplete="off" required="required">
		 						</div>
		 					</div>
		 					<!-- start username filed -->

		 					<!-- start Password filed -->
		 					<div class="form-group form-group-lg">
		 						<label class="col-sm-2 control-label">Password</label>
		 						<div class="col-sm-10 col-md-6">
		 							<input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>">
		 							<input type="Password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave lank if you don't want to change">
		 						</div>
		 					</div>
		 					<!-- start Password filed -->

		 					<!-- start Email filed -->
		 					<div class="form-group form-group-lg">
		 						<label class="col-sm-2 control-label">Email</label>
		 						<div class="col-sm-10 col-md-6">
		 							<input type="email" name="email" value="<?php echo $row['Email'] ?>" class="form-control" required="required">
		 						</div>
		 					</div>
		 					<!-- start Email filed -->

							<!-- start Full Name filed -->
		 					<div class="form-group form-group-lg">
		 						<label class="col-sm-2 control-label">Full Name</label>
		 						<div class="col-sm-10 col-md-6">
		 							<input type="text" name="full" value="<?php echo $row['FullName'] ?>" class="form-control" required="required">
		 						</div>
		 					</div>
		 					<!-- start Full Name filed -->	

		 					<!-- start submit filed -->
		 					<div class="form-group">
		 						<div class="col-sm-offset-2 col-sm-10">
		 							<input type="submit" value="Save" class="btn btn-primary btn-lg">
		 						</div>
		 					</div>
		 					<!-- start submit filed -->
		 				</form>
		 			</div> <!-- End ======= #20 ======= -->
			<?php 

				// if there's no such id show error message

				} else {
					
					echo "<div class= 'container'>";
					$theMsg = '<div class="alert alert-danger">There is no such ID </div>';
					redirectHome($theMsg);
					echo "</div>";
				}
			} elseif ($do == 'update') { // Update Page
				
				echo '<h1 class="text-center">Update Member</h1> ';
				echo "<div class='container'>";

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					// Get the variable from the FORM

					$id 	= $_POST['userid'];
					$user 	= $_POST['username'];
					$email 	= $_POST['email'];
					$name 	= $_POST['full'];


					// Password Trick

					// condition ? True : False

					$pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

					/*
					if (empty($_POST['newpassword'])) {

						$pass = $_POST['oldpassword'];

					} else {

						$pass = sha1($_POST['newpassword']);
					}
					*/

					// #24 validate the form 

					 /*  $formErrors = array( );

					 if (strlen($user) < 4) {

						$formErrors[] = '<div class="alert alert-danger">Username can\'t be less than <strong>4 characters</strong> </div>';
					}

					if (strlen($user) > 20 ) {

						$formErrors[] = '<div class="alert alert-danger">Username can\'t be more than <strong>20 characters</strong> </div>';
					}

					if (empty($user)) {

						$formErrors[] = '<div class="alert alert-danger">Username can\'t be <strong>Empty</strong> </div>'; 
					} 

					if (empty($name)) {

						$formErrors[] = '<div class="alert alert-danger">Full name can\'t be <strong>Empty</strong> </div>'; 
					}

					if (empty($email)) {

						$formErrors[] = '<div class="alert alert-danger">Email can\'t be <strong>Empty</strong> </div>'; 
					}

					foreach ($formErrors as $error) {
						
						echo $error  ;
					} */ 
				// #27
				$formErrors = array( );  

					if (strlen($user) < 4) {

						$formErrors[] = 'Username can\'t be less than <strong>4 characters</strong>';
					}

					if (strlen($user) > 20 ) {

						$formErrors[] = 'Username can\'t be more than <strong>20 characters</strong>';
					}

					if (empty($user)) {

						$formErrors[] = 'Username can\'t be <strong>Empty</strong>'; 
					} 

					if (empty($name)) {

						$formErrors[] = 'Full name can\'t be <strong>Empty</strong>'; 
					}

					if (empty($email)) {

						$formErrors[] = 'Email can\'t be <strong>Empty</strong> '; 
					}

					foreach ($formErrors as $error) {
						
						echo '<div class="alert alert-danger">'. $error . '</div>  ';
					}



					// Check if there's no error proceed the update operation 

					if (empty($formErrors)) {

						// Update the database with this info

						$stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?");
						$stmt->execute(array($user, $email, $name, $pass, $id ));

						// echo success message 

						$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . '  Record Update </div>';

						redirectHome($theMsg,'back');

					}

					

				} else {

					$theMsg = " <div class='alert alert-danger'> sorry you cant browse page directly </div> ";
					redirectHome($theMsg);
				}
				
				echo "</div>";
			} elseif ($do =='delete') { // Delete members page ======= #31 

				// check if get request userid is numeric and get the integer vqlue of it 

				echo '<h1 class="text-center">Delete Member</h1> ';
				echo "<div class='container'>";

				$userid = isset ($_GET['userid']) && is_numeric($_GET['userid']) ? intval ($_GET['userid']) : 0; //#21
				
				// select all data depend on this ID 

				// #38
				$check = checkItem('userid', 'users', $userid );

				// if there's such ID show the form

			    if ( $check > 0 )  { 

					$stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");
					$stmt->bindParam(":zuser" , $userid); // bind = ربط 
					$stmt->execute();
					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . '  Record Delete </div>';

					redirectHome($theMsg, 'back');

				} else { 

					$theMsg = "<div class='alert alert-danger'> ID is not exist </div>";
					redirectHome($theMsg); 
				}
		} elseif ($do =='activate') { // Activate members page ======= #43 

				// check if get request userid is numeric and get the integer vqlue of it 

				echo '<h1 class="text-center">Activate Member</h1> ';
				echo "<div class='container'>";

				$userid = isset ($_GET['userid']) && is_numeric($_GET['userid']) ? intval ($_GET['userid']) : 0; //#21
				
				// select all data depend on this ID 

				// #38
				$check = checkItem('userid', 'users', $userid );

				// if there's such ID show the form

			    if ( $check > 0 )  { 

					$stmt = $con->prepare("UPDATE  users SET RrgStatus = 1 WHERE UserID = ?");
					$stmt->execute(array($userid)); // عملت تنفيذ لهذه الأري مشان اربط اليوزر أي دي بعلامة الاستفهام 
					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . '  Record Updated </div>';

					redirectHome($theMsg);

				} else { 

					$theMsg = "<div class='alert alert-danger'> ID is not exist </div>";
					redirectHome($theMsg); 
				}
		}

		include $tpl . 'footer.php';

	} else { header('location: index.php'); exit(); } 
 ?>