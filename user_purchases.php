<?php
include("config.php");
include("header.php");

if(isset($_SESSION['user_id'])) {
	$purchasesQuery = mysql_query("SELECT * FROM purchases WHERE user_id=".$_SESSION['user_id']);
?>
	<table border="1">
<?php
	while($purchaseRow = mysql_fetch_array($purchasesQuery)) {
?>
	<tr>
		<td>
			Purchase Code: <?php echo $purchaseRow['purchase_id']?> <br/>
			Total Price:  <?php echo $purchaseRow['total_price']?> <br/>
			<a href="purchase_details.php?purchaseId=<?php echo $purchaseRow['purchase_id']?>">Show Details</a>
		</td>
	</tr>
<?php
	}
?>
	</table>
<?php
}
?>