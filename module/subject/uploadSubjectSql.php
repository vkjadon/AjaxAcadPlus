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
 echo "file name $filename";

 $allowed_ext = array(".csv");
 $file_ext = substr($filename, strripos($filename, '.')); // get file name
 if (in_array($file_ext, $allowed_ext)) {
  if ($_POST["action"] == "uploadSubject") {
   $file_data = fopen($_FILES["csv_upload"]["tmp_name"], 'r');
   fgetcsv($file_data);
   echo "inside Subject";
   while ($row = fgetcsv($file_data)) {
    $subject_sno = $conn->real_escape_string($row[0]);
    $subject_name = $conn->real_escape_string($row[1]);
    $code = $conn->real_escape_string($row[2]);
    $subject_code = str_replace(' ', '', $code);
    $subject_semester = $conn->real_escape_string($row[3]);
    $subject_lecture = $conn->real_escape_string($row[4]);
    $subject_tutorial = $conn->real_escape_string($row[5]);
    $subject_practical = $conn->real_escape_string($row[6]);
    $subject_credit = $conn->real_escape_string($row[7]);
    $subject_type = $conn->real_escape_string($row[8]);
    if ($subject_type == "") $subject_type = 'DC';
    //$subject_mode = $conn->real_escape_string($row[9]);
    // $subject_category = $conn->real_escape_string($row[10]);
    // $subject_internal = $conn->real_escape_string($row[11]);
    // if ($subject_internal == "") $subject_internal = '0';
    // $subject_external = $conn->real_escape_string($row[12]);
    // if ($subject_external == "") $subject_external = '0';
    $sql = "select * from subject where batch_id='$myBatch' and program_id='$myProg' and subject_code='$subject_code'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    $records = $result->num_rows;
    if ($records == 0) {
     $sql = "INSERT INTO subject (batch_id, program_id, subject_sno, subject_name, subject_code, subject_semester, subject_lecture, subject_tutorial, subject_practical, subject_credit, subject_type) VALUES ('$myBatch', '$myProg', '$subject_sno', '$subject_name', '$subject_code', '$subject_semester',  '$subject_lecture', '$subject_tutorial', '$subject_practical', '$subject_credit', '$subject_type')";
     $result_insert = $conn->query($sql);
     if (!$result_insert) echo $conn->error;
     $status = "Inserted";
    } else $status = "Exists";
   }
  } 
 } else $output = '1';
} else $output = '0';
echo $output;
