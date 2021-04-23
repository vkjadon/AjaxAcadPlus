<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
//echo $_POST['action'];
//global $tn_tt;
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'clList') {
    $sql = "select cl.*, p.sp_abbri, b.batch from class cl, program p, batch b where cl.program_id=p.program_id and cl.batch_id=b.batch_id and cl.session_id='$mySes' and cl.program_id='$myProg' order by cl.class_semester";
    $result=$conn->query($sql);
    echo '<table class="table list-table-xs"><tr><th>Id</th><th></th><th>Name</th><th>Sem</th><th>Shift</th><th>Prog</th><th>Batch</th><th><i class="fa fa-trash"></i></th><th>Action</th></tr>';
    while($rowArray=$result->fetch_assoc()){
      $id=$rowArray["class_id"];
      $batch_id=$rowArray["batch_id"];
      echo '<tr>';
        echo '<td>'.$id.'</td>';
        echo '<td><a href="#" class="class_idE" id="' . $id . '"><i class="fa fa-edit"></i></a></td>';
        echo '<td>'.$rowArray["class_name"].'['.$rowArray["class_section"].']</td>';
        echo '<td>'.$rowArray["class_semester"].'</td>';
        echo '<td>'.$rowArray["class_shift"].'</td>';
        echo '<td>'.$rowArray["sp_abbri"].'</td>';
        echo '<td>';
        echo '<a href="#" class="increDecre" id="' . $id . '" data-value="' . ($batch_id-1) . '"><i class="fa fa-angle-double-left"></i></a> ';
        echo $rowArray["batch"];
        echo ' <a href="#" class="increDecre" id="' . $id . '" data-value="' . ($batch_id+1) . '"><i class="fa fa-angle-double-right"></i></a> ';
        echo '</td>';
        echo '<td><a href="#" class="class_idD" id="' . $id . '"><i class="fa fa-trash"></i></a></td>';
        echo '<td><a href="#" class="class_idP" id="' . $id . '">Groups</a></td>';
        echo '</tr>';
    }

    //echo "$programId - $mySes";
  } else if ($_POST['action'] == 'addClass') {
    $fields = ['session_id', 'program_id', 'dept_id',  'class_name', 'class_section', 'batch_id', 'class_semester', 'class_shift', 'submit_id'];
    $values = [$mySes, $myProg, $myDept, data_check($_POST['class_name']), data_check($_POST['class_section']), $myBatch, data_check($_POST['class_semester']), $_POST['class_shift'], $myId];
    $status = 'class_status';
    $dup = "select * from class where class_name='" . data_check($_POST["class_name"]) . "' and class_section='" . data_check($_POST["class_section"]) . "' and session_id='$mySes' and $status='0'";
    $dup_alert = "Duplicate Class Name for the Session Exists.";
    addData($conn, 'class', 'class_id', $fields, $values, $status, $dup, $dup_alert);
  } elseif ($_POST['action'] == 'fetchClass') {
    $id = $_POST['classId'];
    $sql = "SELECT * FROM class where class_id='$id'";
    $result = $conn->query($sql);
    $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST['action'] == "updateClass") {
    //echo "Update Class " . $_POST['modalId'];
    $fields = ['class_id', 'class_name', 'class_shift', 'class_semester', 'class_section'];
    $values = [$_POST['modalId'], data_check($_POST['class_name']), $_POST['class_shift'], data_check($_POST['class_semester']), data_check($_POST['class_section'])];
    $status = 'class_status';
    $dup_alert = " Class Name, Section Alreday Exists for this Session !! ";
    updateUniqueData($conn, 'class', $fields, $values, $dup_alert);
  } elseif ($_POST['action'] == 'increDecre') {
    $value = $_POST['value'];
    $id = $_POST['id'];
    updateField($conn, "class", array("class_id", "batch_id"), array($id, $value), "");
  } elseif ($_POST['action'] == 'increment') {
    $value = $_POST['value'] + 1;
    $tlg_id = $_POST['tlg_id'];
    echo "Current Value " . $value;
    echo "Current Id " . $tlg_id;
    updateField($conn, $tn_tlg, array("tlg_id", "tlg_group"), array($tlg_id, $value), "");
  } elseif ($_POST['action'] == 'decrement') {
    $value = $_POST['value'] - 1;
    $tlg_id = $_POST['tlg_id'];
    if ($value > 0) updateField($conn, $tn_tlg, array("tlg_id", "tlg_group"), array($tlg_id, $value), "");
  } elseif ($_POST["action"] == "tl") {
    $classId = $_POST['classId'];
    $sno=1;
    echo "Classs $classId";
    $sql = "select tlg.*, sb.* from $tn_tlg tlg, subject sb where tlg.subject_id=sb.subject_id and tlg.class_id='$classId' and tlg.tlg_status='0' order by tlg.subject_id, tlg.tlg_type";
    $result = $conn->query($sql);
    if (!$result) die("Could not List the Teaching Load!");
    echo '<table  class="list-table-xs table-striped">';
    echo '<thead><th>#</th><th>TlgId</th><th>Subject</th><th>Type</th><th>Grp</th><th>Staff</th><th>Assign</th></thead>';
    while ($rows = $result->fetch_assoc()) {
      $groups = $rows['tlg_group'];
      for ($i = 1; $i <= $groups; $i++) {
        $tlgType = $rows['tlg_type'];
        echo '<tr>';
        echo '<td>' . $sno++. '</td>';
        echo '<td>' . $rows['tlg_id'] . '</td>';
        echo '<td>' . $rows['subject_name'] . '</td>';
        if ($tlgType == 'L') echo '<td>' . $tlgType . '-' . $rows['subject_lecture'] . '</td><td>LG-' . $i . '</td>';
        elseif ($tlgType == 'T') echo '<td>' . $tlgType . '-' . $rows['subject_tutorial'] . '</td><td>TG-' . $i . '</td>';
        else echo '<td>' . $tlgType . '-' . $rows['subject_practical'] . '</td><td>PG-' . $i . '</td>';
        $sql_staff = "SELECT * FROM $tn_tl WHERE tlg_id ='" . $rows['tlg_id'] . "' and tl_group='$i' and tl_status='0'";
        $result_staff = $conn->query($sql_staff);
        $counter = 0;
        echo '<td>';
        while ($rowsStaff = $result_staff->fetch_array()) {
          $counter++;
          $staff_id = $rowsStaff['staff_id'];
          if ($staff_id > 0) {
            echo getField($conn, $staff_id, 'staff', 'staff_id', 'staff_name');
            echo '<a href="#" class="openModalUpdateStaff" id="' . $rowsStaff['tl_id'] . '" data-group="' . $i . '"><i class="fa fa-edit" aria-hidden="true"></i></a>';
            if ($result_staff->num_rows > 1) echo '<a href="#" class="unassign" id="' . $rowsStaff['tl_id'] . '"><i class="fa fa-times" aria-hidden="true" style="color:red"></i></a>';
            echo ',&nbsp;';
          }
        }
        echo '</td>';
        echo '<td>';
        echo '<button class="btn-info btn-xs openModalAssignStaff" id="' . $rows['tlg_id'] . '" data-group="' . $i . '" data-subject="' . $rows['subject_name'] . '" data-type="' . $tlgType . '">+</button>';
        echo '</td>';

        echo '</tr>';
      }
    }
    echo '</table>';
  } elseif ($_POST["action"] == "assignStaff") {
    $tlg_id = $_POST["tlg_idM"];
    $tl_group = $_POST["tl_groupM"];
    $staff_id = $_POST["sel_staff"];
    $sql = "update $tn_tl set tl_status='A' where tlg_id='$tlg_id' and staff_id='$staff_id'";
    $result = $conn->query($sql);
    if (!$result) {
      echo $conn->error;
      die();
    }
    echo "Rows affetced -- " . $conn->affected_rows;
    if ($conn->affected_rows == 0) {
      echo "No row affected";
      $sql = "insert into $tn_tl (tlg_id, staff_id, tl_group, submit_id, tl_status) values('$tlg_id','$staff_id', '$tl_group', '$myId', 'A')";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else 'Added';
    }
  } elseif ($_POST["action"] == "tlData") {
    $classId = $_POST['classId'];
    $tlgType = $_POST['tlgType'];
    $dayId = $_POST['day'];
    $period = $_POST['period'];
    //echo "Classs $classId";
    $sql = "select tl.*, tlg.* from $tn_tl tl, $tn_tlg tlg where tlg.tlg_id=tl.tlg_id and tlg.class_id='$classId' and tlg.tlg_type='$tlgType' and tl.tl_status='0' order by tlg.tlg_type";
    $result = $conn->query($sql);
    if (!$result) die("Could not List the Teaching Load!");
    echo '<table  class="list-table-xs table-striped">';
    echo '<thead><th>tl-tlg</th><th>Subject</th><th>Staff</th><th>Grp</th><th>Assign</th></thead>';
    while ($rows = $result->fetch_assoc()) {
      $subject_name = getField($conn, $rows['subject_id'], "subject", "subject_id", "subject_name");
      $staff_name = getField($conn, $rows['staff_id'], "staff", "staff_id", "staff_name");
      echo '<tr>';
      echo '<td>' . $rows['tl_id'] . '-' . $rows['tlg_id'] . '</td>';
      echo '<td>' . $subject_name . '</td>';
      echo '<td>' . $staff_name . '</td>';
      echo '<td>' . $rows['tlg_type'] . '-' . $rows['tl_group'] . '</td>';
      echo '<td>';
      echo '<button class="btn-info btn-xs addSlot" id="' . $rows['tl_id'] . '" data-day="' . $dayId . '" data-period="' . $period . '">+</button>';
      echo '</td>';
      echo '</tr>';
    }
    echo '</table>';
  }
}

function tlg($conn, $tn_tlg, $subject_id, $classId, $tlg_type)
{
  //echo "Table $tn_tlg";
  $dup = "select * from $tn_tlg where subject_id='$subject_id' and class_id='$classId' and tlg_type='$tlg_type'";
  addData($conn, $tn_tlg, "tlg_id", array("class_id", "subject_id", "tlg_type", "tlg_group"), array($classId, $subject_id, $tlg_type, "1"), "tlg_status", $dup, "NULL");

  $sql = "select * from $tn_tlg where subject_id='" . $subject_id . "' and class_id='$classId' and tlg_type='$tlg_type' and tlg_status='0' order by tlg_group desc";
  $id = getFieldValue($conn, "tlg_id", $sql);

  $value = getFieldValue($conn, "tlg_group", $sql);
  echo '<a href="#" class="decrement" id="' . $id . '" data-value="' . $value . '"><i class="fa fa-angle-double-left"></i></a>';
  echo '<span class="' . $id . '">' . $value . '</span>';
  echo '<a href="#" class="increment" id="' . $id . '" data-value="' . $value . '"><i class="fa fa-angle-double-right"></i></a>';
}
