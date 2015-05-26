<?php
include("config.php");
include("header.php");
include('Item.php');

$itemId = $_GET["itemId"];
$item = Item::getItemByID($itemId);
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
			</div>			
        </div>
    </div>

</div>

  </body>
</html>