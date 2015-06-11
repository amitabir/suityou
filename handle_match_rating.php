<?php
	include("config.php");
	include("algorithms.php");				
	
	$skipped = $_GET['skipped'];
	$matchId = $_GET['matchId'];
	$userId = $_GET['userId'];
	if (!empty($_GET['rating'])) {
		$rating = $_GET['rating'];
	}
	if (!empty($_GET['ratingTime'])) {
		$ratingTime = $_GET['ratingTime'];
	}	
	
	if ($skipped == "true") {
		handleUserSkip($matchId, $userId);
	} else {
		handleUserRating($matchId, $userId, $rating, $ratingTime);
	}	
	
	if (isset($_GET['matchItemId'])) {
		if (empty($_GET['matchItemId'])) {
			header("location: show_trend_match?matchId=".$matchId);
		} else {
			header("location: show_item_match?matchId=".$matchId."&matchItemId=".$_GET['matchItemId']);
		}
	} else {
		$newMatchId = getUserNextMatchQuestion($userId);
		header("location: show_match.php?matchId=".$newMatchId);
	}
?>
