<?php
require('../../module/requireSubModule.php');
//echo $_POST['action'];
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'schoolOption') {
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
  } elseif ($_POST['action'] == 'departmentOption') {
    if(isset($_POST['schoolId']))$id = $_POST['schoolId'];
    else $id='0';
    if($id>0)$sql = "select d.* from department d, school s, school_dept sd where s.school_id='$id' and s.school_id=sd.school_id and sd.dept_id=d.dept_id and d.dept_status='0' order by dept_name";
    else $sql = "select d.* from department d, school s, school_dept sd where s.school_id=sd.school_id and sd.dept_id=d.dept_id and d.dept_status='0' order by dept_name";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      while ($rowsStudent = $result->fetch_assoc()) {
        $json_array[] = $rowsStudent;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'staffOption') {
    if(isset($_POST['schoolId']))$id = $_POST['schoolId'];
    else $id = '0';
    $sql = "select s.* from staff s where s.staff_status='0' order by s.staff_name";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      while ($rowsStudent = $result->fetch_assoc()) {
        $json_array[] = $rowsStudent;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'feUpdate') {
    echo $_POST['action'];
    if ($_POST['fe_id'] == 0) $sql = "insert into faculty_event (fe_type, fe_mode, fe_participant, fe_name, fe_abbri, fe_date_from, fe_time_from, fe_time_to, fe_url, fe_registration_link, fe_webinar_link, staff_id, fe_remarks, update_id, fe_status) values('" . data_check($_POST['fe_type']) . "', '" . data_check($_POST['fe_mode']) . "', '" . data_check($_POST['fe_participant']) . "','" . data_check($_POST['fe_name']) . "', '" . data_check($_POST['fe_abbri']) . "', '" . $_POST['fe_date_from'] . "', '" . $_POST['fe_time_from'] . "', '" . $_POST['fe_time_to'] . "', '" . $_POST['fe_url'] . "', '" . $_POST['fe_registration_link'] . "', '" . $_POST['fe_webinar_link'] . "', '" . $_POST['sel_staff'] . "', '" . $_POST['fe_remarks'] . "', '$myId', '0')";
    else $sql = "update faculty_event set fe_type='" . data_check($_POST['fe_type']) . "', fe_mode='" . data_check($_POST['fe_mode']) . "', fe_participant='" . data_check($_POST['fe_participant']) . "', fe_name='" . data_check($_POST['fe_name']) . "', fe_abbri='" . data_check($_POST['fe_abbri']) . "', fe_date_from='" . $_POST['fe_date_from'] . "', fe_time_from='" . $_POST['fe_time_from'] . "', fe_time_to='" . $_POST['fe_time_to'] . "', fe_registration_link='" . $_POST['fe_registration_link'] . "', fe_webinar_link='" . $_POST['fe_webinar_link'] . "', staff_id='" . $_POST['sel_staff'] . "', fe_url='" . $_POST['fe_url'] . "', fe_remarks='" . data_check($_POST['fe_remarks']) . "' where fe_id='" . $_POST['fe_id'] . "'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
  } elseif ($_POST['action'] == 'feList') {
    // $id = $_POST['userId'];
    // echo $myId;
    $json_array = array();
    $sql = "select * from faculty_event where fe_status<'2'";
    $result = $conn->query($sql);
    while ($todoRows = $result->fetch_assoc()) {
      $json_array[] = $todoRows;
    }
    echo json_encode($json_array);
  } elseif ($_POST['action'] == 'feFetch') {
    $sql = "select * from faculty_event where fe_id='" . $_POST['fe_id'] . "'";
    $result = $conn->query($sql);
    $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST['action'] == 'feRemove') {
    $sql = "update faculty_event set fe_status='1' where fe_id='" . $_POST['fe_id'] . "'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else echo "Removed ";
  } elseif ($_POST['action'] == 'feApprove') {
    $sql = "update faculty_event set fe_status='0' where fe_id='" . $_POST['fe_id'] . "'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else echo "Approved ";
  }
}
