<?php
require('../../module/requireSubModule.php');

if (isset($_POST['action'])) {
  if ($_POST['action'] == 'updateBlock') {
    if ($_POST['block_id'] == 0) $sql = "insert into block (block_name, block_floors, block_type, dept_id, update_ts, update_id, block_status) values('" . data_check($_POST['block_name']) . "','" . data_check($_POST['block_floors']) . "','" . data_check($_POST['block_type']) . "','" . data_check($_POST['sel_dept']) . "','$submit_ts','$myId','0')";
    else $sql = "update block set block_name='" . data_check($_POST['block_name']) . "', block_floors='" . data_check($_POST['block_floors']) . "', block_type='" . data_check($_POST['block_type']) . "', dept_id='" . data_check($_POST['sel_dept']) . "', update_ts='$submit_ts' where block_id='" . $_POST['block_id'] . "'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    echo "Updated";
  } elseif ($_POST['action'] == 'blockList') {
    $sql = "select b.*, d.dept_abbri from block b, department d where b.dept_id=d.dept_id and b.block_status='0'";
    $result = $conn->query($sql);
    $json_array = array();
    while ($output = $result->fetch_assoc()) {
      $json_array[] = $output;
    }
    echo json_encode($json_array);
  } elseif ($_POST['action'] == 'blockFetch') {
    $sql = "select b.* from block b where b.block_id='" . $_POST['block_id'] . "'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    elseif ($result->num_rows > 0) {
      $rowArray = $result->fetch_assoc();
      echo json_encode($rowArray);
    }
  } elseif ($_POST['action'] == 'blUpdate') {
    if ($_POST['bl_id'] == 0) $sql = "insert into block_location (block_id, bl_name, bl_code, bl_type, bl_capacity, bl_rows, bl_cols, bl_floor, dept_id, update_ts, update_id, bl_status) values('" . data_check($_POST['block_id']) . "','" . data_check($_POST['bl_name']) . "', '" . data_check($_POST['bl_code']) . "', '" . data_check($_POST['bl_type']) . "', '" . data_check($_POST['bl_capacity']) . "', '" . data_check($_POST['bl_rows']) . "', '" . data_check($_POST['bl_cols']) . "', '" . data_check($_POST['bl_floor']) . "', '" . data_check($_POST['bl_dept']) . "', '$submit_ts', '$myId', '0')";
    else $sql = "update block_location set bl_name='" . data_check($_POST['bl_name']) . "', bl_code='" . data_check($_POST['bl_code']) . "', bl_type='" . data_check($_POST['bl_type']) . "', bl_capacity='" . data_check($_POST['bl_capacity']) . "', bl_rows='" . data_check($_POST['bl_rows']) . "', bl_cols='" . data_check($_POST['bl_cols']) . "', dept_id='" . data_check($_POST['bl_dept']) . "', bl_floor='" . data_check($_POST['bl_floor']) . "', update_ts='$submit_ts' where bl_id='" . $_POST['bl_id'] . "'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    echo "Updated";
  } elseif ($_POST['action'] == 'blList') {
    $sql = "select bl.*, d.dept_abbri from block_location bl, department d where bl.dept_id=d.dept_id and block_id='" . $_POST["block_id"] . "' and bl.bl_status='0'";
    $result = $conn->query($sql);
    $json_array = array();
    while ($output = $result->fetch_assoc()) {
      $json_array[] = $output;
    }
    echo json_encode($json_array);
  } elseif ($_POST['action'] == 'blFetch') {
    $sql = "select bl.* from block_location bl where bl.bl_id='" . $_POST['bl_id'] . "'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    elseif ($result->num_rows > 0) {
      $rowArray = $result->fetch_assoc();
      echo json_encode($rowArray);
    }
  } elseif ($_POST['action'] == 'trUpdate') {
    echo $_POST['tr_id'];
    if ($_POST['tr_id'] == 0) $sql = "insert into $tn_tr (tr_name, tr_code, tr_start, tr_end, update_ts, update_id, tr_status) values('" . data_check($_POST['tr_name']) . "','" . data_check($_POST['tr_code']) . "','" . data_check($_POST['tr_start']) . "','" . data_check($_POST['tr_end']) . "','$submit_ts','$myId','0')";
    else $sql = "update $tn_tr set tr_name='" . data_check($_POST['tr_name']) . "', tr_code='" . data_check($_POST['tr_code']) . "', tr_start='" . data_check($_POST['tr_start']) . "', tr_end='" . data_check($_POST['tr_end']) . "', update_ts='$submit_ts' where tr_id='" . $_POST['tr_id'] . "'";
    if (!$conn->query($sql)) echo $conn->error;
    echo "Updated";
  } elseif ($_POST['action'] == 'trList') {
    $sql = "select * from $tn_tr where 1";
    $result = $conn->query($sql);
    $json_array = array();
    while ($output = $result->fetch_assoc()) {
      $json_array[] = $output;
    }
    echo json_encode($json_array);
  } elseif ($_POST['action'] == 'trFetch') {
    $sql = "select * from $tn_tr where tr_id='" . $_POST['tr_id'] . "'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    elseif ($result->num_rows > 0) {
      $rowArray = $result->fetch_assoc();
      echo json_encode($rowArray);
    }
  } elseif ($_POST['action'] == 'tsUpdate') {
    if ($_POST['ts_id'] == 0) $sql = "insert into $tn_ts (tr_id, ts_name, ts_sno, ts_longitude, ts_lattitude, update_ts, update_id, ts_status) values('" . data_check($_POST['tr_id']) . "', '" . data_check($_POST['ts_name']) . "', '" . data_check($_POST['ts_sno']) . "', '" . data_check($_POST['ts_longitude']) . "', '" . data_check($_POST['ts_lattitude']) . "', '$submit_ts', '$myId', '0')";
    else $sql = "update $tn_ts set ts_name='" . data_check($_POST['ts_name']) . "', ts_sno='" . data_check($_POST['ts_sno']) . "', ts_longitude='" . data_check($_POST['ts_longitude']) . "', ts_lattitude='" . data_check($_POST['ts_lattitude']) . "', update_ts='$submit_ts' where ts_id='" . $_POST['ts_id'] . "'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    echo "Updated";
  } elseif ($_POST['action'] == 'tsList') {
    $sql = "select * from $tn_ts where tr_id='".$_POST['tr_id']."'";
    $result = $conn->query($sql);
    $json_array = array();
    while ($output = $result->fetch_assoc()) {
      $json_array[] = $output;
    }
    echo json_encode($json_array);
  } elseif ($_POST['action'] == 'tsFetch') {
    $sql = "select * from $tn_ts where ts_id='" . $_POST['ts_id'] . "'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    elseif ($result->num_rows > 0) {
      $rowArray = $result->fetch_assoc();
      echo json_encode($rowArray);
    }
  }
}
