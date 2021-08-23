<?php
function get_feedbackListJson($conn, $myId)
{
  if($myId>0)$sql = "select * from feedback where feedback_status<9 and submit_id='$myId' order by feedback_status asc, submit_ts desc";
  else $sql = "select * from feedback where feedback_status<9 order by feedback_status asc, submit_ts desc";
  $result = $conn->query($sql);
  if (!$result) {
    echo $result->error;
    die(" The script could not be Loadded In Get Extra Attendance! Please report!");
  }
  $data = array();
  while ($rows = $result->fetch_assoc()) {
    $sub_array = array();
    $sub_array["feedback_id"] = $rows['feedback_id'];
    $sub_array["feedback_name"] = $rows['feedback_name'];
    $sub_array["feedback_section"] = $rows['feedback_section'];
    $sub_array["submit_ts"] = $rows['submit_ts'];
    $sub_array["feedback_status"] = $rows['feedback_status'];
    $data[] = $sub_array;
  }
  $output = array(
    "data" => $data
  );
  return json_encode($output);
}
function get_sectionQuestionListJson($conn, $feedback_id, $feedback_section)
{
  $sql = "select qb.*, tq.* from feedback_question tq, question_bank qb where tq.qb_id=qb.qb_id and tq.feedback_id='$feedback_id' and tq.feedback_section='$feedback_section' order by qb.qb_status, tq.tq_status, tq.qb_id";
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
    $sub_array["qb_image"] = $rows['qb_image'];
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
function feedbackQuestionList($conn, $feedback_id, $feedback_section)
{
  if($feedback_section>0)$sql = "select qb.*, tq.* from feedback_question tq, question_bank qb where tq.qb_id=qb.qb_id and tq.feedback_id='$feedback_id' and tq.feedback_section='$feedback_section' and tq.tq_status='2' order by tq.qb_id";
  else $sql = "select qb.*, tq.* from feedback_question tq, question_bank qb where tq.qb_id=qb.qb_id and tq.feedback_id='$feedback_id' and tq.tq_status='2' order by rand()";
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
    $data[] = $sub_array;
  }
  $output = array(
    "data" => $data
  );
  return $output;
}
function get_questionJson($conn, $feedback_id, $id)
{
  $sql = "select qb.*, tq.* from feedback_question tq, question_bank qb where tq.qb_id=qb.qb_id and tq.feedback_id='$feedback_id' and tq.qb_id='$id'";
  $result = $conn->query($sql);
  if (!$result) {
    echo $result->error;
    die(" The script could not be Loadded In Get Extra Attendance! Please report!");
  }
  $data = array();
  while ($rows = $result->fetch_assoc()) {
    $sub_array = array();
    $sub_array["qb_text"] = $rows['qb_text'];
    $sub_array["qb_image"] = $rows['qb_image'];
    $sub_array["tq_marks"] = $rows['tq_marks'];
    $sub_array["tq_nmarks"] = $rows['tq_nmarks'];
    $data[] = $sub_array;
  }
  $output = array(
    "data" => $data
  );
  return $output;
}
function get_activeQuestionJson($conn, $feedback_id, $feedback_section)
{
  $sql = "select qb.*, tq.* from feedback_question tq, question_bank qb where tq.qb_id=qb.qb_id and tq.feedback_id='$feedback_id' and tq.feedback_section='$feedback_section' and qb_status=0";
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
    $sub_array["qb_image"] = $rows['qb_image'];
    $sub_array["tq_marks"] = $rows['tq_marks'];
    $sub_array["tq_nmarks"] = $rows['tq_nmarks'];
    $sub_array["tq_status"] = $rows['tq_status'];
    $data[] = $sub_array;
  }
  $output = array(
    "data" => $data
  );
  return json_encode($output);
}
?>
