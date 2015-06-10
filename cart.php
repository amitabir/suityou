<?php
include("header.php");
include('Item.php');

$displayMaxMessage = false;

function updateQuantityInCart($itemStockId, $quantity) {
	$displayMaxMessage = false;
	$itemStockQuery = mysql_query("SELECT * FROM items_stock WHERE item_stock_id =".$itemStockId);
	$itemStockRow = mysql_fetch_array($itemStockQuery);
	if ($quantity > $itemStockRow['quantity']) {
		$quantity = $itemStockRow['quantity'];
		$displayMaxMessage = true;
	}
	
	foreach($_SESSION["cart_item"] as $k => $v) {
		if($itemStockId == $k) {
			$_SESSION["cart_item"][$k]["quantity"] = $quantity;
		}
	}
	
	return $displayMaxMessage;
}

if(!empty($_GET["action"])) {
	switch($_GET["action"]) {
		case "add":
			// Get parameters from form
			if(!empty($_POST["quantity"]) && !empty($_POST["itemId"]) && !empty($_POST["size"])) {
				$quantity = $_POST["quantity"];
				$itemId = $_POST["itemId"];
				$size = $_POST["size"];
				$picture = $_POST["picture"];

				// Get the item details and stock detail
				$item = Item::getItemByID($itemId);
				$itemStockArr = $item->getItemStock($size);
				reset($itemStockArr);
				$itemStockId = key($itemStockArr);
		
				// Create array with item's data, pointed by the item stock id.
				$itemArray = array($itemStockId => array('name'=>$item->name, 'id'=>$itemStockId, 'price'=>$item->price, 'quantity'=>$quantity, 'size'=>$size, 'picture'=>$picture));
				if(!empty($_SESSION["cart_item"])) {
					if(array_key_exists($itemStockId, $_SESSION["cart_item"])) {
						// Update quantity for existing items (stock items)
						foreach($_SESSION["cart_item"] as $k => $v) {
							if($itemStockId == $k) {
								$displayMaxMessage = updateQuantityInCart($itemStockId, $_SESSION["cart_item"][$k]["quantity"] + $quantity);
							}
						}
					} else {
						$_SESSION["cart_item"] = $_SESSION["cart_item"] + $itemArray;
					}
				} else {
					$_SESSION["cart_item"] = $itemArray;
				}
			}	
		break;
		
		case "update":
			if(!empty($_GET["itemStockId"])) {
				$itemStockId = $_GET["itemStockId"];
				$qtyKey = "qty_".$itemStockId;
				$quantity = $_POST[$qtyKey];
				
				if(!empty($_SESSION["cart_item"])) {
					$displayMaxMessage = updateQuantityInCart($itemStockId, $quantity);
				}
			}
		break;
		case "remove":
			if(!empty($_GET["itemStockId"])) {
				if(!empty($_SESSION["cart_item"])) {
					foreach($_SESSION["cart_item"] as $k => $v) {
						if($_GET["itemStockId"] == $k) {
							unset($_SESSION["cart_item"][$k]);	
						}			
						if(empty($_SESSION["cart_item"])) {
							unset($_SESSION["cart_item"]);
						}
					}
				}
			}
		break;
		case "empty":
			unset($_SESSION["cart_item"]);
		break;	
	}
}
?>
<script type="text/javascript" src="cart_qty_validate.js?2"></script>
<script>
function showUpdate(elementId) {
	console.log("Going to update " + elementId);
	document.getElementById(elementId).style.display = 'block';
}
</script>
	
	<div id="shopping-cart" class="container">
		
		<?php
		if(isset($_SESSION["cart_item"])) {
		    $item_total = 0;
			if ($displayMaxMessage) {
				?> 
					<h3> The quantity has been changed to an amount that is currently available for this item. </h3>
		<?php 
		}
		?>	
		<table class="table" cellpadding="10" cellspacing="1">
			<thead>
				<tr>
					<th class="col-md-6"><strong>Item Description</strong></th>
					<th class="col-md-2"><strong>Size</strong></th>
					<th class="col-md-1"><strong>Quantity</strong></th>
					<th class="col-md-3"><div align="right"><strong>Price</strong></div></th>
				</tr>
			</thead>
			<tbody>
<?php		
    				foreach ($_SESSION["cart_item"] as $item) {
?>
					<tr>
						<td>
							<div class="row">
								<div class="col-xs-4">
							<a href="show_item.php?itemId=<?php echo $item["id"]; ?>" class="thumbnail">
							    <img src="images/items/<?php echo $item["picture"]; ?>" alt="" style="width:200px;height:200px">
							</a>
							</div>
								<div class="col-xs-8">
									<strong><?php echo $item["name"]; ?></strong>
									<div valign="bottom">
									<a href="cart.php?action=remove&itemStockId=<?php echo $item["id"]; ?>" class="btnRemoveAction">Remove Item</a>
									</div>
								</div>
							</div>
						</td>
						<td><?php echo $item["size"]; ?></td>
						<td><form name="updateCartForm_<?php echo $item["id"]; ?>" method="post" action="cart.php?action=update&itemStockId=<?php echo $item["id"]; ?>">
<input type="text" name="qty_<?php echo $item["id"]; ?>" value="<?php echo $item["quantity"]; ?>" size=8 onkeyup="showUpdate('qty_update_<?php echo $item["id"]; ?>')"/><input type="submit" value="Update" id="qty_update_<?php echo $item["id"]; ?>" style='display:none' /></form></td>
						<td align=right><?php echo "$".$item["price"]; ?></td>
					</tr>
<?php
        			$item_total += ($item["price"]*$item["quantity"]);
				}
?>
					<tr>
						<td><a id="btnEmpty" href="cart.php?action=empty"><button class="btn btn-sm btn-primary">Empty Cart</button></a></td>
						<td></td><td></td>
						<td>
							<p align="right"><strong>Total:</strong> <?php echo "$".$item_total; ?></p>
							<?php if (isset($_SESSION["user_id"])){
								$query=mysql_query('SELECT coupon_meter FROM users WHERE user_id= ' .$_SESSION["user_id"]);
								$row=mysql_fetch_array($query);
								$couponMeter=$row["coupon_meter"];
							} else{
								$couponMeter = 0;
							}
							if ($couponMeter == 100){//TODO- add options?
								$discount = 0.1*$item_total;
								$newTotal = 0.9 * $item_total;
								echo "<p align=right><strong>Coupon! 10% Discount:</strong> $$discount </p>";
								echo "<p align=right><strong>Total after Discount:</strong> $$newTotal </p>";

							}
							?>
							<p align="right"><a href="checkout.php"><button class="btn btn-primary">Checkout</button></a></p>
						</td>
					</tr>
				</tbody>
			</table>	
			
<?php
	} else {
?>
	<h3>Your shopping cart is empty</h3>
<?php
	}
	
?>
</div>

</BODY>
</HTML>