<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
include('../../phpFunction/onlineFunction.php');
//echo $_POST['action'];
if (isset($_POST['action'])) {
	if ($_POST['action'] == 'addTest') {
		if (!$_POST['test_name'] == NULL) {
			$sql = "insert into test (test_name, test_section, test_status, submit_id) values('" . $_POST['test_name'] . "','1', '1', '$myId')";
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
				echo '<div class="card bg-light">
      	<div class="card-body mt-0 py-1">
				<div class="row">
				<div class="col">
				<h6>' . $test_name . '[' . $id . ']</h6>
				</div><div class="col">
				<h6 class="text-muted py-1">Section : ';
				$sql = "select * from test where test_id='$id'";
				$value = getFieldValue($conn, "test_section", $sql);
				echo '<a href="#" class="decrement" id="' . $id . '" data-value="' . $value . '"><i class="fa fa-angle-double-left"></i></a>';
				echo '<span class="' . $id . '">' . $value . '</span>';
				echo '<a href="#" class="increment" id="' . $id . '" data-value="' . $value . '"><i class="fa fa-angle-double-right"></i></a></h6>
					</div><div class="col">
				<button class="btn btn-danger btn-square-sm mt-0 removeTestButton" data-test="' . $id . '" title="Remove Test" data-toggle="tooltip"><i class="fa fa-trash"></i></button>';
				echo '<button class="btn btn-info btn-square-sm mt-0 addQuestionButton" data-test="' . $id . '" title="Add Test Questions" data-toggle="tooltip"><i class="fa fa-question-circle"></i></button>';
				echo '<button class="btn btn-secondary btn-square-sm mt-0 addUserButton" data-test="' . $id . '" title="Add User" data-toggle="tooltip"><i class="fa fa-user"></i></button>
					</div></div>
				</div></div>';
			} else {
				echo '<div class="card">
      	<div class="card-body mt-0 py-1">
				<div class="row">
				<div class="col">
				<h6>' . $test_name . '[' . $id . ']</h6>
				</div><div class="col">';
				$sql = "select * from test where test_id='$id'";
				$value = getFieldValue($conn, "test_section", $sql);
				echo '<h6 class="text-muted py-1">Section : ' . $value . '</h6>
					</div><div class="col">
					<button class="btn btn-secondary btn-square-sm mt-0 setActiveButton" data-test="' . $id . '" title="Make this Test Active" data-toggle="tooltip">Set Active</button>
				</div></div>

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
		$sql = "update test set test_status='1' where test_status='0' and submit_id='$myId'";
		$conn->query($sql);
		updateField($conn, "test", array("test_id", "test_status"), array($id, "0"), "1");
	} elseif ($_POST['action'] == 'testHeading') {
		$sql = "select * from test where test_status='0' and submit_id='$myId'";
		$result = $conn->query($sql);
		if ($result) {
			$array = $result->fetch_assoc();
			$id = $array["test_id"];
			$test_name = $array["test_name"];
			$test_section = $array["test_section"];
			$test_status = $array["test_status"];
			echo '<div class="card">
      	<div class="card-body mt-0 py-1">
				<div class="row">
				<div class="col">
				<h6>' . $test_name . '[' . $id . ']</h6>';
			$sql = "select * from test where test_id='$id'";
			$value = getFieldValue($conn, "test_section", $sql);
			echo '</div>';
			echo '<div class="col"><h6 class="text-muted py-1">Section : ' . $value . '</h6></div>';
			echo '<div class="col-3"><button class="btn btn-info btn-square-sm mt-0 testInstruction" data-test="' . $id . '">Instructions</button></div>';
			echo '</div>';
			echo '</div></div>';
			for ($i = 1; $i <= $test_section; $i++) {
				$sql = "select sum(tq_marks) as sum from test_question where test_id='$id' and test_section='$i'";
				$value = getFieldValue($conn, "sum", $sql);
				echo '<div class="card">
      	<div class="card-body mt-0 py-1">
				<div class="row">';
				echo '<div class="col"><h6 class="text-muted py-1">Section : ' . $i . '</h6></div>';
				echo '<div class="col"><h6 class="text-muted py-1">Marks : ' . $value . '</h6></div>';
				echo '<div class="col"><button class="btn btn-secondary btn-square-sm mt-0 sectionInstruction" data-test="' . $id . '" data-section="' . $i . '">Instructions</button></div>';
				echo '</div>';
				echo '</div></div>';
			}
		}
	} elseif ($_POST['action'] == 'addQuestion') {
		$test_id = $_POST['testId'];
		$sectionId = $_POST['sectionId'];
		$question = $_POST['question'];
		$sql = "insert into question_bank (qb_level, qb_base, qb_text, submit_id, qb_status) values('1', '1', '" . $question . "','$myId', '0')";
		$result = $conn->query($sql);
		if ($result) {
			echo "Added Successfully";
			$insertId = $conn->insert_id;
			$sql = "insert into test_question (test_id, test_section, qb_id, tq_marks, tq_nmarks) values('$test_id', '$sectionId', '$insertId', '4', '0')";
			$result = $conn->query($sql);
			if (!$result) echo $conn->error;
		} else {
			$error = $conn->errno;
			if ($error == "1062") echo "Duplicate Found !!!";
		}
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
		$sql = "select * from test where test_status='0' and submit_id='$myId'";
		$result = $conn->query($sql);
		if ($result) {
			$array = $result->fetch_assoc();
			$id = $array["test_id"];
			$test_name = $array["test_name"];
			$test_section = $array["test_section"];
			$test_status = $array["test_status"];
			if(isset($_POST['section']))$section=$_POST['section'];
			else $section='1';
			if(isset($_POST['marks']))$marks=$_POST['marks'];
			else $marks='0';
			if(isset($_POST['nmarks']))$nmarks=$_POST['nmarks'];
			else $nmarks='0';
			echo '<div class="card">
      	<div class="card-body mt-0 py-1">
				<div class="row">';
			echo '<div class="col"><h6>' . $test_name . '[' . $id . ']</h6>';
			echo 'Section : ';
			for($i=1; $i<=$test_section;$i++){
				echo '<button class="btn btn-warning btn-square-sm mt-0 defaultSection" id="defaultSection'.$i.'" data-section="' . $i . '">'.$i.'</button>';
			}
			echo '</div>';
			echo '<div class="col-2"><span class="topBarText">Marks(+)</span><input type="text" class="form-control form-control-sm defaultMarks w-50" id="defaultMarks" name="marks" value="4"></div>';
			echo '<div class="col-2"><span class="topBarText">Marks(-)</span><input type="text" class="form-control form-control-sm defaultNMarks w-50" id="defaultNMarks" name="nmarks" value="0"></div>';
			echo '</div>';
			echo '</div></div>';
		}
	} elseif ($_POST['action'] == 'fetchQuestion') {
		$test_id = $_POST['testId'];
		$section = $_POST['sectionId'];
		$sql = "SELECT qb.* FROM test_question tq, question_bank qb where tq.test_id='$test_id' and tq.test_section='$section' and tq.qb_id=qb.qb_id";
		$result = $conn->query($sql);
		if ($result) $output = $result->fetch_assoc();
		else $output = array("qb_text" => "Please write/paste your Question Here");
		echo json_encode($output);
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
