<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
include('../../phpFunction/feedbackFunction.php');
//echo $_POST['action'];
if (isset($_POST['action'])) {
	if ($_POST['action'] == "addStatement") {
		$sql = "update feedback_question set fq_status='1' where update_id='$myId'";
		$result = $conn->query($sql);
		$sql = "insert into feedback_question (fq_statement, update_id, fq_status) values('" . $_POST['statement'] . "', '$myId', '0')";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		else echo "Updated";
	} elseif ($_POST['action'] == "fetchCurrentQuestion") {
		$sql = "select fq.* from feedback_question fq where fq.update_id='$myId' and fq.fq_status='0'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			$json_array = array();
			while ($rowArray = $result->fetch_assoc()) {
				$json_array[] = $rowArray;
			}
			echo json_encode($json_array);
		} else {
			$json_array = array("fq_statement" => "No Question is Active");
			echo json_encode($json_array);
		}
	} elseif ($_POST['action'] == "fetchCurrentQuestionOption") {
		$sql = "select fo.* from fq_option fo, feedback_question fq where fo.fq_id=fq.fq_id and fq.update_id='$myId' and fq.fq_status='0'";
		$result = $conn->query($sql);
		$json_array = array();
		while ($rowArray = $result->fetch_assoc()) {
			$json_array[] = $rowArray;
		}
		echo json_encode($json_array);
	} elseif ($_POST['action'] == "updateStatement") {
		$sql = "update feedback_question set fq_statement='" . data_check($_POST['statement']) . "', update_ts='$submit_ts' where update_id='$myId' and fq_status='0'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		else echo "Updated";
	} elseif ($_POST['action'] == "addOption") {
		$sql = "select * from feedback_question where update_id='$myId' and fq_status='0'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		else {
			$output = $result->fetch_assoc();
			$fq_id = $output["fq_id"];
		}
		$sql = "insert into fq_option (fq_id, fo_statement, fo_score, fo_sno) values('$fq_id', '" . data_check($_POST['statement']) . "', '" . $_POST['score'] . "', '" . $_POST['sno'] . "')";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		else echo "Updated";
	} elseif ($_POST['action'] == "acceptQuestion") {
		$sql = "update feedback_question set fq_status='1', update_ts='$submit_ts' where update_id='$myId' and fq_status='0'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		else echo "Updated";
	} elseif ($_POST['action'] == "setActive") {
		$sql = "update feedback_question set fq_status='1' where update_id='$myId'";
		$result = $conn->query($sql);
		
		$sql = "update feedback_question set fq_status='0' where fq_id='".$_POST['fq_id']."'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		else echo "Updated";
	} elseif ($_POST['action'] == "questionList") {
		$sql = "select fq.* from feedback_question fq where fq.update_id='$myId' and fq.fq_status='1'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			$json_array = array();
			while ($rowArray = $result->fetch_assoc()) {
				$json_array[] = $rowArray;
			}
			echo json_encode($json_array);
		} else {
			$json_array = array("fq_statement" => "No Question Available");
			echo json_encode($json_array);
		}
	}
}
