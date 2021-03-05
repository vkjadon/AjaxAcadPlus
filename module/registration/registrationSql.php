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

    $session_id = getField($conn, $class_id, "class", "class_id", "session_id");
    $batch_id = getField($conn, $class_id, "class", "class_id", "batch_id");
    $class_semester = getField($conn, $class_id, "class", "class_id", "class_semester");
    $program_id = getField($conn, $session_id, "session", "session_id", "program_id");
    $sqlAll = "select * from student where program_id='$program_id' and batch_id='$batch_id' and student_status='0'";

    if (isset($_POST['rpp'])) $rpp = $_POST['rpp'];
    else $rpp = 50;

    if (isset($_POST['startRecord'])) $startRecord = $_POST['startRecord'];
    else $startRecord = 0;

    paginationBar($conn, $sqlAll, $rpp);

    $sql = "select * from student where program_id='$program_id' and batch_id='$batch_id' and student_status='0' limit $startRecord, $rpp";

    $result = $conn->query($sql);
    echo '<button class="btn btn-secondary btn-square-sm checkAll">Check All</button>';
    echo '<button class="btn btn-danger btn-square-sm uncheckAll">UnCheck All</button>';
    echo '<button class="btn btn-secondary btn-square-sm classSubject">Class Subjects</button>';
    echo '<span id="currentRecord">' . $startRecord . '</span>';
    echo '<table class="table list-table-xs mb-0">';
    echo '<tr><th>#</th><th></th><th>Id</th><th>RollNo</th><th>Name</th><th>Class</th><th>RegDate</th><th>Action</th></tr>';
    while ($rows = $result->fetch_assoc()) {
      $id = $rows['student_id'];
      $check_status = getField($conn, $id, $tn_rc, 'student_id', 'student_id');
      $regDate = getField($conn, $id, $tn_rc, 'student_id', 'rc_date');
      $regClass = getField($conn, $id, $tn_rc, 'student_id', 'class_id');
      $regClass = getField($conn, $regClass, $tn_class, 'class_id', 'class_name');
      $sno++;
      echo '<tr>';
      echo '<td>' . $sno . '</td>';
      if ($check_status == "") echo '<td><input type="checkbox" class="sbp" value="' . $id . '"></td>';
      else echo '<td>--</td>';
      echo '<td>' . $id . '</td>';
      echo '<td>' . $rows['student_rollno'] . '</td>';
      echo '<td>' . $rows['student_name'] . '</td>';
      if ($regClass == "") {
        echo '<td colspan="3" align="center">Not Registered</td>';
      } else {
        echo '<td>' . $regClass . '</td>';
        echo '<td>' . date("d-m-Y", strtotime($regDate)) . '</td>';
        echo '<td><button class="btn btn-secondary btn-square-sm studentSubjectButton" id="'.$id.'">Update Subject</button></td>';
      }
      echo '</tr>';
    }
    echo '</table>';
    echo '<button class="btn btn-success btn-square-sm mt-0 register">Register</button>';
    //echo "sddsd";
  } elseif ($_POST['action'] == 'register') {
    $id = $_POST["checkboxes_value"];
    $classId = $_POST["classId"];
    echo  count($id);
    echo $classId;
    $json = get_classSubject($conn, $classId);
    $array = json_decode($json, true);

    for ($i = 0; $i < count($id); $i++) {
      echo $id[$i];
      echo '<br>';
      $sql = "select * from $tn_rc where student_id='$id[$i]' and rc_status='0'";
      if (!$conn->query($sql)->num_rows) {
        $sql = "insert into $tn_rc (student_id, class_id, rc_date, submit_id) values('$id[$i]','$classId','$submit_date','$myId')";
        $result = $conn->query($sql);
        $rc_id = $conn->insert_id;
        echo "RC Id " . $rc_id;
        for ($j = 0; $j < count($array["data"]); $j++) {
          $subject_id = $array["data"][$j]["id"];
          $sql = "select * from $tn_rs where student_id='$id[$i]' and subject_id='$subject_id' and class_id='$classId' and rs_status='0'";
          if (!$conn->query($sql)->num_rows) {
            $sql = "insert into $tn_rs (student_id, subject_id, class_id, tl_group, submit_id) values('$id[$i]','$subject_id', '$classId', '1','$myId')";
            $result = $conn->query($sql);
          }
        }
      }
    }
  } elseif ($_POST['action'] == 'clSub') {
    $class_id = $_POST['classId'];
    //echo $class_id;
    $json = get_classSubject($conn, $class_id);
    //echo $json;
    $array = json_decode($json, true);
    //echo count($array);
    //echo count($array["data"]);
    $sql="select class_name from class where class_id='$class_id'";
    $class_name=getFieldValue($conn, 'class_name', $sql);

    echo '<h5>Subject List for Class : '.$class_name.'['.$class_id.']</h5>';
    echo '<table class="table list-table-xs">';
    echo '<tr><th>#</th><th>Id</th><th>Subject</th><th>Code</th></tr>';
    for ($i = 0; $i < count($array["data"]); $i++) {
      echo '<tr>';
      echo '<td>' . ($i + 1) . '</td>';
      echo '<td>' . $array["data"][$i]["id"] . '</td>';
      echo '<td>' . $array["data"][$i]["name"] . '</td>';
      echo '<td>' . $array["data"][$i]["code"] . '</td>';
      echo '</tr>';
    }
  } elseif ($_POST['action'] == 'stdSub') {
    $student_id = $_POST['stdId'];
    $class_id = $_POST['classId'];
    //echo "Student - ".$student_id;
    $json = get_classSubject($conn, $class_id);
    //echo $json;
    $array = json_decode($json, true);
    //echo count($array);
    //echo count($array["data"]);
    $sql="select student_name from student where student_id='$student_id'";
    $student_name=getFieldValue($conn, 'student_name', $sql);
    $credit=0;
    echo '<h5 class="text-center">'.$student_name.'['.$student_id.']</h5>';
    echo '<table class="table list-table-xs mb-0">';
    echo '<tr><th>#</th><th></th><th>Id</th><th>Subject</th><th>Code</th><th>Cr</th><th>Class</th></tr>';
    for ($i = 0; $i < count($array["data"]); $i++) {
      $subject_id=$array["data"][$i]["id"];
      $sql="select * from $tn_rs where student_id='$student_id' and subject_id='$subject_id' and rs_status='0'";
      $check_status = getFieldValue($conn, 'rs_id', $sql);
      echo '<tr>';
      echo '<td>' . ($i + 1) . '</td>';
      if($check_status=="")echo '<td><input type="checkbox" class="stdsubCheckbox" data-std="'.$student_id.'" value="' . $subject_id . '"></td>';
      else {
        echo '<td><input type="checkbox" class="stdsubCheckbox" data-std="'.$student_id.'" value="' . $subject_id . '" checked></td>';
        $credit+=$array["data"][$i]["credit"];
      }
      echo '<td>' . $subject_id . '</td>';
      echo '<td>' . $array["data"][$i]["name"] . '</td>';
      echo '<td>' . $array["data"][$i]["code"] . '</td>';
      echo '<td>' . $array["data"][$i]["credit"] . '</td>';
      if($check_status=="")echo '<td>--</td>';
      else {
        $sql="select * from $tn_rs where student_id='$student_id' and subject_id='$subject_id' and rs_status='0'";
        $rs_class=getFieldValue($conn, 'class_id', $sql);
        $class=getField($conn, $rs_class, "class", "class_id", "class_name");
        $group=getField($conn, $check_status, $tn_rs, "rs_id", "tl_group");
        echo '<td><button class="btn btn-secondary btn-square-sm updateClassButton" value="'.$check_status.'" data-class="'.$class.'" data-group="'.$group.'" data-subject="'.$array["data"][$i]["name"].'">'.$class.'</button></td>';
      }
      echo '</tr>';
    }
    echo '</table>';
    echo '<h5>Credits Registered : '.$credit.'</h5>';    
  } elseif ($_POST['action'] == 'updateSub') {
    $student_id = $_POST['stdId'];
    $subject_id = $_POST['subId'];
    $status=$_POST['status'];
    if($status=="false"){
      echo "False Detected ";
      $sql="update $tn_rs set rs_status='1' where student_id='$student_id' and subject_id='$subject_id'";
    }
    else {
      echo "True Detected ";
      $sql="update $tn_rs set rs_status='0' where student_id='$student_id' and subject_id='$subject_id'";
    }
    $conn->query($sql);
  }
}
