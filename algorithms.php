<?php
	include("Item.php");
	define("VOTES_LIMIT_FOR_ACCEPT", 10);
	define("DIFF_FOR_ACCEPT", 10);
	define("IGNORED_VOTES_LIMIT", 10);
	define("NUMBER_OF_CATEGORIES", 6);
	define("MINIMAL_TIME", 0.1);
	define("REPEAT_LIMIT", 10);
	define("TREND_SCORE_LIMIT", 50);
	define("MATCH_SCORE_LIMIT", 50);
	define("AVERAGE_LIMIT", 8);
	define("STDEV_LIMIT", 1);
	define("TREND_CONSTANT", 0.5);
	define("MATCH_CONSTANT", 0.5);
	define("PERCENT_FACTOR", 10);
	
	/* This function receives data about match rating for two items and a new vote value and returns the new rating, new number of 
	   ignored votes and the new ignored average. */
	// Normal match
	function calcNewRatingForTwoItems($newRating, $averageRating, $numberOfVotes, $numberOfIgnoredVotes, $ignoredAverage) {
		$newRating *= PERCENT_FACTOR;
		// Accept new rating - may be not enough votes yet or new vote is not dramatically different.
		if(($numberOfVotes < VOTES_LIMIT_FOR_ACCEPT) or (abs($newRating - $averageRating) <= DIFF_FOR_ACCEPT)){
			$newNumberOfVotes = $numberOfVotes + 1;
			$newAverage = ($newRating + $averageRating * $numberOfVotes)/($newNumberOfVotes);
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
/* 	function calcCounterMovementForAttributesFromTwoItems($rating){
		switch($rating){
			case 10 :
				return -5;
			case 20 :
				return -4;
			case 30 :
				return -3;
			case 40 :
				return -2;
			case 50 :
				return -1;
			case 60 :
				return 1;
			case 70 :
				return 2;
			case 80 :
				return 3;
			case 90 :
				return 4;
			case 100 :
				return 5;
			default :
				return 0;
		}
	} */
	
	function isSpammer($userID){
		$query = mysql_query("SELECT is_spammer FROM Users WHERE user_id = $userID");
		$row = mysql_fetch_array($query);
		return $row['is_spammer'];
	}
	
	/* This function receives an old average rating. a new average rating and the match ID and updates all the attributes counters
		associated if necessary. */
	// Trends
/* 	function dealWithNewVoteTrend(){

		$query = mysql_query("SELECT * FROM item_matchings WHERE match_id = $matchID");
		$row = mysql_fetch_array($query);
		$topID = $row['top_item_id'];
		$bottomID = $row['bottom_item_id'];
		$topItem = Item::getItemByID($topID);
		$bottomItem = Item::getItemByID($bottomID);
		$topAttArray = $topItem->getItemAttributes();
		$bottomAttArray = $bottomItem->getItemAttributes();
		foreach($topAttArray as $category=>$info){
			if(array_key_exists($category, $bottomAttArray)){
				$topAttributeID = $info['att_id'];
				$bottomAttributeID = $bottomAttArray[$category]['att_id'];
				$attQuery = mysql_query("SELECT * FROM attribute_scores WHERE attribute1_id = $topAttributeID AND attribute2_id = $bottomAttributeID");
				if(mysql_num_rows($attQuery) > 0){
					$attRow = mysql_fetch_array($attQuery);
					$newScore = $attRow['score'] + $counterMovement;
					mysql_query("UPDATE attribute_scores
								 SET score = $newScore
								 WHERE attribute1_id = $topAttributeID AND attribute2_id = $bottomAttributeID");
				} else {
					mysql_query('INSERT INTO attribute_scores(attribute1_id, attribute2_id, score) VALUES ('.$topAttributeID.', '.$bottomAttributeID.', '.$counterMovement.')') or die(mysql_error());
				}
			}
		}
	} */
	
	function calculateTotalScoreForTrends($trendID){
		$matchQuery = mysql_query("SELECT match_percent, match_count, trend_percent 
		FROM item_matchings WHERE match_id = ".$trendID) or die(mysql_error());
		$matchRow = mysql_fetch_array($matchQuery);
		if($matchRow["match_count"] > VOTES_LIMIT_FOR_ACCEPT){
			return (TREND_CONSTANT * $matchRow["trend_percent"] + MATCH_CONSTANT * $matchRow["match_percent"])/(TREND_CONSTANT + MATCH_CONSTANT);
		}
		return $matchRow["match_percent"];
	}
	
	function isGoodCouple($data){
		if($data["avg"] > AVERAGE_LIMIT and $data["stdev"] < STDEV_LIMIT){
			return true;
		}
		return false;
	}
	
	function calculateTrendScore($topItemAttributes, $bottomItemAttributes, $attributesData){
		$score = 0;
		$count = 0;
		foreach($topItemAttributes as $topCategoryID=>$topAttribute){
			foreach($bottomItemAttributes as $bottomCategoryID=>$bottomAttribute){
				if($topCategoryID == $bottomCategoryID){
					$topAttributeID = $topAttribute["att_id"];
					$bottomAttributeID = $bottomAttribute["att_id"];
					if(array_key_exists($topAttributeID."-".$bottomAttributeID, $attributesData)){
						$count++;
						$score += PERCENT_FACTOR * $attributesData[$topAttributeID."-".$bottomAttributeID]["avg"]/NUMBER_OF_CATEGORIES;
					}
				}
			}
		}
		return $score;
	}
	
	function checkIfMatchAndTrendExists($topItemID, $bottomItemID){
		$matchQuery = mysql_query("SELECT match_type FROM item_matchings WHERE
		top_item_id = ".$topItemID." AND bottom_item_id = ".$bottomItemID) or die(mysql_error());
		if(mysql_num_rows($matchQuery)== 0){
			$matchExists = false;
			$trendExists = false;
		} else {
			$matchRow = mysql_fetch_array($matchQuery);
			if($matchRow[0] == 1){
				$matchExists = true;
				$trendExists = false; //doesn't matter
			} else {
				$matchExists = false;
				$trendExists = true;
			}
		}
		return array($matchExists, $trendExists);
	}
	
	function dealWithNewVoteTrend(){
		$query = mysql_query("SELECT att1.attribute_id, att2.attribute_id, AVG(user_matchings.rating), 
		STDDEV(user_matchings.rating) FROM user_matchings INNER JOIN item_matchings, items it1, items it2, 
		item_attributes itatt1, item_attributes itatt2, attributes att1, attributes att2 WHERE user_matchings.rating 
		is not NULL AND user_matchings.match_id = item_matchings.match_id AND item_matchings.top_item_id = it1.item_id 
		AND item_matchings.bottom_item_id = it2.item_id AND itatt1.item_id = it1.item_id AND itatt2.item_id = it2.item_id 
		AND att1.attribute_id = itatt1.attribute_id AND att2.attribute_id = itatt2.attribute_id AND 
		att1.category_id = att2.category_id GROUP BY att1.attribute_id, att2.attribute_id") or die(mysql_error());
		$attributesData = array();
		while($row = mysql_fetch_array($query)){
			$attributesData[$row[0]."-".$row[1]] = array("avg" => $row[2], "stdev" => $row[3]);
		}
		foreach($attributesData as $attributes=>$data){
			$attributesID = explode("-", $attributes);
			$itemsQuery = mysql_query("SELECT it1.item_id, it2.item_id FROM items it1, items it2,
			item_attributes itatt1, item_attributes itatt2 WHERE itatt1.attribute_id =".$attributesID[0]." AND 
			itatt2.attribute_id = ".$attributesID[1]." AND it1.item_id = itatt1.item_id AND it2.item_id = itatt2.item_id 
			AND it1.type = 'TOP' AND  it2.type = 'BOTTOM' AND it1.gender = it2.gender") or die(mysql_error());
			$items = mysql_fetch_array($itemsQuery);
			if(empty($items)){
				continue;
			}
			$topItem = Item::getItemByID($items[0]);
			$bottomItem = Item::getItemByID($items[1]);
			$topItemAttributes = $topItem->getItemAttributes();
			$bottomItemAttributes = $bottomItem->getItemAttributes();
			$matchAndTrendExists = checkIfMatchAndTrendExists($items[0], $items[1]);
			if(!$matchAndTrendExists[0]){
				$trendScore = calculateTrendScore($topItemAttributes, $bottomItemAttributes, $attributesData);
				if($matchAndTrendExists[1]){
					mysql_query("UPDATE item_matchings SET trend_percent = ".$trendScore."
					WHERE top_item_id = ".$items[0]." AND bottom_item_id = ".$items[1]) or die(mysql_error());
					exit;
				} else if(isGoodCouple($data) and $trendScore >= TREND_SCORE_LIMIT) {
					mysql_query("INSERT INTO item_matchings(top_item_id, bottom_item_id, trend_percent, match_type)
					VALUES (".$items[0].", ".$items[1].", ".$trendScore.", 0)") or die(mysql_error());
					exit;
				}
/* 						if($matchAndTrendExists[1]){
						mysql_query("DELETE FROM item_matchings WHERE top_item_id = items[0] AND bottom_item_id = items[1]");
					} */
			}
		}
		
	}
	
	function removeOldTrends(){
		$matchTrendQuery = mysql_query("DELETE FROM item_matchings WHERE match_type = 0 AND (trend_percent < ".TREND_SCORE_LIMIT." OR match_percent < ".MATCH_SCORE_LIMIT.")") or die(mysql_error());
	}
	
	/* This function receives a vote, a match ID which the vote belongs to and a user ID which gave the vote.
	   First a spammer check is made and if the user is clean then get the necessary data from the DB, run the
	   calcNewRatingForTwoItems function and update the DB. */
	// Normal match + Trends
	function handleUserRating($matchID, $userID, $vote, $time) {
		//trackSpammer($userID, $vote, $time);
		//if(!isSpammer($userID)){
		if(True) {
			$query = mysql_query("SELECT * FROM item_matchings WHERE match_id =".$matchID) or die(mysql_error());
			$row = mysql_fetch_array($query);
			$averageRating = $row['match_percent'];
			$numberOfVotes = $row['match_count'];
			$ignoredAverage = $row['ignored_match_percent'];
			$numberOfIgnoredVotes = $row['ignored_match_count'];
			$result = calcNewRatingForTwoItems($vote, $averageRating, $numberOfVotes, $numberOfIgnoredVotes, $ignoredAverage);
			mysql_query("UPDATE item_matchings
					 	 SET match_percent =".$result[0].", match_count = ".$result[1].", ignored_match_percent = ".$result[2].", ignored_match_count = ".$result[3]." WHERE match_id = ".$matchID) or die(mysql_error());
			
			mysql_query('INSERT INTO user_matchings(user_id, match_id, rating) VALUES ('.$userID.', '.$matchID.', '.$vote.')') or die(mysql_error());
			
			dealWithNewVoteTrend();
			
			removeOldTrends();
		}	
	}
	
	function handleUserSkip($matchID, $userID) {
		mysql_query('INSERT INTO user_matchings(user_id, match_id, skipped) VALUES ('.$userID.', '.$matchID.', 1)') or die(mysql_error());
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
			if($row["match_type"] == 0){
				continue;
			}
			return $row["match_id"];
			$userMatchesQuery = mysql_query("SELECT * FROM user_matchings WHERE match_id = ".$row["match_id"]);
			$userAnswered = mysql_num_rows($userMatchesQuery);
			if ($userAnswered == 0) {
				var_dump($row);
				return $row["match_id"];
			}
		}
		// TODO - return something else when the user answered everything
		return $row["match_id"];
	}
?>