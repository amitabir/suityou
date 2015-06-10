<?php
include("config.php");

if(isset($_SESSION['user_id'])){
	$userId = $_SESSION['user_id'];
} else {
	$userId = NULL;
}

if ($userId != NULL) {
	$user = User::getUserfromDBbyID($userId);
	$couponMeterValue = $user->coupon_meter;
} else {
	$couponMeterValue = 0;
}

$matchId = $_GET['matchId'];

$matchQuery = mysql_query('SELECT matches.*, it1.name as top_item_name, it2.name as bottom_item_name, it1.description as top_item_description, it2.description as bottom_item_description, it1.price as top_item_price, it2.price as bottom_item_price FROM item_matchings matches INNER JOIN items it1, items it2 WHERE match_type = 1 AND matches.top_item_id = it1.item_id AND matches.bottom_item_id = it2.item_id AND matches.match_id = '. $matchId);

$row = mysql_fetch_array($matchQuery);
$topItemId = $row['top_item_id'];
$topItemName = $row['top_item_name'];
$topItemDescription = $row['top_item_description'];
$topItemPrice = $row['top_item_price'];
$bottomItemId = $row['bottom_item_id'];
$bottomItemName = $row['bottom_item_name'];
$bottomItemDescription = $row['bottom_item_description'];
$bottomItemPrice = $row['bottom_item_price'];
$modelPic = $row['model_picture'];
?>
<script>
	refreshGage(<?php echo $couponMeterValue; ?>);
</script>
		<div class="row">
			<div class="col-md-8" align="center">
				<p><img id='match_pic' src=images/models/<?php echo $modelPic;?> height='500' width='500' /> </p>
				<p> <div id="jRate"></div> </p>
				<p><h3> <label class="label label-warning" id="rating_label">0/10</label> </h3> </p>
			</div>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading" align="left">
						<h3 class="panel-title">Top Item</h3>
				    </div>
					<div class="panel-body" align="left">
						<p><strong><?php echo $topItemName; ?></strong></p>
						<p><?php echo $topItemDescription; ?></p>
						<p>$<?php echo $topItemPrice; ?></p>
						<p style="margin: 0"><a href='show_item.php?itemId=<?php echo $topItemId?>'> Get It Now! </a></p>
					</div>
				</div>
				
				
				<div class="panel panel-default">
					<div class="panel-heading" align="left">
						<h3 class="panel-title">Bottom Item</h3>
				    </div>
					<div class="panel-body" align="left">
						<p><strong><?php echo $bottomItemName; ?></strong></p>
						<p><?php echo $bottomItemDescription; ?></p>
						<p>$<?php echo $bottomItemPrice; ?></p>
						<p style="margin: 0"><a href='show_item.php?itemId=<?php echo $bottomItemId?>'> Get It Now! </a></p>
					</div>
				</div>
			</div>
		</div>
	</div>


<script type="text/javascript">
		$(function () {
			var that = this;
			var startTime = new Date().getTime();
			var toolitup = $("#jRate").jRate({
				count: 10,
				startColor: 'yellow',
				endColor: 'red',
				strokeColor: 'black',
				width: 30,
				height: 30,
				precision: 0.5,
				onChange: function(rating) {
					$("#rating_label").text(rating*2+"/10");
				},
				onSet: function(rating) {
					var endTime = new Date().getTime();
					var ratingTime = endTime-startTime;
					$.ajax({ url: "handle_match_rating.php?skipped=false&matchId=<?php echo $matchId; ?>&userId=<?php echo $userId; ?>&rating="+rating*2+"&ratingTime="+ratingTime,
					        context: document.body,
					        success: function(result) {
					          $("#match").html(result);
							  $("#match_pic").effect("slide", {direction: "left"}, 800);
							  $("#rating_label").effect("highlight", 800);							  
					        }});
				}
			});	
		});
		
		$(document).ready(function(){
		    $("#skipBtn").click(function(){
		        $.ajax({url: "handle_match_rating.php?skipped=true&matchId=<?php echo $matchId; ?>&userId=<?php echo $userId; ?>", success: function(result){
		            $("#match").html(result);
					$("#match_pic").effect("slide", {}, 800);
					
		        }});
		    });
		});
	</script>
		
		<div class="row">
			<div class="col-lg-12" align="right">
				<div id="next">
					<button id="skipBtn">Next</button>
				</div>
			</div>
		</div>


				
