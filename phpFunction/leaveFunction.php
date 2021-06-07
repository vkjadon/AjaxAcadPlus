<?php
function get_extraAttendanceJson($conn, $tn_eac)
{
  $sql = "select eac.* from $tn_eac eac where eac_status<9 order by eac.eac_status, eac.eac_date";

  $result = $conn->query($sql);
  if (!$result) {
    echo $result->error;
    die(" The script could not be Loadded In Get Extra Attendance! Please report!");
  }
  $data = array();
  while ($rows = $result->fetch_assoc()) {
    $sub_array = array();
    $sub_array["student_id"] = $rows['student_id'];
    $sub_array["eac_date"] = $rows['eac_date'];
    $sub_array["eae_id"] = $rows['eae_id'];
    $sub_array["eac_claim"] = $rows['eac_claim'];
    $sub_array["sas_id"] = $rows['sas_id'];
    $sub_array["eac_remarks"] = $rows['eac_remarks'];
    $sub_array["eac_status"] = $rows['eac_status'];
    $sub_array["eac_approved"] = $rows['eac_approved'];
    $sub_array["approver_id"] = $rows['approver_id'];
    $sub_array["approver_ts"] = $rows['approver_ts'];
    $data[] = $sub_array;
  }
  $output = array(
    "data" => $data
  );
  return json_encode($output);
}
function get_classEAJson($conn, $tn_eac)
{
  $sql = "select eac.* from $tn_eac eac where eac_status<9 order by eac.eac_status, eac.eac_date";

  $result = $conn->query($sql);
  if (!$result) {
    echo $result->error;
    die(" The script could not be Loadded In Get Extra Attendance! Please report!");
  }
  $data = array();
  while ($rows = $result->fetch_assoc()) {
    $sub_array = array();
    $sub_array["student_id"] = $rows['student_id'];
    $sub_array["eac_date"] = $rows['eac_date'];
    $sub_array["eae_id"] = $rows['eae_id'];
    $sub_array["eac_claim"] = $rows['eac_claim'];
    $sub_array["sas_id"] = $rows['sas_id'];
    $sub_array["eac_remarks"] = $rows['eac_remarks'];
    $sub_array["eac_status"] = $rows['eac_status'];
    $sub_array["eac_approved"] = $rows['eac_approved'];
    $sub_array["approver_id"] = $rows['approver_id'];
    $sub_array["approver_ts"] = $rows['approver_ts'];
    $data[] = $sub_array;
  }
  $output = array(
    "data" => $data
  );
  return json_encode($output);
}

