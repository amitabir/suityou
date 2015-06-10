<?php
include("config.php");
include("image_upload.php");

define("ITEM_IMAGES_TARGET_DIR", "images/items/");

// Add a new attribute, also check it doesn't already exist
function addNewAttribute($categoryKey, $itemId) {
	$temp = explode("_", $categoryKey);
	$categoryId = end($temp);
	$newAttributeName = $_POST["new_att_for_".$categoryId];
	
	$checkAlreadExistsQuery = mysql_query('SELECT * FROM attributes WHERE category_id = '.$categoryId.' AND name = "'.ucwords($newAttributeName).'"');
	
	$num_rows = mysql_num_rows($checkAlreadExistsQuery);
	if ($num_rows == 0) {
		// The attribute is really new
		if (mysql_query('INSERT INTO attributes(category_id, name) VALUES ('.$categoryId.', "'.ucwords($newAttributeName).'")') or die(mysql_error()));
			$newAttributeId = mysql_insert_id();
	} else {
		// The attribute name already exists, get the id.
		$row = mysql_fetch_array($checkAlreadExistsQuery);
		$newAttributeId = $row["attribute_id"];
	}
	
	mysql_query('INSERT INTO item_attributes(item_id, attribute_id) VALUES ('.$itemId.', '.$newAttributeId.')') or die(mysql_error());
}
	
