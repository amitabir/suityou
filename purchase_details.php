<?php
include("header.php");

if(isset($_GET['purchaseId'])) {
	$purchaseItemQuery = mysql_query("SELECT * FROM purchase_items WHERE purchase_id=".$_GET['purchaseId']);
?>
<div class="container">	
	<table class="table" border="1">
		<thead>
			<tr>
				<th>Name</th>
				<th>Size</th>
				<th>Quantity</th>
				<th>Price</th>
				<th>Item Details</th>
			</tr>
		</thead>
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
		<td><?php echo "$".$item->price; ?></td>
		<td><a href="show_item?itemId=<?php echo $item->itemId; ?>">Show Details</a></td>
	</tr>
<?php
	}
?>
	</table>
</div>	
	
<?php
}
?>
</body>
</html>