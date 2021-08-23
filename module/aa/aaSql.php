<?php
require('../requireSubModule.php');

//echo $_POST['action'];
if (isset($_POST['action'])) {
  if ($_POST["action"] == "batchList") {
    //    echo "MyId- $myId";
    $tableId = 'batch_id';
    $statusDecode = array("status" => "batch_status", "0" => "Active", "1" => "Removed");
    $button = array("E", "Session", "D");
    $fields = array("batch", "batch_status");
    $dataType = array("0");
    $sql = "select * from batch order by batch desc";
    getListCard($conn, $tableId, $fields, $dataType, $sql, $statusDecode, $button);
  } elseif ($_POST["action"] == "addBatch") {
    $batch = data_check($_POST['newBatch']);
    $ay = data_check($_POST['ay']);
    $fields = ['batch', 'academic_year', 'update_id', 'batch_status'];
    $values = [$batch, $ay, $myId, '0'];
    $status = 'batch_status';
    $dup = "select * from batch where batch='" . data_check($_POST["newBatch"]) . "'";
    $dup_alert = " Batch already Exists !!";
    addData($conn, 'batch', 'batch_id', $fields, $values, $status, $dup, $dup_alert);
    // echo "dbsj";
  } elseif ($_POST["action"] == "fetchBatch") {
    $id = $_POST['batchId'];
    $sql = "select * FROM batch where batch_id='$id'";
    $result = $conn->query($sql);
    $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST["action"] == "updateBatch") {
    $fields = ['batch_id', 'batch', 'academic_year'];
    $values = [$_POST['modalId'], data_check($_POST['newBatch']), data_check($_POST['ay'])];
    $dup = "select * from batch where batch_id='" . $_POST["modalId"] . "'";
    $dup_alert = "Could Not Update - Duplicate Entries";
    updateData($conn, 'batch', $fields, $values, $dup, $dup_alert);
    // echo "inside update batch";
  } elseif ($_POST['action'] == 'batchSession') {
    $ay_id = $_POST['batchId'];
    $json = get_schoolSession($conn, $ay_id);
    //echo $json;
    $array = json_decode($json, true);
    //echo count($array);
    //echo count($array["data"]);
    for ($i = 0; $i < count($array["data"]); $i++) {
      echo '<div class="row m-2">';
      echo '<div class="col-sm-2">';
      $school_id = $array["data"][$i]["school_id"];
      $school_abbri = getField($conn, $school_id, "school", "school_id", "school_abbri");
      echo '<span>' . $school_abbri . '</span>';
      echo '<p>[' . $array["data"][$i]["id"] . '] ';
      echo '<a href="#" class="session_idE" data-id="' . $array["data"][$i]["id"] . '"><i class="fa fa-edit"></i></a></p>';
      echo '</div>';
      $ay_id = $array["data"][$i]["ay_id"];
      $batch = getField($conn, $ay_id, "batch", "batch_id", "batch");
      $academic_year = $batch . '-' . ($batch - 1999);

      echo '<div class="col-sm-4">';
      echo '<span class="cardBodyText">AY ' . $academic_year . '</span>';
      echo '<p class="cardBodyText">Start : ' . $array["data"][$i]["start"] . '</p>';
      echo '</div>';

      echo '<div class="col-sm-4">';
      echo '<span class="cardBodyText">' . $array["data"][$i]["name"] . '</span>';
      echo '<p class="cardBodyText">End : ' . $array["data"][$i]["end"] . '</p>';
      echo '</div>';
      echo '<div class="col-sm-2">';
      echo '<a href="#" class="float-right session_idD" data-id="' . $array["data"][$i]["id"] . '"><i class="fa fa-trash"></i></a>';
      echo '</div>';
      echo '</div></div>';
    }
    if (count($array["data"]) == 0) echo "No Session Found";
  } elseif ($_POST["action"] == "addSession") {
    //echo "Add Session";
    $fields = ['school_id', 'ay_id', 'session_name', 'session_start', 'session_end', 'session_remarks'];
    $values = [$myScl, $_POST['batchIdModal'], data_check($_POST['session_name']), data_check($_POST['session_start']), data_check($_POST['session_end']), data_check($_POST['session_remarks'])];
    $status = 'session_status';
    $dup = "select * from session where session_name='" . data_check($_POST["session_name"]) . "' and school_id='" . $myScl . "'  and ay_id='" . $myBatch . "'and $status='0'";
    $dup_alert = "Session Alreday Exists ! Please Change the Name";
    addData($conn, 'session', 'session_id', $fields, $values, $status, $dup, $dup_alert);
  } elseif ($_POST["action"] == "fetchSession") {
    $id = $_POST['sessionId'];
    $sql = "select * FROM session where session_id='$id'";
    $result = $conn->query($sql);
    $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST["action"] == "updateSession") {
    $fields = ['session_id', 'session_name', 'session_remarks', 'session_start', 'session_end'];
    $values = [$_POST['modalId'], data_check($_POST['session_name']), data_check($_POST['session_remarks']), $_POST['session_start'], $_POST['session_end']];
    $dup_alert = "Could Not Update - Duplicate Entries";
    updateUniqueData($conn, 'session', $fields, $values, $dup_alert);
    // echo "inside update batch";
  } elseif ($_POST["action"] == "addPo") {
    // echo "Add PO";
    //echo "batchId " . $_POST['batchIdModal'];
    $fields = ['program_id', 'batch_id', 'po_name', 'po_code', 'po_sno'];
    $values = [$myProg, $myBatch, data_check($_POST['poStatement']), data_check($_POST['poCode']), data_check($_POST['poSno'])];
    $status = 'po_status';
    $dup = "select * from program_outcome where po_sno='" . data_check($_POST["poSno"]) . "' and program_id='" . $myProg . "'  and batch_id='" . $myBatch . "'and $status='0'";
    $dup_alert = "Serial Number Alreday Exists ! Please Check the Order!!";
    addData($conn, 'program_outcome', 'po_id', $fields, $values, $status, $dup, $dup_alert);
  } elseif ($_POST['action'] == 'fetchPo') {
    $id = $_POST['poId'];
    $sql = "select * FROM program_outcome where po_id='$id'";
    $result = $conn->query($sql);
    $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST['action'] == 'updatePo') {
    $fields = ['po_id', 'po_code', 'po_name', 'po_sno'];
    $values = [$_POST['modalId'], data_check($_POST['poCode']), data_check($_POST['poStatement']), data_check($_POST['poSno'])];
    $dup = "select * from program_outcome where po_sno='" . $_POST["poSno"] . "' and po_name='" . $_POST["poStatement"] . "' and program_id='" . $_POST["programIdModal"] . "' and batch_id='" . $_POST["batchIdModal"] . "'";
    $dup_alert = "Could Not Update - Duplicate Entries";
    updateData($conn, 'program_outcome', $fields, $values, $dup, $dup_alert);
  } elseif ($_POST["action"] == "poList") {
    //echo "MyId- $myProg - $myBatch";
    $sql = "select * from program_outcome where program_id='$myProg' and batch_id='$myBatch' order by po_sno, po_code";
    $json = getTableRow($conn, $sql, array("po_id", "program_id", "batch_id", "po_code", "po_name", "po_sno", "po_status"));
    $array = json_decode($json, true);

    for ($i = 0; $i < count($array["data"]); $i++) {
      $po_id = $array["data"][$i]["po_id"];
      $program_id = $array["data"][$i]["program_id"];
      $batch_id = $array["data"][$i]["batch_id"];
      $po_code = $array["data"][$i]["po_code"];
      $po_sno = $array["data"][$i]["po_sno"];
      $po_name = $array["data"][$i]["po_name"];
      $status = $array["data"][$i]["po_status"];
      echo '<div class="card myCard">';

      echo '<div class="row border border-primary mb-1 cardBodyText">';
      echo '<div class="col-sm-3 mb-0 bg-two">';
      echo 'ID : ' . $po_id;
      echo '<a href="#" class="float-right po_idE" data-id="' . $po_id . '"><i class="fa fa-edit"></i></a>';
      echo '<div><b>' . $array["data"][$i]["po_code"] . $po_sno . '</b></div>';
      echo '</div>';

      echo '<div class="col-sm-8">';
      echo '<div class="cardBodyText"><b>' . $po_name . '</b></div>';
      echo '</div>';

      echo '<div class="col-sm-1">';
      if ($status == "9") echo '<a href="#" class="float-right po_idR" data-id="' . $po_id . '">Removed</a>';
      else echo '<a href="#" class="float-right po_idD" data-id="' . $po_id . '"><i class="fa fa-trash"></i></a>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
    }
  } elseif ($_POST["action"] == "poSummary") {
    //echo "MyId- $myProg - $myBatch";
    $sql = "select * from program where program_status='0'";
    $result = $conn->query($sql);
    if ($result) {
      echo '<div class="row shadow border border-primary mt-2 cardBodyText">';
      while ($row = $result->fetch_assoc()) {
        $program_id = $row["program_id"];
        $program_abbri = $row["program_abbri"];
        $sp_name = $row["sp_name"];
        $sql = "select * from program_outcome where program_id='$program_id' and batch_id='$myBatch' and po_status='0'";
        $resultPO = $conn->query($sql);
        if ($resultPO) $poRows = $resultPO->num_rows;
        else $poRows = 0;

        echo '<div class="col-sm-4">' . $program_abbri . '</div>';
        echo '<div class="col-sm-6">' . $sp_name . '</div>';
        if ($poRows > 0) echo '<div class="col-sm-2 inputLabel">' . $poRows . '</div>';
        else echo '<div class="col-sm-2"><i class="fa fa-times"></i></div>';
      }
      echo '</div>';
    } else echo $conn->error;
  } elseif ($_POST["action"] == "headName") {
    $sql = "insert into master_name (mn_code, mn_name, mn_abbri, mn_remarks, mn_status, update_id) values('" . $_POST["headName"] . "', '" . $_POST["name"] . "', '" . $_POST["abbri"] . "', '" . $_POST["remarks"] . "', '0', '$myId')";
    $conn->query($sql);
    echo "Added Successfully";
  } elseif ($_POST["action"] == "masterNameList") {
    //echo "MyId- $myProg - $myBatch";
    $sql = "select * from master_name where mn_code='" . $_POST['headName'] . "' order by mn_name";
    $result = $conn->query($sql);
    echo '<div class="card myCard m-2">';

    while ($row_mn = $result->fetch_assoc()) {
      $mn_id = $row_mn["mn_id"];
      $status = $row_mn["mn_status"];
      echo '<div class="row m-2">';
      echo '<div class="col-sm-2 p-0 pl-1">';
      echo '<a href="#" class="po_idE" data-id="' . $mn_id . '"><i class="fa fa-edit"></i></a>';
      echo ' [' . $mn_id . ']';
      echo '</div>';
      echo '<div class="col-sm-6">';
      echo '<div class="cardBodyText"><b>' . $row_mn["mn_name"] . '</b></div>';
      echo '</div>';
      echo '<div class="col-sm-3">';
      echo '<div class="cardBodyText"><b>' . $row_mn["mn_abbri"] . '</b></div>';
      echo '</div>';
      echo '<div class="col-sm-1">';
      if ($status == "9") echo '<a href="#" class="float-right po_idR" data-id="' . $mn_id . '">Removed</a>';
      else echo '<a href="#" class="float-right po_idD" data-id="' . $mn_id . '"><i class="fa fa-trash"></i></a>';
      echo '</div>';
      echo '</div>';
    }
    echo '</div>';
  } elseif ($_POST['action'] == 'selectList') {
    $tag = $_POST['tag'];
    if ($tag == 'school') $sql = "select * from school where school_status='0' order by school_name";
    elseif ($tag == 'dept') $sql = "select * from department where dept_status='0' order by dept_name";
    elseif ($tag == 'program') $sql = "select * from program where program_status='0' order by program_name";
    elseif ($tag == 'class') $sql = "select * from class where class_status='0' and session_id='$mySes' order by class_name";
    $idField = $tag . '_id';
    $nameField = $tag . '_name';
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    echo '<select class="form-control form-control-sm" id="selectId" name="selectId" required>';
    // echo '<option>Select a Grid</option>';
    while ($rowsArray = $result->fetch_assoc()) {
      $id = $rowsArray[$idField];
      $name = $rowsArray[$nameField];
      if ($tag == 'program') echo '<option value="' . $id . '">' . $rowsArray["program_abbri"] . '(' . $rowsArray["sp_name"] . ')</option>';
      elseif ($tag == 'class') echo '<option value="' . $id . '">' . $rowsArray["class_name"] . '(' . $rowsArray["class_section"] . ')</option>';
      else echo '<option value="' . $id . '">' . $name . '</option>';
    }
    echo '</select>';
  } elseif ($_POST['action'] == "searchStaff") {
    $output = '';
    $sql = "select * from staff where staff_name LIKE '%" . $_POST["searchString"] . "%'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    $output = '<ul class="list-group p-0 m-0">';
    if ($result) {
      while ($row = $result->fetch_assoc()) {
        $output .= '<li class="list-group-item list-group-item-action staffAutoList"  data-staff="' . $row["staff_id"] . '" >' . $row["staff_name"] . ' [' . $row["user_id"] . ']</li>';
      }
    } else {
      $output .= '<li>Staff Not Found</li>';
    }
    $output .= '</ul>';
    echo $output;
  } elseif ($_POST["action"] == "respName") {
    $sql = "insert into responsibility_staff (rs_code, staff_id, unit_id, rs_from_date, rs_to_date, rs_remarks, update_id, rs_status) values('" . $_POST["respName"] . "', '" . $_POST["staffId"] . "', '" . $_POST["selectId"] . "', '" . $_POST["respFrom"] . "', '" . $_POST["respTo"] . "', '" . $_POST["respRemarks"] . "', '$myId', '0')";
    $conn->query($sql);
  }
}
