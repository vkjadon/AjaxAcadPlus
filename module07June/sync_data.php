<?php
//sync_data($conn,"batches", "batch");
//sync_data($conn,"sessions", "session");
//sync_data($conn, "program", "program");
//sync_data($conn, "department", "department");
//sync_data($conn, "program_course", "subject");
//sync_data($conn, "classes", "class");
//sync_data($conn, "staff", "staff");
//sync_data($conn, "registration_class2021", "registration_class");
sync_data($conn, "department_ci", "class_incharge");

function sync_data($conn, $tableX, $table)
{
	$curl = curl_init();
	$url = 'https://instituteerp.net/acadplus/api/tableJson.php?table=' . $tableX;

	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($curl);
	//echo $output;
	$output = json_decode($output, true);

	$rowsX = count($output["data"]);
	$sql = "select * from $table";
	$result = $conn->query($sql);
	$rows = $result->num_rows;
	//echo "RwsX $rowsX Rows $rows";
	if ($rowsX > $rows) {
		for ($i = $rows; $i < $rowsX; $i++) {
			$sql = "";
			if ($table == "batch") $sql = "insert into $table (batch, batch_status) values('" . $output["data"][$i]["batch"] . "','0')";

			elseif ($table == "class_incharge") $sql = "insert into $table (staff_id, ci_from, ci_to, class_id, ci_status) values('" . $output["data"][$i]["staff_id"] . "', '" . $output["data"][$i]["dci_from"] . "', '" . $output["data"][$i]["dci_to"] . "',  '" . $output["data"][$i]["class_id"] . "', '0')";

			elseif ($table == "registration_class") $sql = "insert into $table (class_id, student_id, rc_date, submit_id, rc_status) values('" . $output["data"][$i]["class_id"] . "', '" . $output["data"][$i]["student_id"] . "', '" . $output["data"][$i]["submit_date"] . "',  '" . $output["data"][$i]["submit_id"] . "', '0')";

			elseif ($table == "staff") $sql = "insert into $table (staff_id, dept_id, designation_id, staff_name, staff_dob, staff_fname, staff_mname, staff_doj, staff_mobile, staff_email, submit_id, staff_status) values('" . $output["data"][$i]["staff_id"] . "', '" . $output["data"][$i]["unitid"] . "',  '" . $output["data"][$i]["designation_id"] . "', '" . $output["data"][$i]["aname"] . "',  '" . $output["data"][$i]["dob"] . "', '" . $output["data"][$i]["fname"] . "', '',  '" . $output["data"][$i]["doj"] . "', '" . $output["data"][$i]["mobile"] . "', '" . $output["data"][$i]["email"] . "', '1', '0')";

			
			elseif ($table == "class") $sql = "insert into $table (batch_id, program_id, session_id, class_semester, class_name, class_section, class_shift, submit_id, class_status) values('0', '" . $output["data"][$i]["program_id"] . "', '" . $output["data"][$i]["session_id"] . "', '" . $output["data"][$i]["semester"] . "',  '" . $output["data"][$i]["class_name"] . "', 'A', 'Morning', '1', '0')";

			elseif ($table == "subject") $sql = "insert into $table (batch_id, program_id, subject_semester, subject_name, subject_code, subject_mode, subject_type, subject_category, subject_lecture, subject_tutorial, subject_practical,  submit_id, subject_status) values('" . $output["data"][$i]["batch_id"] . "', '" . $output["data"][$i]["program_id"] . "', '" . $output["data"][$i]["pc_semester"] . "',  '" . $output["data"][$i]["pc_name"] . "', '" . $output["data"][$i]["pc_code"] . "', 'Offline', 'DC', 'Theory', '" . $output["data"][$i]["pc_lecture"] . "', '" . $output["data"][$i]["pc_tutorial"] . "', '" . $output["data"][$i]["pc_practical"] . "', '1', '0')";

			elseif ($table == "session") $sql = "insert into $table (session_id, ay_id, session_name, school_id, program_id, session_start, session_end, session_status) values('" . $output["data"][$i]["session_id"] . "', '" . $output["data"][$i]["batch_id"] . "', '" . $output["data"][$i]["session_name"] . "',  '" . $output["data"][$i]["inst_id"] . "',  '" . $output["data"][$i]["program_id"] . "',  '" . $output["data"][$i]["session_start"] . "', '" . $output["data"][$i]["session_end"] . "', '0')";

			elseif ($table == "program") $sql = "insert into $table (dept_id, program_name, program_abbri, sp_name, sp_abbri, program_semester, program_status) values('1', '" . $output["data"][$i]["program_name"] . "',  '" . $output["data"][$i]["program_abbri"] . "',  '" . $output["data"][$i]["program_name"] . "',  '" . $output["data"][$i]["program_abbri"] . "', '" . $output["data"][$i]["program_semester"] . "', '0')";

			elseif ($table == "department") $sql = "insert into $table (school_id, dept_name, dept_abbri, dept_type, submit_id, dept_status) values('1', '" . $output["data"][$i]["unitname"] . "', '" . $output["data"][$i]["abbri"] . "',  '0', '1', '0')";

			if (strlen($sql) > 10) {
				$result = $conn->query($sql);
				if (!$result) echo $conn->error;
			}
		}
	}
}
