<?php
//include("header.php");
include("config.php");
include("algorithms.php");

//var_dump($_POST);



foreach($_POST as $constName => $constNewVal){
	if($constName != 'submit'){
		$query = "UPDATE constants SET value = ".$constNewVal." WHERE name = '".$constName."'";
		mysql_query($query) or die(mysql_error());
	}
}

header('Location: constants.php');
?>
