<?php
include("db_conf.php");
include("header.php");
$itemId = $_GET["itemId"];
$itemQuery = mysql_query("SELECT * FROM items WHERE id = $itemId");
$itemRow = mysql_fetch_array($itemQuery);
								
$name = $itemRow['name'];
$gender = $itemRow['gender'];
$type = $itemRow['type'];
$description = $itemRow['description'];
$picture = $itemRow['picture'];
$price = $itemRow['price'];
$designerId = $itemRow['designer_id'];
$color = $itemRow['color'];

?>
    <div id="content_header"></div>
    <div id="site_content">
        <div id="content">
			<div class="product-item">
				<form method="post" action="cart.php?action=add&itemId=<?php echo $itemId; ?>">
				<div><img src="<?php echo "images/".$picture ?>"></div>
				<div><strong><?php echo $name; ?></strong></div>
				<div><?php echo $description; ?></div>
				<div class="product-price"><?php echo "$".$price; ?></div>
				<div> 	
					 <select name='size'>
<?php
						$itemStockQuery = mysql_query("SELECT * FROM items_stock WHERE item_id = $itemId");
						while($stockRow = mysql_fetch_array($itemStockQuery)) {
							$size = $stockRow['size'];
							$quantity = $stockRow['quantity'];
							
							if ($quantity > 0) {
?>
								<option value="<?php echo $size; ?>"><?php echo $size; ?></option>	
<?php
							} else {
?>
								<option value="<?php echo $size; ?>"><?php echo $size." - Out of stock"; ?></option>	
<?php
							}
						}	
?>
					</select>
					<input type="text" name="quantity" value="1" size="2" />
					<input type="submit" value="Add To Cart" class="btnAddCart" />
				</div>
				</form>
			</div>			
        </div>
    </div>

</div>

  </body>
</html>