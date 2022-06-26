<?php
require("check_table.php");
//Follwoing are set in Inst Folder e.g. demo
if (isset($_SESSION["setUrl"])) $setUrl = $_SESSION['setUrl'];
if (isset($_SESSION["setLogo"])) $setLogo = $_SESSION['setLogo'];
if (isset($_SESSION["setCodePath"])) $codePath = $_SESSION['setCodePath'];

if (isset($_SESSION["myFolder"])) $myFolder = $_SESSION['myFolder'];
if (isset($_SESSION["myDb"])) $myDb = $_SESSION['myDb'];

if (isset($_SESSION['un'])) $myUn = $_SESSION['un'];
if (isset($_SESSION['pwd'])) $myPwd = $_SESSION['pwd'];
if (isset($_SESSION['mll'])) $myMll = $_SESSION['mll'];
if (isset($_SESSION['timeLag'])) $myTimeLag = $_SESSION['timeLag'];
if (isset($_SESSION["myid"])) $myId = $_SESSION['myid'];
if (isset($_SESSION["privilege"])) $myPriv = $_SESSION['privilege']; //Changed 28-05-2022

if (isset($_SESSION["mysclid"])) $myScl = $_SESSION['mysclid'];
if (isset($_SESSION["mysid"])) $mySes = $_SESSION['mysid'];
if (isset($_SESSION["myBatch"])) $myBatch = $_SESSION['myBatch'];
if (isset($_SESSION["mydeptid"])) $myDept = $_SESSION['mydeptid'];
if (isset($_SESSION["mypid"])) $myProg = $_SESSION['mypid'];

if (isset($_SESSION['myStdId']) > 0) $myStdId = $_SESSION["myStdId"];

