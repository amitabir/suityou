<?php
	define("VOTES_LIMIT", 10);
	define("DIFF_FOR_ACCEPT", 1);
	define("IGNORED_VOTES_LIMIT", 10);
	define("NUMBER_OF_CATEGORIES", 10);
	define("MINIMAL_TIME", 0.1);
	define("REPEAT_LIMIT", 10);
	
	/* This function receives data about match rating for two items and a new vote value and returns the new rating, new number of 
	   ignored votes and the new ignored average. */
	// Normal match
	function calcNewRatingForTwoItems($newRating, $averageRating, $numberOfVotes, $numberOfIgnoredVotes, $ignoredAverage) {
		$newRating *= 10;
		// Accept new rating - may be not enough votes yet or new vote is not dramatically different.
		if((numberOfVotes < VOTES_LIMIT) or (abs($newRating - $averageRating) <= DIFF_FOR_ACCEPT)){
			$newAverage = ($newRating + $averageRating * $numberOfVotes)/($numberOfVotes + 1);
			$newNumberOfVotes = $numberOfVotes + 1;
			$newIgnoredAverage = $ignoredAverage;
			$newNumberOfIgnoredVotes = $numberOfIgnoredVotes;
		// Vote was rejected
		} else {
			$newIgnoredAverage = ($newRating + $ignoredAverage * $numberOfIgnoredVotes)/($numberOfIgnoredVotes + 1);
			$newNumberOfIgnoredVotes = $numberOfIgnoredVotes + 1;
			// Number of ignored votes reached limits so join the rating with rejected rating
			if($newNumberOfIgnoredVotes == IGNORED_VOTES_LIMIT){
				$newAverage = ($averageRating * $numberOfVotes + $newIgnoredAverage * ($numberOfIgnoredVotes + 1))/($numberOfIgnoredVotes + 1 + $numberOfVotes);
				$newNumberOfVotes = $numberOfVotes + $newNumberOfIgnoredVotes;
				$newNumberOfIgnoredVotes = 0;
				$newIgnoredAverage = 0;
			// Add new vote to the rejected
			} else {
				$newAverage = $averageRating;
				$newNumberOfVotes = $numberOfVotes;
			}
		}
		return array($newAverage, $newNumberOfVotes, $newIgnoredAverage, $newNumberOfIgnoredVotes);
	}
	
	/* This function receives two array. The first is the ratings of all the attributes and the second is the weight to 
		be given for each one. The weighted arithmetic mean is calculated and returned. */
	// Trends
	function calcTotalRatingForTwoItems(array $atrributesRatings, array $weights){
		// Calculating the total weight.
		$totalWeight = 0;
		foreach($weights as $weight){
			$totalWeight += $weight;
		}
		// Calculating the total rating
		$totalRating = 0;
		for($i = 0; $i < count($weights); $i++){
			$totalRating += $averageRating[i] * $weights[i];
		}
		// Returning the averaged rating;
		return totalRating / totalWeight;
	}
	
	/* This function receives a rating for two items and computes what movement all the counters associated with them
		should take. */
	// Trends
	function calcCounterMovementForAttributesFromTwoItems($averageRating){
		switch(true){
			case $averageRating <= 10 :
				return -5;
			case $averageRating > 10 && $averageRating <= 20 :
				return -4;
			case $averageRating > 20 && $averageRating <= 30 :
				return -3;
			case $averageRating > 30 && $averageRating <= 40 :
				return -2;
			case $averageRating > 40 && $averageRating < 50 :
				return -1;
			case $averageRating > 50 && $averageRating <= 60 :
				return 1;
			case $averageRating > 60 && $averageRating <= 70 :
				return 2;
			case $averageRating > 70 && $averageRating <= 80 :
				return 3;
			case $averageRating > 80 && $averageRating <= 90 :
				return 4;
			case $averageRating > 90 && $averageRating <= 100 :
				return 5;
			default :
				return 0;
		}
	}
	
	function isSpammer($userID){
		$query = mysql_query("SELECT is_spammer FROM Users WHERE user_id = $userID");
		$row = mysql_fetch_array($query);
		return $row['is_spammer'];
	}
	
	/* This function receives an old average rating. a new average rating and the match ID and updates all the attributes counters
		associated if necessary. */
	// Trends
	function dealWithNewVoteTrend($averageRating, $newAverage, $matchID){
		$oldAverageCounterMovement = calcCounterMovementForAttributesFromTwoItems($averageRating);
		$newAverageCounterMovement = calcCounterMovementForAttributesFromTwoItems($newAverage);
		$counterMovement = $newAverageCounterMovement - $oldAverageCounterMovement;
		if($counterMovement != 0){
			$query = mysql_query("SELECT * FROM ItemMatchings WHERE match_id = $matchID");
			$row = mysql_fetch_array($query);
			$topID = $row['top_id'];
			$bottomID = $row['bottom_id'];
			for($i = 0; $i < NUMBER_OF_CATEGORIES; $i++){
				$topQuery = mysql_query("SELECT * FROM ItemAttributes WHERE category_id = $i AND item_id = $topID");
				$bottomQuery = mysql_query("SELECT * FROM ItemAttributes WHERE category_id = $i AND item_id = $bottomID");
				$topRow = mysql_fetch_array($topQuery);
				$bottomRow = mysql_fetch_array($bottomQuery);
				$topAttributeID = $topRow[attribute_id];
				$bottomAttributeID = $bottomRow[attribute_id];
				$scoreQuery = mysql_query("SELECT * FROM AttributeScore WHERE attribute_1_id = $topAttributeID AND attribute_2_id = $bottomAttributeID");
				$scoreRow = mysql_fetch_array($scoreQuery);
				$newScore = $scoreRow['score'];
				$newScore += $counterMovement;
				mysql_query("UPDATE AttributeScore
							 SET score = $newScore
							 WHERE attribute_1_id = $topAttributeID AND attribute_2_id = $bottomAttributeID");
			}
		}
	}
	
	/* This function receives a vote, a match ID which the vote belongs to and a user ID which gave the vote.
	   First a spammer check is made and if the user is clean then get the necessary data from the DB, run the
	   calcNewRatingForTwoItems function and update the DB. */
	// Normal match + Trends
	function handleUserRating($matchID, $userID, $vote, $time) {
		//trackSpammer($userID, $vote, $time);
		//if(!isSpammer($userID)){
		if(True) {
			$query = mysql_query("SELECT * FROM item_matchings WHERE match_id = $matchID");
			$row = mysql_fetch_array($query);
			$averageRating = $row['match_precent'];
			$numberOfVotes = $row['match_count'];
			$ignoredAverage = $row['ignored_match_percent'];
			$numberOfIgnoredVotes = $row['ignored_match_count'];
			$result = calcNewRatingForTwoItems($vote, $averageRating, $numberOfVotes, $numberOfIgnoredVotes, $ignoredAverage);
			mysql_query("UPDATE item_matchings
					 	 SET match_percent =".$result[0].", match_count = ".$result[1].", ignored_match_percent = ".$result[2].", ignored_match_count = ".$result[3]." WHERE match_id = ".$matchID) or die(mysql_error());
			
			//mysql_query('INSERT INTO user_matchings(user_id, match_id, rating) VALUES ('.$userID.', '.$matchID.', '.$vote.')') or die(mysql_error());
			
			// TODO enable
			//dealWithNewVoteTrend($averageRating, $newAverage, $matchID);
		}	
	}
	
	function handleUserSkip($matchID, $userID) {
		mysql_query('INSERT INTO user_matchings(user_id, match_id, skipped) VALUES ('.$userID.', '.$matchID.', 1)') or die(mysql_error());
	}
	
	function generateTrends(){
		
	}
	
	/* This function receives a user id, his vote and the time it took for him to vote. Then the function decides if
		the user is a spammer and if so updates it to the DB. It also updates the time_tracking, vote_tracking and
		last_vote fields un the Users table.*/
	function trackSpammer($userId, $vote, $time){
		$query = mysql_query("SELECT * FROM Users WHERE user_id = $userID");
		$row = mysql_fetch_array($query);
		if($time < MINIMAL_TIME){
			$timeTracking = $row['time_tracking'] + 1;
			mysql_query("UPDATE Users
						 SET time_tracking = $timeTracking
						 WHERE user_id = $userID");
			if($timeTracking > REPEAT_LIMIT){
				mysql_query("UPDATE Users
							 SET is_spammer = TRUE
							 WHERE user_id = $userID");
			}
		} else {
			mysql_query("UPDATE Users
			 SET time_tracking = 0
			 WHERE user_id = $userID");
		}
		$lastVote = $row['last_vote'];
		if($vote == $lastVote){
			$voteTracking = $row['vote_tracking'] + 1;
			mysql_query("UPDATE Users
						 SET vote_tracking = $voteTracking
						 WHERE user_id = $userID");
			if($voteTracking > REPEAT_LIMIT){
				mysql_query("UPDATE Users
							 SET is_spammer = TRUE
							 WHERE user_id = $userID");
			}
		} else {
			mysql_query("UPDATE Users
			 SET vote_tracking = 0 AND last_vote = $vote
			 WHERE user_id = $userID");
		}
	}
	
	function getUserNextMatchQuestion($userId) {
		$itemsQuery = mysql_query("SELECT * FROM item_matchings ORDER BY match_count");
		while($row = mysql_fetch_array($itemsQuery)) {
			$userMatchesQuery = mysql_query("SELECT * FROM user_matchings WHERE match_id = ".$row["match_id"]);
			$userAnswered = mysql_num_rows($userMatchesQuery);
			if ($userAnswered == 0) {
				return $row["match_id"];
			}
		}
		// TODO - return something else when the user answered everything
		return $row["match_id"];
	}
?>