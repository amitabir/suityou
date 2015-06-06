
<?php 
include("header.php");
if (isset($_SESSION['user_id'],$_SESSION['email'])){
		if (isset($_SESSION['is_admin']) && !empty($_SESSION['is_admin'])){
?>
			    <div id="content_header"></div>
    		<div id="site_content">
        		<div id="content">
            		<div id="content-part">
                		<h2>Welcome to SuitYou management, Boss!</h2>
            		</div>
			
					<ul>				
						<li><a href="manage_matches.php"> Manage Matches </a> </li>
						<li><a href="stats.php"> Statistics </a> </li>
					</ul>
			
        			</div>
    			</div>
	 	 	</body>
		</html>



<?php } 
	}else{
		header("location: index.php");
	}
?>