if ($_GET["action"] == "add") {	
	if(isset($_POST["submit"])) {
		
		$item = Item::itemFromArray($_POST);
		$item->designerId = $_POST["designerId"];

		$uploadResult = uploadImage("imageToUpload", ITEM_IMAGES_TARGET_DIR);
		if ($uploadResult["success"]) {
			$item->picture = $uploadResult["uploadedFileName"];
		} else {
			// Upload failed, set message and return
			$_SESSION['item_update_message']="Error uploading item image: ".$uploadResult["message"];
			$_SESSION['item_update_success'] = false;
			header('Location: add_item.php');
			exit;
		}
				
		mysql_query('INSERT INTO items(name, gender, type, description, price, designer_id, picture) VALUES ("'.$item->name.'", "'.$item->gender.'", "'.$item->type.'", "'.$item->description.'", '.$item->price.', '.$item->designerId.', "'.$item->picture.'")') or die(mysql_error());
	
		$newItemId = mysql_insert_id();
	
		// Insert Item Attributes
		foreach($_POST as $key=>$value) {
			if (strpos($key, 'cat') !== FALSE) {
				if ($value != "new") {
					mysql_query('INSERT INTO item_attributes(item_id, attribute_id) VALUES ('.$newItemId.', '.$value.')') or die(mysql_error());
				} else {
					addNewAttribute($key, $newItemId);
				}
			}
		}
	
		// Insert Item Stock
		$sizes=$_POST['size'];
		$quantities=$_POST['quantity'];
		foreach($sizes as $idx => $size) {
			$quantity = $quantities[$idx];
			mysql_query('INSERT INTO items_stock(item_id, size, quantity) VALUES ('.$newItemId.', "'.$size.'", '.$quantity.')') or die(mysql_error());
		}
		
		$_SESSION['item_update_message'] = "Item added successfully";
		header("location: show_item.php?itemId=".$newItemId);
	
		// TODO : maybe show a "New item was added notification"
	}
} else if ($_GET["action"] == "update") {
	if(isset($_POST["submit"])) { 
		$itemId = $_GET["itemId"];
		$oldItem = Item::getItemById($itemId);
		$updatedItem = Item::itemFromArray($_POST);
		$updatedItem->designerId = $oldItem->designerId;
		
		if (!empty($_FILES["imageToUpload"]["name"])) {
			$uploadResult = uploadImage("imageToUpload", ITEM_IMAGES_TARGET_DIR);
			if ($uploadResult["success"]) {
				deleteImage($oldItem->picture, ITEM_IMAGES_TARGET_DIR);
				$updatedItem->picture = $uploadResult["uploadedFileName"];
			} else {
				// Upload failed, set message and return
				$_SESSION['item_update_message']="Error uploading item image: ".$uploadResult["message"];
				$_SESSION['item_update_success'] = false;
				header('Location: add_item.php?itemId='.$itemId);
				exit;
			}			
		} else {
			$updatedItem->picture = $oldItem->picture;
		}
		
		mysql_query('UPDATE items SET name = "'.$updatedItem->name.'", gender = "'.$updatedItem->gender.'", type = "'.$updatedItem->type.'", description = "'.$updatedItem->description.'", price = '.$updatedItem->price.', picture = "'.$updatedItem->picture.'" WHERE item_id = '.$itemId) or die(mysql_error());
		
		$oldAttArray = $oldItem->getItemAttributes();
		// Update Item Attributes
		foreach($_POST as $key=>$value) {
			if (strpos($key, 'cat') !== FALSE) {
				if ($value != "new") {
					$temp = explode("_", $key);
					$categoryId = end($temp);
					$oldAttIdForCat = $oldAttArray[$categoryId]["att_id"];
					if ($oldAttIdForCat != $value) {
						mysql_query('DELETE FROM item_attributes WHERE item_id = '.$itemId.' AND attribute_id = '.$oldAttIdForCat) or die(mysql_error());
						mysql_query('INSERT INTO item_attributes(item_id, attribute_id) VALUES ('.$itemId.', '.$value.')') or die(mysql_error());
					}
				} else {
					// Adding a new attribute
					addNewAttribute($key, $itemId);
				}
			}
		}
		
		// Insert Item Stock
		$sotckIds = $_POST['stockIds'];
		$sizes=$_POST['size'];
		$quantities=$_POST['quantity'];
		
		// First Delete old sizes
		$oldAttArray = $oldItem->getItemStock();
		foreach($oldAttArray as $stockId=>$stockData) {
			if (!in_array($stockId, $sotckIds)) {
				mysql_query('DELETE from items_stock WHERE item_stock_id ='.$stockId) or die(mysql_error());
			}
		}
		
		// Update/Insert new size
		foreach($sotckIds as $idx => $stockId) {
			$size = $sizes[$idx];
			$quantity = $quantities[$idx];
			if ($stockId == "") {
				// Insert New Size Record
				mysql_query('INSERT INTO items_stock(item_id, size, quantity) VALUES ('.$itemId.', "'.$size.'", '.$quantity.')') or die(mysql_error());
			} else {
				// Update Old Size Record
				mysql_query('UPDATE items_stock SET item_id = '.$itemId.', size =  "'.$size.'", quantity = '.$quantity.' WHERE item_stock_id ='.$stockId) or die(mysql_error());
			}
		}
		
		$_SESSION['item_update_message'] = "Item updated successfully";
		$_SESSION['item_update_success'] = true;
		header("location: show_item.php?itemId=".$itemId);
	}				
} else if ($_GET["action"] == "remove") {
		$itemId = $_GET["itemId"];
		$item = Item::getItemById($itemId);
		
		if (!empty($item->picture)) {
			deleteImage($item->picture, ITEM_IMAGES_TARGET_DIR);
		}
		
		// TODO what if there are still live matches with this item?
		
		// Delete item attributes
		mysql_query('DELETE FROM item_attributes WHERE item_id = '.$itemId) or die(mysql_error());
		
		// Delete item stock
		mysql_query('DELETE FROM items_stock WHERE item_id = '.$itemId) or die(mysql_error());
		
		// Delete the item
		mysql_query('DELETE FROM items WHERE item_id = '.$itemId) or die(mysql_error());
		
		$_SESSION['item_update_message'] = "Item removed successfully";
		$_SESSION['item_update_success'] = true;
		header("location: manage_items.php");
}?>