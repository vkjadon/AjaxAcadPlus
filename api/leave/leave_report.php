<?php
  include('../authenticate.php');
  $lf=$_GET['lf'];
  $lt=$_GET['lt'];
  $deptId=$_GET['deptId'];
  if($deptId>0)$sql = "SELECT ll.*, s.staff_name, lt.leave_type FROM leave_type lt, leave_ledger ll, staff s where s.dept_id='$deptId' and ll.leave_typeid=lt.leave_typeid and ll.staff_id=s.staff_id and ll.leave_from>='$lf' and ll.leave_from<='$lt' order by leave_from desc";
  else $sql = "SELECT ll.*, s.staff_name, lt.leave_type FROM leave_type lt, leave_ledger ll, staff s where ll.leave_typeid=lt.leave_typeid and ll.staff_id=s.staff_id and ll.leave_from>='$lf' and ll.leave_from<='$lt' order by leave_from desc";
  $result = $conn->query($sql);
  $data = array();  
  $no=1;
  while($row=$result->fetch_assoc())  
  {  
    $sub_array = array();                  
    $sub_array[] = $no++;                  
    $sub_array[] = $row['staff_name'];
    $sub_array[] = $row['leave_type'];
    $sub_array[] = date("d-m-Y",strtotime($row['leave_from']));    
    $sub_array[] = date("d-m-Y",strtotime($row['leave_to']));    
    $sub_array[] = $row['leave_reason'];  
    $data[]= $sub_array;
  }  
  $output = array(
    "data"                    =>     $data  
  );
  echo json_encode($output);
  ?>