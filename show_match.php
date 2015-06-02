<?php
	include("config.php");
	
	$userId = $_SESSION['user_id'];
	
	if ($userId != NULL) {
		$user = User::getUserfromDBbyID($userId);
		$couponMeterValue = $user->coupon_meter;
	} else {
		$couponMeterValue = 0;
	}
	
	$matchId = $_GET['matchId'];
	
	$matchQuery = mysql_query("SELECT * FROM item_matchings WHERE match_id = ". $matchId);
	
	$row = mysql_fetch_array($matchQuery);
	$topItemId = $row['top_item_id'];
	$bottomItemId = $row['bottom_item_id'];
	$modelPic = $row['model_picture'];
	
	echo "<img id='match_pic' src=images/models/$modelPic height='600' width='300'/> <br/>";	
	echo "<a href='show_item.php?itemId=$topItemId'> Buy Top Item </a> <br/>";
	echo "<a href='show_item.php?itemId=$bottomItemId'> Buy Bottom Item </a> <br/>";
	
	echo 'Rating:';
?>

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
				onSet: function(rating) {
					var endTime = new Date().getTime();
					var ratingTime = endTime-startTime;
					$.ajax({ url: "handle_match_rating.php?skipped=false&matchId=<?php echo $matchId; ?>&userId=<?php echo $userId; ?>&rating="+rating*2+"&ratingTime="+ratingTime,
					        context: document.body,
					        success: function(result) {
					          $("#match").html(result);
							  $("#match_pic").effect("slide", {direction: "left"}, 800);
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
<div id="jRate"></div>
<div id="next">
	<button id="skipBtn">Next</button>
</div>
				<div id="gauge" style="width: 100px; height:80px;"></div>
        		<script>
				var g = new JustGage({
				  id: "gauge",
				  value: <?php echo $couponMeterValue ?>,
				  min: 0,
				  max: 100,
				  title: "Coupon Meter"
				});
				</script>
