<?php
function showRating($matchId, $userId, $matchItemId, $size) {
	if($userId == NULL){
		if (!isset($_SESSION["user_data"])) {
			$_SESSION["user_data"] = array();
		}
		if(isset($_SESSION['user_data']['user_matchings'])){
			if(isset($_SESSION['user_data']['user_matchings'][$matchId])){
				$rating = $_SESSION['user_data']['user_matchings'][$matchId]['rating'];
			} else {
				$rating = -1;
			}
		} else {
			$rating = -1;
		}
	} else {
		$queryUserMatch = mysql_query('SELECT rating FROM user_matchings WHERE user_id='.$userId.' AND match_id= ' . $matchId);
		if (mysql_num_rows($queryUserMatch) > 0){
			$row = mysql_fetch_array($queryUserMatch);
			$rating = $row['rating'];
		} else {
			$rating = -1;
		}
	}
		?>
		
		<script type="text/javascript">
				$(function () {
					var that = this;
					var startTime = new Date().getTime();
					var toolitup = $("#jRate_<?php echo $matchId?>").jRate({
						<?php if ($rating != -1) {  ?>
							rating: <?php echo $rating / 2; ?>,
							readOnly: true,
						<?php } ?>
						count: 10,
						startColor: 'yellow',
						endColor: 'red',
						strokeColor: 'black',
						width: <?php echo $size; ?>,
						height: <?php echo $size; ?>,
						precision: 0.5,
						onChange: function(rating) {
							$("#rating_label_<?php echo $matchId; ?>").text(rating*2+"/10");
						},
						onSet: function(rating) {
							var endTime = new Date().getTime();
							var ratingTime = endTime-startTime;
							$.ajax({ url: "handle_match_rating.php?skipped=false&matchId=<?php echo $matchId; ?>&userId=<?php echo $userId; ?>&rating="+rating*2+"&ratingTime="+ratingTime+"&matchItemId=<?php echo $matchItemId; ?>",
							        context: document.body,
							        success: function(result) {							
							        	$("#match_<?php echo $matchId; ?>").html(result);
							        }});
						}
					});	
				});
			</script>
		
		<div id="jRate_<?php echo $matchId?>"><p >You Rated: </p></div>
		<?php if ($rating == -1) { ?>
			<p><h3> <label class="label label-warning" id="rating_label_<?php echo $matchId?>">0/10</label> </h3> </p>
		<?php } else { ?>
			<p><h3> <label class="label label-warning" id="rating_label_<?php echo $matchId?>"><?php echo $rating; ?>/10</label> </h3> </p>
		<?php } ?>
		
<?php
}
?>