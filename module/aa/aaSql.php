<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
//echo $_POST['action'];
if (isset($_POST['action'])) {
  if ($_POST["action"] == "addSubject") {
    $fields = ['program_id', 'batch_id', 'subject_name', 'subject_code', 'subject_semester', 'subject_credit', 'subject_type', 'subject_mode', 'subject_category', 'subject_lecture', 'subject_tutorial', 'subject_practical', 'subject_internal', 'subject_external', 'staff_id', 'submit_id'];
    $values = [$myProg, $_POST['batchIdModal'], data_check($_POST['subject_name']), data_check($_POST['subject_code']), data_check($_POST['subject_semester']), data_check($_POST['subject_credit']), data_check($_POST['subject_type']), data_check($_POST['subject_mode']), data_check($_POST['subject_category']), data_check($_POST['subject_lecture']), data_check($_POST['subject_tutorial']), data_check($_POST['subject_practical']), data_check($_POST['subject_internal']), data_check($_POST['subject_external']), $_POST['sel_staff'], $myId];
    $status = 'subject_status';
    $dup = "select * from subject where subject_code='" . data_check($_POST["subject_code"]) . "' and program_id='" . $_POST["programIdModal"] . "' and batch_id='" . $_POST["batchIdModal"] . "' and $status='0'";
    $dup_alert = "Duplicate Code Exists. Multiple Subject Codes not Allowed!";
    addData($conn, 'subject', 'subject_id', $fields, $values, $status, $dup, $dup_alert);
  } elseif ($_POST['action'] == 'fetchSubject') {
    $id = $_POST['subjectId'];
    $sql = "select * FROM subject where subject_id='$id'";
    $result = $conn->query($sql);
    $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST['action'] == 'updateSubject') {
    $fields = ['subject_id', 'subject_name', 'subject_code', 'subject_semester', 'subject_lecture', 'subject_tutorial', 'subject_practical', 'subject_credit', 'subject_type', 'subject_mode', 'subject_category', 'subject_internal', 'subject_external', 'subject_sno', 'staff_id'];

    $values = [$_POST['modalId'], data_check($_POST['subject_name']), data_check($_POST['subject_code']), data_check($_POST['subject_semester']), data_check($_POST['subject_lecture']), data_check($_POST['subject_tutorial']), data_check($_POST['subject_practical']),  data_check($_POST['subject_credit']), data_check($_POST['subject_type']), data_check($_POST['subject_mode']), data_check($_POST['subject_category']), data_check($_POST['subject_internal']), data_check($_POST['subject_external']), data_check($_POST['subject_sno']), $_POST['sel_staff']];
    $dup = "select * from subject where subject_id='" . $_POST["modalId"] . "'";
    $dup_alert = "Could Not Update - Duplicate Entries";
    updateData($conn, 'subject', $fields, $values, $dup, $dup_alert);
  } elseif ($_POST['action'] == 'vac') {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $field = $_POST['field'];
    if ($code == 'N') $sql = "update subject_addon set $field='0' where subject_id='$id'";
    else $sql = "update subject_addon set $field='1' where subject_id='$id'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else {
      //echo $conn->affected_rows;
      $sql = "insert into subject_addon (subject_id, $field) values('$id', '1')";
      $conn->query($sql);
    }
  } elseif ($_POST['action'] == 'deleteSubject') {
    $id = $_POST['id'];
    $sql = "update subject set subject_status='9' where subject_id='$id'";
    $conn->query($sql);
    // echo $conn->error;
  } elseif ($_POST['action'] == 'resetSubject') {
    $id = $_POST['id'];
    $sql = "update subject set subject_status='0' where subject_id='$id'";
    $conn->query($sql);
    echo $conn->error;
  } elseif ($_POST['action'] == 'copySubject') {

    $copyFromProgram = $_POST['programId'];
    $copyFromBatch = $_POST['batchId'];

    $copySemester = $_POST['copy_semester'];
    $copyBatch = $_POST['copy_batch'];

    echo "Copy From Prog - $copyFromProgram - Batch - $copyFromBatch";

    echo "Copy to Batch - $copyBatch - Sem - $copySemester";

    $sql = "select * FROM subject where program_id='$copyFromProgram' and batch_id='$copyFromBatch' and subject_semester='$copySemester'";
    $result = $conn->query($sql);
    while ($rows = $result->fetch_assoc()) {
      $subject_code = $rows['subject_code'];
      $subject_name = $rows['subject_name'];
      $subject_type = $rows['subject_type'];
      $subject_mode = $rows['subject_mode'];
      $subject_lecture = $rows['subject_lecture'];
      $subject_tutorial = $rows['subject_tutorial'];
      $subject_practical = $rows['subject_practical'];
      $subject_category = $rows['subject_category'];
      $subject_credit = $rows['subject_credit'];
      $subject_internal = $rows['subject_internal'];
      $subject_external = $rows['subject_external'];
      $staff_id = $rows['staff_id'];
      echo "$subject_code | ";
      $dup = "select * from subject where program_id='$copyFromProgram' and batch_id='$copyBatch' and subject_code='$subject_code'";
      $result_dup = $conn->query($dup);
      if (!$result_dup) echo $conn->error;
      else if ($result_dup->num_rows == 0) {
        $insert = "insert into subject (program_id, batch_id, subject_semester, subject_name, subject_code, subject_type, subject_mode, subject_lecture, subject_tutorial, subject_practical, subject_category, subject_credit, subject_internal, subject_external, staff_id, submit_id) values('$copyFromProgram', '$copyBatch', '$copySemester', '$subject_name', '$subject_code', '$subject_type', '$subject_mode', '$subject_lecture', '$subject_tutorial', '$subject_practical', '$subject_category', '$subject_credit', '$subject_internal', '$subject_external', '$staff_id', '$myId')";
        $result_insert = $conn->query($insert);
        if (!$result_insert) echo $conn->error;
      }
    };
  } elseif ($_POST["action"] == "subList") {
    //echo "MyId- $myId Prog $myProg";
    $tableId = 'subject_id';
    $sql = "select * from subject where program_id='$myProg' and batch_id='$myBatch' and subject_semester>0 order by subject_semester, subject_status, subject_sno";
    $json = getTableRow($conn, $sql, array("subject_id", "subject_name", "subject_code", "subject_lecture", "subject_tutorial", "subject_practical", "subject_credit", "subject_semester", "subject_sno", "subject_type", "subject_status"));
    $array = json_decode($json, true);
    //echo count($array);
    //echo count($array["data"]);
    for ($i = 0; $i < count($array["data"]); $i++) {
      $subject_id = $array["data"][$i]["subject_id"];
      $L = $array["data"][$i]["subject_lecture"];
      $T = $array["data"][$i]["subject_tutorial"];
      $P = $array["data"][$i]["subject_practical"];
      $Cr = $array["data"][$i]["subject_credit"];
      $sno = $array["data"][$i]["subject_sno"];
      $type = $array["data"][$i]["subject_type"];
      $status = $array["data"][$i]["subject_status"];

      echo '<div class="row shadow border border-primary mb-1 cardBodyText">';
      echo '<div class="col-sm-2 p-1 mb-0 bg-two">';
      echo 'ID:' . $subject_id . ' <b>[' . $sno . ']</b>';
      echo '<a href="#" class="float-right subject_idE" data-id="' . $subject_id . '"><i class="fa fa-edit"></i></a>';
      echo '<div><b>' . $array["data"][$i]["subject_code"] . '</b>
          <span class="float-right footerNote">' . $type . '</span></div>';
      echo '</div>';
      echo '<div class="col-sm-6">';
      echo '<div class="cardBodyText"><b>' . $array["data"][$i]["subject_name"] . '</b></div>';
      echo '<div class="cardBodyText">Semester : ' . $array["data"][$i]["subject_semester"];
      echo ' <b>Credit : ' . $Cr . ' </b>';
      $emp = getField($conn, $subject_id, "subject_addon", "subject_id", "subject_emp");
      if ($emp == "1") echo ' [ <i class="fa fa-check"><b><a href="#" class="vac" data-field="subject_emp" data-code="N" data-id="' . $subject_id . '"></i>Emp</a></b> ] ';
      else echo ' [ <i class="fa fa-times"></i><b><a href="#" class="vac" data-field="subject_emp" data-code="Y" data-id="' . $subject_id . '">Emp</a></b> ] ';

      $skill = getField($conn, $subject_id, "subject_addon", "subject_id", "subject_skill");
      if ($skill == "1") echo ' [ <i class="fa fa-check"><b><a href="#" class="vac" data-field="subject_skill" data-code="N" data-id="' . $subject_id . '"></i>Skill</a></b> ] ';
      else echo ' [ <i class="fa fa-times"></i><b><a href="#" class="vac" data-field="subject_skill" data-code="Y" data-id="' . $subject_id . '">Skill</a></b> ] ';

      $entrep = getField($conn, $subject_id, "subject_addon", "subject_id", "subject_entrep");
      if ($entrep == "1") echo '<i class="fa fa-check"><b><a href="#" class="vac" data-field="subject_entrep" data-code="N" data-id="' . $subject_id . '"></i>Entrep</a></b>';
      else echo '<i class="fa fa-times"></i><b><a href="#" class="vac" data-field="subject_entrep" data-code="Y" data-id="' . $subject_id . '">Entrep</a></b>';
      echo '</div>';
      echo '</div>';

      echo '<div class="col-sm-2">';
      echo 'L-T-P<br>' . $L . '-' . $T . '-' . $P;
      echo '</div>';

      echo '<div class="col-sm-2">';
      $vac = getField($conn, $subject_id, "subject_addon", "subject_id", "subject_vac");

      if ($vac == "1") echo '<i class="fa fa-check"><b><a href="#" class="vac" data-field="subject_vac" data-code="N" data-id="' . $subject_id . '"></i>VAC</a></b>';
      else echo '<i class="fa fa-times"></i><b><a href="#" class="vac" data-field="subject_vac" data-code="Y" data-id="' . $subject_id . '">VAC</a></b>';
      echo '<br>';
      if ($status == "9") echo '<a href="#" class="float-right subject_idR" data-id="' . $subject_id . '">Removed</a>';
      else echo '<a href="#" class="float-right subject_idD" data-id="' . $subject_id . '"><i class="fa fa-trash"></i></a>';
      echo '</div>';
      echo '</div>';
    }
  } elseif ($_POST["action"] == "subjectSummary") {
    //echo "MyId- $myId Prog $myProg";
    $totalLecture = 0;
    $totalTutorial = 0;
    $totalPractical = 0;
    $totalCredit = 0;
    $totalSubjects = 0;
    $coreSubjects = 0;
    $sql = "select sum(subject_lecture) as lecture, sum(subject_tutorial) as tutorial, sum(subject_practical) as practical, sum(subject_credit) as credit, subject_semester from subject where subject_semester>0 and program_id='$myProg' and batch_id='$myBatch' and subject_status<'9' group by subject_semester";
    $result = $conn->query($sql);
    echo '<div class="card card-square">';
    echo '<table class="table table-bordered list-table-xs">';
    echo '<tr><th>Semester</th><th>Lecture</th><th>Tutorial</th><th>Pr</th><th>Credit</th></tr>';
    while ($row = $result->fetch_array()) {
      $lecture = $row["lecture"];
      $tutorial = $row["tutorial"];
      $practical = $row["practical"];
      $credit = $row["credit"];
      $subject_semester = $row["subject_semester"];
      echo '<tr class="text-center">';
      echo '<td>' . $subject_semester . '</td><td>' . $lecture . '</td><td>' . $tutorial . '</td><td>' . $practical . '</td><td>' . $credit . '</td>';
      echo '</tr>';
      $totalLecture += $lecture;
      $totalTutorial += $tutorial;
      $totalPractical += $practical;
      $totalCredit += $credit;
    }
    echo '<tr class="text-center">';
    echo '<td></td><td class="totalRow-sm">' . $totalLecture . '</td><td class="totalRow-sm">' . $totalTutorial . '</td><td class="totalRow-sm">' . $totalPractical . '</td><td class="totalRow-sm">' . $totalCredit . '</td>';
    echo '</tr>';
    echo '</table>';
    $sql = "select count(subject_id) as subjects from subject where subject_semester>0 and program_id='$myProg' and batch_id='$myBatch' and subject_status<'9'";
    $result = $conn->query($sql);
    $row = $result->fetch_array();
    $totalSubjects = $row["subjects"];

    $sql = "select count(subject_id) as subjects from subject where subject_type='DC' and subject_semester>0 and program_id='$myProg' and batch_id='$myBatch' and subject_status<'9'";
    $result = $conn->query($sql);
    $row = $result->fetch_array();
    if ($totalSubjects > 0) $coreSubjects = ceil(($row["subjects"] / $totalSubjects) * 100);

    echo '<div class="row">
      <div class="col-6 pr-0">
        <div class="card text-white bg-info">
          <div class="card-header">Core</div>
          <div class="card-body">
            <h3 class="card-title text-center">' . $coreSubjects . '%</h3>
          </div>
        </div>
      </div>
      <div class="col-6 pl-0">
        <div class="card text-white bg-success">
          <div class="card-header">Electives</div>
          <div class="card-body">
            <h3 class="card-title text-center">' . (100 - $coreSubjects) . '%</h3>
          </div>
        </div>
      </div>
    </div>';
  } elseif ($_POST["action"] == "batchList") {
    //    echo "MyId- $myId";
    $tableId = 'batch_id';
    $statusDecode = array("status" => "batch_status", "0" => "Active", "1" => "Removed");
    $button = array("E", "Session", "D");
    $fields = array("batch", "batch_status");
    $dataType = array("0");
    $sql = "select * from batch order by batch desc";
    getListCard($conn, $tableId, $fields, $dataType, $sql, $statusDecode, $button);
  } elseif ($_POST["action"] == "addBatch") {
    $fields = ['batch'];
    $values = [data_check($_POST['newBatch'])];
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
    $fields = ['batch_id', 'batch'];
    $values = [$_POST['modalId'], data_check($_POST['newBatch'])];
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
      echo '<div class="card mb-1">';
      echo '<div class="card-body mb-0 pb-0">';
      echo '<div class="row">';
      echo '<div class="col-sm-2">';
      $school_id = $array["data"][$i]["school_id"];
      $school_abbri = getField($conn, $school_id, "school", "school_id", "school_abbri");
      echo '<span>' . $school_abbri . '</span>';
      echo '<p>[' . $array["data"][$i]["id"] . '] ';
      echo '<a href="#" class="session_idE" data-id="' . $array["data"][$i]["id"] . '"><i class="fa fa-edit"></i></a></p>';
      echo '</div>';
      $ay_id = $array["data"][$i]["ay_id"];
      $batch = getField($conn, $ay_id, "batch", "batch_id", "batch");
      $academic_year=$batch.'-'.($batch-1999);

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
  } elseif ($_POST["action"] == "programSelectList") {
    //    echo "MyId- $myId";
    $school_id = $_POST['schoolId'];
    //$batch_id = $_POST['batchId'];
    if ($school_id > 0) $sql = "select p.* from program p, department d where d.school_id='$school_id' and d.dept_id=p.dept_id and program_status='0'";
    else $sql = "select p.* from program p where p.program_status='0'";
    selectInput($conn, 'Select Program', 'program_id', 'program_name', 'program_abbri', 'sel_program', $sql);
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

      echo '<div class="row shadow border border-primary mb-1 cardBodyText">';
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
        $sql="select * from program_outcome where program_id='$program_id' and batch_id='$myBatch' and po_status='0'";
        $resultPO=$conn->query($sql);
        if($resultPO)$poRows=$resultPO->num_rows;
        else $poRows=0;

        echo '<div class="col-sm-4">' . $program_abbri . '</div>';
        echo '<div class="col-sm-6">' . $sp_name . '</div>';
        if($poRows>0)echo '<div class="col-sm-2 inputLabel">' . $poRows . '</div>';
        else echo '<div class="col-sm-2"><i class="fa fa-times"></i></div>';
      }
      echo '</div>';
    } else echo $conn->error;
  } elseif ($_POST["action"] == "addCo") {
    //echo "Add Session ";
    $fields = ['subject_id', 'co_name', 'co_code', 'co_sno'];
    $values = [$_POST['subjectIdModal'], data_check($_POST['coStatement']), data_check($_POST['coCode']), data_check($_POST['coSno'])];
    $status = 'co_status';
    $dup = "select * from course_outcome where co_sno='" . data_check($_POST["co_sno"]) . "' and subject_id='" . $_POST["subjectId"] . "'  and $status='0'";
    $dup_alert = "Serial Number Alreday Exists ! Please Check the Order!!";
    addData($conn, 'course_outcome', 'co_id', $fields, $values, $status, $dup, $dup_alert);
  } elseif ($_POST['action'] == 'fetchCo') {
    //  echo "$id";
    $id = $_POST['coId'];
    $sql = "select * FROM course_outcome where co_id='$id'";
    $result = $conn->query($sql);
    $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST['action'] == 'updateCo') {
    $fields = ['co_id', 'co_code', 'co_name', 'co_sno'];
    $values = [$_POST['modalId'], data_check($_POST['coCode']), data_check($_POST['coStatement']), data_check($_POST['coSno'])];
    $dup = "select * from course_outcome where co_sno='" . $_POST["coSno"] . "' and co_name='" . $_POST["coStatement"] . "' and subject_id='" . $_POST["subjectIdModal"] . "'";
    $dup_alert = "Could Not Update - Duplicate Entries";
    updateData($conn, 'course_outcome', $fields, $values, $dup, $dup_alert);
  } elseif ($_POST["action"] == "coList") {
    //    echo "MyId- $myId";

    $sqlSub = "select sb.* from subject sb where sb.program_id='$myProg' and sb.batch_id='$myBatch' and sb.subject_status='0' and subject_semester>0 order by sb.subject_semester, sb.subject_sno";
    $resultSub = $conn->query($sqlSub);
    while ($subArray = $resultSub->fetch_assoc()) {
      $subject_id = $subArray["subject_id"];
      $subject_name = $subArray["subject_name"];
      $subject_code = $subArray["subject_code"];

      echo '<div class="row shadow border border-primary mb-1">';
      echo '<div class="col-sm-3 mb-0 bg-two inputLabel">';
      echo 'Sem ' . $subArray["subject_semester"];
      echo '</div>';
      echo '<div class="col-sm-9 mb-0 bg-two inputLabel">';
      echo $subject_name . '[' . $subject_code . ']';
      echo '</div>';

      $sqlCO = "select co.* from course_outcome co where co.subject_id='$subject_id' and co.co_status='0' order by co.co_sno, co.co_code";
      $resultCO = $conn->query($sqlCO);
      while ($coArray = $resultCO->fetch_assoc()) {
        $co_id = $coArray["co_id"];
        $co_code = $coArray["co_code"];
        $co_sno = $coArray["co_sno"];
        $co_name = $coArray["co_name"];
        $status = $coArray["co_status"];

        echo '<div class="col-sm-1 cardBodyText">';
        echo '<div><b>' . $co_code . $co_sno . '</b></div>';
        echo '</div>';

        echo '<div class="col-sm-10 cardBodyText">';
        echo '<div class="cardBodyText"><b>' . $co_name . '</b></div>';
        echo '</div>';

        echo '<div class="col-sm-1">';
        echo '<a href="#" class="float-right co_idE" data-id="' . $co_id . '"><i class="fa fa-edit"></i></a>';
        if ($status == "9") echo '<a href="#" class="float-right co_idR" data-id="' . $co_id . '">Removed</a>';
        else echo '<a href="#" class="float-right co_idD" data-id="' . $co_id . '"><i class="fa fa-trash"></i></a>';
        echo '</div>';
      }
      echo '</div>';
    }
  } elseif ($_POST["action"] == "copoMap") {
    //    echo "MyId- $myId";
    $sql = "select * from program_outcome where program_id='$myProg' and batch_id='$myBatch' and po_status='0'";
    $result = $conn->query($sql);
    if ($result) {
      $i = 0;
      while ($row = $result->fetch_assoc()) {
        $poArray[$i] = $row["po_id"];
        $i++;
      }
      $totalPO = $i;
    }

    $sqlSub = "select sb.* from subject sb where sb.program_id='$myProg' and sb.batch_id='$myBatch' and sb.subject_status='0' and subject_semester>0 order by sb.subject_semester, sb.subject_sno";
    $resultSub = $conn->query($sqlSub);
    while ($subArray = $resultSub->fetch_assoc()) {
      $subject_id = $subArray["subject_id"];
      $subject_name = $subArray["subject_name"];
      $subject_code = $subArray["subject_code"];

      echo '<div class="row shadow border border-primary mb-1">';
      echo '<div class="col-sm-3 mb-0 bg-two inputLabel">';
      echo 'Sem ' . $subArray["subject_semester"];
      echo '</div>';
      echo '<div class="col-sm-9 mb-0 bg-two inputLabel">';
      echo $subject_name . '[' . $subject_code . ']';
      echo '</div>';

      $sqlCO = "select co.* from course_outcome co where co.subject_id='$subject_id' and co.co_status='0' order by co.co_sno, co.co_code";
      echo '<table class="table table-bordered list-table-xxs"><tr><td>CO</td>';
      $count = 1;
      for ($i = 0; $i < $totalPO; $i++) {
        $po_id = $poArray[$i];
        echo '<td><span>PO' . $count++ . ' </span></td>';
      }
      echo '</tr>';
      echo '<tr>';
      $resultCO = $conn->query($sqlCO);
      while ($coArray = $resultCO->fetch_assoc()) {
        $co_id = $coArray["co_id"];
        $co_code = $coArray["co_code"];
        $co_sno = $coArray["co_sno"];
        echo '<td><b>' . $co_code . $co_sno . '</b></td>';
        $count = 1;
        for ($i = 0; $i < $totalPO; $i++) {
          $po_id = $poArray[$i];
          $sqlPO = "select * from copo_map where po_id='$po_id' and co_id='$co_id'";
          echo '<td><span class="warning">' . getFieldValue($conn, "copo_scale", $sqlPO) . ' </span></td>';
        }
        echo '</tr>';
      }
      echo '</table>';
      echo '</div>';
    }
  } elseif ($_POST["action"] == "selectSubject") {
    $sql = "select * from subject where subject_status='0' and program_id='$myProg' and batch_id='" . $_POST['batch_id'] . "' order by subject_semester, subject_name ";
    selectList($conn, 'Sel Subject', array('0', 'subject_id', 'subject_name', 'subject_code', 'sel_subject'), $sql);
  }
}
