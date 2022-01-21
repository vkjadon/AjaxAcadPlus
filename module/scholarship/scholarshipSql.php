<?php
require('../requireSubModule.php');
// echo $_POST['action'];
if (isset($_POST['action'])) {
   if ($_POST['action'] == 'studentList') {
      $batchId = $_POST['batchId'];
      $tn_ss = "student_status" . $batchId;
      // $mn_id = $_POST['mn_id'];
      $progId = $_POST['progId'];
      $semester = $_POST['ssSemester'];
      $leet = $_POST['leet'];
      if ($leet == '1') $leet = ' and st.student_lateral="1"';
      else $leet = '';
      $ay = $_POST['ay'];
      if ($ay == '1') $batchField = 'ay_id';
      else $batchField = 'batch_id';

      $deleted = $_POST['deleted'];
      if ($deleted == '1') $status = '9';
      else $status = '0';

      // echo "$progId - $batchId - $leet ";
      if ($progId > 0) $sql = "select st.*, sd.*, sa.*, sr.*, b.batch, p.* from student st, student_detail sd, student_address sa, student_reference sr, batch b, program p where st.$batchField=b.batch_id and st.program_id=p.program_id and st.student_id=sd.student_id and st.student_id=sa.student_id and st.student_id=sr.student_id and st.program_id='$progId' and st.$batchField='$batchId' $leet and st.student_status='$status' and student_scholarship='1' order by st.ay_id, st.user_id";
      else $sql = "select st.*, sd.*, sa.*, sr.*, b.batch, p.* from student st, student_detail sd, student_address sa, student_reference sr, batch b, program p where st.$batchField=b.batch_id and st.program_id=p.program_id and st.student_id=sd.student_id and st.student_id=sa.student_id and st.student_id=sr.student_id and st.$batchField='$batchId' $leet and st.student_status='$status' and student_scholarship='1' order by st.ay_id, st.user_id";

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
            $subArray["sp_abbri"] = $rowsStudent["sp_abbri"];
            $subArray["student_rollno"] = $rowsStudent["student_rollno"];
            $subArray["student_mobile"] = $rowsStudent["student_mobile"];
            $subArray["student_semester"] = $rowsStudent["student_semester"];
            $subArray["student_admission"] = $rowsStudent["student_admission"];
            $subArray["student_lateral"] = $rowsStudent["student_lateral"];
            $subArray["student_regular"] = $rowsStudent["student_regular"];
            $subArray["student_scholarship"] = $rowsStudent["student_scholarship"];
            $subArray["student_residential_status"] = $rowsStudent["student_residential_status"];
            $subArray["student_category"] = $rowsStudent["student_category"];
            $subArray["student_fee_category"] = $rowsStudent["student_fee_category"];
            $subArray["student_fname"] = $rowsStudent["student_fname"];

            $sql_scl = "select scl.*, mn.mn_name from student_scholarship scl, master_name mn where scl.student_id='$student_id' and scl.semester='$semester' and scl.mn_id=mn.mn_id and scl.sscl_stage='1'";
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
      }
   } elseif ($_POST['action'] == 'updateScholarship') {
      $sql = "insert into student_scholarship (student_id, mn_id, semester, sscl_stage, sscl_amount, sscl_date, update_id, sscl_status) values ('" . $_POST['student_id'] . "', '" . $_POST['sel_ss'] . "', '" . $_POST['ssSemester'] . "', '1', '" . $_POST['sscl_amount'] . "','$submit_date', '$myId', '0')";
      $result = $conn->query($sql);
      // echo "updated";
   } elseif ($_POST['action'] == 'deleteScholarship') {
      $sql = "delete from student_scholarship where student_id='" . $_POST['student_id'] . "' and mn_id='" . $_POST['mn_id'] . "'";
      $result = $conn->query($sql);
      // echo "Deleted";
   } elseif ($_POST['action'] == 'scholarshipStageList') {
      $batchId = $_POST['batchId'];
      $progId = $_POST['progId'];
      $semester = $_POST['ssSemester'];
      $sql = "select st.*, sd.student_fname, scl.*, mn.mn_name from student st, student_detail sd, student_scholarship scl, master_name mn where scl.student_id=st.student_id and st.student_id=sd.student_id and st.ay_id='" . $batchId . "' and st.program_id='" . $progId . "' and scl.semester='".$semester."' and scl.mn_id=mn.mn_id order by st.user_id, st.student_name, scl.mn_id, scl.sscl_stage";
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
      $sql = "insert into student_scholarship (student_id, mn_id, semester, sscl_stage, sscl_amount, sscl_date, update_id, sscl_status) values ('" . $_POST['student_id'] . "', '" . $_POST['mn_id'] . "', '" . $_POST['ssSemester'] . "', '" . $_POST['sel_stage'] . "', '" . $_POST['stage_amount'] . "', '" . $_POST['sscl_date'] . "', '$myId', '0')";
      $result = $conn->query($sql);
      if (!$result) {
         echo $conn->error;
         $sql = "update student_scholarship set sscl_amount='" . $_POST['stage_amount'] . "', sscl_date='" . $_POST['sscl_date'] . "', update_id='$myId' where student_id='" . $_POST['student_id'] . "' and mn_id='" . $_POST['mn_id'] . "' and sscl_stage='" . $_POST['sel_stage'] . "'";
         $result = $conn->query($sql);
         echo "Update";
         if (!$result) echo $conn->error;
      } else echo "added";
   } elseif ($_POST['action'] == 'removeStage') {
      $sql = "delete from student_scholarship where student_id='" . $_POST['student_id'] . "' and mn_id='" . $_POST['mn_id'] . "' and sscl_stage='" . $_POST['sscl_stage'] . "'";
      $result = $conn->query($sql);
      echo "Removed";
      if (!$result) echo $conn->error;
   }
}
