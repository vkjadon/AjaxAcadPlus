<?php
require('../requireSubModule.php');

//echo "Action ".$_POST['action'];
if (isset($_POST['action'])) {
  if ($_POST["action"] == "addSubject") {
    $fields = ['program_id', 'batch_id', 'subject_name', 'subject_code', 'subject_semester', 'subject_credit', 'subject_type', 'subject_lecture', 'subject_tutorial', 'subject_practical', 'subject_sno', 'update_id', 'subject_status'];
    $values = [$myProg, $myBatch, data_check($_POST['subject_name']), data_check($_POST['subject_code']), data_check($_POST['subject_semester']), data_check($_POST['subject_credit']), data_check($_POST['subject_type']), data_check($_POST['subject_lecture']), data_check($_POST['subject_tutorial']), data_check($_POST['subject_practical']), data_check($_POST['subject_sno']), $myId, '0'];
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
    $fields = ['subject_id', 'subject_name', 'subject_code', 'subject_semester', 'subject_lecture', 'subject_tutorial', 'subject_practical', 'subject_credit', 'subject_type', 'subject_sno', 'update_ts', 'update_id'];

    $values = [$_POST['modalId'], data_check($_POST['subject_name']), data_check($_POST['subject_code']), data_check($_POST['subject_semester']), data_check($_POST['subject_lecture']), data_check($_POST['subject_tutorial']), data_check($_POST['subject_practical']),  data_check($_POST['subject_credit']), data_check($_POST['subject_type']), data_check($_POST['subject_sno']), $submit_ts, $myId];
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

    $copySemester = $_POST['newSemester'];
    $copyBatch = $_POST['newBatch'];

    echo "Copy to Batch - $copyBatch - Sem - $copySemester";

    $sql = "select * FROM subject where program_id='$myProg' and batch_id='$myBatch' and subject_semester='$copySemester'";
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
      $dup = "select * from subject where program_id='$myProg' and batch_id='$copyBatch' and subject_code='$subject_code'";
      $result_dup = $conn->query($dup);
      if (!$result_dup) echo $conn->error;
      else if ($result_dup->num_rows == 0) {
        $insert = "insert into subject (program_id, batch_id, subject_semester, subject_name, subject_code, subject_type, subject_mode, subject_lecture, subject_tutorial, subject_practical, subject_category, subject_credit, subject_internal, subject_external, staff_id, update_id) values('$myProg', '$copyBatch', '$copySemester', '$subject_name', '$subject_code', '$subject_type', '$subject_mode', '$subject_lecture', '$subject_tutorial', '$subject_practical', '$subject_category', '$subject_credit', '$subject_internal', '$subject_external', '$staff_id', '$myId')";
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

      echo '<div class="row m-1 cardBodyText">';
      echo '<div class="col-sm-2">';
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
      if ($emp == "1") echo ' [ <i class="fa fa-check"><b><a href="#" class="vac" data-action="vac" data-field="subject_emp" data-code="N" data-id="' . $subject_id . '"></i>Emp</a></b> ] ';
      else echo ' [ <i class="fa fa-times"></i><b><a href="#" class="vac" data-action="vac" data-field="subject_emp" data-code="Y" data-id="' . $subject_id . '">Emp</a></b> ] ';

      $skill = getField($conn, $subject_id, "subject_addon", "subject_id", "subject_skill");
      if ($skill == "1") echo ' [ <i class="fa fa-check"><b><a href="#" class="vac" data-action="vac" data-field="subject_skill" data-code="N" data-id="' . $subject_id . '"></i>Skill</a></b> ] ';
      else echo ' [ <i class="fa fa-times"></i><b><a href="#" class="vac"  data-action="vac" data-field="subject_skill" data-code="Y" data-id="' . $subject_id . '">Skill</a></b> ] ';

      $entrep = getField($conn, $subject_id, "subject_addon", "subject_id", "subject_entrep");
      if ($entrep == "1") echo '<i class="fa fa-check"><b><a href="#" class="vac" data-action="vac" data-field="subject_entrep" data-code="N" data-id="' . $subject_id . '"></i>Entrep</a></b>';
      else echo '<i class="fa fa-times"></i><b><a href="#" class="vac" data-action="vac"  data-field="subject_entrep" data-code="Y" data-id="' . $subject_id . '">Entrep</a></b>';
      echo '</div>';
      echo '</div>';

      echo '<div class="col-sm-2">';
      echo 'L-T-P<br>' . $L . '-' . $T . '-' . $P;
      echo '</div>';

      echo '<div class="col-sm-2">';
      $vac = getField($conn, $subject_id, "subject_addon", "subject_id", "subject_vac");

      if ($vac == "1") echo '<i class="fa fa-check"><b><a href="#" class="vac" data-action="vac" data-field="subject_vac" data-code="N" data-id="' . $subject_id . '"></i>VAC</a></b>';
      else echo '<i class="fa fa-times"></i><b><a href="#" class="vac"  data-action="vac" data-field="subject_vac" data-code="Y" data-id="' . $subject_id . '">VAC</a></b>';
      echo '<br>';
      if ($status == "9") echo '<a href="#" class="float-right subject_idR" data-id="' . $subject_id . '">Removed</a>';
      else echo '<a href="#" class="float-right subject_idD" data-id="' . $subject_id . '"><i class="fa fa-trash"></i></a>';
      echo '</div>';
      echo '</div>';
    }
  } elseif ($_POST["action"] == "electiveList") {
    //echo "MyId- $myId Prog $myProg";
    $tableId = 'subject_id';
    $sql = "select * from subject where program_id='$myProg' and batch_id='$myBatch' and subject_type='DE' and subject_semester>0 order by subject_semester";
    $result_DE = $conn->query($sql);
    if ($result_DE) {
      $electives = $result_DE->num_rows;
      $count = 0;
      while ($deRows = $result_DE->fetch_assoc()) {
        $de[$count] = $deRows["subject_id"];
        $de_code[$count] = $deRows["subject_code"];
        $count++;
      }
    }
    //echo $electives;
    $sql = "select * from subject where program_id='$myProg' and batch_id='$myBatch' and subject_type='EP' and subject_semester>0 order by subject_semester, subject_status, subject_sno";
    $json = getTableRow($conn, $sql, array("subject_id", "subject_name", "subject_code", "subject_lecture", "subject_tutorial", "subject_practical", "subject_credit", "subject_semester", "subject_sno", "subject_type", "subject_status"));
    $array = json_decode($json, true);

    //echo count($array);
    //echo count($array["data"]);
    for ($i = 0; $i < count($array["data"]); $i++) {
      $subject_id = $array["data"][$i]["subject_id"];
      $Cr = $array["data"][$i]["subject_credit"];
      $type = $array["data"][$i]["subject_type"];
      // echo '<div class="card myCard m-2">';
      echo '<div class="row border m-2">';
      echo '<div class="col-4">';
      echo '[' . $subject_id . ']<b> ' . $array["data"][$i]["subject_code"] . '</b><br>';
     echo 'Sem : ' . $array["data"][$i]["subject_semester"];
      echo ' <b>Cr : ' . $Cr . ' </b>';
      echo '</div>';
      echo '<div class="col">';
      echo '<b>' . $array["data"][$i]["subject_name"] . '</b><br>';
      for ($j = 0; $j < $electives; $j++) {
        $assignedQuery = "select update_id from subject_elective where ep_id='$subject_id' and de_id='$de[$j]'";
        $assigned = getFieldValue($conn, "update_id", $assignedQuery);
        if ($assigned) echo ' [ <i class="fa fa-check"></i><b><a href="#" class="vac" data-action="se" data-field="subject_se" data-code="N" data-ep="' . $subject_id . '" data-id="' . $de[$j] . '">' . $de_code[$j] . '</a></b> ] ';
        else echo ' [ <i class="fa fa-times"></i><b><a href="#" class="vac" data-action="se" data-field="subject_se" data-code="Y" data-ep="' . $subject_id . '" data-id="' . $de[$j] . '">' . $de_code[$j] . '</a></b> ] ';
      }
      // echo '</div>';
      echo '</div>';
      echo '</div>';
    }
  } elseif ($_POST['action'] == 'se') {
    $de = $_POST['id'];
    $ep = $_POST['ep'];
    $code = $_POST['code'];
    $field = $_POST['field'];
    echo "DE  " . $de . " EPool " . $de . " Code " . $code;
    if ($code == 'N') $sql = "delete from subject_elective where ep_id='$ep' and de_id='$de'";
    else $sql = "insert into subject_elective (ep_id, de_id, update_id) values('$ep', '$de', '$myId')";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else  $conn->query($sql);
  } elseif ($_POST["action"] == "electivePool") {
    //echo "MyId- $myId Prog $myProg";
    $tableId = 'subject_id';
    $sql = "select * from subject where program_id='$myProg' and batch_id='$myBatch' and subject_type='DE' and subject_semester>0 order by subject_semester";
    $result_DE = $conn->query($sql);
    if ($result_DE) {
      $electives = $result_DE->num_rows;
      $count = 0;
      while ($deRows = $result_DE->fetch_assoc()) {
        $subject_id = $deRows["subject_id"];
        $subject_code = $deRows["subject_code"];
        echo '<div class="card myCard m-2">';

        echo '<div class="row p-2 card-title">';
        echo '<div class="col-3">';
        echo '<b>' . $subject_code . '</b> [' . $subject_id . ']';
        echo '</div>';
        echo '<div class="col-sm-9">';
        echo '<div>Sem : ' . $deRows["subject_semester"] . '<b> Cr : ' . $deRows["subject_credit"] . ' </b> <b>' . $deRows["subject_name"] . '</b></div>';
        echo '</div>';
        echo '</div>';

        $sql = "select * from subject_elective where de_id='$subject_id'";
        $result = $conn->query($sql);
        while ($rowsPool = $result->fetch_assoc()) {
          $ep_id = $rowsPool["ep_id"];
          $offered = $rowsPool["offered"];
          $cbcs = $rowsPool["cbcs"];
          $sqlSub = "select * from subject where subject_id='$ep_id'";
          $resultSubject = $conn->query($sqlSub);
          $rowSubject = $resultSubject->fetch_assoc();
          echo '<div class="row cardBodyText p-1">';
          echo '<div class="col-sm-2">' . $rowSubject["subject_code"] . '</div>';
          echo '<div class="col-sm-6">' . $rowSubject["subject_name"] . '</div>';
          if($offered>0)echo '<div class="col-sm-2"><i class="fa fa-check"></i><b><a href="#" class="vac" data-action="offer" data-field="offered" data-code="N" data-ep="' . $ep_id . '" data-id="' . $subject_id . '">Offered</a></b></div>';
          else echo '<div class="col-sm-2"><i class="fa fa-times"></i><b><a href="#" class="vac" data-action="offer" data-field="offered" data-code="Y" data-ep="' . $ep_id . '" data-id="' . $subject_id . '">Offered</a></b></div>';
          if($cbcs>0)echo '<div class="col-sm-2"><i class="fa fa-check"></i><b><a href="#" class="vac" data-action="offer" data-field="cbcs" data-code="N" data-ep="' . $ep_id . '" data-id="' . $subject_id . '">CBCS</a></b></div>';
          else echo '<div class="col-sm-2"><i class="fa fa-times"></i><b><a href="#" class="vac" data-action="offer" data-field="cbcs" data-code="Y" data-ep="' . $ep_id . '" data-id="' . $subject_id . '">CBCS</a></b></div>';
          echo '</div>';
        }
        $count++;
        echo '</div>';

      }
    }
  } elseif ($_POST['action'] == 'offer') {
    $de = $_POST['id'];
    $ep = $_POST['ep'];
    $code = $_POST['code'];
    $field = $_POST['field'];
    echo "DE  " . $de . " EPool " . $de . " Code " . $code;
    if($field=="cbcs" && $code=="Y")$sql = "update subject_elective set cbcs='1', offered='1' where ep_id='$ep' and de_id='$de'";
    else if($field=="offered" && $code=="N")$sql = "update subject_elective set cbcs='0', offered='0' where ep_id='$ep' and de_id='$de'";
    else if($code=='Y')$sql = "update subject_elective set $field='1' where ep_id='$ep' and de_id='$de'";
    else $sql = "update subject_elective set $field='0' where ep_id='$ep' and de_id='$de'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else  $conn->query($sql);
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
  }elseif ($_POST["action"] == "selectSubject") {
    $sql = "select * from subject where subject_status='0' and program_id='$myProg' and batch_id='" . $_POST['batch_id'] . "' order by subject_semester, subject_name ";
    selectList($conn, 'Sel Subject', array('0', 'subject_id', 'subject_name', 'subject_code', 'sel_subject'), $sql);
  } elseif ($_POST['action'] == 'subReport') {
    //echo "dfdfdf";
    //$sql = "select * from subject where program_id='$myProg' and batch_id='$myBatch' and subject_semester>0 order by subject_semester, subject_status, subject_sno";
    $sql = "select * from subject where program_id='$myProg' and batch_id='$myBatch' and subject_semester>0 order by subject_semester, subject_status, subject_sno";
    $result = $conn->query($sql);
    $json_array = array();
    while ($rowArray = $result->fetch_assoc()) {
      $json_array[] = $rowArray;
    }
    echo json_encode($json_array);
    //echo $json_array;
  }
}
