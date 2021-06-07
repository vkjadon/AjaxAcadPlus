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
  if ($_POST["action"] == "uploadPO") {
   $file_data = fopen($_FILES["csv_upload"]["tmp_name"], 'r');
   // echo "inside PO $batch_id $myProg";
   fgetcsv($file_data);
   while ($row = fgetcsv($file_data)) {

    $po_sno = $conn->real_escape_string($row[0]);  // po sno
    $po_code = $conn->real_escape_string($row[1]);  // po code
    $po_name = $conn->real_escape_string($row[2]);  // po name

    $sql = "select * from program_outcome where batch_id='$myBatch' and program_id='$myProg' and po_sno='$po_sno'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    $records = $result->num_rows;
    if ($records == 0) {
     $sql = "INSERT INTO program_outcome (batch_id, program_id, po_code, po_name, po_sno, po_status) VALUES ('$myBatch', '$myProg', '$po_code', '$po_name', '$po_sno', '0')";
     $result_insert = $conn->query($sql);
     if (!$result_insert) echo $conn->error;
     $status = "Inserted";
    } else $status = "Exists";
   }
  } elseif ($_POST["action"] == "uploadCO") {
   $file_data = fopen($_FILES["csv_upload"]["tmp_name"], 'r');
   echo "inside CO $myBatch $myProg";
   fgetcsv($file_data);
   while ($row = fgetcsv($file_data)) {
    //echo count($row);
    $co_name = $conn->real_escape_string($row[1]);  // co name
    $subject_code = $conn->real_escape_string($row[0]);
    $subject_code = str_replace(" ", "", $subject_code);
    $sql = "select * from subject where batch_id='$myBatch' and program_id='$myProg' and subject_code='$subject_code'";
    $subject_id = getFieldValue($conn, "subject_id", $sql);
    if ($subject_id > 0) {
     $sql = "select * from course_outcome where subject_id='$subject_id' and co_name='$co_name'";
     $result = $conn->query($sql);
     if (!$result) echo $conn->error;
     $records = $result->num_rows;
     if ($records == 0) {
      $sql = "INSERT INTO course_outcome (subject_id, co_code, co_name, co_status) VALUES ('$subject_id', 'CO', '$co_name', '0')";
      $result_co = $conn->query($sql);
      $co_id = $conn->insert_id;
      //echo "$co_id ";
      $po = 0;
      for ($i = 2; $i < count($row); $i++) {
       $po++;
       $sql_po = "select po_id from program_outcome where program_id='$myProg' and batch_id='$myBatch' and po_sno='$po'";
       $po_id = getFieldValue($conn, "po_id", $sql_po);
       $po_scale = $conn->real_escape_string($row[$i]);  // po scale

       echo "$po_id $po_scale";

       $sql_copo = "INSERT INTO copo_map (co_id, po_id, copo_scale) VALUES ('$co_id', '$po_id', '$po_scale')";
       if (strlen($po_scale) > 0) $conn->query($sql_copo);
      }
     } else $status = "CO Exists";
    }
   }
  }
 } else $output = '1';
} else $output = '0';
echo $output;
