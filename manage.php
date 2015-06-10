<?php 
include("header.php");
if (isset($_SESSION['user_id'],$_SESSION['email'])){
		if (isset($_SESSION['is_admin']) && !empty($_SESSION['is_admin'])){
?>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2>Welcome to SuitYou management, Boss!</h2>
				<h4>
				<ul>				
					<li><a href="manage_matches.php"> Manage Matches </a> </li>
					<li><a href="stats.php"> Statistics </a> </li>
					<li><a href="constants.php"> Manage Constants </a> </li>
				</ul></h4>

				</div>
			</div>
		</div>
	</body>
</html>
<?php } 
	}else{
		echo '<script>window.location.replace("index.php")</script>';
	}
?>