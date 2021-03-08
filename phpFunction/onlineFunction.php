<?php
function get_testListJson($conn, $myId)
{
  $sql = "select * from test where test_status<9 and submit_id='$myId' order by test_status asc, submit_ts desc";
  $result = $conn->query($sql);
  if (!$result) {
    echo $result->error;
    die(" The script could not be Loadded In Get Extra Attendance! Please report!");
  }
  $data = array();
  while ($rows = $result->fetch_assoc()) {
    $sub_array = array();
    $sub_array["test_id"] = $rows['test_id'];
    $sub_array["test_name"] = $rows['test_name'];
    $sub_array["test_section"] = $rows['test_section'];
    $sub_array["submit_ts"] = $rows['submit_ts'];
    $sub_array["test_status"] = $rows['test_status'];
    $data[] = $sub_array;
  }
  $output = array(
    "data" => $data
  );
  return json_encode($output);
}
function get_sectionQuestionListJson($conn, $test_id, $test_section)
{
  $sql = "select qb.*, tq.* from test_question tq, question_bank qb where tq.qb_id=qb.qb_id and tq.test_id='$test_id' and tq.test_section='$test_section' order by qb_status";
  $result = $conn->query($sql);
  if (!$result) {
    echo $result->error;
    die(" The script could not be Loadded In Get Extra Attendance! Please report!");
  }
  $data = array();
  while ($rows = $result->fetch_assoc()) {
    $sub_array = array();
    $sub_array["qb_id"] = $rows['qb_id'];
    $sub_array["qb_text"] = $rows['qb_text'];
    $sub_array["tq_marks"] = $rows['tq_marks'];
    $sub_array["tq_nmarks"] = $rows['tq_nmarks'];
    $sub_array["tq_status"] = $rows['tq_status'];
    $sub_array["qb_status"] = $rows['qb_status'];
    $data[] = $sub_array;
  }
  $output = array(
    "data" => $data
  );
  return json_encode($output);
}
?>
