<?php
require('../requireSubModule.php');

//echo $_POST['action'];
//global $tn_tt;
if (isset($_POST['action'])) {
	if ($_POST['action'] == 'mySubjectList') {
		//$subjectId = $_POST['subjectId'];
		//$loadType = $_POST['loadType'];
		//echo $subjectId $loadType;
		$jsonTL = get_staffTeachingSubject($conn, $myId, $tn_tl, $tn_tlg);
		//echo $jsonTL;
		$array = json_decode($jsonTL, true);
		echo '<table class="table list-table-xs">';
		for ($i = 0; $i < count($array["data"]); $i++) {
			$tlId = $array["data"][$i]["tlId"];
			$subject_id = $array["data"][$i]["subject_id"];
			$subject = getField($conn, $subject_id, "subject", "subject_id", "subject_name");
			echo '<tr>';
			echo '<td>'.$subject . ' [' . $subject_id . ']</td>';
			echo '<td><button class="btn btn-info btn-square-sm mt-1 addAssessment" data-sub="'.$subject_id.'">New</button></td>';

			echo '</tr>';
		}
		echo '</table>';
	} else if ($_POST['action'] == 'mySubjectAssessmentList') {
		$subjectId = $_POST['subjectId'];
		$jsonAD = get_subjectAssessmentList($conn, $subjectId, $tn_ad);
		//echo $jsonTL;
		$array = json_decode($jsonAD, true);
		for ($i = 0; $i < count($array["data"]); $i++) {
			$tlId = $array["data"][$i]["ad_id"];
			$subject_id = $array["data"][$i]["subject_id"];
			$subject = getField($conn, $subject_id, "subject", "subject_id", "subject_name");
			echo '<div class="col text-muted" data-sub="' . $subject_id . '">' . $subject . ' [' . $subject_id . ']</div>';
		}
	}
}
