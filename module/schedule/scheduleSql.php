<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
//echo $_POST['action'];
//global $tn_tt;
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'clList') {
    $programId=$_POST['programId'];
    $fields = array("class_name", "class_section", "class_semester", "class_shift");
    $header = array("Id", "Name", "Sec.", "Sem", "Shift");
    $sql = "select cl.* from class cl where cl.session_id='$mySes' and cl.program_id='$programId' order by cl.class_semester";
    $statusDecode = array("status" => "class_status", "0" => "Active", "1" => "Removed");
    $dataType = array("0", "0", "0", "0", "0", "0");
    $button = array("1", "1", "0", "1");
    getList($conn, "class_id", $fields, $dataType, $header, $sql, $statusDecode, $button);
    echo "$programId - $mySes";
  } else if ($_POST['action'] == 'addClass') {
    $fields = ['session_id', 'program_id', 'class_name', 'class_section', 'batch_id', 'class_semester', 'class_shift', 'submit_id'];
    $values = [$mySes, $_POST['modalId'], data_check($_POST['class_name']), data_check($_POST['class_section']), $_POST['sel_batch'], data_check($_POST['class_semester']), $_POST['class_shift'], $myId];
    $status = 'class_status';
    $dup = "select * from class where class_name='" . data_check($_POST["class_name"]) . "' and class_section='" . data_check($_POST["class_section"]) . "' and session_id='$mySes' and $status='0'";
    $dup_alert = "Duplicate Class Name for the Session Exists.";
    addData($conn, 'class', 'class_id', $fields, $values, $status, $dup, $dup_alert);
  } elseif ($_POST['action'] == 'fetchClass') {
    $id = $_POST['classId'];
    $sql = "SELECT * FROM class where class_id='$id'";
    $result = $conn->query($sql);
    $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST['action'] == "updateClass") {
    //echo "Update Class " . $_POST['modalId'];
    $fields = ['class_id', 'class_name', 'batch_id', 'class_shift', 'class_semester', 'class_section'];
    $values = [$_POST['modalId'], data_check($_POST['class_name']), $_POST['sel_batch'], $_POST['class_shift'], data_check($_POST['class_semester']), data_check($_POST['class_section'])];
    $status = 'class_status';
    $dup_alert = " Class Name, Section Alreday Exists for this Session !! ";
    updateUniqueData($conn, 'class', $fields, $values, $dup_alert);
  } elseif ($_POST['action'] == 'clSub') {
    $classId = $_POST['classId'];

    $session_id = getField($conn, $classId, "class", "class_id", "session_id");
    $batch_id = getField($conn, $classId, "class", "class_id", "batch_id");
    $class_semester = getField($conn, $classId, "class", "class_id", "class_semester");
    $program_id = getField($conn, $classId, "class", "class_id", "program_id");

    //echo "Cl $classId -B $batch_id -Sem $class_semester -P $program_id $tn_tlg";

    $sql = "select * from subject where program_id='$program_id' and batch_id='$batch_id' and subject_semester='$class_semester'";
    $result = $conn->query($sql);
    $i=1;
    echo '<button class="btn btn-secondary btn-square-sm checkAll">Check All</button>';
    echo '<button class="btn btn-danger btn-square-sm uncheckAll">UnCheck All</button>';
    echo '<table class="table list-table-xs">';
    echo '<tr><th></th><th>#</th><th>Code</th><th>Name</th><th>L-T-P</th><th>LG</th><th>TG</th><th>PG</th></tr>';
    while ($rows = $result->fetch_assoc()) {

      $subject_id = $rows['subject_id'];
      $L = $rows['subject_lecture'];
      $T = $rows['subject_tutorial'];
      $P = $rows['subject_practical'];

      echo '<tr>';
      echo '<td><input type="checkbox" class="scb" id="sub' . $rows['subject_id'] . '"></td>';
      echo '<td>' . $i++. '</td>';
      echo '<td>' . $rows['subject_code'] . '</td>';
      echo '<td>' . $rows['subject_name'] . '</td>';
      echo '<td>' . $L . '-' . $T . '-' . $P . '</td>';

      echo '<td>';
      if ($L > 0) tlg($conn, $tn_tlg, $subject_id, $classId, "L");
      echo '</td>';

      echo '<td>';
      if ($T > 0) tlg($conn, $tn_tlg, $subject_id, $classId, "T");
      echo '</td>';

      echo '<td>';
      if ($P > 0) tlg($conn, $tn_tlg, $subject_id, $classId, "P");
      echo '</td>';

      echo '</tr>';
    }
    echo '</table>';
  } elseif ($_POST['action'] == 'increment') {
    $value = $_POST['value'] + 1;
    $tlg_id = $_POST['tlg_id'];
    echo "Current Value " . $value;
    echo "Current Id " . $tlg_id;
    updateField($conn, $tn_tlg, array("tlg_id", "tlg_group"), array($tlg_id, $value), "");
  } elseif ($_POST['action'] == 'decrement') {
    $value = $_POST['value'] - 1;
    $tlg_id = $_POST['tlg_id'];
    if ($value > 0) updateField($conn, $tn_tlg, array("tlg_id", "tlg_group"), array($tlg_id, $value), "");
  } elseif ($_POST["action"] == "tl") {
    $classId = $_POST['classId'];
    $sno=1;
    echo "Classs $classId";
    $sql = "select tlg.*, sb.* from $tn_tlg tlg, subject sb where tlg.subject_id=sb.subject_id and tlg.class_id='$classId' and tlg.tlg_status='0' order by tlg.subject_id, tlg.tlg_type";
    $result = $conn->query($sql);
    if (!$result) die("Could not List the Teaching Load!");
    echo '<table  class="list-table-xs table-striped">';
    echo '<thead><th>#</th><th>TlgId</th><th>Subject</th><th>Type</th><th>Grp</th><th>Staff</th><th>Assign</th></thead>';
    while ($rows = $result->fetch_assoc()) {
      $groups = $rows['tlg_group'];
      for ($i = 1; $i <= $groups; $i++) {
        $tlgType = $rows['tlg_type'];
        echo '<tr>';
        echo '<td>' . $sno++. '</td>';
        echo '<td>' . $rows['tlg_id'] . '</td>';
        echo '<td>' . $rows['subject_name'] . '</td>';
        if ($tlgType == 'L') echo '<td>' . $tlgType . '-' . $rows['subject_lecture'] . '</td><td>LG-' . $i . '</td>';
        elseif ($tlgType == 'T') echo '<td>' . $tlgType . '-' . $rows['subject_tutorial'] . '</td><td>TG-' . $i . '</td>';
        else echo '<td>' . $tlgType . '-' . $rows['subject_practical'] . '</td><td>PG-' . $i . '</td>';
        $sql_staff = "SELECT * FROM $tn_tl WHERE tlg_id ='" . $rows['tlg_id'] . "' and tl_group='$i' and tl_status='0'";
        $result_staff = $conn->query($sql_staff);
        $counter = 0;
        echo '<td>';
        while ($rowsStaff = $result_staff->fetch_array()) {
          $counter++;
          $staff_id = $rowsStaff['staff_id'];
          if ($staff_id > 0) {
            echo getField($conn, $staff_id, 'staff', 'staff_id', 'staff_name');
            echo '<a href="#" class="openModalUpdateStaff" id="' . $rowsStaff['tl_id'] . '" data-group="' . $i . '"><i class="fa fa-edit" aria-hidden="true"></i></a>';
            if ($result_staff->num_rows > 1) echo '<a href="#" class="unassign" id="' . $rowsStaff['tl_id'] . '"><i class="fa fa-times" aria-hidden="true" style="color:red"></i></a>';
            echo ',&nbsp;';
          }
        }
        echo '</td>';
        echo '<td>';
        echo '<button class="btn-info btn-xs openModalAssignStaff" id="' . $rows['tlg_id'] . '" data-group="' . $i . '" data-subject="' . $rows['subject_name'] . '" data-type="' . $tlgType . '">+</button>';
        echo '</td>';

        echo '</tr>';
      }
    }
    echo '</table>';
  } elseif ($_POST["action"] == "assignStaff") {
    $tlg_id = $_POST["tlg_idM"];
    $tl_group = $_POST["tl_groupM"];
    $staff_id = $_POST["sel_staff"];
    $sql = "update $tn_tl set tl_status='A' where tlg_id='$tlg_id' and staff_id='$staff_id'";
    $result = $conn->query($sql);
    if (!$result) {
      echo $conn->error;
      die();
    }
    echo "Rows affetced -- " . $conn->affected_rows;
    if ($conn->affected_rows == 0) {
      echo "No row affected";
      $sql = "insert into $tn_tl (tlg_id, staff_id, tl_group, submit_id, tl_status) values('$tlg_id','$staff_id', '$tl_group', '$myId', 'A')";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else 'Added';
    }
  } elseif ($_POST['action'] == "tt") {
    $classId = $_POST['classId'];
    //echo "Class ".$classId;
    echo '<div class="row">';
    echo '<div class="col-1"><select class="form-control form-control-sm classPeriod" id="classPeriod" name="classPeriod">
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
    <option value="13">13</option>
    </select></div>';
    dayList("dummy1", "dummy2");
    echo '</div>';
  } elseif ($_POST['action'] == "day") {
    $classId = $_POST['classId'];
    $class_period = $_POST['classPeriod'];
    $dayStatus = $_POST['dayStatus'];
    $dayId = $_POST['dayId'];
    //echo "Class $classId dayId $dayId dayStatus $dayStatus Period $class_period";
    echo '<table class="table list-table-xs">';
    echo '<tr>';
    echo '<td rowspan="3"><h6>' . $dayId . '</h6></td>';
    for ($i = 1; $i <= $class_period; $i++) {
      echo '<td>';
      echo $i;
      echo '</td>';
    }
    echo '</tr>';
    echo '<tr>';
    for ($i = 1; $i <= $class_period; $i++) {
      echo '<td id="' . $dayId . $i . '">';
      slotLoad($conn, $tn_tt, $tn_tlg, $tn_tl, $classId, $dayId, $i, "0");
      echo '</td>';
    }
    echo '</tr>';
    echo '<tr align="center">';
    for ($i = 1; $i <= $class_period; $i++) {
      echo '<td>';
      echo '<button class="btn btn-square-sm btn-secondary uploadTTLink" data-type="L" data-day="' . $dayId . '" data-period="' . $i . '">L</button>';
      echo '<button class="btn btn-square-sm btn-danger uploadTTLink" data-type="T" data-day="' . $dayId . '" data-period="' . $i . '">T</button>';
      echo '<button class="btn btn-square-sm btn-info uploadTTLink" data-type="P" data-day="' . $dayId . '" data-period="' . $i . '">P</button>';
      echo '</td>';
    }
    echo '</tr>';
    echo '</table>';
  } elseif ($_POST["action"] == "tlData") {
    $classId = $_POST['classId'];
    $tlgType = $_POST['tlgType'];
    $dayId = $_POST['day'];
    $period = $_POST['period'];
    //echo "Classs $classId";
    $sql = "select tl.*, tlg.* from $tn_tl tl, $tn_tlg tlg where tlg.tlg_id=tl.tlg_id and tlg.class_id='$classId' and tlg.tlg_type='$tlgType' and tl.tl_status='0' order by tlg.tlg_type";
    $result = $conn->query($sql);
    if (!$result) die("Could not List the Teaching Load!");
    echo '<table  class="list-table-xs table-striped">';
    echo '<thead><th>tl-tlg</th><th>Subject</th><th>Staff</th><th>Grp</th><th>Assign</th></thead>';
    while ($rows = $result->fetch_assoc()) {
      $subject_name = getField($conn, $rows['subject_id'], "subject", "subject_id", "subject_name");
      $staff_name = getField($conn, $rows['staff_id'], "staff", "staff_id", "staff_name");
      echo '<tr>';
      echo '<td>' . $rows['tl_id'] . '-' . $rows['tlg_id'] . '</td>';
      echo '<td>' . $subject_name . '</td>';
      echo '<td>' . $staff_name . '</td>';
      echo '<td>' . $rows['tlg_type'] . '-' . $rows['tl_group'] . '</td>';
      echo '<td>';
      echo '<button class="btn-info btn-xs addSlot" id="' . $rows['tl_id'] . '" data-day="' . $dayId . '" data-period="' . $period . '">+</button>';
      echo '</td>';
      echo '</tr>';
    }
    echo '</table>';
  } elseif ($_POST["action"] == "addSlot") {
    $classId = $_POST['classId'];
    $tlId = $_POST['tlId'];
    $dayId = $_POST['day'];
    $period = $_POST['period'];

    $currentStaff = getField($conn, $tlId, $tn_tl, 'tl_id', 'staff_id');

    $sql = "insert into $tn_tt (tl_id, tt_day, tt_period, il_id, update_id) values('$tlId','$dayId','$period','1','$myId')";
    $result = $conn->query($sql);
    slotLoad($conn, $tn_tt, $tn_tlg, $tn_tl, $classId, $dayId, $period, "0");
  } elseif ($_POST["action"] == "clashForm") {
    $classId = $_POST['classId'];
    $dayId = $_POST['dayId'];
    $period = $_POST['period'];
    //echo "Class $classId dayId $dayId Period $period";
    slotLoad($conn, $tn_tt, $tn_tlg, $tn_tl, $classId, $dayId, $period, "1");
  } elseif ($_POST["action"] == "dropSlot") {
    $classId = $_POST['classId'];
    $tlId = $_POST['tlId'];
    $dayId = $_POST['day'];
    $period = $_POST['period'];
    //echo "Tlid $tlId dayId $dayId Period $period";
    $sql = "delete from $tn_tt where tl_id='$tlId' and tt_day='$dayId' and tt_period='$period'";
    $conn->query($sql);
    slotLoad($conn, $tn_tt, $tn_tlg, $tn_tl, $classId, $dayId, $period, "0");
  }
}

