<?php  // #49

	/* 
	================================================
	==  categories Page 
	================================================
	*/

	ob_start();

	session_start();

	$pageTitle = 'Categories';

	if ( isset ( $_SESSION['Username'] )) {
	
		include 'init.php';

 		$do = isset($_GET['action']) ? $_GET['action'] : 'manage' ; 

 		
 		if ($do == 'manage') {  //#51 ,#52

 			$sort = 'asc'; // #54 

 			$sort_array = array('asc', 'desc');

 			if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {

 				$sort = $_GET['sort'];

 			}

 			$stat2 = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");

 			$stat2->execute();

 			$cats = $stat2->fetchall(); ?>

 			<h1 class="text-center">Manage Categories</h1>
 			<div class="container categories">
 				<div class="panel panel-default">
 					<div class="panel-heading">
 						<i class="fa fa-edit"></i> Manage Categories
 						<div class="option pull-right"> <!-- #54 -->
 							<i class="fa fa-sort"></i> Ordering: [
 							<a class=" <?php if($sort == 'asc') {echo 'active';} ?> " href="?sort=asc">Asc</a>  |
 							<a class=" <?php if($sort == 'desc') {echo 'active';} ?> " href="?sort=desc">Desc</a> ]
 							<i class="fa fa-eye"></i> View: [
 							<span class="active" data-view='full'>Full</span> |
 							<span data-view='classic'>Classic</span> ]
 						</div>
 					</div>
					<div class="panel-body">
						<?php

							foreach($cats as $cat) {

								echo "<div class='cat'>";
									echo "<div class='hidden-buttons'>";
										echo "<a href='categories.php?action=edit&catid=" . $cat['ID'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
										echo "<a href='categories.php?action=delete&catid=" . $cat['ID'] . "' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i> Delete</a>";
									echo "</div>";
									echo '<h3>' . $cat['Name'] . '</h3>';
									echo "<div class='full-view'>";
										echo "<p>"; if ($cat['Description'] == '') { echo 'This categories has no description';} else {echo $cat['Description'];} echo"</p>";
										if ($cat['Visibility'] == 1) { echo'<span class="visibility"><i class="fa fa-eye"></i> Hidden </span>'; }
										if ($cat['Allow_Comment'] == 1) { echo'<span class="commenting"><i class="fa fa-close"></i> Comment Disable </span>'; }
										if ($cat['Allow_Ads'] == 1) { echo'<span class="advertises"><i class="fa fa-close"></i> Ads Disable </span>'; }
									echo "</div>";
								echo "</div>";
								echo "<hr>";
							}

						?>
					</div>
				</div>	
				<a class="add-gategory btn btn-primary" href="categories.php?action=add"> <i class="fa fa-plus"></i> New  Categories</a>
			</div>		


 			<?php 

 		} elseif ($do == 'add') { //#49 ?>

 			<h1 class="text-center">Add New Category </h1> <!-- Start ======= #49 ======= -->
		 			<div class="container">
		 				<form class="form-horizontal" action="?action=insert" method="POST">
		 					
		 					<!-- start Name filed -->
		 					<div class="form-group form-group-lg">
		 						<label class="col-sm-2 control-label">Name</label>
		 						<div class="col-sm-10 col-md-6">
		 							<input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Name of the category">
		 						</div>
		 					</div>
		 					<!-- start Name filed -->

		 					<!-- start description filed -->
		 					<div class="form-group form-group-lg">
		 						<label class="col-sm-2 control-label">Description</label>
		 						<div class="col-sm-10 col-md-6">
		 							<input type="text" name="description" class=" form-control" placeholder="Describe the category"> 	
		 						</div>
		 					</div>
		 					<!-- end description filed -->

		 					<!-- start ordering filed -->
		 					<div class="form-group form-group-lg">
		 						<label class="col-sm-2 control-label">Ordering</label>
		 						<div class="col-sm-10 col-md-6">
		 							<input type="text" name="ordering" class="form-control"  placeholder="Number to arrange the categories">
		 						</div>
		 					</div>
		 					<!-- end ordering filed -->

							<!-- start visibility filed -->
		 					<div class="form-group form-group-lg">
		 						<label class="col-sm-2 control-label">Visibile</label>
		 						<div class="col-sm-10 col-md-6">
		 							<div>
		 								<input id="vis-yes" type="radio" name="visibility" value="0" checked />
		 								<label for="vis-yes">Yes</label>
		 							</div>
		 							<div>
		 								<input id="vis-no" type="radio" name="visibility" value="1"/>
		 								<label for="vis-no">No</label>
		 							</div>
		 						</div>
		 					</div>
		 					<!-- end visibility filed -->

		 					<!-- start commenting filed -->
		 					<div class="form-group form-group-lg">
		 						<label class="col-sm-2 control-label">Allow Commenting</label>
		 						<div class="col-sm-10 col-md-6">
		 							<div>
		 								<input id="com-yes" type="radio" name="commenting" value="0" checked />
		 								<label for="com-yes">Yes</label>
		 							</div>
		 							<div>
		 								<input id="com-no" type="radio" name="commenting" value="1"/>
		 								<label for="com-no">No</label>
		 							</div>
		 						</div>
		 					</div>
		 					<!-- end commenting filed -->	

		 					<!-- start ads filed -->
		 					<div class="form-group form-group-lg">
		 						<label class="col-sm-2 control-label">Allow Advertising</label>
		 						<div class="col-sm-10 col-md-6">
		 							<div>
		 								<input id="ads-yes" type="radio" name="advertising" value="0" checked />
		 								<label for="ads-yes">Yes</label>
		 							</div>
		 							<div>
		 								<input id="ads-no" type="radio" name="advertising" value="1"/>
		 								<label for="ads-no">No</label>
		 							</div>
		 						</div>
		 					</div>
		 					<!-- end ads filed -->		

		 					<!-- start submit filed -->
		 					<div class="form-group">
		 						<div class="col-sm-offset-2 col-sm-10">
		 							<input type="submit" value="Add Category" class="btn btn-primary btn-lg">
		 						</div>
		 					</div>
		 					<!-- end submit filed -->
		 				</form>
		 			</div> 

 		<?php 

 		} elseif ($do == 'insert') { // #50

 			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo '<h1 class="text-center">Insert Categories</h1> ';
			
				echo "<div class='container'>";

				// Get the variable from the FORM

				$name 		= $_POST['name'];
				$desc 		= $_POST['description'];
				$order 		= $_POST['ordering'];
				$visibile 	= $_POST['visibility'];
				$comment 	= $_POST['commenting'];
				$ads 		= $_POST['advertising']; 

				// check if categorey exist in database 

				$check = checkItem("Name", "categories" , $name );

				if ($check == 1) {

					$theMsg = "<div class=' alert alert-danger'> Sorry this user is exist  </div>";
					redirectHome($theMsg, 'back');

				} else {

					// Insert category info in database 
					
					$stmt3 = $con->prepare("INSERT INTO 
											categories (Name, Description, Ordering, Visibility, Allow_Comment,  Allow_Ads ) 

											VALUES (:rname, :rdesc, :rorder, :rvisibile, :rcomment, :rads )");
					$stmt3->execute(array(

						'rname' 	=> $name,
						'rdesc' 	=> $desc,
						'rorder' 	=> $order,
						'rvisibile' => $visibile,
						'rcomment' 	=> $comment,
						'rads' 		=> $ads  ));

					// echo success message 

					$theMsg = "<div class='alert alert-success'>" . $stmt3->rowCount() . '  Record inserted </div>';
					redirectHome($theMsg, 'back');
				}
			

			} else {
				
				echo " <div class='container'> ";	
				$theMsg = '<div class="container alert alert-danger"> sorry you can\'t browse page directly </div>';
				
				redirectHome($theMsg, 'back');
				echo "</div>";
			}
			
			echo "</div>";

 		} elseif ($do == 'edit') { // #55 

 			// Check if get request catid  in numeric & GET is integer value 

 			$catid = isset ($_GET['catid']) && is_numeric($_GET['catid']) ? intval ($_GET['catid']) : 0; 

 			// Select all data depend on this ID 
			
			$stmt = $con->prepare(" SELECT * FROM categories WHERE ID = ? "); // علامة الاستفهام لاجل ربط بين المتغير "جيت آي دي" و الاستعلام جاتيجؤيس 

			// Execute Query

			$stmt->execute(array($catid));

			// Fetch the data 

			$cat = $stmt->fetch();

			// the row count 

			$count = $stmt->rowCount();

			// if there's such ID show the form 

			if ($count > 0) { ?>
			
		 		<h1 class="text-center">Edit Category </h1> 
		 		<div class="container">
	 				<form class="form-horizontal" action="?action=update" method="POST">
	 					<input type="hidden" name="catid" value=" <?php echo $catid; ?> ">
	 					
	 					<!-- start Name filed -->
	 					<div class="form-group form-group-lg">
	 						<label class="col-sm-2 control-label">Name</label>
	 						<div class="col-sm-10 col-md-6">
	 							<input type="text" name="name" class="form-control" required="required" placeholder="Name of the category" value=" <?php echo $cat['Name']; ?> " />
	 						</div>
	 					</div>
	 					<!-- start Name filed -->

	 					<!-- start description filed -->
	 					<div class="form-group form-group-lg">
	 						<label class="col-sm-2 control-label">Description</label>
	 						<div class="col-sm-10 col-md-6">
	 							<input type="text" name="description" class=" form-control" placeholder="Describe the category" value=" <?php echo $cat['Description']; ?> "> 	
	 						</div>
	 					</div>
	 					<!-- end description filed -->

	 					<!-- start ordering filed -->
	 					<div class="form-group form-group-lg">
	 						<label class="col-sm-2 control-label">Ordering</label>
	 						<div class="col-sm-10 col-md-6">
	 							<input type="text" name="ordering" class="form-control"  placeholder="Number to arrange the categories" value=" <?php echo $cat['Ordering']; ?> " >
	 						</div>
	 					</div>
	 					<!-- end ordering filed -->

						<!-- start visibility filed -->
	 					<div class="form-group form-group-lg">
	 						<label class="col-sm-2 control-label">Visibile</label>
	 						<div class="col-sm-10 col-md-6">
	 							<div>
	 								<input id="vis-yes" type="radio" name="visibility" value="0" <?php if ($cat['Visibility'] == 0) { echo 'checked';} ?> />
	 								<label for="vis-yes">Yes</label>
	 							</div>
	 							<div>
	 								<input id="vis-no" type="radio" name="visibility" value="1" <?php if ($cat['Visibility'] == 1) { echo 'checked';} ?>  />
	 								<label for="vis-no">No</label>
	 							</div>
	 						</div>
	 					</div>
	 					<!-- end visibility filed -->

	 					<!-- start commenting filed -->
	 					<div class="form-group form-group-lg">
	 						<label class="col-sm-2 control-label">Allow Commenting</label>
	 						<div class="col-sm-10 col-md-6">
	 							<div>
	 								<input id="com-yes" type="radio" name="commenting" value="0" <?php if ($cat['Allow_Comment'] == 0) { echo 'checked';} ?>  />
	 								<label for="com-yes">Yes</label>
	 							</div>
	 							<div>
	 								<input id="com-no" type="radio" name="commenting" value="1" <?php if ($cat['Allow_Comment'] == 1) { echo 'checked';} ?> />
	 								<label for="com-no">No</label>
	 							</div>
	 						</div>
	 					</div>
	 					<!-- end commenting filed -->	

	 					<!-- start ads filed -->
	 					<div class="form-group form-group-lg">
	 						<label class="col-sm-2 control-label">Allow Advertising</label>
	 						<div class="col-sm-10 col-md-6">
	 							<div>
	 								<input id="ads-yes" type="radio" name="advertising" value="0" <?php if ($cat['Allow_Ads'] == 0) { echo 'checked';} ?> />
	 								<label for="ads-yes">Yes</label>
	 							</div>
	 							<div>
	 								<input id="ads-no" type="radio" name="advertising" value="1" <?php if ($cat['Allow_Ads'] == 1) { echo 'checked';} ?>  />
	 								<label for="ads-no">No</label>
	 							</div>
	 						</div>
	 					</div>
	 					<!-- end ads filed -->		

	 					<!-- start submit filed -->
	 					<div class="form-group">
	 						<div class="col-sm-offset-2 col-sm-10">
	 							<input type="submit" value=" Save " class="btn btn-primary btn-lg">
	 						</div>
	 					</div>
	 					<!-- end submit filed -->
	 				</form>
		 		</div>
	
			<?php 

				// if there's no such id show error message

				} else {
					
					echo "<div class= 'container'>";
					$theMsg = '<div class="alert alert-danger">There is no such ID </div>';
					redirectHome($theMsg);
					echo "</div>";
				}

 		} elseif ($do == 'update') { // #56

 			echo '<h1 class="text-center">Update Categories</h1> ';
			echo "<div class='container'>";

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					// Get the variable from the FORM

					$id 		= $_POST['catid'];
					$name 		= $_POST['name'];
					$desc 		= $_POST['description'];
					$order 		= $_POST['ordering'];
					$visibile 	= $_POST['visibility'];
					$comernt 	= $_POST['commenting'];
					$ads 		= $_POST['advertising'];

					// Update the database with this info

					$stmt = $con->prepare(" UPDATE 
												categories 
										    SET 
										   		Name = ?, 
										   		Description = ?, 
										   		Ordering = ?, 
										   		Visibility = ?, 
												Allow_Comment = ?,
												Allow_Ads = ?
										    WHERE 
										    	ID = ?");
					$stmt->execute(array($name, $desc, $order, $visibile, $comernt,$ads, $id ));

					// echo success message 

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . '  Record Update </div>';

					redirectHome($theMsg,'back');				

				} else {

					$theMsg = " <div class='alert alert-danger'> sorry you cant browse page directly </div> ";
					redirectHome($theMsg);
				}
				
				echo "</div>";

 		} elseif ($do == 'delete') {

			echo '<h1 class="text-center">Delete Categories</h1> ';
			echo "<div class='container'>";

				// check if get request catid is numeric and get the integer vqlue of it 

				$catid = isset ($_GET['catid']) && is_numeric($_GET['catid']) ? intval ($_GET['catid']) : 0; 
				
				// select all data depend on this ID 

				
				$check = checkItem('ID', 'categories', $catid );

				// if there's such ID show the form

			    if ( $check > 0 )  { 

					$stmt = $con->prepare("DELETE FROM categories WHERE ID = :zid");
					$stmt->bindParam(":zid" , $catid); // bind = ربط 
					$stmt->execute();
					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . '  Record Delete </div>';

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