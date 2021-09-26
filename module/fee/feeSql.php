<?php
require('../../module/requireSubModule.php');
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'batchOption') {
    $sql = "select * from batch where batch_status='0' order by batch desc";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      while ($rowsStudent = $result->fetch_assoc()) {
        $json_array[] = $rowsStudent;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'schoolOption') {
    $sql = "select * from school where school_status='0' order by school_name";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      while ($rowsStudent = $result->fetch_assoc()) {
        $json_array[] = $rowsStudent;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'progOption') {
    $id = $_POST['schoolId'];
    $sql = "select p.* from program p, dept_program dp, school s, school_dept sd where s.school_id='$id' and s.school_id=sd.school_id and sd.dept_id=dp.dept_id and dp.program_id=p.program_id and p.program_status='0' order by program_name";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      while ($rowsStudent = $result->fetch_assoc()) {
        $json_array[] = $rowsStudent;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'feeCategory') {
    $sql = "select * from master_name where mn_code='fcg' and mn_status='0' order by mn_name ASC";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      while ($rowsStudent = $result->fetch_assoc()) {
        $json_array[] = $rowsStudent;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'feeType') {
    $sql = "select * from master_name where mn_code='ft' and mn_status='0' order by mn_name ASC";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      while ($rowsStudent = $result->fetch_assoc()) {
        $json_array[] = $rowsStudent;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'feeComponent') {
    $sql = "select * from master_name where mn_code='fc' and mn_status='0' order by mn_name ASC";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      while ($rowsStudent = $result->fetch_assoc()) {
        $json_array[] = $rowsStudent;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'addFee') {
    // echo " Add Fee ";
    $school_id = $_POST['sel_school'];
    $batch_id = $_POST['sel_batch'];
    $program_id = $_POST['sel_prog'];
    $fcg = $_POST['sel_fcg'];
    $ft = $_POST['sel_ft'];
    $fc = $_POST['sel_fc'];
    $sem = $_POST['semester'];
    $fee = $_POST['fee'];
    $sql = "insert into fee_structure (school_id, program_id, batch_id, fee_category, fee_type, fee_component,fee_semester, fs_amount, update_id, fs_status) values ('$school_id', '$program_id', '$batch_id', '$fcg', '$ft','$fc', '$sem', '$fee', '$myId', '0')";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else echo "Fee Successfully Added";
  } elseif ($_POST['action'] == 'feeStructureList') {
    $batch_id = $_POST['sel_batch'];
    // $batch_id='10';
    $sql = "select fs.*, b.batch, p.program_name, s.school_name, mn.mn_name from fee_structure fs, batch b, program p, school s, master_name mn where mn.mn_id=fs.fee_category and s.school_id=fs.school_id and b.batch_id=fs.batch_id and p.program_id=fs.program_id and fs_status='0' and fs.batch_id='$batch_id' order by b.batch desc, fs.fee_semester";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      $subArray = array();
      while ($rowsFee = $result->fetch_assoc()) {
        $subArray["fs_id"] = $rowsFee["fs_id"];
        $subArray["batch"] = $rowsFee["batch"];
        $subArray["school_name"] = $rowsFee["school_name"];
        $subArray["program_name"] = $rowsFee["program_name"];
        $subArray["mn_name"] = $rowsFee["mn_name"];
        $subArray["fee_type"] = getField($conn, $rowsFee["fee_type"], "master_name", "mn_id", "mn_name");
        $subArray["fee_component"] = getField($conn, $rowsFee["fee_component"], "master_name", "mn_id", "mn_name");
        $subArray["fee_semester"] = $rowsFee["fee_semester"];
        $subArray["fs_amount"] = $rowsFee["fs_amount"];
        $json_array[] = $subArray;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST["action"] == "deleteFee") {
    $fs_id = $_POST['fs_id'];
    $sql = "update fee_structure set fs_status='9' where fs_id='$fs_id'";
    $result = $conn->query($sql);
    if ($result) echo "Data Dropped !!";
  } elseif ($_POST['action'] == 'copyFee') {
    echo $_POST['action'];
    $batch = getField($conn, $_POST['batch'], "batch", "batch", "batch_id");
    $copyBatch = getField($conn, $_POST['copyBatch'], "batch", "batch", "batch_id");
    echo "$batch - $copyBatch";
    // $batch_id='10';
    $sql = "select fs.* from fee_structure fs where fs.batch_id='$batch' and fs_status='0'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      while ($rowsFee = $result->fetch_assoc()) {
        $amount = $rowsFee["fs_amount"];
        $sql_fs = "insert into fee_structure (school_id, program_id, batch_id, fee_category, fee_type, fee_component,fee_semester, fs_amount, update_id, fs_status) values('" . $rowsFee['school_id'] . "', '" . $rowsFee['program_id'] . "', '$copyBatch', '" . $rowsFee['fee_category'] . "', '" . $rowsFee['fee_type'] . "', '" . $rowsFee['fee_component'] . "', '" . $rowsFee['fee_semester'] . "', '" . $rowsFee['fs_amount'] . "', '$myId', '" . $rowsFee['fs_status'] . "')";
        $result_fs = $conn->query($sql_fs);
        if (!$result_fs) $conn->error;
      }
    }
  } elseif ($_POST['action'] == 'feeScheduleList') {
    $batch_id = $_POST['sel_batch'];
    $fee_type = $_POST['ft'];
    // $batch_id='10';
    $sql = "select fs.*, sum(fs.fs_amount) as amount from fee_structure fs where fs_status='0' and fs.batch_id='$batch_id' and fs.fee_type='$fee_type' group by fs.fee_category, fs.program_id order by fs.program_id, fs.fee_semester";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      while ($rowsFee = $result->fetch_assoc()) {
        $batch_id = $rowsFee["batch_id"];
        $program_id = $rowsFee["program_id"];
        $school_id = $rowsFee["school_id"];
        $fee_category = $rowsFee["fee_category"];
        $fee_type = $rowsFee["fee_type"];
        $fee_semester = $rowsFee["fee_semester"];
        $fsch_amount = $rowsFee["amount"];

        $sql_fsch = "select * from fee_schedule where school_id='$school_id' and program_id='$program_id' and batch_id='$batch_id' and fee_category='$fee_category' and fee_type='$fee_type' and fee_semester='$fee_semester'";
        $result_dup = $conn->query($sql_fsch);
        $dup_rows = $result_dup->num_rows;
        // echo "---$dup_rows----<br>";
        if ($dup_rows == 0) {
          $sql_insert = "insert into fee_schedule (school_id, program_id, batch_id, fee_category, fee_type, fee_semester, fsch_amount, last_date, update_id, fsch_status) values('$school_id', '$program_id', '$batch_id', '$fee_category', '$fee_type', '$fee_semester', '$fsch_amount', '$submit_date', '$myId', '0')";
          $result_insert = $conn->query($sql_insert);
        } else {
          $sql_update = "update fee_schedule set fsch_amount='$fsch_amount' where  school_id='$school_id' and program_id='$program_id' and batch_id='$batch_id' and fee_category='$fee_category' and fee_type='$fee_type' and fee_semester='$fee_semester'";
          $result_update = $conn->query($sql_update);
        }
      }
    }

    $sql = "select fsch.fsch_id, fsch.fee_type, fsch.fee_semester, fsch.fee_category, fsch.last_date, sum(fsch.fsch_amount) as amount, b.batch, p.program_name, s.school_name from fee_schedule fsch, batch b, program p, school s where s.school_id=fsch.school_id and b.batch_id=fsch.batch_id and p.program_id=fsch.program_id and fsch_status='0' and fsch.batch_id='$batch_id' and fsch.fee_type='$fee_type' group by fsch.fee_category, fsch.program_id order by fsch.program_id, fsch.fee_semester";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      $subArray = array();
      while ($rowsFee = $result->fetch_assoc()) {
        $subArray["batch"] = $rowsFee["batch"];
        $subArray["school_name"] = $rowsFee["school_name"];
        $subArray["program_name"] = $rowsFee["program_name"];
        $subArray["fee_category"] = getField($conn, $rowsFee["fee_category"], "master_name", "mn_id", "mn_name");
        $subArray["fee_type"] = getField($conn, $rowsFee["fee_type"], "master_name", "mn_id", "mn_name");
        $subArray["fee_semester"] = $rowsFee["fee_semester"];
        $subArray["fsch_amount"] = $rowsFee["amount"];
        $subArray["last_date"] = $rowsFee["last_date"];
        // $subArray["fs_amount"] = $fee_type;
        $json_array[] = $subArray;
      }
      echo json_encode($json_array);
    }
  }
}
