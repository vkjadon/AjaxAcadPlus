<?php
session_start();
$myFolder='kms';
$_SESSION["myFolder"]=$myFolder;

$setUrl='http://classconnect.in';
$setLogo='http://eisoftech.in/img/logo.png';
  
$_SESSION["setUrl"]=$setUrl;
$_SESSION["setLogo"]=$setLogo;


header('Location: ../index.php');?>
