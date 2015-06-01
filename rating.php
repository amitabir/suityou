<?php
function showRating($matchId, $userId) {
	$queryUserMatch = mysql_query('SELECT rating FROM user_matchings WHERE user_id='.$userId.' AND match_id= ' . $matchId);
	if (mysql_num_rows($queryUserMatch)>0){
		$row = mysql_fetch_array($queryUserMatch);
		$rating = $row['rating'];
	} else {
		$rating = -1;
	}
	?>
		
		<script type="text/javascript">
				$(function () {
					var that = this;
					var startTime = new Date().getTime();
					var toolitup = $("#jRate_<?php echo $matchId?>").jRate({
						<?php if ($rating != -1) {  ?>
							rating: <?php echo $rating / 2;  ?>,
							readOnly: true,
						<?php } ?>
						count: 10,
						startColor: 'yellow',
						endColor: 'red',
						strokeColor: 'black',
						width: 20,
						height: 20,
						precision: 0.5,
						onSet: function(rating) {
							var endTime = new Date().getTime();
							var ratingTime = endTime-startTime;
							$.ajax({ url: "handle_match_rating.php?skipped=false&matchId=<?php echo $matchId; ?>&userId=<?php echo $userId; ?>&rating="+rating*2+"&ratingTime="+ratingTime,
							        context: document.body,
							        success: function(result) {
							         // $("#match").html(result);
							        }});
						}
					});	
				});
			</script>
		<?php if ($rating != -1) { ?>
			You Rated:
		<?php } ?>
		<div id="jRate_<?php echo $matchId?>"></div>
<?php
}
?>