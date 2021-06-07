<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
include('../../phpFunction/leaveFunction.php');
include('../../phpFunction/myArrayFunction.php');
//echo $myId;
$myArrayCI = getResponsibilityArray($conn, "class_incharge", $myId, "class_id");

//print_r($myArrayCI);
//echo $_POST['action'];
if (isset($_POST['action'])) {
	if ($_POST['action'] == 'eaClaimList') {
		//echo "Claim Table ".$tn_eac;
		$json = get_extraAttendanceJson($conn, $tn_eac);
		//echo $json;
		$array = json_decode($json, true);
		//echo $array;
		echo '<table class="table list-table-xxs">';
		echo '<tr align="center"><th>Student</th><th>Class</th><th>Date</th><th>Activity</th><th>Claimed</th><th>Approved</th><th>Remarks</th><th>Status</th><th colspan="2">Action</th></tr>';
		for ($i = 0; $i < count($array["data"]); $i++) {
			$student_id = $array["data"][$i]["student_id"];
			$student_name = getField($conn, $student_id, "student", "student_id", "student_name");
			$eac_date = $array["data"][$i]["eac_date"];
			$eae_id = $array["data"][$i]["eae_id"];
			$eae_name = getField($conn, $eae_id, "ea_event", "eae_id", "eae_name");
			$status = $array["data"][$i]["eac_status"];
			if ($status == '3') echo '<tr class="approved">';
			elseif ($status == '4') echo '<tr class="rejected">';
			else echo '<tr>';
			echo '<td>' . $student_name . '[' . $student_id . ']</td>';
			$sql = "select cl.class_name from $tn_rc rc, class cl where rc.class_id=cl.class_id and student_id='$student_id'";
			$class_name = getFieldValue($conn, "class_name", $sql);
			$remarks = $array["data"][$i]["eac_remarks"];
			$claimed = $array["data"][$i]["eac_claim"];
			$date = date("d-m-Y", strtotime($eac_date));
			$text = $student_name . '[' . $class_name . '] <br>Claimed ' . $claimed . ' attendances for ' . $date . '<br>on account of ' . $eae_name . '<br> Remarks : <br>' . $remarks . '<br>';
			echo '<td>' . $class_name . '</td>';
			echo '<td align="center">' . $date . '</td>';
			echo '<td>' . $eae_name . '</td>';
			echo '<td align="center">' . $claimed . '</td>';
			echo '<td align="center">' . $array["data"][$i]["eac_approved"] . '</td>';
			echo '<td>' . $remarks . '</td>';
			echo '<td align="center">' . status_decode($status) . '</td>';
			echo '<td align="center"><button class="btn btn-success btn-square-sm mt-1 approveButton" data-text="' . $text . '" data-std="' . $student_id . '" data-eae="' . $eae_id . '" data-eacDate="' . $eac_date . '">Approve</button>';
			echo '<td align="center"><button class="btn btn-danger btn-square-sm mt-1 rejectButton" data-text="' . $text . '" data-std="' . $student_id . '" data-eae="' . $eae_id . '" data-eacDate="' . $eac_date . '">Reject</button>';
			echo '</tr>';
		}
		echo '</table>';
	} elseif ($_POST['action'] == "updateEAC") {
		$sql = "update ea_claim set eac_approved='" . data_check($_POST['approved']) . "', approver_ts='$today_ts', eac_status='3' where  student_id='" . $_POST['student_id'] . "' and eac_date='" . $_POST['eac_date'] . "'";
		$result = $conn->query($sql);
		if (!$result) $conn->error;
	} elseif ($_POST['action'] == "rejectEAC") {
		$sql = "update ea_claim set eac_approved='0', approver_ts='$today_ts', eac_status='4' where  student_id='" . $_POST['student_id'] . "' and eac_date='" . $_POST['eac_date'] . "'";
		$result = $conn->query($sql);
		if (!$result) $conn->error;
	} elseif ($_POST['action'] == 'sasEACList') {
		//$tn_sas = "student_attendance_setup" . $mySes;
		//echo "SAS Table " . $tn_sas;
		$json = get_extraAttendanceJson($conn, $tn_eac);
		//echo $json;
		$array = json_decode($json, true);
		//echo $array;
		echo '<table class="table list-table-xxs">';
		echo '<tr align="center"><th>Id</th><th>Student</th><th>Class</th><th>Date</th><th>Period</th><th>Activity</th><th>Remarks</th><th>Status</th><th colspan="2">Action</th></tr>';
		for ($i = 0; $i < count($array["data"]); $i++) {
			$student_id = $array["data"][$i]["student_id"];
			$student_name = getField($conn, $student_id, "student", "student_id", "student_name");
			$eac_date = $array["data"][$i]["eac_date"];
			$eae_id = $array["data"][$i]["eae_id"];
			$eae_name = getField($conn, $eae_id, "ea_event", "eae_id", "eae_name");
			$sas_id = $array["data"][$i]["sas_id"];
			$sas_period = getField($conn, $sas_id, $tn_sas, "sas_id", "sas_period");
			$sql = "select cl.* from $tn_rc rc, class cl where rc.class_id=cl.class_id and rc.student_id='$student_id' and rc.rc_status='A' order by rc.class_id desc";
			$class_id = getFieldValue($conn, "class_id", $sql);
			//echo "Class $class_id";
			$class_name = getFieldValue($conn, "class_name", $sql);
			echo !in_array($class_id, $myArrayCI);
			if ($sas_id > 0 && in_array($class_id, $myArrayCI)) {
				$status = $array["data"][$i]["eac_status"];
				if ($status == '3') echo '<tr class="approved">';
				elseif ($status == '4') echo '<tr class="rejected">';
				else echo '<tr>';
				echo '<td>' . $student_name . '[' . $student_id . ']</td>';
				$remarks = $array["data"][$i]["eac_remarks"];
				$date = date("d-m-Y", strtotime($eac_date));
				$text = $student_name . '[' . $class_name . '] <br> claimed attendances of Period ' . $sas_period . ' for ' . $date . '<br>on account of ' . $eae_name . '<br> Remarks : <br>' . $remarks . '<br>';
				echo '<td>' . $class_name . '</td>';
				echo '<td align="center">' . $date . '</td>';
				echo '<td align="center">' . $sas_period . '</td>';
				echo '<td>' . $eae_name . '</td>';
				echo '<td>' . $remarks . '</td>';
				echo '<td align="center">' . status_decode($status) . '</td>';
				echo '<td align="center"><button class="btn btn-success btn-square-sm mt-1 sasApproveButton" data-text="' . $text . '" data-std="' . $student_id . '" data-sas="' . $sas_id . '">Approve</button>';
				echo '<td align="center"><button class="btn btn-danger btn-square-sm mt-1 sasRejectButton" data-text="' . $text . '" data-std="' . $student_id . '" data-sas="' . $sas_id . '">Reject</button>';
				echo '</tr>';
			}
		}
		echo '</table>';
	} elseif ($_POST['action'] == "rejectSAS") {
		$sql = "update ea_claim set eac_approved='0', approver_ts='$today_ts', eac_status='4' where  student_id='" . $_POST['student_id'] . "' and sas_id='" . $_POST['sas_id'] . "'";
		$result = $conn->query($sql);
		if (!$result) $conn->error;
		$sql = "select cl.* from $tn_rc rc, class cl where rc.class_id=cl.class_id and rc.student_id='$student_id' and rc.rc_status='A' order by rc.class_id desc";
		$class_id = getFieldValue($conn, "class_id", $sql);

		$tn_sa = "student_attendance" . $class_id;
		//echo "SA ".$tn_sa;

		$sql = "update $tn_sa set sa_present='1' where  student_id='" . $_POST['student_id'] . "' and sas_id='" . $_POST['sas_id'] . "'";
		$result = $conn->query($sql);
		if (!$result) $conn->error;
	} elseif ($_POST['action'] == "approveSAS") {
		$sql = "update ea_claim set eac_approved='0', approver_ts='$today_ts', eac_status='3' where  student_id='" . $_POST['student_id'] . "' and sas_id='" . $_POST['sas_id'] . "'";
		$result = $conn->query($sql);
		if (!$result) $conn->error;
		//echo "RC ".$tn_rc;
		$sql = "select cl.* from $tn_rc rc, class cl where rc.class_id=cl.class_id and rc.student_id='" . $_POST['student_id'] . "' and rc.rc_status='A' order by rc.class_id desc";
		$class_id = getFieldValue($conn, "class_id", $sql);

		$tn_sa = "student_attendance" . $class_id;
		echo "SA " . $tn_sa;
		$sql = "update $tn_sa set sa_present='0' where  student_id='" . $_POST['student_id'] . "' and sas_id='" . $_POST['sas_id'] . "'";
		$result = $conn->query($sql);
		if (!$result) $conn->error;
	}
}
