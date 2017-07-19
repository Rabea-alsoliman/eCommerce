  <?php 
  	
  	function lang( $phrase ) {

  		static $lang = array (

  			 // Navbar Link
  			'HOME'			  =>'Home',
  			'CATEGORIES'	=>'Categories',
  			'RABEA'			  =>'Rabea',
  			'ITEMS'			  =>'Items',
  			'MEMBERS'		  =>'Members',
        'COMMENTS'    =>'Comments',
  			'STATISTICS'	=>'Statistics',
  			'LOGS'			  =>'Logs',
  			''=>''
  			);
  		return $lang[$phrase];
  	}	
  ?>					