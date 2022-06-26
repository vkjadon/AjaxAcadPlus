<?php
require('../requireSubModule.php');
//echo $tn_po;
//echo $_POST['action'];
if (isset($_POST['action'])) {
	if ($_POST["action"] == "addPo") {
		// echo "Add PO";
		//echo "batchId " . $_POST['batchIdModal'];
		$fields = ['program_id', 'po_statement', 'po_sno', 'update_id', 'po_status'];
		$values = [$myProg, data_check($_POST['poStatement']), data_check($_POST['poSno']), $myId, '0'];
		$status = 'po_status';
		$dup = "select * from $tn_po where po_statement='" . data_check($_POST["poStatement"]) . "' and program_id='" . $myProg . "'  and $status='0'";
		$dup_alert = "Statement Alreday Exists ! Please Check !!";
		addData($conn, $tn_po, 'po_id', $fields, $values, $status, $dup, $dup_alert);
	} elseif ($_POST['action'] == 'fetchPo') {
		$id = $_POST['id'];
		$sql = "select * FROM $tn_po where po_id='$id'";
		$result = $conn->query($sql);
		$output = $result->fetch_assoc();
		echo json_encode($output);
	} elseif ($_POST['action'] == 'updatePo') {
		$fields = ['po_id', 'po_statement', 'po_sno'];
		$values = [$_POST['modalId'], data_check($_POST['poStatement']), data_check($_POST['poSno'])];
		$dup = "select * from $tn_po where po_sno='" . $_POST["poSno"] . "' and po_statement='" . $_POST["poStatement"] . "' and program_id='$myProg'";
		$dup_alert = "Could Not Update - Duplicate Entries";
		updateData($conn, $tn_po, $fields, $values, $dup, $dup_alert);
	} elseif ($_POST["action"] == "poList") {
		$sql = "SELECT * from $tn_po where program_id='$myProg' order by po_sno";
		// echo "$sql";
		$result = $conn->query($sql);
		//echo $result->num_rows;
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			$json_array = array("success" => "1");
			while ($rowArray = $result->fetch_assoc()) {
				//echo $rowArray["po_statement"];
				$json_array[] = $rowArray;
			}
			echo json_encode($json_array);
		} else {
			$json_array = array("success" => "0");
			echo json_encode($json_array);
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
	} elseif ($_POST["action"] == "subjectList") {
		$sql = "SELECT sb.*, s.staff_email from $tn_sub sb, staff s where sb.program_id='$myProg' and batch_id='$myBatch' and sb.update_id=s.staff_id and sb.subject_status='0' order by subject_semester, subject_name";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			$json_array = array("success" => "1");
			$subArray = array();
			while ($rowArray = $result->fetch_assoc()) {
				$subject_id = $rowArray["subject_id"];
				$subArray["subject_id"] = $subject_id;
				$sql_co = "select * from $tn_co where subject_id='$subject_id' and co_status='0'";
				$result_co = $conn->query($sql_co);
				if ($result) $cos = $result_co->num_rows;
				else $cos = 0;

				$subArray["subject_semester"] = $rowArray["subject_semester"];
				$subArray["subject_code"] = $rowArray["subject_code"];
				$subArray["subject_name"] = $rowArray["subject_name"];
				$subArray["subject_internal"] = $rowArray["subject_internal"];
				$subArray["subject_external"] = $rowArray["subject_external"];
				$subArray["subject_credit"] = $rowArray["subject_credit"];
				$subArray["subject_sno"] = $rowArray["subject_sno"];
				$subArray["subject_status"] = $rowArray["subject_status"];
				$subArray["subject_coordinator"] = $rowArray["subject_coordinator"];
				$str = explode("@", $rowArray["staff_email"]);
				$subArray["email_1"] = $str[0];
				$subArray["email_2"] = $str[1];
				$subArray["cos"] = $cos;
				$subArray["update_id"] = $rowArray["update_id"];
				$json_array[] = $subArray;
			}
			echo json_encode($json_array);
		} else {
			$json_array = array("success" => "0");
			echo json_encode($json_array);
		}
	} elseif ($_POST["action"] == "updateCoc") {
		$id = $_POST['id'];
		$sql = "update $tn_sub set subject_coordinator='" . $_POST['coc'] . "' where subject_id='$id'";
		if ($conn->query($sql)) echo "Course Coordinator Updated !!";
		else echo "Could not Update !!";
		// echo $tn;
	} elseif ($_POST['action'] == 'sendMailCO') {
		$id = $_POST['id'];
		$coc = $_POST['coc'];
		$sql = "select staff_name, staff_id from staff where staff_email='$coc'";
		$result = $conn->query($sql);
		if ($result && $result->num_rows > 0) {
			$rows = $result->fetch_assoc();
			$staff_id = $rows['staff_id'];
			$staff_name = $rows['staff_name'];
			//echo $staff_email . $staff_id . ':' . $password;

			$subject = "Regarding Course Outcome Updation";
			$message = '<html><head><title>HTML email</title></head>
				<body>
				<p>Dear Mr./Ms. '.$staff_name.'</p>
				<h5>You have been assigned </h5>
				<p>Please click the link to proceed to update the Course Outcome <a href ="https://www.classconnect.in/access/obe/co.php?subject='.$id.'&&inst='.$myDb.'">Add Course Outcome </a></p>
				<h4>Regards</h4>
				</body>
				</html>';

			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			// More headers
			$headers .= 'From: <info@classconnect.in>';
			mail($coc, $subject, $message, $headers);
			// echo "The password is sent to registered email [" . $staff_email . $password . "].";
			echo $message;
			// $sql = "insert into staff_email (staff_id, sm_subject) values('$staff_id', '$subject')";
			// $conn->query($sql);

		}
	} elseif ($_POST["action"] == "addStudent") {
		$student_rollno = data_check($_POST['studentRollno']);
		$student_rollno = preg_replace("/[^a-zA-Z0-9]+/", "", $student_rollno);
		$student_name = data_check($_POST['studentName']);
		$student_name = preg_replace("/[^a-zA-Z0-9 ]+/", "", $student_name);
		$student_sno = data_check($_POST['studentSno']);

		$student_email = data_check($_POST['studentEmail']);
		$student_email = preg_replace("/[^a-zA-Z0-9@#$.*+_]+/", "", $student_email);

		$student_id = $_POST['modalId'];
		//echo " $student_name - $student_id ";
		if ($student_id == 0) {
			$sql = "insert into $tn_std (batch_id, program_id, student_rollno, student_name, student_email, student_sno, update_id, student_status) values('$myBatch', '$myProg', '$student_rollno','$student_name', '$student_email', '$student_sno', '$myId', '0')";
			//echo "Inserted - $student_name";
		} else {
			$sql = "update $tn_std set batch_id='$myBatch', program_id='$myProg', student_name='$student_name', student_email='$student_email', student_sno='$student_sno', student_rollno='$student_rollno' where student_id='$student_id'";
			//echo "updated - $student_name";
		}
		$conn->query($sql);
	} elseif ($_POST["action"] == "studentList") {
		$sql = "SELECT * from $tn_std where program_id='$myProg' and batch_id='$myBatch' and student_status='0' order by student_sno, student_rollno";
		// echo "$sql";
		$result = $conn->query($sql);
		//echo $result->num_rows;
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			$json_array = array();
			while ($rowArray = $result->fetch_assoc()) {
				$subarray = array();
				$subarray["update_id"] = $rowArray['update_id'];
				$subarray["student_id"] = $rowArray['student_id'];
				$subarray["student_sno"] = $rowArray['student_sno'];
				$subarray["student_rollno"] = $rowArray['student_rollno'];
				$subarray["student_name"] = $rowArray['student_name'];
				$subarray["student_email"] = $rowArray['student_email'];
				$subarray["student_status"] = $rowArray['student_status'];
				$json_array[] = $subarray;
			}
			echo json_encode($json_array);
		}
	} elseif ($_POST['action'] == 'fetchStudent') {
		$id = $_POST['id'];
		$sql = "select * FROM $tn_std where student_id='$id'";
		$result = $conn->query($sql);
		$output = $result->fetch_assoc();
		echo json_encode($output);
	} elseif ($_POST["action"] == "deleteStudent") {
		$id = $_POST['id'];
		$sql = "update $tn_std set student_status='9' where student_id='$id'";
		$result = $conn->query($sql);
		// echo $tn;
	} elseif ($_POST["action"] == "addEmployer") {
		$emp_industry = data_check($_POST['empIndustry']);
		$emp_name = data_check($_POST['empName']);
		$emp_email = data_check($_POST['empEmail']);
		$emp_id = $_POST['modalId'];
		//echo " $student_name - $student_id ";
		if ($emp_id == 0) {
			$sql = "insert into employer (emp_industry, emp_name, emp_email, update_id, emp_status) values('$emp_industry','$emp_name', '$emp_email', '$myId', '0')";
			//echo "Inserted - $student_name";
		} else {
			$sql = "update employer set emp_name='$emp_name', emp_industry='$emp_industry', emp_email='$emp_email' where emp_id='$emp_id'";
			//echo "updated - $student_name";
		}
		$conn->query($sql);
	} elseif ($_POST["action"] == "empList") {
		$sql = "SELECT * from employer where emp_status='0' order by emp_name";
		// echo "$sql";
		$result = $conn->query($sql);
		//echo $result->num_rows;
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			$json_array = array();
			while ($rowArray = $result->fetch_assoc()) {
				$subarray = array();
				$subarray["update_id"] = $rowArray['update_id'];
				$subarray["emp_id"] = $rowArray['emp_id'];
				$subarray["emp_industry"] = $rowArray['emp_industry'];
				$subarray["emp_name"] = $rowArray['emp_name'];
				$subarray["emp_email"] = $rowArray['emp_email'];
				$subarray["emp_status"] = $rowArray['emp_status'];
				$json_array[] = $subarray;
			}
			echo json_encode($json_array);
		}
	} elseif ($_POST["action"] == "addAlumni") {
		$alm_organization = data_check($_POST['almIndustry']);
		$alm_name = data_check($_POST['almName']);
		$alm_email = data_check($_POST['almEmail']);
		$alm_rollno = data_check($_POST['almRollno']);
		$alm_designation = data_check($_POST['almDesignation']);
		$alm_id = $_POST['modalId'];
		//echo " $student_name - $student_id ";
		if ($alm_id == 0) {
			$sql = "insert into alumni (program_id, alm_organization, alm_name, alm_email, alm_rollno, alm_designation, update_id, alm_status) values('$myProg', '$alm_organization','$alm_name', '$alm_email', '$alm_rollno', '$alm_designation', '$myId', '0')";
			//echo "Inserted - $student_name";
		} else {
			$sql = "update alumni set alm_organization='$alm_organization', alm_name='$alm_name', alm_email='$alm_email',, alm_rollno='$alm_rollno',, alm_designation='$alm_designation' where alm_id='$alm_id'";
			//echo "updated - $student_name";
		}
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
	} elseif ($_POST["action"] == "almList") {
		$sql = "SELECT * from alumni where program_id='$myProg' and alm_status='0' order by alm_rollno, alm_name";
		// echo "$sql";
		$result = $conn->query($sql);
		//echo $result->num_rows;
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			$json_array = array();
			while ($rowArray = $result->fetch_assoc()) {
				$subarray = array();
				$subarray["update_id"] = $rowArray['update_id'];
				$subarray["alm_id"] = $rowArray['alm_id'];
				$subarray["alm_organization"] = $rowArray['alm_organization'];
				$subarray["alm_name"] = $rowArray['alm_name'];
				$subarray["alm_email"] = $rowArray['alm_email'];
				$subarray["alm_rollno"] = $rowArray['alm_rollno'];
				$subarray["alm_designation"] = $rowArray['alm_designation'];
				$subarray["alm_status"] = $rowArray['alm_status'];
				$json_array[] = $subarray;
			}
			echo json_encode($json_array);
		}
	}
}
