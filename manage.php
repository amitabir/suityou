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
					<div class="list-group">
					  <a href="manage_matches.php" class="list-group-item">Manage Matches</a>
					  <a href="stats.php" class="list-group-item">Statistics</a>
					  <a href="view_score.php" class="list-group-item">Trend Scores</a>
					  <a href="constants.php" class="list-group-item">Manage Constants</a>
					</div>
				</h4>
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