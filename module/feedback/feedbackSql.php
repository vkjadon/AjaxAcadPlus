<?php
require('../requireSubModule.php');
include('../../phpFunction/feedbackFunction.php');
//echo $_POST['action'];
if (isset($_POST['action'])) {
	if ($_POST['action'] == "fqUpdate") {

		if ($_POST['fq_id'] == 0) $sql = "insert into feedback_question (feedback_id, fq_statement, fq_sno, fq_option1, fq_score1, fq_option2, fq_score2, fq_option3, fq_score3, fq_option4, fq_score4, fq_option5, fq_score5, update_ts, update_id, fq_status) values('" . data_check($_POST['feedback_id']) . "', '" . data_check($_POST['fq_statement']) . "', '" . data_check($_POST['fq_sno']) . "', '" . data_check($_POST['fq_option1']) . "', '" . data_check($_POST['fq_score1']) . "', '" . data_check($_POST['fq_option2']) . "', '" . data_check($_POST['fq_score2']) . "', '" . data_check($_POST['fq_option3']) . "', '" . data_check($_POST['fq_score3']) . "', '" . data_check($_POST['fq_option4']) . "', '" . data_check($_POST['fq_score4']) . "', '" . data_check($_POST['fq_option5']) . "', '" . data_check($_POST['fq_score5']) . "', '$submit_ts', '$myId', '1')";

		else $sql = "update feedback_question set fq_statement='" . data_check($_POST['fq_statement']) . "', fq_sno='" . data_check($_POST['fq_sno']) . "', fq_option1='" . data_check($_POST['fq_option1']) . "', fq_option2='" . data_check($_POST['fq_option2']) . "', fq_option3='" . data_check($_POST['fq_option3']) . "', fq_option4='" . data_check($_POST['fq_option4']) . "', fq_option5='" . data_check($_POST['fq_option5']) . "', fq_score1='" . data_check($_POST['fq_score1']) . "', fq_score2='" . data_check($_POST['fq_score2']) . "', fq_score3='" . data_check($_POST['fq_score3']) . "', fq_score4='" . data_check($_POST['fq_score4']) . "', fq_score5='" . data_check($_POST['fq_score5']) . "', update_ts='$submit_ts' where fq_id='" . $_POST['fq_id'] . "'";
		if (!$conn->query($sql)) echo $conn->error;
		else echo "Updated";
	} elseif ($_POST['action'] == "fetchCurrentQuestion") {

		$sql = "update feedback_question set fq_status='1' where update_id='$myId'";
		$result = $conn->query($sql);

		$sql = "update feedback_question set fq_status='0' where fq_id='" . $_POST['fq_id'] . "'";
		$result = $conn->query($sql);

		$sql = "select fq.* from feedback_question fq where fq.fq_id='" . $_POST['fq_id'] . "'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			$rowArray = $result->fetch_assoc();
			echo json_encode($rowArray);
		} else {
			$json_array = array("fq_statement" => "No Question is Active");
			echo json_encode($json_array);
		}
	} elseif ($_POST['action'] == "questionList") {
		$sql = "select fq.* from feedback_question fq where fq.update_id='$myId' and feedback_id='" . $_POST['feedback_id'] . "' order by fq.fq_sno";
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
	} elseif ($_POST['action'] == "feedbackList") {
		if (isset($_POST['tag'])) $sql = "select fb.*, s.* from feedback fb, session s where fb.session_id=s.session_id and fb.update_id<>'$myId' order by fb.feedback_id desc";
		else $sql = "select fb.*, s.* from feedback fb, session s where fb.session_id=s.session_id and fb.update_id='$myId' order by fb.feedback_id desc";
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
	} elseif ($_POST['action'] == "fetchFeedback") {
		$sql = "update feedback set feedback_status='1' where update_id='$myId'";
		$result = $conn->query($sql);

		$sql = "update feedback set feedback_status='0' where feedback_id='" . $_POST['feedback_id'] . "'";
		$result = $conn->query($sql);

		$sql = "select f.* from feedback f where f.feedback_id='" . $_POST['feedback_id'] . "'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			$rowArray = $result->fetch_assoc();
			echo json_encode($rowArray);
		} else {
			$json_array = array("fq_statement" => "No Question is Active");
			echo json_encode($json_array);
		}
	} elseif ($_POST['action'] == "updateFeedback") {
		if ($_POST['feedback_id'] == 0) $sql = "insert into feedback (session_id, feedback_name, feedback_section, feedback_open_date, feedback_open_time, feedback_close_date, feedback_close_time, update_ts, update_id, feedback_status) values('$mySes', '" . data_check($_POST['feedback_name']) . "', '1', '" . data_check($_POST['feedback_open_date']) . "', '" . data_check($_POST['feedback_open_time']) . "', '" . data_check($_POST['feedback_close_date']) . "', '" . data_check($_POST['feedback_close_time']) . "', '$submit_ts', '$myId', '0')";

		else $sql = "update feedback set feedback_name='" . data_check($_POST['feedback_name']) . "', feedback_section='" . data_check($_POST['feedback_section']) . "', feedback_open_date='" . data_check($_POST['feedback_open_date']) . "', feedback_open_time='" . data_check($_POST['feedback_open_time']) . "', feedback_close_date='" . data_check($_POST['feedback_close_date']) . "', feedback_close_time='" . data_check($_POST['feedback_close_time']) . "',update_ts='$submit_ts' where feedback_id='" . $_POST['feedback_id'] . "'";
		if (!$conn->query($sql)) echo $conn->error;
		else echo "Updated";
	} elseif ($_POST['action'] == "questionListCopy") {
		$sql = "select fq.* from feedback_question fq where feedback_id='" . $_POST['feedback_id'] . "' order by fq.fq_sno";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {

			echo '<table class="table table-striped list-table-xs">';
			echo '<tr><th>SNo</th><th>Statement</th><th>Option-1</th><th>Option-2</th><th>Option-3</th><th>Option-4</th><th>Option-5</th></tr>';
			while ($rowArray = $result->fetch_assoc()) {
				echo '<tr>';
				echo '<td>' . $rowArray['fq_sno'] . '</td>';
				echo '<td>' . $rowArray['fq_statement'] . '</td>';
				echo '<td>' . $rowArray['fq_option1'] . '[' . $rowArray['fq_score1'] . ']</td>';
				echo '<td>' . $rowArray['fq_option2'] . '[' . $rowArray['fq_score2'] . ']</td>';
				echo '<td>' . $rowArray['fq_option3'] . '[' . $rowArray['fq_score3'] . ']</td>';
				echo '<td>' . $rowArray['fq_option4'] . '[' . $rowArray['fq_score4'] . ']</td>';
				echo '<td>' . $rowArray['fq_option5'] . '[' . $rowArray['fq_score5'] . ']</td>';
				echo '</tr>';
			}
			echo '</table>';
		}
	} elseif ($_POST['action'] == "copyQuestion") {
		$sql = "select fq.* from feedback_question fq where feedback_id='" . $_POST['fqCopy_from'] . "' order by fq.fq_sno";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			while ($rowArray = $result->fetch_assoc()) {
				$sql = "insert into feedback_question (feedback_id, fq_statement, fq_sno, fq_option1, fq_score1, fq_option2, fq_score2, fq_option3, fq_score3, fq_option4, fq_score4, fq_option5, fq_score5, update_ts, update_id, fq_status) values('" . $_POST['fqCopy_to'] . "', '" . data_check($rowArray['fq_statement']) . "', '" . $rowArray['fq_sno'] . "', '" . data_check($rowArray['fq_option1']) . "', '" . $rowArray['fq_score1'] . "', '" . data_check($rowArray['fq_option2']) . "', '" . $rowArray['fq_score2'] . "', '" . data_check($rowArray['fq_option3']) . "', '" . $rowArray['fq_score3'] . "', '" . data_check($rowArray['fq_option4']) . "', '" . $rowArray['fq_score4'] . "', '" . data_check($rowArray['fq_option5']) . "', '" . $rowArray['fq_score5'] . "', '$submit_ts', '$myId', '1')";
				if (!$conn->query($sql)) echo $conn->error;
			}
		}
	} elseif ($_POST['action'] == "programClassList") {

		$feedback_id = $_POST['feedback_id'];

		$sql = "select cl.class_id, cl.class_name, cl.class_section from class cl where cl.session_id='$mySes' and cl.program_id='$myProg' and cl.class_status='0' order by cl.class_semester";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			$json_array = array();
			$subArray = array();
			while ($rowsArray = $result->fetch_assoc()) {
				$class_id = $rowsArray["class_id"];

				$sql_check = "select * from feedback_participant where fp_code_id='$class_id' and feedback_id='$feedback_id'";
				$result_check = $conn->query($sql_check);
				$subArray["status"] = "0";
				$subArray["fp_open_date"] = "";
				$subArray["fp_close_date"] = "";
				$subArray["fp_cutoff"] = "";

				if ($result_check->num_rows == 1) {
					$rowFp = $result_check->fetch_assoc();
					$subArray["status"] = "1";
					$subArray["fp_open_date"] = $rowFp["fp_open_date"];
					$subArray["fp_close_date"] = $rowFp["fp_close_date"];
					$subArray["fp_cutoff"] = $rowFp["fp_cutoff"];
				} else echo $conn->error;
				$subArray["class_id"] = $class_id;
				$subArray["class_name"] = $rowsArray["class_name"];
				$subArray["class_section"] = $rowsArray["class_section"];

				$json_array[] = $subArray;
			}
			echo json_encode($json_array);
		} else {
			$json_array = array("status" => "Could Not Fetch any Data");
			echo json_encode($json_array);
		}
	} elseif ($_POST['action'] == "participantClass") {

		$sql = "select * from feedback where feedback_id='" . $_POST['feedback_id'] . "'";
		$feedback_open = getFieldValue($conn, "feedback_open_date", $sql);
		$feedback_close = getFieldValue($conn, "feedback_close_date", $sql);

		if ($_POST['status'] == 'true') $sql = "insert into feedback_participant (feedback_id, fp_code, fp_code_id, fp_cutoff, fp_open_date, fp_close_date) values('" . $_POST['feedback_id'] . "', 'class_id', '" . $_POST['classId'] . "', '100', '$feedback_open' , '$feedback_close')";
		else $sql = "delete from feedback_participant where feedback_id='" . $_POST['feedback_id'] . "' and fp_code='class_id' and fp_code_id='" . $_POST['classId'] . "'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		else {
			echo "Updated Successfully";
		}
	} elseif ($_POST['action'] == "updateFp") {
		$tag = $_POST['tag'];
		$value = $_POST['value'];
		$sql = "update feedback_participant set $tag='$value' where feedback_id='" . $_POST['feedback_id'] . "' and fp_code='class_id' and fp_code_id='" . $_POST['class_id'] . "'";
		if (!$conn->query($sql)) echo $conn->error;
		else echo "Updated " . $_POST['class_id'];
	}
}
