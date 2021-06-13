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
			$rowArray = $result->fetch_assoc();
			echo json_encode($rowArray);
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

		$sql = "update feedback_question set fq_status='0' where fq_id='" . $_POST['fq_id'] . "'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		else echo "Updated";
	} elseif ($_POST['action'] == "questionList") {
		$sql = "select fq.* from feedback_question fq where fq.update_id='$myId' and fq.fq_status='1' order by fq.fq_id desc";
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
	} elseif ($_POST['action'] == "fetchOption") {
		$sql = "select fo.* from fq_option fo where fo.fq_id='" . $_POST['fq_id'] . "' and fo.fo_sno='" . $_POST['fo_sno'] . "'";
		$result = $conn->query($sql);
		$rowArray = $result->fetch_assoc();
		echo json_encode($rowArray);
	} elseif ($_POST['action'] == "updateOption") {
		$field = $_POST['tag'];
		$sql = "update fq_option set $field='" . data_check($_POST['value']) . "' where fq_id='" . data_check($_POST['fq_id']) . "' and fo_sno='" . data_check($_POST['fo_sno']) . "'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		else echo " Value " . $_POST['value'] . ' Tag ' . $_POST['tag'] . ' FQID ' . $_POST['fq_id'] . ' Sno ' . $_POST['fo_sno'];
	} elseif ($_POST['action'] == "templateList") {
		$sql = "select * from template where ft_id='" . $_POST['ft_id'] . "' order by template_id desc";
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
	} elseif ($_POST['action'] == "addTemplate") {
		$sql = "update template set template_status='1' where update_id='$myId'";
		$result = $conn->query($sql);
		$sql = "insert into template (ft_id, template_name, update_id, template_status) values('" . $_POST['sel_ft'] . "', '" . $_POST['template_name'] . "', '$myId', '0')";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		else echo "Updated";
	} elseif ($_POST['action'] == "addToTemplate") {
		$sql = "select template_id from template where update_id='$myId' and template_status='0'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		else {
			$rowsTemplate = $result->fetch_assoc();
			$template_id = $rowsTemplate['template_id'];
			echo $template_id;
		}
		$sql = "insert into template_question (template_id, fq_id, update_id) values('$template_id', '" . $_POST['fq_id'] . "', '$myId')";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		else echo "Updated";
	} elseif ($_POST['action'] == "setActiveTemplate") {
		$sql = "update template set template_status='1' where update_id='$myId'";
		$result = $conn->query($sql);

		$sql = "update template set template_status='0' where template_id='" . $_POST['template_id'] . "'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		else echo "Updated";
	}elseif ($_POST['action'] == "templateQuestionList") {
		$sql = "select fq.* from template_question tq, feedback_question fq where tq.template_id='".$_POST['template_id']."' and tq.fq_id=fq.fq_id and fq.update_id='$myId' and fq.fq_status='1' order by fq.fq_id desc";
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
