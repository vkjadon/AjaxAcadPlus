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
 // echo "file name $filename";

 $allowed_ext = array(".csv");
 $batch_id = $_POST['batch_idUpload'];
 $file_ext = substr($filename, strripos($filename, '.')); // get file name
 if (in_array($file_ext, $allowed_ext)) {
  if ($_POST["action"] == "uploadSubject") {
   $file_data = fopen($_FILES["csv_upload"]["tmp_name"], 'r');
   fgetcsv($file_data);
   // echo "inside Subject";
   while ($row = fgetcsv($file_data)) {

    $subject_sno = $conn->real_escape_string($row[0]);  
    $subject_name = $conn->real_escape_string($row[1]); 
    $subject_code = $conn->real_escape_string($row[2]); 
    $subject_semester = $conn->real_escape_string($row[3]); 
    $subject_practical = $conn->real_escape_string($row[4]); 
    $subject_tutorial = $conn->real_escape_string($row[5]); 
    $subject_lecture = $conn->real_escape_string($row[6]); 
    $subject_credit = $conn->real_escape_string($row[7]);
    $subject_type = $conn->real_escape_string($row[8]); 
    $subject_mode = $conn->real_escape_string($row[9]);  
    $subject_category = $conn->real_escape_string($row[10]); 
    $subject_internal = $conn->real_escape_string($row[11]);  
    $subject_external = $conn->real_escape_string($row[12]); 

    $sql = "select * from subject where batch_id='$batch_id' and program_id='$myProg' and subject_code='$subject_code'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    $records = $result->num_rows;
    if ($records == 0) {
     $sql = "INSERT INTO subject (batch_id, program_id, subject_sno, subject_name, subject_code, subject_semester, subject_type, subject_mode, subject_practical, subject_tutorial, subject_lecture, subject_category, subject_credit, subject_internal, subject_external) VALUES ('$batch_id', '$myProg', '$subject_sno', '$subject_name', '$subject_code', '$subject_semester', '$subject_type', '$subject_mode', '$subject_practical', '$subject_tutorial', '$subject_lecture', '$subject_category', '$subject_credit', '$subject_internal', '$subject_external')";
     $result_insert = $conn->query($sql);
     if (!$result_insert) echo $conn->error;
     $status = "Inserted";
    } else $status = "Exists";
   }
  } elseif ($_POST["action"] == "uploadPO") {
   $file_data = fopen($_FILES["csv_upload"]["tmp_name"], 'r');
   // echo "inside PO $batch_id $myProg";
   fgetcsv($file_data);
   while ($row = fgetcsv($file_data)) {
    $po_code = $conn->real_escape_string($row[0]); // po code
    $po_name = $conn->real_escape_string($row[1]);  // po name
    $po_sno = $conn->real_escape_string($row[2]);  // po sno

    $sql = "select * from program_outcome where batch_id='$batch_id' and program_id='$myProg' and po_sno='$po_sno'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    $records = $result->num_rows;
    if ($records == 0) {
     $sql = "INSERT INTO program_outcome (batch_id, program_id, po_code, po_name, po_sno, po_status) VALUES ('$batch_id', '$myProg', '$po_code', '$po_name', '$po_sno', '0')";
     $result_insert = $conn->query($sql);
     if (!$result_insert) echo $conn->error;
     $status = "Inserted";
    } else $status = "Exists";
   }
  } elseif ($_POST["action"] == "uploadCO") {
   $file_data = fopen($_FILES["csv_upload"]["tmp_name"], 'r');
   // echo "inside CO $batch_id $myProg";
   fgetcsv($file_data);
   while ($row = fgetcsv($file_data)) {
    $co_code = $conn->real_escape_string($row[0]); // po code
    $co_name = $conn->real_escape_string($row[1]);  // po name
    $co_sno = $conn->real_escape_string($row[2]);  // po sno

    $sql = "select * from course_outcome where batch_id='$batch_id' and program_id='$myProg' and co_sno='$co_sno'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    $records = $result->num_rows;
    if ($records == 0) {
     $sql = "INSERT INTO course_outcome (batch_id, program_id, co_code, co_name, co_sno, co_status) VALUES ('$batch_id', '$myProg', '$co_code', '$co_name', '$co_sno', '0')";
     $result_insert = $conn->query($sql);
     if (!$result_insert) echo $conn->error;
     $status = "Inserted";
    } else $status = "Exists";
   }
  }
 } else $output = '1';
} else $output = '0';
echo $output;
