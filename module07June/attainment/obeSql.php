<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
//echo "Action " . $_POST['action'];
if ($_POST['actionUpdateAssMethod'] == "updateAM") {
  $fields = ['am_id', 'am_name', 'am_code', 'am_weight', 'am_weight_po', 'am_type'];
  $values = [$_POST['amId'], data_check($_POST['am_name']), data_check($_POST['am_code']), data_check($_POST['am_weight']), data_check($_POST['am_weight_po']), data_check($_POST['am_type'])];
  $status = 'am_status';
  $dup_alert = " Method Name Alreday Exists !! ";
  updateUniqueData($conn, 'assessment_method', $fields, $values, $dup_alert);
  $affectedRows = $conn->affected_rows;
  // echo "affected rows $affectedRows";
  if ($affectedRows == 0) {
    $fields = ['am_name', 'am_code', 'am_weight', 'am_weight_po', 'am_type'];
    $values = [data_check($_POST['am_name']), data_check($_POST['am_code']), data_check($_POST['am_weight']), data_check($_POST['am_weight_po']), data_check($_POST['am_type'])];
    $status = 'am_status';
    $dup = "select * from assessment_method where am_name='" . data_check($_POST["am_name"]) . "' and $status='0'";
    $dup_alert = "Method Name Alreday Exists !!";
    addData($conn, 'assessment_method', 'am_id', $fields, $values, $status, $dup, $dup_alert);
  }
}
if (isset($_POST['action'])) {
  if ($_POST['action'] == "addAssessmentMethod") {
    //echo "Add Assessment Method Block";
    $fields = ['am_name', 'am_code', 'am_weight', 'am_weight_po', 'am_type'];
    $values = [data_check($_POST['am_name']), data_check($_POST['am_code']), data_check($_POST['am_weight']), data_check($_POST['am_weight_po']), data_check($_POST['am_type'])];
    $status = 'am_status';
    $dup = "select * from assessment_method where am_name='" . data_check($_POST["am_name"]) . "' and $status='0'";
    $dup_alert = "Method Name Alreday Exists !!";
    addData($conn, 'assessment_method', 'am_id', $fields, $values, $status, $dup, $dup_alert);
  } elseif ($_POST['action'] == "assessmentMethodList") {
    //echo "List - Block ";
    $sql = "select  * from assessment_method where am_status='0' order by am_name";
    $result = $conn->query($sql);
    $json_array = array();
    while ($rowArray = $result->fetch_assoc()) {
      $json_array[] = $rowArray;
    }
    echo json_encode($json_array);
  } elseif ($_POST['action'] == 'fetchAM') {
    //echo "Add Assessment Method Block";
    $id = $_POST['amId'];
    $sql = "SELECT * FROM assessment_method where am_id='$id'";
    $result = $conn->query($sql);
    if (!$result) die("re");
    else $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST['action'] == "addAT") {
    echo "Add Assessment Technique Block";
    $fields = ['am_id', 'at_name', 'at_type', 'at_outcome'];
    $values = [$_POST['sel_am'], data_check($_POST['at_name']), data_check($_POST['at_type']), data_check($_POST['at_outcome'])];
    $status = 'at_status';
    $dup = "select * from assessment_technique where at_name='" . data_check($_POST["at_name"]) . "' and at_outcome='" . data_check($_POST["at_outcome"]) . "' and $status='0'";
    $dup_alert = "Method Name Alreday Exists !!";
    addData($conn, 'assessment_technique', 'at_id', $fields, $values, $status, $dup, $dup_alert);
  } elseif ($_POST['action'] == "assessmentTechniqueList") {
    $sql = "select at.*, am.* from assessment_technique at, assessment_method am where am.am_id=at.am_id and at.at_status='0' order by at.at_outcome, at.at_name";
    $result = $conn->query($sql);
    $json_array = array();
    while ($rowArray = $result->fetch_assoc()) {
      $json_array[] = $rowArray;
    }
    echo json_encode($json_array);
  } elseif ($_POST['action'] == 'fetchAT') {
    //echo "Add Assessment Method Block";
    $id = $_POST['atId'];
    $sql = "SELECT * FROM assessment_technique where at_id='$id'";
    $result = $conn->query($sql);
    if (!$result) die("re");
    else $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST['action'] == "updateAT") {
    echo "Update Assessment Technique Block" . $_POST['modalId'];
    $fields = ['at_id', 'at_name', 'am_id', 'at_type', 'at_outcome'];
    $values = [$_POST['modalId'], data_check($_POST['at_name']), $_POST['sel_am'], $_POST['at_type'], $_POST['at_outcome']];
    $status = 'at_status';
    $dup_alert = " Technique Name Alreday Exists !! ";
    updateUniqueData($conn, 'assessment_technique', $fields, $values, $dup_alert);
  } elseif ($_POST['action'] == "addPOF") {
    echo " PO Feedback Design Block";
    $fields = ['program_id', 'batch_id', 'pf_name', 'pf_mm', 'pf_weight', 'pf_question', 'submit_id'];
    $values = [$_POST['modalProgram'], $_POST['modalBatch'], data_check($_POST['pf_name']), data_check($_POST['pf_mm']), data_check($_POST['pf_weight']), data_check($_POST['pf_question']), $myId];
    $status = 'pf_status';
    $dup = "select * from po_feedback where program_id='" . $_POST["modalProgram"] . "' and batch_id='" . $_POST["batch_id"] . "' and submit_id='$myId' and $status='0'";
    $dup_alert = "PO Feedback for the Program and Batch Alreday Exists !!";
    addData($conn, 'po_feedback', 'pf_id', $fields, $values, $status, $dup, $dup_alert);
  } elseif ($_POST['action'] == "pofList") {
    //echo "POF List - Block ";
    $sql = "select pf.* from po_feedback pf where pf.pf_status='0' order by pf.pf_name";
    $tableId = 'pf_id';

    $statusDecode = array("status" => "at_status", "0" => "Active", "1" => "Removed");
    $button = array("1", "1", "0", "0");

    $fields = array("pf_name", "pf_question", "pf_mm", "pf_weight", "pf_status");
    $dataType = array("0", "0", "0", "0", "0");
    $header = array("Id", "Feedback", "Ques", "Max Marks", "Weightage(%)", "Status");
    getList($conn, $tableId, $fields, $dataType, $header, $sql, $statusDecode, $button);
  } elseif ($_POST['action'] == 'fetchPOF') {
    //echo "Add Assessment Method Block";
    $id = $_POST['pfId'];
    $programId = $_POST['programId'];
    $batchId = $_POST['batchId'];
    $id = $_POST['pfId'];
    $sql = "SELECT * FROM po_feedback where pf_id='$id'";
    $result = $conn->query($sql);
    if (!$result) die("Could Not Proceed");
    else $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST['action'] == "updatePOF") {
    //echo "Update POF Block" . $_POST['modalId'];
    $fields = ['pf_id', 'pf_name', 'pf_question', 'pf_mm', 'pf_weight'];
    $values = [$_POST['modalId'], data_check($_POST['pf_name']), $_POST['pf_question'], $_POST['pf_mm'], $_POST['pf_weight']];
    $status = 'pf_status';
    $dup_alert = " Feedback Name Alreday Exists !! ";
    updateUniqueData($conn, 'po_feedback', $fields, $values, $dup_alert);
  } elseif ($_POST['action'] == "addAD") {
    echo "Assessment Design Block";
    $fields = ['subject_id', 'at_id', 'ad_name', 'ad_mm', 'ad_pm', 'ad_weight', 'ad_question', 'submit_id'];
    $values = [$_POST['sel_subjectAD'], $_POST['sel_at'], data_check($_POST['ad_name']), data_check($_POST['ad_mm']), data_check($_POST['ad_pm']), data_check($_POST['ad_weight']), data_check($_POST['ad_question']), $myId];
    $status = 'ad_status';
    $dup = "select * from assessment_design where subject_id='" . $_POST["sel_subjectAD"] . "' and ad_name='" . data_check($_POST["ad_name"]) . "' and submit_id='$myId' and $status='0'";
    $dup_alert = "Assessment Name for the Subejct Alreday Exists !!";
    addData($conn, 'assessment_design', 'ad_id', $fields, $values, $status, $dup, $dup_alert);
  } elseif ($_POST['action'] == "assessmentDesignList") {
    //echo "AT List - Block ";
    $sql = "select ad.*, at.*, sb.subject_code from assessment_design ad, assessment_technique at, subject sb where ad.subject_id=sb.subject_id and ad.at_id=at.at_id and sb.program_id='$myProg' and sb.batch_id='$myBatch' and ad.ad_status='0' order by ad.ad_name";
    //$result=$conn->query($sql);
    //echo $result->num_rows;
    $tableId = 'ad_id';

    $statusDecode = array("status" => "at_status", "0" => "Active", "1" => "Removed");
    $button = array("1", "1", "0", "0");

    $fields = array("ad_name", "subject_code", "at_name", "ad_question", "ad_mm", "ad_pm", "ad_weight", "ad_status");
    $dataType = array("0", "0", "0", "0", "0", "0", "0", "0");
    $header = array("Id", "Assessment", "Subject", " Technique", "AsessUnit", "Max Marks", "Pass Marks", "Weightage(%)", "Status");

    //echo "<h5> Assessment Technique List </h5>";
    getList($conn, $tableId, $fields, $dataType, $header, $sql, $statusDecode, $button);
  } elseif ($_POST['action'] == 'fetchAD') {
    //echo "Add Assessment Method Block";
    $id = $_POST['adId'];
    $sql = "SELECT * FROM assessment_design where ad_id='$id'";
    $result = $conn->query($sql);
    if (!$result) die("re");
    else $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST['action'] == "updateAD") {
    //echo "Update Assessment Design Block".$_POST['modalId'];
    $fields = ['ad_id', 'ad_name', 'at_id', 'subject_id', 'ad_mm', 'ad_pm', 'ad_weight', 'ad_question'];
    $values = [$_POST['modalId'], data_check($_POST['ad_name']), $_POST['sel_at'], $_POST['sel_subjectAD'], data_Check($_POST['ad_mm']), data_Check($_POST['ad_pm']), data_Check($_POST['ad_weight']), data_check($_POST['ad_question'])];
    $status = 'ad_status';
    $dup_alert = " Technique Name Alreday Exists !! ";
    updateUniqueData($conn, 'assessment_design', $fields, $values, $dup_alert);
  } elseif ($_POST['action'] == "addAUCO") {
    //echo "AUCO Block";
    if (data_check($_POST['auco_weight']) == '0') {
      $sql = "delete from auco_map where ad_id='" . $_POST['ad_idM'] . "' and co_id='" . $_POST['co_idM'] . "' and au_sno='" . $_POST['au_snoM'] . "'";
      $res = $conn->query($sql);
    } else {
      $sql = "insert into auco_map (ad_id, co_id, au_sno, auco_weight) values('" . $_POST['ad_idM'] . "', '" . $_POST['co_idM'] . "', '" . $_POST['au_snoM'] . "', '" . data_check($_POST['auco_weight']) . "')";
      $result = $conn->query($sql);
      if (!$result) {
        $sql = "update auco_map set auco_weight='" . data_check($_POST['auco_weight']) . "' where ad_id='" . $_POST['ad_idM'] . "' and co_id='" . $_POST['co_idM'] . "' and au_sno='" . $_POST['au_snoM'] . "'";
        $result = $conn->query($sql);
      }
    }
  } elseif ($_POST['action'] == "addAUMarks") {
    //echo "AU Marks Block";
    if (data_check($_POST['au_marks']) == '0') {
      $sql = "delete from au_marks where ad_id='" . $_POST['ad_idM'] . "' and au_sno='" . $_POST['au_snoM'] . "'";
      $res = $conn->query($sql);
    } else {
      $sql = "insert into au_marks (ad_id, au_sno, au_marks) values('" . $_POST['ad_idM'] . "', '" . $_POST['au_snoM'] . "', '" . data_check($_POST['au_marks']) . "')";
      $result = $conn->query($sql);
      if (!$result) {
        $sql = "update au_marks set au_marks='" . data_check($_POST['au_marks']) . "' where ad_id='" . $_POST['ad_idM'] . "' and au_sno='" . $_POST['au_snoM'] . "'";
        $result = $conn->query($sql);
      }
    }
  } elseif ($_POST['action'] == 'uaMarks') {
    //echo "Action " . $_POST['action'];
    $uaMarks = $_POST['uaMarks'];
    $studentId = $_POST['studentId'];
    $adId = $_POST['adId'];
    $uaSno = $_POST['uaSno'];
    if ($uaMarks == '') {
      $sql = "delete from assessment_marks where ad_id='$adId' and au_sno='$uaSno' and student_id='$studentId'";
      $res = $conn->query($sql);
    } else {
      $sql = "INSERT INTO assessment_marks (ad_id, au_sno, student_id, am_marks) VALUES('$adId', '$uaSno', '$studentId', '$uaMarks')";
      $result = $conn->query($sql);
      if (!$result) {
        $sql = "update assessment_marks set am_marks='$uaMarks' where ad_id='$adId' and au_sno='$uaSno' and student_id='$studentId'";
        $res = $conn->query($sql);
        if (!$res) echo $conn->error;
      }
    }
  } elseif ($_POST['action'] == 'csScale') {
    //echo "Action " . $_POST['action'];
    $csValue = $_POST['csValue'];
    $cs_scale = $_POST['csScale'];
    $co_id = $_POST['coId'];
    $tag = $_POST['tag'];
    if ($tag == 'F') $cs_from = $csValue;
    else $cs_to = $csValue;

    if ($tag == 'F') $sql = "INSERT INTO co_scale (co_id, cs_scale, cs_from) VALUES('$co_id', '$cs_scale', '$cs_from')";
    else $sql = "INSERT INTO co_scale (co_id, cs_scale, cs_to) VALUES('$co_id', '$cs_scale', '$cs_to')";
    $result = $conn->query($sql);
    if (!$result) {
      if ($tag == 'F') $sql = "update co_scale set cs_from='$cs_from' where co_id='$co_id' and cs_scale='$cs_scale'";
      else $sql = "update co_scale set cs_to='$cs_to' where co_id='$co_id' and cs_scale='$cs_scale'";
      $res = $conn->query($sql);
      if (!$res) echo $conn->error;
    }
  } elseif ($_POST['action'] == 'psScale') {
    //echo "Action " . $_POST['action'];
    $psValue = $_POST['psValue'];
    $ps_scale = $_POST['psScale'];
    $po_id = $_POST['poId'];
    $tag = $_POST['tag'];
    if ($tag == 'F') $ps_from = $psValue;
    else $ps_to = $psValue;

    if ($tag == 'F') $sql = "INSERT INTO po_scale (po_id, ps_scale, ps_from) VALUES('$po_id', '$ps_scale', '$ps_from')";
    else $sql = "INSERT INTO po_scale (po_id, ps_scale, ps_to) VALUES('$po_id', '$ps_scale', '$ps_to')";
    $result = $conn->query($sql);
    if (!$result) {
      if ($tag == 'F') $sql = "update po_scale set ps_from='$ps_from' where po_id='$po_id' and ps_scale='$ps_scale'";
      else $sql = "update po_scale set ps_to='$ps_to' where po_id='$po_id' and ps_scale='$ps_scale'";
      $res = $conn->query($sql);
      if (!$res) echo $conn->error;
    }
  } elseif ($_POST['action'] == 'psCopy') {
    echo "Action " . $_POST['action'];
    $po_id = $_POST['poId'];

    $sql = "select * from po_scale where po_id='$po_id' and ps_scale='1'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $ps1From = $row['ps_from'];
    $ps1To = $row['ps_to'];

    $sql = "select * from po_scale where po_id='$po_id' and ps_scale='2'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $ps2From = $row['ps_from'];
    $ps2To = $row['ps_to'];

    $sql = "select * from po_scale where po_id='$po_id' and ps_scale='3'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $ps3From = $row['ps_from'];
    $ps3To = $row['ps_to'];

    $sqlPO = "select * from program_outcome where program_id='$myProg' and batch_id='$myBatch' and po_status='0'";
    $resultPO = $conn->query($sqlPO);
    while ($rowsPO = $resultPO->fetch_assoc()) {
      $po = $rowsPO['po_id'];
      echo $po . ' - ';
      $sql = "INSERT INTO po_scale (po_id, ps_scale, ps_from, ps_to) VALUES('$po', '1', '$ps1From', '$ps1To')";
      $result = $conn->query($sql);
      if (!$result) {
        //echo $conn->error;
        $sql = "update po_scale set ps_from='$ps1From', ps_to='$ps1To' where po_id='$po' and ps_scale='1'";
        $result = $conn->query($sql);
        if (!$result) echo $conn->error;
      }

      $sql = "INSERT INTO po_scale (po_id, ps_scale, ps_from, ps_to) VALUES('$po', '2', '$ps2From', '$ps2To')";
      $result = $conn->query($sql);
      if (!$result) {
        //echo $conn->error;
        $sql = "update po_scale set ps_from='$ps2From', ps_to='$ps2To' where po_id='$po' and ps_scale='2'";
        $result = $conn->query($sql);
        if (!$result) echo $conn->error;
      }

      $sql = "INSERT INTO po_scale (po_id, ps_scale, ps_from, ps_to) VALUES('$po', '3', '$ps3From', '$ps3To')";
      $result = $conn->query($sql);
      if (!$result) {
        //echo $conn->error;
        $sql = "update po_scale set ps_from='$ps3From', ps_to='$ps3To' where po_id='$po' and ps_scale='3'";
        $result = $conn->query($sql);
        if (!$result) echo $conn->error;
      }

      //else echo 'Added';
    }
  } elseif ($_POST['action'] == 'pofSelect') {
    //echo "POF Select Block";
    $program_id = $_POST['programId'];
    $batch_id = $_POST['batchId'];
    $sql = "select * from po_feedback where batch_id='$batch_id' and program_id='$program_id' and pf_status='0' order by pf_name";
    selectList($conn, 'Select an Assessment ', array('1', 'pf_id', 'pf_name', 'pf_id', 'sel_pf'), $sql);
  } elseif ($_POST['action'] == 'pfMarks') {
    //echo "Action " . $_POST['action'];
    $pfMarks = $_POST['pfMarks'];
    $studentId = $_POST['studentId'];
    $pfId = $_POST['pfId'];
    $poId = $_POST['poId'];
    if ($pfMarks == '') {
      $sql = "delete from pof_marks where pf_id='$pfId' and po_id='$poId' and student_id='$studentId'";
      $res = $conn->query($sql);
    } else {
      $sql = "INSERT INTO pof_marks (pf_id, po_id, student_id, pof_marks) VALUES('$pfId', '$poId', '$studentId', '$pfMarks')";
      $result = $conn->query($sql);
      if (!$result) {
        $sql = "update pof_marks set pof_marks='$pfMarks' where pf_id='$pfId' and po_id='$poId' and student_id='$studentId'";
        $res = $conn->query($sql);
        if (!$res) echo $conn->error;
      }
    }
  }
}
