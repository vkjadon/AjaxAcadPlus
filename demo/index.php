<?php
session_start();
$myFolder='demo';
$_SESSION["myFolder"]=$myFolder;

$setUrl='http://classconnect.in';
$setLogo='https://engineeringinfo.in/images/logo-text.png';
$setCodePath='http://localhost/acadplus';
  
$_SESSION["setUrl"]=$setUrl;
$_SESSION["setLogo"]=$setLogo;
$_SESSION["setCodePath"]=$setCodePath;

header('Location: ../index.php');?>
