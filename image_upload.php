<?php
function uploadImage($fileElementId, $targetDir) {
	$newfilename = NULL;
	if (isset($_FILES[$fileElementId])) {
		$uploadOk = 1;
		$imageFileType = pathinfo(basename($_FILES[$fileElementId]["name"]),PATHINFO_EXTENSION);
	
		// Check if image file is a actual image or fake image
	    $check = getimagesize($_FILES[$fileElementId]["tmp_name"]);
	    if($check !== false) {
	        //echo "File is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	        //echo "File is not an image.";
	        $uploadOk = 0;
	    }
	
		// Check file size
		if ($_FILES[$fileElementId]["size"] > 500000) {
		    //echo "Sorry, your file is too large.";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
		}
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		   // echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			// Change filename before uploading
			$temp = explode(".",$_FILES[$fileElementId]["name"]);
			$newfilename = rand(1,99999) . '.' .end($temp);
		    if (move_uploaded_file($_FILES[$fileElementId]["tmp_name"], $targetDir . $newfilename)) {
		        //echo "The file ". basename( $_FILES[$fileElementId]["name"]). " has been uploaded.";
		    } else {
		        //echo "Sorry, there was an error uploading your file.";
		    }
		}
	}
	return $newfilename;
}

function deleteImage($imageFileName, $targetDir) {
	if (!unlink($targetDir.$imageFileName)) {
		echo "ERROR deleting image";
	}
}
?>