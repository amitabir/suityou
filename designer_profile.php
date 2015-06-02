<?php
	include("config.php");
	include("User.php");
	
	$userId = $_SESSION['user_id'];
	$designerId = $_GET['designerId'];
	
	$designer = User::getUserfromDBbyID($designerId);
	
	if (!$designer->is_designer) {
		echo "This user is not a designer!";
	} else {
?>
	
<?php
	}
?>