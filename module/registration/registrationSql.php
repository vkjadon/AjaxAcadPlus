<?php
require('../requireSubModule.php');

//echo $_POST['action'];
$sno = 0;
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'sbpList') {
    $class_id = $_POST['classId'];
    $class_semester = getField($conn, $class_id, "class", "class_id", "class_semester");
    $class_group = getField($conn, $class_id, "class", "class_id", "class_group");
    $batch_id = getField($conn, $class_id, "class", "class_id", "batch_id");
    // echo "Class $class_id Batch $batch_id";
    $sqlAll = "select student_id from student where program_id='$myProg' and ay_id='$batch_id' and student_status='0'";

    if (isset($_POST['rpp'])) $rpp = $_POST['rpp'];
    else $rpp = 50;

    if (isset($_POST['startRecord'])) $startRecord = $_POST['startRecord'];
    else $startRecord = 0;

    paginationBar($conn, $sqlAll, $rpp, "sbp_rpp", "sbp");

    $sql = "select student_id, student_name, student_rollno from student where program_id='$myProg' and ay_id='$batch_id' and student_status='0' limit $startRecord, $rpp";

    $result = $conn->query($sql);
    echo '<span id="currentRecord">' . $startRecord . '</span>';
    echo '<table class="table list-table-xs mb-0">';
    echo '<tr><th>#</th><th>';
    echo '<input type="checkbox" class="checkUnCheck">';
    echo '</th><th>Id</th><th>RollNo</th><th>Name</th><th>Group</th><th>RegDate</th><th>Updated On</th><th>Updated By</th><th>Status</th></tr>';
    while ($rows = $result->fetch_assoc()) {
      $id = $rows['student_id'];
      $rc_status = getField($conn, $id, $tn_rc, 'student_id', 'rc_status');
      $regDate = getField($conn, $id, $tn_rc, 'student_id', 'rc_date');
      $updateDate = getField($conn, $id, $tn_rc, 'student_id', 'update_ts');
      $updateId = getField($conn, $id, $tn_rc, 'student_id', 'update_id');
      if($updateId>0)$updateId=$updateId+80000;
      $regClassGroup = getField($conn, $id, $tn_rc, 'student_id', 'rc_group');
      $regClass = getField($conn, $id, $tn_rc, 'student_id', 'class_id');
      $regClass = getField($conn, $regClass, "class", 'class_id', 'class_name');
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
        echo '<td>' . date("d-m-Y h-i a", strtotime($updateDate)) . '</td>';
        echo '<td>AG' . $updateId . '</td>';
        if ($rc_status == "0") echo '<td align="center"><i class="fa fa-check"></i>Registered</td>';
        else echo '<td align="center"><i class="fa fa-times"></i>Unregistered</td>';
      }
      echo '</tr>';
    }
    mysqli_free_result($result);
    echo '</table>';
    echo '<div class="row mt-2">';
    echo '<div class="col-sm-2 pr-0 m-0">';
    echo '<label>Class Group</label>';
    echo '<select class="form-control form-control-sm" id="sel_cg" name="class_group">';
    for ($group = 1; $group <= $class_group; $group++) {
      echo '<option value="' . $group . '">' . $group . '</option>';
    }
    echo '</select>';
    echo '</div>';
    echo '<div class="col-sm-10"><br>';
    echo '<button class="btn btn-sm m-0 register">Register</button>';
    echo '</div>';
    echo '</div>';
    //echo "sddsd";
  } elseif ($_POST['action'] == 'register') {
    $id = $_POST["checkboxes_value"];
    $classId = $_POST["classId"];
    $class_group = $_POST["class_group"];
    // echo  " Class $classId $class_group";

    // $sql = "select tl.tl_id from $tn_tlg tlg, $tn_tl tl where tlg.tlg_id=tl.tlg_id and tlg.class_id='$classId' and tlg.tlg_status='0' and tl.tl_status='0'";
    // $result = $conn->query($sql);
    // if (!$result) echo $conn->error;
    // $i = 0;
    // while ($rowArray = $result->fetch_assoc()) {
    //   $tl[$i] = $rowArray["tl_id"];
    //   // echo '<br>TL Id '.$tl[$i];
    //   $i++;
    // }

    for ($i = 0; $i < count($id); $i++) {
      // echo '<br>Std Id '.$id[$i];
      $sql = "select * from $tn_rc where student_id='$id[$i]'";
      if (!$conn->query($sql)->num_rows) $sql = "insert into $tn_rc (student_id, class_id, rc_group, rc_date, update_id, rc_status) values('$id[$i]','$classId', '$class_group', '$submit_date','$myId', '0')";
      else $sql = "update $tn_rc set rc_status='0', update_ts='$submit_ts', update_id='$myId' where student_id='$id[$i]'";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else "Registered";
    }
  } elseif ($_POST['action'] == 'updateRegistration') {
    $id = $_POST["checkboxes_value"];
    $value = $_POST["value"];
    $tag = $_POST["tag"];
    // echo  " Class $tag $value";
    for ($i = 0; $i < count($id); $i++) {
      // echo $id[$i] . '<br>';
      $sql = "update $tn_rc set $tag='$value', update_ts='$submit_ts', update_id='$myId' where student_id='$id[$i]'";
      $conn->query($sql);
    }
    echo "Updated !!";
  } elseif ($_POST['action'] == 'classList') {
    $class_id = $_POST['classId'];
    //echo "Class $class_id";
    $sqlAll = "select rc_id from $tn_rc where class_id='$class_id' and rc_status='0'";

    if (isset($_POST['rpp'])) $rpp = $_POST['rpp'];
    else $rpp = 50;

    if (isset($_POST['startRecord'])) $startRecord = $_POST['startRecord'];
    else $startRecord = 0;

    paginationBar($conn, $sqlAll, $rpp, "cl_rpp", "cl");

    $sql = "select student_id from $tn_rc where class_id='$class_id' and rc_status='0' limit $startRecord, $rpp";

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
      echo '<td><input type="checkbox" class="cl" value="' . $id . '"></td>';
      // if ($check_status == "") echo '<td><input type="checkbox" class="sbp" value="' . $id . '"></td>';
      // else echo '<td><input type="checkbox" checked class="sbp" value="' . $id . '"></td>';
      echo '<td>' . $id . '</td>';
      echo '<td>' . $student_rollno . '</td>';
      echo '<td>' . $student_name . '</td>';
      echo '<td>' . $regClassGroup . '</td>';
      echo '<td>' . date("d-m-Y", strtotime($regDate)) . '</td>';
      echo '<td><button class="btn btn-square-sm studentSubjectButton" id="' . $id . '">Update</button></td>';
      echo '</tr>';
    }
    echo '</table>';
    echo '<span class="text-white" id="currentRecord">' . $startRecord . '</span>'; //white to hide
  } elseif ($_POST['action'] == 'clSub') {
    $class_id = $_POST['classId'];
    //echo "Class $class_id";
    $class_name = getField($conn, $class_id, "class", "class_id", "class_name");
    $class_group = getField($conn, $class_id, "class", "class_id", "class_group");
    echo '<p class="largeText">Group wise subjects for : ' . $class_name . '</p>';
    for ($group = 1; $group <= $class_group; $group++) {
      subjectList($conn, $tn_tlg, $tn_tl, $class_id, $group, "L");
      subjectList($conn, $tn_tlg, $tn_tl, $class_id, $group, "T");
      subjectList($conn, $tn_tlg, $tn_tl, $class_id, $group, "P");
    }
    echo '<p class="largeText">Steps for Bulk Student Subject Registration</p>';
    echo '<p class="footerNote"><span class="text-primary">Step-1 : </span> Select Students using check boxes from left</p>';
    echo '<p class="footerNote"><span class="text-primary">Step-2 : </span> Select Subjects using check boxes above.</p>';
    echo '<p class="footerNote text-success">The checked students will be registered automatically on the subject checked.</p>';
    echo '<p class="footerNote text-danger">You can uncheck the subject to unregister the checked students.</p>';
  } elseif ($_POST['action'] == 'subjectRegistration') {
    $id = $_POST["checkboxes_value"];
    $tl = $_POST["tl"];
    $status = $_POST["status"];

    for ($i = 0; $i < count($id); $i++) {
      // echo $id[$i] . 'TL  - ' . $tl . ' Status ' . $status;
      echo '<br>';
      if ($status == "false") $sql = "delete from $tn_rs where student_id='$id[$i]' and tl_id='$tl'";
      else $sql = "insert into $tn_rs (student_id, tl_id, rs_date, update_ts, update_id, rs_status) values('$id[$i]','$tl','$submit_date', '$submit_ts', '$myId', '0')";
      // echo "All Insert and Delete";
      if (!$conn->query($sql)) echo $conn->error;
    }
  } elseif ($_POST['action'] == 'stdSubReg') {
    $id = $_POST["student_id"];
    $tl = $_POST["tl_id"];
    $value = $_POST["value"];
    if ($value == "0") $sql = "delete from $tn_rs where student_id='$id' and tl_id='$tl'";
    else $sql = "insert into $tn_rs (student_id, tl_id, rs_date, update_ts, update_id, rs_status) values('$id','$tl','$submit_date', '$submit_ts', '$myId', '0')";
    if (!$conn->query($sql)) echo $conn->error;
    echo "Insert and Delete";
  } elseif ($_POST['action'] == 'stdSub') {
    $student_id = $_POST['stdId'];
    //echo "Student - ".$student_id;
    $totalCredit = 0;
    $sql = "select student_name from student where student_id='$student_id'";
    $student_name = getFieldValue($conn, 'student_name', $sql);
    echo '<h5 class="text-center">' . $student_name . '[' . $student_id . ']</h5>';
    echo '<table class="table list-table-xs mb-0">';
    echo '<tr><th>#</th><th></th><th>Tlg-Tl-Sub</th><th>Code</th><th>Subject</th><th>Type</th><th>Staff</th></tr>';

    $sql = "select rs.*, tlg.*, tl.staff_id, tl.tl_group from $tn_rs rs, $tn_tl tl, $tn_tlg tlg where rs.student_id='$student_id' and rs.tl_id=tl.tl_id and tl.tlg_id=tlg.tlg_id";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    $i = 0;
    while ($rowArray = $result->fetch_assoc()) {
      $rs_tl = $rowArray["tl_id"];
      $subject_id = $rowArray["subject_id"];
      $staff_id = $rowArray["staff_id"];
      $tl_group = $rowArray["tl_group"];


      echo '<tr>';
      echo '<td>' . ($i + 1) . '</td>';

      echo '<td><input type="checkbox" class="stdsubCheckbox" data-std="' . $student_id . '" value="' . $rs_tl . '" checked></td>';

      echo '<td>' . $rowArray["tlg_id"] . '-' . $rs_tl . '-' . $subject_id . '</td>';
      echo '<td>' . getField($conn, $subject_id, "subject", "subject_id", "subject_code") . '</td>';
      echo '<td>' . getField($conn, $subject_id, "subject", "subject_id", "subject_name") . '</td>';
      echo '<td>' . $rowArray["tlg_type"] . 'G-' . $tl_group . '</td>';
      echo '<td>' . getField($conn, $staff_id, "staff", "staff_id", "staff_name") . '</td>';
      echo '</tr>';
      $i++;
    }
    echo '</table>';
  } elseif ($_POST['action'] == 'updateSub') {
    $student_id = $_POST['stdId'];
    $tl_id = $_POST['subId'];
    $status = $_POST['status'];
    $sql = "delete from $tn_rs where student_id='$student_id' and tl_id='$tl_id'";
    $conn->query($sql);
  } elseif ($_POST['action'] == 'regMapList') {
    $class_id = $_POST['class_id'];

    $json_array = array();

    $sql = "select tlg.*, tl.* from $tn_tlg tlg, $tn_tl tl where tlg.class_id='$class_id' and tl.tlg_id=tlg.tlg_id and tlg.tlg_status='0' and tl.tl_status='0' order by tlg.tlg_type, tlg.subject_id, tl.tl_group";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    if ($result->num_rows > 0) {
      $subjectArray = array();
      $subArray = array();
      $i = 0;
      while ($rowsSubject = $result->fetch_assoc()) {
        $subject_id = $rowsSubject["subject_id"];
        $subArray["subject_id"] = $subject_id;
        $subArray["subject_code"] = getField($conn, $subject_id, "subject", "subject_id", "subject_code");
        $subArray["subject_name"] = getField($conn, $subject_id, "subject", "subject_id", "subject_name");
        $subArray["tlg_type"] = $rowsSubject["tlg_type"];
        $subArray["tl_group"] = $rowsSubject["tl_group"];
        $subject_credit = getField($conn, $subject_id, "subject", "subject_id", "subject_credit");
        $subArray["subject_credit"] = $subject_credit;
        $tl_id[$i] = $rowsSubject["tl_id"];
        $subjectArray[] = $subArray;
        $i++;
      }
      $json_array["subject"] = $subjectArray;
    }

    $sql = "select st.student_name, st.student_id, st.student_rollno, st.user_id from student st, $tn_rc rc where rc.class_id='$class_id' and rc.student_id=st.student_id and rc.rc_status='0'";

    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $student_array = array();
      $subArray = array();
      while ($rowsStudent = $result->fetch_assoc()) {
        $student_id = $rowsStudent["student_id"];
        $subArray["student_id"] = $student_id;
        $subArray["user_id"] = $rowsStudent["user_id"];
        $subArray["student_name"] = $rowsStudent["student_name"];
        $subArray["student_rollno"] = $rowsStudent["student_rollno"];

        $regStatus = array();
        for ($i = 0; $i < count($tl_id); $i++) {
          $sql_rs = "select * from $tn_rs where student_id='$student_id' and tl_id='$tl_id[$i]' and rs_status='0'";
          if ($conn->query($sql_rs)->num_rows) $regArray["registered"] = '1';
          else $regArray["registered"] = '0';
          $regArray["tl_id"] = $tl_id[$i];
          $regStatus[] = $regArray;
        }
        $subArray["regMap"] = $regStatus;

        $student_array[] = $subArray;
      }
      $json_array["student"] = $student_array;
    }
    echo json_encode($json_array);
    mysqli_free_result($result);
  }
}
function subjectList($conn, $tn_tlg, $tn_tl, $class_id, $group, $tlg_type)
{
  $class_name = getField($conn, $class_id, "class", "class_id", "class_name");
  $sql = "select tlg.*, tl.* from $tn_tlg tlg, $tn_tl tl where tlg.class_id='$class_id' and tl.tlg_id=tlg.tlg_id and tl.tl_group='$group' and tlg.tlg_type='$tlg_type' and tlg.tlg_status='0' and tl.tl_status='0' order by tlg.tlg_type, tlg.subject_id";
  $result = $conn->query($sql);
  if (!$result) echo $conn->error;
  if ($result->num_rows > 0) {
    echo '<label>' . $class_name . '[' . $tlg_type . 'G-' . $group . ']</label>';
    echo '<table class="table list-table-xs">';
    echo '<tr>';
    $count = 1;
    while ($rowsSubject = $result->fetch_assoc()) {
      $tl_id = $rowsSubject["tl_id"];
      $subject_id = $rowsSubject["subject_id"];
      $subject_code = getField($conn, $subject_id, "subject", "subject_id", "subject_code");
      echo '<td><input type="checkbox" class="subjectRegistration" value="' . $tl_id . '"> ';
      // echo $count++;
      // echo ' '.$tl_id . '-' . $subject_id;
      echo ' ' . $subject_code;
    }
    echo '</tr>';
    echo '</table>';
    mysqli_free_result($result);
  }
}
