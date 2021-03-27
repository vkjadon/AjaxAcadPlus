<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
include('../../phpFunction/onlineFunction.php');
//echo $_POST['action'];
if (isset($_POST['action'])) {
	if ($_POST['action'] == 'activeQuestion') {
		$sql = "select * from test where test_status='0' and submit_id='$myId'";
		$result = $conn->query($sql);
		if ($result) {
			$array = $result->fetch_assoc();
			$test_id = $array["test_id"];
		}
		//echo "Test Id $test_id";
		$sectionId = $_POST['sectionId'];
		$json = get_activeQuestionJson($conn, $test_id, $sectionId);
		//echo $json;
		$array = json_decode($json, true);
		$cpError = "False";
		$paramError = "False";
		$optionError = "True";
		$cpKeyError = "False";
		//echo $array;
		for ($i = 0; $i < count($array["data"]); $i++) {
			$id = $array["data"][$i]["qb_id"];
			$tq_marks = $array["data"][$i]["tq_marks"];
			$tq_nmarks = $array["data"][$i]["tq_nmarks"];
			$tq_status = $array["data"][$i]["tq_status"];
			$qb_text = $array["data"][$i]["qb_text"];
			$qb_image = $array["data"][$i]["qb_image"];

			// $fileName='../../olat/text/ques-'.$id.'.txt';
			// if (file_exists($fileName)) $qb_text = file_get_contents($fileName);
			// else $qb_text = "No File Found";
			echo '<h5>Question Edit Panel</h5>';
			echo '<div class="card bg-light">
      	<div class="card-body mt-2 py-1">
				<div class="row">
				<div class="col">
				<textarea rows="4" class="testQuestionText testQuestionUpdate" data-qb="' . $id . '" id="uq" data-tag="qb_text">' . $qb_text . '</textarea>';
			if (strlen($qb_image) > 5) echo '<img src="../../olat/img/' . $qb_image . '">';

			echo '</div></div>';

			// Block for Variable Data Question

			$portion = explode("***", $qb_text);
			$portion_count = count($portion);
			if ($portion_count > 1) {
				echo "<h6>Update Vaiable Input Parameters</h6>";
				echo '<div class="row">';
				echo '<div class="col-4"><span class="topBarText"> Parameter Name</span></div>';
				echo '<div class="col-2"><span class="topBarText"> Min </span></div>';
				echo '<div class="col-2"><span class="topBarText"> Max </span></div>';
				echo '<div class="col-2"><span class="topBarText"> Step </span></div>';
				echo '</div>';
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
				$fileName = '../../olat/cp/cp-' . $id . '.php';
				if (!file_exists($fileName)) $cpKeyError = "True";
				echo '<div class="row">
					<div class="col-6 p-0"><h6 class="ml-0 mt-2 mb-0 p-0">Check Points</h6></div>
					<div class="col-2 p-0"><h6 class="ml-0 mt-2 mb-0 p-0">Marks</h6></div>
					<div class="col-2 p-0"><h6 class="ml-0 mt-2 mb-0 p-0">Range(%)</h6></div>
					</div>';
				$sqlCP = "select * from qb_cp where qb_id='$id' order by qc_sno";
				$resultCP = $conn->query($sqlCP);
				while ($rows = $resultCP->fetch_assoc()) {
					$qc_name = $rows["qc_name"];
					$qc_marks = $rows["qc_marks"];
					$qc_range = $rows["qc_range"];
					$qc_sno = $rows["qc_sno"];
					if ($qc_marks == 0) $cpError = "True";
					echo '<div class="row"><div class="col-6 p-0">
						<input type="text" class="form-control form-control-sm checkPoint" data-qb="' . $id . '"  data-sno="' . $qc_sno . '" data-tag="qc_name" value="' . $qc_name . '">
						</div>
						<div class="col-2 p-0">
						<input type="text" class="form-control form-control-sm checkPoint" data-qb="' . $id . '"  data-sno="' . $qc_sno . '" data-tag="qc_marks" value="' . $qc_marks . '">
						</div>
						<div class="col-2 p-0">
						<input type="text" class="form-control form-control-sm checkPoint" data-qb="' . $id . '"  data-sno="' . $qc_sno . '" data-tag="qc_range" value="' . $qc_range . '">
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
					$code = $rows["qo_code"];
					$qo_image = $rows["qo_image"];
					$qo_text = $rows["qo_text"];
					echo '<div class="row"><div class="col-9"><div class="card">
      			<div class="card-body m-0 p-1">
		  			<input type="text" class="form-control questionOption" data-qb="' . $id . '" data-code="' . $code . '" data-tag="qo_text" value="' . $qo_text . '">';
					if (strlen($qo_image) > 5) echo '<img src="../../olat/img/' . $qo_image . '">';
					echo '</div>';
					echo '</div>';
					echo '</div>';
					echo '<div class="col-3 p-0">';
					if ($correct == "0") echo '<a href="#" class="changeOption" data-qb="' . $id . '" data-code="' . $code . '" data-set="setRight"><i class="fa fa-times"></i></a>&nbsp;&nbsp;';
					else {
						$optionError = "False";
						echo '<a href="#" class="changeOption" data-qb="' . $id . '" data-code="' . $code . '"  data-set="setWrong"><i class="fa fa-check"></i></a>&nbsp;&nbsp;';
					}
					echo '<a href="#" class="uploadOptionImage" data-upload="' . $id . '" data-sno="' . $code . '" data-tag="optionImage" title="Upload Option Image"><i class="fa fa-upload"></i></a>&nbsp;&nbsp;';
					echo '<a href="#" class="trashOption" data-qb="' . $id . '" data-sno="' . $code . '" data-tag="option"><i class="fa fa-trash"></i></a>';
					echo '</div>';
					echo '</div>';
				}
				echo '<div class="row">
					<div class="col-9"><div class="card">
					<div class="card-body m-0 p-1">
					<input type="text" class="form-control form-control-sm" id="newOption" ></div>
					</div></div>
					<div class="col-3 mt-1">
					<a href="#" class="addOption" data-qb="' . $id . '"><i class="fa fa-plus"></i>New Option</a>					
					</div>
					</div>';
			}
			$addToTestEroor = "False";
			if ($portion_count > 1) {
				if ($paramError == "True") {
					echo '<span class="warning"><i class="fa fa-exclamation-triangle"></i>Parameter not Fixed!!</span>';
					$addToTestEroor = "True";
				} elseif ($cpError == "True") {
					echo '<span class="warning"><i class="fa fa-exclamation-triangle"></i>Please add atleast one Check Point with Marks!!</span>';
					$addToTestEroor = "True";
				}
			} else {
				if ($optionRows < 2) {
					$addToTestEroor = "True";
					echo '<i class="fa fa-exclamation-triangle"></i><span class="warning">Please Add atleast TWO Options!!</span>';
				} elseif ($optionError == "True") {
					echo '<i class="fa fa-exclamation-triangle"></i><span class="warning">Set atleast ONE Option right!!</span>';
					$addToTestEroor = "True";
				}
			}
			echo '<div class="row">
				<div class="col-10">';
				if ($portion_count > 1)echo '<button class="btn btn-warning btn-square-sm m-0 uploadKeyFile" data-upload="' . $id . '" data-tag="keyFile">Upload Key File</button>&nbsp;&nbsp;';
			echo '<a href="#" class="uploadQuestionImage" data-upload="' . $id . '" data-tag="questionImage" title="Upload Question Image"><i class="fa fa-upload"></i></a>&nbsp;&nbsp;';
			
			if ($cpKeyError == "True") {
				echo '<span class="warning"><i class="fa fa-exclamation-triangle"> Key File Missing !! </i></soan>';
				$addToTestEroor = "True";
			}

			if ($tq_status == 1 && $addToTestEroor == "False") echo '<button class="btn btn-info btn-square-sm mt-0 testQuestion" data-test="' . $test_id . '" data-qb="' . $id . '" data-tag="qtt">Add To Test</button>';
			echo '</div>';

			if ($tq_status == "1") echo '<div class="col-2"><h6 class="p-1 mb-1 bg-danger text-light text-center small">Draft</h6></div>';
			elseif ($tq_status == "2") echo '<div class="col-2"><h6 class="p-1 mb-1 bg-success text-light text-center small">Added</h6></div>';
			echo '</div>';
			echo '</div></div>';
		}
	} elseif ($_POST['action'] == 'sectionQuestionList') {
		$sql = "select * from test where test_status='0' and submit_id='$myId'";
		$result = $conn->query($sql);
		if ($result) {
			$array = $result->fetch_assoc();
			$test_id = $array["test_id"];
		}
		//echo "Test Id $test_id";
		$sectionId = $_POST['sectionId'];
		$json = get_sectionQuestionListJson($conn, $test_id, $sectionId);
		//echo $json;
		$array = json_decode($json, true);
		$cpError = "False";
		$paramError = "False";
		//echo $array;
		for ($i = 0; $i < count($array["data"]); $i++) {
			$id = $array["data"][$i]["qb_id"];
			$qb_text = $array["data"][$i]["qb_text"];
			$qb_image = $array["data"][$i]["qb_image"];
			$tq_marks = $array["data"][$i]["tq_marks"];
			$tq_nmarks = $array["data"][$i]["tq_nmarks"];
			$qb_status = $array["data"][$i]["qb_status"];
			$tq_status = $array["data"][$i]["tq_status"];

			// $fileName='../../olat/text/ques-'.$id.'.txt';
			// if (file_exists($fileName)) $qb_text = file_get_contents($fileName);
			// else $qb_text = "No File Found";

			$portion = explode("***", $qb_text);
			$portion_count = count($portion);
			if ($portion_count > 1) {
				echo '<div class="card">
				<div class="card-body mt-0 py-1">
				<div class="row">
				<div class="col-1"><span>' . ($i + 1) . '[' . $id . ']</span><br>';
				echo '<a href="#" class="trashQuestion" data-sno="' . $test_id . '" data-qb="' . $id . '" data-tag="tq"><i class="fa fa-trash"></i></a>&nbsp;&nbsp;';
				echo '</div>';
				echo '<div class="col-9">';
				for ($ip = 0; $ip < $portion_count; $ip++) {
					$sno = $ip + 1;
					$sql = "select * from qb_parameter where qb_id='$id' and qp_sno='$sno'";
					$abp[$ip] = getFieldValue($conn, "qp_min", $sql);
					echo '<span class="testQuestionText">' . $portion[$ip] . '</span>';
					if ($sno < $portion_count) echo $abp[$ip]; //to avoid last print (NULL)
				}
				$solution = 'Y';
				$fileName = '../../olat/cp/cp-' . $id . '.php';
				if (file_exists($fileName)) require($fileName);
				else echo '<span class="warning"><i class="fa fa-exclamation-triangle"> Key File Missing !! </i></soan>';
				echo '</div>';
				echo '<div class="col">';
				if ($qb_status > 0) echo '<button class="btn btn-secondary btn-square-sm mt-0 activeQuestion" data-qb="' . $id . '">Set Active</button>';
				else echo '<span class="warning">Active</span>';
				if ($tq_status == 1) echo '<p class="text-info">Draft</p>';
				else echo '<p class="text-success">Added</p>';
				echo '</div></div>';
				echo '<a href="#" class="trashQuestion" data-sno="' . $test_id . '" data-qb="' . $id . '" data-tag="tq"><i class="fa fa-trash"></i></a>&nbsp;&nbsp;';

				echo '</div></div>';
			} else {
				echo '<div class="card">
      	<div class="card-body mt-0 py-1">
				<div class="row">
				<div class="col-1"><span>' . ($i + 1) . '[' . $id . ']</span><br>';
				echo '<a href="#" class="trashQuestion" data-sno="' . $test_id . '" data-qb="' . $id . '" data-tag="tq"><i class="fa fa-trash"></i></a>&nbsp;&nbsp;';
				echo '</div>';
				echo '<div class="col-9">
				<span class="testQuestionText">' . $qb_text . '</span>';
				if (strlen($qb_image) > 5) echo '<p><img src="../../olat/img/' . $qb_image . '"></p>';
				echo '</div>';
				echo '<div class="col">';
				if ($qb_status > 0) echo '<button class="btn btn-secondary btn-square-sm mt-0 activeQuestion" data-qb="' . $id . '">Set Active</button>';
				else echo '<span class="warning">Active</span>';
				if ($tq_status == 1) echo '<p class="text-info">Draft</p>';
				else echo '<p class="text-success">Added</p>';
				echo '</div></div>';
				echo '</div></div>';
			}
		}
	} elseif ($_POST['action'] == 'testQuestion') {
		$qb_id = $_POST['qb_id'];
		$test_id = $_POST['test_id'];
		$tag = $_POST['tag'];
		//echo "Jai ho $qb_id";
		$sql = "update test_question set tq_status='2' where qb_id='$qb_id' and test_id='$test_id'";
		$result = $conn->query($sql);
		if ($result) echo "Updated Successfully";
		else echo $conn->error;
	} elseif ($_POST['action'] == 'questionLibrary') {
		$test_id='1';
		$sql="select * from question_bank where submit_id='$myId' and qb_status<'9' and qb_id NOT IN (select qb_id from test_question where test_id=".$test_id.") order by qb_id desc";
		$json = getTableRow($conn, $sql, array("qb_id", "qb_text", "qb_image", "qb_status"));
		//echo $json;
		$array = json_decode($json, true);
		$cpError = "False";
		$paramError = "False";
		//echo $array;
		for ($i = 0; $i < count($array["data"]); $i++) {
			$id = $array["data"][$i]["qb_id"];
			$qb_text = $array["data"][$i]["qb_text"];
			$qb_image = $array["data"][$i]["qb_image"];
			$qb_status = $array["data"][$i]["qb_status"];

			$portion = explode("***", $qb_text);
			$portion_count = count($portion);
			if ($portion_count > 1) {
				echo '<div class="card">
				<div class="card-body mt-0 py-1">
				<div class="row">
				<div class="col-1"><span>' . ($i + 1) . '[' . $id . ']</span></div>
				<div class="col-10">';
				for ($ip = 0; $ip < $portion_count; $ip++) {
					$sno = $ip + 1;
					$sql = "select * from qb_parameter where qb_id='$id' and qp_sno='$sno'";
					$abp[$ip] = getFieldValue($conn, "qp_min", $sql);
					echo '<span class="testQuestionText">' . $portion[$ip] . '</span>';
					if ($sno < $portion_count) echo $abp[$ip]; //to avoid last print (NULL)
				}
				if (strlen($qb_image) > 5) echo '<p><img src="../../olat/img/' . $qb_image . '"></p>';
				$solution = 'Y';
				$fileName = '../../olat/cp/cp-' . $id . '.php';
				if (!file_exists($fileName))echo '<span class="warning"><i class="fa fa-exclamation-triangle"> Key File Missing !! </i></soan>';
				echo '</div>';
				echo '<div class="col">';
				echo '<button class="btn btn-secondary btn-square-sm mt-0 addQuestionToTest" data-qb="' . $id . '">Add to Test</button>';
				echo '</div></div>';
				echo '</div></div>';
			} else {
				echo '<div class="card">
      	<div class="card-body mt-0 py-1">
				<div class="row">
				<div class="col-1"><span>' . ($i + 1) . '[' . $id . ']</span></div>
				<div class="col-10">
				<span class="testQuestionText">' . $qb_text . '</span>';
				if (strlen($qb_image) > 5) echo '<p><img src="../../olat/img/' . $qb_image . '"></p>';
				echo '</div>';
				echo '<div class="col">';
				echo '<button class="btn btn-secondary btn-square-sm mt-0 addQuestionToTest" data-qb="' . $id . '">Add to Test</button>';
				echo '</div></div>';
				echo '</div></div>';
			}
		}
	} elseif ($_POST['action'] == 'addLibraryQuestionToTest') {
		$sql = "select * from test where test_status='0' and submit_id='$myId'";
		$result = $conn->query($sql);
		if ($result) {
			$array = $result->fetch_assoc();
			$test_id = $array["test_id"];
		}
		$qb_id = $_POST['qb_id'];
		$test_section = $_POST['test_section'];
		//echo "Jai ho $qb_id";
		$sql = "insert into test_question (test_id, test_section, qb_id, tq_marks, tq_nmarks, tq_status) values('$test_id', '$test_section', '$qb_id', '4', '0', '1')";
		$result = $conn->query($sql);
		if ($result) echo "Updated Successfully";
		else echo $conn->error;
	}
}