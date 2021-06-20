<?php
require('../requireSubModule.php');
//echo $_POST['action'];
if (isset($_POST["query"])) {
   $output = '';
   $sql = "select * from student where student_name LIKE '%" . $_POST["query"] . "%'";
   $result = $conn->query($sql);
   $output = '<ul class="list-group">';
   if ($result) {
      while ($row = $result->fetch_assoc()) {
         $output .= '<li class="list-group-item list-group-item-action autoList" data-std="' . $row["student_id"] . '" >' . $row["student_name"] . '</li>';
      }
   } else {
      $output .= '<li>Student Not Found</li>';
   }
   $output .= '</ul>';
   echo $output;
}
if (isset($_POST['action'])) {
   if ($_POST['action'] == 'studentList') {
      $sql = "select * from student st where st.program_id='$myProg' and st.batch_id='$myBatch' and student_status='0' order by student_name";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else {
         $json_array = array();
         while ($rowsStudent = $result->fetch_assoc()) {
            $json_array[] = $rowsStudent;
         }
         echo json_encode($json_array);
      }
   } elseif ($_POST['action'] == 'addStudent') {
      $dup = "select * from student where student_rollno='" . data_check($_POST["sRno"]) . "' and student_status='0'";
      $result = $conn->query($dup);
      $dup_found = $result->num_rows;
      if ($dup_found == 0) {
         $sql = "insert into student (batch_id, program_id, student_name, student_rollno, student_mobile, student_email, update_id, student_status) value('$myBatch', '$myProg', '" . data_check($_POST['sName']) . "', '" . data_check($_POST['sRno']) . "', '" . $_POST['sMobile'] . "', '" . $_POST['sEmail'] . "', '$myId', '0')";
         $result = $conn->query($sql);
         if (!$result) echo $conn->error;
         else {
            $student_id = $conn->insert_id;
            echo "Added - $student_id";
            $sql = "insert into student_detail (student_id, update_id) values('$student_id', '$myId')";
            $result = $conn->query($sql);
         }
      }
   } elseif ($_POST['action'] == 'fetchStudent') {
      $id = $_POST['studentId'];
      $sql = "select sd.*, s.* FROM student s, student_detail sd where s.student_id='$id' and s.student_id=sd.student_id";
      $result = $conn->query($sql);
      $output = $result->fetch_assoc();
      echo json_encode($output);
   } elseif ($_POST['action'] == 'updateStudent') {
      $id_name = $_POST['id_name'];
      $id = $_POST['id'];
      $tag = $_POST['tag'];
      $value = $_POST['value'];
      $sql = "update student set $tag='$value' where $id_name='$id'";
      $conn->query($sql);
      echo $conn->error;
   } elseif ($_POST['action'] == 'updateDetails') {
      $student_id = $_POST['student_id'];
      $tag = $_POST['tag'];
      $value = $_POST['value'];
      $sql = "update student_detail set $tag='$value' where student_id='$student_id'";
      $result = $conn->query($sql);
      $affectedRows = $conn->affected_rows;
      echo "affected rows $affectedRows";
      if (!$result) echo $conn->error;
      else echo "Updated";
   } elseif ($_POST['action'] == 'addStudentQualification') {
      $std_id = $_POST['stdIdModal'];
      $sql = "insert into student_qualification (student_id, qualification_id, sq_institute, sq_board, sq_year, sq_marksObtained, sq_marksMax, sq_percentage) values ('$_POST[stdIdModal]', '$_POST[sel_qual]', '$_POST[sInst]', '$_POST[sBoard]', '$_POST[sYear]', '$_POST[sMarksObt]', '$_POST[sMaxMarks]', '$_POST[sCgpa]')";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else echo "Success";
   } elseif ($_POST['action'] == 'studentQualificationList') {
      $tableId = 'sq_id';

      $stdId = $_POST['stdId'];

      $statusDecode = array("status" => "sq_status", "0" => "Active", "9" => "Inactive");
      $button = array("1", "1", "0", "0");

      $fields = array("qualification_name", "sq_institute", "sq_board", "sq_year", "sq_marksObtained", "sq_marksMax", "sq_percentage");
      $dataType = array("0", "0", "0", "0", "0", "0", "0");
      $header = array("Id", "Qualification", "Institute", "Board", "Passing Year", "Marks Obtained", "Maximum Marks", "Percentage/CGPA");

      if ($stdId > 0) $sql = "select sq.*, q.qualification_name from student_qualification sq, qualification q where q.qualification_id=sq.qualification_id and sq.student_id='$stdId'";
      getList($conn, $tableId, $fields, $dataType, $header, $sql, $statusDecode, $button);
   } elseif ($_POST['action'] == 'updateStudentQualification') {
      $id_name = $_POST['id_name'];
      $student_id = $_POST['student_id'];
      $id = $_POST['id'];
      $tag = $_POST['tag'];
      $value = $_POST['value'];
      $sql = "update student_qualification set $tag='$value' where $id_name='$id' and student_id='$student_id'";
      $result = $conn->query($sql);
      $affectedRows = $conn->affected_rows;
      echo "affected rows $affectedRows";
      if (!$result) echo $conn->error;
      elseif ($affectedRows == 0) {
         $sql = "insert into student_qualification (student_id, qualification_id, $tag) values ('$student_id', '$id, '$value')";
         $result = $conn->query($sql);
         if (!$result) echo $conn->error;
      } else "Updated";
   } elseif ($_POST['action'] == 'fetchStudentQualification') {
      $sq_id = $_POST['sqId'];
      $sql = "select * FROM student_qualification where sq_id='$sq_id'";
      $result = $conn->query($sql);
      $output = $result->fetch_assoc();
      echo json_encode($output);
   } elseif ($_POST['action'] == 'studentProgramList') {
      $sql = "SELECT * from program";
      $json = getTableRow($conn, $sql, array("program_id", "program_name"));
      // echo $json;
      $array = json_decode($json, true);
      $count = count($array["data"]);
      // echo $count;
      echo '<table class="list-table-xs">
     <thead align="center">
     <table class="list-table-xs">
     <thead align="center"><th>Program</th><th>Student Registered</th>
     </thead>';
      for ($i = 0; $i < count($array["data"]); $i++) {
         $program_id = $array["data"][$i]["program_id"];
         $program_name = $array["data"][$i]["program_name"];
         $sql_desig = "select * from student where program_id='$program_id' and batch_id='$myBatch'";
         $result = $conn->query($sql_desig);
         $rowcount = mysqli_num_rows($result);
         echo '<tr><td>' . $program_name . '</td><td>' . $rowcount . '</td></tr>';
      }
      echo '</table></table>';
   } elseif ($_POST['action'] == 'updateStudentList') {
      $sql = "select * from student where program_id='$myProg' and batch_id='$myBatch'";
      $result = $conn->query($sql);
      $json_array = array();
      while ($rowArray = $result->fetch_assoc()) {
         $json_array[] = $rowArray;
      }
      echo json_encode($json_array);
   }
}
