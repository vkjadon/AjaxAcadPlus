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
  } elseif ($_POST['action'] == 'currentOnRollStaff') {
    // Check the Salary Setup Table
    $monthDays = $_POST['monthDays'];
    $salaryMonth = $_POST['salaryMonth'];
    $salaryYear = $_POST['salaryYear'];
    $finYear = data_check($_POST['finYear']);
    $finYearTable = 'staff_salary_setup' . $finYear;
    $sql = "select * from $finYearTable";
    $result = $conn->query($sql);
    if (!$result) {
      //echo "Table Missing $table";
      $query =
        'sss_id INT(6) NOT NULL AUTO_INCREMENT,
      sss_month INT(2) NULL,
      sss_year INT(4) NULL,
      sss_fy VARCHAR(7) NULL,
      sss_days INT(2) NULL,
      sss_remarks VARCHAR(150) NULL,
      update_ts timestamp default current_timestamp(),
      update_id INT(5) NULL,
      sss_status INT(1) NULL,
      PRIMARY KEY (sss_id),
      UNIQUE(sss_month, sss_year)';
      $sql = "CREATE TABLE $finYearTable ($query)";
      $result = $conn->query($sql);
    }

    $sscTable = 'staff_salary_component' . $finYear;
    $sql = "select * from $sscTable";
    $result = $conn->query($sql);
    if (!$result) {
      // echo "Table Missing $table";
      $query =
        'sss_id INT(6) NULL,
      user_id varchar(20) NULL,
      mn_id INT(2) NULL,
      ssc_salary int(7),
      ssc_amount int(7),
      ssc_deduction int(1),
      ssc_remarks VARCHAR(50) NULL,
      update_ts timestamp default current_timestamp(),
      update_id INT(5) NULL,
      ssc_status INT(1) NULL,
      UNIQUE(sss_id, user_id, mn_id)';
      $sql = "CREATE TABLE $sscTable ($query)";
      $result = $conn->query($sql);
    }

    $ssTable = 'staff_salary' . $finYear;
    $sql = "select * from $ssTable";
    $result = $conn->query($sql);
    if (!$result) {
      // echo "Table Missing $table";
      $query =
        'sss_id INT(6) NULL,
      user_id varchar(20) NULL,
      ssal_lwp INT(2) NULL,
      ssal_salary int(7),
      ssal_deduction int(7),
      ssal_payable int(7),
      ssal_remarks VARCHAR(150) NULL,
      update_ts timestamp default current_timestamp(),
      update_id INT(5) NULL,
      ssal_status INT(1) NULL,
      UNIQUE(sss_id, user_id)';
      $sql = "CREATE TABLE $ssTable ($query)";
      $result = $conn->query($sql);
    }

    $sql = "select * from $finYearTable where sss_month='$salaryMonth' and sss_year='$salaryYear'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) $sql_update = "insert into $finYearTable (sss_month, sss_year, sss_fy, sss_days, update_id, sss_status) values('$salaryMonth', '$salaryYear', '$finYear', '$monthDays', '$myId', '0')";
    else $sql_update = "update $finYearTable set sss_days='$monthDays', sss_fy='$finYear' where sss_month='$salaryMonth' and sss_year='$salaryYear'";
    $result = $conn->query($sql_update);
    if (!$result) echo $conn->error;

    $sql = "select st.* from staff st where st.staff_id>1 and st.staff_status='0' order by staff_name";
    $result = $conn->query($sql);
    if ($result) {
      $json_array = array();
      while ($rowsStaff = $result->fetch_assoc()) {
        $subArray = array();

        $staff_id = $rowsStaff["staff_id"];
        $subArray["staff_id"] = $staff_id;

        $subArray["staff_name"] = $rowsStaff["staff_name"];
        $subArray["staff_mobile"] = $rowsStaff["staff_mobile"];

        $user_id = $rowsStaff["user_id"];
        $subArray["user_id"] = $user_id;

        $sql_ss = "select * from $finYearTable where sss_month='$salaryMonth' and sss_year='$salaryYear'";
        $result_ss = $conn->query($sql_ss);
        if ($result_ss) {
          $ss = $result_ss->fetch_assoc();
          $sss_id = $ss["sss_id"];
          $subArray["sss_id"] = $sss_id;
        } else $subArray["sss_id"] = 0;

        $amount = 0;
        $sql_ss = "select sum(ss.ss_value) as sum from staff_salary ss, master_name mn where ss.staff_id='$staff_id' and ss.mn_id=mn.mn_id and mn.mn_code='slc'";
        $result_ss = $conn->query($sql_ss);
        if ($result_ss) {
          $ss = $result_ss->fetch_assoc();
          $amount = $ss["sum"];
          $subArray["ss"] = $amount;
        } else $subArray["ss"] = 0;

        $deduction = 0;
        $sql_ss = "select sum(ss.ss_value) as sum from staff_salary ss, master_name mn where ss.staff_id='$staff_id' and ss.mn_id=mn.mn_id and mn.mn_code='sld'";
        $result_ss = $conn->query($sql_ss);
        if ($result_ss) {
          $ss = $result_ss->fetch_assoc();
          $deduction = $ss["sum"];
          $subArray["ssd"] = $deduction;
        } else $subArray["ssd"] = 0;

        $subArray["ss_payable"] = $subArray["ss"] - $subArray["ssd"];

        $sql_mn = "select ss.*, mn.* from master_name mn, staff_salary ss where ss.staff_id='$staff_id' and ss.mn_id=mn.mn_id and mn.mn_code='slc' order by mn.mn_remarks";
        $result_mn = $conn->query($sql_mn);
        if (!$result_mn) echo $conn->error;
        else {
          while ($rowsMn = $result_mn->fetch_assoc()) {
            $mn_id = $rowsMn['mn_id'];
            $value = $rowsMn['ss_value'];
            $sql_ssc = "insert into $sscTable (sss_id, user_id, mn_id, ssc_amount, ssc_deduction, update_id, ssc_status) values('$sss_id', '$user_id', '$mn_id', '$value', '0', '$myId', '0')";
            $conn->query($sql_ssc);
          }
        }

        $sql_mn = "select ss.*, mn.* from master_name mn, staff_salary ss where ss.staff_id='$staff_id' and ss.mn_id=mn.mn_id and mn.mn_code='sld' order by mn.mn_remarks";
        $result_mn = $conn->query($sql_mn);
        if (!$result_mn) echo $conn->error;
        else {
          while ($rowsMn = $result_mn->fetch_assoc()) {
            $mn_id = $rowsMn['mn_id'];
            $value = $rowsMn['ss_value'];
            $sql_ssc = "insert into $sscTable (sss_id, user_id, mn_id, ssc_amount, ssc_deduction, update_id, ssc_status) values('$sss_id', '$user_id', '$mn_id', '$value', '1', '$myId', '0')";
            $conn->query($sql_ssc);
          }
        }
        $payable = $amount - $deduction;
        $sql_ssc = "insert into $ssTable (sss_id, user_id, ssal_lwp, ssal_salary, ssal_deduction, ssal_payable, update_id, ssal_status) values('$sss_id', '$user_id', '0', '$amount', '$deduction', '$payable', '$myId', '0')";
        $conn->query($sql_ssc);

        $json_array[] = $subArray;
      }
      echo json_encode($json_array);
    } else echo $conn->error;
  } elseif ($_POST['action'] == 'monthlySalary') {
    // Check the Salary Setup Table
    $monthDays = $_POST['monthDays'];
    $salaryMonth = $_POST['salaryMonth'];
    $salaryYear = $_POST['salaryYear'];
    $finYear = data_check($_POST['finYear']);
    $finYearTable = 'staff_salary_setup' . $finYear;
    $ssalTable = 'staff_salary' . $finYear;
    $sscTable = 'staff_salary_component' . $finYear;

    $sql_ss = "select * from $finYearTable where sss_month='$salaryMonth' and sss_year='$salaryYear'";
    $result_ss = $conn->query($sql_ss);
    if ($result_ss) {
      $ss = $result_ss->fetch_assoc();
      $sss_id = $ss["sss_id"];
    }

    $sql = "select st.*, ssal.* from staff st, $ssalTable ssal where st.user_id=ssal.user_id and ssal.sss_id='$sss_id' order by staff_name";
    $result = $conn->query($sql);
    if ($result) {
      $json_array = array();
      while ($rowsStaff = $result->fetch_assoc()) {
        $subArray = array();

        $staff_id = $rowsStaff["staff_id"];
        $subArray["staff_id"] = $staff_id;

        $user_id = $rowsStaff["user_id"];
        $subArray["user_id"] = $user_id;

        $subArray["staff_name"] = $rowsStaff["staff_name"];
        $subArray["staff_mobile"] = $rowsStaff["staff_mobile"];
        $subArray["staff_bank"] = $rowsStaff["staff_bank"];
        $subArray["staff_account"] = $rowsStaff["staff_account"];
        $subArray["staff_ifsc"] = $rowsStaff["staff_ifsc"];

        $subArray["sss_id"] = $rowsStaff["sss_id"];
        $subArray["ssal_lwp"] = $rowsStaff["ssal_lwp"];
        $subArray["ssal_salary"] = $rowsStaff["ssal_salary"];
        $subArray["ssal_deduction"] = $rowsStaff["ssal_deduction"];
        $subArray["ssal_payable"] = $rowsStaff["ssal_payable"];
        $subArray["ssal_remarks"] = $rowsStaff["ssal_remarks"];

        $json_array[] = $subArray;
      }
      echo json_encode($json_array);
    } else echo $conn->error;
  } elseif ($_POST['action'] == 'lwpUpdate') {
    $user_id = $_POST['user_id'];
    $sss_id = $_POST['sss_id'];
    $lwp = $_POST['lwp'];
    $net = $_POST['net'];
    $monthDays = $_POST['monthDays'];
    $finYear = data_check($_POST['finYear']);

    $payable=ceil(($net/$monthDays)*($monthDays-$lwp));

    $ssalTable = 'staff_salary' . $finYear;
    $sscTable = 'staff_salary_component' . $finYear;
    
    $sql="update $ssalTable set ssal_lwp='$lwp', ssal_payable='$payable' where user_id='$user_id' and sss_id='$sss_id'";
    $conn->query($sql);
    echo $payable;

  }
}
