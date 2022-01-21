<?php
require('../requireSubModule.php');

// echo "--".$mySes.'-'.$myProg;
if (isset($_POST['action'])) {
  if ($_POST['action'] == "pclList") {
    $sql = "select * from class where session_id='$mySes' and program_id='$myProg'";
    $result = $conn->query($sql);
    $i = 0;
    echo '<div class="row">';
    while ($classRows = $result->fetch_assoc()) {
      echo '<div class="col-1">';
      $class_id = $classRows['class_id'];
      $class_name = $classRows['class_name'];
      $class_section = $classRows['class_section'];
      if ($i == 0) echo '<input type="radio" class="sel_class" checked id="cl' . $class_id . '" name="class" value="' . $class_id . '">';
      else echo '<input type="radio" class="sel_class"  id="cl' . $class_id . '" name="class" value="' . $class_id . '">';
      echo '<span class="smallerText"> ' . $class_name . '[' . $class_section . '] ' . '</span>';
      echo '</div>';
      $i++;
    }
    echo '</div>';
  } elseif ($_POST['action'] == "fetchAttRepHeaderFooter") {
    $class_id = $_POST['class_id'];

    // From Class
    $className = getField($conn, $class_id, 'class', 'class_id', 'class_name');
    $class_section = getField($conn, $class_id, 'class', 'class_id', 'class_section');

    // echo $className;

    $output = array(
      "class_name" => $className,
      "class_section" => $class_section
    );
    echo json_encode($output);
  } elseif ($_POST['action'] == "attRecord") {
    $class_id = $_POST['class_id'];

    $class_name = getField($conn, $class_id, "class", "class_id", "class_name");
    $batch_id = getField($conn, $class_id, "class", "class_id", "batch_id");
    $class_semester = getField($conn, $class_id, "class", "class_id", "class_semester");
    $program_id = getField($conn, $class_id, "class", "class_id", "program_id");

    //echo "Cl $classId -B $batch_id -Sem $class_semester -P $program_id $tn_tlg";

    $sql = "select * from subject where program_id='$program_id' and batch_id='$batch_id' and subject_semester='$class_semester'";
    $result = $conn->query($sql);
    $count = 0;
    while ($rows = $result->fetch_assoc()) {
      $subject_id[$count] = $rows['subject_id'];
      $subject_code[$count] = $rows['subject_code'];
      $subject_name[$count] = $rows['subject_name'];
      $count++;
    }


    $tn_sa = 'student_attendance' . $class_id;

    // echo $className;
    $sql = "select * from $tn_rc where class_id='$class_id'";
    $result = $conn->query($sql);
    if (!$result) die(" The script could not be Loadded! Unable to populate Student List !");
    while ($rows = $result->fetch_assoc()) {
      $sub_array = array();
      $sub_array["student_id"] = $rows['student_id'];
      $sub_array["student_name"] = getField($conn, $rows['student_id'], "student", "student_id", "student_name");
      $sub_array["student_rollno"] = getField($conn, $rows['student_id'], "student", "student_id", "student_rollno");
      $sub_array["rc_date"] = $rows['rc_date'];
      for ($i = 0; $i < $count; $i++) {
        $sql_sas = "select sa.sa_attendance from $tn_tlg tlg, $tn_tl tl, $tn_sas sas, $tn_sa sa where tlg.subject_id='".$subject_id[$i]."' and tlg.class_id='$class_id' and tl.tlg_id=tlg.tlg_id and sas.tl_id=tl.tl_id and sa.sas_id=sas.sas_id and sa.student_id='".$rows["student_id"]."' and sa.sa_attendance='0'";
        $result_sas=$conn->query($sql_sas);
        $sub_array["scheduled"][] = $result_sas->num_rows;
      }
      $data[] = $sub_array;
    }
    $output = array(
      "records" => $data,
      "subject_code" => $subject_code
    );
    echo json_encode($output);
  }
}
