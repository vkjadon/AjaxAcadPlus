<?php
require('../requireSubModule.php');

//echo $_POST['action'];
if (isset($_POST['action'])) {
  if ($_POST["action"] == "addPo") {
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
  } 
}
