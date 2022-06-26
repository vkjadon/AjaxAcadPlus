<?php
require('../requireSubModule.php');

//echo $_POST['action'];
if (isset($_POST['action'])) {
	if ($_POST['action'] == 'addTemplate') {
		$sql = "insert into $tn_atmp (am_id, at_id, atmp_template, atmp_weightage, atmp_internal, update_id, atmp_status) values('" . data_check($_POST['sel_ac']) . "', '" . data_check($_POST['sel_at']) . "', '" . data_check($_POST['sel_template']) . "', '" . data_check($_POST['weightage']) . "', '" . data_check($_POST['internal']) . "', '$myId','0')";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		echo "Added";
	} elseif ($_POST['action'] == 'selectTemplate') {
		$sql = "select * from $tn_atmp where atmp_status='0' group by atmp_template order by atmp_template";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		$i = 1;
		echo '<select class="form-control form-control-sm" id="sel_template" name="sel_template" required>';
		//echo '<option>Select a Template</option>';
		while ($rowsArray = $result->fetch_assoc()) {
			$id = $rowsArray["atmp_template"];
			echo '<option value="' . $id . '">Template-' . $i++ . '</option>';
		}
		echo '<option value="' . $i . '">New Template</option>';
		echo '</select>';
	} elseif ($_POST['action'] == 'atmpList') {
		$totalTemplates = getMaxField($conn, $tn_atmp, "atmp_template");
		//echo $totalTemplates;
		for ($i = 1; $i <= $totalTemplates; $i++) {
			$sql = "select * from $tn_atmp where atmp_template='$i' order by am_id";
			$result = $conn->query($sql);
			if (!$result) echo $conn->error;
			echo '<div class="row">';
			echo '<div class="col-sm-2 m-0 p-1">';
			echo '<div class="card myCard m-2 text-center">';
			echo '<h4">Template-' . $i . '</h4>';
			echo '</div>';
			echo '</div>';
			while ($rowsArray = $result->fetch_assoc()) {
				$status = $rowsArray["atmp_status"];
				$internal = $rowsArray["atmp_internal"];
				$ac = getField($conn, $rowsArray["am_id"], "master_name", "mn_id", "mn_name");
				$at = getField($conn, $rowsArray["at_id"], "master_name", "mn_id", "mn_name");
				//echo $ac.'-'.$at;
				echo '<div class="col m-1 p-0">';
				echo '<div class="card myCard">';
				echo '<div class="row p-1">';
				echo '<div class="col-8 xsText">' . $ac . '</div>';
				echo '<div class="col-4 smallText m-0">' . $rowsArray["atmp_weightage"] . '</div>';
				echo '</div>';
				echo '<div class="row p-1">';
				echo '<div class="col-8 xsText">' . $at . '</div>';
				if ($internal == 'internal') echo '<div class="col-4 smallText m-0">I</div>';
				else echo '<div class="col-4 smallText m-0">E</div>';
				echo '</div>';
				echo '<div class="row">';
				echo '<div class="col ml-2">';
				echo '<a href="#" class="float-left rp_idE" data-id="' . $rowsArray["am_id"] . '"><i class="fa fa-edit"></i></a>';
				if ($status == "9") echo '<a href="#" class="float-right rp_idR" data-id="' . $rowsArray["am_id"] . '"><i class="fa fa-refresh" aria-hidden="true"></i></a>';
				else echo '<a href="#" class="float-right rp_idD" data-id="' . $rowsArray["am_id"] . '"><i class="fa fa-trash"></i></a>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
			}
			echo '</div>';
		}
	} elseif ($_POST["action"] == "mySubject") {
		$sql = "SELECT * from $tn_sub where subject_coordinator='$myEmail'  order by subject_semester, subject_name";
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
	} elseif ($_POST['action'] == 'fetchSubjectTemplate') {
		$sql = "update $tn_sat set sat_status='1' where update_id='$myId'";
		$result = $conn->query($sql);
		$sql = "insert into $tn_sat (subject_id, update_id, sat_status) values('" . $_POST['id'] . "', '$myId', '0')";
		$conn->query($sql);
		// if(!$conn->query($sql))echo $conn->error;;

		$sql = "update $tn_sat set sat_status='0' where subject_id='" . $_POST['id'] . "'";
		if (!$conn->query($sql)) echo $conn->error;;

		$sql = "select * from $tn_atmp where atmp_status='0' group by atmp_template order by atmp_template";
		$result = $conn->query($sql);
		$data = array();
		while ($rowsArray = $result->fetch_assoc()) {
			$subarray = array();
			$atmp_template = $rowsArray["atmp_template"];
			$sql_atmp = "select atmp.* from $tn_atmp atmp where atmp.atmp_template='$atmp_template' order by atmp.atmp_internal";
			$result_atmp = $conn->query($sql_atmp);
			if (!$result_atmp) echo $conn->error;
			$text = '';
			while ($rowsAtmp = $result_atmp->fetch_assoc()) {
				if ($rowsAtmp["atmp_internal"] == 0) $text .= "External";
				else $text .= "Internal";
				$text .= ' [' . $rowsAtmp["atmp_weightage"] . '], ';
			}
			$subarray["atmp_template"] = $atmp_template;
			$subarray["atmp_id"] = $rowsArray["atmp_id"];
			$subarray["text"] = $text;
			$sql_check = "select * from $tn_sat where subject_id='" . $_POST['id'] . "' and atmp_template='$atmp_template'";
			$result_check = $conn->query($sql_check);
			if ($result_check) $subarray["check"] = $result_check->num_rows;
			else $subarray["check"] = '0';
			$data[] = $subarray;
		}
		$jsonOutput = json_encode($data);
		echo $jsonOutput;
	} elseif ($_POST['action'] == 'setSubjectTemplate') {
		$sql = "select * from $tn_sat where sat_status='0' and update_id='$myId'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		else {
			$row = $result->fetch_assoc();
			$subject_id = $row['subject_id'];
			$sql = "update $tn_sat set atmp_template='" . $_POST['id'] . "' where subject_id='$subject_id'";
			$result = $conn->query($sql);
		}

		// Deleting Assessment Components of Previous Template for this Teaching Load

		$sql = "delete from $tn_sbas where  subject_id='$subject_id'";
		$result = $conn->query($sql);

		$sql_atmp = "select atmp.* from $tn_atmp atmp where atmp.atmp_template='" . $_POST['id'] . "'";
		$result_atmp = $conn->query($sql_atmp);
		while ($rowAtmp = $result_atmp->fetch_assoc()) {
			$atmp_id = $rowAtmp["atmp_id"];
			$sql = "insert into $tn_sbas (subject_id, atmp_id, sbas_assessments, sbas_consider, update_id) values('$subject_id','$atmp_id','1', '1', '$myId')";
			$result = $conn->query($sql);
			if (!$result) echo $conn->error;
		}
	} elseif ($_POST['action'] == 'fetchAssessmentTasks') {
		$sql = "select * from $tn_sat where sat_status='0' and update_id='$myId'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		else {
			$row = $result->fetch_assoc();
			$subject_id = $row['subject_id'];
			$atmp_template = $row['atmp_template'];
			$data = array();
			$sql_ac = "select atmp.*, sbas.subject_id, sbas.sbas_assessments from $tn_atmp atmp, $tn_sbas sbas where sbas.subject_id='$subject_id' and sbas.atmp_id=atmp.atmp_id order by atmp.atmp_internal desc";
			$result_ac = $conn->query($sql_ac);
			if ($result_ac) {
				while ($rowAC = $result_ac->fetch_assoc()) {
					$subArray = array();
					$subArray["template_id"] = $rowAC["atmp_template"];
					$subArray["atmp_id"] = $rowAC["atmp_id"];
					$subArray["sbas_assessments"] = $rowAC["sbas_assessments"];
					$subArray["subject_id"] = $rowAC["subject_id"];
					$subArray["atmp_weightage"] = $rowAC["atmp_weightage"];
					if ($rowAC["atmp_internal"] == '1') $subArray["atmp_internal"] = "Internal";
					else $subArray["atmp_internal"] = "External";
					$data[] = $subArray;
				}
			} else $conn->error;
			$jsonOutput = json_encode($data);
			echo $jsonOutput;
		}
	} elseif ($_POST['action'] == 'updateAssessmentNumber') {
		$sql = "select * from $tn_sat where sat_status='0' and update_id='$myId'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		else {
			$row = $result->fetch_assoc();
			$subject_id = $row['subject_id'];

			if ($_POST['tag'] == 'assessment') {
				//Block added on June 15
				$sql = "select * from $tn_atask where atmp_id='" . data_check($_POST["id"]) . "' and subject_id='$subject_id' and atask_sno='" . data_check($_POST["value"]) . "'";
				$result = $conn->query($sql);
				if ($result->num_rows == '0') {
					$sql = "insert $tn_atask (atmp_id, subject_id, atask_sno, atask_publish, atask_submission, update_id, atask_status) values('" . data_check($_POST["id"]) . "', '$subject_id', '" . data_check($_POST["value"]) . "', '$submit_date', '$submit_date', '$myId', '0')";
					$result = $conn->query($sql);
				}
				//Block ended June 15
				$sql_ac = "update $tn_sbas set sbas_assessments='" . $_POST['value'] . "' where subject_id='$subject_id' and atmp_id='" . $_POST['id'] . "'";
			} else $sql_ac = "update $tn_sbas set sbas_consider='" . $_POST['value'] . "' where subject_id='$subject_id' and atmp_id='" . $_POST['id'] . "'";
			$result_ac = $conn->query($sql_ac);
			if (!$result_ac) echo $conn->error;
		}
	} elseif ($_POST["action"] == "mySubjectList") {
		$sql = "SELECT * from $tn_sub where subject_coordinator='$myUserId' and subject_status='0'  order by subject_semester, subject_name";
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
	} elseif ($_POST["action"] == "addCO") {
		// echo "Add PO";
		//echo "batchId " . $_POST['batchIdModal'];
		$co_id = $_POST['co_id'];
		if ($co_id == '0') {
			$subject_id = data_check($_POST['id']);
			$co_sno = data_check($_POST['co_sno']);
			$co_statement = data_check($_POST['co_statement']);
			$co_weight = data_check($_POST['co_weight']);

			$sql_dup = "select * from $tn_co where co_sno='$co_sno' and subject_id='$subject_id'";
			$result_dup = $conn->query($sql_dup);
			if ($result_dup) {
				if ($result_dup->num_rows == '0') {
					$sql = "insert into $tn_co (subject_id, co_sno, co_statement, co_weight, update_id, co_status) values('$subject_id','$co_sno','$co_statement','$co_weight','$myId','0')";
					$result = $conn->query($sql);
					if (!$result) echo $conn->error;
					else echo "CO Added Successfully!!";
				} else {
					$sql = "update $tn_co set co_status='0', co_statement='$co_statement' where co_sno='$co_sno' and subject_id='$subject_id'";
					$result = $conn->query($sql);
					if (!$result) echo $conn->error;
					else echo "Already Exists. Updated the Existing!!";
				}
			}
		} else {
			$sql = "update $tn_co set co_statement='" . data_check($_POST['co_statement']) . "', co_sno='" . data_check($_POST['co_sno']) . "', co_weight='" . data_check($_POST['co_weight']) . "', co_status='0' where co_id='" . $co_id . "'";
			$result = $conn->query($sql);
			if (!$result) echo $conn->error;
			else echo "CO Updated Successfully!!";
		}
	} elseif ($_POST['action'] == 'fetchCO') {
		$subject_id = $_POST['subject_id'];
		$co_id = $_POST['co_id'];
		$sql = "select * FROM $tn_co where co_id='$co_id' and subject_id='$subject_id'";
		$result = $conn->query($sql);
		$output = $result->fetch_assoc();
		echo json_encode($output);
	} elseif ($_POST["action"] == "coList") {
		$sql = "SELECT co.*, sb.subject_code from $tn_co co, $tn_sub sb where co.subject_id='" . $_POST['id'] . "' and co.subject_id=sb.subject_id order by co.co_status, co.co_sno";
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
	} elseif ($_POST["action"] == "deleteCO") {
		$co_id = $_POST['id'];
		$sql = "update $tn_co set co_status='9' where co_id='$co_id'";
		$result = $conn->query($sql);
		// echo $tn;
	} elseif ($_POST["action"] == "copoMap") {
		$sql = "select * from $tn_po where program_id='$myProg' and po_status='0' order by po_sno";
		$resultPO = $conn->query($sql);
		$pos = 0;
		if (!$resultPO) echo $conn->error;
		else {
			while ($rowsPO = $resultPO->fetch_assoc()) {
				$po[$pos] = $rowsPO["po_id"];
				$pos++;
			}
		}
		$sql = "SELECT * from $tn_co where subject_id='" . $_POST['id'] . "' order by co_sno";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		else {
			$data = array();
			while ($rowArray = $result->fetch_assoc()) {
				$subarray = array();
				$subarray['co'] = $rowArray['co_statement'];
				$subarray['co_id'] = $rowArray['co_id'];
				$mapArray = array();
				for ($i = 0; $i < $pos; $i++) {
					$sqlCOPO = "select * from $tn_copo where co_id='" . $rowArray['co_id'] . "' and po_id='" . $po[$i] . "'";
					$resultMap = $conn->query($sqlCOPO);
					if ($resultMap->num_rows > 0) {
						$rowsScale = $resultMap->fetch_assoc();
						$scale = $rowsScale["copo_scale"];
					} else $scale = "-";
					$mapArray[$i] = $scale;
				}
				$subarray["po"] = $mapArray;
				$subarray["po_id"] = $po;
				$data[] = $subarray;
			}
			$output = array(
				"data" => $data
			);
			echo json_encode($output);
		}
	} elseif ($_POST["action"] == "copoScale") {
		$sql = "select * from $tn_copo where co_id='" . $_POST['co_id'] . "' and po_id='" . $_POST['po_id'] . "'";
		$result = $conn->query($sql);
		if ($result->num_rows == '0') {
			$sql = "insert into $tn_copo (co_id, po_id, copo_scale, update_id) values('" . $_POST['co_id'] . "', '" . $_POST['po_id'] . "', '" . $_POST['copo_scale'] . "', '$myId')";
		} else {
			$sql = "update $tn_copo set copo_scale='" . $_POST['copo_scale'] . "' where co_id='" . $_POST['co_id'] . "' and po_id='" . $_POST['po_id'] . "'";
		}
		$result = $conn->query($sql);
	} elseif ($_POST["action"] == "assessmentTask") {
		//echo "batchId " . $_POST['batchIdModal'];
		$sql = "select * from $tn_atask where atmp_id='" . data_check($_POST["atmp_id"]) . "' and subject_id='" . data_check($_POST["subject_id"]) . "' and atask_sno='" . data_check($_POST["task"]) . "'";
		$result = $conn->query($sql);
		if ($result->num_rows == '0') {
			$sql = "insert $tn_atask (atmp_id, subject_id, atask_sno, update_id, atask_status) values('" . data_check($_POST["atmp_id"]) . "', '" . data_check($_POST["subject_id"]) . "', '" . data_check($_POST["task"]) . "', '$myId', '0')";
			$result = $conn->query($sql);
		}
		$sql = "select atask.* FROM $tn_atask atask, $tn_atmp atmp where atask.atmp_id='" . data_check($_POST["atmp_id"]) . "' and atask.subject_id='" . data_check($_POST["subject_id"]) . "' and atask.atask_sno='" . data_check($_POST["task"]) . "' and atask.atask_status='0' and atask.atmp_id=atmp.atmp_id";
		$result = $conn->query($sql);
		if (!$result) echo $conn->query($sql);
		else {
			$output = $result->fetch_assoc();
			echo json_encode($output);
		}
	} elseif ($_POST["action"] == "updateTask") {
		//echo "batchId " . $_POST['batchIdModal'];
		$tag = $_POST["tag"];
		$sql = "update $tn_atask set $tag='" . data_check($_POST["value"]) . "' where atask_id='" . data_check($_POST["atask_id"]) . "'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
	} elseif ($_POST["action"] == "updateQuestionMap") {
		$atq_sno = $_POST["atq_sno"];
		$atask_id = $_POST["atask_id"];
		echo "Sno $atq_sno Task id $atask_id ";

		$sql = "select * from $tn_atq where atask_id='$atask_id' and atq_sno='$atq_sno'";
		$result = $conn->query($sql);
		// echo $result->num_rows;
		if ($result->num_rows == 0) {
			$sql = "insert into $tn_atq (atask_id, atq_sno, atq_marks, atq_level, atq_bt) values('$atask_id', '$atq_sno', '" . data_check($_POST["atq_marks"]) . "', '" . $_POST["atq_level"] . "', '" . $_POST["atq_bt"] . "')";
		} else {
			$sql = "update $tn_atq set atq_marks='" . data_check($_POST["atq_marks"]) . "', atq_level='" . data_check($_POST["atq_level"]) . "', atq_bt='" . data_check($_POST["atq_bt"]) . "' where atask_id='$atask_id' and atq_sno='$atq_sno'";
		}
		if (!$conn->query($sql)) echo $conn->error;
	} elseif ($_POST["action"] == "questionMap") {
		$atask_id = $_POST['atask_id'];
		$subject_id = getField($conn, $atask_id, $tn_atask, 'atask_id', 'subject_id');

		$sql = "select * from $tn_co where subject_id='$subject_id' and co_status='0' order by co_sno";
		$result = $conn->query($sql);
		$cos = 0;
		if (!$result) echo $conn->error;
		else {
			while ($rows = $result->fetch_assoc()) {
				$co[$cos] = $rows["co_id"];
				$co_sno[$cos] = $rows["co_sno"];
				$cos++;
			}
		}

		$sql = "SELECT * from $tn_atq where atask_id='" . $_POST['atask_id'] . "'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			$data = array();
			while ($rowArray = $result->fetch_assoc()) {
				$subarray = array();
				$subarray['atask_id'] = $rowArray['atask_id'];
				$subarray['atq_sno'] = $rowArray['atq_sno'];
				$subarray['atq_marks'] = $rowArray['atq_marks'];
				if ($rowArray['atq_level'] == '1') $subarray['atq_level'] = "Easy";
				elseif ($rowArray['atq_level'] == '2') $subarray['atq_level'] = "Average";
				else $subarray['atq_level'] = "Difficult";

				if ($rowArray['atq_bt'] == '1') $subarray['atq_bt'] = "Remembering";
				elseif ($rowArray['atq_bt'] == '2') $subarray['atq_bt'] = "Understanding";
				elseif ($rowArray['atq_bt'] == '3') $subarray['atq_bt'] = "Applying";
				elseif ($rowArray['atq_bt'] == '4') $subarray['atq_bt'] = "Analyzing";
				elseif ($rowArray['atq_bt'] == '5') $subarray['atq_bt'] = "Evaluating";
				else $subarray['atq_bt'] = "Creating";

				$mapArray = array();
				for ($i = 0; $i < $cos; $i++) {
					$sqlQCO = "select * from $tn_atco where atq_sno='" . $rowArray['atq_sno'] . "' and co_id='" . $co[$i] . "' and atask_id='" . $_POST['atask_id'] . "'";
					$resultMap = $conn->query($sqlQCO);
					if ($resultMap->num_rows > 0) {
						$rowsScale = $resultMap->fetch_assoc();
						$weight = $rowsScale["atco_weight"];
					} else $weight = "0";
					$mapArray[$i] = $weight;
				}
				$subarray["weight"] = $mapArray;
				$subarray["co_id"] = $co;
				$subarray["co_sno"] = $co_sno;
				$data[] = $subarray;
			}
			$output = array(
				"data" => $data
			);
			echo json_encode($output);
		}
	} elseif ($_POST["action"] == "updateQuestionCOMap") {
		$atq_sno = $_POST["atq_sno"];
		$atask_id = $_POST["atask_id"];
		$co_id = $_POST["co_id"];
		echo "Sno $atq_sno Task id $atask_id ";

		$sql = "select * from $tn_atco where atask_id='$atask_id' and atq_sno='$atq_sno' and co_id='$co_id'";
		$result = $conn->query($sql);
		// echo "Rows ".$result->num_rows; 
		if ($result->num_rows == 0) {
			$sql = "insert into $tn_atco (atask_id, atq_sno, co_id, atco_weight) values('$atask_id', '$atq_sno', '" . $_POST["co_id"] . "', '" . $_POST["weight"] . "')";
			$result = $conn->query($sql);
			if (!$result) echo $conn->error;
			// else echo "Added";
		} else {
			$sql = "update $tn_atco set atco_weight='" . data_check($_POST["weight"]) . "' where atask_id='$atask_id' and atq_sno='$atq_sno' and co_id='" . $co_id . "'";
			$result = $conn->query($sql);
			if (!$result) echo $conn->error;
		}
	} elseif ($_POST["action"] == "checkTemplate") {
		$subject_id = $_POST['subject_id'];
		$sql = "select * from $tn_sat where subject_id='$subject_id' and atmp_template>0 and sat_status='0'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) $output = $result->fetch_assoc();
		else $output = array("sat_id" => "0");
		echo json_encode($output);
	} elseif ($_POST["action"] == "checkQuestionMarks") {

		$subject_id = $_POST['subject_id'];

		$sql = "SELECT sat.*, atmp.*, sbas.* from $tn_sat sat, $tn_atmp atmp, $tn_sbas sbas where sat.subject_id='$subject_id' and sat.atmp_template=atmp.atmp_template and sbas.subject_id='$subject_id' and atmp.atmp_id=sbas.atmp_id";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			$data = array();
			while ($rowArray = $result->fetch_assoc()) {
				$subarray = array();
				$mn_id = $rowArray['at_id'];
				$subarray['tool'] = getField($conn, $mn_id, "master_name", 'mn_id', 'mn_name');
				$atmp_id = $rowArray['atmp_id'];
				$tasks = $rowArray['sbas_assessments'];
				for ($i = 1; $i <= $tasks; $i++) {
					$subarray['task'] = $i;
				}
				$data[] = $subarray;
			}
			$output = array(
				"data" => $data
			);
			echo json_encode($output);
		}
	} elseif ($_POST["action"] == "taskMarksList") {
		$atask_id = $_POST['atask_id'];
		// echo " TaskId $atask_id";
		// $sql = "SELECT sm.*, std.* from $tn_sm sm, $tn_std std where sm.student_id=std.student_id and sm.atask_id='$atask_id'";
		$sql = "SELECT sm.*, std.* from $tn_sm sm, $tn_std std where sm.student_id=std.student_id and sm.atask_id='$atask_id' group by std.student_id";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			$data = array();
			while ($rowArray = $result->fetch_assoc()) {
				$subarray = array();
				$subarray["student_sno"] = $rowArray["student_sno"];
				$subarray["student_rollno"] = $rowArray["student_rollno"];
				$student_id = $rowArray["student_id"];
				$marksArray = array();
				$sql_marks = $sql = "SELECT sm.* from $tn_sm sm where sm.student_id='$student_id' and sm.atask_id='$atask_id'";
				$result_marks = $conn->query($sql_marks);
				$count = 0;
				while ($rowMarks = $result_marks->fetch_assoc()) {
					$marksArray[$count] = $rowMarks["sm_marks"];
					$qnoArray[$count] = $rowMarks["atq_sno"];
					$count++;
				}
				$subarray["marks"] = $marksArray;
				$subarray["qno"] = $qnoArray;
				$data[] = $subarray;
			}
			echo json_encode($data);
		}
	} elseif ($_POST["action"] == "coScale") {
		$sql = "SELECT * from $tn_coscale where subject_id='" . $_POST['subject_id'] . "'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		elseif ($result->num_rows > 0) {
			$output = $result->fetch_assoc();
			echo json_encode($output);
		}
	} elseif ($_POST["action"] == "updateCOScale") {
		$subject_id = $_POST['subject_id'];
		$cs_ha = $_POST['cs_ha'];
		$cs_aa = $_POST['cs_aa'];
		$cs_la = $_POST['cs_la'];
		$cs_marks = $_POST['cs_marks'];
		$sql_dup = "select * from $tn_coscale where subject_id='$subject_id'";
		$result = $conn->query($sql_dup);
		if ($result->num_rows > 0) {
			$sql = "update $tn_coscale set cs_ha='$cs_ha', cs_aa='$cs_aa', cs_la='$cs_la', cs_marks='$cs_marks' where subject_id='$subject_id'";
			echo "Updated";
		} else {
			$sql = "insert into $tn_coscale (subject_id, cs_ha, cs_aa, cs_la, cs_marks, update_id) values('$subject_id', '$cs_ha', '$cs_aa', '$cs_la', '$cs_marks', '$myId')";
			echo "Added";
		}
		$result = $conn->query($sql);
	} elseif ($_POST["action"] == "deleteMarks") {
		$atask_id = $_POST['atask_id'];
		$atq_sno = $_POST['atq_sno'];
		$tn = 'student_marks' . $myBatch . 'p' . $myProg;
		$sql = "delete from $tn where atask_id='$atask_id' and atq_sno='$atq_sno'";
		$result = $conn->query($sql);
		// echo $tn;
	} elseif ($_POST['action'] == 'taskList') {

		$subject_id = $_POST['subject_id'];

		$data = array();
		$sql_ac = "select atmp.*, atask.* from $tn_atmp atmp, $tn_atask atask where atask.subject_id='$subject_id' and atask.atmp_id=atmp.atmp_id order by atask.atask_status, atmp.atmp_internal desc, atask.atask_tool, atask.atask_sno";
		$result_ac = $conn->query($sql_ac);
		while ($rowAC = $result_ac->fetch_assoc()) {
			$subArray = array();
			$subArray["atask_id"] = $rowAC["atask_id"];
			if ($rowAC["atmp_internal"] == 0) $subArray["atmp_internal"] = "External";
			else $subArray["atmp_internal"] = "Internal";
			$subArray["atask_status"] = $rowAC["atask_status"];
			$subArray["atask_name"] = $rowAC["atask_name"];
			$subArray["atmp_template"] = $rowAC["atmp_template"];
			$subArray["atask_sno"] = $rowAC["atask_sno"];
			$subArray["atask_marks"] = $rowAC["atask_marks"];
			$subArray["atask_weight"] = $rowAC["atask_weight"];
			$subArray["atask_publish"] = $rowAC["atask_publish"];
			$subArray["atask_question"] = $rowAC["atask_question"];
			$subArray["atask_submission"] = $rowAC["atask_submission"];
			$atask_tool = $rowAC["atask_tool"];

			$subArray["weighted_marks"] = ($rowAC["atask_marks"] * $rowAC["atask_weight"]) / 100;

			$sql = "select * from master_name where mn_code='at' and mn_status='0'";
			$result = $conn->query($sql);
			$text = '<select class="form-control form-control-sm ataskTool" data-tag="' . $rowAC["atask_id"] . '" id="' . $rowAC["atask_id"] . '" name="sel_tool" required>';
			if (!is_int($atask_tool)) $text .= '<option value="">Select a Tool</option>';
			while ($rowsArray = $result->fetch_assoc()) {
				$mn_id = $rowsArray["mn_id"];
				$mn_name = $rowsArray["mn_name"];
				if ($mn_id == $rowAC["atask_tool"]) $text .= '<option value="' . $mn_id . '" selected>' . $mn_name . '[' . $mn_id . ']</option>';
				else $text .= '<option value="' . $mn_id . '">' . $mn_name . '[' . $mn_id . ']</option>';
			}

			$text .= '</select>';
			$subArray["text"] = $text;

			$data[] = $subArray;
		}
		$jsonOutput = json_encode($data);
		echo $jsonOutput;
	} elseif ($_POST["action"] == "deleteTask") {
		$atask_id = $_POST['atask_id'];
		$sql = "update $tn_atask set atask_status='9' where atask_id='$atask_id'";
		$result = $conn->query($sql);
		// echo $tn;
	} elseif ($_POST["action"] == "deleteQuestion") {
		$atask_id = $_POST['atask_id'];
		$atq_sno = $_POST['atq_sno'];
		$sql = "delete from $tn_atq where atask_id='$atask_id' and atq_sno='$atq_sno'";
		$result = $conn->query($sql);
		if (!$result) $conn->error;
		// echo $tn;
	} elseif ($_POST["action"] == "fetchQMapSummary") {
		$atask_id = $_POST['atask_id'];
		$sql = "SELECT * from $tn_atq where atask_id='$atask_id'";
		$result = $conn->query($sql);
		$output["question"] = $result->num_rows;
		$weightArray = array();
		$totalQuestionMarks = 0;
		$marksArray = array();
		while ($rowsArray = $result->fetch_assoc()) {
			$atq_sno = $rowsArray["atq_sno"];
			$marksArray[] = $rowsArray["atq_marks"];
			$sql_co = "select sum(atco_weight) as sum from $tn_atco where atask_id='" . $_POST['atask_id'] . "' and atq_sno='$atq_sno'";
			$result_co = $conn->query($sql_co);
			if (!$result_co) echo $conn->error;
			else {
				$array = $result_co->fetch_assoc();
				$weightArray[] = $array["sum"];
			}
			$totalQuestionMarks += $rowsArray["atq_marks"];
		}
		$output["weight"] = $weightArray;
		$output["marks"] = $marksArray;
		$output["totalQuestionMarks"] = $totalQuestionMarks;
		$output["taskMarks"] = getField($conn, $atask_id, $tn_atask, "atask_id", "atask_marks");
		echo json_encode($output);
	} elseif ($_POST['action'] == 'ataskSelect') {
		$subject_id = $_POST['subject_id'];
		$sql_ac = "select atmp.*, atask.* from $tn_atmp atmp, $tn_atask atask where atask.subject_id='$subject_id' and atask.atmp_id=atmp.atmp_id order by atask.atask_status, atmp.atmp_internal desc, atask.atask_tool, atask.atask_sno";
		$result_ac = $conn->query($sql_ac);
		$text = '<select class="form-control form-control-sm" id="sel_atask" name="sel_atask" required>';

		while ($rowAC = $result_ac->fetch_assoc()) {
			$subArray = array();
			$atask_id = $rowAC["atask_id"];
			if ($rowAC["atmp_internal"] == 0) $atmp_internal = "External";
			else $atmp_internal = "Internal";
			if ($rowAC["atask_name"]) $atask_name = $rowAC["atask_name"];
			else $atask_name = "Not Set";
			$atask_sno = $rowAC["atask_sno"];
			$atask_tool = $rowAC["atask_tool"];
			if ($atask_tool > 0) $mn_name = getField($conn, $atask_tool, "master_name", "mn_id", "mn_name");
			else $mn_name = 'Not Set';
			$text .= '<option value="' . $atask_id . '">Tool : [' . $mn_name . '] Task : ' . $atask_name . '[' . $atask_id . ']</option>';
		}
		$text .= '</select>';
		echo $text;
	} elseif ($_POST['action'] == 'content') {
		$subject_id = $_POST['subject_id'];
		$content = $_POST['content'];
		//echo "Jai ho $instruction Id $id";
		$folder = '../../' . $myFolder . '/content';
		if (!is_dir($folder)) mkdir($folder);
		$fileName = $folder . '/content' . $subject_id . '.txt';
		echo $fileName;
		$fileHandle = fopen($fileName, 'w+') or die("Cannot open file");
		fwrite($fileHandle, $content);
		fclose($fileHandle);
	} elseif ($_POST['action'] == 'fetchContent') {
		$subject_id = $_POST['subject_id'];
		$folder = '../../' . $myFolder . '/content';

		$fileName = $folder . '/content' . $subject_id . '.txt';
		// echo $fileName;

		if (file_exists($fileName)) $content = file_get_contents($fileName);
		else $content = "No File Found";

		$fileName = $folder . '/scope' . $subject_id . '.txt';
		// echo $fileName;

		if (file_exists($fileName)) $scope = file_get_contents($fileName);
		else $scope = "Scope File Found";

		//echo $content;
		$output = array("file" => "fileName", "content" => $content,  "scope" => $scope);
		echo json_encode($output);
	} elseif ($_POST['action'] == "addST") {
		$subject_id = $_POST['subject_id'];
		$sbt_name = $_POST['sbt_name'];
		$sbt_weight = $_POST['sbt_weight'];
		$sbt_slot = $_POST['sbt_slot'];
		$sbt_unit = $_POST['sbt_unit'];
		$sbt_syllabus = $_POST['sbt_syllabus'];
		$sbt_type = $_POST['sbt_type'];

		$sql = "select max(sbt_sno) as max from $tn_sbt where subject_id='$subject_id' and sbt_type='$sbt_type' and sbt_status='0'";
		echo $max_sno = getMaxValue($conn, $sql) + 1;
		$sql_dup = "select * from $tn_sbt where subject_id='$subject_id' and sbt_type='$sbt_type' and sbt_name='$sbt_name'";
		$result_dup = $conn->query($sql_dup);
		if (!$result_dup) echo $conn->error;
		elseif ($result_dup->num_rows == 0) {
			$sql = "insert into $tn_sbt (subject_id, sbt_name, sbt_weight, sbt_slot, sbt_type, sbt_sno, sbt_unit, sbt_syllabus, update_id, sbt_status) values('$subject_id', '$sbt_name', '$sbt_weight', '$sbt_slot', '$sbt_type', '$max_sno', '$sbt_unit', '$sbt_syllabus', '$myId', '0')";
			if (!$conn->query($sql)) echo $conn->error;
		} else {
			$sql = "update  $tn_sbt set sbt_status='0' where subject_id='$subject_id' and sbt_type='$sbt_type' and sbt_name='$sbt_name'";
			if (!$conn->query($sql)) echo $conn->error;
		}
	} elseif ($_POST['action'] == "stList") {
		$subject_id = $_POST['subject_id'];
		//echo "TL Id - $tlId";
		$sno = 1;
		$sql = "select * from $tn_sbt where subject_id='$subject_id' and sbt_status='0' order by sbt_syllabus, sbt_sno";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		echo '<table class="table list-table-xs mb-0">';
		echo '<tr><th>#</th><th>Id</th><th class="text-center" width="5%"><i class="fa fa-pencil-alt"></i></th><th width="50%">Topic</th><th>Unit</th><th>Wt</th><th>Slot</th><th>S/A</th></tr>';
		while ($rows = $result->fetch_assoc()) {
			$sbtId = $rows["sbt_id"];
			echo '<tr>';
			echo '<td>' . $sno++ . '</td>';
			echo '<td>[' . $rows["sbt_id"] . '] </td>';
			echo '<td class="text-center">';
			// if ($sno > 2) echo '<a href="#" class="btn btn-success btn-square-xs swapButton" data-sbtId="' . $sbtId . '" data-tlId="' . $tlId . '" data-swap="UP"><i class="fa fa-arrow-up"></i></a>';
			// if ($sno <= $result->num_rows) echo '<a href="#" class="btn btn-danger btn-square-xs swapButton" data-sbtId="' . $sbtId . '" data-tlId="' . $tlId . '" data-swap="DN"><i class="fa fa-arrow-down"></i></a>';
			echo '<a href="#" class="fa fa-pencil-alt editButton" data-sbtId="' . $sbtId . '" data-sub="' . $subject_id . '"></a>';
			echo '</td>';
			echo '<td>' . $rows["sbt_name"] . '</td>';
			echo '<td>' . $rows["sbt_unit"] . '</td>';
			echo '<td>' . $rows["sbt_weight"] . '</td>';
			echo '<td>' . $rows["sbt_slot"] . '</td>';
			if ($rows["sbt_syllabus"] == '0') echo '<td>S</td>';
			else echo '<td>A</td>';
			echo '</tr>';
		}
		echo '</table>';
	} else if ($_POST['action'] == 'addRes') {
		$subject_id = $_POST['subject_id'];

		$dup = "select * from $tn_sr where sr_name='" . data_check($_POST["sbr_name"]) . "' and subject_id='$subject_id' and rt_id='" . data_check($_POST['mn_id']) . "' and update_id='$myId'";
		$result = $conn->query($dup);
		if ($result) {
			if ($result->num_rows == 0) {
				$sql = "insert into $tn_sr (subject_id, rt_id, sr_name, sr_type, sr_url, update_id, sr_status) values('$subject_id', '" . $_POST['mn_id'] . "', '" . data_check($_POST["sbr_name"]) . "', '" . data_check($_POST["sbr_type"]) . "', '" . data_check($_POST["sbr_url"]) . "', '$myId', '0')";
			} else {
				$sql = "update  $tn_sr set sr_status='0' where sr_name='" . data_check($_POST["sbr_name"]) . "' and subject_id='$subject_id' and rt_id='" . data_check($_POST['mn_id']) . "' and update_id='$myId'";
			}
			$result = $conn->query($sql);
			if (!$result) echo $conn->error;
		} else echo $conn->error;

		//echo "OK";
	} elseif ($_POST['action'] == "resList") {
		$subject_id = $_POST['subject_id'];
		//echo "Sub $subject_id";
		$subject = getField($conn, $subject_id, "subject", "subject_id", "subject_name");
		$json = get_subjectResource($conn, $tn_sr, $subject_id);
		//echo $json;
		$array = json_decode($json, true);

		echo '<table class="table list-table-xs">';
		echo '<tr><th>Id</th><th width="20%">Title</th><th>Type</th><th>Link</th><th width="5%"><i class="fa fa-upload"></i></th><th width="10%"><i class="fa fa-eye"></i></th></tr>';
		for ($i = 0; $i < count($array["data"]); $i++) {
			$srId = $array["data"][$i]["id"];
			$sr_name = $array["data"][$i]["name"];
			$mn_name = $array["data"][$i]["mn_name"];
			$sr_url = $array["data"][$i]["url"];
			echo '<tr>';
			echo '<td>' . $srId . '</td><td>' . $sr_name . '</td><td>' . $mn_name . '</td><td><a href="' . $sr_url . '" target="_blank">' . $sr_url . '</a></td>';
			echo '<td>';
			echo '<a href="#" class="largeText text-center text-primary fa fa-upload srUpload" data-sr="' . $srId . '"></a>';
			echo '</td>';
			$filelink = '../../' . $myFolder . 'resourse/' . $srId . '.pdf';
			if (!file_exists($filelink)) {
				$filelink = '#';
				$filename = '--';
				echo '<td>' . $filename . '</td>';
			} else {
				$filename = $srId . '.pdf';
				echo '<td><a href="' . $filelink . '" class="fa fa-eye show" target="_blank" data-sr="' . $srId . '">' . $filename . '</a></td>';
			}
			echo '</tr>';
		}
		echo '</table>';
		echo '';
	} else if ($_POST['action'] == 'addBook') {
		$subject_id = $_POST['subject_id'];
		$sql = "insert into $tn_sbk (subject_id, sbk_name, sbk_publisher, sbk_author, sbk_isbn, sbk_doi, sbk_edition, update_id, sbk_status) values('$subject_id', '" . data_check($_POST["sbk_name"]) . "', '" . data_check($_POST["sbk_publisher"]) . "', '" . data_check($_POST["sbk_author"]) . "', '" . data_check($_POST["sbk_isbn"]) . "', '" . data_check($_POST["sbk_doi"]) . "', '" . data_check($_POST["sbk_edition"]) . "', '$myId', '0')";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		echo "Done";
	} elseif ($_POST['action'] == "bookList") {
		$subject_id = $_POST['subject_id'];
		//echo "Sub $subject_id";
		$i=1;
		$sql = "select * from $tn_sbk where subject_id='$subject_id' and sbk_status='0'";
		$result = $conn->query($sql);
		if (!$result) echo $conn->error;
		while ($rows = $result->fetch_assoc()) {
			echo '<p>';
			echo '<span>' . $i++ . ' </span>';
			echo '<b>' . $rows["sbk_author"] . ' </b><i> "' . $rows["sbk_name"] . '"</i>';
			echo '<span> '. $rows["sbk_publisher"] . '</span>';
			echo '<span><b>, '. $rows["sbk_edition"] . '</b></span>';
			echo '<span>, '. $rows["sbk_isbn"] . '</span>';
			echo '<span class="text-primary"> DOI : '. $rows["sbk_doi"] . '</span>';
			echo '</p>';
		}
	}elseif ($_POST['action'] == 'scope') {
		$subject_id = $_POST['subject_id'];
		$scope = $_POST['scope'];
		//echo "Jai ho $instruction Id $id";
		$folder = '../../' . $myFolder . '/content';
		if (!is_dir($folder)) mkdir($folder);
		$fileName = $folder . '/scope' . $subject_id . '.txt';
		echo $fileName;
		$fileHandle = fopen($fileName, 'w+') or die("Cannot open file");
		fwrite($fileHandle, $scope);
		fclose($fileHandle);
	} 
}
