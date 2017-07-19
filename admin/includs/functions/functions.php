<?php    	
		function getTitle() {
			global $pageTitle; // for that is the variable $pageTilte access from any where ==  #18
			if (isset($pageTitle)) {
				echo $pageTitle;
			} else {
				echo 'Default';
			} } 

	/*
	** Home Redirect function v1.0 ===== #32
	** this function access parameter 
	** $errorMsg = echo the error message 
	** $seconds = seconds before redirecting 
	function redirectHome($errorMsg, $seconds = 3) {

			echo "<div class='alert alert-danger'>$errorMsg</div>";
			echo "<div class='alert alert-info'>You will be redirected to homepage after $seconds seconds.</div>";
			header("refresh:$seconds;url=index.php"); // ana katabit refresh badal header for cotrol in number seconds
			exit();
		} 
	*/

		/*
		** Home Redirect function v2.0 ===== #35
		** this function access parameter 
		** $theMsg = echo the message [ Example: error | success | warning ]
		** url = the link you redirect 
		** $seconds = seconds before redirecting 
		*/

		function redirectHome($theMsg, $url = null, $seconds = 3) {

			
			 if ($url === null) {

				$url = 'index.php';
				$link = "homepage";
			} else {

				if ( isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ) {

					$url = $_SERVER['HTTP_REFERER']  ;
					$link = "previous page";

				} else {
					$url = 'index.php'  ;
					$link = "homepage";
				}
			} 

			echo $theMsg;
			echo "<div class='container alert alert-info'>You will be redirected to $link after $seconds seconds.</div>";
			header("refresh:$seconds;url=$url"); // ana katabit refresh badal header for cotrol in number seconds
			exit();
		}
		
	/*
	** check items function v1.0 ===== #34
	** function to check item in database [ function accept  parameters ]
	** $select = the item to select [ Example: user, item, category ]
	** $from = the table to select from [ Example: users, items, categories ]
	** $value = the value of select [ Example: rabea, box, electronics ]
	*/

		function checkItem($select, $from, $value ) {
					
				global $con;

				$statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");  
				$statement->execute(array($value));
				$count = $statement->rowCount();
				return $count;
					
					}
	/*
	** Count number of items function V1.0 ==== #40
	** function of count numbers of items rows
	** $item : the item to count
	** $table : the table to choose from  
	*/				

	function countItems($item, $table) {

		global $con;
		$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table ");
		$stmt2->execute();
		return $stmt2->fetchColumn();

	}

	/*
	** Get latest record function v1.0
	** function to get latest items from database [ EX: users, items, comments]
	** $select = firld to select 
	** $table = the table to choose 
	** $limit = number of records t get
	** $order = the desc oredering  
	** DESC = Descending تنازلي 
	*/ 

	function getLatest($select, $table, $order,$limit = 5) {

		global $con;

		$getstmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

		$getstmt->execute();

		$rows = $getstmt->fetchAll();

		return $rows;

	}

?>