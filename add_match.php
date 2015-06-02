<?php
include("header.php");
if (isset($_SESSION['user_id'],$_SESSION['email'])){
		if (isset($_SESSION['is_admin']) && !empty($_SESSION['is_admin'])){

$matchForUpdate = NULL;
if(!empty($_GET["matchId"])) {
	$matchQuery = mysql_query("SELECT * FROM item_matchings WHERE match_id =".$_GET["matchId"]);
	$matchRow = mysql_fetch_array($matchQuery);
	$matchForUpdate = array("matchId" => $_GET["matchId"], "topItemId" => $matchRow['top_item_id'], "bottomItemId" => $matchRow['bottom_item_id'], "modelPicture" => $matchRow['model_picture']);
}
?>
<script type="text/javascript" src="add_match_validate.js?3"></script>
<script>
	function loadItems(gender, type) {
		$.ajax({ url: "select_item_for_match.php?gender="+gender+"&type="+type,
		 context: document.body,
		 success: function(result) {
		 			$("#selection").html(result);
	 			}
		});
	};

	$(function() {
		$("#dialog").dialog({
				autoOpen: false,				
				modal: true,
				resizable: false,
		});
 
	    $( "#openerTop" ).click(function() {
	      $("#dialog").dialog("open");
  				loadItems("male", "top");
				return false
			});
		
	    $( "#openerBottom" ).click(function() {
	      $("#dialog").dialog("open");
		  	loadItems("male", "bottom");
			return false
		});		
	  });
 </script>
	  
<div id="dialog" title="Item Selection">
	<div id="selection"></div>
</div>

<div id="content_header"></div>
	<div id="site_content">
		<div id="content">
			<div class="add_match_form">
				<?php if ($matchForUpdate == NULL) { ?>
			    	<form id="add_match_form" action="manage_match_logic.php?action=add" method="post" enctype="multipart/form-data".>
				<?php } else { ?>
					<form action="manage_match_logic.php?action=update&matchId=<?php echo $matchForUpdate['matchId']; ?>" method="post" enctype="multipart/form-data".>
				<?php } ?>
			        Add New Match:<br />
			        <div class="center">
			        	<label for="top_item_id">Top Item ID: </label><input type="text" id="top_item_id" name="top_item_id" value="<?php if ($matchForUpdate != NULL) echo $matchForUpdate['topItemId']; ?>" /><button id="openerTop">Select Item</button><br />
			        	<label for="bottom_item_id">Bottom Item ID: </label><input type="text" id="bottom_item_id" name="bottom_item_id" value="<?php if ($matchForUpdate != NULL) echo $matchForUpdate['bottomItemId']; ?>" /><button id="openerBottom">Select Item</button><br />
						<?php if ($matchForUpdate != NULL) { ?>
					    	<img src="images/models/<?php echo $matchForUpdate['modelPicture']; ?>" width="170"/><br/>
						<?php } ?>
						<label for="imageToUpload">Upload Item Image:</label><input type="file" name="imageToUpload" id="imageToUpload" <?php if ($matchForUpdate == NULL) echo "required"; ?>><br/>
						<?php if ($matchForUpdate == NULL) { ?>			
			           		<input type="submit" value="Add Match" name="submit"/>
						<?php } else { ?>
							<input type="submit" value="Update Match" name="submit"/>
						<?php } ?>
					</div>
			    </form>
			</div>			
	</div>
</div>

</div>

  </body>
</html>

<?php
}
}else{
	header("location: index.php");
}
?>