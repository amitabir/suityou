<?php
include("config.php");
include("rating.php");
include("algorithms.php");

if(isset($_SESSION['user_id'])){
	$userId = $_SESSION['user_id'];
} else {
	$userId = NULL;
}
$matchId = $_GET["matchId"];
$matchItemId = $_GET["matchItemId"];

$queryMatches = mysql_query('SELECT * from item_matchings WHERE match_id = '.$matchId);
if (mysql_num_rows($queryMatches) == 0) {
	?>
		<div id="match_removed_<?php echo $matchItemId; ?>">
			<div class="alert alert-danger alert-dismissible" role="alert" >
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <p><strong>Removed!</strong></p> <p> The match was removed because its rating is too low. </p>
			</div>
		</div>
<?php
} else {
	$row = mysql_fetch_array($queryMatches);
	if ($row['match_type'] == 1) {
		$percent = $row['match_percent'];
	} else {
		$percent = calculateTotalScoreForTrends($matchId);
	}

	$matchItem = Item::getItemByID($matchItemId);

	?>
		<div class="container col-xs-6 col-md-4" style="text-align:center;" >
				<h4 align="center"><span class="label label-info " style="position:relative; display:inline"><?php echo round($percent, 0); ?>% Match!</span></h4>
				<div class="img-container-small" align="center">
					<a href="show_item.php?itemId=<?php echo $matchItemId; ?>" class="thumbnail">
					<img class="img-responsive" src="<?php echo "images/items/".$matchItem->picture; ?>" alt=""/>
					</a>
				</div>
				<div><?php showRating($matchId, $userId, $matchItemId, 16); ?></div><br/>
		</div>
<?php } ?>