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
  if ($_POST['action'] == 'paymentHead') {
    $sql = "select * from master_name where mn_code='ph' and mn_status='0' order by mn_name ASC";
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
  } elseif ($_POST['action'] == 'addPayment') {
    // echo " Add Fee ";
    $time=gmdate("Y/m/d H:i:s",time());
    if ($myId > 0) {
      $sql = "insert into payment_voucher (pv_type, pv_head, pv_mode, pv_bank, pv_amount, transaction_id, transaction_date, pv_desc, bill_no, bill_date, bill_amount, payee_name, payee_mobile, payee_id, update_ts, update_id, pv_status) values ('" . $_POST['pv_type'] . "', '" . $_POST['pv_head'] . "', '" . $_POST['pv_mode'] . "', '" . $_POST['pv_bank'] . "', '" . $_POST['pv_amount'] . "', '" . $_POST['transaction_id'] . "', '" . $_POST['transaction_date'] . "', '" . $_POST['pv_desc'] . "', '" . $_POST['bill_no'] . "','" . $_POST['bill_date'] . "', '" . $_POST['bill_amount'] . "', '" . $_POST['payee_name'] . "','" . $_POST['payee_mobile'] . "','" . $_POST['payee_id'] . "', '$time', '$myId', '0')";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else echo "Fee Successfully Added";
    } else echo "Session Time Out !! Please logout and login Again";
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
        $subArray["user_id"] = getField($conn, $rowsFee["update_id"], "staff", "staff_id", "user_id");
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
        $json_array["fr_sno"] = $rowsFee["fr_sno"];
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
  } elseif ($_POST['action'] == 'paymentList') {
    $dateFrom = date("Y-m-d H:i:s", strtotime($_POST['dateFrom']));
    $dateTo = date("Y-m-d H:i:s", (strtotime($_POST['dateTo']) + 24 * 60 * 60));
    // echo "$dateFrom";
    $sql = "select pv.*, mn.mn_name from payment_voucher pv, master_name mn where mn.mn_id=pv.pv_head and pv.pv_status='0' and pv.update_ts>='$dateFrom' and pv.update_ts<='$dateTo' order by pv.pv_id";
    // $sql = "select pv.*, mn.mn_name from payment_voucher pv, master_name mn where mn.mn_id=pv.pv_head and pv.pv_status='0' and pv.update_ts>='$dateFrom' and pv.update_ts<='$dateTo' order by pv.pv_id";
    $result = $conn->query($sql);
    // echo $result->num_rows;
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      $subArray = array();
      while ($rowsFee = $result->fetch_assoc()) {
        $subArray["pv_id"] = $rowsFee["pv_id"];
        $sql_rev="select * from pv_reverse where pv_id='".$rowsFee["pv_id"]."' and pr_status='0'";
        $result_rev=$conn->query($sql_rev);
        if($result_rev->num_rows>0){
          $revRows=$result_rev->fetch_assoc();
          $pr = $revRows["pr_desc"];
        } else $pr='--';
        $subArray["pr_id"] = $pr;
        $subArray["payee_name"] = $rowsFee["payee_name"];
        $subArray["payee_mobile"] = $rowsFee["payee_mobile"];
        $subArray["payee_id"] = $rowsFee["payee_id"];
        $subArray["pv_head"] = $rowsFee["mn_name"];
        $subArray["pv_mode"] = getField($conn, $rowsFee["pv_mode"], "master_name", "mn_id", "mn_name");
        $subArray["staff_id"] = getField($conn, $rowsFee["update_id"], "staff", "staff_id", "user_id");
        $subArray["pv_amount"] = $rowsFee["pv_amount"];
        $subArray["pv_bank"] = $rowsFee["pv_bank"];
        $subArray["transaction_date"] = $rowsFee["transaction_date"];
        $subArray["transaction_id"] = $rowsFee["transaction_id"];
        $subArray["update_ts"] = date("d-m-Y", strtotime($rowsFee["update_ts"]));
        $subArray["pv_type"] = $rowsFee["pv_type"];
        $json_array[] = $subArray;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'pvDaily') {
    $pvDate = $_POST['pvDate'];
    $dateFrom = date("Y-m-d H:i:s", strtotime($pvDate));
    $dateTo = date("Y-m-d H:i:s", (strtotime($pvDate) + 24 * 60 * 60));
    // echo "$dateFrom";
    $sql = "select pv.*, mn.mn_name from payment_voucher pv, master_name mn where mn.mn_id=pv.pv_head and pv.pv_status='0' and pv.update_ts>='$dateFrom' and pv.update_ts<='$dateTo' order by pv.pv_id";
    $result = $conn->query($sql);
    // echo $result->num_rows;
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      $subArray = array();
      while ($rowsFee = $result->fetch_assoc()) {
        $subArray["pv_id"] = $rowsFee["pv_id"];
        $subArray["payee_name"] = $rowsFee["payee_name"];
        $subArray["payee_mobile"] = $rowsFee["payee_mobile"];
        $subArray["payee_mobile"] = $rowsFee["payee_mobile"];
        $subArray["pv_head"] = $rowsFee["mn_name"];
        $subArray["pv_mode"] = getField($conn, $rowsFee["pv_mode"], "master_name", "mn_id", "mn_name");
        $subArray["staff_id"] = getField($conn, $rowsFee["update_id"], "staff", "staff_id", "user_id");
        $subArray["pv_amount"] = $rowsFee["pv_amount"];
        $subArray["pv_bank"] = $rowsFee["pv_bank"];
        $subArray["transaction_date"] = $rowsFee["transaction_date"];
        $subArray["transaction_id"] = $rowsFee["transaction_id"];
        $subArray["update_ts"] = date("d-m-Y", strtotime($rowsFee["update_ts"]));
        $subArray["pv_type"] = $rowsFee["pv_type"];
        $json_array[] = $subArray;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'fetchVoucher') {
    $pv_id = $_POST['pv_id'];
    $sql = "select pv.*, mn.mn_name from payment_voucher pv, master_name mn where pv.pv_id='$pv_id' and mn.mn_id=pv.pv_head order by pv_id desc";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      while ($rowsFee = $result->fetch_assoc()) {
        $json_array["pv_id"] = $rowsFee["pv_id"];
        $json_array["payee_name"] = $rowsFee["payee_name"];
        $json_array["payee_mobile"] = $rowsFee["payee_mobile"];
        $json_array["payee_id"] = $rowsFee["payee_id"];
        $json_array["pv_type"] = $rowsFee["pv_type"];
        $json_array["pv_desc"] = $rowsFee["pv_desc"];
        $json_array["pv_head"] = $rowsFee["mn_name"];
        $json_array["pv_mode"] = getField($conn, $rowsFee["pv_mode"], "master_name", "mn_id", "mn_name");
        $json_array["staff_id"] = getField($conn, $rowsFee["update_id"], "staff", "staff_id", "user_id");
        $json_array["pv_amount"] = $rowsFee["pv_amount"];
        $json_array["pv_bank"] = $rowsFee["pv_bank"];
        $json_array["transaction_date"] = $rowsFee["transaction_date"];
        $json_array["transaction_id"] = $rowsFee["transaction_id"];
        $json_array["update_ts"] = $rowsFee["update_ts"];
        $json_array["bill_date"] = $rowsFee["bill_date"];
        $json_array["bill_no"] = $rowsFee["bill_no"];
        $json_array["bill_amount"] = $rowsFee["bill_amount"];
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'addPVReverse') {
    $id = $_POST['id'];
    $pr_desc = $_POST['pr_desc'];
    if ($myId > 0) {
      $sql = "insert into pv_reverse (pv_id, pr_desc, update_id, pr_status) values ('$id', '$pr_desc', '$myId', '0')";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else echo "Entry Reversed";
    } else echo "Session Time Out !! Please logout and login Again";
  }
}
