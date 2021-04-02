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
						<a href="#" class="fa fa-edit editStudent" data-staff="' . $student_id . '"></a>
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

		$fields = ['student_id', 'student_name', 'student_rollno', 'student_mobile', 'student_email'];
		$values = [$_POST['modalId'], data_check($_POST['sName']), data_check($_POST['sRno']), data_check($_POST['sMobile']), data_check($_POST['sEmail'])];
		$dup = "select * from student where student_id='" . $_POST["modalId"] . "'";
		$dup_alert = "Could Not Update - Duplicate Entries";
		updateData($conn, 'student', $fields, $values, $dup, $dup_alert);
	} elseif ($_POST['action'] == 'addContact') {

		$std_id = $_POST['modalId'];
		echo "std $std_id";
		$sql = "insert into student_contact (student_id, sc_fmobile, sc_mmobile, sc_femail, sc_memail, sc_address) values ('$_POST[modalId]', '$_POST[fMobile]', '$_POST[mMobile]', '$_POST[fEmail]', '$_POST[mEmail]', '$_POST[sAddress]')";
		$result = $conn->query($sql);
		if (!$result) {
			echo "Update";
			$update = "update student_contact set sc_fmobile='$_POST[fMobile]', sc_mmobile='$_POST[mMobile]', sc_femail='$_POST[fEmail]',sc_memail='$_POST[mEmail]', sc_address='$_POST[sAddress]' where student_id = '$std_id'";
			$result = $conn->query($update);
			if (!$result) echo $conn->error;
			else echo "Updated Success";
		}
		echo "New record updated successfully";
	} elseif ($_POST['action'] == 'fetchContact') {
		$id = $_POST['studentId'];
		$sql = "select * from student_contact where student_id='$id'";
		$result = $conn->query($sql);
		$output = $result->fetch_assoc();
		echo json_encode($output);
	} elseif ($_POST['action'] == 'addDetails') {
		$std_id = $_POST['modalId'];
		$sql = "insert into student_details (student_id, sd_fname, sd_mname, sd_foccupation, sd_fdesignation, sd_dob, sd_gender, sd_category) values ('$_POST[modalId]', '$_POST[fName]', '$_POST[mName]', '$_POST[fOccupation]', '$_POST[fDes]', '$_POST[sDob]', '$_POST[sGender]', '$_POST[sCategory]')";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		else echo " Success";
		if (!$result) {
			$update = "update student_details set sd_fname='$_POST[fName]', sd_mname='$_POST[mName]', sd_foccupation='$_POST[fOccupation]',sd_fdesignation='$_POST[fDes]', sd_dob='$_POST[sDob]', sd_gender='$_POST[sGender]', sd_category='$_POST[sCategory]' where student_id = '$std_id'";
			$conn->query($update);
		}
		echo "New record updated successfully";
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
		$sq_id = $_POST['modalId'];
		echo "id $sq_id Inst $sInst";
		$update = "update student_qualification set qualification_id='$_POST[sel_qual]', sq_institute='$_POST[sInst]', sq_board='$_POST[sBoard]', sq_year='$_POST[sYear]', sq_marksObtained='$_POST[sMarksObt]', sq_marksMax='$_POST[sMaxMarks]', sq_percentage='$_POST[sCgpa]' where sq_id = '$sq_id'";
		// $update = "update student_qualification set sq_institute='$_POST[sInst]' where sq_id = '$sq_id'";
		$result = $conn->query($update);
		if (!$result) echo $conn->error;
		else echo "New record updated successfully $result";
	} elseif ($_POST['action'] == 'fetchStudentQualification') {
		$sq_id = $_POST['sqId'];
		$sql = "select * FROM student_qualification where sq_id='$sq_id'";
		$result = $conn->query($sql);
		$output = $result->fetch_assoc();
		echo json_encode($output);
	}
}
