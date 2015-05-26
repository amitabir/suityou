<?php
include("config.php");
include("header.php");
include('Item.php');

$itemId = $_GET["itemId"];
	$userId = $_SESSION['user_id'];
$item = Item::getItemByID($itemId);
if ($item->type=="TOP"){
	$typeColId="top_item_id";
}else{
	$typeColId="bottom_item_id";
}
$queryMatches = mysql_query('SELECT * from item_matchings WHERE '.$typeColId. '='.$item->itemId);
?>

    <div id="content_header"></div>
    <div id="site_content">
        <div id="content">
			<div class="item">
				<form name="addToCartForm" method="post" action="cart.php?action=add">
				<div><img src="<?php echo "images/items/". $item->picture; ?>"></div>
				<div><strong><?php echo $item->name; ?></strong></div>
				<div><?php echo $item->description; ?></div>
				<br/>
				<div class="attributes">
					Categories:
					<table border="1px">
				<?php
					$catArray = $item->getItemAttributes();
					foreach ($catArray as $category=>$categoryAttribute) {
						echo "<tr>";
				   		echo "<td>".$categoryAttribute["cat_name"]."</td> <td>". $categoryAttribute["att_name"] ."</td>";
						echo "</tr>";
				   	}
				?>
					</table>
				</div>
				<br/>
				<div class="product-price">Price: <?php echo "$".$item->price; ?></div>

				<div>
					 <select name='size'>
<?php
						$stockArray = $item->getItemStock();
						foreach ($stockArray as $stockId=>$stockData) {					
							if ($stockData["quantity"] > 0) {
?>
								<option value="<?php echo $size; ?>"><?php echo $stockData["size"]; ?></option>	
<?php
							} else {
?>
								<option value="<?php echo $size; ?>"><?php echo $stockData["size"]." - Out of stock"; ?></option>	
<?php
							}
						}	
?>
					</select>
					<input type="hidden" name="itemId" value="<?php echo $itemId; ?>" />
					<input type="text" name="quantity" value="1" size="2" />
					<input type="submit" value="Add To Cart" class="btnAddCart" />
				</div>
				</form>
				<table border="1">
				<tr>
				<?php
				if ($item->type == "TOP"){
					if ($item->gender == "MALE"){
						echo "Matching Pants:";
					} else{
						echo "Matching Pants and Skirts:";
					}
				} else{
					echo "Matching Shirts:";
				}
				?>
				</tr>
				<tr>
				<?php
				while($row = mysql_fetch_array($queryMatches)) {
					$matchId = $row['match_id'];
					$percent= $row['match_percent'];
					if ($item->type == "TOP"){
						$matchItemId= $row["bottom_item_id"];
					}else{
						$matchItemId= $row['top_item_id'];
					}
					$matchItem = Item::getItemByID($matchItemId);
				?>
					<td>
					match rating: <?php echo "$".$percent; ?> %
					<br/>
					<img src="<?php echo "images/items/". $matchItem->picture; ?>">
					<br/>
				<?php
					$queryUserMatch=mysql_query('SELECT rating FROM user_matchings WHERE user_id='.$userId.' AND match_id= ' . $matchId);
					if (mysql_num_rows($queryUserMatch)>0){
						$row=mysql_fetch_array($queryUserMatch);
						$rating=$row['rating'];
					} else {
						$rating = -1;
					}
					echo '<span class="star-rating">';
					for ($i = 1; $i <= 10; $i++) {
						echo '<input type="radio" name="rating"';
						if ($rating != -1){
							if ($i==$rating){
								echo ' checked disabled';
							}else{
								echo ' disabled';
							}
						}
						echo ' value="'.$i.'" onclick="submitUserRating('.$matchId.', '.$userId.', $(this).val(), 10);"><i></i>';
					}
					echo '</span>';
				?>
					<br/>
					<a href='show_item.php?itemId=<?php echo $matchItemId;?>'> Buy Now </a>
					</td>
				<?php
				}
				?>
			</tr>
			</table>
			</div>			
        </div>
    </div>

</div>

  </body>
</html>