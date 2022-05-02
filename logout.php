<?php
//logout.php
session_start();
require("util/config_database.php");

$ul_logout = date("Y-m-d h:i:s", time());

if (isset($_SESSION['mll'])) $myMll = $_SESSION['mll'];
if (isset($_SESSION['un'])) $myUn = $_SESSION['un'];
// echo $myMll.$ul_logout;
$sql="update user_log set ul_logout='$ul_logout' where user_id='$myUn' and ul_login='$myMll'";
$conn->query($sql);
session_destroy();
// die("You have Successfully logged out.");
header('location:/acadplus/index.php');
?>