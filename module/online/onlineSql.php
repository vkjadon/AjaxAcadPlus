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
			echo '</div><div class="col">';
			echo '<h6 class="text-muted py-1">Section : ' . $value . '</h6>
				</div></div>
				<div class="row">
				<div class="col">
				<button class="btn btn-info btn-square-sm mt-0 testInstruction" data-test="' . $id . '">Instructions</button>';
			for ($i = 1; $i <= $value; $i++) echo '<button class="btn btn-secondary btn-square-sm mt-0 sectionInstruction" data-test="' . $id . '" data-section="' . $i . '">Section-' . $i . '</button>';
			echo '<button class="btn btn-warning btn-square-sm mt-0 addQuestion" data-test="' . $id . '" title="Add Questions in the Test/Section" data-toggle="tooltip">Add Questions</button>';
			echo '</div></div>
				</div></div>';
		}
	} elseif ($_POST['action'] == 'addQuestion') {
		//$id = $_POST['id'];
		//echo "Jai ho";
	} elseif ($_POST['action'] == 'fetchInstruction') {
		$test_id = $_POST['testId'];
		$output = array();
		$folder = '../../' . $myFolder . '/test/' . $test_id;
		$fileName = $folder . '/instructions_test.txt';
		echo $fileName;
		// if (file_exists($fileName)) $content = file_get_contents($fileName);
		// else $content = "No File Found";
		// $output["content"] = $content;
		// echo json_encode($output);
	}
} elseif ($_POST['instructionId'] == 'T' || $_POST['instructionId'] == 'S') {
	$test_id = $_POST['testId'];
	$id = $_POST['instructionId'];
	$sectionId = $_POST['sectionId'];
	$instruction = $_POST['instruction'];
	echo "Jai ho $instruction Id $id";
	$folder = '../../' . $myFolder . '/test';
	if (!is_dir($folder)) mkdir($folder);
	$folder = '../../' . $myFolder . '/test/' . $test_id;
	echo $folder;
	if (!is_dir($folder)) mkdir($folder);
	if ($id == "T") $fileName = $folder . '/instructions_test.txt';
	else $fileName = $folder . '/instructions_section' . $sectionId . '.txt';
	echo $fileName;
	$fileHandle = fopen($fileName, 'w+') or die("Cannot open file");
	fwrite($fileHandle, $instruction);
	fclose($fileHandle);
}
echo '<script>
$(\'[data-toggle="tooltip"]\').tooltip()
</script>';
