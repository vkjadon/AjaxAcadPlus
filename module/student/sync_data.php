<?php
$sql = "select * from admission_form";
$result = $conn->query($sql);
if ($result) {
  $afRows = $result->num_rows;
  $sqlStudent = "select * from student";
  $resultStudent = $conn->query($sqlStudent);
  $studentRows = $resultStudent->num_rows;
  if ($afRows > $studentRows) {
    echo "$afRows - $studentRows";
    $i = 0;
    while ($afArray = $result->fetch_assoc()) {
      $i++;

      if ($i > $studentRows) {
        echo $afArray["af_id"] . '<br>';
        $tableId='student_id';
        $values=array($afArray["batch_id"], $afArray["program_id"], $afArray["sname"], $afArray["smobile"], $afArray["semail"], $afArray["univ_rollno"], $afArray["submit_id"]);
        $fields=array('batch_id', 'program_id', 'student_name', 'student_mobile', 'student_email', 'student_rollno', 'submit_id');
        $status='student_status';
        $dup="select student_id from student where student_rollno='EISOFTECH'";
        $dup_alert="Student Email Already Exists!!";
        addData($conn, 'student', $tableId, $fields, $values, $status, $dup, $dup_alert);
        
      }
    }
  }
}
//else echo "Echo ";
