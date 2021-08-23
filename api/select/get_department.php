<?php
  include('../authenticate.php');
  $sql = "SELECT * FROM department where dept_status='0' order by dept_name";
  $result = $conn->query($sql);
  $data = array();  
  $no=1;
  while($row=$result->fetch_assoc())  
  {  
    $sub_array = array();                  
    $sub_array[] = $row['dept_id'];
    $sub_array[] = $row['dept_name'];
    $sub_array[] = $row['dept_abbri'];    
    $data[]= $sub_array;
  }  
  $output = array(
    "data"                    =>     $data  
  );
  echo json_encode($output);
?>
	