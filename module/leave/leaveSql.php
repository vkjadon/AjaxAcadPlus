<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
//echo $_POST['action'];
/*
0 - Saved
1 - Withdrwan
2 - Forwarded
3 - Approved
8 - Rejected by Forwarder
9 - Rejected by Approver
Once Rejected, A new application is to be submitted.
*/

if (isset($_POST["specialStaffquery"])) {
  $output = '';
  $sql = "select * from staff where staff_name LIKE '%" . $_POST["specialStaffquery"] . "%'";
  $result = $conn->query($sql);
  $output = '<ul class="list-group">';
  if ($result) {
    while ($row = $result->fetch_assoc()) {
      $output .= '<li class="list-group-item list-group-item-action specialStaffAutoList"  data-std="' . $row["staff_id"] . '" >' . $row["staff_name"] . '</li>';
    }
  } else {
    $output .= '<li>Staff Not Found</li>';
  }
  $output .= '</ul>';
  echo $output;
}
if (isset($_POST["approverQuery"])) {
  $output = '';
  $sql = "select * from staff where staff_name LIKE '%" . $_POST["approverQuery"] . "%'";
  $result = $conn->query($sql);
  $output = '<ul class="list-group">';
  if ($result) {
    while ($row = $result->fetch_assoc()) {
      $output .= '<li class="list-group-item list-group-item-action approverAutoList"  data-std="' . $row["staff_id"] . '" >' . $row["staff_name"] . '</li>';
    }
  } else {
    $output .= '<li>Staff Not Found</li>';
  }
  $output .= '</ul>';
  echo $output;
}
if (isset($_POST["forwarderQuery"])) {
  $output = '';
  $sql = "select * from staff where staff_name LIKE '%" . $_POST["forwarderQuery"] . "%'";
  $result = $conn->query($sql);
  $output = '<ul class="list-group">';
  if ($result) {
    while ($row = $result->fetch_assoc()) {
      $output .= '<li class="list-group-item list-group-item-action forwarderAutoList"  data-std="' . $row["staff_id"] . '" >' . $row["staff_name"] . '</li>';
    }
  } else {
    $output .= '<li>Staff Not Found</li>';
  }
  $output .= '</ul>';
  echo $output;
}
if ($_POST['action'] == 'add') {
  //echo "MyId- $myId";
  $fields = ['lccf_claim_date', 'lccf_reason', 'staff_id', 'submit_date', 'submit_id'];
  $values = [data_check($_POST['duty_date']), data_check($_POST['reason']), $myId, $submit_date, $myId];
  $status = 'lccf_status';
  $dup = "select * from leave_ccf where staff_id='$myId' and lccf_claim_date='" . data_check($_POST["duty_date"]) . "' and $status='0'";
  addData($conn, 'leave_ccf', 'lccf_id', $fields, $values, $status, $dup, '');
} elseif ($_POST['action'] == 'edit') {
  $fields = ['lccf_id', 'lccf_claim_date', 'lccf_reason', 'update_ts'];
  $values = [$_POST['id'], data_check($_POST['duty_date']), data_check($_POST['reason']), $submit_ts];
  $dup = "select * from leave_ccf where staff_id='$myId' and lccf_claim_date='" . data_check($_POST["duty_date"]) . "' and lccf_status='0'";
  $dup_alert = "Duplicate Found!!";
  updateData($conn, 'leave_ccf', $fields, $values, $dup, $dup_alert);
} elseif ($_POST['action'] == 'delete') {
  echo "MyId- $myId";
  $update_ts = time();

  $sql = "update leave_ccf set lccf_status='1' where lccf_id='" . $_POST["deleteId"] . "'";
  $result = $conn->query($sql);
} elseif ($_POST["action"] == "ccfList") {
  //echo "MyId- $myId";
  $tableId = 'lccf_id';
  $fields = array("lccf_claim_date", "lccf_reason", "lccf_status");
  $dataType = array("1", "0", "0");
  $header = array("Id", "ClaimDate", "Reason", "Status");
  $statusDecode = array("status" => "lccf_status", "0" => "Saved", "1" => "Withdrawn", "2" => "Forwarded", "3" => "Approved", "8" => "Rejected by Forwarder", "9" => "Rejected by Approver");
  $button = array("1", "1", "1", "0");

  $sql = "SELECT * from leave_ccf where staff_id='$myId' order by lccf_claim_date desc";
  getList($conn, $tableId, $fields, $dataType, $header, $sql, $statusDecode, $button);
} elseif ($_POST["action"] == "ccfForwarderPendingList" || $_POST["action"] == "ccfApproverPendingList") {
  //echo "MyId- $myId";
  $tableId = 'lccf_id';
  $fields = array("staff_name", "lccf_claim_date", "lccf_reason", "lccf_status");
  $dataType = array("0", "1", "0", "0");
  $header = array("Id", "Staff", "ClaimDate", "Reason", "Status");
  $statusDecode = array("status" => "lccf_status", "0" => "Saved", "1" => "Withdrawn", "2" => "Forwarded", "3" => "Approved", "8" => "Rejected by Forwarder", "9" => "Rejected by Approver");
  $button = array("0", "0", "0", "1");

  if ($_POST["action"] == "ccfForwarderPendingList") $sql = "SELECT lc.*, s.staff_name from leave_ccf lc, staff s where lc.staff_id=s.staff_id and lccf_status='0' order by lc.lccf_claim_date desc";
  else $sql = "SELECT lc.*, s.staff_name from leave_ccf lc, staff s where lc.staff_id=s.staff_id and lccf_status='2' order by lc.lccf_claim_date desc";
  getList($conn, $tableId, $fields, $dataType, $header, $sql, $statusDecode, $button);
} elseif ($_POST['action'] == 'fetch') {
  $id = $_POST['lccfId'];
  $sql = "SELECT * FROM leave_ccf where lccf_id='$id'";
  $result = $conn->query($sql);
  $output = $result->fetch_assoc();
  echo json_encode($output);
} elseif ($_POST['action'] == 'approve') {
  $id = $_POST['modal_lccfId'];
  $status = $_POST['modal_status'];
  $previous_comments = $_POST['modal_comments'];
  $comments = $_POST['comments'];

  if ($status == '0') {

    $comments = $previous_comments . '<br><b>Forwarding Comments on ' . date("d-m-Y", time()) . '</b><br>' . $comments;
    if ($_POST['approve'] == '1') {
      $newStatus = '2';
      $comments .= ' (<b>Forwarded</b>)';
    } else {
      $newStatus = '8';
      $comments .= ' (<b>Rejected</b>)';
    }
    $sql = "update leave_ccf set lccf_reason='$comments', lccf_forwarder_ts='$submit_ts', lccf_status='$newStatus' where lccf_id='$id'";
    $result = $conn->query($sql);
  } elseif ($status == '2') {
    $comments = $previous_comments . '<br><b>Approving Comments on ' . date("d-m-Y", time()) . '</b><br>' . $comments;
    if ($_POST['approve'] == '1') {
      $newStatus = '3';
      $comments .= ' (<b>Approved</b>)';
    } else {
      $newStatus = '9';
      $comments .= ' (<b>Rejected</b>)';
    }
    $sql = "update leave_ccf set lccf_reason='$comments', lccf_approver_ts='$submit_ts', lccf_status='$newStatus' where lccf_id='$id'";
    $result = $conn->query($sql);
  } else $update = $status;
} elseif ($_POST['action'] == 'leaveReport') {
  $lf = $_POST['lf'];
  $lt = $_POST['lt'];
  $deptId = $_POST['deptId'];
  $url = $setUrl . '/acadplus/api/leave/leave_report.php?u=' . $myUn . '&&p=' . $myPwd . '&&lf=' . $lf . '&&lt=' . $lt . '&&deptId=' . $deptId;
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  $output = curl_exec($curl);
  //$output=json_decode($output, true);
  curl_close($curl);
  echo $output;
} elseif ($_POST['action'] == 'leaveTypeList') {
  $sql = "select * from leave_type";
  $result = $conn->query($sql);
  $json_array = array();
  while ($rowArray = $result->fetch_assoc()) {
    $json_array[] = $rowArray;
  }
  echo json_encode($json_array);
} elseif ($_POST['actionLeaveYear'] == 'addLeaveYear') {
  $ly_to = $_POST['leaveYearTo'];
  $ly_from = $_POST['leaveYearFrom'];
  $sql = "insert into leave_year (ly_to, ly_from) values ('$ly_to', '$ly_from')";
  $conn->query($sql);
  echo $conn->error;
} elseif ($_POST['action'] == 'leaveYearList') {
  $sql = "select * from leave_year";
  $result = $conn->query($sql);
  $json_array = array();
  while ($rowArray = $result->fetch_assoc()) {
    $json_array[] = $rowArray;
  }
  echo json_encode($json_array);
} elseif ($_POST['action'] == 'setCurrentLeaveYear') {
  $sql = "update leave_year set ly_status='A'";
  $result = $conn->query($sql);
  $id  = $_POST['id'];
  $sql = "update leave_year set ly_status='C' where ly_id = '$id' ";
  $result = $conn->query($sql);
} elseif ($_POST['actionLeaveSetup'] == 'addLeaveSetup') {
  $sel_month = $_POST['sel_month'];
  $leaveType = $_POST['sql_lt'];
  $leaveGender = $_POST['lcGender'];
  // if($leaveGender=='B') $
  $leaveValue = $_POST['leaveValue'];
  $lyIdHidden = $_POST['lyIdHidden'];
  $sql = "insert into leave_setup (ls_month, leave_typeid, ls_value, ly_id, ls_gender) values ('$sel_month', '$leaveType', '$leaveValue', '$lyIdHidden', '$leaveGender')";
  $conn->query($sql);
  echo $conn->error;
} elseif ($_POST['actionLeaveForm'] == 'addStaffLeave') {
  $leaveFromDate = $_POST['leaveFromDate'];
  $leaveToDate = $_POST['leaveToDate'];
  $leaveToTime = $_POST['leaveToTime'];
  $leaveFromTime = $_POST['leaveFromTime'];
  $leaveTypeStaff = $_POST['leaveTypeStaff'];
  $leaveReason = $_POST['leaveReason'];
  $submitDate = date("Y-m-d");
  $sql = "insert into leave_ledger (leave_from, leave_to, leave_timeFrom, leave_timeTo, leave_typeid, leave_reason, staff_id, submit_date) values ('$leaveFromDate', '$leaveToDate', '$leaveToTime', '$leaveFromTime', '$leaveTypeStaff', '$leaveReason', '$myId' ,'$submitDate')";
  $conn->query($sql);
  echo $conn->error;
} elseif ($_POST['action'] == 'leaveSetupList') {
  $lt_id = $_POST['lt_id'];
  $sql = "select ls.*, lt.leave_type from leave_setup ls, leave_type lt where lt.leave_typeid=ls.leave_typeid";
  $result = $conn->query($sql);
  $json_array = array();
  while ($rowArray = $result->fetch_assoc()) {
    $json_array[] = $rowArray;
  }
  echo json_encode($json_array);
} elseif ($_POST['action'] == 'leaveDurationList') {
  $sql = "select * from leave_duration";
  $result = $conn->query($sql);
  $json_array = array();
  while ($rowArray = $result->fetch_assoc()) {
    $json_array[] = $rowArray;
  }
  echo json_encode($json_array);
} elseif ($_POST['action'] == 'leaveApplicationList') {
  $sql = "select ll.*, lt.leave_type from leave_ledger ll, leave_type lt where lt.leave_typeid=ll.leave_typeid";
  $result = $conn->query($sql);
  $json_array = array();
  while ($rowArray = $result->fetch_assoc()) {
    $json_array[] = $rowArray;
  }
  echo json_encode($json_array);
} elseif ($_POST['actionSpecialStaffForm'] == 'specialStaff') {
  $staff_id = $_POST['specialStaffIdHidden'];
  $approver_id = $_POST['approverIdHidden'];
  $forwarder_id = $_POST['forwarderIdHidden'];
  $sql = "insert into special_staff (staff_id, approver_id, forwarder_id) values ('$staff_id', '$approver_id', '$forwarder_id')";
  $conn->query($sql);
  echo $conn->error;
} elseif ($_POST['action'] == 'fetchLeaveType') {
  $id = $_POST['ltId'];
  $sql = "SELECT * FROM leave_type where leave_typeid='$id'";
  $result = $conn->query($sql);
  $output = $result->fetch_assoc();
  echo json_encode($output);
}
