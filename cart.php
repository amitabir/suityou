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

				// Get the item details and stock detail
				$item = Item::getItemByID($itemId);
				$itemStockArr = $item->getItemStock($size);
				reset($itemStockArr);
				$itemStockId = key($itemStockArr);
		
				// Create array with item's data, pointed by the item stock id.
				$itemArray = array($itemStockId => array('name'=>$item->name, 'id'=>$itemStockId, 'price'=>$item->price, 'quantity'=>$quantity, 'size'=>$size));
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
	
	<div id="shopping-cart">
		<div class="txt-heading">Shopping Cart <a id="btnEmpty" href="cart.php?action=empty">Empty Cart</a></div>
		<?php
		if(isset($_SESSION["cart_item"])){
		    $item_total = 0;
			if ($displayMaxMessage) {
				?> 
					<h3> The quantity has been changed to an amount that is currently available for this item. </h3>
		<?php 
		}
		?>	
		<table cellpadding="10" cellspacing="1">
			<tbody>
				<tr>
					<th><strong>Name</strong></th>
					<th><strong>Size</strong></th>
					<th><strong>Quantity</strong></th>
					<th><strong>Price</strong></th>
					<th><strong>Action</strong></th>
				</tr>	
<?php		
    				foreach ($_SESSION["cart_item"] as $item) {
?>
					<tr>
						<td><strong><?php echo $item["name"]; ?></strong></td>
						<td><?php echo $item["size"]; ?></td>
						<td><form name="updateCartForm_<?php echo $item["id"]; ?>" method="post" action="cart.php?action=update&itemStockId=<?php echo $item["id"]; ?>">
<input type="text" name="qty_<?php echo $item["id"]; ?>" value="<?php echo $item["quantity"]; ?>" size=4 onkeyup="showUpdate('qty_update_<?php echo $item["id"]; ?>')"/><input type="submit" value="Update" id="qty_update_<?php echo $item["id"]; ?>" style='display:none' /></form></td>
						<td align=right><?php echo "$".$item["price"]; ?></td>
						<td><a href="cart.php?action=remove&itemStockId=<?php echo $item["id"]; ?>" class="btnRemoveAction">Remove Item</a></td>
					</tr>
<?php
        			$item_total += ($item["price"]*$item["quantity"]);
				}
?>

					<tr>
						<td colspan="5" align=right><strong>Total:</strong> <?php echo "$".$item_total; ?><br/>
						<a href="checkout.php">Checkout</a></td>
					</tr>
				</tbody>
			</table>		
<?php
	}
?>
</div>

</BODY>
</HTML>