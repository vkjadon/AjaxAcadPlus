<?php
session_start();
include('openObeDb.php');
require('../php_function.php');
include('../phpFunction/onlineFunction.php');

if ($_POST['action'] == 'checkUser') {
	$myUn = $_POST['username'];
	$myPwd = $_POST['userpassword'];
	if ($myUn == "obe101" && $myPwd == "chitkara")$user="1";
	else $user="NotFound";
	echo $user;
	$_SESSION['myid'] = $user;
}
