<?php
include("header.php");
include("item.php");

if(isset($_GET['purchaseId'])) {
	$purchaseItemQuery = mysql_query("SELECT * FROM purchase_items WHERE purchase_id=".$_GET['purchaseId']);
?>
	<table border="1">
		<tr>
				<td>Name</td>
				<td>Size</td>
				<td>Quantity</td>
				<td>Price</td>
				<td>Item Details</td>
		</tr>
<?php
	while($purchaseItemRow = mysql_fetch_array($purchaseItemQuery)) {
		$itemStockQuery = mysql_query("SELECT * FROM items_stock WHERE item_stock_id = ".$purchaseItemRow['item_stock_id']);
		$itemStockRow = mysql_fetch_array($itemStockQuery);
		$item = Item::getItemById($itemStockRow['item_id']);
?>
	<tr>
		<td><?php echo $item->name; ?></td>
		<td><?php echo $itemStockRow['size']; ?></td>
		<td><?php echo $purchaseItemRow['quantity']; ?></td>
		<td><?php echo $item->price; ?></td>
		<td><a href="show_item?itemId=<?php echo $item->itemId; ?>">Show Details</a></td>
	</tr>
<?php
	}
?>
	</table>
<?php
}
?>