<?php
require('../../module/requireSubModule.php');
// echo $_POST['action'];
if (isset($_POST["query"])) {
  $output = '';
  $sql = "select s.student_id, s.student_name, sd.student_fname, b.batch, student_rollno from student s, student_detail sd, batch b where (s.student_name LIKE '%" . $_POST["query"] . "%' or s.student_rollno LIKE '%" . $_POST["query"] . "%' )and s.student_id=sd.student_id and s.ay_id=b.batch_id and s.student_status='0' and s.program_id>0";
  $result = $conn->query($sql);
  $output = '<ul class="list-group">';
  if ($result) {
    while ($row = $result->fetch_assoc()) {
      $output .= '<li class="list-group-item list-group-item-action autoList" style="z-index: 4;" data-std="' . $row["student_id"] . '" >' . $row["student_name"] . ' [' . $row["student_fname"] . ']' . $row["batch"] . '[' . $row["student_rollno"] . ']</li>';
    }
  } else {
    $output .= '<li>Student Not Found</li>';
  }
  $output .= '</ul>';
  echo $output;
}
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'fetchStudentAutoList') {
    $id = $_POST['userId'];
    $sql = "select st.*, sd.*, sa.*, sr.*, b.batch, p.program_name from student st, student_detail sd, student_address sa, student_reference sr, batch b, program p where st.batch_id=b.batch_id and st.student_id='$id' and st.program_id=p.program_id and st.student_id=sd.student_id and st.student_id=sa.student_id and st.student_id=sr.student_id and st.student_status='0'";
    $result = $conn->query($sql);
    $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST['action'] == 'fetchStudent') {
    $id = $_POST['userId'];
    $sql = "select st.*, sd.*, b.batch, p.program_name from student st, student_detail sd, batch b, program p where st.batch_id=b.batch_id and st.user_id='$id' and st.program_id=p.program_id and st.student_id=sd.student_id";
    $output = array();
    $result = $conn->query($sql)->fetch_assoc();
    $output["student_name"] = $result["student_name"];
    $output["student_image"] = $result["student_image"];
    $output["student_fname"] = $result["student_fname"];
    $output["student_rollno"] = $result["student_rollno"];
    $output["student_id"] = $result["student_id"];
    $output["student_mobile"] = $result["student_mobile"];
    $output["batch"] = $result["batch"];
    $output["program_name"] = $result["program_name"];
    $output["fcg"] = $result["student_fee_category"];
    $output["ay"] = getField($conn, $result["ay_id"], "batch", "batch_id", "batch");

    echo json_encode($output);
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
  } elseif ($_POST['action'] == 'feeMode') {
    $sql = "select * from master_name where mn_code='fm' and mn_status='0' order by mn_name ASC";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      while ($rowsStudent = $result->fetch_assoc()) {
        $json_array[] = $rowsStudent;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'addFeeReceipt') {
    // echo " Add Fee ";
    $student_id = $_POST['id'];
    $t_id = $_POST['tId'];
    $transaction_date = $_POST['transaction_date'];
    $ft = $_POST['feeType'];
    $fm = $_POST['feeMode'];
    $sem = $_POST['sem'];
    $fee = $_POST['feeAmount'];
    $fr_bank = $_POST['fr_bank'];
    $feeDesc = data_clean($_POST['feeDesc']);
    $feeDate = $_POST['fr_date'];
    $fr_sno = $_POST['fr_sno'];
    // echo "$student_id $ft";
    $time = gmdate("Y/m/d H:i:s", time());
    if ($myId > 0) {
      $sql = "insert into fee_receipt (fr_sno, fee_type, fr_date, student_id, fee_mode, fee_semester, fr_amount, transaction_id, transaction_date, fr_bank, fr_desc, update_ts, update_id, fr_status) values ('$fr_sno', '$ft', '$feeDate', '$student_id', '$fm', '$sem', '$fee','$t_id', '$transaction_date', '$fr_bank', '$feeDesc', '$time', '$myId', '0')";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else echo "Fee Successfully Added";
    } else echo "Session Time Out !! Please logout and login Again";
  } elseif ($_POST['action'] == 'addFeeReverse') {
    // echo " Add Fee ";
    $id = $_POST['id'];
    $frev_desc = $_POST['frev_desc'];
    // echo "$student_id $ft";
    if ($myId > 0) {
      $sql = "insert into fee_reverse (fr_id, frev_desc, update_id, frev_status) values ('$id', '$frev_desc', '$myId', '0')";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else echo "Entry Reversed";
    } else echo "Session Time Out !! Please logout and login Again";
  } elseif ($_POST['action'] == 'feeReceiptList') {
    $student_id = $_POST['id'];
    $sql = "select fr.*, mn.mn_name from fee_receipt fr, master_name mn where fr.student_id='$student_id' and mn.mn_id=fr.fee_type and fr.fr_status='0' order by fr.fr_id";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      $subArray = array();
      while ($rowsFee = $result->fetch_assoc()) {
        $subArray["fr_id"] = $rowsFee["fr_id"];
        $subArray["semester"] = $rowsFee["fee_semester"];
        $subArray["frev_id"] = getField($conn, $rowsFee["fr_id"], "fee_reverse", "fr_id", "frev_id");
        $subArray["mn_name"] = $rowsFee["mn_name"];
        $subArray["fee_type"] = getField($conn, $rowsFee["fee_type"], "master_name", "mn_id", "mn_name");
        $subArray["fee_mode"] = getField($conn, $rowsFee["fee_mode"], "master_name", "mn_id", "mn_name");
        $subArray["user_id"] = getField($conn, $rowsFee["update_id"], "staff", "staff_id", "user_id");
        $subArray["fr_amount"] = $rowsFee["fr_amount"];
        $subArray["fr_desc"] = $rowsFee["fr_desc"];
        $subArray["fr_date"] = $rowsFee["fr_date"];
        $subArray["fee_bank"] = $rowsFee["fr_bank"];
        $json_array[] = $subArray;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'transactionHead') {
    $dateFrom = $_POST['dateFrom'];
    $dateTo = $_POST['dateTo'];

    $sql = "select sum(fr.fr_amount) as amount, mn.mn_name from fee_receipt fr, master_name mn where fr_date>='$dateFrom' and fr.fr_date<='$dateTo' and mn.mn_id=fr.fee_mode and fr_status='0' and fr.fr_id NOT IN (select fr_id from fee_reverse) group by fr.fee_mode order by fr.fee_mode";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      $subArray = array();
      while ($rowsFee = $result->fetch_assoc()) {
        $subArray["mode"] = $rowsFee["mn_name"];
        $subArray["amount"] = $rowsFee["amount"];
        $json_array[] = $subArray;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'fetchReceipt') {
    $fr_id = $_POST['frId'];
    $sql = "select fr.*, mn.mn_name, st.* from fee_receipt fr, master_name mn, student st where fr.student_id=st.student_id and fr.fr_id='$fr_id' and mn.mn_id=fr.fee_type order by fr_id desc";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      while ($rowsFee = $result->fetch_assoc()) {
        $json_array["fr_id"] = $rowsFee["fr_id"];
        $json_array["fr_sno"] = $rowsFee["fr_sno"];
        $json_array["mn_name"] = $rowsFee["mn_name"];
        $json_array["fee_type"] = getField($conn, $rowsFee["fee_type"], "master_name", "mn_id", "mn_name");
        $json_array["fee_mode"] = getField($conn, $rowsFee["fee_mode"], "master_name", "mn_id", "mn_name");
        $json_array["fr_amount"] = $rowsFee["fr_amount"];
        $json_array["fee_semester"] = $rowsFee["fee_semester"];
        $json_array["transaction_date"] = $rowsFee["transaction_date"];
        $json_array["transaction_id"] = $rowsFee["transaction_id"];
        $json_array["fee_bank"] = $rowsFee["fr_bank"];
        $json_array["fr_date"] = $rowsFee["fr_date"];
        $json_array["fr_desc"] = $rowsFee["fr_desc"];
        $json_array["update_ts"] = $rowsFee["update_ts"];
        $json_array["student_name"] = $rowsFee["student_name"];
        $json_array["student_fname"] = getField($conn, $rowsFee["student_id"], "student_detail", "student_id", "student_fname");
        $json_array["student_program"] = getField($conn, $rowsFee["program_id"], "program", "program_id", "sp_name");
        $json_array["student_batch"] = getField($conn, $rowsFee["batch_id"], "batch", "batch_id", "batch");

        $json_array["user_id"] = $rowsFee["user_id"];
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'transactionList') {
    $dateFrom = $_POST['dateFrom'];
    $dateTo = $_POST['dateTo'];
    $fee_mode = $_POST['mode'];
    $fee_type = $_POST['ft'];
    // echo "$fee_mode";

    if ($fee_mode > 0 && $fee_type == 'ALL') $sql = "select fr.*, mn.mn_name from fee_receipt fr, master_name mn where fr.fr_date>='$dateFrom' and fr.fr_date<='$dateTo' and fr.fee_mode='$fee_mode' and  mn.mn_id=fr.fee_type and fr.fr_status='0' and fr.fr_id NOT IN (select fr_id from fee_reverse) order by fr.fr_id";
    elseif ($fee_mode == 'ALL' && $fee_type > 0) $sql = "select fr.*, mn.mn_name from fee_receipt fr, master_name mn where fr.fr_date>='$dateFrom' and fr.fr_date<='$dateTo' and fr.fee_type='$fee_type' and  mn.mn_id=fr.fee_type and fr.fr_status='0' and fr.fr_id NOT IN (select fr_id from fee_reverse) order by fr.fr_id";
    elseif ($fee_mode > 0 && $fee_type > 0) $sql = "select fr.*, mn.mn_name from fee_receipt fr, master_name mn where fr.fr_date>='$dateFrom' and fr.fr_date<='$dateTo' and fr.fee_mode='$fee_mode' and fr.fee_type='$fee_type' and  mn.mn_id=fr.fee_type and fr.fr_status='0' and fr.fr_id NOT IN (select fr_id from fee_reverse) order by fr.fr_id";
    else $sql = "select fr.*, mn.mn_name from fee_receipt fr, master_name mn where fr.fr_date>='$dateFrom' and fr.fr_date<='$dateTo' and mn.mn_id=fr.fee_type and fr.fr_status='0' and fr.fr_id NOT IN (select fr_id from fee_reverse) order by fr.fr_id";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      $subArray = array();
      while ($rowsFee = $result->fetch_assoc()) {
        $student_id = $rowsFee["student_id"];
        $subArray["student_name"] = getField($conn, $student_id, "student", "student_id", "student_name");
        $subArray["user_id"] = getField($conn, $student_id, "student", "student_id", "user_id");
        $program_id = getField($conn, $student_id, "student", "student_id", "program_id");
        $subArray["sp_abbri"] = getField($conn, $program_id, "program", "program_id", "sp_abbri");
        $subArray["fr_id"] = $rowsFee["fr_id"];
        $subArray["mn_name"] = $rowsFee["mn_name"];
        $subArray["fee_type"] = getField($conn, $rowsFee["fee_type"], "master_name", "mn_id", "mn_name");
        $subArray["fee_mode"] = getField($conn, $rowsFee["fee_mode"], "master_name", "mn_id", "mn_name");
        $subArray["staff_id"] = getField($conn, $rowsFee["update_id"], "staff", "staff_id", "user_id");
        $subArray["fr_amount"] = $rowsFee["fr_amount"];
        $subArray["fr_date"] = $rowsFee["fr_date"];
        $subArray["transaction_date"] = $rowsFee["transaction_date"];
        $subArray["transaction_id"] = $rowsFee["transaction_id"];
        if (strlen($rowsFee["fr_bank"]) > 0) $subArray["fee_bank"] = $rowsFee["fr_bank"];
        else $subArray["fee_bank"] = '--';
        $json_array[] = $subArray;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'rerList') {
    $dateFrom = $_POST['dateFrom'];
    $dateTo = $_POST['dateTo'];
    // echo "$fee_mode";

    $sql = "select fr.*, mn.mn_name, frev.* from fee_receipt fr, master_name mn, fee_reverse frev where fr.fr_date>='$dateFrom' and fr.fr_date<='$dateTo' and mn.mn_id=fr.fee_type and fr.fr_status='0' and fr.fr_id=frev.fr_id order by fr.fr_id";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      $subArray = array();
      while ($rowsFee = $result->fetch_assoc()) {
        $student_id = $rowsFee["student_id"];
        $subArray["student_name"] = getField($conn, $student_id, "student", "student_id", "student_name");
        $subArray["user_id"] = getField($conn, $student_id, "student", "student_id", "user_id");
        $program_id = getField($conn, $student_id, "student", "student_id", "program_id");
        $subArray["sp_abbri"] = getField($conn, $program_id, "program", "program_id", "sp_abbri");
        $subArray["fr_id"] = $rowsFee["fr_id"];
        $subArray["mn_name"] = $rowsFee["mn_name"];
        $subArray["fee_type"] = getField($conn, $rowsFee["fee_type"], "master_name", "mn_id", "mn_name");
        $subArray["fee_mode"] = getField($conn, $rowsFee["fee_mode"], "master_name", "mn_id", "mn_name");
        $subArray["staff_id"] = getField($conn, $rowsFee["update_id"], "staff", "staff_id", "user_id");
        $subArray["fr_amount"] = $rowsFee["fr_amount"];
        $subArray["fr_date"] = $rowsFee["fr_date"];
        $subArray["frev_date"] = $rowsFee["update_ts"];
        $subArray["frev_desc"] = $rowsFee["frev_desc"];
        $json_array[] = $subArray;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'proposeConcession') {
    // echo " Add Fee ";
    $student_id = $_POST['id'];
    $ft = $_POST['feeType'];
    $sem = $_POST['sem'];
    $concession = $_POST['fcAmount'];
    $fee = $_POST['feeAmount'];
    $fd_remarks = $_POST['fdRemarks'];
    if ($myId > 0) {
      $sql = "insert into fee_dues (student_id, fee_type, fee_semester, fd_dues, fd_concession, fd_remarks, update_id, fd_status) values ('$student_id', '$ft', '$sem', '$fee', '$concession', '$fd_remarks', '$myId', '0')";
      $result = $conn->query($sql);
      if (!$result) {
        $sql = "update fee_dues set fd_dues='$fee', fd_concession='$concession', fd_remarks='$fd_remarks' where student_id='$student_id' and fee_type='$ft' and fee_semester='$sem'";
        $result = $conn->query($sql);
        echo "Fee and Concession Successfully Updated";
      } else echo "Fee and Concession Successfully Added";
    } else echo "Session Time Out !! Please logout and login Again";
  } elseif ($_POST['action'] == 'feeConcessionList') {
    $student_id = $_POST['id'];
    $sql = "select fd.*, mn.mn_name from fee_dues fd, master_name mn where fd.student_id='$student_id' and mn.mn_id=fd.fee_type  order by fd.fee_semester";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      $subArray = array();
      while ($rowsFee = $result->fetch_assoc()) {
        $subArray["mn_name"] = $rowsFee["mn_name"];
        $subArray["user_id"] = getField($conn, $rowsFee["update_id"], "staff", "staff_id", "user_id");
        $subArray["fee_semester"] = $rowsFee["fee_semester"];
        $subArray["fd_dues"] = $rowsFee["fd_dues"];
        $subArray["fd_concession"] = $rowsFee["fd_concession"];
        $subArray["fd_remarks"] = $rowsFee["fd_remarks"];
        $json_array[] = $subArray;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'feeDebitList') {
    $student_id = $_POST['id'];
    $sql = "select * from student where student_id='$student_id'";
    $result = $conn->query($sql);
    $rows = $result->fetch_assoc();
    $batch_id = $rows['batch_id'];
    $program_id = $rows['program_id'];
    $fcg = $rows['student_fee_category'];
    $sql = "select mn_id from master_name where mn_abbri='$fcg' and mn_code='fcg' and mn_status='0'";
    $fee_category = getFieldValue($conn, "mn_id", $sql);

    $json_array = array();
    $subArray = array();

    $sql = "select fd.* from fee_dues fd where fd.student_id='$student_id' and fd.fd_status='0'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      while ($rowsFee = $result->fetch_assoc()) {
        $subArray["fr_id"] = "--";
        $subArray["semester"] = $rowsFee["fee_semester"];
        $subArray["fr_amount"] = (int)$rowsFee["fd_dues"] - (int)$rowsFee["fd_concession"];
        $subArray["fr_desc"] = $rowsFee["fd_remarks"] . ' [Dues and Concession]';
        $subArray["fee_type"] = getField($conn, $rowsFee["fee_type"], "master_name", "mn_id", "mn_name");
        $subArray["fee_mode"] = 'Direct';
        $subArray["user_id"] = getField($conn, $rowsFee["update_id"], "staff", "staff_id", "user_id");
        $subArray["update_ts"] = $rowsFee["update_ts"];
        $json_array[] = $subArray;
      }
    }

    $sql = "select fr.*, frev.*, mn.mn_name from fee_receipt fr, fee_reverse frev, master_name mn where fr.student_id='$student_id' and mn.mn_id=fr.fee_type and fr.fr_id=frev.fr_id and fr.fr_status='0' order by fr.fee_semester";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      while ($rowsFee = $result->fetch_assoc()) {
        $subArray["fr_id"] = $rowsFee["fr_id"];
        $subArray["semester"] = $rowsFee["fee_semester"];
        $subArray["fr_desc"] = $rowsFee["fr_desc"] . ' [Reverse Entry]' . $rowsFee["frev_desc"];
        $subArray["fr_amount"] = $rowsFee["fr_amount"];
        $subArray["fee_type"] = getField($conn, $rowsFee["fee_type"], "master_name", "mn_id", "mn_name");
        $subArray["fee_mode"] = 'Direct';
        $subArray["user_id"] = getField($conn, $rowsFee["update_id"], "staff", "staff_id", "user_id");
        $subArray["update_ts"] = $rowsFee["update_ts"];
        $json_array[] = $subArray;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'feeStructure') {
    $student_id = $_POST['student_id'];
    $fee_semester = $_POST['fee_semester'];

    $program_id = getField($conn, $student_id, "student", "student_id", "program_id");
    $batch_id = getField($conn, $student_id, "student", "student_id", "batch_id");
    $fcg = getField($conn, $student_id, "student", "student_id", "student_fee_category");
    $sql = "select mn_id from master_name where mn_abbri='$fcg' and mn_code='fcg' and mn_status='0'";
    $fee_category = getFieldValue($conn, "mn_id", $sql);

    $json_array = array();
    $subArray = array();

    $sql = "select fs.*, sum(fs.fs_amount) as amount from fee_structure fs where fs.batch_id='$batch_id' and fs.program_id='$program_id' and fs.fee_category='$fee_category' and fs.fee_semester='$fee_semester' and fs.fs_status='0' group by fs.fee_type order by fs.fee_type";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      while ($rowsFee = $result->fetch_assoc()) {
        $subArray["amount"] = $rowsFee["amount"];
        $subArray["fee_type"] = getField($conn, $rowsFee["fee_type"], "master_name", "mn_id", "mn_name");
        $json_array[] = $subArray;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'feeRecordList') {
    $student_id = $_POST['id'];
    $sql = "select * from student where student_id='$student_id'";
    $result = $conn->query($sql);
    $rows = $result->fetch_assoc();
    $batch_id = $rows['batch_id'];
    $program_id = $rows['program_id'];
    $fcg = $rows['student_fee_category'];
    $sql = "select mn_id from master_name where mn_abbri='$fcg' and mn_code='fcg' and mn_status='0'";
    $fee_category = getFieldValue($conn, "mn_id", $sql);

    // echo "$program_id";
    $json_array = array();
    $subArray = array();

    $sql = "select fd.* from fee_dues fd where fd.student_id='$student_id' and fd.fd_status='0'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      while ($rowsFee = $result->fetch_assoc()) {
        $subArray["fr_id"] = "--";
        $subArray["semester"] = $rowsFee["fee_semester"];
        $subArray["frev_id"] = "--";
        $subArray["mn_name"] = "--";
        $subArray["fee_type"] = getField($conn, $rowsFee["fee_type"], "master_name", "mn_id", "mn_name");
        $subArray["fee_mode"] = 'Direct';
        $subArray["user_id"] = getField($conn, $rowsFee["update_id"], "staff", "staff_id", "user_id");
        $subArray["fr_debit"] = (int)$rowsFee["fd_dues"] - (int)$rowsFee["fd_concession"];
        $subArray["fr_amount"]="0";
        $subArray["fr_desc"] = $rowsFee["fd_remarks"] . ' [Dues and Concession]';
        $subArray["fr_date"] = $rowsFee["update_ts"];
        $subArray["fee_bank"] = '--';
        $json_array[] = $subArray;
      }
    }

    $sql = "select fr.*, frev.*, mn.mn_name from fee_receipt fr, fee_reverse frev, master_name mn where fr.student_id='$student_id' and mn.mn_id=fr.fee_type and fr.fr_id=frev.fr_id and fr.fr_status='0' order by fr.fee_semester";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      while ($rowsFee = $result->fetch_assoc()) {
        $subArray["fr_id"] = $rowsFee["fr_id"];
        $subArray["semester"] = $rowsFee["fee_semester"];
        $subArray["frev_id"] = "--";
        $subArray["mn_name"] = "--";
        $subArray["fee_type"] = getField($conn, $rowsFee["fee_type"], "master_name", "mn_id", "mn_name");
        $subArray["fee_mode"] = 'Direct';
        $subArray["user_id"] = getField($conn, $rowsFee["update_id"], "staff", "staff_id", "user_id");
        $subArray["fr_debit"]="0";
        $subArray["fr_amount"] = $rowsFee["fr_amount"];
        $subArray["fr_desc"] = $rowsFee["fr_desc"] . ' [Reverse Entry]' . $rowsFee["frev_desc"];
        $subArray["fr_date"] = $rowsFee["update_ts"];
        $subArray["fee_bank"] = $rowsFee["fr_bank"];
        $json_array[] = $subArray;
      }
    }
    $sql = "select fr.*, mn.mn_name from fee_receipt fr, master_name mn where fr.student_id='$student_id' and mn.mn_id=fr.fee_type and fr.fr_status='0' order by fr.fr_id";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      while ($rowsFee = $result->fetch_assoc()) {
        $subArray["fr_id"] = $rowsFee["fr_id"];
        $subArray["semester"] = $rowsFee["fee_semester"];
        $subArray["frev_id"] = getField($conn, $rowsFee["fr_id"], "fee_reverse", "fr_id", "frev_id");
        $subArray["mn_name"] = $rowsFee["mn_name"];
        $subArray["fee_type"] = getField($conn, $rowsFee["fee_type"], "master_name", "mn_id", "mn_name");
        $subArray["fee_mode"] = getField($conn, $rowsFee["fee_mode"], "master_name", "mn_id", "mn_name");
        $subArray["user_id"] = getField($conn, $rowsFee["update_id"], "staff", "staff_id", "user_id");
        $subArray["fr_debit"]="0";
        $subArray["fr_amount"] = $rowsFee["fr_amount"];
        $subArray["fr_desc"] = $rowsFee["fr_desc"];
        $subArray["fr_date"] = $rowsFee["fr_date"];
        $subArray["fee_bank"] = $rowsFee["fr_bank"];
        $json_array[] = $subArray;
      }
    }
    echo json_encode($json_array);
  }
}
