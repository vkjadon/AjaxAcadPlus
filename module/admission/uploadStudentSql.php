<?php
require('../requireSubModule.php');

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
      $sno = data_clean($row[0]);
      $id = data_clean($row[1]);
      $roll = data_clean($row[2]);
      $name = data_clean($row[3]);
      $dob = data_clean($row[7]);
      $mobile = data_clean($row[9]);
      // echo $name;
      $sql = "select * from student where user_id='$id'";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      $records = $result->num_rows;
      // echo "records $records";
      if ($records == 0) {
        $sql = "INSERT INTO student (batch_id, program_id, user_id, student_rollno, student_name, student_dob, student_mobile, update_id, student_status) VALUES ('$myBatch', '$myProg', '$id', '$roll', '$name', '$dob', '$mobile', '$myId', '0')";
        $result = $conn->query($sql);
        if (!$result) echo $conn->error;
        else {
          $student_id = $conn->insert_id;
          // echo "Added - $student_id";
          $sql = "insert into student_detail (student_id, update_id) values('$student_id', '$myId')";
          $result = $conn->query($sql);
          $status = "Inserted";
        }
      } else $status = "Exists";
    }
  } else $output = '1';
} else $output = '0';
echo $output;
