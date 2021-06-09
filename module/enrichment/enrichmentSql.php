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
  } elseif ($_POST['orgAction'] == 'organizationList') {
    $id = $_POST['orgId'];
    $sql = "SELECT  * FROM organization where org_id='$id'";
    $result = $conn->query($sql);
    $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST['addOrg'] == 'organizationList') {
    $sql = "insert into organization (org_name, org_url, org_mobile, org_email, org_address, org_contact, org_status) values('" . data_check($_POST['org_name']) . "','" . data_check($_POST['org_url']) . "','" . data_check($_POST['org_mobile']) . "','" . data_check($_POST['org_email']) . "','" . data_check($_POST['rp_address']) . "','" . data_check($_POST['rp_about']) . "','$myId','0')";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    echo "Added";
  }
}
if (isset($_POST['orgAction'])) {
}
