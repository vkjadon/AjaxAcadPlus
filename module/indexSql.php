<?php
session_start();
if (isset($_SESSION["myid"])) $myId = $_SESSION['myid'];
require("../util/config_database.php");
require('../php_function.php');
require('../util/config_variable.php');

//echo $_POST['action'];

if (isset($_POST['action'])) {
   if ($_POST['action'] == 'profile') {
      // $id = $_POST['userId'];
      // echo $myId;
      $sql = "select s.* from staff s where s.staff_id='$myId'";
      $result = $conn->query($sql);
      $output = $result->fetch_assoc();
      echo json_encode($output);
   } 
}
