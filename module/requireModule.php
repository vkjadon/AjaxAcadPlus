<?php 
session_start();
if (isset($_SESSION["myid"])) $myId = $_SESSION['myid'];
if(!isset($myId) || strlen($myId)==0 ){
  //echo "My Id Check ";
  require("../logout.php");
}
require("../util/config_database.php");
require('../php_function.php');
require('../util/config_variable.php');

?>