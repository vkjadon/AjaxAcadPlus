<?php
session_start();

require("config_database.php");

if (isset($_POST['action'])) {
  if ($_POST['action'] == 'pmList') {
    $sql = "select * from portal_menu where pm_status='0' order by pm_sno";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      while ($rowsStudent = $result->fetch_assoc()) {
        $json_array[] = $rowsStudent;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'pgList') {
    $pm_id = $_POST['pm_id'];
    $sql = "select * from portal_group where pg_status='0' and pm_id='$pm_id' order by pg_sno";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      while ($rowsStudent = $result->fetch_assoc()) {
        $json_array[] = $rowsStudent;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'plList') {
    $pg_id = $_POST['pg_id'];
    $sql = "select * from portal_link where pl_status='0' and pg_id='$pg_id' order by pl_sno";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      $json_array = array();
      while ($rowsStudent = $result->fetch_assoc()) {
        $json_array[] = $rowsStudent;
      }
      echo json_encode($json_array);
    }
  } elseif ($_POST['action'] == 'fetchMenu') {
    $pm_id = $_POST['pm_id'];
    $sql = "select * from portal_menu where pm_id='$pm_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $json_array = $row;
    echo json_encode($json_array);
  } elseif ($_POST['action'] == 'addUpdateMenu') {
    $pm_id = $_POST['pm_hidden'];
    $pm_name = $_POST['pm_name'];
    $pm_sno = $_POST['pm_sno'];
    if ($pm_id == 0) {
      $sql = "insert into portal_menu (pm_name, pm_sno, pm_status) values('$pm_name', '$pm_sno', '0')";
    } else $sql = "update portal_menu set pm_name='$pm_name', pm_sno='$pm_sno' where pm_id='$pm_id'";
    $result = $conn->query($sql);
  } elseif ($_POST['action'] == 'fetchGroup') {
    $pg_id = $_POST['pg_id'];
    $sql = "select * from portal_group where pg_id='$pg_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $json_array = $row;
    echo json_encode($json_array);
  } elseif ($_POST['action'] == 'addUpdateGroup') {
    $pm_id = $_POST['sel_pm'];
    $pg_id = $_POST['pg_hidden'];
    $pg_name = $_POST['pg_name'];
    $pg_sno = $_POST['pg_sno'];
    if ($pg_id == 0) {
      $sql = "insert into portal_group (pm_id, pg_name, pg_sno, pg_status) values('$pm_id', '$pg_name', '$pg_sno', '0')";
    } else $sql = "update portal_group set pm_id='$pm_id', pg_name='$pg_name', pg_sno='$pg_sno' where pg_id='$pg_id'";
    $result = $conn->query($sql);
  } elseif ($_POST['action'] == 'fetchLink') {
    $pl_id = $_POST['pl_id'];
    $sql = "select * from portal_link where pl_id='$pl_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $json_array = $row;
    echo json_encode($json_array);
  }elseif ($_POST['action'] == 'addUpdateLink') {
    $pg_id = $_POST['sel_pg'];
    $pl_id = $_POST['pl_hidden'];
    $pl_name = $_POST['pl_name'];
    $pl_sno = $_POST['pl_sno'];
    if ($pl_id == 0) {
      $sql = "insert into portal_link (pg_id, pl_name, pl_sno, pl_status) values('$pg_id', '$pl_name', '$pl_sno', '0')";
    } else $sql = "update portal_link set pl_id='$pl_id', pl_name='$pl_name', pl_sno='$pl_sno' where pl_id='$pl_id'";
    $result = $conn->query($sql);
  }
}
