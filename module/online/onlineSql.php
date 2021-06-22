<?php
require('../requireSubModule.php');

include('../../phpFunction/onlineFunction.php');
//echo $_POST['action'];
if (isset($_POST['action'])) {
	if ($_POST['action'] == 'addTest') {
		if (!$_POST['test_name'] == NULL) {
			$sql = "insert into test (test_name, test_section, test_status, update_id) values('" . $_POST['test_name'] . "','1', '1', '$myId')";
			$result = $conn->query($sql);
			if ($result) echo "Added Successfully";
			else {
				$error = $conn->errno;
				if ($error == "1062") echo "Duplicate Found";
			}
		} else echo "Test Name Cannot be Blank";
	} elseif ($_POST['action'] == 'testList') {
		$json = get_testListJson($conn, $myId);
		//echo $json;
		$array = json_decode($json, true);
		//echo $array;
		for ($i = 0; $i < count($array["data"]); $i++) {
			$id = $array["data"][$i]["test_id"];
			$test_name = $array["data"][$i]["test_name"];
			$test_section = $array["data"][$i]["test_section"];
			$test_status = $array["data"][$i]["test_status"];
			if ($test_status == "0") {
				echo '<div class="container card  myCard p-2 bg-light">
				<div class="row">
				<div class="col-10"><input class="form-control form-control-sm testName" data-test="' . $id . '" name="testName" value="' . $test_name . '" data-tag="test_name"><br>
				<h6 class="text-muted">Section : ';
				$sql = "select * from test where test_id='$id'";
				$value = getFieldValue($conn, "test_section", $sql);
				echo '<a href="#" class="decrement" id="' . $id . '" data-value="' . $value . '"><i class="fa fa-angle-double-left"></i></a>';
				echo '<span class="' . $id . '">' . $value . '</span>';
				echo '<a href="#" class="increment" id="' . $id . '" data-value="' . $value . '"><i class="fa fa-angle-double-right"></i></a></h6>
					</div><div class="col-2">
				<a class="mt-0 removeTestButton" data-test="' . $id . '"><i class="fa fa-trash"></i></a>
				</div>
				</div></div>';
			} else {
				echo '<div class="container card myCard mt-2 p-2">
				<div class="row">
				<div class="col-6">
				<h6>' . $test_name . '[' . $id . ']</h6>
				</div><div class="col-4">';
				$sql = "select * from test where test_id='$id'";
				$value = getFieldValue($conn, "test_section", $sql);
				echo '<h6 class="text-muted">Sec : ' . $value . '</h6>
					</div><div class="col-2">
					<button class="btn btn-sm mt-0 setActiveButton" data-test="' . $id . '" title="Make this Test Active" data-toggle="tooltip">Active</button>
				</div>
				</div></div>';
			}
		}
	} elseif ($_POST['action'] == 'increment') {
		$value = $_POST['value'] + 1;
		$id = $_POST['id'];
		//echo "Current Value " . $value;
		//echo "Current Id " . $id;
		updateField($conn, "test", array("test_id", "test_section"), array($id, $value), "");
	} elseif ($_POST['action'] == 'decrement') {
		$value = $_POST['value'] - 1;
		$id = $_POST['id'];
		if ($value > 0) updateField($conn, "test", array("test_id", "test_section"), array($id, $value), "");
	} elseif ($_POST['action'] == 'removeTest') {
		$id = $_POST['id'];
		//echo "Jai ho";
		updateField($conn, "test", array("test_id", "test_status"), array($id, "9"), "1");
	} elseif ($_POST['action'] == 'setActive') {
		$id = $_POST['id'];
		//echo "Jai ho";
		$sql = "update test set test_status='1' where test_status='0' and update_id='$myId'";
		$conn->query($sql);
		updateField($conn, "test", array("test_id", "test_status"), array($id, "0"), "1");
		$sql = "update question_bank set qb_status='1' where qb_status='0' and update_id='$myId'";
		$conn->query($sql);
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

		$sql = "insert into question_option (qb_id, qo_text, qo_code) values('$qb_id','$qo_text', '$max_sno')";
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
		$sql = "update question_bank set qb_status='1' where qb_id IN (select qb_id from test_question where test_id='$test_id')";
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
			echo '<div class="col-3">';
			echo '<div class="row">';
			echo '<div class="col p-0 m-1">';
			echo '<span class="topBarText p-0 m-0">Subject Topic</span>';
			echo '<input type="text" class="form-control form-control-sm subjectTopic" id="subjectTopic" name="subjectTopic" value="">';
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '<div class="col-3">
				<span class="topBarText p-0 m-0">+ Marks -</span>
				<div class="row">
					<div class="col p-0 m-1">
						<input type="text" class="form-control form-control-sm defaultMarks" id="defaultMarks" name="marks" value="4">
					</div>
					<div class="col p-0 m-1">
						<input type="text" class="form-control form-control-sm defaultNMarks" id="defaultNMarks" name="nmarks" value="0">
					</div>
				</div>
			</div>';

			echo '<div class="col-3 text-center">';
			echo '<span class="topBarText p-0 m-0">Sections</span>';
			echo '<div class="row">';
			echo '<div class="col p-0 m-1 text-center">';
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
