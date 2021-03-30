<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
//echo $_POST['action'];
if (isset($_POST["query"])) {
	$output = '';
	$sql = "select * from staff where staff_name LIKE '%" . $_POST["query"] . "%'";
	$result = $conn->query($sql);
	$output = '<ul class="list-group">';
	if ($result) {
		while ($row = $result->fetch_assoc()) {
			$output .= '<li class="list-group-item list-group-item-action autoList" data-std="' . $row["staff_id"] . '" >' . $row["staff_name"] . '</li>';
		}
	} else {
		$output .= '<li>Staff Not Found</li>';
	}
	$output .= '</ul>';
	echo $output;
}
if (isset($_POST['action'])) {
	if ($_POST['action'] == 'staffList') {

		$sql = "SELECT * from staff where staff_status='0' order by staff_name";
		$json = getTableRow($conn, $sql, array("staff_id", "staff_name", "staff_mobile", "staff_email"));
		// echo $json;
		$array = json_decode($json, true);
		$count = count($array["data"]);
		//  echo $count;
		for ($i = 0; $i < count($array["data"]); $i++) {
			$staff_id = $array["data"][$i]["staff_id"];
			$staff_name = $array["data"][$i]["staff_name"];
			$staff_mobile = $array["data"][$i]["staff_mobile"];
			$staff_email = $array["data"][$i]["staff_email"];

			echo '<div class="card">
      <div class="card-body mb-0">
						<div class="row">
						<div class="col-10">
      <h7 class="card-title">' . $staff_name . '</h7><br>
						</div>
						<div class="col-2">
						<a href="#" class="fa fa-edit editStaff" data-inst="' . $staff_id . '"></a>
						</div>
						</div>
      <h8 class="card-subtitle mb-2 text-muted">' . $staff_email . ' </h8>
      </div></div>';
		}
	} elseif ($_POST['action'] == 'addStaff') {

		$dept_id = $_POST['deptIdModal'];
		$fields = ['dept_id', 'staff_name', 'deignation_id', 'staff_mobile', 'staff_mobile'];
		$values = [$_POST['deptIdModal'], data_check($_POST['sName']), data_check($_POST['sel_desig']), $_POST['sMobile'], $_POST['sEmail']];
		$status = 'staff_status';
		$dup = "select * from staff where staff_id='" . data_check($_POST["sRno"]) . "' and $status='0'";
		$dup_alert = "Duplicate URL Exists. One Dept can have one URL. Give Dummy Unique URL if required";
		addData($conn, 'staff', 'staff_id', $fields, $values, $status, $dup, $dup_alert);
	} elseif ($_POST['action'] == 'fetchStaff') {
		$id = $_POST['staffId'];
		$sql = "select * FROM staff where staff_id='$id'";
		$result = $conn->query($sql);
		$output = $result->fetch_assoc();
		echo json_encode($output);
	} elseif ($_POST['action'] == 'updateStaff') {
		$fields = ['staff_id', 'staff_name', 'designation_id', 'staff_mobile', 'staff_email'];
		$values = [$_POST['modalId'], data_check($_POST['sName']), data_check($_POST['sel_desig']), data_check($_POST['sMobile']), data_check($_POST['sEmail'])];
		$dup = "select * from staff where staff_id='" . $_POST["modalId"] . "'";
		$dup_alert = "Could Not Update - Duplicate Entries";
		updateData($conn, 'staff', $fields, $values, $dup, $dup_alert);
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
	} elseif ($_POST['action'] == 'fetchStaffDetails') {
		$id = $_POST['studentId'];
		$sql = "select * from staff_details where staff_id='$id'";
		$result = $conn->query($sql);
		$output = $result->fetch_assoc();
		echo json_encode($output);
	} elseif ($_POST['action'] == 'addStaffQualification') {
		$stf_id = $_POST['stfIdModal'];
		$sql = "insert into staff_qualification (staff_id, qualification_id, stq_institute, stq_board, stq_year, stq_marksObtained, stq_marksMax, stq_percentage) values ('$_POST[stfIdModal]', '$_POST[sel_qual]', '$_POST[sInst]', '$_POST[sBoard]', '$_POST[sYear]', '$_POST[sMarksObt]', '$_POST[sMaxMarks]', '$_POST[sCgpa]')";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		else echo "Success";
	} elseif ($_POST['action'] == 'staffQualificationList') {
		$tableId = 'stq_id';
		$stfId = $_POST['stfId'];
		// echo "$stfId";

		$statusDecode = array("status" => "stq_status", "0" => "Active", "9" => "Inactive");
		$button = array("1", "1", "0", "0", "Upload", "View");

		$fields = array("qualification_name", "stq_institute", "stq_board", "stq_year", "stq_marksObtained", "stq_marksMax", "stq_percentage");
		$dataType = array("0", "0", "0", "0", "0", "0", "0");
		$header = array("Id", "Qualification", "Institute", "Board", "Passing Year", "Marks Obtained", "Maximum Marks", "Percentage/CGPA");

		if ($stfId > 0) $sql = "select stq.*, q.qualification_name from staff_qualification stq, qualification q where q.qualification_id=stq.qualification_id and stq.staff_id='$stfId'";
		// getList($conn, $tableId, $fields, $dataType, $header, $sql, $statusDecode, $button);

		$columnCount = count($header);
		// echo "In Function  $sql Column Count $columnCount";
		echo '<table class="list-table-xs">';
		echo '<thead align="center">';
		echo '<th><i class="fa fa-edit"></i></th><th>Id</th><th>Qualification</th><th>Institute</th><th>Board</th><th>Passing Year</th><th>Marks Obtained</th><th>Maximum Marks</th><th>Percentage/CGPA</th><th><i class="fa fa-trash"></i></th><th>Upload</th><th>View</th>';

		if (isset($statusDecode["align"]) == "center") $align = 'align=' . '"center"';
		else $align = '';
		echo '<table class="list-table-xs">';
		echo '<thead ' . $align . '>';
		if ($button[0] == '1') echo '<th><i class="fa fa-edit"></i></th>';
		for ($j = 0; $j < $columnCount; $j++) echo '<th>' . $header[$j] . '</th>';
		if ($button[1] > 0) echo '<th><i class="fa fa-trash"></i></th>';
		if ($button[2] == '1') echo '<td><i class="fa fa-info-circle"></i></td>';
		if ($button[3] == '1') echo '<td>Process</td>';
		$buttonCount = count($button);
		if ($buttonCount > 4) {
			for ($i = 4; $i < $buttonCount; $i++) {
				echo '<th>' . $button[$i] . '</th>';
			}
		}
		echo '</thead>';
		$fieldCount = count($fields);
		$result = $conn->query($sql);
		if (!$result) {
			echo $conn->error;
			die(" The script could not be Loadded! Please report!");
		}
		while ($rows = $result->fetch_assoc()) {
			$data = "";
			echo '<tr ' . $align . '>';
			if ($tableId <> '') $id = $rows[$tableId];
			if ($button[0] == '1') echo '<td><a href="#" class="' . $tableId . 'E" id="' . $id . '"><i class="fa fa-edit"></i></a></td>';
			if ($tableId <> '') echo '<td>' . $id . '</td>';
			for ($j = 0; $j < $fieldCount; $j++) {
				$fieldName = $fields[$j];
				$fieldValue = $rows[$fieldName];
				$data .= ' data-' . $fieldName . '="' . $fieldValue . '"';
				if ($fieldName == $statusDecode["status"]) echo '<td>' . $statusDecode[$fieldValue] . '</td>';
				else {
					if ($dataType[$j] == "0") echo '<td>' . $fieldValue . '</td>';
					elseif ($dataType[$j] == "1") echo '<td>' . date("d-M-Y", strtotime($fieldValue)) . '</td>';
				}
			}
			if ($button[1] == '1') echo '<td><a href="#" class="' . $tableId . 'D" id="' . $id . '"><i class="fa fa-trash"></i></a></td>';
			elseif ($button[1] == '2') echo '<td><a href="#" class="' . $tableId . 'R" id="' . $id . '"><i class="fa fa-trash"></i></a></td>';
			if ($button[2] == '1') echo '<td><a href="#" class="' . $tableId . 'I" id="' . $id . '"><i class="fa fa-info-circle"></i></a></td>';
			if ($button[3] == '1') echo '<td><a href="#" class="' . $tableId . 'P" id="' . $id . '">Process</a></td>';
			if ($buttonCount > 4) {
				for ($i = 4; $i < $buttonCount; $i++) {
					echo '<td><button class="btn btn-secondary btn-square-sm mt-1 ' . $tableId . $button[$i] . '" id="' . $id . '" ' . $data . '>' . $button[$i] . '</button></td>';
				}
			}
			echo '</tr>';
		}
		echo '</table>';
	} elseif ($_POST['action'] == 'updateStaffQualification') {
		$stq_id = $_POST['modalId'];
		$update = "update staff_qualification set qualification_id='$_POST[sel_qual]', stq_institute='$_POST[sInst]', stq_board='$_POST[sBoard]', stq_year='$_POST[sYear]', stq_marksObtained='$_POST[sMarksObt]', stq_marksMax='$_POST[sMaxMarks]', stq_percentage='$_POST[sCgpa]' where stq_id = '$stq_id'";
		$result = $conn->query($update);
		if (!$result) echo $conn->error;
		else echo "New record updated successfully";
	} elseif ($_POST['action'] == 'fetchStaffQualification') {
		$stq_id = $_POST['stqId'];
		$sql = "select * FROM staff_qualification where stq_id='$stq_id'";
		$result = $conn->query($sql);
		$output = $result->fetch_assoc();
		echo json_encode($output);
	}
}
