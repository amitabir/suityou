<?php
class User
{
	public $user_id;
	public $email;
	public $first_name;
	public $last_name;
	public $address;
	public $gender; 
	public $birth_date;
	public $is_designer;
	public $avatar;
	public $coupon_meter;
	public $description;
	public $website_link;
	
	public function getUserfromDBbyID($user_id)
	{
		$query = mysql_query('select * from users where user_id=.'.$user_id);
		$row = mysql_num_rows($query);
		if($row == 1)
			return mysql_fetch_object($query,'User');
		else
			return null; 
	}
	
	public function getUserfromDBbyEmail($email)
	{
		$query = mysql_query('select * from users where email=.'.$email);
		$row = mysql_num_rows($query);
		if($row == 1)
			return mysql_fetch_object($query,'User');
		else
			return null;
	}
	
	public function getUserFromArray(array $arr)
	{
		$user = new User();
		foreach ($arr as $key => $value)
		{
		    $user->$key = $value;
		}
		return $user;
	}
	
	function setArrayFromUser(array $arr)
	{
		
		foreach($this as $key => $value)
		{
			$arr[$key]= $value; 
		}
		
	}
	
	function unSetArrayFromUser(array $arr)
	{
		foreach($this as $key => $value)
		{
			unset($arr[$key]);
		}
	}
	
	function issetUserinArray(array $arr)
	{
		foreach($this as $key => $value)
		{
			if(!isset($arr[$key]))
				return false;
			else
				return true; 
		}
	}
	
	
}
?>
