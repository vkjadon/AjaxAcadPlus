<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
//echo $_POST['action'];
if (isset($_POST['actionDeptProgram'])) {
	$deptId = $_POST['deptIdHidden2'];
	$programId = $_POST['programIdHidden'];
	echo "$deptId,$schoolId";
	if (!$_POST['sel_deptProgram'] == NULL && !$_POST['sel_program'] == NULL) {
		$sql = "insert into dept_program (dept_id, program_id) values('$deptId', '$programId')";
		$result = $conn->query($sql);
		if ($result) echo "Added Successfully";
		else {
			$error = $conn->errno;
		}
	} else echo "No Field should be Blank";
}
if (isset($_POST['action'])) {
	if ($_POST['action'] == 'addInst') {
		//echo "MyId- $myId";
		$fields = ['inst_name', 'inst_abbri', 'inst_url', 'inst_doi', 'submit_id'];
		$values = [data_check($_POST['inst_name']), data_check($_POST['inst_abbri']), $_POST['inst_url'], $_POST['inst_doi'], $myId];
		$status = 'inst_status';
		$dup = "select * from institution where inst_url='" . data_check($_POST["inst_url"]) . "' and $status='0'";
		$dup_alert = "Duplicate URL Exists. One Institute can have one URL. Give Dummy Unique URL if required";
		addData($conn, 'institution', 'inst_id', $fields, $values, $status, $dup, $dup_alert);
	} elseif ($_POST['action'] == 'updateInst') {
		$id_name = $_POST['id_name'];
		$id = $_POST['id'];
		$tag = $_POST['tag'];
		$value = $_POST['value'];

		$sql = "update institution set $tag='$value' where $id_name='$id'";
		$conn->query($sql);
		echo $conn->error;
	} elseif ($_POST['action'] == 'fetchInst') {
		$id = $_POST['instId'];
		$sql = "SELECT * FROM institution where inst_id='$id'";
		$result = $conn->query($sql);
		$output = $result->fetch_assoc();
		echo json_encode($output);
	} elseif ($_POST['action'] == 'addSchool') {
		// echo "MyId- $myId";
		// echo "inside";
		$fields = ['school_name', 'school_abbri', 'school_url', 'school_doi', 'submit_id'];
		$values = [data_check($_POST['school_name']), data_check($_POST['school_abbri']), $_POST['school_url'], $_POST['school_doi'], $myId];
		$status = 'school_status';
		$dup = "select * from school where school_url='" . data_check($_POST["school_url"]) . "' and $status='0'";
		$dup_alert = "Duplicate URL Exists. One School can have one URL. Give Dummy Unique URL if required";
		addData($conn, 'school', 'school_id', $fields, $values, $status, $dup, $dup_alert);
	} elseif ($_POST['action'] == 'fetchSchool') {
		$id = $_POST['schoolId'];
		$sql = "SELECT * FROM school where school_id='$id'";
		$result = $conn->query($sql);
		$output = $result->fetch_assoc();
		echo json_encode($output);
	} elseif ($_POST['action'] == 'updateSchool') {
		$fields = ['school_id', 'school_name', 'school_abbri', 'school_url', 'school_doi'];
		$values = [$_POST['modalId'], data_check($_POST['school_name']), data_check($_POST['school_abbri']),  data_check($_POST['school_url']), data_check($_POST['school_doi'])];
		$dup = "select * from school where school_id='" . $_POST["modalId"] . "'";
		$dup_alert = "Could Not Update - Duplicate Entries";
		updateData($conn, 'school', $fields, $values, $dup, $dup_alert);
	} elseif ($_POST['action'] == 'addDept') {
		//echo "MyId- $myId";
		$fields = ['dept_name', 'dept_abbri', 'dept_type', 'school_id', 'dept_doi', 'submit_id'];
		$values = [data_check($_POST['dept_name']), data_check($_POST['dept_abbri']), $_POST['deptTypeModal'], $_POST['schoolIdModal'], $_POST['dept_doi'], $myId];
		$status = 'dept_status';
		$dup = "select * from department where dept_name='" . data_check($_POST["dept_name"]) . "' and $status='0'";
		$dup_alert = "Duplicate URL Exists. One Dept can have one URL. Give Dummy Unique URL if required";
		addData($conn, 'department', 'dept_id', $fields, $values, $status, $dup, $dup_alert);
	} elseif ($_POST['action'] == 'fetchDept') {
		$id = $_POST['deptId'];
		$sql = "SELECT * FROM department where dept_id='$id'";
		$result = $conn->query($sql);
		$output = $result->fetch_assoc();
		echo json_encode($output);
	} elseif ($_POST['action'] == 'updateDept') {
		$fields = ['dept_id', 'dept_name', 'dept_abbri', 'dept_doi'];
		$values = [$_POST['modalId'], data_check($_POST['dept_name']), data_check($_POST['dept_abbri']), data_check($_POST['dept_doi'])];
		$dup = "select * from department where dept_id='" . $_POST["modalId"] . "'";
		$dup_alert = "Could Not Update - Duplicate Entries";
		updateData($conn, 'department', $fields, $values, $dup, $dup_alert);
	} elseif ($_POST['action'] == 'addProgram') {
		//echo "MyId- $myId";
		$fields = ['dept_id', 'program_name', 'program_abbri', 'program_duration', 'program_seat', 'program_start',  'program_code', 'program_semester', 'sp_name', 'sp_abbri', 'sp_code'];
		$values = [$_POST['deptIdModal'], data_check($_POST['program_name']), data_check($_POST['program_abbri']), $_POST['program_duration'], $_POST['program_seat'], $_POST['program_start'], $_POST['program_code'], $_POST['program_semester'], data_check($_POST['sp_name']), data_check($_POST['sp_abbri']), data_check($_POST['sp_code'])];
		$status = 'program_status';
		$dup = "select * from program where sp_name='" . data_check($_POST["sp_name"]) . "' and $status='0'";
		$dup_alert = "Duplicate URL Exists. One Dept can have one URL. Give Dummy Unique URL if required";
		addData($conn, 'program', 'program_id', $fields, $values, $status, $dup, $dup_alert);
	} elseif ($_POST['action'] == 'fetchProgram') {
		$id = $_POST['programId'];
		$sql = "SELECT * FROM program where program_id='$id'";
		$result = $conn->query($sql);
		$output = $result->fetch_assoc();
		echo json_encode($output);
	} elseif ($_POST['action'] == 'updateProgram') {
		$fields = ['program_id', 'program_name', 'program_abbri', 'program_duration', 'program_seat', 'program_start',  'program_code', 'program_semester', 'sp_name', 'sp_abbri', 'sp_code'];
		$values = [$_POST['modalId'], data_check($_POST['program_name']), data_check($_POST['program_abbri']), data_check($_POST['program_duration']), data_check($_POST['program_seat']), data_check($_POST['program_start']), data_check($_POST['program_code']), data_check($_POST['program_semester']), data_check($_POST['sp_name']), data_check($_POST['sp_abbri']), data_check($_POST['sp_code'])];
		$dup = "select * from program where program_id='" . $_POST["modalId"] . "'";
		$dup_alert = "Could Not Update - Duplicate Entries";
		updateData($conn, 'program', $fields, $values, $dup, $dup_alert);
	} elseif ($_POST["action"] == "instList") {
		//echo "MyId- $myId";
		$sql = "SELECT * from institution where inst_status='0' order by inst_name";
		$json = getTableRow($conn, $sql, array("inst_id", "inst_name", "inst_abbri", "inst_url"));
		// echo $json;
		$array = json_decode($json, true);
		$count = count($array["data"]);
		//  echo $count;
		for ($i = 0; $i < count($array["data"]); $i++) {
			$inst_id = $array["data"][$i]["inst_id"];
			$inst_name = $array["data"][$i]["inst_name"];
			$inst_abbri = $array["data"][$i]["inst_abbri"];
			$inst_url = $array["data"][$i]["inst_url"];

			echo '<div class="card">
      <div class="card-body mb-0">
      <h5 class="card-title" >' . $inst_name . '[' . $inst_id . ']</h5>
      <h6 class="card-subtitle mb-2 text-muted">' . $inst_url . ' [' . $inst_abbri . ']</h6>
      <a href="#" class="btn btn-info btn-sm basicInfoUni" data-inst="' . $inst_id . '">Basic Info</a>
      </div></div>';
		}
	} elseif ($_POST["action"] == "schoolList") {
		//echo "MyId- $myId";
		$sql = "SELECT * from school where school_status='0' order by school_name";
		$json = getTableRow($conn, $sql, array("school_id", "school_name", "school_abbri", "school_url"));
		// echo $json;
		$array = json_decode($json, true);
		$count = count($array["data"]);
		//  echo $count;
		for ($i = 0; $i < count($array["data"]); $i++) {
			$school_id = $array["data"][$i]["school_id"];
			$school_name = $array["data"][$i]["school_name"];
			$school_abbri = $array["data"][$i]["school_abbri"];
			$school_url = $array["data"][$i]["school_url"];

			echo '<div class="card">
      <div class="card-body mb-0">
      <h5 class="card-title" >' . $school_name . '[' . $school_id . ']</h5>
      <h6 class="card-subtitle mb-2 text-muted">' . $school_url . ' [' . $school_abbri . ']</h6>
      <a href="#" class="btn btn-info btn-sm basicInfoCollege" data-school="' . $school_id . '">Basic Info</a>
      </div></div>';
		}
	} elseif ($_POST["action"] == "deptList") {

		$sql = "SELECT * from department where dept_status='0' order by dept_name";
		$json = getTableRow($conn, $sql, array("dept_id", "dept_name", "dept_abbri", "dept_doi"));
		$array = json_decode($json, true);
		$count = count($array["data"]);

		for ($i = 0; $i < count($array["data"]); $i++) {
			$dept_id = $array["data"][$i]["dept_id"];
			$dept_name = $array["data"][$i]["dept_name"];
			$dept_abbri = $array["data"][$i]["dept_abbri"];
			$dept_doi = $array["data"][$i]["dept_doi"];

			echo '<div class="card">
   		<div class="card-body mb-0">
				<div class="row">
					<div class="col-9">
   					<h7>' . $dept_name . '</h7>['.$dept_abbri.']<br>
	 					<h8 class="card-subtitle mb-2 text-muted">Head : -- </h8>
	 				</div>
					<div class="col-3 text-center">
						<a href="#" class="fa fa-edit editDept" data-dept="' . $dept_id . '"></a>
						<h6 class="cardBodyText">' . date("d-m-Y",strtotime($dept_doi)) . '</h6>
					</div>
				</div>
   		</div>
			</div>';
		}
	} elseif ($_POST["action"] == "programList") {
		//    echo "MyId- $myId";
		$sql = "SELECT * from program where program_status='0'";
		$json = getTableRow($conn, $sql, array("program_id", "program_name", "program_abbri", "program_semester", "program_duration", "program_code", "sp_name", "sp_abbri", "program_seat", "program_start"));
		$array = json_decode($json, true);
		//echo count($array);
		//echo count($array["data"]);
		for ($i = 0; $i < count($array["data"]); $i++) {
			$program_id = $array["data"][$i]["program_id"];
			$program_name = $array["data"][$i]["program_name"];
			$program_abbri = $array["data"][$i]["program_abbri"];
			$program_semester = $array["data"][$i]["program_semester"];
			$program_duration = $array["data"][$i]["program_duration"];
			$program_start = $array["data"][$i]["program_start"];
			$Cr = '';
			$status = '';

			echo '<div class="row border border-primary mb-2 ml-2 cardBodyText">';
			echo '<div class="col-sm-2 mb-0 bg-two">';
			echo 'ID : ' . $program_id . '';
			echo '<a href="#" class="float-right program_idE" data-id="' . $program_id . '"><i class="fa fa-edit"></i></a>';
			echo '<div><b>' . $array["data"][$i]["program_abbri"] . '</b>
          <span class="float-right footerNote"></span></div>';
			echo '</div>';

			echo '<div class="col-sm-6">';
			echo '<div class="cardBodyText"><b>' . $program_name . '</b></div>';
			echo '<div class="cardBodyText">Semester : ' . $program_semester;
			echo ' <b>Duration : ' . $program_duration . '</b>';
			echo ' <b>Seats : ' . $array["data"][$i]["program_seat"] . '</b>';
			echo '</div>';
			echo '</div>';

			echo '<div class="col-sm-2">';
			echo '<div class="cardBodyText">In-Charge</div>';
			echo '<div class="cardBodyText">--</div>';
			echo '</div>';


			echo '<div class="col-sm-2 text-center">';
			if ($status == "9") echo '<a href="#" class="program_idR" data-id="' . $program_id . '">Removed</a>';
			else echo '<a href="#" class="program_idD" data-id="' . $program_id . '"><i class="fa fa-trash"></i></a>';
			echo ' <h6 class="cardBodyText">' . $array["data"][$i]["program_start"] . '</h6>';

			echo '</div>';
			echo '</div>';
		}
	} elseif ($_POST["action"] == "attachSchoolDept") {
		$deptId = $_POST['deptId'];
		$schoolId = $_POST['schoolId'];
		echo "$deptId,$schoolId";
		if (!$_POST['deptId'] == NULL && !$_POST['schoolId'] == NULL) {
			$sql = "insert into school_dept (school_id, dept_id) values('$schoolId', '$deptId')";
			$result = $conn->query($sql);
			if ($result) echo "Added Successfully";
			else {
				$error = $conn->errno;
			}
		} else echo "No Field should be Blank";
	} elseif ($_POST["action"] == "deptSchoolList") {
		$sql = "SELECT * from school_dept";
		$json = getTableRow($conn, $sql, array("school_id", "dept_id"));
		$array = json_decode($json, true);
		//echo count($array);
		//echo count($array["data"]);
		echo '<table class="list-table-xs">
   	<thead align="center">
   	<table class="list-table-xs">
   	<thead align="center"><th>School</th><th>Department</th>
   	<th><i class="fa fa-trash"></i></th>
   	</thead>';
		for ($i = 0; $i < count($array["data"]); $i++) {
			$school_id = $array["data"][$i]["school_id"];
			$dept_id = $array["data"][$i]["dept_id"];
			$sql_school = "select * from school where school_id='$school_id'";
			$value_school = getFieldValue($conn, "school_name", $sql_school);
			$sql_dept = "select * from department where dept_id='$dept_id'";
			$value_dept = getFieldValue($conn, "dept_name", $sql_dept);

			echo '<tr><td>' . $value_school . '</td><td>' . $value_dept . '</td><td class="text-center"><i class="fa fa-trash deleteSchoolDept"></i></td></tr>';
		}
		echo '</table></table>';
	} elseif ($_POST["action"] == "deptProgramList") {
		$sql = "SELECT * from dept_program";
		$json = getTableRow($conn, $sql, array("dept_id", "program_id"));
		$array = json_decode($json, true);
		//echo count($array);
		//echo count($array["data"]);
		echo '<table class="list-table-xs">
   <thead align="center">
   <table class="list-table-xs">
   <thead align="center"><th>Department</th><th>Program</th>
   <th><i class="fa fa-trash"></i></th>
   </thead>';
		for ($i = 0; $i < count($array["data"]); $i++) {
			$program_id = $array["data"][$i]["program_id"];
			$dept_id = $array["data"][$i]["dept_id"];
			$sql_program = "select * from program where program_id='$program_id'";
			$value_school = getFieldValue($conn, "sp_name", $sql_program);
			$sql_dept = "select * from department where dept_id='$dept_id'";
			$value_dept = getFieldValue($conn, "dept_name", $sql_dept);

			echo '<tr><td>' . $value_dept . '</td><td>' . $value_school . '</td><td class="text-center"><i class="fa fa-trash deleteSchoolDept"></i></td></tr>';
		}
		echo '</table></table>';
	}
}