if (isset($mySes)) {
  //echo "$mySes";
  $myEmail = getField($conn, $myId, "staff", "staff_id", "staff_email");
  $session_start = getField($conn, $mySes, "session", "session_id", "session_start");
  $session_end = getField($conn, $mySes, "session", "session_id", "session_end");

  //echo "$session_start - $session_end";

  // $sesDeptName=getField($conn, $myDept, "department", "dept_id", "dept_name");
  // $dept_header='<h5 class="text-center">'.$sesDeptName.'</h5>';

  //echo "$dept_header ";
  check_tn_ly($conn, "leave_year");

  $sql = "select ly_id from leave_year where ly_status='0'";
  $result = $conn->query($sql);
  if ($result && $result->num_rows == 1) {
    $rowsArray = $result->fetch_assoc();
    $ly_id = $rowsArray['ly_id'];
  } elseif ($result && $result->num_rows == 0) {
    echo $conn->error;
    $ly_id = '1';
  } else {
    echo $conn->error;
    die("Not Processed - Leave Year ");
  }

  // check_tn_ad($conn, 'assessment_design');
  
  check_tn_ah($conn, 'activity_head');

  check_tn_ash($conn, 'activity_sub_head');

  check_tn_block($conn, 'block');
  check_tn_bl($conn, "block_location");

  check_tn_class($conn, "class");
  
  check_tn_com($conn, "committee");
  check_tn_cs($conn, "committee_structure");

  check_tn_ee($conn, "evaluation_event");

  check_tn_fe($conn, "faculty_event");

  check_tn_feeConcession($conn, "fee_concession");
  check_tn_feeDues($conn, "fee_dues");
  check_tn_feeReverse($conn, "fee_reverse");
  check_tn_feeReceipt($conn, "fee_receipt");
  check_tn_feeStructure($conn, "fee_structure");
  check_tn_feeSchedule($conn, "fee_schedule");

  check_tn_feedback($conn, "feedback");
  check_tn_feedback_question($conn, "feedback_question");
  check_tn_feedback_option($conn, "feedback_option");
  check_tn_feedback_participant($conn, "feedback_participant");

  check_tn_hs($conn, "hostel_student");
  //check_tn_ha($conn, "hostel_attendance"); Session Based variable name

  check_tn_leave_credit($conn, "leave_credit");
  check_tn_ld($conn, "leave_duration");
  check_tn_lt($conn, "leave_type");
  check_tn_org($conn, 'organization');
  check_tn_mn($conn, 'master_name');
  check_tn_pg($conn, 'privilege_group');
  check_tn_prtg($conn, 'portal_group');
  check_tn_prtm($conn, 'portal_menu');
  check_tn_pv($conn, 'payment_voucher');
  check_tn_pvr($conn, 'pv_reverse');
  check_tn_qb_cp($conn, 'qb_cp');
  check_tn_qb_parameter($conn, 'qb_parameter');
  check_tn_question_bank($conn, 'question_bank');
  check_tn_question_option($conn, 'question_option');
  check_tn_respStaff($conn, 'responsibility_staff');
  check_tn_rg($conn, 'responsibility_group');
  check_tn_rl($conn, 'responsibility_link');
  check_tn_rp($conn, 'resource_person');
  check_tn_sdl($conn, "schedule");
  check_tn_sq($conn, "staff_qualification");
  check_tn_ssl($conn, "staff_salary");
  check_tn_stddoc($conn, "student_document");
  check_tn_stddd($conn, "student_document_detail");
  check_tn_stdqual($conn, "student_qualification");
  check_tn_stdscl($conn, "student_scholarship");
  
  // check_tn_subaddon($conn, "subject_addon");
  check_tn_subelective($conn, "subject_elective");
  check_tn_test($conn, "test");
  check_tn_test_participant($conn, "test_participant");
  check_tn_test_question($conn, "test_question");
  check_tn_todo($conn, "todo");
  check_tn_user($conn, "user");
  check_tn_userLog($conn, "user_log");
  check_tn_userActivity($conn, "user_activity");

  // Fixed Table Name but variable used in codes
   
  $tn_ea = 'enrichment_activity';
  check_tn_ea($conn, $tn_ea);

  $tn_eap = 'enrichment_activity_participant';
  check_tn_eap($conn, $tn_eap);
  
  $tn_ear = 'enrichment_activity_resource';
  check_tn_ear($conn, $tn_ear);
  
  $tn_sub = 'subject';
  check_tn_sub($conn, $tn_sub);

  $tn_sbk = 'subject_book';
  check_tn_sbk($conn, $tn_sbk);

  $tn_tr='transport_route';
  check_tn_tr($conn, $tn_tr);

  $tn_ts='transport_stop';
  check_tn_ts($conn, $tn_ts);

  $tn_atmp = 'assessment_template';
  check_tn_atmp($conn, $tn_atmp);

  // Batch Based Tables

  $tn_atask = 'assessment_task' . $myBatch;
  check_tn_atask($conn, $tn_atask);

  $tn_atco = 'assessment_task_co' . $myBatch;
  check_tn_atco($conn, $tn_atco);
  
  $tn_atm = 'assessment_task_map' . $myBatch;
  //check_tn_atm($conn, $tn_atm);

  $tn_atq = 'assessment_task_question' . $myBatch;
  check_tn_atq($conn, $tn_atq);

  $tn_sat = 'subject_assessment_template' . $myBatch;
  check_tn_sat($conn, $tn_sat);

  $tn_co = 'course_outcome' . $myBatch;
  check_tn_co($conn, $tn_co);
  
  $tn_copo = 'co_po' . $myBatch;
  check_tn_copo($conn, $tn_copo);

  $tn_sbas = 'subject_assessment' . $myBatch;
  check_tn_sbas($conn, $tn_sbas);


  //Session Based Tables

  $tn_ccd = 'cc_detail' . $mySes;
  check_tn_ccd($conn, $tn_ccd);
  
  $tn_ha = 'hostel_attendance' . $mySes;
  check_tn_ha($conn, $tn_ha);


  //echo "Leave Year ";

  $tn_lc = 'leave_claim' . $ly_id;
  check_tn_lc($conn, $tn_lc);

  $tn_ll = 'leave_ledger' . $ly_id;
  check_tn_ll($conn, $tn_ll);

  $tn_po = 'program_outcome' . $myBatch;
  check_tn_po($conn, $tn_po);
  
  $tn_rc = 'registration_class' . $mySes;
  check_tn_rc($conn, $tn_rc);

  $tn_rs = 'registration_subject' . $mySes;
  check_tn_rs($conn, $tn_rs);

  $tn_sas = 'student_attendance_setup' . $mySes;
  check_tn_sas($conn, $tn_sas);

  $tn_sbt = 'subject_topic' . $mySes;
  check_tn_sbt($conn, $tn_sbt);

  $tn_sc = 'subject_choice' . $mySes;
  check_tn_sc($conn, $tn_sc);

  $tn_sm = 'student_marks' . $mySes;

  $tn_sms = 'student_marks_setup' . $mySes;
  check_tn_sms($conn, $tn_sms);

  $tn_sr = 'subject_resource' . $mySes;
  check_tn_sr($conn, $tn_sr);

  $tn_src = 'subject_resource_class' . $mySes;
  check_tn_src($conn, $tn_src);

  $tn_tl = 'teaching_load' . $mySes;
  check_tn_tl($conn, $tn_tl);

  $tn_tt = 'time_table' . $mySes;
  check_tn_tt($conn, $tn_tt);

  $tn_ttp = 'time_table_period' . $mySes;
  check_tn_ttp($conn, $tn_ttp);

  $tn_tlg = 'tl_group' . $mySes;
  check_tn_tlg($conn, $tn_tlg);
}
$today = date("Y-m-d", time()+$myTimeLag);
$submit_date = date("Y-m-d", time()+$myTimeLag);
$submit_ts = date("Y-m-d H:i:s", time()+$myTimeLag);
$time_ts = time()+$myTimeLag;
