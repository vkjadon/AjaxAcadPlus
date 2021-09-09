<?php
require('../requireSubModule.php');

$output = '';

if (!empty($_FILES["student_upload"]["name"])) {
  $output = '';
  $filename = $_FILES["student_upload"]["name"];
  $allowed_ext = array(".csv");
  $file_ext = substr($filename, strripos($filename, '.')); // get file name
  // echo $file_ext;
  $count=0;
  if (in_array($file_ext, $allowed_ext)) {
    $batch_id=$_POST['selectedBatch'];
    $program_id=$_POST['selectedProg'];
    $file_data = fopen($_FILES["student_upload"]["tmp_name"], 'r');
    fgetcsv($file_data);
    while ($row = fgetcsv($file_data)) {
      $sno = data_clean($row[0]);
      $id = data_clean($row[1]);
      $roll = data_clean($row[2]);
      if($roll=="")$roll=$id;
      $name = data_clean($row[3]);
      $fname = data_clean($row[4]);
      $mobile = data_clean($row[5]);
      
      // echo $name;
      $sql = "select * from student where user_id='$id'";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      $records = $result->num_rows;
      // echo "records $records";
      if ($records == 0) {
        $count++;
        $sql = "INSERT INTO student (batch_id, program_id, user_id, student_rollno, student_name, student_mobile, student_lateral, student_semester, update_id, student_status) VALUES ('$batch_id', '$program_id', '$id', '$roll', '$name', '$mobile', '0', '1', '$myId', '0')";
        $result = $conn->query($sql);
        if (!$result) echo $conn->error;
        else {
          $student_id = $conn->insert_id;
          // echo "Added - $student_id";
          $sql = "insert into student_detail (student_id, student_fname, update_id) values('$student_id', '$fname', '$myId')";
          $result = $conn->query($sql);
          $sql = "insert into student_address (student_id, update_id) values('$student_id', '$myId')";
         $result = $conn->query($sql);
         $sql = "insert into student_reference (student_id, update_id) values('$student_id', '$myId')";
         $result = $conn->query($sql);
        }
      } else $status = "Exists";
    }if($count>0) $output = $count." Entries Added !!";
    else $output = "Could not Add !!";
  } 
} else $output = 'No File Selected !!';
echo $output;
