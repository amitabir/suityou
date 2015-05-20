<?php
include('header.php');
//We check if the form has been sent
if(isset($_POST['email'], $_POST['first_name'], $_POST['last_name'], $_POST['address'], $_POST['gender'], $_POST['birth_date']))
{
			//We check if the email form is valid
			if(preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',$_POST['email']))
			{
				//We protect the variables
				$email = mysql_real_escape_string($_POST['email']);
				//We check if there is no other user using the same email
				$dn = mysql_num_rows(mysql_query('select email from users where email="'.$email.'"'));
				if($dn==0)
				{
					$user = User::UserFromArray($_POST);
					//We save the informations to the databse
					if(mysql_query('insert into users(email, first_name, last_name, address, gender, birth_date, is_designer, avatar, description, website_link) values ("'.$user->{'email'}.'", "'.$user->{'first_name'}.'", "'.$user->{'last_name'}.'", "'.$user->{'address'}.'", "'.$user->{'gender'}.'", "'.$user->{'birth_date'}.'", "'.$user->{'is_designer'}.'","'.$user->{'avatar'}.'", "'.$user->{'description'}.'", "'.$user->{'website_link'}.'")'))
					{
						//We dont display the form
						$form = false;
						//logging him into session automatically
						$dn = mysql_fetch_assoc(mysql_query('select user_id,email from users where email="'.$email.'"'));
						$_SESSION['user_id'] = $dn['user_id'];
						$_SESSION['email'] = $dn['email'];
						header("Location: index.php");
					}
					else
					{
						//Otherwise, we say that an error occured
						$form = true;
						$message = mysql_error();//'An error occurred while signing up.';
					}
						
				}
				else
				{
					//Otherwise, email is already taken fwD to login
					$form = false;
					$message = 'The email in already listed, please log in';
				}
			}
			else
			{
				//Otherwise, we say the email is not valid
				$form = true;
				$message = 'The email you entered is not valid.';
			}
}
else
{
	$form = true;
}
//We display a message if necessary
if(isset($message))
{
	echo '<div class="message">'.$message.'</div><br/>';
}
if($form)
{
?>
<div class="content">
    <form action="sign_up.php" method="post">
        Please fill the following form to sign up:<br />
        <div class="center">
        	<label for="email">Email</label><input type="text" name="email" value="<?php if(isset($_SESSION['email'])){echo htmlentities($_SESSION['email'], ENT_QUOTES, 'UTF-8');} ?>" /><br />
            <label for="first_name">First name:</label><input type="text" name="first_name" id="first_name" /><br />
            <label for="last_name">Last name:</label><input type="text" name="last_name" id="last_name" /><br />
            <label for="address">Address:</label><input type="text" name="address" id='address' /><br />
            <label for="gender">Gender:</label>
            <select name="gender" size="2">
            	<option selected="selected" value="FEMALE">FEMALE</option>
            	<option value="MALE">MALE</option>
			</select><br/>            
            <label for="birth_date">Birth Date:</label><input type="text" name="birth_date" id="birth_date"  /><br />
            <!--INSERT ISDESIGNER FURTHER LOGICS--><input type="checkbox" name="is_designer" id="is_designer" value="0"/><br/>
            <label for="avatar">Avatar:<span class="small">(optional)</span></label><input type="text" name="avatar" value="<?php if(isset($_POST['avatar'])){echo htmlentities($_POST['avatar'], ENT_QUOTES, 'UTF-8');} ?>" /><br />
            <label for="description">Description:<span class="small">(optional)</span></label><input type="text" name="description" id="description"  /><br />
            <label for="website_link">Web Site:<span class="small">(optional)</span></label><input type="text" name="website_link" id="website_link"  /><br />
            <input type="submit" value="Sign up" />
		</div>
    </form>
</div>
<?php
}
?>
