<?php
require('../requireSubModule.php');
//echo $_POST['action'];
if (isset($_POST["query"])) {
   $output = '';
   if($_POST["sel_school"]=='ALL')$sql = "select s.student_id, s.student_name, sd.student_fname, b.batch, student_rollno from student s, student_detail sd, batch b where (s.student_name LIKE '%" . $_POST["query"] . "%' or s.student_rollno LIKE '%" . $_POST["query"] . "%' )and s.student_id=sd.student_id and s.ay_id=b.batch_id and s.student_status='0' limit 15";
   else $sql = "select s.student_id, s.student_name, sd.student_fname, b.batch, student_rollno from student s, student_detail sd, batch b, school_dept scd, dept_program dp where (s.student_name LIKE '%" . $_POST["query"] . "%' or s.student_rollno LIKE '%" . $_POST["query"] . "%' )and s.student_id=sd.student_id and s.ay_id=b.batch_id and scd.school_id='" . $_POST["sel_school"] . "' and scd.dept_id=dp.dept_id and dp.program_id=s.program_id and s.student_status='0' and s.program_id>0 limit 15";
   $result = $conn->query($sql);
   $output = '<ul class="list-group">';
   if ($result) {
     while ($row = $result->fetch_assoc()) {
       $output .= '<li class="list-group-item list-group-item-action autoList" style="z-index: 4;" data-std="' . $row["student_id"] . '" >' . $row["student_name"] . ' [' . $row["student_fname"] . ']' . $row["batch"] . '</li>';
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
      addActivity($conn, $myId, "Enter Student List", $myTimeLag);

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
      } else {
         if ($hostel == '1' && $transport == '0' && $dayScholar == '0') $srs = ' and st.student_residential_status="2"';
         elseif ($hostel == '0' && $transport == '1' && $dayScholar == '0') $srs = ' and st.student_residential_status="1"';
         elseif ($hostel == '0' && $transport == '0' && $dayScholar == '1') $srs = ' and st.student_residential_status="0"';
         else $srs = ' and st.student_residential_status>"0"';
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
         addActivity($conn, $myId, "End of Student List", $myTimeLag);
      }
   } elseif ($_POST['action'] == 'studentDisp') {
      $id = $_POST['userId'];
      $sql = "select st.*, sd.*, sa.*, sr.*, b.batch, p.program_name from student st, student_detail sd, student_address sa, student_reference sr, batch b, program p where st.batch_id=b.batch_id and st.user_id='$id' and st.program_id=p.program_id and st.student_id=sd.student_id and st.student_id=sa.student_id and st.student_id=sr.student_id";
      $result = $conn->query($sql);
      $output = $result->fetch_assoc();
      echo json_encode($output);
      addActivity($conn, $myId, "studentDisp", $myTimeLag);
   } elseif ($_POST['action'] == 'fetchStudent') {
      $id = $_POST['userId'];
      $sql = "select st.*, sd.*, sa.*, sr.*, b.batch, p.program_name from student st, student_detail sd, student_address sa, student_reference sr, batch b, program p where st.batch_id=b.batch_id and st.user_id='$id' and st.program_id=p.program_id and st.student_id=sd.student_id and st.student_id=sa.student_id and st.student_id=sr.student_id";
      $result = $conn->query($sql);
      $output = $result->fetch_assoc();
      echo json_encode($output);
      addActivity($conn, $myId, $_POST['action'], $myTimeLag);
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
      addActivity($conn, $myId, $_POST['action'], $myTimeLag);
   } 
}
