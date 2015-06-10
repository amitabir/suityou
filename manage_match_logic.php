<?php
include("config.php");
include("image_upload.php");

define("MODELS_IMAGES_TARGET_DIR", "images/models/");

if ($_GET["action"] == "add") {	
	if(isset($_POST["submit"])) {
		$topItemId = $_POST['top_item_id'];
		$bottomItemId = $_POST['bottom_item_id'];
		
		$uploadResult = uploadImage("imageToUpload", MODELS_IMAGES_TARGET_DIR);
		if ($uploadResult["success"]) {
			$modelPicture = $uploadResult["uploadedFileName"];
		} else {
			// Upload failed, set message and return
			$_SESSION['match_update_message']="Error uploading item image: ".$uploadResult["message"];
			$_SESSION['match_update_success'] = false;
			header('Location: manage_matches.php');
			exit;
		}						
				
		mysql_query('INSERT INTO item_matchings(top_item_id, bottom_item_id, match_type, model_picture) VALUES ('.$topItemId.', '.$bottomItemId.', 1, "'.$modelPicture.'")') or die(mysql_error());

		$_SESSION['match_update_message'] = "Match added successfully";
		$_SESSION['match_update_success'] = true;
		header("location: manage_matches.php");
	}
} else if ($_GET["action"] == "update") {
	if(isset($_POST["submit"])) { 
		$matchId = $_GET["matchId"];
		$matchQuery = mysql_query("SELECT * FROM item_matchings WHERE match_id =".$matchId);
		$matchRow = mysql_fetch_array($matchQuery);
		$modelPicture = $matchRow['model_picture'];
		
		if (!empty($_FILES["imageToUpload"]["name"])) {
			$uploadResult = uploadImage("imageToUpload", MODELS_IMAGES_TARGET_DIR);
			if ($uploadResult["success"]) {
				deleteImage($modelPicture, MODELS_IMAGES_TARGET_DIR);
				$updatedModelPicture = $uploadResult["uploadedFileName"];
			} else {
				// Upload failed, set message and return
				$_SESSION['match_update_message']="Error uploading item image: ".$uploadResult["message"];
				$_SESSION['match_update_success'] = false;
				header('Location: manage_matches.php');
				exit;
			}						
		} else {
			$updatedModelPicture = $modelPicture;
		}
		
		$topItemId = $_POST['top_item_id'];
		$bottomItemId = $_POST['bottom_item_id'];
		
		// Update the match
		mysql_query('UPDATE item_matchings SET model_picture = "'.$updatedModelPicture.'", top_item_id="'.$topItemId.'", bottom_item_id="'.$bottomItemId.'" WHERE match_id = '.$matchId) or die(mysql_error());
		
		$_SESSION['match_update_message'] = "Match updated successfully";
		$_SESSION['match_update_success'] = true;
		header("location: manage_matches.php");
	}				
} else if ($_GET["action"] == "remove") {
		$matchId = $_GET["matchId"];
		$matchQuery = mysql_query("SELECT * FROM item_matchings WHERE match_id =".$matchId);
		$matchRow = mysql_fetch_array($matchQuery);
		$modelPicture = $matchRow['model_picture'];
		
		// Delete the match model picture
		if (!empty($modelPicture)) {
			deleteImage($modelPicture, MODELS_IMAGES_TARGET_DIR);
		}
				
		// Delete the match
		mysql_query('DELETE FROM item_matchings WHERE match_id = '.$matchId) or die(mysql_error());
		
		// TODO delete the rating history?
		
		$_SESSION['match_update_message'] = "Match removed successfully";
		$_SESSION['match_update_success'] = true;
		header("location: manage_matches.php");
}?>