<?php
require('../../module/requireSubModule.php');
// echo $_POST['action'];
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
    $sql = "select fs.*, b.batch, p.program_name, s.school_name, mn.mn_name from fee_structure fs, batch b, program p, school s, master_name mn where mn.mn_id=fs.fee_category and s.school_id=fs.school_id and b.batch_id=fs.batch_id and p.program_id=fs.program_id and fs_status='0' order by b.batch desc, fs.fee_semester";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      $subArray=array();
      while ($rowsFee = $result->fetch_assoc()) {
        $subArray["fs_id"]=$rowsFee["fs_id"];
        $subArray["batch"]=$rowsFee["batch"];
        $subArray["school_name"]=$rowsFee["school_name"];
        $subArray["program_name"]=$rowsFee["program_name"];
        $subArray["mn_name"]=$rowsFee["mn_name"];
        $subArray["fee_type"]=getField($conn, $rowsFee["fee_type"], "master_name", "mn_id", "mn_name");
        $subArray["fee_component"]=getField($conn, $rowsFee["fee_component"], "master_name", "mn_id", "mn_name");
        $subArray["fee_semester"]=$rowsFee["fee_semester"];
        $subArray["fs_amount"]=$rowsFee["fs_amount"];
        $json_array[] = $subArray;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST["action"] == "deleteFee") {
    $fs_id = $_POST['fs_id'];
    $sql = "update fee_structure set fs_status='9' where fs_id='$fs_id'";
    $result = $conn->query($sql);
    if($result) echo "Data Dropped !!";
  }
}
