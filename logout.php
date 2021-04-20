<?php
//logout.php
session_start();
$myFolder=$_SESSION['myFolder'];
session_destroy();
header('location:/acadplus/'.$myFolder.'/index.php');
?>