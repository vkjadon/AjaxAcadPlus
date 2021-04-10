<?php
session_start();
//manage_subjectSql.php
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
$output = '';

if (!empty($_FILES["upload_staff"]["name"])) {
 $output = '';
 $filename = $_FILES["upload_staff"]["name"];
 $allowed_ext = array(".csv");
 $file_ext = substr($filename, strripos($filename, '.')); // get file name
 // echo $file_ext;
 if (in_array($file_ext, $allowed_ext)) {
  $file_data = fopen($_FILES["upload_staff"]["tmp_name"], 'r');
  fgetcsv($file_data);
  while ($row = fgetcsv($file_data)) {
   print_r($file_data);
   $name = $conn->real_escape_string($row[0]); // staff_name
   $doj = $conn->real_escape_string($row[1]);  //doj
   $mobile = $conn->real_escape_string($row[2]);  //mobile
   $email = $conn->real_escape_string($row[3]);  //email

   $sql = "select * from staff where staff_email='$email'";
   $result = $conn->query($sql);
   if (!$result) echo $conn->error;
   $records = $result->num_rows;
   echo $records;
   if ($records == 0) {
    $sql = "INSERT INTO staff (staff_name, staff_doj, staff_mobile, staff_email) VALUES ('$name', '$doj', '$mobile', '$email')";
    $result = $conn->query($sql);
    $status = "Inserted";
   } else $status = "Exists";
  }
 } else $output = '1';
} else $output = '0';
echo $output;

