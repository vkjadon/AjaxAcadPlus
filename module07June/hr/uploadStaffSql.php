<?php
session_start();
//manage_subjectSql.php
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
$output = '';

if (!empty($_FILES["csv_upload"]["name"])) {
 $output = '';
 $filename = $_FILES["csv_upload"]["name"];
 $allowed_ext = array(".csv");
 $file_ext = substr($filename, strripos($filename, '.')); // get file name
 echo $file_ext;
 if (in_array($file_ext, $allowed_ext)) {
  if ($_POST["action"] == "uploadStaff") {
   $file_data = fopen($_FILES["csv_upload"]["tmp_name"], 'r');
   fgetcsv($file_data);
   while ($row = fgetcsv($file_data)) {
    //    print_r($file_data);
    $name = $conn->real_escape_string($row[0]); // staff_name
    $doj = $conn->real_escape_string($row[1]);  // doj
    $doj=date("Y-m-d", strtotime($doj));
    $mobile = $conn->real_escape_string($row[2]);  // mobile
    $email = $conn->real_escape_string($row[3]);  // email
    $user_id = $conn->real_escape_string($row[4]);  // userid

    $sql = "select * from staff where user_id='$user_id'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    $records = $result->num_rows;

    if ($records == 0) {
     $sql = "INSERT INTO staff (staff_name, staff_doj, staff_mobile, staff_email, user_id) VALUES ('$name', '$doj', '$mobile', '$email', '$user_id')";
     $result_insert = $conn->query($sql);
     $last_id = $conn->insert_id;
     if (!$result_insert) echo $conn->error;
     $status = "Inserted";
    } else $status = "Exists";

    $sql = "INSERT INTO staff_service (staff_id, dept_id) VALUES ('$last_id', '$myDept')";
    $result_service = $conn->query($sql);
    if (!$result_service) echo $conn->error;
   }
  }
 } else $output = '1';
} else $output = '0';
echo $output;
