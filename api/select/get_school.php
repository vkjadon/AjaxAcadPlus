<?php
include('../../config_database.php');
$sql = "select * from school where school_status='0' order by school_name";
$result = $conn->query($sql);
if (!$result) die(" The script could not be Loadded! Please report!");
else {
  while ($rows = $result->fetch_assoc()) {
    $name = $rows['school_name'];
    $id = $rows['school_id'];
    $response["data"][] = array(
      'id'   => $id,
      'name'   => $name,
    );
  }

  $response["success"] = True;
  $someJSON = json_encode($response);
}
echo $someJSON;
