<?php
include("config.php");
include("image_upload.php");

define("USERS_IMAGES_TARGET_DIR", "images/users/");


	if(isset($_POST["submit"])) { 
		$designerId = $_GET["designerId"];
		$desQuery = mysql_query("SELECT * FROM users WHERE user_id =".$designerId);
		$desRow = mysql_fetch_array($desQuery);
		$avatar = $desRow['avatar'];
		
		if (!empty($_FILES["imageToUpload"]["name"])) {
			deleteImage($avatar, USERS_IMAGES_TARGET_DIR);
			$newAvatar = uploadImage("imageToUpload", USERS_IMAGES_TARGET_DIR);
		} else {
			$newAvatar = $avatar;
		}
		$user->avatar=$newAvatar;
		
		$description = $_POST['description'];
		$websiteLink = $_POST['website_link'];
		
		// Update the user
		mysql_query('UPDATE users SET avatar = "'.$newAvatar.'", website_link="'.$websiteLink.'", description="'.$description.'" WHERE user_id = '.$designerId) or die(mysql_error());
		
		
		header("location: designer_profile.php?designerId=$designerId");
	}				

?>