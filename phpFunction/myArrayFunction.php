<?php
function getResponsibilityArray($conn, $table, $staffId, $getId)
{  
  //Return Array of the Classes for Current Staff as Class In-Charge 
  $sql = "select * from $table where staff_id='" . $staffId . "'";
  $result = $conn->query($sql);
  $i = 0;
  if (!$result) {
    echo $conn->error;
    die("Opps! Some Error occured !! Please contact Administrator !");
  } else {
    $output = array();
    while ($rows = $result->fetch_assoc()) {
        $output[$i] = $rows[$getId];
      $i++;
    }
  }
  return $output;
}
