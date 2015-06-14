<?php
require_once 'config.php';
require_once 'algorithms.php'; 
$message = '';
//We check if the form has been sent
if(isset($_POST['email'], $_POST['first_name'], $_POST['last_name'], $_POST['address'], $_POST['gender'], $_POST['birth_date'], $_POST['is_designer']))
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
						$dn = mysql_fetch_assoc(mysql_query('select user_id,email,is_designer from users where email="'.$email.'"'));
						$_SESSION['user_id'] = $dn['user_id'];
						$_SESSION['email'] = $dn['email'];
						$_SESSION['is_designer'] = $dn['is_designer'];
						insertAnonUserToDB($_SESSION['user_id']);
						//if the user chose to sign up as a designer, fwd to add designer details page
						if($dn['is_designer'] == 1)
						{
							$_SESSION['firstTime'] = true;
							header('Location: profile.php');
						}
						else
						{
							//we fwd to home page
							header("Location: index.php");	
						}
					}
					else
					{
						//Otherwise, we say that an error occured
						$form = true;
						$message = 'An error occurred while signing up.';
					}
						
				}
				else
				{
					//Otherwise, email is already taken fwD to login
					$form = false;
					$_SESSION['email'] = $_POST['email'];
					header("Location: connexion.php");
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
$_SESSION['sign_up_message'] = $message;
if($form)
{
	header("Location: sign_up_form.php");
}
?>
