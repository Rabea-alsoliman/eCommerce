<?php  // start #61
		/* 
		================================================
		==  Items Page 
		================================================
		*/

		ob_start();

		session_start();

		$pageTitle = 'Items';

		if ( isset ( $_SESSION['Username'] )) {
		
		include 'init.php';

 		$do = isset($_GET['action']) ? $_GET['action'] : 'manage' ; 

 		
 		if ($do == 'manage') {  // #67


 			$stmt = $con->prepare("SELECT 
 										items.*,
 										categories.Name AS Cat_Name, 
 										users.Username 
 								   FROM 
 								   		items 
 								   INNER JOIN 
 								   		categories 
 								   ON 
 								   		categories.ID = items.Cat_ID
 				INNER JOIN users ON users.UserID = items.Member_ID; ");

 			// execute this statement
 			
 			$stmt->execute(); 

 			// assign to variable

 			$items = $stmt->fetchAll();
 		?>

 			<h1 class="text-center">Manage Items</h1> 

		 			<div class="container"> 
		 				<div class="table-responsive text-center">
		 				<table class="main-table table-center table table-bordered">
		 					<tr>
		 						<td>#ID</td>
		 						<td>Name</td>
		 						<td>Description</td>
		 						<td>Price</td>
		 						<td>Adding Data</td>
		 						<td>Categories</td>
		 						<td>Username</td>
		 						<td>Control</td>
		 					</tr>
								<?php  
									foreach($items as $item) {

									echo "<tr>";
										echo "<td>".$item['item_ID']."</td>"	;
										echo "<td>".$item['Name']."</td> "	;
										echo "<td>".$item['Description']."</td>"	;
										echo "<td>".$item['Price']."</td>"	;
										echo "<td>".$item['Add_Date']."</td> "	;
										echo "<td>".$item['Cat_Name']."</td> "	;
										echo "<td>".$item['Username']."</td> "	;
										echo " <td>
												<a href='items.php?action=edit&itemid=".$item['item_ID']." ' class='btn btn-success '>
												<i class='fa fa-edit'></i> Edit </a> 
												<a href='items.php?action=delete&itemid=".$item['item_ID']." ' class='btn btn-danger confirm'>
												<i class='fa fa-close'></i> Delete </a> ";	
												if ($item['Approve'] == 0) { // start #72

												echo "<a 
												   href='items.php?action=approve&itemid=".$item['item_ID']." ' class='btn btn-info '>
												<i class='fa fa-check'></i> Approve </a> ";
											} // end # 72 
										echo "</td> "	; 
									echo "</tr>";
									}			
								?>
		 				</table>	
		 				</div>
		 				<a href="items.php?action=add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> New item</a>
		 			</div> 
		 			<!-- End ======= #29 ======= -->
 		</div> <!-- End ======= #26 ======= -->

 		<?php

 		} elseif ($do == 'add') {  ?> <!-- #61 -->

 			<h1 class="text-center">Add New Item</h1> <!-- Start ======= #49 ======= -->
		 			<div class="container">
		 				<form class="form-horizontal" action="?action=insert" method="POST">
		 					
		 					<!-- start Name filed -->
		 					<div class="form-group form-group-lg">
		 						<label class="col-sm-2 control-label">Name</label>
		 						<div class="col-sm-10 col-md-6">
		 							<input 
		 								type="text" 
		 								name="name" 
		 								class="form-control"  
		 								 
		 								placeholder="Name of the item" />
		 						</div>
		 					</div>
		 					<!-- start Name filed -->

		 					<!-- start Description filed -->
		 					<div class="form-group form-group-lg">
		 						<label class="col-sm-2 control-label">Description</label>
		 						<div class="col-sm-10 col-md-6">
		 							<input 
		 								type="text" 
		 								name="description" 
		 								class="form-control"  
		 								
		 								placeholder="Description of the item" />
		 						</div>
		 					</div>
		 					<!-- start Description filed -->

		 					<!-- start Price filed -->
		 					<div class="form-group form-group-lg">
		 						<label class="col-sm-2 control-label">Price</label>
		 						<div class="col-sm-10 col-md-6">
		 							<input 
		 								type="text" 
		 								name="price" 
		 								class="form-control"  
		 								 
		 								placeholder="Price of the item" />
		 						</div>
		 					</div>
		 					<!-- start Price filed -->

		 					<!-- start Country filed -->
		 					<div class="form-group form-group-lg">
		 						<label class="col-sm-2 control-label">Country</label>
		 						<div class="col-sm-10 col-md-6">
		 							<input 
		 								type="text" 
		 								name="country" 
		 								class="form-control"  
		 								placeholder="Country of made" />
		 						</div>
		 					</div>
		 					<!-- start Country filed -->

		 					<!-- start Status filed -->
		 					<div class="form-group form-group-lg">
		 						<label class="col-sm-2 control-label">Status</label>
		 						<div class="col-sm-10 col-md-6">
		 							<select  name="status" >
		 								<option value="0">...</option>
		 								<option value="1">New</option>
		 								<option value="2">Like New</option>
		 								<option value="3">Used</option>
		 								<option value="4">Very Old</option>
		 							</select>
		 						</div>
		 					</div>
		 					<!-- start Status filed -->

		 					<!-- start members filed -->
		 					<div class="form-group form-group-lg">
		 						<label class="col-sm-2 control-label">Members</label>
		 						<div class="col-sm-10 col-md-6">
		 							<select  name="member" >
		 								<option value="0">...</option>
		 								<?php 
		 									$stmt = $con->prepare("SELECT * FROM users ");
		 									$stmt->execute();
		 									$users = $stmt->fetchAll();
		 									foreach ($users as $user) {

		 										echo "<option value='".$user['UserID']."'>".$user['Username']."</option>";
		 									}
		 								 ?>
		 							</select>
		 						</div>
		 					</div>
		 					<!-- start members filed -->

							<!-- start categories filed -->
		 					<div class="form-group form-group-lg">
		 						<label class="col-sm-2 control-label">Category</label>
		 						<div class="col-sm-10 col-md-6">
		 							<select  name="category" >
		 								<option value="0">...</option>
		 								<?php 
		 									$stmt2 = $con->prepare("SELECT * FROM categories ");
		 									$stmt2->execute();
		 									$cats = $stmt2->fetchAll();
		 									foreach ($cats as $cat) {

		 										echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";
		 									}
		 								 ?>
		 							</select>
		 						</div>
		 					</div>
		 					<!-- start categories filed -->
							
		 					<!-- start submit filed -->
		 					<div class="form-group">
		 						<div class="col-sm-offset-2 col-sm-10">
		 							<input type="submit" value="Add New Item" class="btn btn-primary btn-md">
		 						</div>
		 					</div>
		 					<!-- end submit filed -->
		 				</form>
		 			</div> 

 		<?php

 		} elseif ($do == 'insert') { // #63

 			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo '<h1 class="text-center">Insert Item</h1> ';
			
				echo "<div class='container'>";

				// Get the variable from the FORM

				$name 		= $_POST['name'];
				$desc 		= $_POST['description'];
				$price 		= $_POST['price'];
				$country 	= $_POST['country'];
				$status 	= $_POST['status'];
				$member 	= $_POST['member'];
				$cat		= $_POST['category'];
				
				// validate the form 

				$formErrors = array( );

				if (empty($name)) {

					$formErrors[] = 'Name can\'t be  <strong>empty</strong>';
				}

				if (empty($desc))  {

					$formErrors[] = 'Description can\'t be  <strong>empty</strong>';
				}

				if (empty($price)) {

					$formErrors[] = 'Price can\'t be  <strong>empty</strong>'; 
				}

				if (empty($country)) {

					$formErrors[] = 'Country can\'t be  <strong>empty</strong>'; 
				}  

				if ($status == 0) {

					$formErrors[] = 'You must choose the  <strong>status</strong>'; 
				}

				if ($member == 0) {

					$formErrors[] = 'You must choose the  <strong>Member</strong>'; 
				}

				if ($cat == 0) {

					$formErrors[] = 'You must choose the  <strong>Category</strong>'; 
				}

				foreach ($formErrors as $error) {
					
					echo '<div class="alert alert-danger">'. $error . '</div>  ';
				}

				// Check if there's no error proceed the update operation 

				if (empty($formErrors)) {

					// Insert info in database 
					
					$stmt = $con->prepare("INSERT INTO 

							items(Name, Description, Price, Country_Made, Status, Add_Date, Member_ID,Cat_ID ) 

							VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zmember, :zcat)");
					$stmt->execute(array(

						'zname'		=>	$name, 		
						'zdesc'		=>	$desc, 		
						'zprice'	=>	$price, 		
						'zcountry'	=>	$country, 	
						'zstatus'	=>	$status,
						'zmember'	=>	$member, 
						'zcat'		=>	$cat
						

						));	

					// echo success message 

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . '  Record inserted </div>';
					redirectHome($theMsg, 'back');
					}
				

			} else {
				
				
				echo " <div class='container'> ";	
				$theMsg = '<div class="container alert alert-danger"> sorry you can\'t browse page directly </div>';
				
				redirectHome($theMsg);
				echo "</div>";
			}
			
			echo "</div>";

 		} elseif ($do == 'edit') { // #69

 			// check if get request itme is numeric and get its integer value 

 			$itemid = isset ($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval ($_GET['itemid']) : 0; //#21
			
				// select all data depend on this ID 

				$stmt = $con->prepare(" SELECT * FROM items WHERE item_ID = ?");

				// execute query 

				$stmt->execute(array($itemid));
				
				// fetch tha data 

				$item = $stmt->fetch();
				  
				// the row count 
				  
				$count = $stmt->rowCount(); 

				// there's such ID show the form 

				if ($stmt->rowCount() > 0) { ?>
				
					<h1 class="text-center">Edit Item</h1> 
			 			<div class="container">
			 				<form class="form-horizontal" action="?action=update" method="POST">
			 					<input type="hidden" name="itemid" value="<?php echo $itemid ?>">	
			 					<!-- start Name filed -->
			 					<div class="form-group form-group-lg">
			 						<label class="col-sm-2 control-label">Name</label>
			 						<div class="col-sm-10 col-md-6">
			 							<input 
			 								type="text" 
			 								name="name" 
			 								class="form-control"  			 								 
			 								placeholder="Name of the item" 
			 								value=" <?php echo $item['Name'] ?> " />
			 						</div>
			 					</div>
			 					<!-- start Name filed -->

			 					<!-- start Description filed -->
			 					<div class="form-group form-group-lg">
			 						<label class="col-sm-2 control-label">Description</label>
			 						<div class="col-sm-10 col-md-6">
			 							<input 
			 								type="text" 
			 								name="description" 
			 								class="form-control"  
			 								
			 								placeholder="Description of the item" 
			 								value=" <?php echo $item['Description'] ?> " />
			 						</div>
			 					</div>
			 					<!-- start Description filed -->

			 					<!-- start Price filed -->
			 					<div class="form-group form-group-lg">
			 						<label class="col-sm-2 control-label">Price</label>
			 						<div class="col-sm-10 col-md-6">
			 							<input 
			 								type="text" 
			 								name="price" 
			 								class="form-control"  			 								 
			 								placeholder="Price of the item" 
			 								value=" <?php echo $item['Price'] ?> "/>
			 						</div>
			 					</div>
			 					<!-- start Price filed -->

			 					<!-- start Country filed -->
			 					<div class="form-group form-group-lg">
			 						<label class="col-sm-2 control-label">Country</label>
			 						<div class="col-sm-10 col-md-6">
			 							<input 
			 								type="text" 
			 								name="country" 
			 								class="form-control"  
			 								placeholder="Country of made" 
			 								value=" <?php echo $item['Country_Made'] ?> " />
			 						</div>
			 					</div>
			 					<!-- start Country filed -->

			 					<!-- start Status filed -->
			 					<div class="form-group form-group-lg">
			 						<label class="col-sm-2 control-label">Status</label>
			 						<div class="col-sm-10 col-md-6">
			 							<select  name="status" >
			 								<option value="0"  { echo 'selected'; } ?>>...</option>
			 								<option value="1" <?php if ($item['Status'] == 1) { echo 'selected'; } ?>>New</option>
			 								<option value="2" <?php if ($item['Status'] == 2) { echo 'selected'; } ?>>Like New</option>
			 								<option value="3" <?php if ($item['Status'] == 3) { echo 'selected'; } ?>>Used</option>
			 								<option value="4" <?php if ($item['Status'] == 4) { echo 'selected'; } ?>>Very Old</option>
			 							</select>
			 						</div>
			 					</div>
			 					<!-- start Status filed -->

			 					<!-- start members filed -->
			 					<div class="form-group form-group-lg">
			 						<label class="col-sm-2 control-label">Members</label>
			 						<div class="col-sm-10 col-md-6">
			 							<select  name="member" >
			 								<option value="0">...</option>
			 								<?php 
			 									$stmt = $con->prepare("SELECT * FROM users ");
			 									$stmt->execute();
			 									$users = $stmt->fetchAll();
			 									foreach ($users as $user) {

			 										echo "<option value='".$user['UserID']."'"; 
			 										if ($item['Member_ID'] == $user['UserID']) { echo 'selected';} 
			 										echo ">".$user['Username']."</option>";
			 									}
			 								 ?>
			 							</select>
			 						</div>
			 					</div>
			 					<!-- start members filed -->

								<!-- start categories filed -->
			 					<div class="form-group form-group-lg">
			 						<label class="col-sm-2 control-label">Category</label>
			 						<div class="col-sm-10 col-md-6">
			 							<select  name="category" >
			 								<option value="0">...</option>
			 								<?php 
			 									$stmt2 = $con->prepare("SELECT * FROM categories ");
			 									$stmt2->execute();
			 									$cats = $stmt2->fetchAll();
			 									foreach ($cats as $cat) {

			 										echo "<option value='".$cat['ID']."'"; 
			 										if ($item['Cat_ID'] == $cat['ID']) { echo 'selected';} 
			 										echo ">".$cat['Name']."</option>";
			 									}
			 								 ?>
			 							</select>
			 						</div>
			 					</div>
			 					<!-- start categories filed -->
								
			 					<!-- start submit filed -->
			 					<div class="form-group">
			 						<div class="col-sm-offset-2 col-sm-10">
			 							<input type="submit" value="Save Item" class="btn btn-primary btn-md">
			 						</div>
			 					</div>
			 					<!-- end submit filed -->
			 				</form>

			 				<?php

			 				// select all users except admin 

				 			$stmt = $con->prepare("SELECT 
				 										comments.*, users.Username AS Member 
				 									FROM 
				 										comments
				 								
				 									INNER JOIN 
				 										users 
				 									ON 
				 										users.UserID = comments.user_id 
													WHERE 
														item_id = ?		
				 										");

				 			// execute this statement
				 			
				 			$stmt->execute(array($itemid)); 

				 			// assign to variable

				 			$rows = $stmt->fetchAll();

				 			if (! empty($rows)) {
				 			
				 			?>

				 			<h1 class="text-center">Manage [ <?php echo $item['Name'] ?> ] Comments</h1> 
				 				<div class="table-responsive text-center">
				 					<table class="main-table table-center table table-bordered">
					 					<tr>
					 						<td>Comments </td>
					 						<td>User Name </td>
					 						<td>Added Data </td>
					 						<td>Control </td>
					 					</tr>
											<?php  // ========== #30
												foreach($rows as $row) {

												echo "<tr>";
													echo "<td>". $row['comment']."</td> ";
													echo "<td>". $row['Member'] ."</td>";
													echo "<td>". $row['comment_date']."</td>";
													echo "<td>
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
				 					</table>	
				 				</div>


								<?php }

									// if there's no such id show error message

									} else {
										
										echo "<div class= 'container'>";
										$theMsg = '<div class="alert alert-danger">There is no such ID </div>';
										redirectHome($theMsg);
										echo "</div>";
									}

 		} elseif ($do == 'update') {  // #70

 			echo '<h1 class="text-center">Update Item</h1> ';
			echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				// Get the variable from the FORM

				$id 		= $_POST['itemid'];
				$name 		= $_POST['name'];
				$desc 		= $_POST['description'];
				$price 		= $_POST['price'];
				$country 	= $_POST['country'];
				$status 	= $_POST['status'];
				$cat 		= $_POST['category'];
				$member 	= $_POST['member'];
				

				// Validate the form 

				$formErrors = array( );

				if (empty($name)) {

					$formErrors[] = 'Name can\'t be  <strong>empty</strong>';
				}

				if (empty($desc))  {

					$formErrors[] = 'Description can\'t be  <strong>empty</strong>';
				}

				if (empty($price)) {

					$formErrors[] = 'Price can\'t be  <strong>empty</strong>'; 
				}

				if (empty($country)) {

					$formErrors[] = 'Country can\'t be  <strong>empty</strong>'; 
				}  

				if ($status == 0) {

					$formErrors[] = 'You must choose the  <strong>status</strong>'; 
				}

				if ($member == 0) {

					$formErrors[] = 'You must choose the  <strong>Member</strong>'; 
				}

				if ($cat == 0) {

					$formErrors[] = 'You must choose the  <strong>Category</strong>'; 
				}

				foreach ($formErrors as $error) {
					
					echo '<div class="alert alert-danger">'. $error . '</div>  ';
				}

				// Check if there's no error proceed the update operation 

				if (empty($formErrors)) {

					// Update the database with this info

					$stmt = $con->prepare(" UPDATE 
												items 
											SET 
												name = ?, 
												Description = ?, 
												Price = ?, 
												Country_Made = ?,
												Status = ?,
												Cat_ID = ?,
												Member_ID = ?

											WHERE 
												item_ID = ?");
					$stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $id ));

					// echo success message 

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . '  Record Update </div>';

					redirectHome($theMsg,'back');

				}

				} else {

					$theMsg = " <div class='alert alert-danger'> sorry you cant browse page directly </div> ";
					redirectHome($theMsg);
				}
				
				echo "</div>";

 		} elseif ($do == 'delete') { // #71

 			// check if get request itemid is numeric and get the integer vqlue of it 

				echo '<h1 class="text-center">Delete Item</h1> ';
				echo "<div class='container'>";

				$itemid = isset ($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval ($_GET['itemid']) : 0; //#21
				
				// select all data depend on this ID 

				// #38
				$check = checkItem('item_ID', 'items', $itemid );

				// if there's such ID show the form

			    if ( $check > 0 )  { 

					$stmt = $con->prepare("DELETE FROM items WHERE item_ID = :zid");
					$stmt->bindParam(":zid" , $itemid); // bind = ربط 
					$stmt->execute();
					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . '  Record Delete </div>';

					redirectHome($theMsg, 'back');

				} else { 

					$theMsg = "<div class='alert alert-danger'> ID is not exist </div>";
					redirectHome($theMsg); 
				}
			echo '</div>';

 		} elseif ($do == 'approve') {	// #72 

 			// check if get request item id is numeric and get the integer vqlue of it 

				echo '<h1 class="text-center">Approve Item</h1> ';
				echo "<div class='container'>";

				$itemid = isset ($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval ($_GET['itemid']) : 0; //#21
				
				// select all data depend on this ID 

				// #38
				$check = checkItem('item_ID', 'items', $itemid );

				// if there's such ID show the form

			    if ( $check > 0 )  { 

					$stmt = $con->prepare("UPDATE  items SET Approve = 1 WHERE item_ID = ?");
					$stmt->execute(array($itemid)); // عملت تنفيذ لهذه الأري مشان اربط اليوزر أي دي بعلامة الاستفهام 
					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . '  Record Updated </div>';

					redirectHome($theMsg, 'back');

				} else { 

					$theMsg = "<div class='alert alert-danger'> ID is not exist </div>";
					redirectHome($theMsg); 
				}

 		}

 		include $tpl . 'footer.php';

 	} else { 

 		header('location: index.php');

 		exit();

 	}

 		ob_end_flush(); // release output

 		
 		?>