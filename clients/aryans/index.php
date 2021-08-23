<?php
session_start();
// Change Below
$myFolder='clients/aryans';
// Change Below
$myDb='aryan';
$_SESSION["myFolder"]=$myFolder;
$_SESSION["myDb"]=$myDb;

$setUrl='http://classconnect.in';
$setLogo='https://aryans.edu.in/wp-content/uploads/2020/09/aryans_logo01.png';
$setCodePath='http://localhost/acadplus';
  
$_SESSION["setUrl"]=$setUrl;
$_SESSION["setLogo"]=$setLogo;
$_SESSION["setCodePath"]=$setCodePath;

header('Location: ../../index.php');

?>

