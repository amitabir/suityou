<?php
include("header.php");
include("rating.php");
include("algorithms.php");

if(isset($_SESSION['item_update_message']) and isset($_SESSION['item_update_success'])) {
	$message = $_SESSION['item_update_message'];
	if ($_SESSION['item_update_success']) {
		$class='"alert alert-success alert-dismissible"';
	} else {
		$class='"alert alert-danger alert-dismissible"';
	}
	if(!empty($message)) {
		echo '<div class='.$class.' role="alert">';
		echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		echo $message;
		echo '</div>';
		unset($_SESSION['item_update_message']);
	}
	unset($_SESSION['item_update_success']);
}

$outOfStockValue = "OUT_OF_STOCK";

$itemId = $_GET["itemId"];

if(isset($_SESSION['user_id'])){
	$userId = $_SESSION['user_id'];
} else {
	$userId = NULL;
}

$item = Item::getItemByID($itemId);
if ($item->type=="TOP"){
	$typeColId="top_item_id";
}else{
	$typeColId="bottom_item_id";
}
$queryMatches = mysql_query('SELECT * from item_matchings WHERE '.$typeColId. '='.$item->itemId);

$sorted_matches = array();
while ($queryRow = mysql_fetch_array($queryMatches)) {
	if ($queryRow["match_type"] == 1) {
		$key = $queryRow['match_percent'];
	} else {
		$key = calculateTotalScoreForTrends($queryRow["match_id"]);
	}
	$consts = getConstants();
	if ($key >= $consts['MATCH_SCORE_LIMIT']) {
		$sorted_matches[$key] = $queryRow;
	}	
}
krsort($sorted_matches);


$designerNameQuery = mysql_query('SELECT first_name, last_name from users WHERE user_id = '.$item->designerId);
$designerRow = mysql_fetch_array($designerNameQuery);
?>
<script type="text/javascript" src="js/site_scripts/show_item_validator.js?2"></script>
<div class="container">	
	<div class="row">
        <div class="col-md-12">
            <h2 class="page-header"><?php echo $item->name; ?>
            </h2>
        </div>
    </div>
	
	<div class="row">
		
        <div class="col-md-3">
        	<div class="img-container-show">
            	<img class="img-responsive" src="<?php echo "images/items/". $item->picture; ?>" alt=""/>
            </div>
        </div>

        <div class="col-md-9">
            <h3>Item Description</h3>
            <p><?php echo $item->description; ?></p>
            <p>Designer: <a href = "designer_profile.php?designerId=<?php echo $item->designerId; ?>"><?php echo $designerRow["first_name"]." ".$designerRow["last_name"]; ?></a></p>
			<p>Price: <?php echo "$".$item->price; ?></p>
							<form id="addToCartForm" name="addToCartForm" method="post" action="cart.php?action=add" class="form-inline">
								 <select id="size" name='size' class="form-control">
			<?php
									$stockArray = $item->getItemStock();
									foreach ($stockArray as $stockId=>$stockData) {					
										if ($stockData["quantity"] > 0) {
			?>
											<option value="<?php echo $stockData["size"]; ?>"><?php echo $stockData["size"]; ?></option>	
			<?php
										} else {
			?>
											<option value="<?php echo $outOfStockValue ?>"><?php echo $stockData["size"]." - Out of stock"; ?></option>	
			<?php
										}
									}	
			?>
								</select>
								<input type="hidden" name="itemId" value="<?php echo $itemId; ?>" />
								<input type="hidden" name="picture" value="<?php echo $item->picture; ?>" />
								<input type="text" name="quantity" value="1" />
								<input type="submit" value="Add To Cart" class="btnAddCart" />
							</form>
							<?php if ($userId != NULL and $item->designerId == $userId) { ?>
								<p><a href='add_item.php?itemId=<?php echo $itemId;?>'> <button class="btn btn-primary">Update Item</button> </a></p>
							<?php } ?>
							<div id="errorBox">
								
							</div>
							<script>
							$(document).ready(function(){
								$('#addToCartForm').submit(function() {
									if ($('#size').val() == "<?php echo $outOfStockValue ?>") {
										$('#sizeOutOfStock').show();
										return false;
									}
									return true;
								});
							});
							
							</script>
							
							<div id="sizeOutOfStock" class="alert alert-danger alert-dismissible" role="alert" style="display: none">
							  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							  <strong>Error!</strong> Please choose a size that is available in stock.
							</div>
        </div>
	</div>
		
		<?php if (count($sorted_matches) > 0) {  ?>
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
				<?php
				$count = 0;
				foreach($sorted_matches as $key=>$matchRow) {
					if ($count == 6) {
						break;
					}
					$matchId = $matchRow['match_id'];
					if ($item->type == "TOP") {
						$matchItemId= $matchRow["bottom_item_id"];
					} else {
						$matchItemId= $matchRow['top_item_id'];
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
				$count++;
				}
				?>
			</div>
		<?php }  ?>
	</div>
  </body>
</html>