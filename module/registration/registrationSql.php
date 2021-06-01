<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
//echo $_POST['action'];
$sno = 0;
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'sbpList') {
    $class_id = $_POST['classId'];

    $class_semester = getField($conn, $class_id, "class", "class_id", "class_semester");
    $class_group = getField($conn, $class_id, "class", "class_id", "class_group");
    $batch_id = getField($conn, $class_id, "class", "class_id", "batch_id");
    //echo "Class $class_id Batch $batch_id";
    $sqlAll = "select * from student where program_id='$myProg' and batch_id='$batch_id' and student_status='0'";

    if (isset($_POST['rpp'])) $rpp = $_POST['rpp'];
    else $rpp = 50;

    if (isset($_POST['startRecord'])) $startRecord = $_POST['startRecord'];
    else $startRecord = 0;

    paginationBar($conn, $sqlAll, $rpp, "sbp_rpp", "sbp");

    $sql = "select * from student where program_id='$myProg' and batch_id='$batch_id' and student_status='0' limit $startRecord, $rpp";

    $result = $conn->query($sql);
    echo '<span id="currentRecord">' . $startRecord . '</span>';
    echo '<table class="table list-table-xs mb-0">';
    echo '<tr><th>#</th><th>';
    echo '<input type="checkbox" class="checkUnCheck">';
    echo '</th><th>Id</th><th>RollNo</th><th>Name</th><th>Group</th><th>RegDate</th><th>Status</th></tr>';
    while ($rows = $result->fetch_assoc()) {
      $id = $rows['student_id'];
      $rc_status = getField($conn, $id, $tn_rc, 'student_id', 'rc_status');
      $regDate = getField($conn, $id, $tn_rc, 'student_id', 'rc_date');
      $regClassGroup = getField($conn, $id, $tn_rc, 'student_id', 'rc_group');
      $regClass = getField($conn, $id, $tn_rc, 'student_id', 'class_id');
      $regClass = getField($conn, $regClass, $tn_class, 'class_id', 'class_name');
      $sno++;
      echo '<tr>';
      echo '<td>' . $sno . '</td>';
      echo '<td><input type="checkbox" class="sbp" value="' . $id . '"></td>';
      // if ($check_status == "") echo '<td><input type="checkbox" class="sbp" value="' . $id . '"></td>';
      // else echo '<td><input type="checkbox" checked class="sbp" value="' . $id . '"></td>';
      echo '<td>' . $id . '</td>';
      echo '<td>' . $rows['student_rollno'] . '</td>';
      echo '<td>' . $rows['student_name'] . '</td>';
      if ($rc_status == "") {
        echo '<td colspan="3" align="center">Not Registered</td>';
      } else {
        echo '<td>G-' . $regClassGroup . '</td>';
        echo '<td>' . date("d-m-Y", strtotime($regDate)) . '</td>';
        if ($rc_status == "0") echo '<td align="center"><i class="fa fa-check"></i>Registered</td>';
        else echo '<td align="center"><i class="fa fa-times"></i>Unregistered</td>';
      }

      echo '</tr>';
    }
    echo '</table>';
    echo '<div class="row mt-2">';
    echo '<div class="col-sm-1 pr-0 m-0">';
    echo '<select class="form-control form-control-sm" id="sel_cg" name="class_group">';
    for ($group = 1; $group <= $class_group; $group++) {
      echo '<option value="' . $group . '">' . $group . '</option>';
    }
    echo '</select>';
    echo '</div>';
    echo '<div class="col-sm-4 p-0">';
    echo '<button class="btn btn-success btn-sm m-0 register">Register</button>';
    echo '</div>';
    echo '</div>';
    //echo "sddsd";
  } elseif ($_POST['action'] == 'register') {
    $id = $_POST["checkboxes_value"];
    $classId = $_POST["classId"];
    $class_group = $_POST["class_group"];
    echo  " Class $classId $class_group";

    $sql = "select tl.tl_id from $tn_tlg tlg, $tn_tl tl where tlg.tlg_id=tl.tlg_id and tlg.class_id='$classId' and tlg.tlg_status='0' and tl.tl_status='0'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    $i = 0;
    while ($rowArray = $result->fetch_assoc()) {
      echo $tl[$i] = $rowArray["tl_id"];
      $i++;
    }

    for ($i = 0; $i < count($id); $i++) {
      echo $id[$i];
      echo '<br>';
      $sql = "select * from $tn_rc where student_id='$id[$i]' and rc_status='0'";
      if (!$conn->query($sql)->num_rows) {
        $sql = "insert into $tn_rc (student_id, class_id, rc_group, rc_date, submit_id, rc_status) values('$id[$i]','$classId', '$class_group', '$submit_date','$myId', '0')";
        $result = $conn->query($sql);
      }
    }
  } elseif ($_POST['action'] == 'updateRegistration') {
    $id = $_POST["checkboxes_value"];
    $value = $_POST["value"];
    $tag = $_POST["tag"];
    echo  " Class $tag $value";
    for ($i = 0; $i < count($id); $i++) {
      echo $id[$i] . '<br>';
      $sql = "update $tn_rc set $tag='$value' where student_id='$id[$i]'";
      $result = $conn->query($sql);
    }
  } elseif ($_POST['action'] == 'classList') {
    $class_id = $_POST['classId'];
    //echo "Class $class_id";
    $sqlAll = "select * from $tn_rc where class_id='$class_id' and rc_status='0'";

    if (isset($_POST['rpp'])) $rpp = $_POST['rpp'];
    else $rpp = 50;

    if (isset($_POST['startRecord'])) $startRecord = $_POST['startRecord'];
    else $startRecord = 0;

    paginationBar($conn, $sqlAll, $rpp, "cl_rpp", "cl");

    $sql = "select * from $tn_rc where class_id='$class_id' and rc_status='0' limit $startRecord, $rpp";

    $result = $conn->query($sql);
    echo '<table class="table list-table-xs mb-0">';
    echo '<tr><th>#</th><th>';
    echo '<input type="checkbox" class="checkUnCheck" data-tag="cl">';
    echo '</th><th>Id</th><th>RollNo</th><th>Name</th><th>Group</th><th>RegDate</th><th>Action</th></tr>';
    while ($rows = $result->fetch_assoc()) {
      $id = $rows['student_id'];
      $student_rollno = getField($conn, $id, "student", 'student_id', 'student_rollno');
      $student_name = getField($conn, $id, "student", 'student_id', 'student_name');
      $regDate = getField($conn, $id, $tn_rc, 'student_id', 'rc_date');
      $regClassGroup = getField($conn, $id, $tn_rc, 'student_id', 'rc_group');
      $sno++;
      echo '<tr>';
      echo '<td>' . $sno . '</td>';
      echo '<td><input type="checkbox" class="sbp" value="' . $id . '"></td>';
      // if ($check_status == "") echo '<td><input type="checkbox" class="sbp" value="' . $id . '"></td>';
      // else echo '<td><input type="checkbox" checked class="sbp" value="' . $id . '"></td>';
      echo '<td>' . $id . '</td>';
      echo '<td>' . $student_rollno . '</td>';
      echo '<td>' . $student_name . '</td>';
      echo '<td>' . $regClassGroup . '</td>';
      echo '<td>' . date("d-m-Y", strtotime($regDate)) . '</td>';
      echo '<td><button class="btn btn-secondary btn-square-sm studentSubjectButton" id="' . $id . '">Update</button></td>';
      echo '</tr>';
    }
    echo '</table>';
    echo '<span class="text-white" id="currentRecord">' . $startRecord . '</span>'; //white to hide
  } elseif ($_POST['action'] == 'clSub') {
    $class_id = $_POST['classId'];
    //echo "Class $class_id";
    $class_group = getField($conn, $class_id, "class", "class_id", "class_group");
    for ($group = 1; $group <= $class_group; $group++) {
      subjectList($conn, $tn_tlg, $tn_tl, $class_id, $group, "L");
      subjectList($conn, $tn_tlg, $tn_tl, $class_id, $group, "T");
      subjectList($conn, $tn_tlg, $tn_tl, $class_id, $group, "P");
    }
  } elseif ($_POST['action'] == 'subjectRegistration') {
    $id = $_POST["checkboxes_value"];
    $tl = $_POST["tl"];
    $status = $_POST["status"];

    for ($i = 0; $i < count($id); $i++) {
      echo $id[$i] . 'TL  - ' . $tl . ' Status ' . $status;
      echo '<br>';
      if($status=="false")$sql = "delete from $tn_rs where student_id='$id[$i]' and tl_id='$tl'";
      else $sql = "insert into $tn_rs (student_id, tl_id, update_id) values('$id[$i]','$tl','$myId')";
      echo "All Insert and Dlete";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
    }
  } elseif ($_POST['action'] == 'stdSub') {
    $student_id = $_POST['stdId'];
    $class_id = $_POST['classId'];
    //echo "Student - ".$student_id;
    $totalCredit = 0;
    $sql = "select student_name from student where student_id='$student_id'";
    $student_name = getFieldValue($conn, 'student_name', $sql);
    echo '<h5 class="text-center">' . $student_name . '[' . $student_id . ']</h5>';
    echo '<table class="table list-table-xs mb-0">';
    echo '<tr><th>#</th><th></th><th>Tlg</th><th>Tl</th><th>Sub</th><th>Code</th><th>Subject</th><th>Type</th><th>Cr</th><th>Class</th></tr>';

    $sql = "select tl.tl_id, sb.*, tlg.* from $tn_tlg tlg, $tn_tl tl, subject sb where tlg.tlg_id=tl.tlg_id and tlg.subject_id=sb.subject_id and tlg.class_id='$class_id' and tlg.tlg_status='0' and tl.tl_status='0' and sb.subject_status='0' group by tlg.tlg_id";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    $i = 0;
    while ($rowArray = $result->fetch_assoc()) {
      $rs_tl = $rowArray["tl_id"];
      $subject_id = $rowArray["subject_id"];
      $subject_credit = $rowArray["subject_credit"];

      //echo $rs_tl;
      $sql = "select * from $tn_rs where student_id='$student_id' and tl_id='$rs_tl'";
      $check_status = getFieldValue($conn, 'student_id', $sql);
      echo '<tr>';
      echo '<td>' . ($i + 1) . '</td>';
      if ($check_status == "") echo '<td><input type="checkbox" class="stdsubCheckbox" data-std="' . $student_id . '" value="' . $rs_tl . '"></td>';
      else {
        echo '<td><input type="checkbox" class="stdsubCheckbox" data-std="' . $student_id . '" value="' . $rs_tl . '" checked></td>';
        $totalCredit += $subject_credit;
      }
      echo '<td>' . $rowArray["tlg_id"] . '</td>';
      echo '<td>' . $rs_tl . '</td>';
      echo '<td>' . $subject_id . '</td>';
      echo '<td>' . $rowArray["subject_code"] . '</td>';
      echo '<td>' . $rowArray["subject_name"] . '</td>';
      echo '<td>' . $rowArray["tlg_type"] . '</td>';
      echo '<td>' . $subject_credit . '</td>';
      if ($check_status == "") echo '<td>--</td>';
      else {

        echo '<td><button class="btn btn-secondary btn-square-sm updateClassButton" value="' . $check_status . '">Update</button></td>';
      }
      echo '</tr>';
      $i++;
    }
    echo '</table>';
    echo '<h5>Credits Registered : ' . $totalCredit . '</h5>';
  } elseif ($_POST['action'] == 'updateSub') {
    $student_id = $_POST['stdId'];
    $tl_id = $_POST['subId'];
    $status = $_POST['status'];
    if ($status == "false") {
      echo "False Detected ";
      $sql = "update $tn_rs set rs_status='1' where student_id='$student_id' and tl_id='$tl_id'";
    } else {
      echo "True Detected ";
      $sql = "update $tn_rs set rs_status='0' where student_id='$student_id' and tl_id='$tl_id'";
    }
    $conn->query($sql);
    if ($conn->affected_rows == 0) {
      $sql = "insert into $tn_rs (student_id, tl_id, update_id, rs_status) values('$student_id','$tl_id','$myId', '0')";
      $conn->query($sql);
    }
  }
}
function subjectList($conn, $tn_tlg, $tn_tl, $class_id, $group, $tlg_type)
{
  $class_name = getField($conn, $class_id, "class", "class_id", "class_name");
  $sql = "select tlg.*, tl.* from $tn_tlg tlg, $tn_tl tl where tlg.class_id='$class_id' and tl.tlg_id=tlg.tlg_id and tl.tl_group='$group' and tlg.tlg_type='$tlg_type' and tlg.tlg_status='0' and tl.tl_status='0' order by tlg.tlg_type, tlg.subject_id";
  $result = $conn->query($sql);
  if (!$result) echo $conn->error;
  if ($result->num_rows > 0) {
    echo '<h5>Subject List for Class : ' . $class_name . '[' . $tlg_type . 'G-' . $group . ']</h5>';
    echo '<table class="table list-table-xs">';
    echo '<tr><th></th><th>#</th><th>Id</th><th>Code</th><th>Subject</th></tr>';
    $count = 1;
    while ($rowsSubject = $result->fetch_assoc()) {
      $tl_id = $rowsSubject["tl_id"];
      $subject_id = $rowsSubject["subject_id"];
      $subject_code = getField($conn, $subject_id, "subject", "subject_id", "subject_code");
      $subject_name = getField($conn, $subject_id, "subject", "subject_id", "subject_name");
      echo '<tr>';
      echo '<td><input type="checkbox" class="subjectRegistration" value="' . $tl_id . '"></td>';
      echo '<td>' . $count++ . '</td>';
      echo '<td>' . $tl_id . '-' . $subject_id . '</td>';
      echo '<td>' . $subject_code . '</td>';
      echo '<td>' . $subject_name . '</td>';
      echo '</tr>';
    }
    echo '</table>';
  }
}
