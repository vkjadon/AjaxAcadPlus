<?php
session_start();
$myFolder='mce';
$_SESSION["myFolder"]=$myFolder;

$setUrl='http://classconnect.in';
$setLogo='https://engineeringinfo.in/images/logo-text.png';
  
$_SESSION["setUrl"]=$setUrl;
$_SESSION["setLogo"]=$setLogo;

header('Location: ../index.php');?>
