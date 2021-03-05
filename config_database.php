<?php
if (isset($_SESSION["myFolder"])) {
  $myFolder = $_SESSION["myFolder"];
  $servername = "localhost";  //Host Name
  $username = "root";         // Database User Name
  $password = "";             // Database User Password
  $db = "classcon_" . $myFolder;             // Database Name

  // Create connection
  $conn = new mysqli($servername, $username, $password, $db);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  //else $output=json_encode("Connected successfully");
}
