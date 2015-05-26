<?php
class Item {
	public $itemId;
	public $name;
	public $gender;
	public $type;
	public $description;
	public $price;
	public $designerId;
	public $creationTime;
	public $picture;

	public static function getItemByID($itemId) {
		$itemQuery = mysql_query("SELECT * FROM items WHERE item_id = ".$itemId);
	
		$num_rows = mysql_num_rows($itemQuery);
		if($num_rows == 1) {
			$itemRow = mysql_fetch_array($itemQuery);
			$item = new Item();
			$item->itemId = $itemId;
			$item->name = $itemRow['name'];
			$item->gender = $itemRow['gender'];
			$item->type = $itemRow['type'];
			$item->description = $itemRow['description'];
			$item->price = $itemRow['price'];
			$item->designerId = $itemRow['designer_id'];
			$item->creationTime = $itemRow['creation_time'];
			$item->picture = $itemRow['picture'];
			return $item;
		}
		else {
			return null;
		}
	}
	
	public function getItemAttributes() {
		$itemAttributesQuery = mysql_query("SELECT categories.category_id, categories.name ,attributes.attribute_id, attributes.name
									   FROM item_attributes
									   INNER JOIN attributes, categories
									   WHERE item_attributes.item_id = ". $this->itemId . " AND item_attributes.attribute_id = attributes.attribute_id AND attributes.category_id = categories.category_id") or die(mysql_error());
		
		$result = array();
	   	while($row = mysql_fetch_array($itemAttributesQuery)) {
			$categoryId = $row[0];
			$categoryName = $row[1];
	   		$attributeId = $row[2];
	   		$attributeName = $row[3];
			$result[$categoryId] = array("cat_name" => $categoryName, "att_id" => $attributeId, "att_name" => $attributeName);
	   	}
		
		return $result;	  
	}
	
	public function getItemStock() {
		$itemStockQuery = mysql_query("SELECT * FROM items_stock WHERE item_id = ". $this->itemId);
		$result = array();
		while($stockRow = mysql_fetch_array($itemStockQuery)) {
			$stockId = $stockRow['item_stock_id'];
			$result[$stockId] = array('size' => $stockRow['size'], 'quantity' => $stockRow['quantity']);
		}
		return $result;
	}
	
	public static function itemFromArray(&$arr)	{
		$item = new Item();
		foreach($item as $key => $value)
		{
			if(isset($arr[$key]))
			{
				$item->$key = $arr[$key];
			}
		}
		return $item;
	}
}
?>
