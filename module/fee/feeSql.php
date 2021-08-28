<?php
require('../../module/requireSubModule.php');
//echo $_POST['action'];
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
    $school_id = $_POST['sel_school'];
    $batch_id = $_POST['sel_batch'];
    $program_id = $_POST['sel_prog'];
    $fcg = $_POST['sel_fcg'];
    $ft = $_POST['sel_ft'];
    $fc = $_POST['sel_fc'];
    $sem = $_POST['semester'];
    $fee = $_POST['fee'];
    $sql = "insert into fee_structure (school_id,program_id,batch_id,fee_category,fee_type, fee_component,fee_semester,fc_amount,update_id,status) values ('$school_id','$program_id','$batch_id','$fcg','$ft','$fc','$sem','$fee','$myId','0')";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  } elseif ($_POST['action'] == 'feeStructureList') {

    $sql = "select fs.*, b.batch, p.program_name, s.school_name, mn.mn_name from fee_structure fs, batch b, program p, school s, master_name mn where mn.mn_id=fs.fee_category and s.school_id=fs.school_id and b.batch_id=fs.batch_id and p.program_id=fs.program_id and status='0'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      while ($rowsFee = $result->fetch_assoc()) {
        $json_array[] = $rowsFee;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST["action"] == "deleteFee") {
    $fs_id = $_POST['fs_id'];
    $sql = "update fee_structure set status='9' where fs_id='$fs_id'";
    $result = $conn->query($sql);
    // echo $tn;
  }
}
