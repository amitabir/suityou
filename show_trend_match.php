<?php
include("config.php");
include("rating.php");

if(isset($_SESSION['user_id'])){
	$userId = $_SESSION['user_id'];
} else {
	$userId = NULL;
}

$matchId = $_GET["matchId"];

$queryMatches = mysql_query('SELECT * from item_matchings WHERE match_id = '.$matchId);
$row = mysql_fetch_array($queryMatches);
$percent= $row['match_percent'];

?>

	<!-- <h4 align="center"><span class="label label-info"><?php echo round($percent, 0); ?>% Match!</span></h4> -->
	What do you think?
	<span align="center"><?php showRating($matchId, $userId, NULL, 25); ?></span><br/>
