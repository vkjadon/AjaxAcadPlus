<?php
// required in "module/requireSubModule.php"

require("config_database.php");

// This block fetch the links associated with a [custom: created through master data] responsibility

$sql = "select rs.*, rg.* from responsibility_staff rs, responsibility_group rg where rs.staff_id='$myId' and rs.mn_id=rg.mn_id";
$result = $conn->query($sql);
$myLinks = array();
if ($result) {
  while ($rowsArray = $result->fetch_assoc()) {
    $myLinks[] = $rowsArray["pg_id"];
  }
} else echo $conn->error;

// This block fetch the links associated with Portal responsibility: Already Fixed such as HOD, Director etc.

$sql = "select rs.*, rg.* from responsibility_staff rs, responsibility_group rg where rs.staff_id='$myId' and rs.rs_code=rg.rs_code and rs.rs_code<>'AA'";
$result = $conn->query($sql);
if ($result) {
  while ($rowsArray = $result->fetch_assoc()) {
    $myLinks[] = $rowsArray["pg_id"];
  }
} else echo $conn->error;

// Set Privilege as Staff (up_code=1) in case the

if(!isset($myPriv))$myPriv=1;

$sql = "select * from privilege_group where up_code='$myPriv'";
$result = $conn->query($sql);
if ($result) {
  while ($rowsArray = $result->fetch_assoc()) {
    $myLinks[] = $rowsArray["pg_id"];
  }
} else echo $conn->error;

$myLinks=array_unique($myLinks);

// print_r($myLinks);