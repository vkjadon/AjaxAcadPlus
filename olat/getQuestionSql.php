<?php
session_start();
include('../config_database.php');
include('../config_variable.php');
include('../php_function.php');
include('../phpFunction/onlineFunction.php');
//echo $_POST['action'];
if ($_POST['action'] == 'getQuestion') {
	$test_id = $_POST["test_id"];
	$qb_id = $_POST["qb_id"];
	//echo "Test $test_id CQ $qb_id ";

	$json = get_questionJson($conn, $test_id, $qb_id);
	//echo $json;
	$array = json_decode($json, true);
	echo '<div class="card">
	<div class="card-body mt-0 py-1">';

	$id = $array["data"][0]["qb_id"];
	$tq_marks = $array["data"][0]["tq_marks"];
	$tq_nmarks = $array["data"][0]["tq_nmarks"];
	$fileName = 'text/ques-' . $id . '.txt';
	if (file_exists($fileName)) $qb_text = file_get_contents($fileName);
	else $qb_text = "No File Found";
	echo '<div class="row p-1">';
	echo '<div class="col-1 p-0 m-0">Ques</div>';
	echo '<div class="col-11 p-0 m-0 bg-light">';
	echo $qb_text;
	echo '</div></div>';
	$portion = explode("***", $qb_text);
	$portion_count = count($portion);
	if ($portion_count > 1) {

		for ($ipc = 1; $ipc < $portion_count; $ipc++) {
			$sql = "select * from qb_parameter where qb_id='$id' and qp_sno='$ipc'";
			$value = getFieldValue($conn, "qp_name", $sql);
			echo '<div class="row">';
			echo '<div class="col-4 p-0">';
			echo '<input type="text" class="form-control form-control-sm parameter" data-qp="' . $ipc . '" data-tag="qp_name" data-qb="' . $id . '" value="' . $value . '">';
			echo '</div>';
			$value = getFieldValue($conn, "qp_min", $sql);
			echo '<div class="col-2 p-0">';
			echo '<input type="text" class="form-control form-control-sm parameter" data-qp="' . $ipc . '" data-tag="qp_min" data-qb="' . $id . '" value="' . $value . '">';
			echo '</div>';
			$value = getFieldValue($conn, "qp_max", $sql);
			echo '<div class="col-2 p-0">';
			echo '<input type="text" class="form-control form-control-sm parameter" data-qp="' . $ipc . '" data-tag="qp_max" data-qb="' . $id . '" value="' . $value . '">';
			echo '</div>';
			$value = getFieldValue($conn, "qp_step", $sql);
			if ($value == 0) $paramError = "True";
			echo '<div class="col-2 p-0">';
			echo '<input type="text" class="form-control form-control-sm parameter" data-qp="' . $ipc . '" data-tag="qp_step" data-qb="' . $id . '" value="' . $value . '">';
			echo '</div>';
			echo '</div>';
		}

		// Block for Check Points
		$fileName = 'cp/cp-' . $id . '.php';
		if (!file_exists($fileName)) $cpKeyError = "True";
		echo '<div class="row">
					<div class="col-8 p-0"><h6 class="ml-0 mt-2 mb-0 p-0">Check Points</h6></div>
					<div class="col-2 p-0"><h6 class="ml-0 mt-2 mb-0 p-0">Marks</h6></div>
					</div>';
		$sqlCP = "select * from qb_cp where qb_id='$id' order by qc_sno";
		$resultCP = $conn->query($sqlCP);
		while ($rows = $resultCP->fetch_assoc()) {
			$qc_name = $rows["qc_name"];
			$qc_marks = $rows["qc_marks"];
			$qc_sno = $rows["qc_sno"];
			if ($qc_marks == 0) $cpError = "True";
			echo '<div class="row"><div class="col-8 p-0">
						<input type="text" class="form-control form-control-sm checkPoint" data-qb="' . $id . '"  data-sno="' . $qc_sno . '" data-tag="qc_name" value="' . $qc_name . '">
						</div>
						<div class="col-2 p-0">
						<input type="text" class="form-control form-control-sm checkPoint" data-qb="' . $id . '"  data-sno="' . $qc_sno . '" data-tag="qc_marks" value="' . $qc_marks . '">
						</div>
						<div class="col-2 p-0">&nbsp;
						<a href="#" class="trashCP" data-sno="' . $qc_sno . '" data-qb="' . $id . '" data-tag="cp"><i class="fa fa-trash"></i></a>
						</div>
						</div>';
		}
		if (!isset($qc_marks)) {
			echo "No Check Point added";
			$cpError = "True";
			$qc_sno = 1;
		} else $qc_sno++;
		echo '<div class="row">
					<div class="col-8 p-0">
					<h6 class="ml-0 mt-2 mb-0 p-0">Add New Check Point</h6>
					<input type="text" class="form-control form-control-sm" id="newCP" ></div>
					<div class="col-2 p-0">
					<h6 class="ml-0 mt-2 mb-0 p-0">Marks</h6>
					<input type="text" class="form-control form-control-sm" id="newCPMarks" ></div>
					<div class="col-2 p-0"><br>&nbsp;
					<a href="#" class="addCheckPoint" data-sno="' . $qc_sno . '" data-qb="' . $id . '"><i class="fa fa-plus"></i></a>
					</div>
					</div>';
	} else {
		$sqlOption = "select * from question_option where qb_id='$id' order by qo_code";
		$resultOption = $conn->query($sqlOption);
		$optionRows = $resultOption->num_rows;
		while ($rows = $resultOption->fetch_assoc()) {
			$correct = $rows["qo_correct"];
			$qo_code = $rows["qo_code"];
			$qo_text = $rows["qo_text"];
			echo '<div class="row p-1">';
			echo '<div class="col-1 p-0"><span class="check" id="'.$qo_code.'"></span></div>';
			echo '<div class="col-11 p-0">';
			echo '<a href="#" class="list-group-item list-group-item-action markOption" data-qb="' . $id . '" data-code="' . $qo_code . '">' . $qo_text . '</a>';
			echo '</div>';
			echo '</div>';
		}
	}
	echo '<div class="row p-1">';

	echo '<div class="col-1 p-0"><span class="check"></span></div>';
	echo '<div class="col-9 p-0">';
	echo '<button class="btn btn-info btn-square-sm submitOption">Submit</button>';
	echo '</div>';
	echo '<div class="col-2 p-0">';
	echo '<button class="btn btn-success btn-square-sm">Next >> </button>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
}elseif ($_POST['action'] == 'submitOption') {
	$qb_id = $_POST["qb_id"];
	$qb_code=$_POST['qo_code'];
	echo $jsonText=$_POST['jsonText'];
	
}
