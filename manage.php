<?php 
include("header.php");
if (isset($_SESSION['user_id'],$_SESSION['email'])){
		if (isset($_SESSION['is_admin']) && !empty($_SESSION['is_admin'])){
?>
	<div class="container">
		<h2>Welcome to SuitYou management, Boss!</h2>

		<ul>				
			<li><a href="manage_matches.php"> Manage Matches </a> </li>
			<li><a href="stats.php"> Statistics </a> </li>
		</ul>

		</div>
	</body>
</html>
<?php } 
	}else{
		echo '<script>window.location.replace("index.php")</script>';
	}
?>