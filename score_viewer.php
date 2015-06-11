<?php
include("config.php");

?>
<script type="text/javascript">
$('#gender').on('change', function() {
  	loadMatch($(this).val(), "<?php if (isset($matchId)){ echo $matchId; }?>", "<?php  if (isset($firstId)){echo $firstId;} ?>", "<?php  if (isset($secondId)){echo $secondId;} ?>");
});

$(document).ready(function() {
		$('#itemsModal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var type = button.data('whatever') // Extract info from data-* attributes
		  loadItems("<?php if (!empty($gender)){echo $gender;} else { echo "male" ;}?>", type);
		 
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
	
	$(document).ready(function() {
		$('#meter').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var topId = $('#top_item_id').val();		  
		  var botId = $('#bottom_item_id').val();		
		  loadScore(topId, botId);
		})
	});

function loadItems(gender, type) {
		$.ajax({ url: "select_item_for_match.php?gender="+gender+"&type="+type,
		 context: document.body,
		 success: function(items) {
		 			$("#items").html(items);
	 			}
		});
	};
	
	$('#topItem').on('show.bs.modal', function() {
  	loadMatch($(this).val(), "<?php if (isset($matchId)){ echo $matchId; }?>", "<?php  if (isset($firstId)){echo $firstId;} ?>", "<?php  if (isset($secondId)){echo $secondId;} ?>");
});

$('#bottomItem').on('change', function() {
  	loadMatch($(this).val(), "<?php if (isset($matchId)){ echo $matchId; }?>", "<?php  if (isset($firstId)){echo $firstId;} ?>", "<?php  if (isset($secondId)){echo $secondId;} ?>");
});
	
</script>
<?php

if (isset($_SESSION['user_id'],$_SESSION['email'])){
		if (isset($_SESSION['is_admin']) && !empty($_SESSION['is_admin'])){

$matchForUpdate = NULL;
if(!empty($_GET["matchId"])) {
	$matchQuery = mysql_query("SELECT * FROM item_matchings WHERE match_id =".$_GET["matchId"]);
	$matchRow = mysql_fetch_array($matchQuery);
	$matchForUpdate = array("matchId" => $_GET["matchId"], "topItemId" => $matchRow['top_item_id'], "bottomItemId" => $matchRow['bottom_item_id'], "modelPicture" => $matchRow['model_picture']);
} else {
	$match=NULL;
}
if (!empty($_GET["gender"])){
	$gender=$_GET["gender"];
} else{
	$gender="choose gender";
}
?>




  
<div id=topItem class="col-md-6" align="center">
		        	<label class="control-label" for="top_item_id">Top Item ID: </label>
					<input class="form-control" type="text" id="top_item_id" name="top_item_id" value="<?php if ($match != NULL) echo $match['topItemId']; ?>" />
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#itemsModal" data-whatever="top">Select Top Item</button>
				</div>
				<div id=bottomItem class="col-md-6" align="center">
		        	<label class="control-label" for="bottom_item_id">Bottom Item ID: </label>
					<input class="form-control" type="text" id="bottom_item_id" name="bottom_item_id" value="<?php if ($match != NULL) echo $match['bottomItemId']; ?>" />
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#itemsModal" data-whatever="bottom">Select Bottom Item</button>
				</div>
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#meter" >Show Score!</button>
<div class="modal fade" id="itemsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">New message</h4>
      </div>
      <div class="modal-body" id="items">
	  </div>
      </div>
    </div>
  </div>
 
  
  <div class="row">
<div class="col-md-12" align="center">
	<select id="gender"> 
	<option />
	<option value="male" <?php if ($gender == "male") echo "selected"; ?> >Men</option>
	<option value="female" <?php if ($gender == "female") echo "selected"; ?>>Women</option>
</select>
</div>
</div>



<div id=meter class=col-md-12 align="center">

</div>
<div id="items"><!-- content will be loaded here --></div>
</div>
<?php
if ($gender != "choose gender"){
	
if (empty($firstId)){
	echo $gender;
	?>
	
	<script type="text/javascript">
	loadItems($gender,"top");
	</script>
	<?php
} else if (empty($secondId)){
	?>
	<script type="text/javascript">
	loadItem($gender,"bottom");
	</script>
	<?php
}
}
?>

<?php
}
}else{
	header("location: index.php");
}
?>
