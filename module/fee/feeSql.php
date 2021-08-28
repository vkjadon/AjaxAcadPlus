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
  }
}
