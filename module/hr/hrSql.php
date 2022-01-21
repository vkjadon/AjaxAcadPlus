<?php
require('../requireSubModule.php');

//echo $_POST['action'];
if (isset($_POST["query"])) {
  $output = '';
  $sql = "select * from staff where staff_name LIKE '%" . $_POST["query"] . "%'";
  $result = $conn->query($sql);
  $output = '<ul class="list-group">';
  if ($result) {
    while ($row = $result->fetch_assoc()) {
      $output .= '<li class="list-group-item list-group-item-action autoList" data-std="' . $row["staff_id"] . '" >' . $row["staff_name"] . '</li>';
    }
  } else {
    $output .= '<li>Staff Not Found</li>';
  }
  $output .= '</ul>';
  echo $output;
}
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'staffList') {
    $sql = "SELECT s.* from staff s where s.staff_status='0' order by s.staff_name";
    $json = getTableRow($conn, $sql, array("staff_id", "staff_name", "staff_mobile", "staff_email", "user_id"));
    // echo $json;
    $array = json_decode($json, true);
    $count = count($array["data"]);
    //  echo $count;
    for ($i = 0; $i < count($array["data"]); $i++) {
      $staff_id = $array["data"][$i]["staff_id"];
      $staff_name = $array["data"][$i]["staff_name"];
      $staff_mobile = $array["data"][$i]["staff_mobile"];
      $staff_email = $array["data"][$i]["staff_email"];
      $user_id = $array["data"][$i]["user_id"];

      $sql = "SELECT * from user where staff_id='$staff_id'";
      $result = $conn->query($sql);
      echo '<div class="card">';
      echo '<div class="row m-1">';
      echo '<div class="col-10"><h7 class="card-title">' . $staff_name . '</h7>[<span class="card-subtitle mb-2 text-muted">' . $user_id . '</span>]</div>';
      echo '<div class="col-1 p-0">';
      if ($result->num_rows > 0)  echo '<a href="#" class="fa fa-minus removeUser" data-id="' . $staff_id . '"></a></div>';
      else echo '<a href="#" class="fa fa-plus addUser" data-id="' . $staff_id . '"></a></div>';
      echo '<div class="col-1 p-0"><a href="#" class="fa fa-edit editStaff" data-staff="' . $staff_id . '"></a></div>';
      echo '</div>';
      echo '</div>';
    }
  } elseif ($_POST['action'] == 'addStaff') {

    $sql = "insert into staff (school_id, staff_name, staff_doj, staff_mobile, staff_email, update_id, staff_status) value('$myScl', '" . data_check($_POST['sName']) . "', '" . data_check($_POST['sDoj']) . "', '" . data_check($_POST['sMobile']) . "', '" . data_check($_POST['sEmail']) . "', '$myId', '0')";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $staff_id = $conn->insert_id;
      $user_id = 80000 + $staff_id;
      $user_id = 'AG' . $user_id;
      $sql = "update staff set user_id='$user_id' where staff_id='$staff_id'";
      $result = $conn->query($sql);
    }
  } elseif ($_POST['action'] == 'fetchStaff') {
    $id = $_POST['staffId'];
    $sql = "select * FROM staff where staff_id='$id'";
    $result = $conn->query($sql);
    $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST['action'] == 'updateStaff') {
    $id_name = $_POST['id_name'];
    $id = $_POST['id'];
    $tag = $_POST['tag'];
    $value = $_POST['value'];
    $sql = "update staff set $tag='$value' where $id_name='$id'";
    $conn->query($sql);
    echo $conn->error;
  } elseif ($_POST['action'] == 'addDetails') {
    $std_id = $_POST['modalId'];
    $sql = "insert into student_details (student_id, sd_fname, sd_mname, sd_foccupation, sd_fdesignation, sd_dob, sd_gender, sd_category) values ('$_POST[modalId]', '$_POST[fName]', '$_POST[mName]', '$_POST[fOccupation]', '$_POST[fDes]', '$_POST[sDob]', '$_POST[sGender]', '$_POST[sCategory]')";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else echo " Success";
    if (!$result) {
      $update = "update student_details set sd_fname='$_POST[fName]', sd_mname='$_POST[mName]', sd_foccupation='$_POST[fOccupation]',sd_fdesignation='$_POST[fDes]', sd_dob='$_POST[sDob]', sd_gender='$_POST[sGender]', sd_category='$_POST[sCategory]' where student_id = '$std_id'";
      $conn->query($update);
    }
    echo "New record updated successfully";
  } elseif ($_POST['action'] == 'fetchStaffDetails') {
    $id = $_POST['studentId'];
    $sql = "select * from staff_details where staff_id='$id'";
    $result = $conn->query($sql);
    $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST['action'] == 'addStaffQualification') {
    $stf_id = $_POST['stfIdModal'];
    $sql = "insert into staff_qualification (staff_id, qualification_id, stq_institute, stq_board, stq_year, stq_marksObtained, stq_marksMax, stq_percentage) values ('$_POST[stfIdModal]', '$_POST[sel_qual]', '$_POST[sInst]', '$_POST[sBoard]', '$_POST[sYear]', '$_POST[sMarksObt]', '$_POST[sMaxMarks]', '$_POST[sCgpa]')";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else echo "Success";
  } elseif ($_POST['action'] == 'staffQualificationList') {
    $stfId = $_POST['stfId'];
    // echo "$stfId";

    $sql = "select sq.*, mn.mn_name from staff_qualification sq, master_name mn where mn.mn_id=sq.mn_id and sq.staff_id='$stfId'";

    echo '<table class="list-table-xs">';
    echo '<thead><th><i class="fa fa-edit"></i></th>';
    echo '<th>Qualification</th>';
    echo '<th>Institute</th>';
    echo '<th><i class="fa fa-trash"></i></th>';
    echo '</thead>';
    $result = $conn->query($sql);
    if (!$result) {
      echo $conn->error;
      die(" The script could not be Loadded! Please report!");
    }
    while ($rows = $result->fetch_assoc()) {
      $staff_id = $rows['staff_id'];
      $mn_id = $rows['mn_id'];
      echo '<tr>';
      echo '<td><a href="#" class="editSQ" data-staff="' . $staff_id . '" data-mn="' . $mn_id . '"><i class="fa fa-edit"></i></a></td>';
      echo '<td>' . $rows['sq_institute'] . '</td>';
      echo '<td>' . $rows['sq_board'] . '</td>';
      echo '<td>' . $rows['sq_year'] . '</td>';
      echo '<td><a href="#" class="trashSQ" data-staff="' . $staff_id . '" data-mn="' . $mn_id . '"><i class="fa fa-trash"></i></a></td>';
      echo '</tr>';
    }
    echo '</table>';
  } elseif ($_POST['action'] == 'updateStaffQualification') {
    $id_name = $_POST['id_name'];
    $staff_id = $_POST['staff_id'];
    $id = $_POST['id'];
    $tag = $_POST['tag'];
    $value = $_POST['value'];
    $sql = "update staff_qualification set $tag='$value' where $id_name='$id' and staff_id='$staff_id'";
    $result = $conn->query($sql);
    $affectedRows = $conn->affected_rows;
    echo "affected rows $affectedRows";
    if (!$result) echo $conn->error;
    elseif ($affectedRows == 0) {
      $sql = "insert into staff_qualification (staff_id, qualification_id, $tag) values ('$staff_id','$id', '$value')";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
    } else "Updated";
  } elseif ($_POST['action'] == 'fetchStaffQualification') {
    $stq_id = $_POST['stqId'];
    $sql = "select * FROM staff_qualification where stq_id='$stq_id'";
    $result = $conn->query($sql);
    $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST['action'] == 'staffServiceList') {
    $staff_id = $_POST['staffId'];
    // echo "Staff $staff_id";
    $sql = "SELECT * from staff_service where staff_id='$staff_id'";
    $json = getTableRow($conn, $sql, array("ss_from", "dept_id", "designation_id", "ss_order"));
    // echo $json;
    $array = json_decode($json, true);
    $count = count($array["data"]);
    // echo $count;
    echo '<table class="list-table-xs">
   <thead align="center">
   <table class="list-table-xs">
   <thead align="center"><th>Department</th><th>Designation</th><th>With Effect From</th><th>Order Number</th>
   <th><i class="fa fa-trash"></i></th>
   </thead>';
    for ($i = 0; $i < count($array["data"]); $i++) {
      $ss_from = $array["data"][$i]["ss_from"];
      $dept_id = $array["data"][$i]["dept_id"];
      $desig_id = $array["data"][$i]["designation_id"];
      $ss_order = $array["data"][$i]["ss_order"];
      $sql_desig = "select * from designation where designation_id='$desig_id'";
      $value_desig = getFieldValue($conn, "designation_name", $sql_desig);
      $sql_dept = "select * from department where dept_id='$dept_id'";
      $value_dept = getFieldValue($conn, "dept_name", $sql_dept);
      echo '<tr><td>' . $value_dept . '</td><td>' . $value_desig . '</td><td>' . $ss_from . '</td><td>' . $ss_order . '</td><td><i class="fa fa-trash deleteStaffService"></i></td></tr>';
    }
    echo '</table></table>';
  } elseif ($_POST['action'] == 'addStaffService') {
    $staff_id = $_POST['stfIdService'];
    if (!$_POST['sel_dept'] == NULL && !$_POST['sel_desig'] == NULL && !$_POST['sOrderNo'] == NULL && !$_POST['sWef'] == NULL) {
      $sql = "insert into staff_service (staff_id, dept_id, designation_id, ss_order , ss_from, ss_status) values('$staff_id', '" . $_POST['sel_dept'] . "','" . $_POST['sel_desig'] . "' ,'" . $_POST['sOrderNo'] . "','" . $_POST['sWef'] . "','1')";
      $result = $conn->query($sql);
      if ($result) echo "Added Successfully";
      else {
        $error = $conn->errno;
      }
    } else echo "No Field should be Blank";
  } elseif ($_POST['action'] == 'addUser') {
    $id = $_POST['id'];
    $mail = getField($conn, $id, "staff", "staff_id", "staff_email");
    $password = $myDb.$id;
    $encripted = sha1($password);
    $sql = "insert into user (staff_id, user_password, user_status) values ('$id', '$encripted', '0')";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $subject = "Registration successful as User";
      $message = '<html><head><title>HTML email</title></head>
      <body>
      <h4>Registration Successful.</h4>
      <h5>Your password is ' . $password . '</h5>
      <h4>Regards</h4>
      </body>
      </html>';

      // Always set content-type when sending HTML email
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

      // More headers
      $headers .= 'From: <info@classconnect.in>';
      mail($mail, $subject, $message, $headers);
      echo "Staff Added as User. The password is sent to registered email [" . $mail . "].";
    }
  } elseif ($_POST['action'] == 'removeUser') {
    $id = $_POST['id'];
    $sql = "delete from user where staff_id='$id'";
    $conn->query($sql);
    echo $conn->error;
  }
}
