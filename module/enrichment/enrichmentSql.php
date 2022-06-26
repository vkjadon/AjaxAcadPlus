<?php
require('../../module/requireSubModule.php');

//echo $_POST['action'];

if (isset($_POST['action'])) {
  if ($_POST['action'] == 'addRP') {
    if ($_POST['rp_id'] == 0) $sql = "insert into resource_person (rp_name, rp_designation, rp_mobile, rp_email, rp_address, rp_about, update_id, rp_status) values('" . data_check($_POST['rp_name']) . "','" . data_check($_POST['rp_designation']) . "','" . data_check($_POST['rp_mobile']) . "','" . data_check($_POST['rp_email']) . "','" . data_check($_POST['rp_address']) . "','" . data_check($_POST['rp_about']) . "','$myId','0')";
    else $sql = "update resource_person set rp_name='" . data_check($_POST['rp_name']) . "', rp_designation='" . data_check($_POST['rp_designation']) . "', rp_mobile='" . data_check($_POST['rp_mobile']) . "', rp_email='" . data_check($_POST['rp_email']) . "', rp_address='" . data_check($_POST['rp_address']) . "', rp_about='" . data_check($_POST['rp_about']) . "', update_id='$myId' where rp_id='" . $_POST['rp_id'] . "'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    echo "Updated";
  } elseif ($_POST['action'] == 'resourcePersonList') {
    $sql = "select * from resource_person where rp_status='0'";
    $result = $conn->query($sql);
    $json_array = array();
    while ($output = $result->fetch_assoc()) {
      $json_array[] = $output;
    }
    echo json_encode($json_array);
  } elseif ($_POST['action'] == 'fetchRP') {
    $sql = "select rp.* from resource_person rp where rp.rp_id='" . $_POST['rp_id'] . "'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    elseif ($result->num_rows > 0) {
      $rowArray = $result->fetch_assoc();
      echo json_encode($rowArray);
    }
  } elseif ($_POST['action'] == 'orgList') {
    $sql = "select * from organization where org_status='0'";
    $result = $conn->query($sql);
    $json_array = array();
    while ($output = $result->fetch_assoc()) {
      $json_array[] = $output;
    }
    echo json_encode($json_array);
  } elseif ($_POST['action'] == 'addOrg') {
    if ($_POST['org_id'] == 0) $sql = "insert into organization (org_name, org_url, org_mobile, org_email, org_contact, org_address, org_about, update_id, org_status) values('" . data_check($_POST['org_name']) . "','" . data_check($_POST['org_url']) . "','" . data_check($_POST['org_mobile']) . "', '" . data_check($_POST['org_email']) . "', '" . data_check($_POST['org_contact']) . "', '" . data_check($_POST['org_address']) . "','" . data_check($_POST['org_about']) . "','$myId','0')";
    else $sql = "update organization set org_name='" . data_check($_POST['org_name']) . "', org_url='" . data_check($_POST['org_url']) . "', org_mobile='" . data_check($_POST['org_mobile']) . "', org_email='" . data_check($_POST['org_email']) . "', org_contact='" . data_check($_POST['org_contact']) . "', org_address='" . data_check($_POST['org_address']) . "', org_about='" . data_check($_POST['org_about']) . "', update_id='$myId' where org_id='" . $_POST['org_id'] . "'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    echo "Updated !! ";
  } elseif ($_POST['action'] == 'fetchOrg') {
    $sql = "select org.* from organization org where org.org_id='" . $_POST['org_id'] . "'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    elseif ($result->num_rows > 0) {
      $rowArray = $result->fetch_assoc();
      echo json_encode($rowArray);
    }
  } elseif ($_POST['action'] == 'selectList') {
    $tag = $_POST['tag'];
    if ($tag == 'rp') $sql = "select * from resource_person where rp_status='0'";
    elseif ($tag == 'org') $sql = "select * from organization where org_status='0'";
    $idField = $tag . '_id';
    $nameField = $tag . '_name';
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    echo '<select class="form-control form-control-sm" id="sel_' . $tag . '" name="sel_' . $tag . '" required>';
    if ($tag == 'rp') echo '<option> Select a Resouce Person </option>';
    else echo '<option> Select a Resouce Industry </option>';
    while ($rowsArray = $result->fetch_assoc()) {
      $id = $rowsArray[$idField];
      $name = $rowsArray[$nameField];
      if ($tag == 'rp') echo '<option value="' . $id . '">' . $rowsArray["rp_name"] . '(' . $rowsArray["rp_name"] . ')</option>';
      elseif ($tag == 'org') echo '<option value="' . $id . '">' . $rowsArray["org_name"] . '(' . $rowsArray["org_name"] . ')</option>';
      else echo '<option value="' . $id . '">' . $name . '</option>';
    }
    echo '</select>';
  } elseif ($_POST['action'] == 'eaList') {

    $sql = "select ea.*, d.dept_abbri, mn.mn_name from $tn_ea ea, master_name mn, department d where ea.mn_id=mn.mn_id and ea.dept_id=d.dept_id";

    $result = $conn->query($sql);
    if ($result) {
      $json_array = array();
      while ($output = $result->fetch_assoc()) {
        $json_array[] = $output;
      }
      echo json_encode($json_array);
    } else echo $conn->error;
  } elseif ($_POST['action'] == 'addEA') {
    if ($_POST['ea_id'] == 0) $sql = "insert into $tn_ea (mn_id, dept_id, ea_name, ea_from_date, ea_from_time, ea_to_date, ea_to_time, ea_about, ea_extra_attendance, update_id, ea_status) values('" . $_POST['sel_cca'] . "','$myDept','" . data_check($_POST['ea_name']) . "', '" . data_check($_POST['ea_from_date']) . "', '" . data_check($_POST['ea_from_time']) . "', '" . data_check($_POST['ea_to_date']) . "', '" . data_check($_POST['ea_to_time']) . "', '" . data_check($_POST['ea_about']) . "', '" . data_check($_POST['ea_extra_attendance']) . "', '$myId', '0')";
    else $sql = "update $tn_ea set mn_id='" . $_POST['sel_cca'] . "', ea_name='" . data_check($_POST['ea_name']) . "', ea_from_date='" . data_check($_POST['ea_from_date']) . "', ea_from_time='" . data_check($_POST['ea_from_time']) . "', ea_to_date='" . data_check($_POST['ea_to_date']) . "', ea_to_time='" . data_check($_POST['ea_to_time']) . "', ea_about='" . data_check($_POST['ea_about']) . "', ea_extra_attendance='" . data_check($_POST['ea_extra_attendance']) . "', ea_status='0' where ea_id='" . $_POST['ea_id'] . "'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    echo "Added";
  } elseif ($_POST['action'] == 'fetchEA') {
    $sql = "update $tn_ea set ea_status='1' where update_id='$myId'";
    $result = $conn->query($sql);

    $sql = "update $tn_ea set ea_status='0' where ea_id='" . $_POST['ea_id'] . "'";
    $result = $conn->query($sql);

    $sql = "select ea.*, mn.mn_name from $tn_ea ea, master_name mn where ea.ea_id='" . $_POST['ea_id'] . "' and ea.mn_id=mn.mn_id";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    elseif ($result->num_rows > 0) {
      $rowArray = $result->fetch_assoc();
      echo json_encode($rowArray);
    } else {
      $json_array = array("fq_statement" => "No Question is Active");
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'ear_rp') {
    $sql = "insert $tn_ear (ea_id, ear_code, ear_code_id, update_id) values('" . $_POST['ea_id'] . "','rp','" . data_check($_POST['rp_id']) . "', '$myId')";
    // $sql = "insert $tn_ear (ea_id, ear_code, ear_code_id, ear_task_name, ear_task_about, update_id) values('" . $_POST['ea_id'] . "','rp','" . data_check($_POST['rp_id']) . "', '" . data_check($_POST['ear_task_name']) . "', '" . data_check($_POST['ear_task_about']) . "', '$myId')";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    echo "Added";
  } elseif ($_POST['action'] == 'ear_rpList') {
    $sql = "select ear.*, rp.rp_id, rp.rp_name from $tn_ear ear, resource_person rp where ear_code='rp' and ear.ear_code_id=rp.rp_id and ea_id='" . $_POST['ea_id'] . "'";
    $result = $conn->query($sql);
    if ($result) {
      $json_array = array();
      while ($output = $result->fetch_assoc()) {
        $json_array[] = $output;
      }
      echo json_encode($json_array);
    } else echo $conn->error;
  } elseif ($_POST['action'] == 'ear_rpUpdate') {
    $fieldTag = $_POST['tag'];
    $sql = "update $tn_ear set $fieldTag='" . data_check($_POST['value']) . "' where ea_id='" . $_POST['ea_id'] . "' and ear_code_id='" . data_check($_POST['rp_id']) . "' and ear_code='rp'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    echo "Updated";
  } elseif ($_POST['action'] == 'ear_rpDelete') {
    $sql = "delete from $tn_ear where ea_id='" . $_POST['ea_id'] . "' and ear_code_id='" . data_check($_POST['rp_id']) . "' and ear_code='rp'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    echo "Updated";
  } elseif ($_POST['action'] == 'ear_org') {
    $sql = "insert $tn_ear (ea_id, ear_code, ear_code_id, update_id) values('" . $_POST['ea_id'] . "','org','" . data_check($_POST['org_id']) . "', '$myId')";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    echo "Added";
  } elseif ($_POST['action'] == 'ear_orgList') {
    $sql = "select ear.*, org.org_id, org.org_name from $tn_ear ear, organization org where ear_code='org' and ear.ear_code_id=org.org_id and ea_id='" . $_POST['ea_id'] . "'";
    $result = $conn->query($sql);
    if ($result) {
      $json_array = array();
      while ($output = $result->fetch_assoc()) {
        $json_array[] = $output;
      }
      echo json_encode($json_array);
    } else echo $conn->error;
  } elseif ($_POST['action'] == 'ear_orgUpdate') {
    $fieldTag = $_POST['tag'];
    $sql = "update $tn_ear set $fieldTag='" . data_check($_POST['value']) . "' where ea_id='" . $_POST['ea_id'] . "' and ear_code_id='" . data_check($_POST['org_id']) . "' and ear_code='org'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    echo "Updated";
  } elseif ($_POST['action'] == 'ear_orgDelete') {
    $sql = "delete from $tn_ear where ea_id='" . $_POST['ea_id'] . "' and ear_code_id='" . data_check($_POST['org_id']) . "' and ear_code='org'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    echo "Updated";
  } elseif ($_POST['action'] == "deptClassList") {

    $sql = "select * from $tn_ea where update_id='$myId' and ea_status='0'";
    $ea_id = getFieldValue($conn, "ea_id", $sql);

    $sql = "select cl.* from class cl where cl.session_id='$mySes' and cl.dept_id='$myDept' and cl.class_status='0' order by cl.class_semester";

    $result = $conn->query($sql);
    $data = array();
    if ($result) {
      while ($rowsArray = $result->fetch_assoc()) {
        $subArray = array();
        $class_id = $rowsArray["class_id"];
        $query = "select * from $tn_eap where eap_code='class' and eap_code_id='$class_id' and ea_id='$ea_id'";
        $check = $conn->query($query)->num_rows;
        $subArray["class_id"] = $class_id;
        $subArray["class_name"] = $rowsArray["class_name"];
        $subArray["class_section"] = $rowsArray["class_section"];
        if ($check > 0) $subArray["check"] = "1";
        else $subArray["check"] = "0";
        $data[] = $subArray;
      }
    }
    $jsonOutput = json_encode($data);
    echo $jsonOutput;
  } elseif ($_POST['action'] == "participant") {
    $sql = "select * from $tn_ea where update_id='$myId' and ea_status='0'";
    $ea_id = getFieldValue($conn, "ea_id", $sql);
    echo $ea_id;
    if ($_POST['status'] == 'true') $sql = "insert into $tn_eap (ea_id, eap_code, eap_code_id, update_id) values('$ea_id', 'class', '" . $_POST['classId'] . "', '$myId')";
    else $sql = "delete from $tn_eap where ea_id='$ea_id' and eap_code='class' and eap_code_id='" . $_POST['classId'] . "'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      echo "Query Successful";
    }
  }
}
