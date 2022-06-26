<?php
require('../../module/requireSubModule.php');
// echo $_POST['action'];
if (isset($_POST["query"])) {
  $output = '';
  $sql = "select s.staff_id, s.staff_name, s.user_id from staff s where s.staff_name LIKE '%" . $_POST["query"] . "%' and s.staff_status='0'";
  $result = $conn->query($sql);
  $output = '<ul class="list-group">';
  if ($result) {
    while ($row = $result->fetch_assoc()) {
      $output .= '<li class="list-group-item list-group-item-action autoList" data-std="' . $row["staff_id"] . '" >[' . $row["user_id"] . ']' . $row["staff_name"] . '</li>';
    }
  } else {
    $output .= '<li>Staff Not Found</li>';
  }
  $output .= '</ul>';
  echo $output;
}
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'fetchStaffAutoList') {
    $id = $_POST['userId'];

    $sql = "select * from master_name where mn_code='slc' and mn_status='0' order by mn_remarks ASC";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      while ($rows = $result->fetch_assoc()) {
        $mn_id = $rows["mn_id"];
        $sql_insert = "insert into staff_salary (staff_id, mn_id, mn_type, ss_value, ss_percent, ss_daily) values('$id', '$mn_id','0','0','0','1')";
        $result_insert = $conn->query($sql_insert);
      }
    }

    $sql = "select * from master_name where mn_code='sld' and mn_status='0' order by mn_remarks ASC";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      while ($rows = $result->fetch_assoc()) {
        $mn_id = $rows["mn_id"];
        $sql_insert = "insert into staff_salary (staff_id, mn_id, mn_type, ss_value, ss_percent, ss_daily) values('$id', '$mn_id','0','0', '0', '1')";
        $result_insert = $conn->query($sql_insert);
      }
    }

    $sql = "select st.* from staff st where st.staff_id='$id' and st.staff_status='0'";
    $result = $conn->query($sql);
    if ($result) {
      $output = $result->fetch_assoc();
      echo json_encode($output);
    } else echo $conn->error;
  } elseif ($_POST['action'] == 'fetchStaff') {
    $id = $_POST['userId'];
    $sql = "select st.* from staff st where st.staff_id='$id' and st.staff_status='0'";
    $result = $conn->query($sql);
    if ($result) {
      $output = $result->fetch_assoc();
      echo json_encode($output);
    } else echo $conn->error;
  } elseif ($_POST["action"] == "ssList") {
    //echo "MyId- $myProg - $myBatch";
    $sql = "select * from staff_service where staff_id='" . $_POST['staff_id'] . "' order by ss_from_date desc";
    $result = $conn->query($sql);
    echo '<table class="table list-table-xs">';
    if ($result->num_rows > 0) {
      while ($row_ss = $result->fetch_assoc()) {
        $ss_id = $row_ss["ss_id"];
        $status = $row_ss["ss_status"];
        echo '<tr>';
        echo '<td>';
        echo '<a href="#" class="ssE" data-id="' . $ss_id . '"><i class="fa fa-edit"></i></a>';
        echo ' [' . $ss_id . ']';
        echo '</td';
        echo '<td>' . getField($conn, $row_ss["staff_id"], "staff", "staff_id", "staff_name") . '</td>';
        echo '<td>' . getField($conn, $row_ss["school_id"], "school", "school_id", "school_name") . '</td>';
        echo '<td>' . getField($conn, $row_ss["dept_id"], "department", "dept_id", "dept_name") . '</td>';
        echo '<td>' . getField($conn, $row_ss["designation_id"], "master_name", "mn_id", "mn_name") . '</td>';
        echo '<td>' . date("d-m-Y", strtotime($row_ss["ss_from_date"])) . '</td>';
        echo '<td>' . date("d-m-Y", strtotime($row_ss["ss_to_date"])) . '</td>';
        echo '<td>' . $row_ss["ss_order"] . '</td>';
        echo '<td>' . date("d-m-Y", strtotime($row_ss["ss_order_date"])) . '</td>';
        echo '<td>';
        if ($status == "9") echo '<a href="#" class="ssR" data-id="' . $ss_id . '">Removed</a>';
        elseif ($status == "1")  echo '<a href="#" class="ssC" data-id="' . $ss_id . '">Set Currect</a>';
        else echo '<a href="#" class="ssD" data-id="' . $ss_id . '"><i class="fa fa-trash"></i></a>';
        echo '</td>';
        echo '<td>';
        echo '<a href="#" class="ssSetSalary" data-id="' . $ss_id . '">Set Salary</a>';
        echo '</td>';
        echo '</tr>';
      }
      echo '</table>';
    } else echo '<p class="largeText">No Record Found !!</p>';
  } elseif ($_POST["action"] == "ssInsert") {
    $sql = "insert into staff_service (staff_id, school_id, dept_id, designation_id, ss_from_date, ss_to_date, ss_order, ss_order_date, ss_remarks, update_ts, update_id, ss_status) values('" . $_POST["staffId"] . "', '" . $_POST["school_id"] . "', '" . $_POST["dept_id"] . "', '" . $_POST["mn_id"] . "', '" . $_POST["ss_from_date"] . "', '" . $_POST["ss_to_date"] . "', '" . $_POST["ss_order"] . "', '" . $_POST["ss_order_date"] . "', '" . $_POST["ss_remarks"] . "', '$submit_ts', '$myId', '1')";
    if (!$conn->query($sql)) echo $conn->error;
    else echo "Added in Service Book";
  } elseif ($_POST["action"] == "ssUpdate") {
    $sql = "update staff_service set school_id='" . $_POST["school_id"] . "', dept_id='" . $_POST["dept_id"] . "', designation_id='" . $_POST["mn_id"] . "', ss_from_date='" . $_POST["ss_from_date"] . "', ss_to_date='" . $_POST["ss_to_date"] . "',  ss_order='" . $_POST["ss_order"] . "', ss_order_date='" . $_POST["ss_order_date"] . "', ss_remarks='" . $_POST["ss_remarks"] . "', update_ts='$submit_ts', update_id='$myId' where ss_id='" . $_POST["ss_id"] . "'";
    if (!$conn->query($sql)) echo $conn->error;
    else echo "Updated !! ";
  } elseif ($_POST["action"] == "ssFetch") {
    $id = $_POST['ss_id'];
    $sql = "select * FROM staff_service where ss_id='$id'";
    $result = $conn->query($sql);
    $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST['action'] == 'salaryComponents') {
    $id = $_POST['userId'];
    $sql = "select ss.*, mn.* from master_name mn, staff_salary ss where ss.staff_id='$id' and ss.mn_id=mn.mn_id and mn.mn_code='slc' order by mn.mn_remarks";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      while ($rowsStaff = $result->fetch_assoc()) {
        $json_array[] = $rowsStaff;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'salaryDeductions') {
    $id = $_POST['userId'];
    $sql = "select ss.*, mn.* from master_name mn, staff_salary ss where ss.staff_id='$id' and ss.mn_id=mn.mn_id and mn.mn_code='sld' order by mn.mn_remarks";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      while ($rowsStaff = $result->fetch_assoc()) {
        $json_array[] = $rowsStaff;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'staffSalary') {
    $id = $_POST['userId'];
    $mn_id = $_POST['mn_id'];
    $tag = $_POST['tag'];
    $value = $_POST['value'];
    $sql = "update staff_salary set $tag='$value' where staff_id='$id' and mn_id='$mn_id'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else echo "Updated $tag=$value where staff = $id and mn_id=$mn_id";
  } elseif ($_POST['action'] == 'staffSalaryDeduction') {
    $id = $_POST['userId'];
    $mn_id = $_POST['mn_id'];
    $tag = $_POST['tag'];
    $value = $_POST['value'];
    $sql = "update staff_salary set $tag='$value' where staff_id='$id' and mn_id='$mn_id'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else echo "Updated $tag=$value where staff = $id and mn_id=$mn_id";
  } elseif ($_POST['action'] == 'percentBasic') {
    $id = $_POST['userId'];
    $mn_id = $_POST['mn_id'];
    $tag = $_POST['tag'];
    $value = $_POST['value'];
    $sql = "update staff_salary set $tag='$value' where staff_id='$id' and mn_id='$mn_id'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else echo "Updated $tag=$value where staff = $id and mn_id=$mn_id";
  } elseif ($_POST['action'] == 'calculatedDaily') {
    $id = $_POST['userId'];
    $mn_id = $_POST['mn_id'];
    $tag = $_POST['tag'];
    $value = $_POST['value'];
    $sql = "update staff_salary set $tag='$value' where staff_id='$id' and mn_id='$mn_id'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else echo "Updated $tag=$value where staff = $id and mn_id=$mn_id";
  } elseif ($_POST['action'] == 'salRepList') {
    $sql = "select st.* from staff st where st.staff_id>1 and st.staff_status='0' order by staff_name";
    $result = $conn->query($sql);
    if ($result) {
      $json_array = array();
      while ($rowsStaff = $result->fetch_assoc()) {
        $subArray = array();

        $subArray["staff_name"] = $rowsStaff["staff_name"];
        $subArray["staff_mobile"] = $rowsStaff["staff_mobile"];
        $subArray["user_id"] = $rowsStaff["user_id"];

        $staff_id = $rowsStaff["staff_id"];
        $sql_ss = "select sum(ss.ss_value) as sum from staff_salary ss, master_name mn where ss.staff_id='$staff_id' and ss.mn_id=mn.mn_id and mn.mn_code='slc'";
        $result_ss = $conn->query($sql_ss);
        if ($result_ss) {
          $ss = $result_ss->fetch_assoc();
          $subArray["ss"] = $ss["sum"];
        } else $subArray["ss"] = 0;

        $sql_ss = "select sum(ss.ss_value) as sum from staff_salary ss, master_name mn where ss.staff_id='$staff_id' and ss.mn_id=mn.mn_id and mn.mn_code='sld'";
        $result_ss = $conn->query($sql_ss);
        if ($result_ss) {
          $ss = $result_ss->fetch_assoc();
          $subArray["ssd"] = $ss["sum"];
        } else $subArray["ssd"] = 0;

        $subArray["ss_payable"] = $subArray["ss"] - $subArray["ssd"];

        $json_array[] = $subArray;
      }
      echo json_encode($json_array);
    } else echo $conn->error;
  }
}
