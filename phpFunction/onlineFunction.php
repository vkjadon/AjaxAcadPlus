<?php
function get_testListJson($conn, $myId){
    $sql = "select * from test where test_status<9 and submit_id='$myId' order by test_status asc, submit_ts desc";
    $result = $conn->query($sql);
    if (!$result){
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
    return json_encode($output);}
?>