function slotLoad($conn, $tn_tt, $tn_tlg, $tn_tl, $classId, $dayId, $period, $dropButton)
{
  $sql = "select tt.* from $tn_tt tt, $tn_tl tl, $tn_tlg tlg where tt.tl_id=tl.tl_id and tl.tlg_id=tlg.tlg_id and tlg.class_id='$classId' and tt.tt_day='$dayId' and tt.tt_period='$period'";
  $result = $conn->query($sql);
  $clash = 0; $sno=0;
  if ($result && $result->num_rows > 0) {
    while ($rows = $result->fetch_assoc()) {
      $sno++;
      $tl_id = $rows['tl_id'];
      $staff_id = getField($conn, $tl_id, $tn_tl, 'tl_id', 'staff_id');
      $tlg_id = getField($conn, $tl_id, $tn_tl, 'tl_id', 'tlg_id');
      $tl_group = getField($conn, $tl_id, $tn_tl, 'tl_id', 'tl_group');
      $tlg_type=getField($conn, $tlg_id, $tn_tlg, 'tlg_id', 'tlg_type');
      $subject_id = getField($conn, $tlg_id, $tn_tlg, 'tlg_id', 'subject_id');
      $subject_code = getField($conn, $subject_id, 'subject', 'subject_id', 'subject_code');
      $staff_name = getField($conn, $staff_id, 'staff', 'staff_id', 'staff_name');
      //echo '<span>' . $subject_code . ' <b>[G-' . $tl_group . ']</b><br>' . $staff_name . '</span>';

      // Check Staff Clashes with the existing TimeTable
      $sqlClash = "select tt.* from $tn_tt tt, $tn_tl tl where tt.tl_id=tl.tl_id and tl.staff_id='$staff_id' and tt.tt_day='$dayId' and tt.tt_period='$period'";
      $resultClash = $conn->query($sqlClash);
      if ($resultClash->num_rows > 1) {
        $clash = '1';
        if ($dropButton == '1') {
          echo '<div class="col-12">';
          echo '<table class="table list-table-xs text-white">';
          echo '<tr><th>Load '.$sno.'</th><th>Staff</th><th>Class</th><th>Group</th><th>Code</th></tr>';
          while ($rowsClash = $resultClash->fetch_assoc()) {
            $tl = $rowsClash['tl_id'];
            
            $staff_id = getField($conn, $tl, $tn_tl, 'tl_id', 'staff_id');
            $tlg_id = getField($conn, $tl, $tn_tl, 'tl_id', 'tlg_id');
            $tl_group = getField($conn, $tl, $tn_tl, 'tl_id', 'tl_group');
            $type=getField($conn, $tlg_id, $tn_tlg, 'tlg_id', 'tlg_type');
            $cl=getField($conn, $tlg_id, $tn_tlg, 'tlg_id', 'class_id');
            $clN=getField($conn, $cl, "class", 'class_id', 'class_name');
            $clS=getField($conn, $cl, "class", 'class_id', 'class_section');
            $subject_id = getField($conn, $tlg_id, $tn_tlg, 'tlg_id', 'subject_id');
            $subject_code = getField($conn, $subject_id, 'subject', 'subject_id', 'subject_code');
            $staff_name = getField($conn, $staff_id, 'staff', 'staff_id', 'staff_name');
            
            echo '<tr>';
            echo '<td><button class="btn btn-light btn-square-sm dropClashButton"  data-tlDrop="' . $tl . '" data-dayDrop="' . $dayId . '" data-periodDrop="' . $period . '">Drop</button></td>';
            echo '<td>' . $staff_name . '</td>';
            echo '<td>' . $clN . '[' . $clS . ']</td>';
            echo '<td>['.$type.'G-' . $tl_group . ']</td>';
            echo '<td>' . $subject_code . '</td>';
            echo '</tr>';
          }
        }
      }

      // Check Class Clashes with the existing TimeTable
      $sqlClash = "select tt.* from $tn_tt tt, $tn_tl tl, $tn_tlg tlg where tt.tl_id=tl.tl_id and tl.tlg_id=tlg.tlg_id and tlg.class_id='$classId' and tlg.tlg_type='L' and tt.tt_day='$dayId' and tt.tt_period='$period'";
      $resultClash = $conn->query($sqlClash);
      if ($resultClash->num_rows > 1) {
        $clash = '1';
        while ($rowsClash = $resultClash->fetch_assoc()) {
          $tl_id = $rowsClash['tl_id'];
          $staff_id = getField($conn, $tl_id, $tn_tl, 'tl_id', 'staff_id');
          $tlg_id = getField($conn, $tl_id, $tn_tl, 'tl_id', 'tlg_id');
          $tl_group = getField($conn, $tl_id, $tn_tl, 'tl_id', 'tl_group');
          //$tlg_type=getField($conn, $tlg_id, $tn_tlg, 'tlg_id', 'tlg_type');
          $subject_id = getField($conn, $tlg_id, $tn_tlg, 'tlg_id', 'subject_id');
          $subject_code = getField($conn, $subject_id, 'subject', 'subject_id', 'subject_code');
          $staff_name = getField($conn, $staff_id, 'staff', 'staff_id', 'staff_name');
          echo '<span class="bg-warning">' . $subject_code . ' <b>[G-' . $tl_group . ']</b><br>' . $staff_name . '</span>';
        }
      }

      if ($clash == '1' && $dropButton == '0') echo '<span class="bg-warning">' . $subject_code . ' <b>['.$tlg_type.'G-' . $tl_group . ']</b><br>' . $staff_name . '</span>';
      elseif ($dropButton == '0') echo '<span>' . $subject_code . ' <b>['.$tlg_type.'G-' . $tl_group . ']</b><br>' . $staff_name . '</span>';
      if ($result->num_rows > 1) echo '<br>';
    }
    if ($clash == '1' && $dropButton == '0') echo '<br><button class="btn btn-info btn-square-sm resolveClashButton" data-tlId="' . $tl_id . '" data-day="' . $dayId . '" data-period="' . $period . '">Resolve</button>';
  } else {
    echo '<span>--</span>';
  }
}
function tlg($conn, $tn_tlg, $subject_id, $classId, $tlg_type)
{
  //echo "Table $tn_tlg";
  $dup = "select * from $tn_tlg where subject_id='$subject_id' and class_id='$classId' and tlg_type='$tlg_type'";
  addData($conn, $tn_tlg, "tlg_id", array("class_id", "subject_id", "tlg_type", "tlg_group"), array($classId, $subject_id, $tlg_type, "1"), "tlg_status", $dup, "NULL");

  $sql = "select * from $tn_tlg where subject_id='" . $subject_id . "' and class_id='$classId' and tlg_type='$tlg_type' and tlg_status='0' order by tlg_group desc";
  $id = getFieldValue($conn, "tlg_id", $sql);

  $value = getFieldValue($conn, "tlg_group", $sql);
  echo '<a href="#" class="decrement" id="' . $id . '" data-value="' . $value . '"><i class="fa fa-angle-double-left"></i></a>';
  echo '<span class="' . $id . '">' . $value . '</span>';
  echo '<a href="#" class="increment" id="' . $id . '" data-value="' . $value . '"><i class="fa fa-angle-double-right"></i></a>';
}
