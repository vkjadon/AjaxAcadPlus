<?php
require('../requireSubModule.php');

//echo $_POST['action'];
if (isset($_POST['action'])) {
	if ($_POST['action'] == 'addTest') {
		if (!$_POST['test_name'] == NULL) {
			$sql="update test set test_status='1' where update_id='$myId'";
			$result = $conn->query($sql);
			if ($_POST['test_id'] == '0') $sql = "insert into test (test_name, test_section, test_status, update_id) values('" . data_check($_POST['test_name']) . "','" . data_check($_POST['test_section']) . "', '1', '$myId')";
			else $sql = "update test set test_name='" . data_check($_POST['test_name']) . "', test_section='" . data_check($_POST['test_section']) . "', update_ts='$submit_ts' where test_id='" . $_POST['test_id'] . "'";
			$result = $conn->query($sql);
			if ($result) echo "Added Successfully";
			else {
				$error = $conn->errno;
				if ($error == "1062") echo "Duplicate Found";
			}
		} else echo "Test Name Cannot be Blank";
	} elseif ($_POST['action'] == 'testList') {
		$sql = "select * from test where update_id='$myId'";
		$result = $conn->query($sql);
		if ($result) {
			$json_array = array();
			while ($output = $result->fetch_assoc()) {
				$json_array[] = $output;
			}
			echo json_encode($json_array);
		} else echo $conn->error;
	} elseif ($_POST['action'] == 'fetchTest') {
		$sql = "update test set test_status='1' where update_id='$myId'";
		$result = $conn->query($sql);

		$sql = "update test set test_status='0' where test_id='" . $_POST['test_id'] . "'";
		$result = $conn->query($sql);

		$sql = "select * from test where test_id='" . $_POST['test_id'] . "'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			$rowArray = $result->fetch_assoc();
			echo json_encode($rowArray);
		} else {
			$json_array = array("fq_statement" => "No Active Data Found");
			echo json_encode($json_array);
		}
	} elseif ($_POST['action'] == 'removeTest') {
		$id = $_POST['id'];
		//echo "Jai ho";
		updateField($conn, "test", array("test_id", "test_status"), array($id, "9"), "1");
	} elseif ($_POST['action'] == 'testHeading') {
		$sql = "select * from test where test_status='0' and update_id='$myId'";
		$result = $conn->query($sql);
		if ($result) {
			$array = $result->fetch_assoc();
			$id = $array["test_id"];
			$test_name = $array["test_name"];
			$test_section = $array["test_section"];
			$test_status = $array["test_status"];
			echo '<div class="col p-0"><button class="btn btn-primary btn-sm studyMaterial"> Study Material</button></div>';

			echo '<div class="card p-2">
   <div class="card-body p-1">
				<a href="#" class="atag testInstruction p-0" data-test="' . $id . '"><i class="fa fa-edit"></i></a>
				<span><b> ' . $test_name . '</b></span>';
			echo '<div class="row">';
			for ($i = 1; $i <= $test_section; $i++) {
				$sql = "select sum(tq_marks) as sum from test_question where test_id='$id' and test_section='$i'";
				$value = getFieldValue($conn, "sum", $sql);
				//echo '<div class="col-3"><h6 class="text-muted py-1">Marks : ' . $value . '</h6></div>';
				echo '<div class="col"><button class="btn btn-info btn-square-sm sectionInstruction" data-test="' . $id . '" data-section="' . $i . '">Section : ' . $i . ' Instructions</button></div>';
			}
			echo '</div>';
			echo '</div></div>';
		}
	} elseif ($_POST['action'] == 'addQuestion') {
		$sql="update question_bank set qb_status='1' where update_id='$myId'";
		$result = $conn->query($sql);

		$sql = "select * from test where test_status='0' and update_id='$myId'";
		$result = $conn->query($sql);
		if ($result) {
			$array = $result->fetch_assoc();
			$test_id = $array["test_id"];
		}
		$sectionId = $_POST['sectionId'];
		$question = data_check($_POST['question']);
		$tq_marks = $_POST['defaultMarks'];
		$tq_nmarks = $_POST['defaultNMarks'];
		$actionCode = $_POST['actionCode'];
		echo "Action Code $actionCode";
		if ($actionCode == "add") {
			$sql = "insert into question_bank (qb_level, qb_base, qb_text, update_id, qb_status) values('1', '1', '$question', '$myId', '1')";
			$result = $conn->query($sql);
			if ($result) {
				echo "Added Successfully";
				$insertId = $conn->insert_id;
				$sql = "insert into test_question (test_id, test_section, qb_id, tq_marks, tq_nmarks, tq_status) values('$test_id', '$sectionId', '$insertId', '$tq_marks', '$tq_nmarks', '1')";
				$result = $conn->query($sql);
				if (!$result) echo $conn->error;
				$fileName = 'ques-' . $insertId . '.txt';
				writeToFile("../../olat/text", $fileName, $question);

				// Block for Variable Input

				$portion = explode("***", $question);
				$portion_count = count($portion);
				if ($portion_count > 1) {
					for ($ipc = 1; $ipc < $portion_count; $ipc++) {
						$sql = "insert into qb_parameter (qb_id, qp_sno, qp_name) values('$insertId', '$ipc', 'Parameter')";
						$result = $conn->query($sql);
						if (!$result) echo $conn->error;
					}
				}
			} else {
				$error = $conn->errno;
				if ($error == "1062") echo "Duplicate Found !!!";
			}
		} else {
			$sql = "select * from question_bank where qb_status='0' and update_id='$myId'";
			$result = $conn->query($sql);
			if ($result) {
				$array = $result->fetch_assoc();
				$qb_id = $array["qb_id"];

				$fileName = 'ques-' . $qb_id . '.txt';
				writeToFile("../../olat/text", $fileName, $question);

				// Block for Variable Input

				$portion = explode("***", $question);
				$portion_count = count($portion);
				if ($portion_count > 1) {
					for ($ipc = 1; $ipc < $portion_count; $ipc++) {
						$sql = "insert into qb_parameter (qb_id, qp_sno, qp_name) values('$qb_id', '$ipc', 'Parameter')";
						$result = $conn->query($sql);
						//if (!$result) echo $conn->error;
					}
				}
				echo "Question Updated";
			}
		}
	} elseif ($_POST['action'] == 'addOption') {		
		$sql = "select * from question_bank where qb_status='0' and update_id='$myId'";
		$result = $conn->query($sql);
		if ($result) {
			$array = $result->fetch_assoc();
			$qb_id = $array["qb_id"];
		}
		$qo_text = $_POST['content'];
		$sql = "select max(qo_code) as max from question_option where qb_id='$qb_id'";
		$max_sno = getMaxValue($conn, $sql) + 1;

		$sql = "insert into question_option (qb_id, qo_text, qo_code, qo_correct) values('$qb_id','$qo_text', '$max_sno', '0')";
		$result = $conn->query($sql);
		if ($result) {
			echo "Added Successfully";
		} else {
			$error = $conn->errno;
			if ($error == "1062") echo "Duplicate Found !!!";
		}
	} elseif ($_POST['action'] == 'activeQuestion') {
		$sql = "select * from test where test_status='0' and update_id='$myId'";
		$result = $conn->query($sql);
		if ($result) {
			$array = $result->fetch_assoc();
			$test_id = $array["test_id"];
		}
		$qb_id = $_POST['qb_id'];
		//echo "Jai ho $test_id";
		$sql = "update question_bank set qb_status='1' where update_id='$myId'";
		// $sql = "update question_bank set qb_status='1' where qb_id IN (select qb_id from test_question where test_id='$test_id')";
		$result = $conn->query($sql);

		$sql = "update question_bank set qb_status='0' where qb_id='$qb_id'";
		$result = $conn->query($sql);
		if ($result) echo "Updated Successfully";
	} elseif ($_POST['action'] == 'fetchInstruction') {
		$test_id = $_POST['testId'];
		$folder = '../../' . $myFolder . '/test/' . $test_id;
		if (isset($_POST['sectionId'])) {
			$section = $_POST['sectionId'];
			$fileName = $folder . '/instructions_section' . $section . '.txt';
		} else {
			$fileName = $folder . '/instructions_test.txt';
			//echo $fileName;
		}
		if (file_exists($fileName)) $content = file_get_contents($fileName);
		else $content = "No File Found";
		//echo $content;
		$output = array("file" => "fileName", "content" => $content);
		echo json_encode($output);
	} elseif ($_POST['action'] == 'questionHeading') {
		$sql = "select * from test where test_status='0' and update_id='$myId'";
		$result = $conn->query($sql);
		if ($result) {
			$array = $result->fetch_assoc();
			$id = $array["test_id"];
			$test_name = $array["test_name"];
			$test_section = $array["test_section"];
			$test_status = $array["test_status"];
			if (isset($_POST['section'])) $section = $_POST['section'];
			else $section = '1';
			if (isset($_POST['marks'])) $marks = $_POST['marks'];
			else $marks = '0';
			if (isset($_POST['nmarks'])) $nmarks = $_POST['nmarks'];
			else $nmarks = '0';
			echo '<div class="row">';
			echo '<div class="col"><h6>[' . $id . '] ' . $test_name . '</h6></div>';
			echo '</div>';
			echo '<div class="row">';
			echo '<div class="col-3 text-center">';
			echo '<span class="topBarText p-0 m-0">Sections</span>';
			echo '<div class="row">
			<div class="col p-0 m-1 text-center">';
			for ($i = 1; $i <= $test_section; $i++) {
				echo '<button class="btn btn-warning btn-square-sm mt-0 defaultSection" id="defaultSection' . $i . '" data-section="' . $i . '">' . $i . '</button>';
			}
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
		}
	} elseif ($_POST['action'] == 'fetchQuestion') {
		$test_id = $_POST['testId'];
		$section = $_POST['sectionId'];
		$sql = "SELECT qb.* FROM test_question tq, question_bank qb where tq.test_id='$test_id' and tq.test_section='$section' and tq.qb_id=qb.qb_id";
		$result = $conn->query($sql);
		if ($result) $output = $result->fetch_assoc();
		else $output = array("qb_text" => "Please write/paste your Question Here");
		echo json_encode($output);
	} elseif ($_POST['action'] == 'changeOption') {
		$qb_id = $_POST['qb_id'];
		$qo_code = $_POST['qo_code'];
		$change_code = $_POST['change_code'];
		//echo "Jai ho $qb_id code $qo_code";
		if ($change_code == "setRight") $sql = "update question_option set qo_correct='1' where qb_id='$qb_id' and qo_code='$qo_code'";
		else $sql = "update question_option set qo_correct='0' where qb_id='$qb_id' and qo_code='$qo_code'";
		$result = $conn->query($sql);
		if ($result) echo "Updated Successfully";
		else echo $conn->error;
	} elseif ($_POST['action'] == 'updateOption') {
		$qb_id = $_POST['qb_id'];
		$qo_code = $_POST['qo_code'];
		$qo_text = $_POST['qo_text'];
		//echo "Jai ho $qb_id code $qo_code";
		$result = $conn->query($sql);
		if ($result) echo "Updated Successfully";
		else echo $conn->error;
	} elseif ($_POST['action'] == 'updateText') {
		if (isset($_POST['qb_id'])) $qb_id = $_POST['qb_id'];
		if (isset($_POST['qo_code'])) $qo_code = $_POST['qo_code'];
		if (isset($_POST['qp_sno'])) $qp_sno = $_POST['qp_sno'];
		if (isset($_POST['test_id'])) $test_id = $_POST['test_id'];
		$value = $_POST['value'];
		$tag = $_POST['tag'];
		echo "Jai ho Tag $tag - Val $value";
		//echo "Rest  $qb_id - Val $value";
		//echo "Jai ho  code $qo_code";
		//echo "Jai ho  Sno  $qp_sno";
		if ($tag == "qo_text") $sql = "update question_option set qo_text='$value' where qb_id='$qb_id' and qo_code='$qo_code'";
		elseif ($tag == "test_name") $sql = "update test set test_name='$value' where test_id='$test_id'";
		elseif ($tag == "qb_text") $sql = "update question_bank set $tag='$value' where qb_id='$qb_id'";
		else $sql = "update qb_parameter set $tag='$value' where qb_id='$qb_id' and qp_sno='$qp_sno'";
		$result = $conn->query($sql);
		$affectedRows = $conn->affected_rows;
		if (!$result) echo $conn->error;
		elseif ($affectedRows == 0) {
			$sql = "insert into qb_parameter (qb_id, qp_sno, $tag) values('$qb_id', '$qp_sno', '$value')";
			$result = $conn->query($sql);
			if (!$result) echo $conn->error;
		} else echo "Updated Successfully";
	} elseif ($_POST['action'] == 'addCP') {
		$qb_id = $_POST["qb_id"];
		$qc_name = $_POST['qc_name'];
		$qc_marks = $_POST['qc_marks'];
		$qc_sno = $_POST['qc_sno'];
		$sql = "insert into qb_cp (qb_id, qc_name, qc_marks, qc_sno) values('$qb_id', '$qc_name', '$qc_marks', '$qc_sno')";
		$result = $conn->query($sql);
		if ($result) {
			echo "Added Successfully";
		} else {
			$error = $conn->errno;
			if ($error == "1062") echo "Duplicate Found !!!";
		}
	} elseif ($_POST['action'] == 'updateCP') {
		$qb_id = $_POST['qb_id'];
		$qc_sno = $_POST['qc_sno'];
		$value = $_POST['value'];
		$tag = $_POST['tag'];
		//echo "Jai ho $qb_id code $qo_code";
		$sql = "update qb_cp set $tag='$value' where qb_id='$qb_id' and qc_sno='$qc_sno'";
		$result = $conn->query($sql);
		if ($result) echo "Updated Successfully";
		else echo $conn->error;
	} elseif ($_POST['action'] == 'delete') {
		$id = $_POST['id'];
		$sno = $_POST['sno'];
		$tag = $_POST['tag'];
		//echo "Jai ho $qb_id code $qo_code";
		if ($tag == "cp") $sql = "delete from qb_cp where qb_id='$id' and qc_sno='$sno'";
		elseif ($tag == "tq") $sql = "delete from test_question where qb_id='$id' and test_id='$sno'";
		else $sql = "delete from question_option where qb_id='$id' and qo_code='$sno'";
		$result = $conn->query($sql);
		if ($result) echo "Removed Successfully";
		else echo $conn->error;
	} elseif ($_POST['action'] == "deptClassList") {
		$sql = "select * from test where update_id='$myId' and test_status='0'";
		$test_id = getFieldValue($conn, "test_id", $sql);

		$sql = "select cl.* from class cl where cl.session_id='$mySes' and cl.dept_id='$myDept' and cl.class_status='0' order by cl.class_semester";

		$result = $conn->query($sql);
		$data = array();
		if ($result) {
			while ($rowsArray = $result->fetch_assoc()) {
				$subArray = array();
				$class_id = $rowsArray["class_id"];
				$query = "select * from test_participant where participant_code='class' and code_id='$class_id' and test_id='$test_id'";
				$check = $conn->query($query)->num_rows;
				$subArray["class_id"] = $class_id;
				$subArray["class_name"] = $rowsArray["class_name"];
				$subArray["class_section"] = $rowsArray["class_section"];
				if ($check > 0) $subArray["check"] = "1";
				else $subArray["check"] = "0";
				$data[] = $subArray;
			}
		}
		$jsonOutput = json_encode($data);
		echo $jsonOutput;
	} elseif ($_POST['action'] == "participant") {
		$sql = "select * from test where update_id='$myId' and test_status='0'";
		$test_id = getFieldValue($conn, "test_id", $sql);
		echo $test_id;
		if ($_POST['status'] == 'true') $sql = "insert into test_participant (test_id, participant_code, code_id, update_id) values('$test_id', 'class', '" . $_POST['classId'] . "', '$myId')";
		else $sql = "delete from test_participant where test_id='$test_id' and participant_code='class' and code_id='" . $_POST['classId'] . "'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		else {
			echo "Query Successful";
		}
	} elseif ($_POST['action'] == "addSchedule") {
		$sql = "select * from test where update_id='$myId' and test_status='0'";
		$test_id = getFieldValue($conn, "test_id", $sql);
		echo $test_id;
		$sql = "update test set test_from_date='" . $_POST['test_from_date'] . "', test_from_time='" . $_POST['test_from_time'] . "', test_to_date='" . $_POST['test_to_date'] . "', test_to_time='" . $_POST['test_to_time'] . "', test_duration='" . $_POST['test_duration'] . "' where test_id='$test_id'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		else {
			echo "Query Successful";
		}
	} elseif ($_POST['action'] == 'testSR') {
		$sql = "select * from test where update_id='$myId' and test_status='0'";
		$test_id = getFieldValue($conn, "test_id", $sql);

		//echo $test_id;
		$sql = "select * from test where test_id='$test_id'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			$data = array();
			$rowArray = $result->fetch_assoc();
			$data["test_name"] = $rowArray["test_name"];
			$data["test_section"] = $rowArray["test_section"];
			$data["test_from_date"] = $rowArray["test_from_date"];
			$data["test_from_time"] = $rowArray["test_from_time"];
			$data["test_to_date"] = $rowArray["test_to_date"];
			$data["test_to_time"] = $rowArray["test_to_time"];
			$data["test_duration"] = $rowArray["test_duration"];
			$data["update"] = $rowArray["update_ts"];
			$data["staff"] = getField($conn, $rowArray["update_id"], "staff", "staff_id", "staff_name" );

			$text = '';
			$sql = "select cl.* from class cl, test_participant tp where tp.test_id='$test_id' and tp.participant_code='class' and tp.code_id=cl.class_id order by cl.class_semester";
			$result = $conn->query($sql);
			while ($rowArray = $result->fetch_assoc()) {
				$text .= $rowArray["class_name"] . '[' . $rowArray["class_section"] . '], ';
			}
			$data["participant"] = $text;

			$sql = "select * from test_question where test_id='$test_id'";
			$result = $conn->query($sql);
			$data["question"] = $result->num_rows;

			$sql = "select sum(tq_marks) as marks, sum(tq_nmarks) as nmarks from test_question where test_id='$test_id'";
			$result = $conn->query($sql);
			$rowArray = $result->fetch_assoc();
			$data["marks"] = $rowArray["marks"];
			$data["nmarks"] = $rowArray["nmarks"];
			echo json_encode($data);
		}
	}
} elseif ($_POST['instructionId'] == 'T' || $_POST['instructionId'] == 'S') {
	$test_id = $_POST['testId'];
	$id = $_POST['instructionId'];
	$sectionId = $_POST['sectionId'];
	$instruction = $_POST['instruction'];
	//echo "Jai ho $instruction Id $id";
	$folder = '../../' . $myFolder . '/test';
	if (!is_dir($folder)) mkdir($folder);
	$folder = '../../' . $myFolder . '/test/' . $test_id;
	//echo $folder;
	if (!is_dir($folder)) mkdir($folder);
	if ($id == "T") $fileName = $folder . '/instructions_test.txt';
	else $fileName = $folder . '/instructions_section' . $sectionId . '.txt';
	echo $fileName;
	$fileHandle = fopen($fileName, 'w+') or die("Cannot open file");
	fwrite($fileHandle, $instruction);
	fclose($fileHandle);
}
