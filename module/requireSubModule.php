<?php 
session_start();
require('../../php_function.php');
require("../../util/config_database.php");
require('../../util/config_variable.php');
if(!isset($myId) || $myId<1)require("../../logout.php");
require('../../util/myLinks.php');
?>