<?php
require('../requireSubModule.php');

//echo $_POST['action'];
//global $tn_tt;
if (isset($_POST['action'])) {
  if ($_POST['action'] == "tt") {
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
      $sql = "select ttp_start from $tn_ttp where class_id='$classId' and ttp_day='$dayId' and ttp_period='$i'";
      $ttp_start = getFieldValue($conn, "ttp_start", $sql);
      echo ' <input type="time" class="periodTime" data-period="' . $i . '" data-day="' . $dayId . '" data-class="' . $classId . '" value="' . $ttp_start . '">';
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
      echo '<button class="btn btn-square-sm uploadTTLink" data-type="P" data-day="' . $dayId . '" data-period="' . $i . '">P</button>';
      echo '<button class="btn btn-square-sm btn-info uploadTTLink" data-type="T" data-day="' . $dayId . '" data-period="' . $i . '">T</button>';
      echo '<button class="btn btn-square-sm uploadTTLink" data-type="L" data-day="' . $dayId . '" data-period="' . $i . '">L</button>';
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
  } elseif ($_POST["action"] == "ttTime") {
    $sql = "update $tn_ttp set ttp_start='" . $_POST['ttTime'] . "' where class_id='" . $_POST['classId'] . "' and ttp_day='" . $_POST['day'] . "' and ttp_period='" . $_POST['period'] . "'";
    $result = $conn->query($sql);
    if (!$result) $conn->error;
    elseif ($conn->affected_rows == '0') $sql = "insert into $tn_ttp (class_id, ttp_day, ttp_period, ttp_start, update_id) values('" . $_POST['classId'] . "', '" . $_POST['day'] . "', '" . $_POST['period'] . "', '" . $_POST['ttTime'] . "', '$myId')";
    $result = $conn->query($sql);
    if (!$result) $conn->error;
  }
}
function slotLoad($conn, $tn_tt, $tn_tlg, $tn_tl, $classId, $dayId, $period, $dropButton)
{
  // $dropButton = 0; -> For Display in Time Table
  // $dropButton = 1; ->  For Display the Clash Data in Resolve Clash Modal Form
  // tt_clash=0; -> No Clash
  // tt_clash=1; -> Staff Clash tt_clash=2; -> Class Allowed
  // tt_clash=3; -> Class Clash with T/P of the smae Lecture class  tt_clash=4; -> Class Allowed
  // tt_clash=5; -> Class Group Clash  tt_clash=6; -> Class Allowed

  // Query to find the Allotted Schedule for the Class-Day-Period

  $sql = "select tt.* from $tn_tt tt, $tn_tl tl, $tn_tlg tlg where tt.tl_id=tl.tl_id and tl.tlg_id=tlg.tlg_id and tlg.class_id='$classId' and tt.tt_day='$dayId' and tt.tt_period='$period'";
  $result = $conn->query($sql);
  $clashStaff = 0;
  $clashClass = 0;
  if ($result && $result->num_rows > 0) {
    while ($rows = $result->fetch_assoc()) {
      $tl_id = $rows['tl_id'];
      $staff_id = getField($conn, $tl_id, $tn_tl, 'tl_id', 'staff_id');
      $tlg_id = getField($conn, $tl_id, $tn_tl, 'tl_id', 'tlg_id');
      $tl_group = getField($conn, $tl_id, $tn_tl, 'tl_id', 'tl_group');
      $tlg_type = getField($conn, $tlg_id, $tn_tlg, 'tlg_id', 'tlg_type');
      $subject_id = getField($conn, $tlg_id, $tn_tlg, 'tlg_id', 'subject_id');
      $subject_code = getField($conn, $subject_id, 'subject', 'subject_id', 'subject_code');
      $staff_name = getField($conn, $staff_id, 'staff', 'staff_id', 'staff_name');
      if ($dropButton == '0') echo '<span class="ttText">' . $subject_code . ' <b>[' . $tlg_type . 'G-' . $tl_group . ']</b> ' . $staff_name . '</span>';

      // Check Staff Clashes with the existing TimeTable
      $sqlClashStaff = "select tt.*, tl.* from $tn_tt tt, $tn_tl tl where tt.tl_id=tl.tl_id and tl.staff_id='$staff_id' and tt.tt_day='$dayId' and tt.tt_period='$period'";
      if ($conn->query($sqlClashStaff)->num_rows > 1) $clashStaff = 1;

      $sqlClashClass = "select tt.* from $tn_tt tt, $tn_tl tl, $tn_tlg tlg where tt.tl_id=tl.tl_id and tl.tlg_id=tlg.tlg_id and tlg.class_id='$classId' and tlg.tlg_type='L' and tt.tt_day='$dayId' and tt.tt_period='$period'";
      if ($conn->query($sqlClashClass)->num_rows > 1) $clashClass = 1;

      // Following block will be executed for Clash Resolve Modal Form
      if ($dropButton == '1') {
        echo '<div class="row border p-1 m-1">';
        echo '<div class="col-sm-5">' . $staff_name . '</div>';
        echo '<div class="col-sm-2">[' . $tlg_type . 'G-' . $tl_group . ']</div>';
        echo '<div class="col-sm-3">' . $subject_code . '</div>';
        echo '<div class="col-sm-2"><a class="dropClashButton"  data-tlDrop="' . $tl_id . '" data-dayDrop="' . $dayId . '" data-periodDrop="' . $period . '"><i class="fa fa-trash"></i></a></div>';
        echo '</div>';
      }
      if ($result->num_rows > 1 && $dropButton == '0') echo '<br>';
    }
    if ($clashClass == '1' || $clashStaff == '1') $clash = 1;
    else $clash = 0;
    // To Show Resolve Button for Clashes
    if ($clash == '1' && $dropButton == '0') echo '<br><a href="#" class="atag resolveClashButton" data-tlId="' . $tl_id . '" data-day="' . $dayId . '" data-period="' . $period . '"><span class="warning">Resolve</span></a>';
    elseif ($dropButton == '0') echo '<a href="#" class="atag resolveClashButton" data-tlId="' . $tl_id . '" data-day="' . $dayId . '" data-period="' . $period . '"><span class="warning"><i class="fa fa-trash"></i></span></a>';
  } else {
    echo '<span>--</span>';
  }
  if ($clashStaff == '1') {
    //echo "Staff Clash";
    $result = $conn->query($sqlClashStaff);
    while ($rowsTT = $result->fetch_assoc()) {
      $tlg_id=$rowsTT['tlg_id'];
      $clashClassId=getField($conn, $tlg_id, $tn_tlg, "tlg_id", "class_id");
      $subject_id=getField($conn, $tlg_id, $tn_tlg, "tlg_id", "subject_id");
      if($clashClassId<>$classId)
      {
        echo '<br>'.getField($conn, $clashClassId, "class", "class_id", "class_name");
        echo ' ['.getField($conn, $subject_id, "subject", "subject_id", "subject_code").']';
      }
    }
  }
}
