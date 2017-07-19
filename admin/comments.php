<?php  // #76
		/* 
		================================================
		== Manage Comments Page
		== You Can  Edit | Delete | Approve Comments from here 
		================================================
		*/
		session_start();

		$pageTitle = 'Comments';

	if ( isset ( $_SESSION['Username'] )) {
		
		include 'init.php';

 		$do = isset($_GET['action']) ? $_GET['action'] : 'manage' ; 

 		// start manage page 
 		
 		if ($do == 'manage') {   // manage Comments page
 

 			// select all users except admin 

 			$stmt = $con->prepare("SELECT 
 										comments.*, items.Name AS Item_Name, users.Username AS Member 
 									FROM 
 										comments
 									INNER JOIN 
 										items 
 									ON 
 										items.item_ID = comments.item_id 
 									INNER JOIN 
 										users 
 									ON 
 										users.UserID = comments.user_id ");

 			// execute this statement
 			
 			$stmt->execute(); 

 			// assign to variable

 			$rows = $stmt->fetchAll();
 		?>

 			<h1 class="text-center">Manage Comments</h1>

		 			<div class="container"> 
		 				<div class="table-responsive text-center">
		 				<table class="main-table table-center table table-bordered">
		 					<tr>
		 						<td>ID</td>
		 						<td>Comments</td>
		 						<td>Item Name</td>
		 						<td>User Name</td>
		 						<td>Added Data</td>
		 						<td>Control</td>
		 					</tr>
								<?php  // ========== #30
									foreach($rows as $row) {

									echo "<tr>";
										echo "<td>".$row['c_id']."</td>";
										echo "<td>".$row['comment']."</td> ";
										echo "<td>".$row['Item_Name']."</td>";
										echo "<td>".$row['Member']."</td>";
										echo "<td>".$row['comment_date']."</td>";
										echo " <td>
												<a href='comments.php?action=edit&comid=".$row['c_id']." ' class='btn btn-success '>
												<i class='fa fa-edit'></i> Edit </a> 
												<a href='comments.php?action=delete&comid=".$row['c_id']." ' class='btn btn-danger confirm'>
												<i class='fa fa-close'></i> Delete </a> ";	

												// #42 start
												if ($row['status'] == 0) {

													echo "<a href='comments.php?action=approve&comid=".$row['c_id']." ' class='btn btn-info '>
												<i class='fa fa-check'></i> Approve </a> ";
												// #42 end

												}	
											    echo "</td> "	; 
									echo "</tr>";
										
										}
								?>
								<tr>
		 				</table>	
		 				</div>
		 			</div> 
		 			
 		<?php

 		}  elseif ($do == 'edit') { // #77 edit page   

			$comid = isset ($_GET['comid']) && is_numeric($_GET['comid']) ? intval ($_GET['comid']) : 0; //#21
			
				$stmt = $con->prepare(" SELECT * FROM comments WHERE c_id = ?");
				$stmt->execute(array($comid));
				$row = $stmt->fetch();
				$count = $stmt->rowCount(); 

				if ($stmt->rowCount() > 0) { ?>
			
		 			<h1 class="text-center">Edit Comments</h1> <!-- Start ======= #20 ======= -->
		 			<div class="container">
		 				<form class="form-horizontal" action="?action=update" method="POST">
		 					<input type="hidden" name="comid" value="<?php echo $comid ?>">
		 					<!-- start Comment filed -->
		 					<div class="form-group form-group-lg">
		 						<label class="col-sm-2 control-label">Comment</label>
		 						<div class="col-sm-10 col-md-6">
		 							<textarea class="form-control" name="comment"><?php echo $row['comment'] ?> </textarea> 
		 						</div>
		 					</div>
							<!-- End Comment filed -->

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
				
				echo '<h1 class="text-center">Update Comment</h1> ';
				echo "<div class='container'>";

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					// Get the variable from the FORM

					$comid 		= $_POST['comid'];
					$comment 	= $_POST['comment'];

					// Update the database with this info

					$stmt = $con->prepare("UPDATE comments SET comment = ? WHERE c_id = ?");
					$stmt->execute(array($comment, $comid ));

					// echo success message 

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . '  Record Update </div>';

					redirectHome($theMsg,'back');			

				} else {

					$theMsg = " <div class='alert alert-danger'> sorry you cant browse page directly </div> ";
					redirectHome($theMsg);
				}
				
				echo "</div>";
			} elseif ($do =='delete') { // Delete comment

				// check if get request comid is numeric and get the integer vqlue of it 

				echo '<h1 class="text-center">Delete Comment</h1> ';

				echo "<div class='container'>";

				$comid = isset ($_GET['comid']) && is_numeric($_GET['comid']) ? intval ($_GET['comid']) : 0; //#21
				
				// select all data depend on this ID 

				// #38
				$check = checkItem('c_id', 'comments', $comid );

				// if there's such ID show the form

			    if ( $check > 0 )  { 

					$stmt = $con->prepare("DELETE FROM comments WHERE c_id = :zid");
					$stmt->bindParam(":zid" , $comid); // bind = ربط 
					$stmt->execute();
					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . '  Record Delete </div>';

					redirectHome($theMsg, 'back');

				} else { 

					$theMsg = "<div class='alert alert-danger'> ID is not exist </div>";
					redirectHome($theMsg); 
				}
		} elseif ($do =='approve') { // 

				// check if get request userid is numeric and get the integer vqlue of it 

				echo '<h1 class="text-center">Approve Comment</h1> ';
				
				echo "<div class='container'>";

				$comid = isset ($_GET['comid']) && is_numeric($_GET['comid']) ? intval ($_GET['comid']) : 0; //#21
				
				// select all data depend on this ID 

				// #38
				$check = checkItem('c_id', 'comments', $comid );

				// if there's such ID show the form

			    if ( $check > 0 )  { 

					$stmt = $con->prepare("UPDATE  comments SET status = 1 WHERE c_id = ?");
					
					$stmt->execute(array($comid)); // عملت تنفيذ لهذه الأري مشان اربط اليوزر أي دي بعلامة الاستفهام 
					
					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . '  Record Approve </div>';

					redirectHome($theMsg, 'back');

				} else { 

					$theMsg = "<div class='alert alert-danger'> ID is not exist </div>";
					redirectHome($theMsg); 
				}
		}

		include $tpl . 'footer.php';

	} else { header('location: index.php'); exit(); } 
 ?>