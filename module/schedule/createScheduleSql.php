<?php
require('../requireSubModule.php');

//echo $_POST['action'];
//global $tn_tt;
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'sessionClassList') {
    $json = get_sessionClass($conn, $mySes, $myDept);
    //echo $json;
    $array = json_decode($json, true);
    //echo count($array);
    //echo count($array["data"]);
    echo '<table class="table list-table-xs mb-0">';
    echo '<tr><th></th><th>Name</th><th>StdReg</th></tr>';
    for ($i = 0; $i < count($array["data"]); $i++) {

      echo '<tr>';
      echo '<td><input type="checkbox" class="sclCS" id="' . $array["data"][$i]["id"] . '" value="' . $array["data"][$i]["id"] . '"></td>';
      echo '<td>' . $array["data"][$i]["name"] . '[' . $array["data"][$i]["section"] . ']</td>';
      echo '<td><button class="btn btn-secondary btn-square-sm showScheduleForm" id="ss' . $array["data"][$i]["id"] . '">Schedule Form</button></td>';
      echo '</tr>';
    }
    echo '</table>';
    //echo '<button class="btn btn-success btn-square-sm mt-0 scheduleFormButton">Show Schedule Form</button>';
  } elseif ($_POST['action'] == 'createSchedule') {
    $from = $_POST['scheduleFrom'];
    $to = $_POST['scheduleTo'];
    $classId = $_POST['classId'];
    echo " $from - $to - $classId ";
    $days = (strtotime($to) - strtotime($from)) / (24 * 60 * 60) + 1;
    echo getField($conn, $classId, 'class', 'class_id', 'class_name');
    for ($j = 0; $j < $days; $j++) {
      $current_ts = strtotime($from) + $j * 24 * 60 * 60;
      $current_date = date("Y-m-d", $current_ts);
      $dayofDate = date("D", $current_ts);
      //echo "$dayofDate";
      $json = get_classTimeTableJson($conn, $classId, $tn_tt, $tn_tl, $tn_tlg, $dayofDate);
      //echo $json;
      $array = json_decode($json, true);
      for ($k = 0; $k < count($array["data"]); $k++) {
        $tlId = $array["data"][$k]["tlId"];
        $period = $array["data"][$k]["period"];
        $sql_dup = "select * from $tn_sas where tl_id='$tlId' and sas_period='$period' and sas_date='$current_date'";
        $result_dup = $conn->query($sql_dup);
        if ($result_dup->num_rows == '0') {
          $staff_id = getField($conn, $tlId, $tn_tl, "tl_id", "staff_id");
          //echo $staff_id;
          $sql = "insert into $tn_sas (tl_id, sas_period, sas_date, sas_mark, staff_id, update_id, sas_status) values('$tlId','$period','$current_date', '0', '$staff_id','$myId', '0')";
          $conn->query($sql);
        } else {
          $rows = $result_dup->fetch_assoc();
          $status = $rows["sas_status"];
          $sas_id = $rows["sas_id"];
          //echo "Status $status";
          if ($status == '1') {
            $sql = "update $tn_sas set sas_status='0' where sas_id='$sas_id'";
            $conn->query($sql);
          }
        }
      }
    }
    echo "<h4>Schedule Created </h4>";
  } elseif ($_POST['action'] == 'sessionClassListSTT') {
    // echo $mySes.'-'.$myProg;
    $json = get_sessionClass($conn, $mySes, $myProg);
    //echo $json;
    $array = json_decode($json, true);
    
    for ($i = 0; $i < count($array["data"]); $i++) {
      echo '<input type="checkbox" class="sclSTT" id="STT' . $array["data"][$i]["id"] . '" value="' . $array["data"][$i]["id"] . '"> ' . $array["data"][$i]["name"] . '[' . $array["data"][$i]["section"] . '] ';
    }
    
    //echo '<button class="btn btn-success btn-square-sm mt-0 scheduleFormButton">Show Schedule Form</button>';
  } elseif ($_POST['action'] == 'showTimeTable') {
    $id = $_POST['checkboxes_value'];
    $day = array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun");
    for ($i = 0; $i < count($id); $i++) {
      echo '<table class="table list-table-xs">';
      echo '<thead><td><h5>' . getField($conn, $id[$i], 'class', 'class_id', 'class_name') . '</h5></td>';
      echo '<td colspan="2">CI </td>';
      echo '<td colspan="2">CR </td>';
      echo '<td colspan="2">Room </td>';
      echo '</thead>';
      for ($k = 0; $k < count($day); $k++) {
        echo '<tr><td>' . $day[$k] . '</td>';
        $classId = $id[$i];
        //$json = get_classTimeTableJson($conn, $classId, $tn_tt, $tn_tl, $tn_tlg);
        //echo $json;
        //$array = json_decode($json, true);

        for ($j = 1; $j < 10; $j++) {
          $sql = "select tt.* from $tn_tt tt, $tn_tl tl, $tn_tlg tlg where tt.tl_id=tl.tl_id and tl.tlg_id=tlg.tlg_id and tlg.class_id='$classId' and tt.tt_day='$day[$k]' and tt.tt_period='$j'";
          $result = $conn->query($sql);
          $sno = 0;
          echo '<td>';
          if ($result && $result->num_rows > 0) {
            while ($rows = $result->fetch_assoc()) {
              $sno++;
              $tl_id = $rows['tl_id'];
              $staff_id = getField($conn, $tl_id, $tn_tl, 'tl_id', 'staff_id');
              $tlg_id = getField($conn, $tl_id, $tn_tl, 'tl_id', 'tlg_id');
              $tl_group = getField($conn, $tl_id, $tn_tl, 'tl_id', 'tl_group');
              $tlg_type = getField($conn, $tlg_id, $tn_tlg, 'tlg_id', 'tlg_type');
              $subject_id = getField($conn, $tlg_id, $tn_tlg, 'tlg_id', 'subject_id');
              $subject_code = getField($conn, $subject_id, 'subject', 'subject_id', 'subject_code');
              $staff_name = getField($conn, $staff_id, 'staff', 'staff_id', 'staff_name');
              //echo '<span>' . $subject_code . ' <b>[G-' . $tl_group . ']</b><br>' . $staff_name . '</span>';

              echo '<span>' . $subject_code . ' <b>[' . $tlg_type . 'G-' . $tl_group . ']</b><br>' . $staff_name . '</span>';
              if ($result->num_rows > 1) echo '<br>';
            }
          } else {
            echo '<span>--</span>';
          }
          echo '</td>';
        }
      }
      echo '</tr>';
    }
    echo '</table>';
  } elseif ($_POST['action'] == 'showSchedule') {
    $classId = $_POST['classId'];
    $from = $_POST['scheduleFrom'];
    $to = $_POST['scheduleTo'];
    //echo "$from - $to";
    $days = (strtotime($to) - strtotime($from)) / (24 * 60 * 60) + 1;
          
    $day = array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
    echo '<table class="table list-table-xxs">';
    echo '<tr><td><h5>' . getField($conn, $classId, 'class', 'class_id', 'class_name') . '</h5></td></tr>';
    for ($k = 0; $k < $days; $k++) {
      $current_ts = strtotime($from) + $k * 24 * 60 * 60;
      $current_date = date("Y-m-d", $current_ts);
      $dayofDate = date("D", $current_ts);

      echo '<tr><td>' . $dayofDate . '</td>';
      for ($j = 1; $j < 10; $j++) {
        $sql = "select sas.*, tl.tl_id, tl.tl_group, tlg.* from $tn_sas sas, $tn_tl tl, $tn_tlg tlg where sas.tl_id=tl.tl_id and tl.tlg_id=tlg.tlg_id and tlg.class_id='$classId' and sas.sas_date='$current_date' and sas.sas_period='$j' and sas_status='0'";
        $result = $conn->query($sql);
        $sno = 0;
        echo '<td>';
        echo '<a href="#" class="substituteSchedule" data-class="' . $classId . '" data-date="' . $current_date . '" data-period="' . $j . '"><i class="fa fa-upload" aria-hidden="true" style="color:green"></i></a>';
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

            $staff_id = $rows['staff_id'];
            $staff_name = getField($conn, $staff_id, 'staff', 'staff_id', 'staff_name');

            //echo '<span>' . $subject_code . ' <b>[G-' . $tl_group . ']</b><br>' . $staff_name . '</span>';

            echo '<div id="sas' . $sas_id . '">' . $subject_code . ' <b>[' . $tlg_type . 'G-' . $tl_group . ']</b><br>' . $staff_name;
            echo '<a href="#" class="dropSchedule" data-sas="' . $sas_id . '"><i class="fa fa-times" aria-hidden="true" style="color:red"></i></a>';
            echo '&nbsp;<a href="#" class="substituteStaff" data-sas="' . $sas_id . '"><i class="fa fa-upload" aria-hidden="true" style="color:black"></i></a>';
            echo '</div>';
            if ($result->num_rows > 1) echo '<br>';
          }
        }
        echo '</td>';
      }
    }
    echo '</tr>';
    echo '</table>';
    echo '<em>Note: Use Green link to substitute the Teaching Load and Use Black link to Staff only, . </em>';
  } elseif ($_POST['action'] == 'dropSchedule') {
    $sas_id = $_POST['sasId'];
    $sql = "update $tn_sas set sas_status='1' where sas_id='$sas_id'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    echo '';
  } elseif ($_POST['action'] == 'tlDataSub') {
    $classId = $_POST['classId'];
    $sasDate = $_POST['sasDate'];
    $sasPeriod = $_POST['sasPeriod'];
    echo "Classs $classId";
    $sql = "select tl.*, tlg.* from $tn_tl tl, $tn_tlg tlg where tlg.tlg_id=tl.tlg_id and tlg.class_id='$classId' and tl.tl_status='0' order by tlg.tlg_type";
    $result = $conn->query($sql);
    if (!$result) die("Could not List the Teaching Load!");
    echo '<table  class="list-table-xxs table-striped">';
    echo '<thead><th>tl-tlg</th><th>Subject</th><th>Staff</th><th>Grp</th><th>Assign</th></thead>';
    while ($rows = $result->fetch_assoc()) {
      $subject_name = getField($conn, $rows['subject_id'], "subject", "subject_id", "subject_name");
      $staff_name = getField($conn, $rows['staff_id'], "staff", "staff_id", "staff_name");
      $tlId=$rows['tl_id'];
      echo '<tr>';
      echo '<td>' . $tlId . '-' . $rows['tlg_id'] . '</td>';
      echo '<td>' . $subject_name . '</td>';
      echo '<td>' . $staff_name . '</td>';
      echo '<td>' . $rows['tlg_type'] . '-' . $rows['tl_group'] . '</td>';
      echo '<td>';
      echo '<input type="radio" class="subSlot" data-tl="' . $rows['tl_id'] . '" data-sasPeriod="' . $sasPeriod . '" data-sasDate="' . $sasDate . '" name="sub" value="'.$tlId.'">';
      echo '</td>';
      echo '</tr>';
    }
    echo '</table>';
  } elseif ($_POST['action'] == 'subStaffForm') {
    //$classId = $_POST['classId'];
    $sasId = $_POST['sasId'];
    echo "SasId $sasId";
    $sql="select * from staff where staff_status='0'";
    selectList($conn, "", array("0", "staff_id", "staff_name", "staff_id", "sub_staff"), $sql);
  } elseif ($_POST['action'] == 'subStaff') {
    //$classId = $_POST['classId'];
    $sasId = $_POST['modalIdSub'];
    $staff_id = $_POST['sub_staff'];
    $sql="update $tn_sas set staff_id='$staff_id', update_ts='$submit_ts', update_id='$myId' where sas_id='$sasId'";
    $conn->query($sql);
    //echo "SasId $sasId $staff_id";
  } elseif ($_POST['action'] == 'subSchedule') {
    $sasDate = $_POST['subDateM'];
    $sasPeriod = $_POST['subPeriodM'];
    $classId = $_POST['subClassM'];
    $tlId = $_POST['sub'];
    $staff_id=getField($conn, $tlId, $tn_tl, 'tl_id', 'staff_id');
    //echo "SasDate $sasDate Period $sasPeriod Class $classId TLId $tlId";
    $sql="update $tn_sas set sas_status='0' where tl_id='$tlId' and staff_id='$staff_id' and sas_period='$sasPeriod' and sas_date='$sasDate'";
    $result=$conn->query($sql);
    if($conn->affected_rows==0){
      $sql="insert into $tn_sas (tl_id, sas_date, sas_period, staff_id, update_ts, update_id, sas_status) values('$tlId', '$sasDate', '$sasPeriod', '$staff_id', '$submit_ts', '$myId', '0')";
      $conn->query($sql);
      $result=$conn->query($sql);
      if(!$result)echo $conn->error;
      else echo " Inserted ";
    }
    elseif($conn->affected_rows>0) echo "Updated";
    else echo $conn->error;
  }
}
