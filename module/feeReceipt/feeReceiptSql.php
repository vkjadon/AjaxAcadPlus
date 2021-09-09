<?php
require('../../module/requireSubModule.php');
// echo $_POST['action'];
if (isset($_POST["query"])) {
  $output = '';
  $sql = "select s.student_id, s.student_name, sd.student_fname from student s, student_detail sd where s.student_name LIKE '%" . $_POST["query"] . "%' and s.student_id=sd.student_id and s.student_status='0' and s.program_id>0";
  $result = $conn->query($sql);
  $output = '<ul class="list-group">';
  if ($result) {
    while ($row = $result->fetch_assoc()) {
      $output .= '<li class="list-group-item list-group-item-action autoList" style="z-index: 4;" data-std="' . $row["student_id"] . '" >' . $row["student_name"] . ' [' . $row["student_fname"] . ']</li>';
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
    $sql = "select st.*, sd.*, sa.*, sr.*, b.batch, p.program_name from student st, student_detail sd, student_address sa, student_reference sr, batch b, program p where st.batch_id=b.batch_id and st.user_id='$id' and st.program_id=p.program_id and st.student_id=sd.student_id and st.student_id=sa.student_id and st.student_id=sr.student_id and st.student_status='0'";
    $result = $conn->query($sql);
    $output = $result->fetch_assoc();
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
    $feeDesc = $_POST['feeDesc'];
    $feeDate = $_POST['fr_date'];
    // echo "$student_id $ft";
    $sql = "insert into fee_receipt (fee_type, fr_date, student_id, fee_mode, fee_semester, fr_amount, transaction_id, transaction_date, fr_desc, update_id, fr_status) values ('$ft', '$feeDate', '$student_id', '$fm', '$sem', '$fee','$t_id', '$transaction_date', '$feeDesc', '$myId', '0')";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else echo "Fee Successfully Added";
  } elseif ($_POST['action'] == 'feeReceiptList') {
    $student_id = $_POST['id'];
    $sql = "select fr.*, mn.mn_name from fee_receipt fr, master_name mn where fr.student_id='$student_id' and mn.mn_id=fr.fee_type and fr_status='0' order by fr.fee_semester";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      $subArray = array();
      while ($rowsFee = $result->fetch_assoc()) {
        $subArray["fr_id"] = $rowsFee["fr_id"];
        $subArray["mn_name"] = $rowsFee["mn_name"];
        $subArray["fee_type"] = getField($conn, $rowsFee["fee_type"], "master_name", "mn_id", "mn_name");
        $subArray["fee_mode"] = getField($conn, $rowsFee["fee_mode"], "master_name", "mn_id", "mn_name");
        $subArray["fr_amount"] = $rowsFee["fr_amount"];
        $subArray["fr_desc"] = $rowsFee["fr_desc"];
        $json_array[] = $subArray;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'fetchReceipt') {
    $fr_id = $_POST['frId'];
    $sql = "select fr.*, mn.mn_name from fee_receipt fr, master_name mn where fr.fr_id='$fr_id' and mn.mn_id=fr.fee_type order by fr_id desc";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      while ($rowsFee = $result->fetch_assoc()) {
        $json_array["fr_id"] = $rowsFee["fr_id"];
        $json_array["mn_name"] = $rowsFee["mn_name"];
        $json_array["fee_type"] = getField($conn, $rowsFee["fee_type"], "master_name", "mn_id", "mn_name");
        $json_array["fee_mode"] = getField($conn, $rowsFee["fee_mode"], "master_name", "mn_id", "mn_name");
        $json_array["fr_amount"] = $rowsFee["fr_amount"];
        $json_array["fee_semester"] = $rowsFee["fee_semester"];
        $json_array["transaction_date"] = $rowsFee["transaction_date"];
        $json_array["transaction_id"] = $rowsFee["transaction_id"];
        $json_array["fr_date"] = $rowsFee["fr_date"];
        $json_array["update_ts"] = $rowsFee["update_ts"];
      }
      echo json_encode($json_array);
    }
  }elseif ($_POST['action'] == 'transactionList') {
    $dateFrom = $_POST['dateFrom'];
    $dateTo = $_POST['dateTo'];
    //echo "$dateFrom";
    $sql = "select fr.*, mn.mn_name from fee_receipt fr, master_name mn where fr.transaction_date>='$dateFrom' and fr.transaction_date<='$dateTo' and mn.mn_id=fr.fee_type and fr.fr_status='0' order by fr.fr_id";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      $subArray = array();
      while ($rowsFee = $result->fetch_assoc()) {
        $student_id=$rowsFee["student_id"];
        $subArray["student_name"]=getField($conn, $student_id, "student", "student_id", "student_name");
        $subArray["user_id"]=getField($conn, $student_id, "student", "student_id", "user_id");
        $subArray["fr_id"] = $rowsFee["fr_id"];
        $subArray["mn_name"] = $rowsFee["mn_name"];
        $subArray["fee_type"] = getField($conn, $rowsFee["fee_type"], "master_name", "mn_id", "mn_name");
        $subArray["fee_mode"] = getField($conn, $rowsFee["fee_mode"], "master_name", "mn_id", "mn_name");
        $subArray["fr_amount"] = $rowsFee["fr_amount"];
        $subArray["fr_date"] = $rowsFee["fr_date"];
        $subArray["transaction_id"] = $rowsFee["transaction_id"];
        $json_array[] = $subArray;
      }
      echo json_encode($json_array);
    }
  }
}
