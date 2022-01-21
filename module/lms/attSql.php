<?php
require('../requireSubModule.php');

//echo $_POST['action'];
//global $tn_tt;
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'studentClassSubjectList') {
    $sasId = $_POST['sasId'];
    //echo "SAS ".$sasId;
    $tlId = getField($conn, $sasId, $tn_sas, "sas_id", "tl_id");
    $date = getField($conn, $sasId, $tn_sas, "sas_id", "sas_date");
    $period = getField($conn, $sasId, $tn_sas, "sas_id", "sas_period");
    $tlgId = getField($conn, $tlId, $tn_tl, "tl_id", "tlg_id");
    $tlGroup = getField($conn, $tlId, $tn_tl, "tl_id", "tl_group");
    $subjectId = getField($conn, $tlgId, $tn_tlg, "tlg_id", "subject_id");
    $classId = getField($conn, $tlgId, $tn_tlg, "tlg_id", "class_id");
    $tlgType = getField($conn, $tlgId, $tn_tlg, "tlg_id", "tlg_type");

    //echo "tlId ".$tlId.'<br>OK';

    $current_ts = strtotime($date);
    $dayofDate = date("D", $current_ts);

    $subject_code = getField($conn, $subjectId, 'subject', 'subject_id', 'subject_code');
    $subject_name = getField($conn, $subjectId, 'subject', 'subject_id', 'subject_name');
    $className = getField($conn, $classId, 'class', 'class_id', 'class_name');
    $class_section = getField($conn, $classId, 'class', 'class_id', 'class_section');

    $tn_sa = 'student_attendance' . $classId;
    //sa_attendance=0 mean present and sa_attendance=1 means Absent

    $json = get_studentClassSubjectList($conn, $tn_rs, $tlId);
    //echo $json;
    $array = json_decode($json, true);
    $student = count($array["data"]);
    $sno = 1;
    echo '<div class="row">';
    echo '<div class="col-8 pr-0">';
    echo '<table class="table list-table-xs">';
    echo '<tr><th>#</th><th>Id</th><th>Name</th><th>RollNo</th><th>Status</th><th>DoReg</th>';
    echo '<th>Att</th><th>Del</th><th>%</th></tr>';
    for ($i = 0; $i < $student; $i++) {
      $student_id = $array["data"][$i]["student"];
      $regDate = $array["data"][$i]["date"];
      $sql = "select * from student where student_id='$student_id'";
      $result = $conn->query($sql);
      $rows = $result->fetch_assoc();

      $name = $rows["student_name"];
      $rollno = $rows["student_rollno"];
      $mobile = $rows["student_mobile"];
      $email = $rows["student_email"];
      $output = get_subjectAttendance($conn, $tn_sa, $tn_sas, $tlId, $student_id);
      $sqlSA = "insert into $tn_sa (sas_id, student_id, sa_attendance) values('$sasId', '$student_id', '0')";
      $conn->query($sqlSA);
      $sql = "select * from $tn_sa where sas_id='$sasId' and student_id='$student_id'";
      $sa = getFieldValue($conn, "sa_attendance", $sql);
      if ($sa == '0') $checked = 'checked';
      else $checked = "";
      echo '<tr>';
      echo '<td>' . $sno++ . '</td><td>' . $student_id . '</td><td>' . $name . '</td><td>' . $rollno . '</td>';
      echo '<td>';
      echo '<label class="switch">
      <input type="checkbox" class="markAttendance" ' . $checked . ' data-sas="' . $sasId . '" data-std="' . $student_id . '" data-sa="' . $sa . '">
      <span class="slider round"></span>
    </label>';
      if ($output[0] == 0) echo '</td><td>' . $regDate . '</td><td>' . $output[1] . '</td><td>' . $output[0] . '</td><td>--</td>';
      else echo '</td><td>' . $regDate . '</td><td>' . $output[1] . '</td><td>' . $output[0] . '</td><td>' . ceil(($output[1] / $output[0]) * 100) . '</td>';
      echo '</tr>';
    }
    echo '</table>';
    echo '</div>';

    echo '<div class="col-md-4 pl-1 pr-0">';
    echo '<div class="card mb-2">
    <div class="card-body mb-0">';
    echo '<div class="row">';
    echo '<div class="col-sm-8 pr-0">';
    echo '<h5 class="card-title"  data-tl="' . $tlId . '">' . $date . '[' . $dayofDate . ']  :' . $period . ' </h5>
      <h6 class="card-subtitle mb-2 text-muted">' . $subject_name . ' [' . $subjectId . ']</h6>
      <h6 class="card-subtitle mb-2 text-muted">' . $className . ' [' . $class_section . ' ]<b>[' . $tlgType . 'G-' . $tlGroup . ']</b></h6>';
    echo '</div>';
    echo '<div class="col">';
    echo '<div id="attStats">';
    $sql = "select * from $tn_sa where sa_attendance='0' and sas_id='$sasId'";
    $result = $conn->query($sql);
    echo '<h6>P : ' . $result->num_rows . '</h6>';
    $sql = "select * from $tn_sa where sa_attendance='1' and sas_id='$sasId'";
    $result = $conn->query($sql);
    echo '<h6>A : ' . $result->num_rows . '</h6>';
    echo '<button class="btn btn-danger btn-square-xs lock" data-sas="' . $sasId . '" >LOCK</button>';
    echo '</div>
      </div></div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="card mb-2 overflow-auto" style="height: 250px;">
      <div class="card-body">';
    $sql = "select * from $tn_sbt where subject_id='$subjectId' and sbt_type='$tlgType' and sbt_status='0' order by sbt_sno";
    echo '<table class="table list-table-xs">';
    $result = $conn->query($sql);
    while ($rows = $result->fetch_assoc()) {
      $sbtId = $rows["sbt_id"];

      $sqlST = "select * from $tn_ccd where sas_id='$sasId' and sbt_id='$sbtId'";
      //echo $conn->query($sqlST)->num_rows;
      if ($conn->query($sqlST)->num_rows > 0) $checked = 'checked';
      else $checked = "";

      echo '<tr><td><input type="checkbox" class="sasST" ' . $checked . ' name="sas_st" data-sasST="' . $sbtId . '" data-sas="' . $sasId . '"></td><td>' . $sbtId . '</td><td>' . $rows["sbt_name"] . '</td>';
      echo '</tr>';
    }
    echo '</table>';
    echo '</div></div>';

    echo '</div>';
  } elseif ($_POST['action'] == 'showSchedule') {
    $from = $_POST['scheduleFrom'];
    $to = $_POST['scheduleTo'];
    //echo "$from - $to";
    $days = (strtotime($to) - strtotime($from)) / (24 * 60 * 60) + 1;

    $day = array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
    for ($k = 0; $k < $days; $k++) {
      $current_ts = strtotime($from) + $k * 24 * 60 * 60;
      $current_date = date("Y-m-d", $current_ts);
      $dayofDate = date("D", $current_ts);
      echo '<div class="row">';
      echo '<div class="col-2">';
      echo '<div class="card mb-2">';
      echo '<div class="card-header"><h4>' . date("d-M", $current_ts) . '</h4></div>';
      echo '<div class="card-body">' . $dayofDate . '</div>';
      echo '</div></div>';

      $sql = "select sas.*, tl.tl_id, tl.tl_group, tlg.* from $tn_sas sas, $tn_tl tl, $tn_tlg tlg where sas.tl_id=tl.tl_id and tl.tlg_id=tlg.tlg_id and sas.staff_id='$myId' and sas.sas_date='$current_date' and sas_status='0' order by sas.sas_period";
      $result = $conn->query($sql);
      $sno = 0;
      if ($result && $result->num_rows > 0) {
        while ($rows = $result->fetch_assoc()) {
          $sno++;
          $sas_id = $rows['sas_id'];
          $tl_id = $rows['tl_id'];
          $tl_group = $rows['tl_group'];
          $subject_id = $rows['subject_id'];
          $subject_code = getField($conn, $subject_id, 'subject', 'subject_id', 'subject_code');

          $tlg_id = $rows['tlg_id'];
          $tlg_type = $rows['tlg_type'];

          $class_id = $rows['class_id'];
          $class_name = getField($conn, $class_id, 'class', 'class_id', 'class_name');
          $class_section = getField($conn, $class_id, 'class', 'class_id', 'class_section');

          $sas_mark = $rows['sas_mark'];


          $tn_sa = 'student_attendance' . $class_id;
          check_tn_sa($conn, $tn_sa);

          $check = getField($conn, $sas_id, $tn_sa, "sas_id", "student_id");
          if (strlen($check) > 0) $update_ts = getField($conn, $sas_id, $tn_sas, "sas_id", "update_ts");

          echo '<div class="col-2"><div class="card mb-2 p-0">';
          echo 'Id:' . $rows['sas_id'];
          echo '<div class="card-body m-0 p-2">
          <h5 class="card-title m-0">Period : ' . $rows['sas_period'] . ' </h5>
          <h6 class="text-muted m-0 pt-2">' . $class_name . ' [' . $class_section . ' ]<b>[' . $tlg_type . 'G-' . $tl_group . ']</b></h6>
          <h6 class="text-muted m-0 pt-2">' . $subject_code . ' [' . $subject_id . ']</h6>';
          echo '</div>';
          echo '<div class="card-footer m-0 p-0">';

          if ($sas_mark == '0') echo '<button class="btn btn-danger btn-block m-0 p-0 showAttendanceList" data-tl="' . $tl_id . '" data-sas="' . $sas_id . '">Mark/Update</button>';
          else echo '<button class="btn btn-info btn-block btn-square-xs unlockRequest" data-sas="' . $sas_id . '">Unlock Request</button>';
          echo '</div></div>';
          echo '</div>';
        }
      }
      echo '</div>';
    }
  } elseif ($_POST['action'] == 'markAttendance') {
    $sasId = $_POST['sasId'];
    $student_id = $_POST['studentId'];
    if ($_POST['checkboxStatus'] == "true") $status = '0';
    else $status = '1';
    $tlId = getField($conn, $sasId, $tn_sas, "sas_id", "tl_id");
    $tlgId = getField($conn, $tlId, $tn_tl, "tl_id", "tlg_id");
    $classId = getField($conn, $tlgId, $tn_tlg, "tlg_id", "class_id");
    $tn_sa = 'student_attendance' . $classId;
    $mark_status = getField($conn, $sasId, $tn_sas, "sas_id", "sas_mark");
    if ($mark_status == 0) {
      $sql = "update $tn_sa set sa_attendance='$status' where sas_id='$sasId' and student_id='$student_id'";
      $conn->query($sql);
      $sql = "select * from $tn_sa where sa_attendance='0' and sas_id='$sasId'";
      $result = $conn->query($sql);
      echo '<h6>P : ' . $result->num_rows . '</h6>';
      $sql = "select * from $tn_sa where sa_attendance='1' and sas_id='$sasId'";
      $result = $conn->query($sql);
      echo '<h6>A : ' . $result->num_rows . '</h6>';
      echo '<button class="btn btn-danger btn-square-xs lock" data-sas="' . $sasId . '">LOCK</button>';
    } else echo "<h5>The attendance is Locked.</h5><h6> The changes will not be Saved!!</h5>";
  } elseif ($_POST['action'] == "addST") {
    $sasId = $_POST['sasId'];
    $sbtId = $_POST['stId'];
    $stAction = $_POST['stAction'];
    echo "$sasId - $sbtId - $stAction";

    if ($stAction == 'add') $sql = "insert into $tn_ccd (sas_id, sbt_id) values('$sasId','$sbtId')";
    else $sql = "delete from $tn_ccd where sas_id='$sasId' and sbt_id='$sbtId'";
    $mark_status = getField($conn, $sasId, $tn_sas, "sas_id", "sas_mark");
    if ($mark_status == 0) $conn->query($sql);
  } elseif ($_POST['action'] == "lockAtt") {
    $sasId = $_POST['sasId'];
    echo "SSS $sasId";
    $sql = "update $tn_sas set sas_mark='1', update_ts='$submit_ts' where sas_id='$sasId'";
    $conn->query($sql);
  } elseif ($_POST['action'] == "fetchAttRegHeaderFooter") {
    $tlId = $_POST['tlId'];

    // From Teaching Load
    $tlgId = getField($conn, $tlId, $tn_tl, "tl_id", "tlg_id");
    $tlGroup = getField($conn, $tlId, $tn_tl, "tl_id", "tl_group");

    // From Teacihng Load Group
    $subjectId = getField($conn, $tlgId, $tn_tlg, "tlg_id", "subject_id");
    $classId = getField($conn, $tlgId, $tn_tlg, "tlg_id", "class_id");
    $tlgType = getField($conn, $tlgId, $tn_tlg, "tlg_id", "tlg_type");

    // From Subject
    $subject_code = getField($conn, $subjectId, 'subject', 'subject_id', 'subject_code');
    $subject_name = getField($conn, $subjectId, 'subject', 'subject_id', 'subject_name');

    // From Class
    $className = getField($conn, $classId, 'class', 'class_id', 'class_name');
    $class_section = getField($conn, $classId, 'class', 'class_id', 'class_section');

    // echo $className;

    $output = array(
      "class_name" => $className,
      "class_section" => $class_section,
      "subject_name" => $subject_name,
      "subject_code" => $subject_code
    );
    echo json_encode($output);
    $tn_sa = 'student_attendance' . $classId;
  } elseif ($_POST['action'] == "attRecord") {
    $tlId = $_POST['tlId'];

    // From Teaching Load
    $tlgId = getField($conn, $tlId, $tn_tl, "tl_id", "tlg_id");
    $tlGroup = getField($conn, $tlId, $tn_tl, "tl_id", "tl_group");

    // From Teacihng Load Group
    $subjectId = getField($conn, $tlgId, $tn_tlg, "tlg_id", "subject_id");
    $classId = getField($conn, $tlgId, $tn_tlg, "tlg_id", "class_id");
    $tlgType = getField($conn, $tlgId, $tn_tlg, "tlg_id", "tlg_type");

    $sql = "select * from $tn_sas where tl_id='$tlId' order by sas_date, sas_period";
    $result = $conn->query($sql);
    $count = 0;
    $data = array();
    while ($sasRows = $result->fetch_assoc()) {
      $sas[$count] = $sasRows["sas_id"];
      $sas_date[$count] = $sasRows["sas_date"];
      $sas_period[$count] = $sasRows["sas_period"];
      $count++;
    }
    // $data[] = $sub_array;

    $tn_sa = 'student_attendance' . $classId;

    // echo $className;
    $sql = "select * from $tn_rs where tl_id='$tlId'";
    $result = $conn->query($sql);
    if (!$result) die(" The script could not be Loadded! Unable to populate Student List !");
    while ($rows = $result->fetch_assoc()) {
      $sub_array = array();
      $sub_array["student_id"] = $rows['student_id'];
      $sub_array["student_name"] = getField($conn, $rows['student_id'], "student", "student_id", "student_name");
      $sub_array["student_rollno"] = getField($conn, $rows['student_id'], "student", "student_id", "student_rollno");
      $sub_array["rs_date"] = $rows['rs_date'];
      $absents=0;$presents=0;$delivered=0;
      for ($i = 0; $i < $count; $i++) {
        $sql_sa = "select * from $tn_sa where sas_id='" . $sas[$i] . "' and student_id='" . $rows['student_id'] . "'";
        $result_sa = $conn->query($sql_sa);
        if ($result_sa && $result_sa->num_rows > 0) {
          $saRows = $result_sa->fetch_assoc();
          if ($saRows["sa_attendance"] == '1') {
            $sub_array["sa_attendance"][] = 'A';
            $absents++;
          }
          else {
            $sub_array["sa_attendance"][] = 'P';
            $presents++;
          }
        } else $sub_array["sa_attendance"][] = '--';
      }
      $sub_array["presents"]=ceil(($presents/($absents+$presents))*100);
      $data[] = $sub_array;
    }
    $output = array(
      "records" => $data,
      "dates" => $sas_date,
      "sas_id" => $sas
    );
    echo json_encode($output);
  } elseif($_POST['action']=="updateAttendance"){
    $tlId = $_POST['tlId'];
    $sas_id=$_POST['sas_id'];
    $student_id=$_POST['student_id'];
    $attendance=$_POST['attendance'];
    if($attendance=='A')$attendance='1';
    else $attendance='0';
    $tlgId = getField($conn, $tlId, $tn_tl, "tl_id", "tlg_id");
    $classId = getField($conn, $tlgId, $tn_tlg, "tlg_id", "class_id");
    // echo $sas_id.'-'.$tlId.'-'.$tlgId.'-'.$classId;
    $tn_sa="student_attendance".$classId;
    $sql="update $tn_sa set sa_attendance='$attendance' where student_id='$student_id' and sas_id='$sas_id'";
    $conn->query($sql);
    $sql="select * from $tn_sa sa, $tn_sas sas where sas.tl_id='$tlId' and sa.sas_id=sas.sas_id and sa.student_id='$student_id' and sa.sa_attendance='0'";
    $result=$conn->query($sql);
    $presents=$result->num_rows;
    $sql="select * from $tn_sa sa, $tn_sas sas where sas.tl_id='$tlId' and sa.sas_id=sas.sas_id and sa.student_id='$student_id' and sa.sa_attendance='1'";
    $result=$conn->query($sql);
    $absents=$result->num_rows;
    $percent=ceil($presents/($absents+$presents)*100);
    echo $percent;
  }
}
