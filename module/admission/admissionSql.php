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
      $batchId = $_POST['batchId'];
      $progId = $_POST['progId'];

      // $sql = "select st.* from student st where st.student_status='0' order by user_id";
      if ($progId > 0) $sql = "select st.*, sd.*, sa.*, sr.*, b.batch, p.program_name from  student st, student_detail sd, student_address sa, student_reference sr, batch b, program p where st.batch_id=b.batch_id and st.program_id=p.program_id and st.student_id=sd.student_id and st.student_id=sa.student_id and st.student_id=sr.student_id and st.program_id='$progId' and st.student_status='0'";
      else $sql = "select st.*, sd.*, sa.*, sr.*, b.batch, p.program_name from student st, student_detail sd, student_address sa, student_reference sr, batch b, program p where st.batch_id=b.batch_id and st.program_id=p.program_id and st.student_id=sd.student_id and st.student_id=sa.student_id and st.student_id=sr.student_id and st.student_status='0'";
      //$sql = "select st.*, sd.*, sa.*, b.batch, p.program_name from student st, student_detail sd, student_address sa, batch b, program p where st.batch_id=b.batch_id and st.program_id=p.program_id and st.student_id=sd.student_id and st.student_id=sa.student_id";

      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else {
         $json_array = array();
         while ($rowsStudent = $result->fetch_assoc()) {
            $json_array[] = $rowsStudent;
         }
         echo json_encode($json_array);
      }
   } elseif ($_POST['action'] == 'studentDisp') {
      // $batchId=$_POST['batchId'];
      // $progId=$_POST['progId'];
      // if($batchId>0)$strBatch="and st.batch_id='".$batchId."'";
      // else $strBatch='';
      // if($progId>0)$str="and st.program_id='".$progId."'";
      // else $strProg='';

      // $str=$strBatch.' '.$strProg;
      // $sql = "select st.*, sd.*, sa.*, sr.*, b.batch, p.program_name from student st, student_detail sd, student_address sa, student_reference sr, batch b, program p where st.batch_id=b.batch_id and st.program_id=p.program_id and st.student_id=sd.student_id and st.student_id=sa.student_id and st.student_id=sr.student_id";
      $id = $_POST['userId'];
      $sql = "select st.*, sd.*, sa.*, sr.*, b.batch, p.program_name from student st, student_detail sd, student_address sa, student_reference sr, batch b, program p where st.batch_id=b.batch_id and st.user_id='$id' and st.program_id=p.program_id and st.student_id=sd.student_id and st.student_id=sa.student_id and st.student_id=sr.student_id";
      $result = $conn->query($sql);
      $output = $result->fetch_assoc();
      echo json_encode($output);
   } elseif ($_POST['action'] == 'addStudent') {
      $dup = "select * from student where student_rollno='" . data_check($_POST["sRno"]) . "' and student_status='0'";
      $result = $conn->query($dup);
      $dup_found = $result->num_rows;
      if ($dup_found == 0) {
         $school_code = getField($conn, $myScl, 'school', 'school_id', 'school_code');
         $batch = getField($conn, $myBatch, 'batch', 'batch_id', 'batch');
         $sp_code = getField($conn, $myProg, 'program', 'program_id', 'sp_code');

         $sql = "select max(user_id) as max from student where program_id='$myProg' and batch_id='$myBatch'";
         $result = $conn->query($sql);
         if ($result) {
            $row = $result->fetch_assoc();
            $last_user_id = $row["max"];
            $last_user_id++;
            if ($last_user_id == 1) $last_user_id = $school_code . substr($batch, 2) . $sp_code . '0001';
         } else echo $conn->error;

         $sql = "insert into student (batch_id, program_id, student_name, student_rollno, student_mobile, student_email, user_id, update_id, student_status) value('$myBatch', '$myProg', '" . data_check($_POST['sName']) . "', '" . data_check($_POST['sRno']) . "', '" . $_POST['sMobile'] . "', '" . $_POST['sEmail'] . "', '$last_user_id', '$myId', '0')";
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
      $id = $_POST['userId'];
      $sql = "select st.*, sd.*, sa.*, sr.*, b.batch, p.program_name from student st, student_detail sd, student_address sa, student_reference sr, batch b, program p where st.batch_id=b.batch_id and st.user_id='$id' and st.program_id=p.program_id and st.student_id=sd.student_id and st.student_id=sa.student_id and st.student_id=sr.student_id and st.student_status='0'";
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
      $id_name = $_POST['id_name'];
      $id = $_POST['id'];
      $tag = $_POST['tag'];
      $value = $_POST['value'];
      $sql = "update student_detail set $tag='$value' where student_id='$id'";
      $result = $conn->query($sql);
      $affectedRows = $conn->affected_rows;
      echo "affected rows $affectedRows";
      if (!$result) echo $conn->error;
      else echo "Updated";
   } elseif ($_POST['action'] == 'updateAddress') {
      $id_name = $_POST['id_name'];
      $id = $_POST['id'];
      $tag = $_POST['tag'];
      $value = $_POST['value'];
      $sql = "update student_address set $tag='$value' where student_id='$id'";
      $result = $conn->query($sql);
      $affectedRows = $conn->affected_rows;
      echo "affected rows $affectedRows";
      if (!$result) echo $conn->error;
      else echo "Updated";
   }
   elseif ($_POST['action'] == 'updateReference') {
      $id_name = $_POST['id_name'];
      $id = $_POST['id'];
      $tag = $_POST['tag'];
      $value = $_POST['value'];
      $sql = "update student_reference set $tag='$value' where student_id='$id'";
      $result = $conn->query($sql);
      $affectedRows = $conn->affected_rows;
      echo "affected rows $affectedRows";
      if (!$result) echo $conn->error;
      else echo "Updated";
   } elseif ($_POST['action'] == 'studentQualificationList') {
      $tableId = 'sq_id';

      $stdId = $_POST['stdId'];

      $statusDecode = array("status" => "sq_status", "0" => "Active", "9" => "Inactive");
      $button = array("1", "1", "0", "0");

      $fields = array("mn_name", "sq_institute", "sq_board", "sq_mo", "sq_mm", "sq_percentage", "sq_year");
      $dataType = array("0", "0", "0", "0", "0", "0", "0");
      $header = array("Id", "Qual", "Inst", "Board", "MO", "MM", "%", "Year");

      if ($stdId > 0) $sql = "select sq.*, mn.mn_name from student_qualification sq, master_name mn where mn.mn_id=sq.mn_id and sq.student_id='$stdId'";
      getList($conn, $tableId, $fields, $dataType, $header, $sql, $statusDecode, $button);
   } elseif ($_POST['action'] == 'updateStudentQualification') {
      $student_id = $_POST['student_id'];
      $mn_id = $_POST['mn_id'];
      $tag = $_POST['tag'];
      $value = $_POST['value'];
      $dup = "select * from student_qualification where student_id='$student_id' and mn_id='$mn_id'";
      $result = $conn->query($dup);
      if ($result->num_rows == 0) {
         $sql = "insert into student_qualification (student_id, mn_id, $tag, update_id, sq_status) values('$student_id','$mn_id', '$value', '$myId','0')";
      } else {
         $sql = "update student_qualification set $tag='$value', sq_status='0', update_ts='$submit_ts', update_id='$myId' where student_id='$student_id' and mn_id='$mn_id'";
      }
      $conn->query($sql);
      echo $conn->error;
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
   } elseif ($_POST['action'] == 'totalStudents') {
      $program_id = $_POST['programId'];
      $sql_desig = "select * from student where program_id='$program_id' and student_status='0'";
      $result = $conn->query($sql_desig);
      $rowcount = mysqli_num_rows($result);
      echo  "Total Students Registered in this Program : $rowcount";
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
