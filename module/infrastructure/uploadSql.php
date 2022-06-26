<?php
require('../requireSubModule.php');

$output = '';

if (!empty($_FILES["csv_upload"]["name"])) {
 $output = '';
 $filename = $_FILES["csv_upload"]["name"];
 $allowed_ext = array(".csv");
 $file_ext = substr($filename, strripos($filename, '.')); // get file name
 // echo $file_ext;
 if (in_array($file_ext, $allowed_ext)) {
  if ($_POST["action"] == "uploadProgram") {
   $file_data = fopen($_FILES["csv_upload"]["tmp_name"], 'r');
   fgetcsv($file_data);
   echo "inside Program";
   while ($row = fgetcsv($file_data)) {
    print_r($file_data);
    $sno = $conn->real_escape_string($row[0]); // staff_name
    $program_name = $conn->real_escape_string($row[1]);  //doj
    $program_abbri = $conn->real_escape_string($row[2]);  //mobile
    $program_code = $conn->real_escape_string($row[3]);  //email
    $sp_name = $conn->real_escape_string($row[4]);  //email
    $sp_abbri = $conn->real_escape_string($row[5]);  //email
    $sp_code = $conn->real_escape_string($row[6]);  //email
    $program_seat = $conn->real_escape_string($row[7]);  //email
    $program_duration = $conn->real_escape_string($row[8]);  //email
    $program_semester = $conn->real_escape_string($row[9]);  //email
    $program_start = $conn->real_escape_string($row[10]);  //email

    $sql = "select * from program where program_code='$program_code'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    $records = $result->num_rows;
    echo "record $sno";
    if ($records == 0) {
     $sql = "INSERT INTO program (program_name, program_abbri, program_code, sp_name, sp_abbri, sp_code, program_seat, program_duration, program_semester, program_start, sno, program_status) VALUES ('$program_name', '$program_abbri', '$program_code', '$sp_name', '$sp_abbri', '$sp_code', '$program_seat', '$program_duration', '$program_semester', '$program_start', '$sno', '0')";
     $result_insert = $conn->query($sql);
     if (!$result_insert) echo $conn->error;
     $status = "Inserted";
    } else $status = "Exists";
   }
  }
 } else $output = '1';
} else $output = '0';
echo $output;
