<?php
require('../requireSubModule.php');

$output = '';

if (!empty($_FILES["csv_upload"]["name"])) {
  $output = '';
  $filename = $_FILES["csv_upload"]["name"];
  //echo "file name $filename";
  $subject_name = 'New';
  $allowed_ext = array(".csv");
  $file_ext = substr($filename, strripos($filename, '.')); // get file name
  if (in_array($file_ext, $allowed_ext)) {
    if ($_POST["action"] == "uploadMarks") {
      $file_data = fopen($_FILES["csv_upload"]["tmp_name"], 'r');
      fgetcsv($file_data);
      //echo "inside Subject";
      $atask_id = $_POST['atask_id'];
      while ($row = fgetcsv($file_data)) {
        $sno = $conn->real_escape_string($row[0]);
        $sno = preg_replace("/[^a-zA-Z0-9]+/", "", $sno);
        $columns = count($row);
        $student_rollno = data_check($row[1]);
        $student_rollno = preg_replace("/[^a-zA-Z0-9]+/", "", $student_rollno);

        $sql = "select * from $tn_std where student_rollno='$student_rollno' and student_status='0'";
        $result = $conn->query($sql);
        if (!$result) echo $conn->error;
        elseif ($result->num_rows == 0) {
          echo "$student_rollno not Found<br>";
        } else {
          $std = $result->fetch_assoc();
          $student_id = $std["student_id"];
          $atq_sno = 0;
          for ($j = 2; $j < $columns; $j++) {
            $sm_marks = ceil(data_check($row[$j]));
            $sm_marks = preg_replace("/[^a-zA-Z0-9]+/", "", $sm_marks);
            $atq_sno++;
            $sql_sm = "select * from $tn_sm where student_id='$student_id' and atask_id='$atask_id' and atq_sno='$atq_sno'";
            $result_sm = $conn->query($sql_sm);
            if (!$result_sm) echo $conn->error;
            $records = $result_sm->num_rows;
            // echo "Marks found [$records] for  ";
            if ($records == 0) {
              $sql_sm = "insert into $tn_sm (student_id, atask_id, atq_sno, sm_marks) values('$student_id', '$atask_id','$atq_sno','$sm_marks')";
              $res = $conn->query($sql_sm);
              if (!$res) echo $conn->error;
              echo " Marks Added $student_rollno $atq_sno $sm_marks [$atask_id]<br>";
            } else {
              $sql_sm = "update $tn_sm set sm_marks='$sm_marks' where student_id='$student_id' and atask_id='$atask_id' and atq_sno='$atq_sno'";
              $res = $conn->query($sql_sm);
              echo "Marks Updated $student_rollno $atq_sno $sm_marks [$atask_id]<br>";
            }
          }
        }
      }
    }
  } else $output = '1';
} else $output = '0';
echo $output;
