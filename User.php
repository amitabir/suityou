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
	
	public static function getUserfromDBbyID($user_id)
	{
		$query = mysql_query('select * from users where user_id=.'.$user_id);
		$row = mysql_num_rows($query);
		if($row == 1)
			return mysql_fetch_object($query,'User');
		else
			return null; 
	}
	
	public static function getUserfromDBbyEmail($email)
	{
		$query = mysql_query('select * from users where email=.'.$email);
		$row = mysql_num_rows($query);
		if($row == 1)
			return mysql_fetch_object($query,'User');
		else
			return null;
	}
	

	public function setArrayFromUser(&$arr)
	{
		
		foreach($this as $key => $value)
		{
			$arr[$key]= $value; 
		}
		
	}
	
	public static function unSetArrayFromUser(&$arr)
	{
		$properties =  get_class_vars('User');
		foreach($properties as $key => $value)
		{
			if(isset($arr[$key]))
				unset($arr[$key]);
		}
	}
	
	public static function issetUserinArray(&$arr)
	{
		$properties =  get_class_vars('User');
		foreach($properties as $key => $value)		
		{
			if(!isset($arr[$key])){
				return false;
			}
			else
				return true; 
		}
	}
	
	public static function UserFromArray(&$arr)
	{
		$user = new User;
		foreach($user as $key => $value)
		{
			if(isset($arr[$key]))
			{
				$user->$key = $arr[$key];
			}
		}
		return $user;
	}
	
	public function applyFuncOnUser(&$function)
	{
		foreach($this as $key => $value)
		{
			$this->$key = $function($this->$key);
			
		}
	}
	
}
?>
