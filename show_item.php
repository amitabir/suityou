<?php
include("config.php");
include("header.php");
include('Item.php');
include("rating.php");

$itemId = $_GET["itemId"];
$userId = $_SESSION['user_id'];
$item = Item::getItemByID($itemId);
if ($item->type=="TOP"){
	$typeColId="top_item_id";
}else{
	$typeColId="bottom_item_id";
}
$queryMatches = mysql_query('SELECT match_id, top_item_id, bottom_item_id from item_matchings WHERE '.$typeColId. '='.$item->itemId);

$designerNameQuery = mysql_query('SELECT first_name, last_name from users WHERE user_id = '.$item->designerId);
$designerRow = mysql_fetch_array($designerNameQuery);
?>
    
<div class="container">	
	<div class="row">
        <div class="col-md-12">
            <h2 class="page-header"><?php echo $item->name; ?>
            </h2>
        </div>
    </div>
	
	<div class="row">
		
        <div class="col-md-3">
            <img class="img-thumbnail" src="<?php echo "images/items/". $item->picture; ?>" alt=""/>
        </div>

        <div class="col-md-9">
            <h3>Item Description</h3>
            <p><?php echo $item->description; ?></p>
            <p>Designer: <a href = designer_profile.php?designerId=$desId><?php echo $designerRow["first_name"]." ".$designerRow["last_name"]; ?></a></p>
			<p>Price: <?php echo "$".$item->price; ?></p>
							<form name="addToCartForm" method="post" action="cart.php?action=add" class="form-inline">
								 <select name='size' class="form-control">
			<?php
									$stockArray = $item->getItemStock();
									foreach ($stockArray as $stockId=>$stockData) {					
										if ($stockData["quantity"] > 0) {
			?>
											<option value="<?php echo $stockData["size"]; ?>"><?php echo $stockData["size"]; ?></option>	
			<?php
										} else {
			?>
											<option value="<?php echo $stockData["size"]; ?>"><?php echo $stockData["size"]." - Out of stock"; ?></option>	
			<?php
										}
									}	
			?>
								</select>
								<input type="hidden" name="itemId" value="<?php echo $itemId; ?>" />
								<input type="text" name="quantity" value="1" />
								<input type="submit" value="Add To Cart" class="btnAddCart" />
							</form>
        </div>
	</div>
	
		
				
				<!-- <div class="attributes">
					Categories:
					<table border="1px">
				<?php
					// $catArray = $item->getItemAttributes();
// 					foreach ($catArray as $category=>$categoryAttribute) {
// 						echo "<tr>";
// 				   		echo "<td>".$categoryAttribute["cat_name"]."</td> <td>". $categoryAttribute["att_name"] ."</td>";
// 						echo "</tr>";
// 				   	}
				?>
					</table> -->
				
		
		
		<?php if (mysql_num_rows($queryMatches) > 0) {  ?>
			<div class="row">
				<div class="col-lg-12">
				     <h4 class="page-header">
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
					</h4>
				</div>
			</div>
			<div class="row">
				<?php
				while($row = mysql_fetch_array($queryMatches)) {
					$matchId = $row['match_id'];
					if ($item->type == "TOP") {
						$matchItemId= $row["bottom_item_id"];
					} else {
						$matchItemId= $row['top_item_id'];
					}
				?>
					<script>
				$(document).ready(function(){
						$.ajax({ url: "show_item_match.php?matchId=<?php echo $matchId; ?>&matchItemId=<?php echo $matchItemId; ?>",
						        context: document.body,
						        success: function(result) {
						          $("#match_<?php echo $matchId; ?>").html(result);
						        }});
							});
						</script>
					<div id="match_<?php echo $matchId; ?>" class="col-sm-2">
					</div>
				<?php
				}
				?>
			</div>
		<?php }  ?>
	</div>
  </body>
</html>