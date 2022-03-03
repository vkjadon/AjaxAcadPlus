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
      $tn_ss = "student_status" . $batchId;
      $sql = "select * from $tn_ss";
      $result = $conn->query($sql);
      if (!$result) {
         $query = 'student_id INT(5) null,
         program_id INT(3) null,
         semester INT(2) null,
         mn_id INT(4) null,
         UNIQUE(student_id, program_id, semester, mn_id)';
         $sql = "CREATE TABLE $tn_ss ($query)";
         $result = $conn->query($sql);
         if (!$result) echo $conn->error;
      }

      $mn_id = $_POST['mn_id'];
      $progId = $_POST['progId'];
      $ssSemester = $_POST['ssSemester'];
      $leet = $_POST['leet'];
      if ($leet == '1') $leet = ' and st.student_lateral="1"';
      else $leet = '';
      $ay = $_POST['ay'];
      if ($ay == '1') $batchField = 'ay_id';
      else $batchField = 'batch_id';

      $deleted = $_POST['deleted'];
      if ($deleted == '1') $status = '9';
      else $status = '0';

      $hostel = $_POST['hostel'];
      $transport = $_POST['transport'];
      $dayScholar = $_POST['dayScholar'];
      if ($hostel == '1' && $transport == '1' && $dayScholar == '1') {
         if ($progId > 0) $sql = "select st.*, sd.*, sa.*, sr.*, b.batch, p.* from student st, student_detail sd, student_address sa, student_reference sr, batch b, program p where st.$batchField=b.batch_id and st.program_id=p.program_id and st.student_id=sd.student_id and st.student_id=sa.student_id and st.student_id=sr.student_id and st.program_id='$progId' and st.$batchField='$batchId' $leet and st.student_status='$status' order by st.ay_id, st.user_id";
         else $sql = "select st.*, sd.*, sa.*, sr.*, b.batch, p.* from student st, student_detail sd, student_address sa, student_reference sr, batch b, program p where st.$batchField=b.batch_id and st.program_id=p.program_id and st.student_id=sd.student_id and st.student_id=sa.student_id and st.student_id=sr.student_id and st.$batchField='$batchId' $leet and st.student_status='$status' order by st.ay_id, st.user_id";
      }else{
         if ($hostel == '1' && $transport == '0' && $dayScholar == '0')$srs=' and st.student_residential_status="2"';
         elseif ($hostel == '0' && $transport == '1' && $dayScholar == '0')$srs=' and st.student_residential_status="1"';
         elseif ($hostel == '0' && $transport == '0' && $dayScholar == '1')$srs=' and st.student_residential_status="0"';
         else $srs=' and st.student_residential_status>"0"';
         if ($progId > 0) $sql = "select st.*, sd.*, sa.*, sr.*, b.batch, p.* from student st, student_detail sd, student_address sa, student_reference sr, batch b, program p where st.$batchField=b.batch_id and st.program_id=p.program_id and st.student_id=sd.student_id and st.student_id=sa.student_id and st.student_id=sr.student_id and st.program_id='$progId' and st.$batchField='$batchId' $leet $srs and st.student_status='$status' order by st.ay_id, st.user_id";
         else $sql = "select st.*, sd.*, sa.*, sr.*, b.batch, p.* from student st, student_detail sd, student_address sa, student_reference sr, batch b, program p where st.$batchField=b.batch_id and st.program_id=p.program_id and st.student_id=sd.student_id and st.student_id=sa.student_id and st.student_id=sr.student_id and st.$batchField='$batchId' $leet $srs and st.student_status='$status' order by st.ay_id, st.user_id";
      }

      // echo "$progId - $batchId - $leet ";

      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else {
         // echo $result->num_rows;
         $json_array = array();
         $subArray = array();
         while ($rowsStudent = $result->fetch_assoc()) {
            $student_id = $rowsStudent["student_id"];
            $sql_ss = "select * from $tn_ss where student_id='$student_id' and semester='$ssSemester' and mn_id='$mn_id'";
            $result_ss = $conn->query($sql_ss);
            if ($result_ss->num_rows == 0) $subArray["ss"] = '0';
            else $subArray["ss"] = '1';
            $subArray["student_id"] = $student_id;
            $subArray["student_ay"] = getField($conn, $rowsStudent["ay_id"], "batch", "batch_id", "batch");
            $subArray["user_id"] = $rowsStudent["user_id"];
            $subArray["student_name"] = $rowsStudent["student_name"];
            $subArray["program_name"] = $rowsStudent["program_name"];
            $subArray["sp_abbri"] = $rowsStudent["sp_abbri"];
            $subArray["student_rollno"] = $rowsStudent["student_rollno"];
            $subArray["student_mobile"] = $rowsStudent["student_mobile"];
            $subArray["student_semester"] = $rowsStudent["student_semester"];
            $subArray["student_admission"] = $rowsStudent["student_admission"];
            $subArray["student_lateral"] = $rowsStudent["student_lateral"];
            $subArray["student_regular"] = $rowsStudent["student_regular"];
            $subArray["student_scholarship"] = $rowsStudent["student_scholarship"];
            $subArray["student_residential_status"] = $rowsStudent["student_residential_status"];
            $subArray["student_dob"] = $rowsStudent["student_dob"];
            $subArray["student_whatsapp"] = $rowsStudent["student_whatsapp"];
            $subArray["student_adhaar"] = $rowsStudent["student_adhaar"];
            $subArray["student_category"] = $rowsStudent["student_category"];
            $subArray["student_religion"] = $rowsStudent["student_religion"];
            $subArray["student_bg"] = $rowsStudent["student_bg"];
            $subArray["student_fee_category"] = $rowsStudent["student_fee_category"];
            $subArray["student_gender"] = $rowsStudent["student_gender"];
            $subArray["student_fname"] = $rowsStudent["student_fname"];
            $subArray["student_fmobile"] = $rowsStudent["student_fmobile"];
            $subArray["student_femail"] = $rowsStudent["student_femail"];
            $subArray["student_foccupation"] = $rowsStudent["student_foccupation"];
            $subArray["student_fdesignation"] = $rowsStudent["student_fdesignation"];
            $subArray["student_mname"] = $rowsStudent["student_mname"];
            $subArray["student_mmobile"] = $rowsStudent["student_mmobile"];
            $subArray["student_memail"] = $rowsStudent["student_memail"];
            $subArray["permanent_address"] = $rowsStudent["permanent_address"];
            $subArray["city"] = $rowsStudent["city"];
            $subArray["pincode"] = $rowsStudent["pincode"];
            // $state_id=$rowsStudent["state_id"];
            if ($rowsStudent["mn_id"] > 0) $subArray["remarks"] = getField($conn, $rowsStudent["mn_id"], "master_name", "mn_id", "mn_name");
            else $subArray["remarks"] = '--';
            $subArray["state_name"] = getField($conn, $rowsStudent["state_id"], "states", "state_id", "state_name");
            $subArray["district_name"] = getField($conn, $rowsStudent["district_id"], "districts", "district_id", "district_name");
            $subArray["reference_name"] = $rowsStudent["reference_name"];
            $subArray["reference_staff"] = $rowsStudent["reference_staff"];

            $sql_qual = "select sq.*, mn.mn_name from student_qualification sq, master_name mn where sq.student_id='$student_id' and sq.mn_id=mn.mn_id";
            $result_qual = $conn->query($sql_qual);
            $qualArray = array();
            while ($qualRows = $result_qual->fetch_assoc()) {
               $qualArray[] = $qualRows;
            }
            $subArray["qualification"] = $qualArray;
            $json_array[] = $subArray;
         }
         echo json_encode($json_array);
      }
   } elseif ($_POST['action'] == 'studentDisp') {
      $id = $_POST['userId'];
      $sql = "select st.*, sd.*, sa.*, sr.*, b.batch, p.program_name from student st, student_detail sd, student_address sa, student_reference sr, batch b, program p where st.batch_id=b.batch_id and st.user_id='$id' and st.program_id=p.program_id and st.student_id=sd.student_id and st.student_id=sa.student_id and st.student_id=sr.student_id";
      $result = $conn->query($sql);
      $output = $result->fetch_assoc();
      echo json_encode($output);
   } elseif ($_POST['action'] == 'fetchAcademicBatch') {
      $id = $_POST['userId'];
      $sql = "select b.* from student st, batch b where st.ay_id=b.batch_id and st.user_id='$id'";
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
      $sql = "select st.*, sd.*, sa.*, sr.*, b.batch, p.program_name from student st, student_detail sd, student_address sa, student_reference sr, batch b, program p where st.batch_id=b.batch_id and st.user_id='$id' and st.program_id=p.program_id and st.student_id=sd.student_id and st.student_id=sa.student_id and st.student_id=sr.student_id";
      $result = $conn->query($sql);
      $output = $result->fetch_assoc();
      echo json_encode($output);
   } elseif ($_POST['action'] == 'fetchState') {
      $state_id = $_POST['state_id'];
      $sql = "select * from states where state_id='$state_id'";
      $result = $conn->query($sql);
      $output = $result->fetch_assoc();
      echo json_encode($output);
   } elseif ($_POST['action'] == 'fetchDistrict') {
      $district_id = $_POST['district'];
      $sql = "select * from districts where district_id='$district_id'";
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
   } elseif ($_POST['action'] == 'updateReference') {
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

      $stdId = $_POST['stdId'];
      $sql = "select sq.*, mn.mn_name from student_qualification sq, master_name mn where mn.mn_id=sq.mn_id and sq.student_id='$stdId'";
      $result = $conn->query($sql);
      $output = array();
      while ($rows = $result->fetch_assoc()) $output[] = $rows;
      echo json_encode($output);
   } elseif ($_POST['action'] == 'updateQualification') {
      $student_id = $_POST['studentIdQual'];
      $mn_id = $_POST['sel_qual'];
      $sq_institute = $_POST['sq_institute'];
      $sq_board = $_POST['sq_board'];
      $sq_year = $_POST['sq_year'];
      $sq_mo = $_POST['sq_mo'];
      $sq_mm = $_POST['sq_mm'];
      $sq_percentage = $_POST['sq_percentage'];
      $sq_cgpa = $_POST['sq_cgpa'];
      $dup = "select * from student_qualification where student_id='$student_id' and mn_id='$mn_id'";
      $result = $conn->query($dup);
      if ($result->num_rows == 0) {
         $sql = "insert into student_qualification (student_id, mn_id, sq_institute, sq_board, sq_year, sq_mo, sq_mm, sq_percentage, sq_cgpa, update_id, sq_status) values('$student_id','$mn_id', '$sq_institute', '$sq_board', '$sq_year', '$sq_mo', '$sq_mm', '$sq_percentage', '$sq_cgpa', '$myId','0')";
      } else {
         $sql = "update student_qualification set sq_institute='$sq_institute', sq_board='$sq_board', sq_year='$sq_year', sq_mo='$sq_mo', sq_mm='$sq_mm', sq_percentage='$sq_percentage', sq_cgpa='$sq_cgpa', update_ts='$submit_ts', update_id='$myId' where student_id='$student_id' and mn_id='$mn_id'";
      }
      $conn->query($sql);
      echo $conn->error;
   } elseif ($_POST['action'] == 'fetchStudentQualification') {
      $sq_id = $_POST['mn_id'];
      $studentId = $_POST['studentId'];
      $sql = "select sq.*, mn.mn_name FROM student_qualification sq, master_name mn where sq.student_id='$studentId' and sq.sq_id='$sq_id' and sq.sq_id=mn.mn_id";
      $result = $conn->query($sql);
      $output = $result->fetch_assoc();
      echo json_encode($output);
   } elseif ($_POST['action'] == 'studentProgramList') {
      $sql = "SELECT * from program where program_status='0' order by sp_name";
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
      $batch_id = $_POST['batchId'];
      $program_id = $_POST['progId'];
      $sql = "select * from student where program_id='$program_id' and batch_id='$batch_id'";
      $result = $conn->query($sql);
      $json_array = array();
      while ($rowArray = $result->fetch_assoc()) {
         $json_array[] = $rowArray;
      }
      echo json_encode($json_array);
   } elseif ($_POST['action'] == 'dropStudent') {
      $id = $_POST['id'];
      $mn_id = $_POST['mn_id'];
      $sql = "update student set student_status='9' where student_id='$id'";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else echo "Student Removed ";

      $sql = "update student_detail set mn_id='$mn_id' where student_id='$id'";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
   } elseif ($_POST['action'] == 'resetStudent') {
      $id = $_POST['id'];
      $sql = "update student set student_status='0' where student_id='$id'";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else echo "Student Removed ";
      $sql = "update student_detail set mn_id='' where student_id='$id'";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
   } elseif ($_POST['action'] == 'updateStatus') {
      $program_id = $_POST['progId'];
      $batchId = $_POST['batchId'];
      $tn_ss = "student_status" . $batchId;
      $ssId = $_POST['ssId'];
      $ssSemester = $_POST['ssSemester'];

      $sql = "delete from $tn_ss where program_id='$program_id' and semester='$ssSemester' and mn_id='$ssId'";
      $conn->query($sql);

      if (isset($_POST['checkboxes_value'])) {
         $checkBox = $_POST['checkboxes_value'];
         if (count($checkBox) > 0) {
            for ($i = 0; $i < count($checkBox); $i++) {
               $id = $checkBox[$i];
               $sql = "insert into $tn_ss (student_id, program_id, semester, mn_id) values('$id', '$program_id', '$ssSemester', '$ssId')";
               $conn->query($sql);
            }
         }
      }
   } elseif ($_POST['action'] == 'changeBranch') {
      $id = $_POST['studentId'];
      $progId = $_POST['progId'];
      $sql = "update student set program_id='$progId' where student_id='$id'";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else echo " Branch Changed ";
   } elseif ($_POST['action'] == 'changeAdBatch') {
      $id = $_POST['studentId'];
      $batchId = $_POST['batchId'];
      $sql = "update student set batch_id='$batchId' where student_id='$id'";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else echo " Admission Batch Changed ";
   } elseif ($_POST['action'] == 'changeAcBatch') {
      $id = $_POST['studentId'];
      $batchId = $_POST['batchId'];
      $sql = "update student set ay_id='$batchId' where student_id='$id'";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else echo " Academin Batch Changed ";
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
   }
}
