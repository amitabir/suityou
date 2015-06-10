<?php
//We start sessions
session_unset();
session_start();
/******************************************************
------------------Required Configuration---------------
******************************************************/

// Set the timezone
date_default_timezone_set('Asia/Jerusalem');

//We log to the DataBase
  mysql_connect("localhost", "root", "");
  mysql_select_db("suityou");
  
//Webmaster Email
$mail_webmaster = 'example@example.com';

//Top site root URL
$url_root = 'http://www.example.com/';

//Loading Classes
require_once 'User.php';

/******************************************************
-----------------Optional Configuration----------------
******************************************************/

//Home page file name
$url_home = 'index.php';

//Design Name
$design = 'default';


?>