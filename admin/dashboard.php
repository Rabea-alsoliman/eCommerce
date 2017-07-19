<?php  
	ob_start(); // #48 output buffering start
	session_start();
	if (isset ($_SESSION['Username'])) {
		$pageTitle = 'Dashboard';
		include 'init.php';
		// Start dashboard page 

		$numUsers = 5; // #45  number of latest user 

		$latestUsers = getLatest("*", "users", "UserID", $numUsers); // #45 latest user array

		$unmItems = 5; // #73  number of latest item

		$latestItems = getLatest("*", "items", "item_ID", $unmItems); // #73 latest user array

		 ?> 
		<div class="home-stats">
			<div class="container text-center">
			 	<h1>Dashboard</h1>
				<div class="row">
					<div class="col-md-3">
						<div class="stat st-members">
							<i class="fa fa-users"  ></i>
							<div class="info">
								Total Members
								<span>
									<a href="members.php">
									<?php echo countItems ('UserID', 'users') ?>	
									</a>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="stat st-pending">
							<i class="fa fa-user-plus"  ></i>
							<div class="info">
								Pending Members
								<span>
									<a href="members.php?action=manage&page=pending"> 
										<?php echo checkItem("RrgStatus", "users", 0) ;?>											
									</a>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="stat st-items">
							<i class="fa fa-tag"  ></i>
							<div class="info">
								Total Items
								<span>
									<a href="items.php">
										<?php echo countItems ('Item_ID', 'items') ?></a>
									</span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="stat st-comments"> 
							<i class="fa fa-comments"  ></i>
							<div class="info">
								Total Comments
								<span>0</span>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="latest">
			<div class="container ">
			 	<div class="row">
			 		<div class="col-sm-6">
			 			<div class="panel panel-default">
			 				<div class="panel-heading">
			 					<i class="fa fa-users"></i> 
			 					Latest <?php echo $numUsers; ?> Registerd Users
			 					<span class="toggle-info pull-right">
			 						<i class="fa fa-minus fa-lg"></i>
			 					</span>
			 				</div>
			 				<div class="panel-body">
			 					<ul class="list-unstyled latest-users">
				 					<?php

		 								foreach ($latestUsers as $user) { // #45 
								 		echo '<li>'; // #46
									 		echo $user['Username'] ; 
									 		echo '<a href="members.php?action=edit&userid=' . $user['UserID'] . '">';
									 			echo '<span class ="btn btn-success pull-right">';
									 				echo '<i class ="fa fa-edit"></i> Edit';
									 				if ($user['RrgStatus'] == 0) {

													echo "<a href='members.php?action=activate&userid=".$user['UserID']." 'class='btn btn-info pull-right '>
												<i class='fa fa-check'></i> Activate </a> ";
												}
									 			echo '</span>';
									 		echo '</a>';
								 		echo '</li>';

									 		}  
									 ?>
								 </ul>
			 				</div>
			 			</div>
			 		</div>
			 		<div class="col-sm-6">
			 			<div class="panel panel-default">
			 				<div class="panel-heading">
			 					<i class="fa fa-tag"></i> Latest Items
			 					<span class="toggle-info pull-right">
			 						<i class="fa fa-minus fa-lg"></i>
			 					</span>
			 				</div>
			 				<div class="panel-body">
			 					<ul class="list-unstyled latest-users"> <!-- #73 start  -->
				 					<?php

		 								foreach ($latestItems as $item) {  
								 		echo '<li>'; 
									 		echo $item['Name'] ; 
									 		echo '<a href="items.php?action=edit&itemid=' . $item['item_ID'] . '">';
									 			echo '<span class ="btn btn-success pull-right">';
									 				echo '<i class ="fa fa-edit"></i> Edit';
									 				if ($item['Approve'] == 0) { 
												echo "<a 
												   href='items.php?action=approve&itemid=".$item['item_ID']." ' class='btn btn-info pull-right '>
												<i class='fa fa-check'></i> Approve </a> ";
											}
									 			echo '</span>';
									 		echo '</a>';  
								 		echo '</li>';

									 		}  
									 ?>
								 </ul>     <!-- #73 end -->
			 				</div>
			 			</div>
			 		</div>
			 	</div>
				<!-- #78 Start Latest Comment -->
			 	<div class="row">
			 		<div class="col-sm-6">
			 			<div class="panel panel-default">
			 				<div class="panel-heading">
			 					<i class="fa fa-comments-o"></i> 
			 					Latest Comments
			 					<span class="toggle-info pull-right">
			 						<i class="fa fa-minus fa-lg"></i>
			 					</span>
			 				</div>
			 				<div class="panel-body">
			 				<?php 
				 					$stmt = $con->prepare("SELECT 
					 										comments.*, users.Username AS Member 
					 									FROM 
					 										comments
					 								
					 									INNER JOIN 
					 										users 
					 									ON 
					 										users.UserID = comments.user_id 
														");

						 			// execute this statement
						 			
						 			$stmt->execute(); 

						 			// assign to variable

						 			$comments = $stmt->fetchAll();

						 			foreach ($comments as $comment)	 {																																																																																																					

						 				echo '<div class="comment-box"> ';
						 					echo '<span class="member-n">'.$comment['Member'].'</span>';
						 					echo '<p class="member-c">'.$comment['comment'].'</p>';
						 				echo '</div>';
						 			}
				 			 ?>
			 				</div>
			 			</div>
			 		</div>
			 	</div>
			 	</div>
				<!-- End  Latest Comment -->
			 </div>
		 </div>

		 <?php

		 // End dashpoard page 
		 include $tpl . 'footer.php';
}   else {
		 header('location: index.php');
		 exit(); } 

		 ob_end_flush();
		 ?>