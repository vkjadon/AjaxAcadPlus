<?php
require('../../module/requireSubModule.php');
// echo $_POST['action'];
if (isset($_POST['action'])) {
 if ($_POST['action'] == 'fetchStudent') {
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
  $ft = $_POST['feeType'];
  $fm = $_POST['feeMode'];
  $sem = $_POST['sem'];
  $fee = $_POST['feeAmount'];
  $feeDesc = $_POST['feeDesc'];
  $feeDate = $_POST['feeDate'];
  // echo "$student_id $ft";
  $sql = "insert into fee_receipt (fee_type, fee_date, student_id, fee_mode, fee_semester, fee_amount, transaction_id, fee_desc, update_id, fr_status) values ('$ft','$feeDate','$student_id' ,'$fm', '$sem', '$fee','$t_id', '$feeDesc', '$myId', '0')";
  $result = $conn->query($sql);
  if (!$result) echo $conn->error;
  else echo "Fee Successfully Added";
 } elseif ($_POST['action'] == 'feeReceiptList') {
  $sql = "select fr.*, mn.mn_name from fee_receipt fr, master_name mn where mn.mn_id=fr.fee_type and fr_status='0' order by fr.fee_semester";
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
    $subArray["fee_amount"] = $rowsFee["fee_amount"];
    $json_array[] = $subArray;
   }
   echo json_encode($json_array);
  }
 } elseif ($_POST["action"] == "deleteFee") {
  $fs_id = $_POST['fs_id'];
  $sql = "update fee_structure set fs_status='9' where fs_id='$fs_id'";
  $result = $conn->query($sql);
  if ($result) echo "Data Dropped !!";
 }
}
