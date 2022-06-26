<?php
require('../requireSubModule.php');
//echo $tn_po;
//echo $_POST['action'];
if (isset($_POST['actionDeptProgram'])) {
	$deptId = $_POST['deptIdHidden2'];
	$programId = $_POST['programIdHidden'];
	// echo "$deptId";
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
	if ($_POST['action'] == 'addProgram') {
		//echo "MyId- $myId";
		$fields = ['program_name', 'program_abbri', 'program_duration', 'program_seat', 'program_start',  'program_semester', 'sp_name', 'sp_abbri', 'sp_code', 'update_id', 'program_status'];
		$values = [data_check($_POST['program_name']), data_check($_POST['program_abbri']), $_POST['program_duration'], $_POST['program_seat'], $_POST['program_start'], $_POST['program_semester'], data_check($_POST['sp_name']), data_check($_POST['sp_abbri']), data_check($_POST['sp_code']), $myId, '0'];
		$status = 'program_status';
		$dup = "select * from program where program_name='" . data_check($_POST["program_name"]) . "' and sp_name='" . data_check($_POST["sp_name"]) . "' and $status='0'";
		$dup_alert = "Program Name with same Specialization Name Exists.";
		addData($conn, 'program', 'program_id', $fields, $values, $status, $dup, $dup_alert);
	} elseif ($_POST['action'] == 'fetchProgram') {
		$id = $_POST['programId'];
		$sql = "SELECT * FROM program where program_id='$id'";
		$result = $conn->query($sql);
		$output = $result->fetch_assoc();
		echo json_encode($output);
	} elseif ($_POST['action'] == 'updateProgram') {

		$sql = "update program set program_name='" . data_check($_POST['program_name']) . "', program_abbri='" . data_check($_POST['program_abbri']) . "', program_duration='" . data_check($_POST['program_duration']) . "', program_seat='" . data_check($_POST['program_seat']) . "', program_start='" . data_check($_POST['program_start']) . "', program_semester='" . data_check($_POST['program_semester']) . "', sp_name='" . data_check($_POST['sp_name']) . "', sp_abbri='" . data_check($_POST['sp_abbri']) . "', sp_code='" . data_check($_POST['sp_code']) . "'  where program_id='" . $_POST['modalId'] . "'";

		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
	} elseif ($_POST['action'] == 'removeProgram') {
		$progId = $_POST['progId'];
		$sql = "update program set program_status='9' where program_id='$progId'";
		$conn->query($sql);
		echo $conn->error;
	} elseif ($_POST['action'] == 'resetProgram') {
		$progId = $_POST['progId'];
		$sql = "update program set program_status='0' where program_id='$progId'";
		$conn->query($sql);
		echo $conn->error;
	} elseif ($_POST["action"] == "programList") {
		//    echo "MyId- $myId";
		$sql = "SELECT * from program order by program_status, program_start, program_name";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			$json_array = array("success" => "1");
			while ($rowArray = $result->fetch_assoc()) {
				$json_array[] = $rowArray;
			}
			echo json_encode($json_array);
		} else {
			$json_array = array("success" => "0");
			echo json_encode($json_array);
		}
	} elseif ($_POST["action"] == "mnList") {
		//    echo "MyId- $myId";
		$sql = "SELECT * from master_name where mn_code='doc' and mn_status='0' order by mn_sno";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			$json_array = array("success" => "1");
			$subArray = array();
			while ($rowArray = $result->fetch_assoc()) {
				$subArray["mn_id"] = $rowArray["mn_id"];
				$subArray["mn_name"] = $rowArray["mn_name"];
				$sql_rowCount = "select * from student_document where program_id='" . $_POST["program_id"] . "' and mn_id='" . $rowArray["mn_id"] . "' and batch_id='" . $_POST["batch_id"] . "' ";
				$subArray["status"] = getRowCount($conn, $sql_rowCount);
				$json_array[] = $subArray;
			}
			echo json_encode($json_array);
		} else {
			$json_array = array("success" => "0");
			echo json_encode($json_array);
		}
	} elseif ($_POST["action"] == "updateDocument") {
		$status = $_POST['status'];
		// echo $program_id = $_POST['program_id'];
		if ($status == "add") {
			$sql = "insert into student_document (mn_id, program_id, batch_id, sd_mandatory, sd_remarks) values('" . $_POST["mn_id"] . "', '" . $_POST["program_id"] . "', '" . $_POST["batch_id"] . "', '1', 'No Remarks')";
			if (!$conn->query($sql)) echo $conn->error;
		} else {
			$sql = "delete from student_document where program_id='" . $_POST["program_id"] . "' and batch_id='" . $_POST["batch_id"] . "' and mn_id='" . $_POST["mn_id"] . "'";
			if (!$conn->query($sql)) echo $conn->error;
		}
	} elseif ($_POST['action'] == 'addSchool') {
		$school_id = $_POST['modalId'];
		$school_name = data_clean($_POST['school_name']);
		$school_abbri = data_clean($_POST['school_abbri']);
		$school_code = data_clean($_POST['school_code']);
		echo "MyId- $myId School $school_id";
		$sql_dup = "select * from school where school_name='" . data_clean($_POST["school_name"]) . "'";
		$result_dup = $conn->query($sql_dup);
		if ($school_id > 0) {
			$sql = "update school set school_name='$school_name', school_abbri='$school_abbri', school_code='$school_code' where school_id='$school_id'";
			$result = $conn->query($sql);
		} else {
			$sql = "insert into school (school_name, school_abbri, school_code, school_status) values('$school_name', '$school_abbri', '$school_code', '0')";
			$result = $conn->query($sql);
		}
	} elseif ($_POST['action'] == 'fetchSchool') {
		$id = $_POST['schoolId'];
		$sql = "SELECT * FROM school where school_id='$id'";
		$result = $conn->query($sql);
		$output = $result->fetch_assoc();
		echo json_encode($output);
	} elseif ($_POST['action'] == 'removeSchool') {
		$sclId = $_POST['sclId'];
		$sql = "update school set school_status='9' where school_id='$sclId'";
		$conn->query($sql);
		echo $conn->error;
	} elseif ($_POST['action'] == 'resetSchool') {
		$sclId = $_POST['sclId'];
		$sql = "update school set school_status='0' where school_id='$sclId'";
		$conn->query($sql);
		echo $conn->error;
	} elseif ($_POST["action"] == "schoolList") {
		//    echo "MyId- $myId";
		$sql = "SELECT * from school order by school_code";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			$json_array = array("success" => "1");
			while ($rowArray = $result->fetch_assoc()) {
				$json_array[] = $rowArray;
			}
			echo json_encode($json_array);
		} else {
			$json_array = array("success" => "0");
			echo json_encode($json_array);
		}
	} elseif ($_POST['action'] == 'addDept') {
		$dept_id = $_POST['modalId'];
		$dept_name = data_clean($_POST['dept_name']);
		$dept_abbri = data_clean($_POST['dept_abbri']);
		$dept_type = data_clean($_POST['dept_type']);
		echo "MyId- $myId Dept $dept_id Type";
		$sql_dup = "select * from department where dept_name='$dept_name'";
		$result_dup = $conn->query($sql_dup);
		if ($dept_id > 0) {
			$sql = "update department set dept_name='$dept_name', dept_abbri='$dept_abbri', dept_type='$dept_type' where dept_id='$dept_id'";
			$result = $conn->query($sql);
		} else {
			$sql = "insert into department (dept_name, dept_abbri, dept_type, dept_status) values('$dept_name', '$dept_abbri', $dept_type, '0')";
			$result = $conn->query($sql);
		}
	} elseif ($_POST['action'] == 'fetchDept') {
		$id = $_POST['deptId'];
		$sql = "SELECT * FROM department where dept_id='$id'";
		$result = $conn->query($sql);
		$output = $result->fetch_assoc();
		echo json_encode($output);
	} elseif ($_POST['action'] == 'removeDept') {
		$deptId = $_POST['deptId'];
		$sql = "update department set dept_status='9' where dept_id='$deptId'";
		$conn->query($sql);
		echo $conn->error;
	} elseif ($_POST['action'] == 'resetDept') {
		$deptId = $_POST['deptId'];
		$sql = "update department set dept_status='0' where dept_id='$deptId'";
		$conn->query($sql);
		echo $conn->error;
	} elseif ($_POST["action"] == "deptList") {
		//    echo "MyId- $myId";
		$sql = "SELECT * from department order by dept_type, dept_name";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			$json_array = array("success" => "1");
			while ($rowArray = $result->fetch_assoc()) {
				$json_array[] = $rowArray;
			}
			echo json_encode($json_array);
		} else {
			$json_array = array("success" => "0");
			echo json_encode($json_array);
		}
	} elseif ($_POST['action'] == 'fetchInst') {
		$sql = "SELECT * FROM institution where inst_status='0'";
		$result = $conn->query($sql);
		$output = $result->fetch_assoc();
		echo json_encode($output);
	} elseif ($_POST['action'] == 'updateInst') {
		$sql = "update institution set inst_logo='" . data_check($_POST['inst_logo']) . "', inst_name='" . data_check($_POST['inst_name']) . "', inst_abbri='" . data_check($_POST['inst_abbri']) . "', inst_url='" . data_check($_POST['inst_url']) . "', inst_address='" . data_check($_POST['inst_address']) . "', inst_city='" . data_check($_POST['inst_city']) . "', inst_state='" . data_check($_POST['inst_state']) . "', inst_pincode='" . data_check($_POST['inst_pincode']) . "', inst_approval='" . data_check($_POST['inst_approval']) . "', inst_affiliation='" . data_check($_POST['inst_affiliation']) . "', inst_timelag='" . data_check($_POST['inst_timelag']) . "' where inst_id='" . $_POST["modalId"] . "'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
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

			echo '<tr><td>' . $value_school . '</td><td>' . $value_dept . '</td><td class="text-center"><a href="#" class="fa fa-trash deleteSchoolDept" data-dept="' . $dept_id . '" data-school="' . $school_id . '"></a></td></tr>';
		}
		echo '</table>';
	} elseif ($_POST["action"] == "deptProgramList") {
		$sql = "SELECT dp.* from dept_program dp, program p where p.program_id=dp.program_id and p.program_status='0' order by dept_id";
		$json = getTableRow($conn, $sql, array("dept_id", "program_id"));
		$array = json_decode($json, true);
		//echo count($array);
		//echo count($array["data"]);
		echo '<table class="list-table-xs">
    	<thead align="center"><th>Department</th><th>Program</th><th>Specialization</th>
    	<th><i class="fa fa-trash"></i></th>
        </thead>';
		for ($i = 0; $i < count($array["data"]); $i++) {
			$program_id = $array["data"][$i]["program_id"];
			$dept_id = $array["data"][$i]["dept_id"];
			$sql_program = "select * from program where program_id='$program_id'";
			$pa = getFieldValue($conn, "program_abbri", $sql_program);
			$sp = getFieldValue($conn, "sp_name", $sql_program);
			$sql_dept = "select * from department where dept_id='$dept_id'";
			$value_dept = getFieldValue($conn, "dept_name", $sql_dept);

			echo '<tr><td>' . $value_dept . '</td><td>' . $pa . '</td><td>' . $sp . '</td>
   <td class="text-center">
   <a href="#" class="fa fa-trash deleteDeptProgram" data-dept="' . $dept_id . '" data-program="' . $program_id . '"></a>
   </td>
   </tr>';
		}
		echo '</table>';
	} elseif ($_POST['action'] == 'removeSchoolDept') {
		$schoolId = $_POST['schoolId'];
		$deptId = $_POST['deptId'];
		echo "$deptId,$schoolId";
		$sql = "delete from school_dept where school_id='$schoolId' and dept_id='$deptId'";
		$conn->query($sql);
		echo $conn->error;
	} elseif ($_POST['action'] == 'removeDeptProgram') {
		$progId = $_POST['progId'];
		$deptId = $_POST['deptId'];
		$sql = "delete from dept_program where program_id='$progId' and dept_id='$deptId'";
		$conn->query($sql);
		echo $conn->error;
	} elseif ($_POST['action'] == 'updateCom') {
		if ($_POST['com_id'] == 0) $sql = "insert into committee (com_name, com_scope, com_term, update_ts, update_id, com_status) values('" . data_check($_POST['com_name']) . "','" . data_check($_POST['com_scope']) . "','" . data_check($_POST['com_term']) . "', '$submit_ts','$myId','0')";
		else $sql = "update committee set com_name='" . data_check($_POST['com_name']) . "', com_scope='" . data_check($_POST['com_scope']) . "', com_term='" . data_check($_POST['com_term']) . "', update_ts='$submit_ts' where com_id='" . $_POST['com_id'] . "'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		echo "Updated";
	} elseif ($_POST['action'] == 'comList') {
		$sql = "select c.* from committee c where c.com_status='0'";
		$result = $conn->query($sql);
		$json_array = array();
		while ($output = $result->fetch_assoc()) {
			$json_array[] = $output;
		}
		echo json_encode($json_array);
	} elseif ($_POST['action'] == 'comFetch') {
		$sql = "select c.* from committee c where c.com_id='" . $_POST['com_id'] . "'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			$rowArray = $result->fetch_assoc();
			echo json_encode($rowArray);
		}
	} elseif ($_POST['action'] == 'csUpdate') {
		if ($_POST['cs_id'] == 0) $sql = "insert into committee_structure (com_id, cs_name, cs_scope, cs_number, cs_remarks, update_ts, update_id, cs_status) values('" . data_check($_POST['com_id']) . "','" . data_check($_POST['cs_name']) . "', '" . data_check($_POST['cs_scope']) . "', '" . data_check($_POST['cs_number']) . "', '" . data_check($_POST['cs_remarks']) . "', '$submit_ts', '$myId', '0')";
		else $sql = "update committee_structure set cs_name='" . data_check($_POST['cs_name']) . "', cs_scope='" . data_check($_POST['cs_scope']) . "', cs_number='" . data_check($_POST['cs_number']) . "', cs_remarks='" . data_check($_POST['cs_remarks']) . "', update_ts='$submit_ts' where cs_id='" . $_POST['cs_id'] . "'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		echo "Updated";
	} elseif ($_POST['action'] == 'csList') {
		// echo $_POST["com_id"];
		$sql = "select * from committee_structure where com_id='" . $_POST["com_id"] . "' and cs_status='0'";
		$result = $conn->query($sql);
		$json_array = array();
		while ($output = $result->fetch_assoc()) {
			$json_array[] = $output;
		}
		echo json_encode($json_array);
	} elseif ($_POST['action'] == 'csFetch') {
		$sql = "select cs.* from committee_structure cs where cs.cs_id='" . $_POST['cs_id'] . "'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			$rowArray = $result->fetch_assoc();
			echo json_encode($rowArray);
		}
	} elseif ($_POST['action'] == 'ahUpdate') {
		if ($_POST['ah_id'] == 0) $sql = "insert into activity_head (ah_name, mn_id, ah_module, ah_start_week, ah_end_week, update_ts, update_id, ah_status) values('" . data_check($_POST['ah_name']) . "','" . data_check($_POST['sel_resp']) . "','" . data_check($_POST['ah_module']) . "', '" . data_check($_POST['ah_start_week']) . "', '" . data_check($_POST['ah_end_week']) . "', '$submit_ts','$myId','0')";
		else $sql = "update activity_head set ah_name='" . data_check($_POST['ah_name']) . "', mn_id='" . data_check($_POST['sel_resp']) . "', ah_module='" . data_check($_POST['ah_module']) . "', ah_start_week='" . data_check($_POST['ah_start_week']) . "', ah_end_week='" . data_check($_POST['ah_end_week']) . "', update_ts='$submit_ts' where ah_id='" . $_POST['ah_id'] . "'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		echo "Updated";
	} elseif ($_POST['action'] == 'ahList') {
		$sql = "select ah.*, mn.mn_name from activity_head ah, master_name mn where ah.mn_id=mn.mn_id and ah.ah_status='0' order by ah.ah_module, ah.ah_start_week ";
		$result = $conn->query($sql);
		$json_array = array();
		while ($output = $result->fetch_assoc()) {
			$json_array[] = $output;
		}
		echo json_encode($json_array);
	} elseif ($_POST['action'] == 'ahFetch') {
		$sql = "select ah.*, mn.mn_name from activity_head ah, master_name mn where ah.mn_id=mn.mn_id and ah.ah_id='" . $_POST['ah_id'] . "'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			$rowArray = $result->fetch_assoc();
			echo json_encode($rowArray);
		}
	} elseif ($_POST['action'] == 'ashUpdate') {
		if ($_POST['ash_id'] == 0) $sql = "insert into activity_sub_head (ah_id, ash_name, ash_spoc, ash_start_week, ash_end_week, ash_remarks, update_ts, update_id, ash_status) values('" . data_check($_POST['ah_id']) . "','" . data_check($_POST['ash_name']) . "', '" . data_check($_POST['ash_spoc']) . "', '" . data_check($_POST['ash_start_week']) . "', '" . data_check($_POST['ash_end_week']) . "', '" . data_check($_POST['ash_remarks']) . "', '$submit_ts', '$myId', '0')";
		else $sql = "update activity_sub_head set ash_name='" . data_check($_POST['ash_name']) . "', ash_spoc='" . data_check($_POST['ash_spoc']) . "', ash_start_week='" . data_check($_POST['ash_start_week']) . "', ash_end_week='" . data_check($_POST['ash_end_week']) . "', ash_remarks='" . data_check($_POST['ash_remarks']) . "', update_ts='$submit_ts' where ash_id='" . $_POST['ash_id'] . "'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		echo "Updated";
	} elseif ($_POST['action'] == 'ashList') {
		// echo $_POST["com_id"];
		$sql = "select * from activity_sub_head where ah_id='" . $_POST["ah_id"] . "' and ash_status='0'";
		$result = $conn->query($sql);
		$json_array = array();
		while ($output = $result->fetch_assoc()) {
			$json_array[] = $output;
		}
		echo json_encode($json_array);
	} elseif ($_POST['action'] == 'ashFetch') {
		$sql = "select * from activity_sub_head where ash_id='" . $_POST['ash_id'] . "'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			$rowArray = $result->fetch_assoc();
			echo json_encode($rowArray);
		}
	}
}
