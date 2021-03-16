<?php
session_start();
include('../../config_database.php');
include('../../config_variable.php');
include('../../php_function.php');
include('../../phpFunction/onlineFunction.php');
//echo $_POST['action'];
if (isset($_POST['action'])) {
	if($_POST['action'] == 'sectionQuestionList') {
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
		$cpError="False"; $paramError = "False";
		//echo $array;
		for ($i = 0; $i < count($array["data"]); $i++) {
			$id = $array["data"][$i]["qb_id"];
			$qb_text = $array["data"][$i]["qb_text"];
			$tq_marks = $array["data"][$i]["tq_marks"];
			$tq_nmarks = $array["data"][$i]["tq_nmarks"];
			$qb_status = $array["data"][$i]["qb_status"];
			if ($qb_status == "0") {
				echo '<div class="card bg-light">
      	<div class="card-body mt-0 py-1">
				<div class="row">
				<div class="col">
				<span class="testQuestion">[Id:' . $id . ']' . $qb_text . '</span>';
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
						if($value==0)$paramError="True";
						echo '<div class="col-2 p-0">';
						echo '<input type="text" class="form-control form-control-sm parameter" data-qp="' . $ipc . '" data-tag="qp_step" data-qb="' . $id . '" value="' . $value . '">';
						echo '</div>';
						echo '</div>';
					}

					// Block for Check Points

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
						if($qc_marks==0)$cpError="True";
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
					$optionRows=$resultOption->num_rows;
					while ($rows = $resultOption->fetch_assoc()) {
						$correct = $rows["qo_correct"];
						$code = $rows["qo_code"];
						$qo_text = $rows["qo_text"];
						echo '<div class="row"><div class="col-9"><div class="card">
      			<div class="card-body m-0 p-1">
		  			<input type="text" class="form-control questionOption" id="option' . $code . '" value="' . $qo_text . '">
					</div>';
						echo '</div>';
						echo '</div>';
						echo '<div class="col-3 p-0">';
						echo '<a href="#" class="updateOption" data-qb="' . $id . '" data-code="' . $code . '"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';
						if ($correct == "0") echo '<a href="#" class="changeOption" data-qb="' . $id . '" data-code="' . $code . '" data-set="setRight"><i class="fa fa-times"></i></a>&nbsp;&nbsp;';
						else echo '<a href="#" class="changeOption" data-qb="' . $id . '" data-code="' . $code . '"  data-set="setWrong"><i class="fa fa-check"></i></a>&nbsp;&nbsp;';
						echo '<a href="#" class="uploadOption" title="Upload Option Image"><i class="fa fa-upload"></i></a>&nbsp;&nbsp;';
						echo '<a href="#" class="trashOption" data-qb="' . $id . '" data-sno="' . $code . '" data-tag="option"><i class="fa fa-trash"></i></a>';
						echo '</div>';
						echo '</div>';
					}
				}
				echo '<div class="row">
				<div class="col">';
				echo '<a href="#" class="editQuestion" data-qb="' . $qb_text . '"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;';
				echo '<a href="#" class="uploadQuestion" data-qb="' . $id . '" title="Upload Question Image"><i class="fa fa-upload"></i></a>&nbsp;&nbsp;';
				echo '<a href="#" class="trashQuestion" data-test="' . $id . '" data-section="' . $i . '"><i class="fa fa-trash"></i></a>&nbsp;&nbsp;';
				if($paramError=="True")echo "Parameter not Fixed!!";
				elseif($cpError=="True")echo "Please add atleast one Check Point with Marks!!!!";
				elseif($portion_count>1)echo "Upload key";
				elseif($optionRows<2) echo "Please Add atleast TWO Options";
				else echo "Add to Test";
				echo '</div>';
				echo '</div>';

				echo '</div></div>';
			} else {
				echo '<div class="card">
      	<div class="card-body mt-0 py-1">
				<div class="row">
				<div class="col">
				<span class="testQuestion">[' . $id . ']' . $qb_text . '</span>
				</div></div>
				<div class="row">
				<div class="col">
				<button class="btn btn-secondary btn-square-sm mt-0 activeQuestion" data-qb="' . $id . '">Active</button>
				<button class="btn btn-danger btn-square-sm mt-0 dropQuestion" data-qb="' . $id . '">Drop From Test</button>
				</div></div>
				</div></div>';
			}
		}
	}
}