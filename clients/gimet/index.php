<?php
session_start();
// Change Below
$myFolder='clients/gimet';
// Change Below
$myDb='gimet';
$_SESSION["myFolder"]=$myFolder;
$_SESSION["myDb"]=$myDb;

$setUrl='http://classconnect.in';
$setLogo='https://www.globalinstitutes.edu.in/wp-content/uploads/2019/11/logo.png';
$setCodePath='http://localhost/acadplus';
  
$_SESSION["setUrl"]=$setUrl;
$_SESSION["setLogo"]=$setLogo;
$_SESSION["setCodePath"]=$setCodePath;

header('Location: ../../index.php');

?>

