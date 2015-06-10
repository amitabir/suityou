<?php
include("config.php");
include("item.php");
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

	<h4 align="center"><span class="label label-info"><?php echo round($percent, 0); ?>% Match!</span></h4>
	
	<a href="show_item.php?itemId=<?php echo $matchItemId; ?>" class="thumbnail">
	<img src="<?php echo "images/items/".$matchItem->picture; ?>" alt="" width="100" height="100" />
	</a>
	<span align="center"><?php showRating($matchId, $userId, $matchItemId, 17); ?></span><br/>
