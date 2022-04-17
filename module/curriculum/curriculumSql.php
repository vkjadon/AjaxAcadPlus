<?php
require('../requireSubModule.php');

//echo $_POST['action'];
if (isset($_POST['action'])) {
  if ($_POST["action"] == "addSubject") {
    $fields = ['program_id', 'batch_id', 'subject_name', 'subject_code', 'subject_semester', 'subject_credit', 'subject_type', 'subject_mode', 'subject_category', 'subject_lecture', 'subject_tutorial', 'subject_practical', 'subject_internal', 'subject_external', 'staff_id', 'submit_id'];
    $values = [$myProg, $_POST['batchIdModal'], data_check($_POST['subject_name']), data_check($_POST['subject_code']), data_check($_POST['subject_semester']), data_check($_POST['subject_credit']), data_check($_POST['subject_type']), data_check($_POST['subject_mode']), data_check($_POST['subject_category']), data_check($_POST['subject_lecture']), data_check($_POST['subject_tutorial']), data_check($_POST['subject_practical']), data_check($_POST['subject_internal']), data_check($_POST['subject_external']), $_POST['sel_staff'], $myId];
    $status = 'subject_status';
    $dup = "select * from subject where subject_code='" . data_check($_POST["subject_code"]) . "' and program_id='" . $_POST["programIdModal"] . "' and batch_id='" . $_POST["batchIdModal"] . "' and $status='0'";
    $dup_alert = "Duplicate Code Exists. Multiple Subject Codes not Allowed!";
    addData($conn, 'subject', 'subject_id', $fields, $values, $status, $dup, $dup_alert);
  } 
}
