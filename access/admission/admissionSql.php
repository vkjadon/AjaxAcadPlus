<?php
require('../../module/requireSubModule.php');
//echo $_POST['action'];
if (isset($_POST['action'])) {
   if ($_POST['action'] == 'schoolOption') {
      $sql = "select * from school where school_status='0' order by school_name";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else {
         $json_array = array();
         while ($rowsStudent = $result->fetch_assoc()) {
            $json_array[] = $rowsStudent;
         }
         echo json_encode($json_array);
      }
   } elseif ($_POST['action'] == 'progOption') {
      $id = $_POST['schoolId'];
      $sql = "select p.* from program p, dept_program dp, school s, school_dept sd where s.school_id='$id' and s.school_id=sd.school_id and sd.dept_id=dp.dept_id and dp.program_id=p.program_id and p.program_status='0' order by program_name";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else {
         $json_array = array();
         while ($rowsStudent = $result->fetch_assoc()) {
            $json_array[] = $rowsStudent;
         }
         echo json_encode($json_array);
      }
   } elseif ($_POST['action'] == 'stateOption') {
      $sql = "select * from states order by state_name ASC";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else {
         $json_array = array();
         while ($rowsStudent = $result->fetch_assoc()) {
            $json_array[] = $rowsStudent;
         }
         echo json_encode($json_array);
      }
   } elseif ($_POST['action'] == 'districtOption') {
      $id = $_POST['stateId'];
      $sql = "select dt.* from districts dt, states st where st.state_id='$id' and st.state_id=dt.state_id";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else {
         $json_array = array();
         while ($rowsStudent = $result->fetch_assoc()) {
            $json_array[] = $rowsStudent;
         }
         echo json_encode($json_array);
      }
   } elseif ($_POST['action'] == 'addNew') {
      $school_id = $_POST['sel_school'];
      $program_id = $_POST['sel_prog'];
      $semester = $_POST['stdSemester'];
      $date = $_POST['stdAdmission'];
      $ay = $_POST['stdAcademicBatch'];
      if (isset($_POST['stdLateralEntry'])) $lateral = 1;
      else $lateral = 0;
      if (isset($_POST['stdRegular'])) $regular = 1;
      else $regular = 0;

      $school_code = getField($conn, $school_id, 'school', 'school_id', 'school_code');
      $batch = getField($conn, $myBatch, 'batch', 'batch_id', 'batch');
      $ay_id = getField($conn, $ay, 'batch', 'batch', 'batch_id');

      $sp_code = getField($conn, $program_id, 'program', 'program_id', 'sp_code');
      // echo "SP Code  $sp_code PID $program_id $myBatch ";
      $sql = "select max(user_id) as max from student where program_id='$program_id' and batch_id='$myBatch'";
      $result = $conn->query($sql);
      if ($result) {
         $row = $result->fetch_assoc();
         $last_user_id = $row["max"];
         $last_user_id++;
         // echo "USER ID ".$last_user_id.'<br>';
         if ($last_user_id == 1) $last_user_id = $school_code . substr($batch, 2) . $sp_code . '0001';
      } else echo $conn->error;

      $sql = "insert into student (batch_id, program_id, ay_id, student_lateral, student_regular, student_semester, user_id, student_admission, student_gender, update_id, student_status) value('$myBatch', '$program_id', '$ay_id', '$lateral', '$regular', '$semester', '$last_user_id', '$date', 'M', '$myId', '0')";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else {
         $student_id = $conn->insert_id;
         // echo "Added - $student_id";
         $sql = "insert into student_detail (student_id, update_id) values('$student_id', '$myId')";
         $result = $conn->query($sql);
         $sql = "insert into student_address (student_id, update_id) values('$student_id', '$myId')";
         $result = $conn->query($sql);
         $sql = "insert into student_reference (student_id, update_id) values('$student_id', '$myId')";
         $result = $conn->query($sql);
      }
      echo "$last_user_id";
   } elseif ($_POST['action'] == 'updateId') {
      $school_id = $_POST['sel_school'];
      $program_id = $_POST['sel_prog'];
      if (isset($_POST['stdLateralEntry'])) $lateral = 1;
      else $lateral = 0;
      if (isset($_POST['stdRegular'])) $regular = 1;
      else $regular = 0;
      $semester = $_POST['stdSemester'];
      $ay = $_POST['stdAcademicBatch'];
      $date = $_POST['stdAdmission'];

      $userId = $_POST['userId'];
      $sql = "update student set student_lateral='$lateral', student_regular='$regular', student_semester='$semester', student_admission='$date' where user_id='$userId'";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      echo $userId;
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
   } elseif ($_POST['action'] == 'updateStudent') {
      $id = $_POST['id'];
      $tag = $_POST['tag'];
      $value = $_POST['value'];
      $sql = "update student set $tag='$value' where user_id='$id'";
      $conn->query($sql);
      echo $conn->error;
   } elseif ($_POST['action'] == 'updateParentsInfo') {
      $id = $_POST['id'];
      $tag = $_POST['tag'];
      $value = $_POST['value'];
      $student_id = getField($conn, $id, "student", "user_id", "student_id");
      //   echo "$student_id";
      $sql = "update student_detail set $tag='$value' where student_id='$student_id'";
      $conn->query($sql);
      echo $conn->error;
   } elseif ($_POST['action'] == 'updateAddress') {
      $id = $_POST['id'];
      $tag = $_POST['tag'];
      $value = $_POST['value'];
      $student_id = getField($conn, $id, "student", "user_id", "student_id");
      //   echo "$student_id";
      $sql = "update student_address set $tag='$value' where student_id='$student_id'";
      $conn->query($sql);
      echo $conn->error;
   } elseif ($_POST['action'] == 'updateReference') {
      $id = $_POST['id'];
      $tag = $_POST['tag'];
      $value = $_POST['value'];

      $student_id = getField($conn, $id, "student", "user_id", "student_id");
      //   echo "$student_id";
      $sql = "update student_reference set $tag='$value' where student_id='$student_id'";
      $conn->query($sql);
      echo $conn->error;
   } elseif ($_POST['action'] == 'studentDisp') {
      $id = $_POST['userId'];
      $sql = "select st.*, sd.*, sa.*, sr.*, b.batch, p.program_name from student st, student_detail sd, student_address sa, student_reference sr, batch b, program p where st.batch_id=b.batch_id and st.user_id='$id' and st.program_id=p.program_id and st.student_id=sd.student_id and st.student_id=sa.student_id and st.student_id=sr.student_id";
      $result = $conn->query($sql);
      $output = $result->fetch_assoc();
      echo json_encode($output);
   } elseif ($_POST['action'] == 'studentList') {
      //   echo "hellsdka";
      // $id = $_POST['userId'];
      $sql = "select st.*, b.batch, p.program_name from student st, batch b, program p where st.batch_id=b.batch_id and p.program_id=st.program_id";
      $result = $conn->query($sql);
      $json_array = array();
      while ($rowArray = $result->fetch_assoc()) {
         $json_array[] = $rowArray;
      }
      echo json_encode($json_array);
   } elseif ($_POST['action'] == 'personalList') {
      //   echo "hellsdka";
      // $id = $_POST['userId'];
      $sql = "select * from student";
      $result = $conn->query($sql);
      $json_array = array();
      while ($rowArray = $result->fetch_assoc()) {
         $json_array[] = $rowArray;
      }
      echo json_encode($json_array);
   } elseif ($_POST['action'] == 'updateStudentQualification') {
      $id = $_POST['id'];
      $student_id = getField($conn, $id, "student", "user_id", "student_id");
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
   } elseif ($_POST['action'] == 'studentOption') {
      $code = $_POST['code'];
      $sql = "select * from master_name where mn_code='$code' order by mn_name";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else {
         $json_array = array();
         while ($rowsStudent = $result->fetch_assoc()) {
            $json_array[] = $rowsStudent;
         }
         echo json_encode($json_array);
      }
   }
}
