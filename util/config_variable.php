<?php
require("check_table.php");

//Follwoing are set in Inst Folder e.g. demo
if (isset($_SESSION["setUrl"])) $setUrl = $_SESSION['setUrl'];
if (isset($_SESSION["setLogo"])) $setLogo = $_SESSION['setLogo'];
if (isset($_SESSION["setCodePath"])) $codePath = $_SESSION['setCodePath'];

if (isset($_SESSION["myFolder"])) $myFolder = $_SESSION['myFolder'];

if (isset($_SESSION['un'])) $myUn = $_SESSION['un'];
if (isset($_SESSION['pwd'])) $myPwd = $_SESSION['pwd'];
if (isset($_SESSION["myid"])) $myId = $_SESSION['myid'];
if (isset($_SESSION["privledge"])) $myPriv = $_SESSION['privledge'];

if (isset($_SESSION["mysclid"])) $myScl = $_SESSION['mysclid'];
if (isset($_SESSION["mysid"])) $mySes = $_SESSION['mysid'];
if (isset($_SESSION["myBatch"])) $myBatch = $_SESSION['myBatch'];
if (isset($_SESSION["mydeptid"])) $myDept = $_SESSION['mydeptid'];
if (isset($_SESSION["mypid"])) $myProg = $_SESSION['mypid'];

if (isset($_SESSION['myStdId']) > 0) $myStdId = $_SESSION["myStdId"];

if (isset($mySes)) {
  $session_start = getField($conn, $mySes, "session", "session_id", "session_start");
  $session_end = getField($conn, $mySes, "session", "session_id", "session_end");

  // check_tn_ad($conn, 'assessment_design');
  check_tn_amap($conn, 'assessment_map');
  //check_tn_rs($conn, 'cc_outcome');
  check_tn_class($conn, "class");
  check_tn_lt($conn, "leave_type");
  check_tn_org($conn, 'organization');
  check_tn_mn($conn, 'master_name');
  check_tn_rp($conn, 'resource_person');
  check_tn_respStaff($conn, 'responsibility_staff');
  check_tn_std($conn, "student");
  check_tn_stddetail($conn, "student_detail");
  check_tn_stdqual($conn, "student_qualification");
  check_tn_sub($conn, "subject");
  check_tn_subaddon($conn, "subject_addon");
  check_tn_subelective($conn, "subject_elective");
  check_tn_user($conn, "user");

  $tn_ccd = 'cc_detail' . $mySes;
  check_tn_ccd($conn, $tn_ccd);

  $tn_eac = 'ea_claim' . $mySes;
  //check_tn_eac($conn, $tn_eac);

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

  $tn_sr = 'subject_resource' . $mySes;
  check_tn_sr($conn, $tn_sr);

  $tn_tl = 'teaching_load' . $mySes;
  check_tn_tl($conn, $tn_tl);

  $tn_tt = 'time_table' . $mySes;
  check_tn_tt($conn, $tn_tt);

  $tn_ttp = 'time_table_period' . $mySes;
  check_tn_ttp($conn, $tn_ttp);

  $tn_tlg = 'tl_group' . $mySes;
  check_tn_tlg($conn, $tn_tlg);
} else {
  $tn_eac = 'ea_claim';
  $tn_rc = 'registration_class2021';
  //check_tn_rc($conn, $tn_tl);
}
$submit_date = date("Y-m-d", time());
$submit_ts = date("Y-m-d h:i:s", time());
$today_ts = time();
