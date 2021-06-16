<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
//echo $_POST['action'];

if (isset($_POST['rpAction'])) {
  if ($_POST['rpAction'] == 'addRP') {

    $sql = "insert into resource_person (rp_name, rp_designation, rp_mobile, rp_email, rp_address, rp_about, update_id, rp_status) values('" . data_check($_POST['rp_name']) . "','" . data_check($_POST['rp_designation']) . "','" . data_check($_POST['rp_mobile']) . "','" . data_check($_POST['rp_email']) . "','" . data_check($_POST['rp_address']) . "','" . data_check($_POST['rp_about']) . "','$myId','0')";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    echo "Added";
  } elseif ($_POST['rpAction'] == 'resourcePersonList') {
    $sql = "select * from resource_person order by rp_name";
    $result = $conn->query($sql);

    while ($rowsArray = $result->fetch_assoc()) {
      $id = $rowsArray["rp_id"];
      $status = $rowsArray["rp_status"];
      echo '<div class="card myCard m-2">';
      echo '<div class="ml-2"><b>' . $rowsArray["rp_name"] . '</b>(' . $rowsArray["rp_designation"] . ')</div>';
      echo '<div class="row m-2">';
      echo '<div class="col-sm-10">';
      echo '<div class="cardBodyText">' . $rowsArray["rp_address"] . '</div>';
      echo '</div>';
      echo '</div>';
      echo '<div class="card-footer">';
      echo '<div class="cardBodyText text-center">';
      echo '<a href="#" class="float-left rp_idE" data-id="' . $id . '"><i class="fa fa-edit"></i></a>';
      echo '<i class="fa fa-mobile"></i> ' . $rowsArray["rp_mobile"] . ' | <i class="fa fa-envelope"></i> ' . $rowsArray["rp_email"];
      if ($status == "9") echo '<a href="#" class="float-right rp_idR" data-id="' . $id . '"><i class="fa fa-refresh" aria-hidden="true"></i></a>';
      else echo '<a href="#" class="float-right rp_idD" data-id="' . $id . '"><i class="fa fa-trash"></i></a>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
    }
  }
}
if (isset($_POST['orgAction'])) {
  if ($_POST['orgAction'] == 'orgList') {
    $sql = "select * from organization";
    $result = $conn->query($sql);
    $json_array = array();
    while ($output = $result->fetch_assoc()) {
      $json_array[] = $output;
    }
    echo json_encode($json_array);
  } elseif ($_POST['orgAction'] == 'addOrg') {
    $sql = "insert into organization (org_name, org_url, org_mobile, org_email, org_address, org_about,update_id, org_status) values('" . data_check($_POST['org_name']) . "','" . data_check($_POST['org_url']) . "','" . data_check($_POST['org_mobile']) . "','" . data_check($_POST['org_email']) . "','" . data_check($_POST['org_address']) . "','" . data_check($_POST['org_about']) . "','$myId','0')";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    echo "Added";
  }
}
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'selectList') {
    $tag = $_POST['tag'];
    if ($tag == 'rp') $sql = "select * from resource_person where rp_status='0'";
    elseif ($tag == 'org') $sql = "select * from organization where org_status='0'";
    $idField = $tag . '_id';
    $nameField = $tag . '_name';
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    echo '<select class="form-control form-control-sm" id="selectId" name="selectId" required>';
    // echo '<option>Select a Grid</option>';
    while ($rowsArray = $result->fetch_assoc()) {
      $id = $rowsArray[$idField];
      $name = $rowsArray[$nameField];
      if ($tag == 'rp') echo '<option value="' . $id . '">' . $rowsArray["rp_name"] . '(' . $rowsArray["rp_name"] . ')</option>';
      elseif ($tag == 'org') echo '<option value="' . $id . '">' . $rowsArray["org_name"] . '(' . $rowsArray["org_name"] . ')</option>';
      else echo '<option value="' . $id . '">' . $name . '</option>';
    }
    echo '</select>';
  }
}
