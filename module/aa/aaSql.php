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
    addActivity($conn, $myId, "Add Batch", $submit_ts);
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
    addActivity($conn, $myId, "Update Batch", $submit_ts);

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
    $fields = ['school_id', 'ay_id', 'session_name', 'session_start', 'session_end', 'session_remarks', 'update_id', 'session_status'];
    $values = [$myScl, $_POST['batchIdModal'], data_check($_POST['session_name']), data_check($_POST['session_start']), data_check($_POST['session_end']), data_check($_POST['session_remarks']), $myId, '0'];
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
  } elseif ($_POST["action"] == "headName") {
    $id = $_POST['mn_id'];
    if ($id == 0) $sql = "insert into master_name (mn_code, mn_name, mn_abbri, mn_remarks, mn_status, update_id) values('" . $_POST["headName"] . "', '" . $_POST["name"] . "', '" . $_POST["abbri"] . "', '" . $_POST["remarks"] . "', '0', '$myId')";
    else $sql = "update master_name set mn_name='" . $_POST["name"] . "', mn_abbri='" . $_POST["abbri"] . "', mn_remarks='" . $_POST["remarks"] . "' where mn_id='$id'";
    if ($id > 0) $text = "Update Successfully";
    else $text = "Added Successfully";
    if ($conn->query($sql)) echo $text;
    else echo $conn->error;
  } elseif ($_POST["action"] == "mnUpdate") {
    if ($_POST["tag"] == "D") $sql = "update master_name set mn_status='9' where mn_id='" . $_POST["mn_id"] . "'";
    else $sql = "update master_name set mn_status='0' where mn_id='" . $_POST["mn_id"] . "'";
    $conn->query($sql);
    // echo "inside update batch";
  } elseif ($_POST["action"] == "mnFetch") {
    $id = $_POST['mn_id'];
    $sql = "select * FROM master_name where mn_id='$id'";
    $result = $conn->query($sql);
    $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST["action"] == "masterNameList") {
    //echo "MyId- $myProg - $myBatch";
    $sql = "select * from master_name where mn_code='" . $_POST['headName'] . "' order by mn_status, mn_name";
    $result = $conn->query($sql);
    echo '<div class="card myCard m-2">';

    while ($row_mn = $result->fetch_assoc()) {
      $mn_id = $row_mn["mn_id"];
      $status = $row_mn["mn_status"];
      echo '<div class="row m-2">';
      echo '<div class="col-sm-2 p-0 pl-1">';
      echo '<a href="#" class="mn_idE" data-id="' . $mn_id . '"><i class="fa fa-edit"></i></a>';
      echo ' [' . $mn_id . ']';
      echo '</div>';
      echo '<div class="col-sm-5">';
      echo '<div class="cardBodyText"><b>' . $row_mn["mn_name"] . '</b></div>';
      echo '</div>';
      echo '<div class="col-sm-2">';
      echo '<div class="cardBodyText"><b>' . $row_mn["mn_abbri"] . '</b></div>';
      echo '</div>';
      echo '<div class="col-sm-2">';
      echo '<div class="cardBodyText"><b>' . $row_mn["mn_remarks"] . '</b></div>';
      echo '</div>';
      echo '<div class="col-sm-1">';
      if ($status == "9") echo '<a href="#" class="float-right mnUpdate" data-tag="R" data-id="' . $mn_id . '"><i class="fa fa-refresh"></i></a>';
      else echo '<a href="#" class="float-right mnUpdate" data-tag="D" data-id="' . $mn_id . '"><i class="fa fa-trash"></i></a>';
      echo '</div>';
      echo '</div>';
    }
    echo '</div>';
  } elseif ($_POST['action'] == 'selectTemplate') {
    $sql = "select * from $tn_atmp where atmp_status='0' group by atmp_template order by atmp_template desc";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    $i = 1;
    echo '<select class="form-control form-control-sm" id="sel_template" name="sel_template" required>';
    //echo '<option>Select a Template</option>';
    while ($rowsArray = $result->fetch_assoc()) {
      $id = $rowsArray["atmp_template"];
      echo '<option value="' . $id . '">Template-' . $id . '</option>';
      $i++;
    }
    echo '<option value="' . $i . '">New Template</option>';
    echo '</select>';
  } elseif ($_POST['action'] == 'addTemplate') {
    $sql = "insert into $tn_atmp (atmp_template, atmp_weightage, atmp_internal, update_id, atmp_status) values('" . data_check($_POST['sel_template']) . "', '" . data_check($_POST['weightage']) . "', '" . data_check($_POST['internal']) . "', '$myId','0')";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    echo "Added";
  } elseif ($_POST['action'] == 'atmpList') {
    $totalTemplates = getMaxField($conn, $tn_atmp, "atmp_template");
    //echo $totalTemplates;
    echo '<div class="row">';
    for ($i = 1; $i <= $totalTemplates; $i++) {
      $sql = "select * from $tn_atmp where atmp_template='$i' order by atmp_internal";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      echo '<div class="col-md-3 pr-1">';
      echo '<div class="container card mt-2 myCard">';
      echo '<h4">Template-' . $i . '</h4>';
      echo '<table class="table table-striped list-table-xs">';
      echo '<tr><th></th><th>Component</th><th>Weightage</th><th></th></tr>';
      while ($rowsArray = $result->fetch_assoc()) {
        $status = $rowsArray["atmp_status"];
        $internal = $rowsArray["atmp_internal"];
        $id = $rowsArray["atmp_id"];
        //echo $at.'-'.$am;
        echo '<tr>';
        echo '<td><a href="#" class="fa fa-pencil-alt float-left rp_idE" data-id="' . $rowsArray["atmp_id"] . '"></a></td>';
        if ($internal == '1') echo '<td>CIE (Internal)</td>';
        else echo '<td>SEE (External)</td>';
        echo '<td>' . $rowsArray["atmp_weightage"] . '</td>';
        if ($status == "9") echo '<td><a href="#" class="float-right rp_idR" data-id="' . $rowsArray["atmp_id"] . '"><i class="fa fa-refresh" aria-hidden="true"></i></a></td>';
        else echo '<td><a href="#" class="float-right rp_idD" data-id="' . $rowsArray["atmp_id"] . '"><i class="fa fa-trash"></i></a></td>';
        echo '</tr>';
      }
      echo '</table>';
      echo '</div>';
      echo '</div>';
    }
    echo '</div>';
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
    $sql = "insert into responsibility_staff (mn_id, staff_id, rs_from_date, rs_to_date, rs_remarks, update_id, rs_status) values('" . $_POST["mn_id"] . "', '" . $_POST["staffId"] . "', '" . $_POST["respFrom"] . "', '" . $_POST["respTo"] . "', '" . $_POST["respRemarks"] . "', '$myId', '0')";
    $conn->query($sql);
  } elseif ($_POST["action"] == "respList") {
    //echo "MyId- $myProg - $myBatch";
    $sql = "select * from responsibility_staff where mn_id='" . $_POST['mn_id'] . "'";
    $result = $conn->query($sql);
    echo '<table class="table list-table-xs">';

    while ($row_mn = $result->fetch_assoc()) {
      $rs_id = $row_mn["rs_id"];
      $status = $row_mn["rs_status"];
      echo '<tr>';
      echo '<td>';
      echo '<a href="#" class="po_idE" data-id="' . $rs_id . '"><i class="fa fa-edit"></i></a>';
      echo ' [' . $rs_id . ']';
      echo '</td';
      echo '<td>';
      echo getField($conn, $row_mn["staff_id"], "staff", "staff_id", "staff_name");
      echo '</td>';
      echo '<td>' . $row_mn["rs_from_date"] . '</td>';
      echo '<td>' . $row_mn["rs_to_date"] . '</td>';
      echo '<td>';
      if ($status == "9") echo '<a href="#" class="float-right po_idR" data-id="' . $rs_id . '">Removed</a>';
      else echo '<a href="#" class="float-right po_idD" data-id="' . $rs_id . '"><i class="fa fa-trash"></i></a>';
      echo '</td>';
      echo '</tr>';
    }
    echo '</table>';
  } elseif ($_POST["action"] == "hod" || $_POST["action"] == "dir" || $_POST["action"] == "gd") {
    $sql = "insert into responsibility_staff (unit_id, rs_code, staff_id, rs_from_date, rs_to_date, rs_remarks, update_id, rs_status) values('" . $_POST["mn_id"] . "', '" . $_POST["action"] . "', '" . $_POST["staffId"] . "', '" . $_POST["respFrom"] . "', '" . $_POST["respTo"] . "', '" . $_POST["respRemarks"] . "', '$myId', '0')";
    if (!$conn->query($sql)) echo $conn->error;
    else echo "Added";
  } elseif ($_POST["action"] == "headList") {
    //echo "MyId- $myProg - $myBatch";
    $sql = "select * from responsibility_staff where unit_id='" . $_POST['unit_id'] . "' and rs_code='" . $_POST['head'] . "' ";
    $result = $conn->query($sql);
    echo '<table class="table list-table-xs">';

    while ($row_mn = $result->fetch_assoc()) {
      $rs_id = $row_mn["rs_id"];
      $status = $row_mn["rs_status"];
      echo '<tr>';
      echo '<td>';
      echo '<a href="#" class="po_idE" data-id="' . $rs_id . '"><i class="fa fa-edit"></i></a>';
      echo ' [' . $rs_id . ']';
      echo '</td';
      echo '<td>';
      echo getField($conn, $row_mn["staff_id"], "staff", "staff_id", "staff_name");
      echo '</td>';
      echo '<td>' . $row_mn["rs_from_date"] . '</td>';
      echo '<td>' . $row_mn["rs_to_date"] . '</td>';
      echo '<td>';
      if ($status == "9") echo '<a href="#" class="float-right po_idR" data-id="' . $rs_id . '">Removed</a>';
      else echo '<a href="#" class="float-right po_idD" data-id="' . $rs_id . '"><i class="fa fa-trash"></i></a>';
      echo '</td>';
      echo '</tr>';
    }
    echo '</table>';
  } elseif ($_POST['action'] == 'selectList') {
    $tag = $_POST['tag'];
    $mn_abbri = getField($conn, $tag, "master_name", "mn_id", "mn_abbri");
    if ($mn_abbri == 'inst') {
      $sql = "select * from school where school_status='0' order by school_name";
      $tableTag = 'school';
    } elseif ($mn_abbri == 'dept') {
      $sql = "select * from department where dept_status='0' order by dept_name";
      $tableTag = 'dept';
    } elseif ($mn_abbri == 'prog') {
      $sql = "select * from program where program_status='0' order by program_name";
      $tableTag = 'program';
    } elseif ($mn_abbri == 'cl') {
      $sql = "select * from class where class_status='0' and session_id='$mySes' order by class_name";
      $tableTag = 'class';
    } else {
      $sql = "select * from school where school_status='0' order by school_name";
      $tableTag = 'school';
    }
    $idField = $tableTag . '_id';
    $nameField = $tableTag . '_name';
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    echo '<select class="form-control form-control-sm" id="selectId" name="selectId" required>';
    // echo '<option>Select a Grid</option>';
    while ($rowsArray = $result->fetch_assoc()) {
      $id = $rowsArray[$idField];
      $name = $rowsArray[$nameField];
      if ($tableTag == 'program') echo '<option value="' . $id . '">' . $rowsArray["program_abbri"] . '(' . $rowsArray["sp_name"] . ')</option>';
      elseif ($tableTag == 'class') echo '<option value="' . $id . '">' . $rowsArray["class_name"] . '(' . $rowsArray["class_section"] . ')</option>';
      else echo '<option value="' . $id . '">' . $name . '</option>';
    }
    echo '<option value="0">ALL</option>';
    echo '</select>';
  } elseif ($_POST['action'] == 'updateMasterData') {
    $curl = curl_init();
    $url = 'https://classconnect.in/api/get_master_data.php';
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    $output = json_decode($output, true);

    echo $output;

    if ($output['success'] == "True") {
      $masterGroup = count($output['data']);
      $sql = "select * from master_name";
      $result = $conn->query($sql);
      $portalGroup = $result->num_rows;
      echo $masterGroup . '-' . $portalGroup;
      if ($masterGroup > $portalGroup) {
        for ($i = $portalGroup; $i < $masterGroup; $i++) {
          $sql = "insert into master_name (mn_name, mn_abbri, mn_sno, mn_editable, mn_remarks, mn_status) values('" . $output["data"][$i]["mn_name"] . "','" . $output["data"][$i]["mn_abbri"] . "','" . $output["data"][$i]["mn_sno"] . "','" . $output["data"][$i]["mn_editable"] . "', '" . $output["data"][$i]["mn_remarks"] . "', '" . $output["data"][$i]["mn_status"] . "')";
          $result = $conn->query($sql);
          if (!$result) {
            echo " " . $conn->error;
          }
        }
      }
    }
  }
}
