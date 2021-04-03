<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
//echo $_POST['action'];
if (isset($_POST['action'])) {
  if ($_POST["action"] == "addSubject") {
    $fields = ['program_id', 'batch_id', 'subject_name', 'subject_code', 'subject_semester', 'subject_credit', 'subject_type', 'subject_mode', 'subject_category', 'subject_lecture', 'subject_tutorial', 'subject_practical', 'subject_internal', 'subject_external', 'staff_id', 'submit_id'];
    $values = [$_POST['programIdModal'], $_POST['batchIdModal'], data_check($_POST['subject_name']), data_check($_POST['subject_code']), data_check($_POST['subject_semester']), data_check($_POST['subject_credit']), data_check($_POST['subject_type']), data_check($_POST['subject_mode']), data_check($_POST['subject_category']), data_check($_POST['subject_lecture']), data_check($_POST['subject_tutorial']), data_check($_POST['subject_practical']), data_check($_POST['subject_internal']), data_check($_POST['subject_external']), $_POST['sel_staff'], $myId];
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
    $fields = ['subject_id', 'subject_name', 'subject_code', 'subject_semester', 'subject_lecture', 'subject_tutorial', 'subject_practical', 'subject_credit', 'subject_type', 'subject_mode', 'subject_category', 'subject_internal', 'subject_external', 'staff_id'];

    $values = [$_POST['modalId'], data_check($_POST['subject_name']), data_check($_POST['subject_code']), data_check($_POST['subject_semester']), data_check($_POST['subject_lecture']), data_check($_POST['subject_tutorial']), data_check($_POST['subject_practical']),  data_check($_POST['subject_credit']), data_check($_POST['subject_type']), data_check($_POST['subject_mode']), data_check($_POST['subject_category']), data_check($_POST['subject_internal']), data_check($_POST['subject_external']), $_POST['sel_staff']];
    $dup = "select * from subject where subject_id='" . $_POST["modalId"] . "'";
    $dup_alert = "Could Not Update - Duplicate Entries";
    updateData($conn, 'subject', $fields, $values, $dup, $dup_alert);
  } elseif ($_POST['action'] == 'copySubject') {
    
    $copyFromProgram = $_POST['programId'];
    $copyFromBatch = $_POST['batchId'];
    
    $copySemester = $_POST['copy_semester'];
    $copyBatch = $_POST['copy_batch'];

    echo "Copy From Prog - $copyFromProgram - Batch - $copyFromBatch";

    echo "Copy to Batch - $copyBatch - Sem - $copySemester";

    $sql = "select * FROM subject where program_id='$copyFromProgram' and batch_id='$copyFromBatch' and subject_semester='$copySemester'";
    $result = $conn->query($sql);
    while($rows=$result->fetch_assoc()){
      $subject_code=$rows['subject_code'];
      $subject_name=$rows['subject_name'];
      $subject_type=$rows['subject_type'];
      $subject_mode=$rows['subject_mode'];
      $subject_lecture=$rows['subject_lecture'];
      $subject_tutorial=$rows['subject_tutorial'];
      $subject_practical=$rows['subject_practical'];
      $subject_category=$rows['subject_category'];
      $subject_credit=$rows['subject_credit'];
      $subject_internal=$rows['subject_internal'];
      $subject_external=$rows['subject_external'];
      $staff_id=$rows['staff_id'];
      echo "$subject_code | ";
      $dup="select * from subject where program_id='$copyFromProgram' and batch_id='$copyBatch' and subject_code='$subject_code'";
      $result_dup=$conn->query($dup);
      if(!$result_dup)echo $conn->error;
      else if($result_dup->num_rows==0){
        $insert="insert into subject (program_id, batch_id, subject_semester, subject_name, subject_code, subject_type, subject_mode, subject_lecture, subject_tutorial, subject_practical, subject_category, subject_credit, subject_internal, subject_external, staff_id, submit_id) values('$copyFromProgram', '$copyBatch', '$copySemester', '$subject_name', '$subject_code', '$subject_type', '$subject_mode', '$subject_lecture', '$subject_tutorial', '$subject_practical', '$subject_category', '$subject_credit', '$subject_internal', '$subject_external', '$staff_id', '$myId')";
        $result_insert=$conn->query($insert);
        if(!$result_insert)echo $conn->error;  
      }
    };
    
  } elseif ($_POST["action"] == "subList") {
    //echo "MyId- $myId Prog $myProg";
    $tableId = 'subject_id';

    $batch_id = $_POST['batchId'];
    $sql="select * from subject where program_id='$myProg' and batch_id='$batch_id'";
    $json = getTableRow($conn, $sql, array("subject_id", "subject_name", "subject_code"));

    $array = json_decode($json, true);
    //echo count($array);
    //echo count($array["data"]);
    for ($i = 0; $i < count($array["data"]); $i++) {
      $subject_id=$array["data"][$i]["subject_id"];
      echo '<div class="card m-1 p-1">';
      echo '<div class="card-body mb-0 pb-0">';
      echo '<div class="row">';
      echo '<div class="col-sm-2 text-center">';
      echo '[' . $subject_id . ']';
      echo '<a href="#" class="float left session_idE" data-id="' . $subject_id . '"><i class="fa fa-edit"></i></a>';
      echo '</div>';
      echo '<div class="col-sm-8">';
      echo $array["data"][$i]["subject_code"].' : <span class="cardBodyText">'.$array["data"][$i]["subject_name"].'</span>';
      echo '</div>';
      echo '<div class="col-sm-1">';
      echo '<a href="#" class="float-right session_idD" data-id="' . $subject_id . '"><i class="fa fa-trash"></i></a>';
      echo '</div>';
      echo '</div>';
      echo '<div class="row">';
      echo '<div class="col-sm-3">';
      echo '<a href="#" class="atag addSchool" data-id="' . $subject_id . '">Add School</a>';
      echo '</div>';
      echo '</div>';
      echo '</div></div>';
    }
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
    //$school_id = $myScl;
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
      echo '<div class="col-sm-1">';
      echo '<a href="#" class="float left session_idE" data-id="' . $array["data"][$i]["id"] . '"><i class="fa fa-edit"></i></a>';
      echo '</div>';
      echo '<div class="col-sm-2">';
      echo '[' . $array["data"][$i]["id"] . ']';
      echo '</div>';
      echo '<div class="col-sm-6">';
      echo '<span class="cardBodyText">'.$array["data"][$i]["name"].'</span>';
      echo '</div>';
      echo '<div class="col-sm-3">';
      echo '<a href="#" class="float-right session_idD" data-id="' . $array["data"][$i]["id"] . '"><i class="fa fa-trash"></i></a>';
      echo '</div>';
      echo '</div>';
      echo '<div class="row">';
      echo '<div class="col-3">';
      echo '<a href="#" class="atag addSchool" data-id="' . $array["data"][$i]["id"] . '">Add School</a>';
      echo '</div>';
      echo '</div>';
      echo '</div></div>';
    }
    echo '</table>';
    
  } elseif ($_POST["action"] == "addSession") {
    //echo "Add Session";
    $fields = ['school_id', 'program_id', 'ay_id', 'session_name', 'session_start', 'session_end', 'session_remarks'];
    $values = [$myScl, $_POST['programIdModal'], $_POST['batchIdModal'], data_check($_POST['session_name']), data_check($_POST['session_start']), data_check($_POST['session_end']), data_check($_POST['session_remarks'])];
    $status = 'session_status';
    $dup = "select * from session where session_name='" . data_check($_POST["session_name"]) . "' and program_id='" . $_POST["programIdModal"] . "'  and ay_id='" . $_POST["batchIdModal"] . "'and $status='0'";
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
      echo "Prg Id ".$_POST['programIdModal'];
      echo "batchId ".$_POST['batchIdModal'];
      $fields = ['program_id', 'batch_id', 'po_name', 'po_code', 'po_sno'];
      $values = [$_POST['programIdModal'], $_POST['batchIdModal'], data_check($_POST['poStatement']), data_check($_POST['poCode']), data_check($_POST['poSno'])];
      $status = 'po_status';
      $dup = "select * from program_outcome where po_sno='" . data_check($_POST["poSno"]) . "' and program_id='" . $_POST["programIdModal"] . "'  and batch_id='" . $_POST["batchIdModal"] . "'and $status='0'";
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
          // echo "MyId- $myId";
      $program_id = $_POST['programId'];
      $batch_id = $_POST['batchId'];

      $sql = "select * from program_outcome where program_id='$program_id' and batch_id='$batch_id' order by po_sno, po_code";
      $tableId = 'po_id';

      $statusDecode = array("status" => "po_status", "0" => "Active", "1" => "Removed");
      $button = array("1", "1", "0", "0");

      $fields = array("po_code", "po_sno", "po_name", "po_status");
      $dataType = array("0", "0", "0", "0");
      $header = array("Id", "PO", "#", "PO Statement", "Status");

      getList($conn, $tableId, $fields, $dataType, $header, $sql, $statusDecode, $button);
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
      $subject_id = $_POST['subjectId'];

      if ($subject_id == "ALL") $sql = "select co.*, sb.subject_name from course_outcome co, subject sb where sb.subject_id=co.subject_id  and co.co_status='0' and sb.subject_status='0' order by co_sno, co_code";
      else $sql = "select  co.*, sb.subject_name  from course_outcome co, subject sb where sb.subject_id=co.subject_id and co.subject_id='$subject_id' and co.co_status='0' and sb.subject_status='0' order by co_sno, co_code";
      $tableId = 'co_id';

      $statusDecode = array("status" => "co_status", "0" => "Active", "1" => "Removed");
      $button = array("1", "1", "0", "0");

      $fields = array("co_code", "co_sno", "co_name", "co_status");
      $dataType = array("0", "0", "0", "0");
      $header = array("Id", "CO", "#", "CO Statement", "Status");

      getList($conn, $tableId, $fields, $dataType, $header, $sql, $statusDecode, $button);
    }
  }




