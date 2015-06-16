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

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

  <link rel="stylesheet" href= <?php echo $design ?> >

  <link rel="stylesheet" type="text/css" href="style/style.css?8" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

  <script src="js/jquery-ui.min.js"></script>

  <script type="text/javascript" src="jquery.validate.min.js"></script>

  <script src="jRate.min.js"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

  <script src="js/jquery.twbsPagination.min.js"></script>

  <script src="js/raphael.2.1.0.min.js"></script>

  <script src="js/justgage.1.0.1.min.js"></script>

</head>

<body>

<nav class="navbar navbar-default">



  <div class="container-fluid">

    <!-- Brand and toggle get grouped for better mobile display -->

    <div class="navbar-header">

      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">

        <span class="sr-only">Toggle navigation</span>

        <span class="icon-bar"></span>

        <span class="icon-bar"></span>

        <span class="icon-bar"></span>

      </button>

      <a class="navbar-brand" href="index.php">	<img src="images/BannerTransBG.png"  height="26" width="100"> </a>

    </div>



    <!-- Collect the nav links, forms, and other content for toggling -->

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      <ul class="nav navbar-nav navbar-left">

        <li class="dropdown">

          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Shop<span class="caret"></span></a>

          <ul class="dropdown-menu" role="menu">

            <li><a href="shop_entrance.php?gender=male">Men</a></li>

            <li class="divider"></li>

            <li><a href="shop_entrance.php?gender=female">Women</a></li>

          </ul>

        </li>

        <li><a href="matching.php">Match</a></li>

        <li><a href="trends.php">Trends</a></li>

      </ul>

      <ul class="nav navbar-nav navbar-right">

     <?php if(isset($_SESSION['user_id'],$_SESSION['email']))

        {

     ?>

          <p class="navbar-text">Hello <?php echo $_SESSION['email']?></p> 

          <li><a href="cart.php">Shopping Cart <span class ="glyphicon glyphicon-shopping-cart"></span></a></li>

		  <li><a href="user_purchases.php">My Purchases <span class="glyphicon glyphicon-barcode"></span></a></li>

          <li><a href="profile.php">Profile <span class="glyphicon glyphicon-user"></span></span></a></li>  

     <?php if (isset($_SESSION['is_designer']) && !empty($_SESSION['is_designer']))

          {

     ?>

          <li><a href="manage_items.php">Manage Items <span class="glyphicon glyphicon-briefcase"></span></a></li>

    <?php }

	 	if (isset($_SESSION['is_admin']) && !empty($_SESSION['is_admin']))

         {

    ?>

         <li><a href="manage.php">Manage Site <span class="glyphicon glyphicon-dashboard"></span></a></li>

   <?php }

        }  else  {

     ?>
 		  <li><a href="cart.php">Shopping Cart <span class ="glyphicon glyphicon-shopping-cart"></span></a></li>
          
		  <li><a href="sign_up.php">Sign up <span class="glyphicon glyphicon-list-alt"></span></a></li>

          <li><a href="connexion.php">Log in <span class="glyphicon glyphicon-log-in"></span></a></li>

  <?php }
	 if(isset($_SESSION['user_id'],$_SESSION['email']))   {
  ?>
  		<li><a href="connexion.php">Logout <span class="glyphicon glyphicon-log-out"></span></a></li>
  <?php } ?>

      </ul>

    </div><!-- /.navbar-collapse -->

  </div><!-- /.container-fluid -->

</nav>