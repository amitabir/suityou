<?php
include 'header.php';	
//If the user is logged, we log him out
if(isset($_SESSION['user_id']) && isset($_SESSION['email']) && $_SESSION['email'] != '')
{
	//We log him out by clearing session
	User::unSetArrayFromUser($_SESSION);
	header("Location: index.php");
}
else
{
	$user = new User();
	//We check if the form has been sent
	if(isset($_POST['email']) && $_POST['email'] != '')
	{
		
		$user = User::UserFromArray($_POST);
		$req = mysql_query('select user_id,email,is_designer,is_admin from users where email="'.$user->{'email'}.'"');
		$dn = mysql_fetch_array($req);
		//We compare the submited email and we check if the user exists
		if($dn['email']==$user->{'email'} and mysql_num_rows($req)>0)
		{
			//If the email exsit, we dont show the form
			$form = false;
			//We save the email in the session email and the user Id in the session userid
			$_SESSION['email'] = $dn['email'];
			$_SESSION['user_id']=$dn['user_id'];
			$_SESSION['is_designer']=$dn['is_designer'];
			$_SESSION['is_admin']=$dn['is_admin'];
			header("Location: index.php");
		}
		else
		{
			echo "here";
			//we suggest to register
			$form = false;
			$_SESSION['email']=$_POST['email'];
			//header("Location: sign_up.php");
		}
	}
	else
	{
		$form = true;
	}
	if($form)
	{	
		//We display the form
?>
	
	<script type="text/javascript" src="connexion.js"></script>
		<div class="content">
		    <form id="connexion_form"action="connexion.php" method="post">
		        Please type your Email to log in:<br />
		        <div class="center">
			        	<label for="email">Email</label><input type="text" name="email" id="email" value="<?php if(isset($_SESSION['email'])) echo $_SESSION['email'];?>" /><br/>
		        <input type="submit" value="Log in" />
				</div>
		    </form>
		</div>
	<?php
	}
} 
	?>	