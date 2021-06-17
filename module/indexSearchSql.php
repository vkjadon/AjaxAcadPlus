<?php
require('requireModule.php');
$string = $_POST["searchString"];
$output = '';
$sql = "select * from staff where (staff_name LIKE '%$string%' or staff_mobile LIKE '%$string%' or user_id LIKE '%$string%')";
$result = $conn->query($sql);
if (!$result) echo $conn->error;
$output = '<ul class="list-group p-0 m-0">';
if ($result) {
  while ($row = $result->fetch_assoc()) {
    $output .= '<li class="list-group-item list-group-item-action indexAutoList"  data-staff="' . $row["staff_id"] . '" >' . $row["staff_name"] . ' [' . $row["user_id"] . '] ' . $row["staff_mobile"] . '</li>';
  }
} else {
  $output .= '<li>Staff Not Found</li>';
}
$output .= '</ul>';
echo $output;
