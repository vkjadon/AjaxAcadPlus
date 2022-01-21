<?php
//logout.php
session_start();
$myFolder=$_SESSION['myFolder'];
session_destroy();
// die("You have Successfully logged out.");
header('location:/acadplus/index.php');
?>