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
      $output .= '<li class="list-group-item list-group-item-action autoList" style="z-index: 4;" data-std="' . $row["staff_id"] . '" >' . $row["staff_name"] . '[' . $row["user_id"] . ']</li>';
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
        $sql_insert = "insert into staff_salary (staff_id, mn_id, mn_type, ss_value) values('$id', '$mn_id','0','0')";
        $result_insert = $conn->query($sql_insert);
      }
    }

    $sql = "select * from master_name where mn_code='sld' and mn_status='0' order by mn_remarks ASC";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      while ($rows = $result->fetch_assoc()) {
        $mn_id = $rows["mn_id"];
        $sql_insert = "insert into staff_salary (staff_id, mn_id, mn_type, ss_value) values('$id', '$mn_id','0','0')";
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
  } elseif($_POST['action'] == 'salRepList'){
    $sql = "select st.* from staff st where st.staff_id>1 and st.staff_status='0' order by staff_name";
    $result = $conn->query($sql);
    if ($result) {
      $json_array = array();
      while ($rowsStaff = $result->fetch_assoc()) {
        $subArray=array();

        $subArray["staff_name"] = $rowsStaff["staff_name"];
        $subArray["staff_mobile"] = $rowsStaff["staff_mobile"];
        $subArray["user_id"] = $rowsStaff["user_id"];

        $staff_id=$rowsStaff["staff_id"];
        $sql_ss = "select sum(ss.ss_value) as sum from staff_salary ss, master_name mn where ss.staff_id='$staff_id' and ss.mn_id=mn.mn_id and mn.mn_code='slc'";
        $result_ss = $conn->query($sql_ss);
        if($result_ss){
          $ss = $result_ss->fetch_assoc();
          $subArray["ss"]=$ss["sum"];
        }else $subArray["ss"]=0;
        
        $sql_ss = "select sum(ss.ss_value) as sum from staff_salary ss, master_name mn where ss.staff_id='$staff_id' and ss.mn_id=mn.mn_id and mn.mn_code='sld'";
        $result_ss = $conn->query($sql_ss);
        if($result_ss){
          $ss = $result_ss->fetch_assoc();
          $subArray["ssd"]=$ss["sum"];
        }else $subArray["ssd"]=0;

        $subArray["ss_payable"]=$subArray["ss"]-$subArray["ssd"];

        $json_array[] = $subArray;
      }
      echo json_encode($json_array);
    } else echo $conn->error;
  }
}
