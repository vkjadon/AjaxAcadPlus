<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
//echo $_POST['action'];
if (isset($_POST["query"])) {
 $output = '';
 $sql = "select * from student where student_name LIKE '%" . $_POST["query"] . "%'";
 $result = $conn->query($sql);
 $output = '<ul class="list-group">';
 if ($result) {
  while ($row = $result->fetch_assoc()) {
   $output .= '<li class="list-group-item list-group-item-action autoList" data-std="' . $row["student_id"] . '" >' . $row["student_name"] . '</li>';
  }
 } else {
  $output .= '<li>Student Not Found</li>';
 }
 $output .= '</ul>';
 echo $output;
}
if (isset($_POST['action'])) {
 if ($_POST['action'] == 'studentList') {

  $program_id = $_POST['programId'];
  $batch_id = $_POST['batchId'];
  if ($program_id > 0 && $batch_id > 0) $sql = "select * from student st where st.program_id='$program_id' and st.batch_id='$batch_id' and student_status='0' order by student_name";
  $json = getTableRow($conn, $sql, array("student_id", "student_name", "student_rollno"));
  // echo $json;
  $array = json_decode($json, true);
  $count = count($array["data"]);
  //  echo $count;
  for ($i = 0; $i < count($array["data"]); $i++) {
   $student_id = $array["data"][$i]["student_id"];
   $student_name = $array["data"][$i]["student_name"];
   $student_rollno = $array["data"][$i]["student_rollno"];

   echo '<div class="card">
      <div class="card-body mb-0">
						<div class="row">
						<div class="col-10">
      <h7 class="card-title">' . $student_name . '</h7><br>
						</div>
						<div class="col-2">
						<a href="#" class="fa fa-edit editStudent" data-student="' . $student_id . '"></a>
						</div>
						</div>
      <h8 class="card-subtitle mb-2 text-muted">' . $student_rollno . ' </h8>
      </div></div>';
  }
 } elseif ($_POST['action'] == 'addStudent') {

  $program_id = $_POST['programIdModal'];
  $fields = ['batch_id', 'program_id', 'student_name', 'student_rollno', 'student_mobile', 'student_email'];
  $values = [$_POST['batchIdModal'], $_POST['programIdModal'], data_check($_POST['sName']), data_check($_POST['sRno']), $_POST['sMobile'], $_POST['sEmail']];
  $status = 'student_status';
  $dup = "select * from student where student_rollno='" . data_check($_POST["sRno"]) . "' and $status='0'";
  $dup_alert = "Duplicate URL Exists. One Dept can have one URL. Give Dummy Unique URL if required";
  addData($conn, 'student', 'student_id', $fields, $values, $status, $dup, $dup_alert);
 } elseif ($_POST['action'] == 'fetchStudent') {

  $id = $_POST['studentId'];
  $sql = "select * FROM student where student_id='$id'";
  $result = $conn->query($sql);
  $output = $result->fetch_assoc();
  echo json_encode($output);
 } elseif ($_POST['action'] == 'updateStudent') {
  $id_name = $_POST['id_name'];
  $id = $_POST['id'];
  $tag = $_POST['tag'];
  $value = $_POST['value'];
  $sql = "update student set $tag='$value' where $id_name='$id'";
  $conn->query($sql);
  echo $conn->error;
 } elseif ($_POST['action'] == 'updateContact') {
  $id_name = $_POST['id_name'];
  $student_id = $_POST['student_id'];
  $id = $_POST['id'];
  $tag = $_POST['tag'];
  $value = $_POST['value'];
  $sql = "update student_contact set $tag='$value' where $id_name='$id'";
  $result = $conn->query($sql);
  $affectedRows = $conn->affected_rows;
  echo "affected rows $affectedRows";
  if (!$result) echo $conn->error;
  elseif ($affectedRows == 0) {
   $sql = "insert into student_contact (student_id, $tag) values ('$student_id', '$value')";
   $result = $conn->query($sql);
   if (!$result) echo $conn->error;
  } else "Updated";
 } elseif ($_POST['action'] == 'fetchContact') {
  $id = $_POST['studentId'];
  $sql = "select * from student_contact where student_id='$id'";
  $result = $conn->query($sql);
  $output = $result->fetch_assoc();
  echo json_encode($output);
 } elseif ($_POST['action'] == 'updateDetails') {
  $id_name = $_POST['id_name'];
  $student_id = $_POST['student_id'];
  $id = $_POST['id'];
  $tag = $_POST['tag'];
  $value = $_POST['value'];
  $sql = "update student_details set $tag='$value' where $id_name='$id'";
  $result = $conn->query($sql);
  $affectedRows = $conn->affected_rows;
  echo "affected rows $affectedRows";
  if (!$result) echo $conn->error;
  elseif ($affectedRows == 0) {
   $sql = "insert into student_details (student_id, $tag) values ('$student_id', '$value')";
   $result = $conn->query($sql);
   if (!$result) echo $conn->error;
  } else "Updated";
 } elseif ($_POST['action'] == 'fetchDetails') {
  $id = $_POST['studentId'];
  $sql = "select * from student_details where student_id='$id'";
  $result = $conn->query($sql);
  $output = $result->fetch_assoc();
  echo json_encode($output);
 } elseif ($_POST['action'] == 'addStudentQualification') {
  $std_id = $_POST['stdIdModal'];
  $sql = "insert into student_qualification (student_id, qualification_id, sq_institute, sq_board, sq_year, sq_marksObtained, sq_marksMax, sq_percentage) values ('$_POST[stdIdModal]', '$_POST[sel_qual]', '$_POST[sInst]', '$_POST[sBoard]', '$_POST[sYear]', '$_POST[sMarksObt]', '$_POST[sMaxMarks]', '$_POST[sCgpa]')";
  $result = $conn->query($sql);
  if (!$result) echo $conn->error;
  else echo "Success";
 } elseif ($_POST['action'] == 'studentQualificationList') {
  $tableId = 'sq_id';

  $stdId = $_POST['stdId'];

  $statusDecode = array("status" => "sq_status", "0" => "Active", "9" => "Inactive");
  $button = array("1", "1", "0", "0");

  $fields = array("qualification_name", "sq_institute", "sq_board", "sq_year", "sq_marksObtained", "sq_marksMax", "sq_percentage");
  $dataType = array("0", "0", "0", "0", "0", "0", "0");
  $header = array("Id", "Qualification", "Institute", "Board", "Passing Year", "Marks Obtained", "Maximum Marks", "Percentage/CGPA");

  if ($stdId > 0) $sql = "select sq.*, q.qualification_name from student_qualification sq, qualification q where q.qualification_id=sq.qualification_id and sq.student_id='$stdId'";
  getList($conn, $tableId, $fields, $dataType, $header, $sql, $statusDecode, $button);
 } elseif ($_POST['action'] == 'updateStudentQualification') {
  $id_name = $_POST['id_name'];
  $student_id = $_POST['student_id'];
  $id = $_POST['id'];
  $tag = $_POST['tag'];
  $value = $_POST['value'];
  $sql = "update student_qualification set $tag='$value' where $id_name='$id' and student_id='$student_id'";
  $result = $conn->query($sql);
  $affectedRows = $conn->affected_rows;
  echo "affected rows $affectedRows";
  if (!$result) echo $conn->error;
  elseif ($affectedRows == 0) {
   $sql = "insert into student_qualification (student_id, qualification_id, $tag) values ('$student_id', '$id, '$value')";
   $result = $conn->query($sql);
   if (!$result) echo $conn->error;
  } else "Updated";
 } elseif ($_POST['action'] == 'fetchStudentQualification') {
  $sq_id = $_POST['sqId'];
  $sql = "select * FROM student_qualification where sq_id='$sq_id'";
  $result = $conn->query($sql);
  $output = $result->fetch_assoc();
  echo json_encode($output);
 } elseif ($_POST['action'] == 'studentProgramList') {
  $sql = "SELECT * from program";
  $json = getTableRow($conn, $sql, array("program_id", "program_name"));
  // echo $json;
  $array = json_decode($json, true);
  $count = count($array["data"]);
  // echo $count;
  echo '<table class="list-table-xs">
     <thead align="center">
     <table class="list-table-xs">
     <thead align="center"><th>Program</th><th>Student Registered</th>
     </thead>';
  for ($i = 0; $i < count($array["data"]); $i++) {
   $program_id = $array["data"][$i]["program_id"];
   $program_name = $array["data"][$i]["program_name"];
   $sql_desig = "select * from student where program_id='$program_id' and batch_id='$myBatch'";
   $result = $conn->query($sql_desig);
   $rowcount=mysqli_num_rows($result);
   echo '<tr><td>' . $program_name . '</td><td>' . $rowcount . '</td></tr>';
  }
  echo '</table></table>';

 }
}
