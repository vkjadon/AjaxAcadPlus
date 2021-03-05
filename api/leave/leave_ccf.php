<?php
  include('../authenticate.php');
  $sql = "SELECT * FROM leave_ccf";
  $result = $conn->query($sql);
  $data = array();  
  $no=1;
  while($row=$result->fetch_assoc())  
  {  
    $sub_array = array();                  
    $sub_array[] = $no++;                  
    $sub_array[] = $row['staff_id'];
    $sub_array[] = $row['lccf_reason'];  
    $sub_array[] = $row['submit_ts'];  
    $sub_array[] = $row['update_ts'];    
    $data[]= $sub_array;
  }  
  $output = array(
    "data"                    =>     $data  
  );
  echo json_encode($output);
  ?>