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
    $result = $conn->query($sql);
    echo '<table class="table list-table-xs"><tr><th>Id</th><th></th><th>Name</th><th>Sem</th><th>Shift</th><th>Prog</th><th>Batch</th><th><i class="fa fa-trash"></i></th><th>Action</th></tr>';
    while ($rowArray = $result->fetch_assoc()) {
      $id = $rowArray["class_id"];
      $batch_id = $rowArray["batch_id"];
      echo '<tr>';
      echo '<td>' . $id . '</td>';
      echo '<td><a href="#" class="class_idE" id="' . $id . '"><i class="fa fa-edit"></i></a></td>';
      echo '<td>' . $rowArray["class_name"] . '[' . $rowArray["class_section"] . ']</td>';
      echo '<td>' . $rowArray["class_semester"] . '</td>';
      echo '<td>' . $rowArray["class_shift"] . '</td>';
      echo '<td>' . $rowArray["sp_abbri"] . '</td>';
      echo '<td>';
      echo '<a href="#" class="increDecre" id="' . $id . '" data-value="' . ($batch_id - 1) . '"><i class="fa fa-angle-double-left"></i></a> ';
      echo $rowArray["batch"];
      echo ' <a href="#" class="increDecre" id="' . $id . '" data-value="' . ($batch_id + 1) . '"><i class="fa fa-angle-double-right"></i></a> ';
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
  } elseif ($_POST['action'] == 'clSub') {
    $classId = $_POST['classId'];

    $session_id = getField($conn, $classId, "class", "class_id", "session_id");
    $batch_id = getField($conn, $classId, "class", "class_id", "batch_id");
    $class_semester = getField($conn, $classId, "class", "class_id", "class_semester");
    $program_id = getField($conn, $classId, "class", "class_id", "program_id");

    echo "Cl $classId -B $batch_id -Sem $class_semester -P $program_id $tn_tlg";

    $sql = "select * from subject where program_id='$program_id' and batch_id='$batch_id' and subject_semester='$class_semester'";
    $result = $conn->query($sql);
    $i = 1;
    echo '<button class="btn btn-secondary btn-square-sm checkAll">Check All</button>';
    echo '<button class="btn btn-danger btn-square-sm uncheckAll">UnCheck All</button>';
    echo '<table class="table list-table-xs">';
    echo '<tr><th></th><th>#</th><th>Code</th><th>Name</th><th>L-T-P</th><th>LG</th><th>TG</th><th>PG</th></tr>';
    while ($rows = $result->fetch_assoc()) {

      $subject_id = $rows['subject_id'];
      $L = $rows['subject_lecture'];
      $T = $rows['subject_tutorial'];
      $P = $rows['subject_practical'];

      echo '<tr>';
      echo '<td><input type="checkbox" class="scb" id="sub' . $rows['subject_id'] . '"></td>';
      echo '<td>' . $i++ . '</td>';
      echo '<td>' . $rows['subject_code'] . '</td>';
      echo '<td>' . $rows['subject_name'] . '</td>';
      echo '<td>' . $L . '-' . $T . '-' . $P . '</td>';

      echo '<td>';
      if ($L > 0) tlg($conn, $tn_tlg, $subject_id, $classId, "L");
      echo '</td>';

      echo '<td>';
      if ($T > 0) tlg($conn, $tn_tlg, $subject_id, $classId, "T");
      echo '</td>';

      echo '<td>';
      if ($P > 0) tlg($conn, $tn_tlg, $subject_id, $classId, "P");
      echo '</td>';

      echo '</tr>';
    }
    $sql = "update $tn_tlg set dept_id='$myDept' where dept_id=0 and class_id='$classId'";
    $conn->query($sql);
    echo '</table>';
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
    $sno = 1;
    //echo "Classs $classId";
    $sql = "select tlg.*, sb.* from $tn_tlg tlg, subject sb where tlg.subject_id=sb.subject_id and tlg.class_id='$classId' and tlg.tlg_status='0' order by tlg.subject_id, tlg.tlg_type";
    $result = $conn->query($sql);
    if (!$result) die("Could not List the Teaching Load!");
    echo '<table  class="list-table-xs table-striped">';
    echo '<thead><th>#</th><th>TlgId</th><th>Subject</th><th>Type</th><th>Grp</th><th>Staff</th><th>Assign</th><th>Choice</th></thead>';
    while ($rows = $result->fetch_assoc()) {
      $groups = $rows['tlg_group'];
      for ($i = 1; $i <= $groups; $i++) {
        $tlgType = $rows['tlg_type'];
        echo '<tr>';
        echo '<td>' . $sno++ . '</td>';
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
            //echo '<a href="#" class="openModalUpdateStaff" id="' . $rowsStaff['tl_id'] . '" data-group="' . $i . '"><i class="fa fa-edit" aria-hidden="true"></i></a>';
            if ($result_staff->num_rows > 1) echo '<a href="#" class="unassign" data-tl="' . $rowsStaff['tl_id'] . '"><i class="fa fa-times" aria-hidden="true" style="color:red"></i></a>';
            echo ',&nbsp;';
          }
        }
        echo '</td>';
        echo '<td>';
        echo '<button class="btn btn-info btn-sm openModalAssignStaff" id="' . $rows['tlg_id'] . '" data-group="' . $i . '" data-subject="' . $rows['subject_name'] . '" data-type="' . $tlgType . '">Assign</button>';
        echo '</td>';
        echo '<td>';
        echo '<button class="btn btn-success btn-sm subAllChoices" data-tlg="' . $rows['tlg_id'] . '">Choices</button>';
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
  } elseif ($_POST['action'] == "updateTlgDept") {
    //echo "Update Dept " . $_POST['sel_dept'];
    //echo "TlgId " . $_POST['tlg_idM'];
    $sql = "update $tn_tlg set dept_id='" . $_POST['sel_dept'] . "' where tlg_id='" . $_POST['tlg_idM'] . "'";
    $conn->query($sql);
    //echo $_POST['tlg_idM'];
    echo getField($conn, $_POST['sel_dept'], "department", "dept_id", "dept_abbri"); // return to update the display
  } elseif ($_POST['action'] == "subChoiceList") {
    $sno = 1;
    $sql = "select tlg.*, sb.* from $tn_tlg tlg, subject sb where tlg.subject_id=sb.subject_id and dept_id='$myDept' and tlg.tlg_type='L' and tlg.tlg_status='0' order by tlg.subject_id, tlg.tlg_type";
    $result = $conn->query($sql);
    if (!$result) die("Could not List the Teaching Load!");
    echo '<table  class="list-table-xs table-striped">';
    echo '<thead><th>#</th><th>TlgId</th><th>Subject</th><th>Class</th><th>Weekly Load</th><th>Groups</th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th></thead>';
    while ($rows = $result->fetch_assoc()) {
      $tlgId = $rows['tlg_id'];
      $tlgGroup = $rows['tlg_group'];
      $class_id = $rows['class_id'];
      echo '<tr>';
      echo '<td>' . $sno++ . '</td>';
      echo '<td>' . $rows['tlg_id'] . '</td>';
      echo '<td>' . $rows['subject_name'] . '</td>';
      echo '<td><div id="dept' . $tlgId . '">';
      echo getField($conn, $class_id, "class", "class_id", "class_name");
      echo '</div></td>';
      echo '<td>' . $rows['subject_lecture'] . '</td><td>' . $tlgGroup . '</td>';
      $sql = "select * from $tn_sc where staff_id='$myId' and tlg_id='$tlgId'";
      $status = getFieldValue($conn, "choice", $sql);
      $td = '<i class="fa fa-check"></i>';
      if ($status == '1') echo '<td class="click"><a href="#" class="setChoice" data-choice="1" data-tlg="' . $tlgId . '">' . $td . '</a></td>';
      else echo '<td class="click"><a href="#" class="setChoice" data-choice="1" data-tlg="' . $tlgId . '">&nbsp;</a></td>';
      if ($status == '2') echo '<td class="click"><a href="#" class="setChoice" data-choice="2" data-tlg="' . $tlgId . '">' . $td . '</a></td>';
      else echo '<td class="click"><a href="#" class="setChoice" data-choice="2" data-tlg="' . $tlgId . '">&nbsp;</a></td>';
      if ($status == '3') echo '<td class="click"><a href="#" class="setChoice" data-choice="3" data-tlg="' . $tlgId . '">' . $td . '</a></td>';
      else echo '<td class="click"><a href="#" class="setChoice" data-choice="3" data-tlg="' . $tlgId . '">&nbsp;</a></td>';
      if ($status == '4') echo '<td class="click"><a href="#" class="setChoice" data-choice="4" data-tlg="' . $tlgId . '">' . $td . '</a></td>';
      else echo '<td class="click"><a href="#" class="setChoice" data-choice="4" data-tlg="' . $tlgId . '">&nbsp;</a></td>';
      if ($status == '5') echo '<td class="click"><a href="#" class="setChoice" data-choice="5" data-tlg="' . $tlgId . '">' . $td . '</a></td>';
      else echo '<td class="click"><a href="#" class="setChoice" data-choice="5" data-tlg="' . $tlgId . '">&nbsp;</a></td>';
      echo '</tr>';
    }
    echo '</table>';
  } elseif ($_POST['action'] == "setChoice") {
    //echo "Tl ".$_POST['tlg_id'];
    // echo "Value ".$_POST['value'];
    $sql = "select * from $tn_sc where staff_id='$myId' and choice='" . $_POST['value'] . "'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      // echo "Choice Found <br>";
      $sql = "delete from $tn_sc where choice='" . $_POST['value'] . "' and staff_id='$myId'";
      $result = $conn->query($sql);
    }
    $sql = "update $tn_sc set choice='" . $_POST['value'] . "' where tlg_id='" . $_POST['tlg_id'] . "' and staff_id='$myId'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    if ($conn->affected_rows == 0) {
      $sql = "insert into $tn_sc (tlg_id,staff_id,choice) values('" . $_POST['tlg_id'] . "', '$myId', '" . $_POST['value'] . "')";
      $result = $conn->query($sql);
      if (!$result) echo "Could Not Insert !!";
      else echo "Choice Added Successfully !!";
    } else echo "Choice Updated !! ";
  } elseif ($_POST['action'] == "myChoiceList") {
    $sno = 1;
    $sql = "select tlg.*, sc.* from $tn_tlg tlg, $tn_sc sc where sc.staff_id='$myId' and tlg.tlg_id=sc.tlg_id order by choice";
    $result = $conn->query($sql);
    while ($rows = $result->fetch_assoc()) {
      $tlgId = $rows['tlg_id'];
      $subject_id = $rows['subject_id'];
      $class_id = $rows['class_id'];
      $choice = $rows['choice'];
      echo '<div class="card mb-1 p-0">';
      echo '<div class="row">';
      echo '<div class="col-sm-3 pr-0 mr-0 bg-danger text-white"><h3>'.$choice.'</h3>';
      echo getField($conn, $class_id, "class", "class_id", "class_name");
      echo '</div>';
      echo '<div class="col-sm-9 p-0"><h5>';
      echo getField($conn, $subject_id, "subject", "subject_id", "subject_name");
      echo '</h5></div>';
      echo '</div></div>';
    }
  } elseif ($_POST['action'] == "subAllChoices") {
    $tlg_id=$_POST['tlg_id'];
    $subject_id=getField($conn, $tlg_id, $tn_tlg, "tlg_id", "subject_id");
    echo '<h6>'.getField($conn, $subject_id, "subject", "subject_id", "subject_name").'</h6>';

    $sql = "select sc.*, s.staff_name, s.user_id from staff s, $tn_sc sc where sc.tlg_id='$tlg_id' and sc.staff_id=s.staff_id order by sc.choice";
    $result = $conn->query($sql);
    while ($rows = $result->fetch_assoc()) {
      $tlgId = $rows['tlg_id'];
      $choice = $rows['choice'];
      echo '<div class="row border">';
      echo '<div class="col-sm-1 p-1 text-center"><h5><b>'.$choice.'</h5></b></div>';
      echo '<div class="col-sm-9 p-1">['.$rows['user_id'].'] '.$rows['staff_name'].'</div>';
      echo '</div>';
    }
  } elseif ($_POST['action'] == "tlDelete") {
    echo "TlId " . $_POST['tl_id'];
    $sql = "update $tn_tl set tl_status='9' where tl_id='" . $_POST['tl_id'] . "'";
    $conn->query($sql);
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
