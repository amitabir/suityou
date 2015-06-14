<?php
include("config.php");
include("rating.php");


if(isset($_SESSION['user_id'])){
	$userId = $_SESSION['user_id'];
} else {
	$userId = NULL;
}
$matchId = $_GET["matchId"];
$matchItemId = $_GET["matchItemId"];

$queryMatches = mysql_query('SELECT * from item_matchings WHERE match_id = '.$matchId);
$row = mysql_fetch_array($queryMatches);
$percent= $row['match_percent'];
$matchItem = Item::getItemByID($matchItemId);

?>
	<div class="container col-xs-6 col-md-4" style="text-align:center;" >
			<h4 align="center"><span class="label label-info " style="position:relative; display:inline"><?php echo round($percent, 0); ?>% Match!</span></h4>
			<div class="img-container-small" align="center">
				<a href="show_item.php?itemId=<?php echo $matchItemId; ?>" class="thumbnail">
				<img class="img-responsive" src="<?php echo "images/items/".$matchItem->picture; ?>" alt=""/>
				</a>
			</div>
			<span align="center"><?php showRating($matchId, $userId, $matchItemId, 17); ?></span><br/>
	</div>