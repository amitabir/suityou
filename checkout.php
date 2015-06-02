<?php
include("config.php");

// This function returns the total price of the purchase (summing all the items)
function calcTotalPrice($cart_data) {
	$result = 0;
	foreach ($cart_data as $item) {
		$result += $item["price"]*$item["quantity"];
	}
	return $result;
}

if(!empty($_SESSION["cart_item"]) and !empty($_SESSION["user_id"])) {	
	$userId = $_SESSION["user_id"];
	$cartData = $_SESSION["cart_item"];
	$totalPrice = calcTotalPrice($cartData);
	$query=mysql_query('SELECT coupon_meter FROM users WHERE user_id= ' .$_SESSION["user_id"]);
	$row=mysql_fetch_array($query);
	$couponMeter=$row["coupon_meter"];
	if ($couponMeter == 100){//TODO- add options?
		$totalPrice = 0.9 * $totalPrice;
		mysql_query('UPDATE users SET coupon_meter=0 WHERE user_id ='.$userId);
	}
	
	// Insert purchase
	mysql_query('INSERT INTO purchases(user_id, total_price) VALUES ('.$userId.', '.$totalPrice.')') or die(mysql_error());
	$purchaseId = mysql_insert_id();
	
	// Insert purchase items
	foreach($cartData as $itemStockId => $itemData) {
		mysql_query('INSERT INTO purchase_items(purchase_id, item_stock_id, quantity) VALUES ('.$purchaseId.', '.$itemStockId.', '.$itemData['quantity'].')') or die(mysql_error());
	}
	
	// Cleasr the session cart data
	unset($_SESSION["cart_item"]);
	
	header("location: user_purchases.php");
} else if (empty($_SESSION["user_id"])) {
	echo '<h2>You must sign in before checking out!</h2>';
	echo '<a href="cart.php">Go Back</a>';
}
?>