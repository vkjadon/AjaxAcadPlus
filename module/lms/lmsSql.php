<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
//echo $_POST['action'];
//global $tn_tt;
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'rtList') {

    $fields = array("rt_name", "rt_status");
    $header = array("Id", "Name", "Status");
    $sql = "select * from resource_type where rt_status='0'";
    $statusDecode = array("status" => "rt_status", "0" => "Active", "1" => "Removed");
    $dataType = array("0");
    $button = array("1", "1", "0", "1");
    getList($conn, "rt_id", $fields, $dataType, $header, $sql, $statusDecode, $button);
    // echo "sddsd";
  } else if ($_POST['action'] == 'addRT') {
    $fields = ['rt_name', 'rt_status'];
    $values = [data_check($_POST['rt_name']), '0'];
    $status = 'rt_status';
    $dup = "select * from resource_type where rt_name='" . data_check($_POST["rt_name"]) . "' and $status='0'";
    $dup_alert = "Duplicate Resource Type Name Exists.";
    addData($conn, 'resource_type', 'rt_id', $fields, $values, $status, $dup, $dup_alert);
    //echo "OK";
  } elseif ($_POST['action'] == 'fetchRT') {
    $id = $_POST['rtId'];
    $sql = "SELECT * FROM resource_type where rt_id='$id'";
    $result = $conn->query($sql);
    $output = $result->fetch_assoc();
    echo json_encode($output);
    //  echo "sddsd";

  } elseif ($_POST['action'] == "updateRt") {
    //echo "Update Class " . $_POST['modalId'];
    $fields = ['rt_id', 'rt_name'];
    $values = [$_POST['modalId'], data_check($_POST['rt_name'])];
    $status = 'rt_status';
    $dup_alert = " Resource Type Alreday Exists !! ";
    updateUniqueData($conn, 'resource_type', $fields, $values, $dup_alert);
  } elseif ($_POST['action'] == "mtlList") {
    //echo "$myId - $tn_tl - $tn_tlg";
    $jsonTL = get_staffTeachingLoad($conn, $myId, $tn_tl, $tn_tlg);
    //echo $jsonTL;
    $array = json_decode($jsonTL, true);
    for ($i = 0; $i < count($array["data"]); $i++) {
      $tlId = $array["data"][$i]["tlId"];
      $class_id = $array["data"][$i]["class_id"];
      $class = getField($conn, $class_id, "class", "class_id", "class_name");
      $subject_id = $array["data"][$i]["subject_id"];
      $subject = getField($conn, $subject_id, "subject", "subject_id", "subject_name");
      $text = "Topics for " . $subject . '[' . $array["data"][$i]["type"] . ']';
      echo '<div class="card">
      <div class="card-body mb-0">
      <h5 class="card-title"  id="cl' . $tlId . '">' . $class . '[' . $class_id . ']</h5>
      <h6 class="card-subtitle mb-2 text-muted" id="sb' . $tlId . '">' . $subject . ' [' . $subject_id . ']</h6>
      <a href="#" class="btn btn-info btn-square-sm showSTForm" data-text="' . $text . '" data-tl="' . $tlId . '">Topic</a>
      <a href="#" class="btn btn-danger btn-square-sm showResourceForm"  data-text="' . $text . '" data-tl="' . $tlId . '" data-sub="' . $subject_id . '">Resource</a>
      <a href="#" class="btn btn-secondary btn-square-sm showCoverage" data-text="' . $text . '" data-tl="' . $tlId . '">Coverage</a>
      <a href="#" class="btn btn-warning btn-square-sm showQuizForm"  data-text="' . $text . '" data-tl="' . $tlId . '" data-sub="' . $subject_id . '">Quiz</a>
      </div></div>';
    }
    echo '<span class="footerNote">Subject Topics will be same for one Subject irrespective of the Class and Faculty. It signifies the Syllabus.</span>';
  } elseif ($_POST['action'] == "coverage") {
    $tlId = $_POST['tlId'];
    //echo "TL Id - $tlId";
    echo '<h6>Course Coverage</h6>';
    $sno = 1;
    $sql = "select * from $tn_sas where tl_id='$tlId' and sas_status='0' order by sas_date, sas_period";
    $result = $conn->query($sql);
    echo '<table class="table list-table-xs mb-0">';
    echo '<tr><th>#</th><th>SasId</th><th>Date</th><th>Period</th><th width="50%">Topic</th><th>Wt</th></tr>';
    while ($rows = $result->fetch_assoc()) {
      $sasId = $rows["sas_id"];
      echo '<tr>';
      echo '<td>' . $sno++ . '</td><td>' . $rows["sas_id"] . '</td>';
      echo '<td>' . date("d-M",strtotime($rows["sas_date"])) . '</td>';
      echo '<td>' . $rows["sas_period"] . '</td>';
      echo '<td>';
      $output=getFieldArray($conn, $sasId, $tn_ccd, "sas_id", "sbt_id");
      for($i=0; $i<count($output); $i++){
        if($i>0)echo '<br>';
        echo getField($conn, $output[$i], $tn_sbt, "sbt_id", "sbt_name"); ;
        echo '[#'.getField($conn, $output[$i], $tn_sbt, "sbt_id", "sbt_sno").']';
      }
      echo '</td>';
      echo '<td>';
      echo '</td>';
      echo '</tr>';
    }
    echo '</table>';
  } elseif ($_POST['action'] == "stList") {
    $tlId = $_POST['tlId'];
    //echo "TL Id - $tlId";
    $tlgId = getField($conn, $tlId, $tn_tl, "tl_id", "tlg_id");
    $subject_id = getField($conn, $tlgId, $tn_tlg, "tlg_id", "subject_id");
    $tlg_type = getField($conn, $tlgId, $tn_tlg, "tlg_id", "tlg_type");
    echo '<h6>Syllabus Topics</h6>';
    $sno = 1;
    $sql = "select * from $tn_sbt where subject_id='$subject_id' and tlg_type='$tlg_type' and sbt_type='Syllabus' and sbt_status='0' order by sbt_sno";
    $result = $conn->query($sql);
    echo '<table class="table list-table-xs mb-0">';
    echo '<tr><th>#</th><th>Id</th><th>Action</th><th width="50%">Topic</th><th>Wt</th><th>Slot(s)</th><th>Coverage</th></tr>';
    while ($rows = $result->fetch_assoc()) {
      $sbtId = $rows["sbt_id"];
      echo '<tr>';
      echo '<td>' . $sno++ . '</td>';
      echo '<td>[' . $rows["sbt_id"] . '] </td>';
      echo '<td>';
      if ($sno > 2) echo '<a href="#" class="btn btn-success btn-square-xs swapButton" data-sbtId="' . $sbtId . '" data-tlId="' . $tlId . '" data-swap="UP"><i class="fa fa-arrow-up"></i></a>';
      if ($sno <= $result->num_rows) echo '<a href="#" class="btn btn-danger btn-square-xs swapButton" data-sbtId="' . $sbtId . '" data-tlId="' . $tlId . '" data-swap="DN"><i class="fa fa-arrow-down"></i></a>';
      echo '<a href="#" class="btn btn-info btn-square-xs editButton" data-sbtId="' . $sbtId . '" data-tlId="' . $tlId . '"><i class="fa fa-edit"></i></a>';
      echo '</td>';
      echo '<td>' . $rows["sbt_name"] . '</td>';
      echo '<td>' . $rows["sbt_weight"] . '</td>';
      echo '<td>';
      echo '</td>';
      echo '<td>';
      $output=getFieldArray($conn, $sbtId, $tn_ccd, "sbt_id", "sas_id");
      for($i=0; $i<count($output); $i++){
        if($i>0)echo '<br>';
        echo getField($conn, $output[$i], $tn_sas, "sas_id", "sas_date"); ;
      }
      echo '</td>';
      echo '</tr>';
    }
    echo '</table>';
    echo '<h6>Additional Topics</h6>';
    $sno = 1;
    $sql = "select * from $tn_sbt where subject_id='$subject_id' and tlg_type='$tlg_type' and sbt_type='Additional' and sbt_status='0' order by sbt_sno";
    $result = $conn->query($sql);
    echo '<table class="table list-table-xs mb-0">';
    echo '<tr><th>#</th><th>Id</th><th>Action</th><th width="50%">Topic</th><th>Wt</th><th>Slot(s)</th><th>Coverage</th></tr>';
    while ($rows = $result->fetch_assoc()) {
      $sbtId = $rows["sbt_id"];
      echo '<tr>';
      echo '<td>' . $sno++ . '</td>';
      echo '<td>[' . $rows["sbt_id"] . '] </td>';
      echo '<td>';
      if ($sno > 2) echo '<a href="#" class="btn btn-success btn-square-xs swapButton" data-sbtId="' . $sbtId . '" data-tlId="' . $tlId . '" data-swap="UP"><i class="fa fa-arrow-up"></i></a>';
      if ($sno <= $result->num_rows) echo '<a href="#" class="btn btn-danger btn-square-xs swapButton" data-sbtId="' . $sbtId . '" data-tlId="' . $tlId . '" data-swap="DN"><i class="fa fa-arrow-down"></i></a>';
      echo '<a href="#" class="btn btn-info btn-square-xs editButton" data-sbtId="' . $sbtId . '" data-tlId="' . $tlId . '"><i class="fa fa-edit"></i></a>';
      echo '</td>';
      echo '<td>' . $rows["sbt_name"] . '</td>';
      echo '<td>' . $rows["sbt_weight"] . '</td>';
      echo '<td>';
      echo '</td>';
      echo '<td>';
      echo '</td>';
      echo '</tr>';
    }
    echo '</table>';
    echo '<span class="footerNote">Syllabus Topics are not editable. These are as approved by BOS. The faculty can add additional Topics in the interest of students based on current trends and industry requirements.</span>';
  } elseif ($_POST['action'] == "addST") {
    $tlId = $_POST['tlId'];
    $sbt_name = $_POST['sbt_name'];
    $sbt_weight = $_POST['sbt_weight'];
    $sbt_type = $_POST['sbt_type'];

    //echo "TL Id - $tlId";
    $tlgId = getField($conn, $tlId, $tn_tl, "tl_id", "tlg_id");
    $subject_id = getField($conn, $tlgId, $tn_tlg, "tlg_id", "subject_id");
    $tlg_type = getField($conn, $tlgId, $tn_tlg, "tlg_id", "tlg_type");

    $sql = "select max(sbt_sno) as max from $tn_sbt where subject_id='$subject_id' and tlg_type='$tlg_type' and sbt_status='0'";
    $max_sno = getMaxValue($conn, $sql) + 1;
    //echo "Max $max_sno | Type $tlg_type";
    $dup = "select * from subject_topic where subject_id='$subject_id' and tlg_type='$tlg_type' and sbt_name='$sbt_name' and sbt_status='0'";
    $dup_alert = "Duplicate Exists";
    $fields = array("subject_id", "sbt_name", "sbt_weight", "sbt_type", "tlg_type", "sbt_sno", "sbt_status", "submit_id");
    $values = array($subject_id, $sbt_name, $sbt_weight, $sbt_type, $tlg_type, $max_sno, "0", $myId);
    addData($conn, $tn_sbt, "sbt_id", $fields, $values, "sbt_status", $dup, $dup_alert);
  } elseif ($_POST['action'] == "swap") {
    $selectedId = $_POST['sbtId'];
    $swap = $_POST['swap'];
    $sql = "select * from $tn_sbt where sbt_id='$selectedId'";
    $json = getTableRow($conn, $sql, array("subject_id", "tlg_type", "sbt_sno"));
    echo $json;
    $array = json_decode($json, true);

    $selectedSno = $array["data"][0]["sbt_sno"];
    if ($swap == "UP") $swapSno = $selectedSno - 1;
    elseif ($swap == "DN") $swapSno = $selectedSno + 1;

    $subject_id = $array["data"][0]["subject_id"];
    $tlg_type = $array["data"][0]["tlg_type"];

    $sql = "update $tn_sbt set sbt_sno='$selectedSno' where subject_id='$subject_id' and tlg_type='$tlg_type' and sbt_sno='$swapSno'";
    $result = $conn->query($sql);

    $sql = "update $tn_sbt set sbt_sno='$swapSno' where sbt_id='$selectedId'";
    $result = $conn->query($sql);
  } else if ($_POST['action'] == 'addRes') {
    $subject_id = $_POST['subjectId'];
    echo "Subject $subject_id Id $myId";

    $fields = ['rsb_name', 'rt_id', 'subject_id', 'rsb_url', 'rsb_type', 'submit_id', 'rsb_status'];
    $values = [data_check($_POST['rsb_name']), $_POST['sel_rt'], $subject_id, data_check($_POST['rsb_url']), $_POST['rsb_type'], $myId, '0'];
    $status = 'rsb_status';
    $dup = "select * from resource_subject where rsb_name='" . data_check($_POST["rsb_name"]) . "' and subject_id='$subject_id' and rt_id='" . data_check($_POST['sel_rt']) . "' and submit_id='$myId' and $status='0'";
    $dup_alert = "Duplicate Resource Type Name Exists.";
    addData($conn, 'resource_subject', 'rsb_id', $fields, $values, $status, $dup, $dup_alert);
    //echo "OK";
  } elseif ($_POST['action'] == "resList") {
    $subject_id = $_POST['subjectId'];
    //echo "Sub $subject_id";
    $subject = getField($conn, $subject_id, "subject", "subject_id", "subject_name");
    $json = get_subjectResource($conn, $tn_res, $subject_id);
    //echo $json;
    $array = json_decode($json, true);

    echo '<table class="table list-table-xs">';
    echo '<tr><th>Id</th><th>Title</th><th>Link</th><th><i class="fa fa-upload"></i></th><th>Class</th></tr>';
    for ($i = 0; $i < count($array["data"]); $i++) {
      $rsbId = $array["data"][$i]["id"];
      $rsb_name = $array["data"][$i]["name"];
      $rsb_url = $array["data"][$i]["url"];
      echo '<tr>';
      echo '<td>' . $rsbId . '</td><td>' . $rsb_name . '</td><td><a href="' . $rsb_url . '" target="_blank">' . $rsb_url . '</a></td>';
      echo '<td><button class="btn btn-square-sm upload" data-rsb="' . $rsbId . '"><i class="fa fa-upload" aria-hidden="true"></i></button></td>';
      echo '<td>';
      $jsonTL = get_staffClass($conn, $myId, $tn_tl, $tn_tlg);
      //echo $jsonTL;
      $arrayTL = json_decode($jsonTL, true);
      for ($j = 0; $j < count($arrayTL["data"]); $j++) {
        $class_id = $arrayTL["data"][$j]["class_id"];
        $sql="select * from resource_class where class_id='$class_id' and rsb_id='$rsbId'";
        $result=$conn->query($sql);
        $class = getField($conn, $class_id, "class", "class_id", "class_name");
        if($result->num_rows==0)echo '<input type="checkbox" class="resClass" name="res_class" data-resCl="' . $class_id . '" data-rsb="' . $rsbId . '">' . $class . '[' . $class_id . ']';
        else echo '<input type="checkbox" class="resClass" checked name="res_class" data-resCl="' . $class_id . '" data-rsb="' . $rsbId . '">' . $class . '[' . $class_id . ']';
      }
      echo '</td>';
      echo '</tr>';
    }
    echo '</table>';
    echo '<span class="footerNote">You can edit the resource added by you but you can use the Resource (Public) of other and assign to classes you teach.</span>';
  } elseif ($_POST['action'] == "resClass") {
    $classId = $_POST['classId'];
    $rsbId = $_POST['rsbId'];
    $checkboxStatus = $_POST['checkboxStatus'];
    
    echo "Class $classId RSB $rsbId";
    if($checkboxStatus=='true')$sql = "insert into resource_class (class_id, rsb_id) values('$classId', '$rsbId')";
    else $sql = "delete from resource_class where class_id='$classId' and rsb_id='$rsbId'";
    $conn->query($sql);
    echo $conn->error;
  }
}
