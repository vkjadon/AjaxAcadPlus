<?php
require('../requireSubModule.php');

//echo $_POST['action'];
if (isset($_POST['action'])) {
 if ($_POST['action'] == 'addLocation') {
  //echo "MyId- $myId";
  $fields = ['location_name', 'location_code', 'location_rows', 'location_columns', 'location_type', 'location_floor', 'location_capacity'];
  $values = [data_check($_POST['loc_name']), data_check($_POST['loc_code']), $_POST['loc_rows'], $_POST['loc_cols'], $_POST['loc_type'], $_POST['loc_floor'], $_POST['loc_cap']];
  $status = 'location_status';
  $dup = "select * from institute_location where location_code='" . data_check($_POST["loc_code"]) . "' and $status='0'";
  $dup_alert = "Duplicate Code Exists. One Institute can have one Code. Give Dummy Unique Code if required";
  addData($conn, 'institute_location', 'location_id', $fields, $values, $status, $dup, $dup_alert);
 } elseif ($_POST['action'] == 'fetchLocation') {
  $id = $_POST['locationId'];
  $sql = "SELECT * FROM institute_location where location_id='$id'";
  $result = $conn->query($sql);
  $output = $result->fetch_assoc();
  echo json_encode($output);
 } elseif ($_POST['action'] == 'updateLocation') {
  $fields = ['location_id', 'location_name', 'location_code', 'location_rows', 'location_columns', 'location_type', 'location_floor', 'location_capacity'];
  $values = [$_POST['locationIdHidden'], data_check($_POST['loc_name']), data_check($_POST['loc_code']), $_POST['loc_rows'], $_POST['loc_cols'], $_POST['loc_type'], $_POST['loc_floor'], $_POST['loc_cap']];
  $dup = "select * from institute_location where location_id='" . $_POST["locationIdHidden"] . "'";
  $dup_alert = "Could Not Update - Duplicate Entries";
  updateData($conn, 'institute_location', $fields, $values, $dup, $dup_alert);
 } elseif ($_POST["action"] == "locationList") {
  // echo "MyId- $myId";
  $sql = "SELECT * from institute_location where location_status='0' order by location_name";
  $json = getTableRow($conn, $sql, array("location_id", "location_name", "location_code"));
  // echo $json;
  $array = json_decode($json, true);
  $count = count($array["data"]);
  //  echo $count;
  for ($i = 0; $i < count($array["data"]); $i++) {
   $location_id = $array["data"][$i]["location_id"];
   $location_name = $array["data"][$i]["location_name"];
   $location_code = $array["data"][$i]["location_code"];

   echo '<div class="card">
   <div class="card-body mb-0">
			<div class="row">
			<div class="col-10">
   <h7>' . $location_name . '</h7><br>
			</div>
			<div class="col-2">
			<a href="#" class="fa fa-edit editLocation" data-loc="' . $location_id . '"></a>
			</div>
			</div>
   <h8 class="card-subtitle mb-2 text-muted">' . $location_code . ' </h8>
   </div></div>';
  }
 }
}
