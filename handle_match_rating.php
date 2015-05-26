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
	
	$newMatchId = getUserNextMatchQuestion($userId);
	
	header("location: show_match.php?matchId=".$newMatchId);
?>
