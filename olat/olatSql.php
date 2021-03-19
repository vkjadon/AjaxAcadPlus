<?php
session_start();
include('../config_database.php');
include('../config_variable.php');
include('../php_function.php');
include('../phpFunction/onlineFunction.php');
//echo $_POST['action'];
if (isset($_POST['action'])) {
	if ($_POST['action'] == 'testHeading') {
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
				<div class="col-6">
				<h6>' . $test_name . '[' . $id . ']</h6>';
			$sql = "select * from test where test_id='$id'";
			$value = getFieldValue($conn, "test_section", $sql);
			echo '</div>';
			echo '</div>';
			$fileName = '../demo/test/' . $id . '/instructions_test.txt';
			if (file_exists($fileName)) $content = file_get_contents($fileName);
			else $content = "No File Found";
			echo $content;
			echo '</div></div>';
			for ($i = 1; $i <= $test_section; $i++) {
				$sql = "select sum(tq_marks) as sum from test_question where test_id='$id' and test_section='$i'";
				$value = getFieldValue($conn, "sum", $sql);
				echo '<div class="card">
      	<div class="card-body mt-0 py-1">
				<div class="row">';
				echo '<div class="col-6"><h6 class="text-muted py-1">Section : ' . $i . '</h6></div>';
				echo '<div class="col-3"><h6 class="text-muted py-1">Marks : ' . $value . '</h6></div>';
				echo '</div>';
				$fileName = '../demo/test/' . $id . '/instructions_section' . $i . '.txt';
				if (file_exists($fileName)) $content = file_get_contents($fileName);
				else $content = "No File Found";
				echo $content;
				echo '</div></div>';
			}
		}
	}
	if ($_POST['action'] == 'testQuestionList') {
		$id = $_POST["test_id"];
		echo "Test $id";
		$sql = "select * from test where test_id='$id'";
		$result = $conn->query($sql);
		if ($result) {
			$array = $result->fetch_assoc();
			$test_id = $array["test_id"];
			$test_name = $array["test_name"];
			$test_section = $array["test_section"];
			$test_status = $array["test_status"];
			echo '<div class="card">
      	<div class="card-body mt-0 py-1">
				<div class="row">
				<div class="col-6">	<h6>' . $test_name . '[' . $test_id . ']</h6>';
			echo '</div>';
			echo '</div>';
			echo '</div></div>';
			for ($its = 1; $its <= $test_section; $its++) {
				echo '<div class="card">
      		<div class="card-body mt-0 py-1">
					<div class="row">';
				echo '<h6>Section - ' . $its . '</h6>';
				echo '</div>';
				echo '</div></div>';
				$json = get_testQuestionListJson($conn, $test_id, $its);
				//echo $json;
				$array = json_decode($json, true);
				echo '<div class="card">
				<div class="card-body mt-0 py-1">';

				for ($i = 0; $i < count($array["data"]); $i++) {
					$id = $array["data"][$i]["qb_id"];
					//$qb_text = $array["data"][$i]["qb_text"];
					$tq_marks = $array["data"][$i]["tq_marks"];
					$tq_nmarks = $array["data"][$i]["tq_nmarks"];

					$fileName = 'text/ques-' . $id . '.txt';
					if (file_exists($fileName)) $qb_text = file_get_contents($fileName);
					else $qb_text = "No File Found";
					echo '<div class="row p-1">';
					echo '<div class="col-1">';
					echo $i;
					echo '</div>';
					echo '<div class="col-9 bg-light">';
					echo $qb_text;
					echo '</div>';
					echo '</div>';
				}
				echo '</div></div>';
			}
		}
	}
}
