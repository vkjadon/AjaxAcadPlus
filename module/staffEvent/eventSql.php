<?php
require('../requireSubModule.php');

//echo $_POST['action'];
/*
0 - Saved
1 - Load/Duty Adjusted
2 - Additional Recommendation Requested (multiple)
3 - Additional Recommendation Received (All)
4 - Forwarded
5 - Approved
7 - Rejected by Forwarder
8 - Rejected by Approver
9 - Withdrwan

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
  $output = '<ul class="list-group p-0 m-0">';
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
if ($_POST['action'] == 'addLeaveType') {
  echo "MyId- $myId";
  $carry = $check = '0';
  if (isset($_POST['leave_carry'])) $carry = '1';
  if (isset($_POST['leave_check'])) $check = '1';

  echo $Id = $_POST['leaveId'];

  // $sql="select * from leave_type where lt_name='" . data_check($_POST['leave_name']) . "'";
  // $rowsFound=$conn->query($sql)->num_rows;
  // echo "Found $rowsFound";

  if ($Id == 0) $sql = "insert into leave_type (lt_name, lt_abbri, lt_male, lt_female, lt_monthly, lt_check, lt_carry, lt_max, update_id, lt_status) values('" . data_check($_POST['leave_name']) . "', '" . data_check($_POST['leave_abbri']) . "', '" . data_check($_POST['leave_male']) . "', '" . data_check($_POST['leave_female']) . "', '" . data_check($_POST['leave_monthly']) . "', '$check', '$carry', '" . data_check($_POST['leave_max']) . "', '$myId', '0')";

  else $sql = "update leave_type set lt_name='" . data_check($_POST['leave_name']) . "', lt_abbri='" . data_check($_POST['leave_abbri']) . "', lt_male='" . data_check($_POST['leave_male']) . "',  lt_female='" . data_check($_POST['leave_female']) . "', lt_monthly='" . data_check($_POST['leave_monthly']) . "', lt_check='$check', lt_carry='$carry', lt_max='" . data_check($_POST['leave_max']) . "' where lt_id='$Id'";

  $result = $conn->query($sql);
  if (!$result) $conn->error;
} elseif ($_POST['action'] == 'leaveTypeList') {
  $sql = "select * from leave_type";
  $result = $conn->query($sql);
  $json_array = array();
  while ($rowArray = $result->fetch_assoc()) {
    $json_array[] = $rowArray;
  }
  echo json_encode($json_array);
} elseif ($_POST['action'] == 'updateLT') {
  $field = $_POST['field'];
  $text = $_POST['text'];
  echo "Field $field Text $text ";
  $sql = "update leave_type set $_POST[field]='" . $_POST['text'] . "' where lt_id='" . $_POST['id'] . "'";
  $result = $conn->query($sql);
  if (!$result) echo $conn->error;
} elseif ($_POST['action'] == 'fetchLeaveType') {
  $id = $_POST['ltId'];
  $sql = "SELECT  * FROM leave_type where lt_id='$id'";
  $result = $conn->query($sql);
  $output = $result->fetch_assoc();
  echo json_encode($output);
} elseif ($_POST['action'] == 'leaveYearList') {
  $sql = "select * from leave_year order by ly_from desc";
  $result = $conn->query($sql);
  $json_array = array();
  while ($rowArray = $result->fetch_assoc()) {
    $json_array[] = $rowArray;
  }
  echo json_encode($json_array);
} elseif ($_POST['action'] == 'addLeaveYear') {
  $ly_from = $_POST['ly_from'];
  $ly_to = $_POST['ly_to'];
  $ly_id = $_POST['lyId'];

  if ($ly_id == '0') $sql = "insert into leave_year (ly_from, ly_to, update_id, ly_status) values ('$ly_from', '$ly_to', '$myId', '0')";
  else $sql = "update leave_year set ly_from='$ly_from', ly_to='$ly_to' where ly_id='$ly_id'";
  $result = $conn->query($sql);
  if (!$result) echo $conn->error;
} elseif ($_POST['action'] == 'fetchLeaveYear') {
  $id = $_POST['lyId'];
  $sql = "SELECT  * FROM leave_year where ly_id='$id'";
  $result = $conn->query($sql);
  $output = $result->fetch_assoc();
  echo json_encode($output);
} elseif ($_POST['action'] == 'setCurrentLeaveYear') {
  $sql = "update leave_year set ly_status='A'";
  $result = $conn->query($sql);
  $id  = $_POST['id'];
  $sql = "update leave_year set ly_status='C' where ly_id = '$id' ";
  $result = $conn->query($sql);
} elseif ($_POST['action'] == 'addLeaveSetup') {
  $lcr_year = $_POST['lsYear'];
  $lcr_month = $_POST['sel_month'];
  $lt_id = $_POST['leave_type'];
  $lcr_male = $_POST['lsMale'];
  $lcr_female = $_POST['lsFemale'];
  $lcr_id = $_POST['lsId'];
  if ($lcr_id == 0) $sql = "insert into leave_credit (lcr_year, lcr_month, lt_id, lcr_male, lcr_female, update_id, lcr_status) values ('$lcr_year', '$lcr_month', '$lt_id', '$lcr_male', '$lcr_female', '$myId', '0')";
  else $sql = "update leave_credit set lcr_year='$lcr_year', lcr_month='$lcr_month', lt_id='$lt_id',  lcr_male='$lcr_male',  lcr_female='$lcr_female', update_id='$myId' where lcr_id='$lcr_id'";
  $result=$conn->query($sql);
  if(!$result)echo $conn->error;
} elseif ($_POST['action'] == 'leaveSetupList') {
  $sql = "select lcr.*, lt.lt_name from leave_credit lcr, leave_type lt where lt.lt_id=lcr.lt_id order by lcr_year desc, lcr_month desc";
  $result = $conn->query($sql);
  $json_array = array();
  while ($rowArray = $result->fetch_assoc()) {
    $json_array[] = $rowArray;
  }
  echo json_encode($json_array);
} elseif ($_POST['action'] == 'fetchLeaveSetup') {
  $id = $_POST['lsId'];
  $sql = "select lcr.*, lt.* FROM leave_credit lcr, leave_type lt where lt.lt_id=lcr.lt_id and lcr.lcr_id='$id'";
  $result = $conn->query($sql);
  $output = $result->fetch_assoc();
  echo json_encode($output);
} elseif ($_POST['action'] == 'addLeave') {
  $ll_from = date("Y-m-d H:i:s", strtotime($_POST['leaveFrom']));
  $ll_to = date("Y-m-d H:i:s", strtotime($_POST['leaveTo']));
  $ll_days = $_POST['leaveDays'];
  $lt_id = $_POST['sel_lt'];
  $ll_reason = $_POST['leaveReason'];
  if (isset($_POST['sel_staff'])) $staff_id = isset($_POST['sel_staff']);
  else $staff_id = $myId;
  echo $ll_from;
  //echo ' Date '.date("d-m-Y", strtotime($ll_from)).' Time '.date("h-i", strtotime($ll_from));
  $sql = "insert into $tn_ll (staff_id, lt_id, ll_from, ll_to, ll_days, ll_reason, update_id, ll_status) values ('$staff_id', '$lt_id', '$ll_from', '$ll_to', '$ll_days', '$ll_reason', '$myId' ,'0')";
  $result = $conn->query($sql);
  if (!$result) $conn->error;
} elseif ($_POST['action'] == 'leaveApplicationList') {
  $sql = "select ll.*, lt.lt_name, s.staff_name, s.user_id from $tn_ll ll, leave_type lt, staff s where lt.lt_id=ll.lt_id and ll.staff_id=s.staff_id";
  $result = $conn->query($sql);
  $json_array = array();
  while ($rowArray = $result->fetch_assoc()) {
    $json_array[] = $rowArray;
  }
  echo json_encode($json_array);
} elseif ($_POST['action'] == 'leaveBalance') {
  $sql = "select sum(lcr.lcr_male) as sum, lt.* from leave_credit lcr, leave_type lt where lt.lt_id=lcr.lt_id group by lt.lt_id";
  $result = $conn->query($sql);
  $data = array();
  if ($result) {
    while ($rowsArray = $result->fetch_assoc()) {
      $subArray = array();
      $subArray["lt_name"] = $rowsArray["lt_name"];
      $subArray["lcr_male"] = $rowsArray["sum"];
      $data[] = $subArray;
    }
  }
  $jsonOutput = json_encode($data);
  echo $jsonOutput;
} elseif ($_POST['action'] == 'addCPL') {
  $lc_date = $_POST['cplDate'];
  $lc_order = $_POST['cplOrder'];
  $lc_reason = $_POST['cplReason'];
  if (isset($_POST['sel_staff'])) $staff_id = isset($_POST['sel_staff']);
  else $staff_id = $myId;

  echo $lc_date;
  //echo ' Date '.date("d-m-Y", strtotime($ll_from)).' Time '.date("h-i", strtotime($ll_from));
  $sql = "insert into $tn_lc (lc_date, lc_order, lc_reason, staff_id, update_id, lc_status) values ('$lc_date', '$lc_order', '$lc_reason', '$staff_id' , '$myId' , '0')";
  $result = $conn->query($sql);
  if (!$result) $conn->error;
} elseif ($_POST['action'] == 'cplList') {
  $sql = "select lc.*, s.staff_name, s.user_id from $tn_lc lc, staff s where lc.staff_id=s.staff_id order by update_ts desc";
  $result = $conn->query($sql);
  $json_array = array();
  while ($rowArray = $result->fetch_assoc()) {
    $json_array[] = $rowArray;
  }
  echo json_encode($json_array);
} elseif ($_POST['action'] == 'specialStaff') {
  $staff_id = $_POST['specialStaffIdHidden'];
  $approver_id = $_POST['approverIdHidden'];
  $forwarder_id = $_POST['forwarderIdHidden'];
  $sql = "insert into special_staff (staff_id, approver_id, forwarder_id) values ('$staff_id', '$approver_id', '$forwarder_id')";
  $conn->query($sql);
  echo $conn->error;
} elseif ($_POST['action'] == 'lrDetails') {
  $sql = "select ll.*, lt.lt_name, s.staff_name, s.user_id from $tn_ll ll, leave_type lt, staff s where lt.lt_id=ll.lt_id and ll.staff_id=s.staff_id and ll.ll_id='" . $_POST['ll_id'] . "'";
  $result = $conn->query($sql);
  $rowArray = $result->fetch_assoc();
  echo json_encode($rowArray);
} elseif ($_POST['action'] == 'llStatusUpdate') {
  $id = $_POST['modalId'];
  $status = $_POST['llStatus'];
  $comments = $_POST['comments'];
  $reason = getField($conn, $id, $tn_ll, "ll_id", "ll_reason");
  $reason=$reason.' '.$comments;
  $sql = "update $tn_ll set ll_reason='$reason', update_ts='$submit_ts', ll_status='$status' where ll_id='$id'";
  $result = $conn->query($sql);
} elseif ($_POST['action'] == 'delete') {
  echo "MyId- $myId";
  $update_ts = time();

  $sql = "update leave_ccf set lccf_status='1' where lccf_id='" . $_POST["deleteId"] . "'";
  $result = $conn->query($sql);
}
