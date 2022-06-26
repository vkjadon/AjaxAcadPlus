<?php
## Database configuration
require('../requireSubModule.php');

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($conn,$_POST['search']['value']); // Search value

## Search 
$searchQuery = " ";
if($searchValue != ''){
   $searchQuery = " and (s.staff_name like '%".$searchValue."%' or 
        s.staff_email like '%".$searchValue."%' or 
        s.staff_mobile like'%".$searchValue."%' ) ";
}

## Total number of records without filtering
$sel = mysqli_query($conn,"select count(*) as allcount from staff");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of record with filtering
$sel = mysqli_query($conn,"select count(s.staff_id) as allcount from staff s WHERE s.staff_status='0' ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$empQuery = "select s.*, d.dept_abbri from staff s, department d WHERE s.staff_status='0' and s.dept_id=d.dept_id ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($conn, $empQuery);
$data = array();
$i=1;
while ($row = mysqli_fetch_assoc($empRecords)) {

   $data[] = array( 
      "sno"=>$i++,
      "user_id"=>$row['user_id'],
      "staff_name"=>$row['staff_name'],
      "staff_dob"=>date("d-m-Y",strtotime($row['staff_dob'])),
      "staff_email"=>$row['staff_email'],
      "staff_gender"=>$row['staff_gender'],
      "staff_mobile"=>$row['staff_mobile'],
      "dept_id"=>$row['dept_abbri']
   );
}

## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($response);
