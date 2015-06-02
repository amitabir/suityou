<?php
include("header.php");

// TODO this page is meant to be only for admin

$matchQuery = mysql_query('SELECT * FROM item_matchings WHERE match_type = 1');
?>
    <div id="content_header"></div>
    <div id="site_content">
        <div id="content">
            <div id="content-part">
                <h2>Welcome to SuitYou!</h2>
            </div>
			<a href='add_match.php'> Add New Match </a>
			<table border="1px">
				<tr>
					<td>ID</td>
					<td>Top Item</td>
					<td>Bottom Item</td>
					<td>Percent</td>
					<td>Count</td>
					<td>Model</td>
					<td>Action</td>
				</tr>
<?php
			   	while($matchRow = mysql_fetch_array($matchQuery)) {
					$matchId = $matchRow['match_id'];
			   		$topItemId = $matchRow['top_item_id'];
			   		$bottomItemId = $matchRow['bottom_item_id'];
					$matchCount = $matchRow['match_count'];
					$matchPercent = $matchRow['match_percent'];
					$modelPicture = $matchRow['model_picture'];
					echo "<tr>";
			   		echo "<td> $matchId </td> <td> <a href='show_item.php?itemId=$topItemId'> Top Item </a> </td> <td> <a href='show_item.php?itemId=$bottomItemId'> Bottom Item </a> </td> <td> ".round($matchPercent,2)."% </td> <td> $matchCount </td> <td> <img width='170' src=images/models/$modelPicture /> </td> <td> <a href='add_match?matchId=$matchId'> Update Match </a><br/><a href='manage_match_logic?action=remove&matchId=$matchId'> Remove Match </a> </td>";
					echo "</tr>";
			   	}
			   ?>
			</table>
			
			
        </div>
    </div>

</div>

  </body>
</html>