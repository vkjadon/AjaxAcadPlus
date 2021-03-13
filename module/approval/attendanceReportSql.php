<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
include('../../phpFunction/leaveFunction.php');
include('../../phpFunction/myArrayFunction.php');
//echo $myId;
//$myArrayCI = getResponsibilityArray($conn, "class_incharge", $myId, "class_id");

//print_r($myArrayCI);
//echo $_POST['action'];
if (isset($_POST['action'])) {
	if ($_POST['action'] == 'sasEACReport') {
		//$tn_sas = "student_attendance_setup" . $mySes;
		//echo "SAS Table " . $tn_sas;
		$json = get_classEAJson($conn, $tn_eac);
		//echo $json;
		$array = json_decode($json, true);
		//echo $array;
		$found='0';
		echo '<div class="row">';
		echo '<table class="table list-table-xxs">';
		echo '<tr align="center"><th>Id</th><th>Student</th><th>Class</th><th>Date</th><th>Period</th><th>Activity</th><th>Remarks</th><th>Status</th></tr>';
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
			//echo !in_array($class_id, $myArrayCI);
			if ($sas_id > 0) {
				$found=1;
				$status = $array["data"][$i]["eac_status"];
				if ($status == '3') echo '<tr class="approved">';
				elseif ($status == '4') echo '<tr class="rejected">';
				else echo '<tr>';
				echo '<td>' . $sas_id . '</td>';
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
				echo '</tr>';
			}
		}
		if($found=='0')echo '<tr><td colspan="8"><h4>No Data Found </h4></td></tr>';
		echo '</table>';
		echo '</div>';
	}elseif($_POST['action']=='program'){
		$sql="select * from program";
		selectList($conn, "Select a Program", array("0", "program_id", "program_name", "program_abbri", "sel_program" ), $sql);
	}elseif($_POST['action']=='class'){
		$programId=$_POST['programId'];
		//echo "Prog  $programId";
		$sql="select cl.*, s.* from class cl, session s where cl.program_id='$programId' and cl.session_id=s.session_id and s.session_status='0' and cl.class_status='0' order by cl.class_id desc limit 6";
		selectList($conn, "Select a Class", array("0", "class_id", "class_name", "session_name", "sel_class" ), $sql);
	}elseif($_POST['action']=='classStudentList'){
		$classId=$_POST['classId'];
		echo " Class $classId";
		$json = get_classEAJson($conn, $tn_eac);
		//echo $json;
		$array = json_decode($json, true);
		//echo $array;
		$found='0';
		echo '<table class="table list-table-xxs">';
		echo '<tr align="center"><th>Id</th><th>Student</th><th>Class</th><th>Date</th><th>Period</th><th>Activity</th><th>Remarks</th><th>Status</th></tr>';
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
			//echo !in_array($class_id, $myArrayCI);
			if ($sas_id > 0) {
				$found=1;
				$status = $array["data"][$i]["eac_status"];
				if ($status == '3') echo '<tr class="approved">';
				elseif ($status == '4') echo '<tr class="rejected">';
				else echo '<tr>';
				echo '<td>' . $sas_id . '</td>';
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
				echo '</tr>';
			}
		}
		if($found=='0')echo '<tr><td colspan="8"><h4>No Data Found </h4></td></tr>';
		echo '</table>';
	}
}
