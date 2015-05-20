<?php
include("header.php");
if(!empty($_GET["action"])) {
	switch($_GET["action"]) {
		case "add":
			// Get parameters from form
			if(!empty($_POST["quantity"]) && !empty($_POST["itemId"]) && !empty($_POST["size"])) {
				$quantity = $_POST["quantity"];
				$itemId = $_POST["itemId"];
				$size = $_POST["size"];
				
				// Find the item stock ID - this will be its identifier in the cart
				$stockQuery = mysql_query("SELECT * FROM items_stock WHERE item_id = $itemId AND size = '$size'");
				$stockRow = mysql_fetch_array($stockQuery);
				$itemStockId = $stockRow["id"];

				// We also need the item details
		   		$itemQuery = mysql_query("SELECT * FROM items WHERE id = $itemId");
		   		$itemRow = mysql_fetch_array($itemQuery);
		
				// Create array with item's data, pointed by the item stock id.
				$itemArray = array($itemStockId => array('name'=>$itemRow["name"], 'id'=>$itemStockId, 'price'=>$itemRow["price"], 'quantity'=>$quantity, 'size'=>$size));
				if(!empty($_SESSION["cart_item"])) {
					if(array_key_exists($itemStockId, $_SESSION["cart_item"])) {
						// Update quantity for existing items (stock items)
						foreach($_SESSION["cart_item"] as $k => $v) {
							if($itemStockId == $k) {
								$_SESSION["cart_item"][$k]["quantity"] += $quantity;
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
	<div id="shopping-cart">
		<div class="txt-heading">Shopping Cart <a id="btnEmpty" href="cart.php?action=empty">Empty Cart</a></div>
		<?php
		if(isset($_SESSION["cart_item"])){
		    $item_total = 0;
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
    				foreach ($_SESSION["cart_item"] as $item){
?>
					<tr>
						<td><strong><?php echo $item["name"]; ?></strong></td>
						<td><?php echo $item["size"]; ?></td>
						<td><?php echo $item["quantity"]; ?></td>
						<td align=right><?php echo "$".$item["price"]; ?></td>
						<td><a href="cart.php?action=remove&itemStockId=<?php echo $item["id"]; ?>" class="btnRemoveAction">Remove Item</a></td>
					</tr>
<?php
        			$item_total += ($item["price"]*$item["quantity"]);
				}
?>

					<tr>
						<td colspan="5" align=right><strong>Total:</strong> <?php echo "$".$item_total; ?></td>
					</tr>
				</tbody>
			</table>		
<?php
	}
?>
</div>

</BODY>
</HTML>