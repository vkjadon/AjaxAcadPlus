<?php
//logout.php
session_start();
$myFolder=$_SESSION['myFolder'];
session_destroy();
//die("Session Time Out.");
header('location:/acadplus/'.$myFolder.'/index.php');
?>