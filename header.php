<?php
require_once 'config.php';
?>
<html>
<head>
  <title>SuitYou</title>
  <!-- TODO -->
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=windows-1252" />
  <link rel="stylesheet" type="text/css" href="style/style.css" /> 
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="ajax.js?102"></script>
</head>

<body>
<div id="main">
    <div id="header">
     <div id="logo">
        <div id="logo_text">
          <h1><a href="index.php">Suit<span class="logo_colour">You</span></a></h1>
          <h2>Simply suits you.</h2>
        </div>
      </div>
     
     
      <div id="menubar">
        <ul id="leftmenu">
          	<li><a href="shop_entrance.php?gender=male">Shop-Men</a></li>
			<li><a href="shop_entrance.php?gender=female">Shop-Women</a></li>
          	<li><a href="matching.php">Match</a></li>	
          	<li><a href="trends.php">Trends</a></li>
        </ul>        
<?php 
if(isset($_SESSION['user_id'],$_SESSION['email']))
{
?>
		<p>Hello <?php echo $_SESSION['email']?></p>
		<ul id="changeMenu">			
			<li><a href="cart.php">Shopping Cart</a></li>
          	<li><a href="profile.php">Profile</a></li>	
          	<li><a href="connexion.php">Logout</a></li>
        </ul>
<?php
}
else
{
?>
		<ul id="changeMenu">
			<li><a href="sign_up.php">Sign up</a></li>
			<li><a href="connexion.php">Log in</a></li>
		</ul>
<?php 
}
?>        
      </div>
    </div>
</div>