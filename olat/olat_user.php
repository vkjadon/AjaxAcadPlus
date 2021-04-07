<?php
session_start();
include('openTestDb.php');
require('../php_function.php');
include('../phpFunction/onlineFunction.php');

if ($_POST['action'] == 'checkUser') {
	$myUn = $_POST['username'];
	$myPwd = $_POST['userpassword'];
	if ($myUn == "Eshan" && $myPwd == "cc101")$user="101";
	else $user="NotFound";
	echo $user;
	$_SESSION['myid'] = $user;
}
