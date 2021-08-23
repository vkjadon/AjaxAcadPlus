<?php 
session_start();
require("../util/config_database.php");
require('../php_function.php');
require('../util/config_variable.php');
if(!isset($myId) || strlen($myId)==0 ){
  //echo "My Id Check ";
  require("../logout.php");
}
?>