<?php
require('../requireSubModule.php');

//echo "Action " . $_POST['action'];

if (isset($_POST['action'])) {
  if ($_POST['action'] == "pof") {
    //echo "Add Assessment Method Block";
    $sql = "select * from po_feedback where pf_status='0' order by pf_name";
    selectList($conn, 'Select an Assessment ', array('1', 'pf_id', 'pf_name', 'pf_id', 'sel_pf'), $sql);
  } elseif ($_POST['action'] == "dept") {
    //echo "Add Assessment Method Block";
    $sql = "select * from department where dept_status='0'";
    selectList($conn, 'Select Department', array('1', 'dept_id', 'dept_name', 'dept_abbri', 'sel_dept'), $sql);
  } elseif ($_POST['action'] == "deptClass") {
    //echo "Add Assessment Method Block";
    $sql = "select cl.* from department d, class cl where cl.dept_id=d.dept_id and dept_status='0'";
    selectList($conn, 'Select Class', array('1', 'class_id', 'class_name', 'class_id', 'sel_class'), $sql);
  } elseif ($_POST['action'] == 'hfFb') {
    //echo "Action in poFb" . $_POST['action'];

    $pf_id = $_POST['pfId'];
    $program_id = getField($conn, $pf_id, "po_feedback", "pf_id", "program_id");
    $batch_id = getField($conn, $pf_id, "po_feedback", "pf_id", "batch_id");
    $sql = "select * from po_feedback where pf_id='$pf_id'";
    $pf_header = getFieldValue($conn, "pf_header", $sql);
    $pf_footer = getFieldValue($conn, "pf_footer", $sql);
    echo '<div class="row offset-1">';
    echo '<div class="col-10 text-center"><h5>Feedback Form</h5>';
    echo 'Type in your Instructions/Request';
    echo '<textarea class="hf" rows="3" data-tag="H"  data-pf="' . $pf_id . '">' . $pf_header . '</textarea>';
    echo '</div></div>';

    $sql = "select * from pof_question where pf_id='$pf_id'";
    $result = $conn->query($sql);
    if ($result) {
      $sno = 0;
      while ($rows = $result->fetch_assoc()) {
        $sno++;
        $question = $rows['pq_statement'];
        $pq_id = $rows['pq_id'];
        //echo $question;
        echo '<div class="row pt-2">';
        echo '<div class="col-1 offset-1 text-right"><span class="badge  badge-pill badge-secondary">' . $sno . '</span></div>';
        echo '<div class="col-8 fbQuestion">' . $question . '</div>';
        echo '</div>';
        echo '<div class="offset-2 pb-2">';
        echo '<div class="row">';
        $sqlOption = "select * from pof_option where pq_id='$pq_id' order by po_scale desc";
        $resultOption = $conn->query($sqlOption);
        if ($resultOption) {
          while ($rowsOption = $resultOption->fetch_assoc()) {
            echo '<div class="col">';
            echo '<input type="radio" class="fbOption" data-pq="' . $pq_id . '" data-scale="' . $rowsOption['po_scale'] . '" name="' . $pq_id . '">';
            echo $rowsOption['po_option'];
            echo '</div>';
          }
          echo '<div class="col-1"></div>';
        }
        echo '</div>';
        echo '</div>';
      }
      echo '<hr>';
      echo '<div class="row offset-1">';
      echo '<div class="col-10 text-center">';
      echo 'Type in your Footer';
      echo '<textarea class="hf" rows="3" data-tag="F"  data-pf="' . $pf_id . '">' . $pf_footer . '</textarea>';
      echo '</div></div>';
    }
  } elseif ($_POST['action'] == 'poFb') {
    //echo "Action in poFb" . $_POST['action'];
    echo '<table class="table list-table-xs" id="tblData">';
    echo '<tr align="center">';
    $au = '5';
    $pf_id = $_POST['pfId'];
    $program_id = getField($conn, $pf_id, "po_feedback", "pf_id", "program_id");
    $batch_id = getField($conn, $pf_id, "po_feedback", "pf_id", "batch_id");
    echo '<td>' . $program_id . '</td><td width="40%">PO</td>';
    for ($j = 1; $j <= $au; $j++) echo '<td>' . $j . '</td>';
    echo '</tr>';
    $sqlPO = "select * from program_outcome where program_id='$program_id' and batch_id='$batch_id' and po_status='0'";
    $resultPO = $conn->query($sqlPO);
    $i = 0;
    while ($rowsPO = $resultPO->fetch_assoc()) {
      $po_id = $rowsPO['po_id'];

      $sql = "select * from pof_question where po_id='$po_id' and pf_id='$pf_id'";
      $result = $conn->query($sql);
      if ($result) {
        $rows = $result->fetch_assoc();
        $pq_statement = $rows['pq_statement'];
        $pq_id = $rows['pq_id'];
      }
      if ($pq_statement == "") {
        $pq_statement = $rowsPO['po_name'];
        $sql = "INSERT INTO pof_question (pf_id, po_id, pq_statement) VALUES('$pf_id', '$po_id', '$pq_statement')";
        $result = $conn->query($sql);
        $pq_id = $conn->insert_id;
      }

      echo '<tr>';
      echo '<td class="po" id="po' . $po_id . '" data-toggle="tooltip">' . $rowsPO['po_code'] . $rowsPO['po_sno'] . '</td><td><textarea class="poId" rows="3" cols="60" data-tag="PO"  data-pf="' . $pf_id . '" data-po="' . $po_id . '">' . $pq_statement . '</textarea></td>';
      for ($j = 1; $j <= $au; $j++) {
        $po_option = "";
        if ($pq_id > 0) {
          $sqlOption = "select * from pof_option where pq_id='" . $pq_id . "' and po_scale='" . $j . "'";
          $resultOption = $conn->query($sqlOption);
          if ($resultOption->num_rows > 0) {
            $rowsOption = $resultOption->fetch_assoc();
            $po_option = $rowsOption['po_option'];
          } else echo $conn->error;
        }
        echo '<td><textarea class="poOption" rows="3" cols="10" data-scale="' . $j . '" data-pq="' . $pq_id . '">' . $po_option . '</textarea></td>';
      }
      echo '<td><button class="btn btn-info btn-square-sm poScaleCopy" data-pq="' . $pq_id . '">Copy Option to All</button></td>';
      echo '</tr>';
    }
    echo '</table>';
  } elseif ($_POST['action'] == 'pfQuestion') {
    //echo "Action " . $_POST['action'];
    $pq_statement = $_POST['pfQuestion'];
    $po_id = $_POST['poId'];
    $pf_id = $_POST['pfId'];

    $sql = "INSERT INTO pof_question (pf_id, po_id, pq_statement) VALUES('$pf_id', '$po_id', '$pq_statement')";
    $result = $conn->query($sql);
    if (!$result) {
      $sql = "update pof_question set pq_statement='$pq_statement' where po_id='$po_id' and pf_id='$pf_id'";
      $res = $conn->query($sql);
      if (!$res) echo $conn->error;
    }
  } elseif ($_POST['action'] == 'poOption') {
    echo "Action " . $_POST['action'];
    $po_option = $_POST['poOption'];
    $pq_id = $_POST['pqId'];
    $po_scale = $_POST['scale'];

    $sql = "INSERT INTO pof_option (pq_id, po_scale, po_option) VALUES('$pq_id', '$po_scale', '$po_option')";
    $result = $conn->query($sql);
    if (!$result) {
      $sql = "update pof_option set po_option='$po_option' where pq_id='$pq_id' and po_scale='$po_scale'";
      $res = $conn->query($sql);
      if (!$res) echo $conn->error;
    }
  } elseif ($_POST['action'] == 'poCopy') {
    echo "Action " . $_POST['action'];
    $pq_id = $_POST['pqId'];
    $pf_id = $_POST['pfId'];

    for ($i = 0; $i < 5; $i++) {
      $scale = $i + 1;
      $sql = "select * from pof_option where pq_id='$pq_id' and po_scale='$scale'";
      $po_option[$i] = getFieldValue($conn, "po_option", $sql);
    }
    $sqlPQ = "select * from pof_question where pf_id='$pf_id' and pq_status='0'";
    $resultPQ = $conn->query($sqlPQ);
    while ($rowsPQ = $resultPQ->fetch_assoc()) {
      $pq = $rowsPQ['pq_id'];
      //echo $pq.' - ';
      for ($i = 0; $i < 5; $i++) {
        $scale = $i + 1;
        $sql = "INSERT INTO pof_option (pq_id, po_scale, po_option) VALUES('$pq', '$scale', '$po_option[$i]')";
        $result = $conn->query($sql);
        if (!$result) {
          $sql = "update pof_option set po_option='$po_option[$i]' where pq_id='$pq' and po_scale='$scale'";
          $result = $conn->query($sql);
        }
      }
      //else echo 'Added';
    }
  }
}
