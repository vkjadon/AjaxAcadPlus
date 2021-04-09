<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');
if (!empty($_FILES["student_upload"]["name"])) {
 $output = '';
 $filename = $_FILES["student_upload"]["name"];
 $allowed_ext = array("csv");
 $extension = end(explode('.', $filename)); // get file extension
 if (in_array($extension, $allowed_ext)) {
  $file_data = fopen($filename, "r");
  echo count(fgetcsv($file_data));
  // echo $file_data;
  // while ($row == fgetcsv($file_data)) {
  // }
 } else {
  echo "Error 1";
 }
} else echo " Blank ";
