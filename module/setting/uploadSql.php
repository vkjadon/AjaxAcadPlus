<?php
require('../requireSubModule.php');

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
        echo $subject_sno;
        $subject_semester = $conn->real_escape_string($row[1]);

        $subject_code = preg_replace("/[^a-zA-Z0-9 ]+/", "", $row[2]);
        $subject_name = preg_replace("/[^a-zA-Z0-9 ]+/", "", $row[3]);
        $subject_internal = preg_replace("/[^a-zA-Z0-9]+/", "", $row[4]);
        $subject_external = preg_replace("/[^a-zA-Z0-9]+/", "", $row[5]);
        $subject_credit = preg_replace("/[^a-zA-Z0-9]+/", "", $row[6]);
        $subject_coordinator = $conn->real_escape_string($row[7]);
        if ($subject_internal == "") $subject_internal = '0';
        if ($subject_external == "") $subject_external = '0';
        $sql = "select * from $tn_sub where program_id='$myProg' and subject_name='$subject_name' and subject_status='0'";
        $result = $conn->query($sql);
        if (!$result) echo $conn->error;
        $records = $result->num_rows;
        if ($records == 0) {
          $sql = "INSERT INTO $tn_sub (batch_id, program_id, subject_sno, subject_name, subject_code, subject_semester, subject_internal, subject_external, subject_credit, subject_coordinator, update_id, subject_status) VALUES ('$myBatch', '$myProg', '$subject_sno', '$subject_name', '$subject_code', '$subject_semester',  '$subject_internal', '$subject_external', '$subject_credit', '$subject_coordinator', '$myId', '0')";
        } else {
          echo "Updated !!";
        }
        $result_insert = $conn->query($sql);
        if (!$result_insert) echo $conn->error;
      }
    } elseif ($_POST["action"] == "uploadPO") {
      $file_data = fopen($_FILES["csv_upload"]["tmp_name"], 'r');
      fgetcsv($file_data);
      //echo "inside Subject";
      while ($row = fgetcsv($file_data)) {
        $po_sno = $conn->real_escape_string($row[0]);
        $po_sno = preg_replace("/[^a-zA-Z0-9 ]+/", "", $po_sno);
        //echo $subject_sno;
        $po_statement = data_check($row[1]);
        $po_statement = preg_replace("/[^a-zA-Z0-9 ]+/", "", $po_statement);
        //echo $po_statement;
        $sql = "select * from $tn_po where program_id='$myProg' and po_statement='$po_statement'";
        $result = $conn->query($sql);
        if (!$result) echo $conn->error;
        $records = $result->num_rows;
        if ($records == 0) {
          $sql = "INSERT INTO $tn_po (program_id, po_sno, po_statement, update_id, po_status) VALUES ('$myProg', '$po_sno', '$po_statement', '$myId', '0')";
          $result_insert = $conn->query($sql);
          if (!$result_insert) echo $conn->error;
          $status = "Inserted";
        } else $status = "Exists";
      }
    } elseif ($_POST["action"] == "uploadStudent") {
      $file_data = fopen($_FILES["csv_upload"]["tmp_name"], 'r');
      fgetcsv($file_data);
      //echo "inside Subject";
      while ($row = fgetcsv($file_data)) {
        $student_sno = $conn->real_escape_string($row[0]);
        $student_sno = preg_replace("/[^a-zA-Z0-9]+/", "", $student_sno);
        //echo $subject_sno;
        $student_rollno = data_check($row[1]);
        $student_rollno = preg_replace("/[^a-zA-Z0-9]+/", "", $student_rollno);
        $student_name = data_check($row[2]);
        $student_name = preg_replace("/[^a-zA-Z0-9 ]+/", "", $student_name);
        //echo $po_statement;
        $sql = "select * from $tn_std where student_rollno='$student_rollno'";
        $result = $conn->query($sql);
        if (!$result) echo $conn->error;
        $records = $result->num_rows;
        if ($records == 0) {
          $sql = "INSERT INTO $tn_std (program_id, batch_id, student_rollno, student_name, student_sno, update_id, student_status) VALUES ('$myProg', '$myBatch', '$student_rollno', '$student_name', '$student_sno', '$myId', '0')";
          echo "Inserted";
        } else {
          $sql = "update $tn_std set student_name='$student_name', batch_id='$myBatch', program_id='$myProg', student_sno='$student_sno' where student_rollno='$student_rollno'";
          echo "Updated ";
        }
        $result_insert = $conn->query($sql);
        if (!$result_insert) echo $conn->error;
      }
    }
  } else $output = '1';
} else $output = 'No File Selected';
echo $output;
