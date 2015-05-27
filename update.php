<?php
include'header.php';
echo var_dump($_POST);
echo "<br/>";

$message='';
if(User::issetUserDetailsinArray($_POST) && isset($_SESSION['user_id'],$_SESSION['email'],$_SESSION['is_designer']))
{
	$email = $_POST['email'];
	//We check if the email form is valid
	if($_SESSION['email'] != $email)
	{
		if(preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$_POST['email']))
		{
			//We protect the variables
			$email = mysql_real_escape_string($email);
			//We check if there is no other user using the same email
			$dn = mysql_num_rows(mysql_query('select email from users where email="'.$email.'"'));
			if($dn != 0)
			{
					//Otherwise, email is already taken
					$message = 'Error: The email is already listed';
			}
				
		}
		else
		{
			//Otherwise, we say the email is not valid
			$message = 'Error: The email you entered is not valid.';
		}
	}
	if($message=='')
	{
		//TODO: NEED TO ADD FURTHER LOGIC IF WE WISH TO ALLOW REMOVING DATA
		//creating the update query
		$query = 'UPDATE users SET';
		$user = User::UserFromArray($_POST);
		foreach($user as $key=>$value)
		{
			if(!empty($value))
			{
				$query.=' '.$key.'="'.$value.'",';
			}
		}
		$query = rtrim($query,","); //removing trailing ','
		$query.=' WHERE user_id="'.$_SESSION['user_id'].'"';
		if(mysql_query($query))
		{
			//logging him into session automatically
			$_SESSION['email'] = $_POST['email'];
			$message = 'Updated Successfully';			
		}
		else
		{
			$message = mysql_error();//TODO:'An error occurred while signing up.';
		}
	}
	$_SESSION['update_message']=$message;
	header('Location: profile.php');
}
else
{	
	header("Location: connexion.php");
}	
	