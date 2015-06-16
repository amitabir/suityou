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
<script type="text/javascript" src="js/site_scripts/add_match_validate.js?3"></script>
<script>
	function loadItems(gender, type) {
		$.ajax({ url: "select_item_for_match.php?gender="+gender+"&type="+type,
		 context: document.body,
		 success: function(result) {
		 			$("#result").html(result);
	 			}
		});
	};

	$(document).ready(function() {
		$('#itemsModal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var type = button.data('whatever') // Extract info from data-* attributes
		  loadItems("male", type);
		 
		  var modal = $(this)
			var title = "";
			if (type == "top") {
				title = "Top"
			} else {
				title = "Bottom"
			}
		  modal.find('.modal-title').text('Select '  + title + ' Item')
		})
	});
 </script>
	  
<div class="modal fade" id="itemsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">New message</h4>
      </div>
      <div class="modal-body" id="result"></div>
      </div>
    </div>
  </div>

<div class="container">
	<div class="row">
			<?php if ($matchForUpdate == NULL) { ?>
		    	<form class="form-horizontal" id="add_match_form" action="manage_match_logic.php?action=add" method="post" enctype="multipart/form-data" role="form">
					<h3 class="page-header">Add New Match</h3>
			<?php } else { ?>
				<form class="form-horizontal" action="manage_match_logic.php?action=update&matchId=<?php echo $matchForUpdate['matchId']; ?>" method="post" enctype="multipart/form-data" role="form">
					<h3 class="page-header">Update Match</h3>
			<?php } ?>
		       	<div class="form-group controls form-inline">
		        	<label class="control-label" for="top_item_id">Top Item ID: </label>
					<input class="form-control" type="text" id="top_item_id" name="top_item_id" value="<?php if ($matchForUpdate != NULL) echo $matchForUpdate['topItemId']; ?>" />
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#itemsModal" data-whatever="top">Select Top Item</button>
				</div>
		       	<div class="form-group controls form-inline">
		        	<label class="control-label" for="bottom_item_id">Bottom Item ID: </label>
					<input class="form-control" type="text" id="bottom_item_id" name="bottom_item_id" value="<?php if ($matchForUpdate != NULL) echo $matchForUpdate['bottomItemId']; ?>" />
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#itemsModal" data-whatever="bottom">Select Bottom Item</button>
				</div>
				<?php if ($matchForUpdate != NULL) { ?>
			    	<img src="images/models/<?php echo $matchForUpdate['modelPicture']; ?>" width="170"/><br/>
				<?php } ?>
				<div class="form-group">
					<label class="control-label" for="imageToUpload">Upload Match Image:</label>
					<input class="form-control" type="file" name="imageToUpload" id="imageToUpload" <?php if ($matchForUpdate == NULL) echo "required"; ?>>
				</div>
				<?php if ($matchForUpdate == NULL) { ?>			
	           		<button type="submit" class="btn btn-primary" name="submit">Add Match</button>
				<?php } else { ?>
					<button type="submit" class="btn btn-primary" name="submit">Update Match</button>
				<?php } ?>
		    </form>
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