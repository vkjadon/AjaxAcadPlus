<?php
require('../requireSubModule.php');
if (isset($_POST['action'])) {
   if ($_POST['action'] == 'studentList') {
      $batchId = $_POST['batchId'];
      $blockId = $_POST['blockId'];
      $sel_date = $_POST['sel_date'];
      $colM = 'M' . date("Md_Y", strtotime($sel_date));
      $sql = "alter table $tn_ha add column $colM int(1)";
      $conn->query($sql);
      $colE = 'E' . date("Md_Y", strtotime($sel_date));
      $sql = "alter table $tn_ha add column $colE int(1)";
      $conn->query($sql);

      if ($_POST['gender'] == 'F') $gender = " and st.student_gender='F' ";
      elseif ($_POST['gender'] == 'M') $gender = " and st.student_gender='M' ";
      else $gender = "";
      $sql = "select st.student_id, st.student_name, st.ay_id, st.user_id, st.student_rollno, st.student_mobile, st.student_gender, st.batch_id, sd.student_fname, p.* from student st, student_detail sd, batch b, program p where st.ay_id=b.batch_id and st.program_id=p.program_id and st.student_id=sd.student_id and st.ay_id='$batchId' and st.student_residential_status='1' $gender and st.student_status='0' order by st.student_gender, st.ay_id, p.program_abbri, st.user_id";

      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else {
         // echo $result->num_rows;
         $json_array = array();
         $subArray = array();
         while ($rowsStudent = $result->fetch_assoc()) {
            $student_id = $rowsStudent["student_id"];
            $subArray["student_id"] = $student_id;
            $subArray["student_ay"] = getField($conn, $rowsStudent["ay_id"], "batch", "batch_id", "batch");
            $subArray["student_batch"] = getField($conn, $rowsStudent["batch_id"], "batch", "batch_id", "batch");
            $subArray["user_id"] = $rowsStudent["user_id"];
            $subArray["student_name"] = $rowsStudent["student_name"];
            $subArray["program_abbri"] = $rowsStudent["program_abbri"];
            $subArray["sp_name"] = $rowsStudent["sp_name"];
            $subArray["sp_abbri"] = $rowsStudent["sp_abbri"];
            $subArray["student_rollno"] = $rowsStudent["student_rollno"];
            $subArray["student_mobile"] = $rowsStudent["student_mobile"];
            $subArray["student_gender"] = $rowsStudent["student_gender"];
            $subArray["student_fname"] = $rowsStudent["student_fname"];

            $sql_hostel = "select * from hostel_student where student_id='$student_id' and block_id='$blockId' and hs_status='0'";
            $result_hostel = $conn->query($sql_hostel);
            if ($result_hostel->num_rows == 1) $subArray["hs"] = "1";
            else $subArray["hs"] = "0";

            $sql_hostel = "select * from $tn_ha where student_id='$student_id' and $colM='1'";
            $result_hostel = $conn->query($sql_hostel);
            if ($result_hostel->num_rows == 1) $subArray["haM"] = "1";
            else $subArray["haM"] = "0";

            $sql_hostel = "select * from $tn_ha where student_id='$student_id' and $colE='1'";
            $result_hostel = $conn->query($sql_hostel);
            if ($result_hostel->num_rows == 1) $subArray["haE"] = "1";
            else $subArray["haE"] = "0";


            $json_array[] = $subArray;
         }
         echo json_encode($json_array);
         mysqli_free_result($result);
      }
   } elseif ($_POST['action'] == 'studentDisp') {
      $id = $_POST['userId'];
      $sql = "select st.*, sd.*, sa.*, sr.*, b.batch, p.program_name from student st, student_detail sd, student_address sa, student_reference sr, batch b, program p where st.batch_id=b.batch_id and st.user_id='$id' and st.program_id=p.program_id and st.student_id=sd.student_id and st.student_id=sa.student_id and st.student_id=sr.student_id";
      $result = $conn->query($sql);
      $output = $result->fetch_assoc();
      echo json_encode($output);
      addActivity($conn, $myId, "studentDisp", $submit_ts);
      mysqli_free_result($result);
   } elseif ($_POST['action'] == 'fetchAcademicBatch') {
      $id = $_POST['userId'];
      $sql = "select b.* from student st, batch b where st.ay_id=b.batch_id and st.user_id='$id'";
      $result = $conn->query($sql);
      $output = $result->fetch_assoc();
      echo json_encode($output);
      mysqli_free_result($result);
      addActivity($conn, $myId, $_POST['action'], $submit_ts);
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
      // mysqli_free_result($result);
      addActivity($conn, $myId, $_POST['action'], $submit_ts);
   } elseif ($_POST['action'] == 'fetchStudent') {
      $id = $_POST['userId'];
      $sql = "select st.*, sd.*, sa.*, sr.*, b.batch, p.program_abbri, p.sp_abbri from student st, student_detail sd, student_address sa, student_reference sr, batch b, program p where st.batch_id=b.batch_id and st.user_id='$id' and st.program_id=p.program_id and st.student_id=sd.student_id and st.student_id=sa.student_id and st.student_id=sr.student_id";
      $result = $conn->query($sql);
      $output = $result->fetch_assoc();
      echo json_encode($output);
      mysqli_free_result($result);
      addActivity($conn, $myId, $_POST['action'], $submit_ts);
   } elseif ($_POST['action'] == 'hostelUpdate') {
      $block_id = $_POST['blockId'];
      $sql = "update hostel_student set hs_status='9' where block_id='$block_id'";
      $conn->query($sql);
      if (isset($_POST['checkboxes_value'])) {
         $checkBox = $_POST['checkboxes_value'];
         if (count($checkBox) > 0) {
            for ($i = 0; $i < count($checkBox); $i++) {
               $id = $checkBox[$i];
               $sql_dup = "select * from hostel_student where student_id='$id'";
               $result_dup = $conn->query($sql_dup);
               if ($result_dup->num_rows == 1) $sql = "update hostel_student set block_id='$block_id', hs_status='0' where student_id='$id'";
               else $sql = "insert into hostel_student (student_id, block_id, hs_status) values('$id', '$block_id', '0')";
               $conn->query($sql);
            }
         }
      }
      addActivity($conn, $myId, $_POST['action'], $submit_ts);
   } elseif ($_POST['action'] == 'attendanceUpdate') {
      $student_id = $_POST['student_id'];
      $tag = $_POST['tag'];
      $attendance = $_POST['attendance'];
      $sel_date = $_POST['sel_date'];

      if ($tag == 'ha_morning') $col = 'M' . date("Md_Y", strtotime($sel_date));
      else $col = 'E' . date("Md_Y", strtotime($sel_date));

      echo "Attend $attendance Std $student_id tag $tag date $col";

      $sql_dup = "select * from $tn_ha where student_id='$student_id'";
      $result_dup = $conn->query($sql_dup);
      if ($result_dup->num_rows == 1) $sql = "update $tn_ha set $col='$attendance' where student_id='$student_id'";
      else $sql = "insert into $tn_ha (student_id, $col) values('$student_id', '$attendance')";
      $conn->query($sql);

   }
}
