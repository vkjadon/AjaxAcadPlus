<?php
session_start();
include('../../config_database.php');
//echo $_POST['action'];
$_SESSION['msd'] = $_POST["sel_session"];
include('config_variable.php');
