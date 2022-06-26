<?php
require('../requireSubModule.php');
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
        $mobile = $conn->real_escape_string($row[1]);  // mobile
        $email = $conn->real_escape_string($row[2]);  // email

        $sql = "select * from staff where staff_email='$email'";
        $result = $conn->query($sql);
        if (!$result) echo $conn->error;
        $records = $result->num_rows;
        if ($records == 0) {
          $sql = "INSERT INTO staff (school_id, dept_id, staff_name, staff_mobile, staff_email, mn_id, update_ts, update_id, staff_status) VALUES ('$myScl', '$myDept', '$name', '$mobile', '$email', '197', '$submit_ts', '$myId', '0')";
          $result_insert = $conn->query($sql);
          if (!$result_insert) {
            echo $conn->error;
            $status = "NotInserted";
          } else {
            $insert_id = $conn->insert_id;
            $user_id = 'AG' . (80000 + $insert_id);
            $sql_up = "update staff set user_id='$user_id' where staff_id='$insert_id'";
            $result_up = $conn->query($sql_up);
            $status = "Inserted";
            $sql_ss = "INSERT INTO staff_service (staff_id, dept_id) VALUES ('$insert_id', '$myDept')";
            $result_ss = $conn->query($sql_ss);
            if (!$result_ss) echo $conn->error;
          }
        } else $status = "Exists";
      }
    }
  } else $output = '1';
} else $output = '0';
echo $output;
