<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
//echo $_POST['action'];
if (isset($_POST['action'])) {

  if ($_POST['action'] == 'addInst') {
    //echo "MyId- $myId";
    $fields = ['inst_name', 'inst_abbri', 'inst_url', 'inst_doi', 'submit_id'];
    $values = [data_check($_POST['inst_name']), data_check($_POST['inst_abbri']), $_POST['inst_url'], $_POST['inst_doi'],$myId];
    $status = 'inst_status';
    $dup = "select * from institution where inst_url='" . data_check($_POST["inst_url"]) . "' and $status='0'";
    $dup_alert = "Duplicate URL Exists. One Institute can have one URL. Give Dummy Unique URL if required";
    addData($conn, 'institution', 'inst_id', $fields, $values, $status, $dup, $dup_alert);
  } elseif ($_POST['action'] == 'updateInst') {
    $fields = ['inst_id', 'inst_name', 'inst_abbri', 'inst_url', 'inst_doi'];
    $values = [$_POST['modalId'], data_check($_POST['inst_name']), data_check($_POST['inst_abbri']),  data_check($_POST['inst_url']), data_check($_POST['inst_doi'])];
    $dup = "select * from institution where inst_id='" . $_POST["modalId"] . "'";
    $dup_alert="Could Not Update - Duplicate Entries";
    updateData($conn, 'institution', $fields, $values, $dup, $dup_alert);
  } elseif ($_POST['action'] == 'fetchInst') {
    $id = $_POST['instId'];
    $sql = "SELECT * FROM institution where inst_id='$id'";
    $result = $conn->query($sql);
    $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST['action'] == 'addSchool') {
    //echo "MyId- $myId";
    $fields = ['school_name', 'school_abbri', 'school_url', 'school_doi', 'submit_id'];
    $values = [data_check($_POST['school_name']), data_check($_POST['school_abbri']), $_POST['school_url'], $_POST['school_doi'], $myId];
    $status = 'school_status';
    $dup = "select * from school where school_url='" . data_check($_POST["school_url"]) . "' and $status='0'";
    $dup_alert = "Duplicate URL Exists. One School can have one URL. Give Dummy Unique URL if required";
    addData($conn, 'school', 'school_id', $fields, $values, $status, $dup, $dup_alert);
  } elseif ($_POST['action'] == 'fetchSchool') {
    $id = $_POST['schoolId'];
    $sql = "SELECT * FROM school where school_id='$id'";
    $result = $conn->query($sql);
    $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST['action'] == 'updateSchool') {
    $fields = ['school_id', 'school_name', 'school_abbri', 'school_url', 'school_doi'];
    $values = [$_POST['modalId'], data_check($_POST['school_name']), data_check($_POST['school_abbri']),  data_check($_POST['school_url']), data_check($_POST['school_doi'])];
    $dup = "select * from school where school_id='" . $_POST["modalId"] . "'";
    $dup_alert="Could Not Update - Duplicate Entries";
    updateData($conn, 'school', $fields, $values, $dup, $dup_alert);
  } elseif ($_POST['action'] == 'addDept') {
    //echo "MyId- $myId";
    $fields = ['dept_name', 'dept_abbri', 'dept_type', 'school_id', 'dept_doi', 'submit_id'];
    $values = [data_check($_POST['dept_name']), data_check($_POST['dept_abbri']), $_POST['deptTypeModal'], $_POST['schoolIdModal'], $_POST['dept_doi'], $myId];
    $status = 'dept_status';
    $dup = "select * from department where dept_name='" . data_check($_POST["dept_name"]) . "' and $status='0'";
    $dup_alert = "Duplicate URL Exists. One Dept can have one URL. Give Dummy Unique URL if required";
    addData($conn, 'department', 'dept_id', $fields, $values, $status, $dup, $dup_alert);
  } elseif ($_POST['action'] == 'fetchDept') {
    $id = $_POST['deptId'];
    $sql = "SELECT * FROM department where dept_id='$id'";
    $result = $conn->query($sql);
    $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST['action'] == 'updateDept') {
    $fields = ['dept_id', 'dept_name', 'dept_abbri', 'dept_doi'];
    $values = [$_POST['modalId'], data_check($_POST['dept_name']), data_check($_POST['dept_abbri']), data_check($_POST['dept_doi'])];
    $dup = "select * from department where dept_id='" . $_POST["modalId"] . "'";
    $dup_alert="Could Not Update - Duplicate Entries";
    updateData($conn, 'department', $fields, $values, $dup, $dup_alert);
  } elseif ($_POST['action'] == 'addProgram') {
    //echo "MyId- $myId";
    $fields = ['dept_id', 'program_name', 'program_abbri', 'program_duration','program_seat', 'program_start',  'program_code', 'program_semester','sp_name', 'sp_abbri','sp_code'];
    $values = [$_POST['deptIdModal'], data_check($_POST['program_name']), data_check($_POST['program_abbri']), $_POST['program_duration'], $_POST['program_seat'], $_POST['program_start'], $_POST['program_code'], $_POST['program_semester'],data_check($_POST['sp_name']),data_check($_POST['sp_abbri']),data_check($_POST['sp_code'])];
    $status = 'program_status';
    $dup = "select * from program where sp_name='" . data_check($_POST["sp_name"]) . "' and $status='0'";
    $dup_alert = "Duplicate URL Exists. One Dept can have one URL. Give Dummy Unique URL if required";
    addData($conn, 'program', 'program_id', $fields, $values, $status, $dup, $dup_alert);
  } elseif ($_POST['action'] == 'fetchProgram') {
    $id = $_POST['programId'];
    $sql = "SELECT * FROM program where program_id='$id'";
    $result = $conn->query($sql);
    $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST['action'] == 'updateProgram') {
    $fields = ['program_id','program_name', 'program_abbri', 'program_duration','program_seat', 'program_start',  'program_code', 'program_semester','sp_name', 'sp_abbri','sp_code'];
    $values = [$_POST['modalId'], data_check($_POST['program_name']), data_check($_POST['program_abbri']), data_check($_POST['program_duration']), data_check($_POST['program_seat']), data_check($_POST['program_start']),data_check($_POST['program_code']), data_check($_POST['program_semester']),data_check($_POST['sp_name']),data_check($_POST['sp_abbri']),data_check($_POST['sp_code'])];
    $dup = "select * from program where program_id='" . $_POST["modalId"] . "'";
    $dup_alert="Could Not Update - Duplicate Entries";
    updateData($conn, 'program', $fields, $values, $dup, $dup_alert);
  }elseif ($_POST["action"] == "instList") {
    //echo "MyId- $myId";
    $tableId = 'inst_id';
    $fields = array("inst_name", "inst_abbri", "inst_url", "inst_doi", "inst_status");
    $dataType = array("0", "0", "0", "1", "0");
    $header = array("Id", "Institute Name", "Institute abbri", "Institute URL", "Institute DoI", "Status");
    $statusDecode = array("status" => "inst_status", "0" => "Active", "1" => "Deleted");
    $button = array("1", "1", "0", "0");

    $sql = "SELECT * from institution where inst_status='0' order by inst_name";
    getList($conn, $tableId, $fields, $dataType, $header, $sql, $statusDecode, $button);
  } elseif ($_POST["action"] == "schoolList") {
    //echo "MyId- $myId";
    $tableId = 'school_id';
    $fields = array("school_name", "school_abbri", "school_url", "school_doi", "school_status");
    $dataType = array("0", "0", "0", "1", "0");
    $header = array("Id", "School Name", "School abbri", "School URL", "School DoI", "Status");
    $statusDecode = array("status" => "school_status", "0" => "Active", "1" => "Deleted");
    $button = array("1", "1", "0", "0");

    $sql = "SELECT * from school where school_status='0' order by school_name";
    getList($conn, $tableId, $fields, $dataType, $header, $sql, $statusDecode, $button);
  } elseif ($_POST["action"] == "deptList") {
    
    //echo "MyId- $myId";
    
    $school_id=$_POST['schoolId'];
    $dept_type=$_POST['deptType'];
    //echo "School Id  ".$school_id;

    $tableId = 'dept_id';   
    $statusDecode = array("status" => "dept_status", "0" => "Active", "1" => "Deleted");
    $button = array("1", "1", "0", "0");

    $fields = array("dept_name", "dept_abbri", "dept_doi", "dept_status");
    $dataType = array("0", "0", "0", "1", "0");
    $header = array("Id", "Department Name", "Department Abbri", "Department DoI", "Status");
    
    if($school_id>0)$sql = "SELECT * from department where school_id='$school_id' and dept_type='$dept_type' and dept_status='0' order by dept_name";
    else $sql = "SELECT * from department where dept_type='$dept_type' and dept_status='0' order by dept_name";
    getList($conn, $tableId, $fields, $dataType, $header, $sql, $statusDecode, $button);
  }elseif ($_POST["action"] == "programList") {
    //    echo "MyId- $myId";
    $tableId = 'program_id';
    
    //$dept_id=$_POST['deptId'];
    
    $statusDecode = array("status" => "program_status", "0" => "Active", "1" => "Deleted");
    $button = array("1", "1", "0", "0");

    $fields = array("program_name", "program_abbri", "sp_name", "sp_abbri", "program_duration", "program_semester", "program_start","program_seat", "program_code", "program_status");
    $dataType = array("0", "0", "0", "0", "0", "0", "0", "0", "0", "0");
    $header = array("Id", "Program Name", "Prg Abbri", "Sp Name", "Sp Abbri", "Duration (yrs)", "Semester", "Start Year", "Seats", " PrgCode", "Status");
    
    $sql = "SELECT * from program where program_status='0' order by program_name";
    getList($conn, $tableId, $fields, $dataType, $header, $sql, $statusDecode, $button);
  }
}
