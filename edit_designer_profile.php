<?php
include("header.php");

$designer = NULL;
if(!empty($_GET["designerId"])) {
	$desQuery = mysql_query("SELECT * FROM users WHERE user_id =".$_GET["designerId"]);
	$designer = mysql_fetch_array($desQuery);
	$name=$designer['first_name']." ".$designer['last_name'];
}
?>

	  
<div id="dialog" title="Item Selection">
	<div id="selection"></div>
</div>

<div id="content_header"></div>
	<div id="site_content">
		<div id="content">
			<div class="edit_designer_info_form">
				<?php if ($designer == NULL) { 
				 } else { ?>
					<form id="edit_designer" action="designer_management.php?designerId=<?php echo $designer['user_id']; ?>" method="post" enctype="multipart/form-data".>
				<?php } ?>
			        Edit Your Info:<br />
			        <div class="center">
						<?php echo $name ?>
						<br/>
						<?php if ($designer != NULL) { ?>
						<textarea name="description" form="edit_designer" placeholder="Describe yourself..."><?php echo $designer["description"]	 ?> </textarea>
						<?php } ?>
						<br/>
			        	<label for="website_link">Your Website: </label><input type="text" id="website_link" name="website_link" placeholder="Enter your website..." value="<?php if ($designer != NULL) echo $designer['website_link']; ?>" /><br />
						<?php if ($designer != NULL) { ?>
					    	<img src="images/users/<?php echo $designer['avatar']; ?>" width="170"/><br/>
						<?php } ?>
						<label for="imageToUpload">Upload Item Image:</label><input type="file" name="imageToUpload" id="imageToUpload" <?php if ($designer == NULL) echo "required"; ?>><br/>
						<?php if ($designer != NULL) { ?>
							<input type="submit" value="Update Info" name="submit"/>
						<?php } ?>
					</div>
			    </form>
			</div>			
	</div>
</div>

</div>

  </body>
</html>
