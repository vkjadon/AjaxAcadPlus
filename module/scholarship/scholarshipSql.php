<?php
require('../requireSubModule.php');
// echo $_POST['action'];
if (isset($_POST['action'])) {
   if ($_POST['action'] == 'studentList') {
      $batchId = $_POST['batchId'];
      $progId = $_POST['progId'];
      $semester = $_POST['ssSemester'];

      // echo "$progId - $batchId ";

      if ($progId > 0) $sql = "select st.*, sd.student_fname, sa.permanent_address, sa.state_id from student st, student_detail sd, student_address sa where st.program_id='$progId' and st.ay_id='$batchId' and st.student_id=sd.student_id and st.student_id=sa.student_id and st.student_category<>'Genera' and st.student_status='0' order by st.ay_id, st.student_rollno, st.student_name";

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
            $subArray["user_id"] = $rowsStudent["user_id"];
            $subArray["student_name"] = $rowsStudent["student_name"];
            $subArray["student_rollno"] = $rowsStudent["student_rollno"];
            $subArray["student_mobile"] = $rowsStudent["student_mobile"];
            $subArray["student_semester"] = $rowsStudent["student_semester"];
            $subArray["student_category"] = $rowsStudent["student_category"];
            $subArray["student_fee_category"] = $rowsStudent["student_fee_category"];
            $subArray["student_religion"] = $rowsStudent["student_religion"];
            $subArray["permanent_address"] = $rowsStudent["permanent_address"];
            $subArray["state"] = getField($conn, $rowsStudent["state_id"], "states", "state_id", "state_name");
            $subArray["student_fname"] = $rowsStudent["student_fname"];

            $sql_scl = "select scl.*, mn.mn_name from student_scholarship scl, master_name mn where scl.student_id='$student_id' and scl.semester='$semester' and scl.mn_id=mn.mn_id";
            $result_scl = $conn->query($sql_scl);
            if ($result_scl) {
               $sclArray = array();
               while ($sclRows = $result_scl->fetch_assoc()) {
                  $sclArray[] = $sclRows;
               }
               $subArray["scholarship"] = $sclArray;
            } else echo $conn->error;
            $json_array[] = $subArray;
         }
         echo json_encode($json_array);
         mysqli_free_result($result);
      }
   } elseif ($_POST['action'] == 'updateScholarship') {
      // echo "Update Function";
      $sql = "insert into student_scholarship (student_id, mn_id, semester, scholarship_amount, scholarship_ts, scholarship_id, sscl_status) values ('" . $_POST['student_id'] . "', '" . $_POST['sel_ss'] . "', '" . $_POST['ssSemester'] . "', '" . $_POST['sscl_amount'] . "','$submit_ts', '$myId', '0')";
      $result = $conn->query($sql);
      if (!$result) {
         // echo mysqli_errno($conn);
         $sql = "update student_scholarship set scholarship_amount='" . $_POST['sscl_amount'] . "', scholarship_ts='$submit_ts', scholarship_id='$myId' where student_id='" . $_POST['student_id'] . "' and mn_id= '" . $_POST['sel_ss'] . "' and semester='" . $_POST['ssSemester'] . "' ";
         $result = $conn->query($sql);
         if (!$result) echo $conn->error;
         else echo "Scholarship Updated !! ";
      } else echo "Scholarship Added !! ";
   } elseif ($_POST['action'] == 'deleteScholarship') {
      $sql = "delete from student_scholarship where student_id='" . $_POST['student_id'] . "' and mn_id='" . $_POST['mn_id'] . "'";
      $result = $conn->query($sql);
      // echo "Deleted";
   } elseif ($_POST['action'] == 'scholarshipStageList') {
      $batchId = $_POST['batchId'];
      $progId = $_POST['progId'];
      $semester = $_POST['ssSemester'];

      // echo "$progId - $batchId ";

      $sql = "select st.user_id, st.student_id, st.student_name, st.student_mobile, st.student_rollno, sd.student_fname, scl.*, mn.mn_name from student st, student_detail sd, student_scholarship scl, master_name mn where scl.student_id=st.student_id and st.student_id=sd.student_id and st.ay_id='" . $batchId . "' and st.program_id='" . $progId . "' and scl.semester='" . $semester . "' and scl.mn_id=mn.mn_id order by st.student_rollno, st.student_name, scl.mn_id";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else {
         // echo $result->num_rows;
         $json_array = array();
         while ($rowsStudent = $result->fetch_assoc()) {
            $json_array[] = $rowsStudent;
         }
         echo json_encode($json_array);
      }
   } elseif ($_POST['action'] == 'updateStage') {
      if ($_POST['sel_stage'] == 2) {
         $amount = "applied_amount";
         $ts = "applied_ts";
      } elseif ($_POST['sel_stage'] == 3) {
         $amount = "sanctioned_amount";
         $ts = "sanctioned_ts";
      } elseif ($_POST['sel_stage'] == 4) {
         $amount = "released_amount";
         $ts = "released_ts";
      } else {
         $amount = "deposited_amount";
         $ts = "deposited_ts";
      }
      if($_POST['sel_stage'] > 0){
         $sql = "update student_scholarship set $amount='" . $_POST['stage_amount'] . "', $ts='$submit_ts', applied_id='$myId' where student_id='" . $_POST['student_id'] . "' and mn_id='" . $_POST['mn_id'] . "' and semester='" . $_POST['ssSemester'] . "'";
         $result = $conn->query($sql);
         echo "Update";
         if (!$result) echo $conn->error;
      }else echo "Select Stage ";
   } elseif ($_POST['action'] == 'removeStage') {
      $sql = "delete from student_scholarship where student_id='" . $_POST['student_id'] . "' and mn_id='" . $_POST['mn_id'] . "' and sscl_stage='" . $_POST['sscl_stage'] . "'";
      $result = $conn->query($sql);
      echo "Removed";
      if (!$result) echo $conn->error;
   }
}
