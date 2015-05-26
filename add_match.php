<?php
include("header.php");
include("image_upload.php");

if(isset($_POST["submit"])) {	
	
	$modelPic = uploadImage("imageToUpload", "images/models/");
	if (mysql_query('INSERT INTO item_matchings(top_item_id, bottom_item_id, model_picture, match_type) VALUES ('.$_POST["top_item_id"].', '.$_POST["bottom_item_id"].', "'.$modelPic.'", 1)')) {
		echo "Match was added: id = ".mysql_insert_id();
	} else {
		echo mysql_error();
	}
}
?>

    <div id="content_header"></div>
    <div id="site_content">
        <div id="content">
			<div class="add_match_form">
			    <form action="add_match.php" method="post" enctype="multipart/form-data".>
			        Add New Match:<br />
			        <div class="center">
			        	<label for="top_item_id">Top Item ID</label><input type="text" name="top_item_id"/><br />
			        	<label for="bottom_item_id">Top Item ID</label><input type="text" name="bottom_item_id"/><br />
						<label for="image">Upload Item Image:</label><input type="file" name="imageToUpload" id="imageToUpload"><br />			
			            <input type="submit" value="Add Item" name="submit"/>
					</div>
			    </form>
			</div>			
        </div>
    </div>

</div>

  </body>
</html>