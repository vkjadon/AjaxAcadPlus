<?php
session_start();
//manage_subjectSql.php
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
$output = '';

if (!empty($_FILES["student_upload"]["name"])) {
 $output = '';
 $filename = $_FILES["student_upload"]["name"];
 $allowed_ext = array(".csv");
 $file_ext = substr($filename, strripos($filename, '.')); // get file name
 // echo $file_ext;
 if (in_array($file_ext, $allowed_ext)) {
  $file_data = fopen($_FILES["student_upload"]["tmp_name"], 'r');
  fgetcsv($file_data);
  while ($row = fgetcsv($file_data)) {
   $name = $conn->real_escape_string($row[1]); // staff_name
   $roll = $conn->real_escape_string($row[2]);  //mname
   $mobile = $conn->real_escape_string($row[3]);  //mobile
   $email = $conn->real_escape_string($row[4]);  //email
    // echo $name;
   $sql = "select * from student where student_rollno='$roll'";
   $result = $conn->query($sql);
   if (!$result) echo $conn->error;
   $records = $result->num_rows;
   // echo "records $records";
   if ($records == 0) {
    $sql = "INSERT INTO student (batch_id, program_id, student_name, student_rollno, student_mobile, student_email) VALUES ('$myBatch', '$myProg', '$name', '$roll', '$mobile', '$email')";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    $status = "Inserted";
   } else $status = "Exists";
  }
 } else $output = '1';
} else $output = '0';
echo $output;
