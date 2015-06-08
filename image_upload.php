<?php
// Uploads an image to the site storage in the given target directory. Validates that the file is an image and not too large.
// Also chaning its name to some random name to avoid name conflicts.
function uploadImage($fileElementId, $targetDir) {
	$newfilename = NULL;
	if (isset($_FILES[$fileElementId])) {
		$uploadOk = true;
		$message = "";
		$imageFileType = pathinfo(basename($_FILES[$fileElementId]["name"]),PATHINFO_EXTENSION);
	
		// Check if image file is a actual image or fake image
	    $check = getimagesize($_FILES[$fileElementId]["tmp_name"]);
	    if($check !== false) {
	        //echo "File is an image - " . $check["mime"] . ".";
	        $uploadOk = true;
	    } else {
	        $message = "File is not an image.";
	        $uploadOk = false;
	    }
	
		// Check file size
		if ($_FILES[$fileElementId]["size"] > 500000) {
		    $message = "Sorry, your file is too large.";
		    $uploadOk = false;
		}
				
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = false;
		}
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk) {
			// Change filename before uploading
			$temp = explode(".",$_FILES[$fileElementId]["name"]);
			$newfilename = rand(1,99999) . '.' .end($temp);
		    if (!move_uploaded_file($_FILES[$fileElementId]["tmp_name"], $targetDir . $newfilename)) {
		       $message = "Sorry, there was an error uploading your file.";
			   $uploadOk = false;
		    }
		}
	}
	return array("success" => $uploadOk, "uploadedFileName" => $newfilename, "message" => $message);
}

// Delets an image from the given target directory. Returns true if the deletion succeeded.
function deleteImage($imageFileName, $targetDir) {
	if (!empty($imageFileName) and file_exists($targetDir.$imageFileName)) {
		if (!unlink($targetDir.$imageFileName)) {
			return false;
		}
	}
	return true;
}
?>