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
  <link rel="stylesheet" type="text/css" href="style/style.css?3" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="js/jquery-ui.min.js"></script>
  <script type="text/javascript" src="jquery.validate.min.js"></script>
  <script src="jRate.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>

<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">SuitYou - <small>Simply suits you</small></a>
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
          <li><a href="cart.php">Shopping Cart</a></li>
          <li><a href="profile.php">Profile</a></li>  
          <li><a href="connexion.php">Logout</a></li>
          <?php if (isset($_SESSION['is_admin']) && !empty($_SESSION['is_admin']))
          {
          ?>
          <li><a href="manage.php">Manage Site</a></li>
    <?php }
        }
        else
        {
        ?>
          <li><a href="sign_up.php">Sign up</a></li>
          <li><a href="connexion.php">Log in</a></li>
  <?php } ?>  
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

