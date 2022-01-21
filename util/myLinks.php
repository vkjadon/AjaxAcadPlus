<?php
require("config_database.php");
$sql = "select rs.*, rl.* from responsibility_staff rs, responsibility_link rl where rs.staff_id='$myId' and rs.mn_id=rl.mn_id";
$result = $conn->query($sql);
$myLinks = array();
if ($result) {
  while ($rowsArray = $result->fetch_assoc()) {
    $myLinks[] = $rowsArray["pl_id"];
  }
} else echo $conn->error;


$curl = curl_init();
$url = 'https://classconnect.in/api/get_portal_link.php?pg=ALL';

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($curl);
$output = json_decode($output, true);

if ($output['success'] == "True") {
  $links = count($output['data']);
  $subArray = array();
  for ($i = 0; $i < $links; $i++) {
    $id = $output["data"][$i]["pl_id"];
    $pl_type = $output["data"][$i]["pl_type"];
    if ($pl_type == '1' || $myId < 4) $myLinks[] = $id;
  }
}

// print_r($myLinks);
