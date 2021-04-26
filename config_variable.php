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

  $tn_ad = 'assessment_design';
  //check_tn_ad($conn, $tn_ad);

  $tn_ccd = 'cc_detail'.$mySes;
  //check_tn_ccd($conn, $tn_ccd);

  $tn_cco = 'cc_outcome';
  //check_tn_rs($conn, $tn_tl);

  $tn_class = 'class';
  //check_tn_rs($conn, $tn_tl);

  $tn_eac = 'ea_claim'.$mySes;
  //check_tn_eac($conn, $tn_eac);

  $tn_rc = 'registration_class'.$mySes;
  check_tn_rc($conn, $tn_rc);

  $tn_res = 'resource_subject'.$mySes;
  //check_tn_rs($conn, $tn_tl);

  $tn_rs = 'registration_subject'.$mySes;
  check_tn_rs($conn, $tn_rs);

  $tn_sas = 'student_attendance_setup' . $mySes;
  check_tn_sas($conn, $tn_sas);

  $tn_sbt = 'subject_topic'.$mySes;
  check_tn_sbt($conn, $tn_sbt);

  $tn_tlg = 'tl_group'.$mySes;
  check_tn_tlg($conn, $tn_tlg);

  $tn_tl = 'teaching_load'.$mySes;
  check_tn_tl($conn, $tn_tl);

  $tn_tt = 'time_table'.$mySes;
  check_tn_tt($conn, $tn_tt);

} else {
  $tn_eac = 'ea_claim';
  $tn_rc = 'registration_class2021';
  //check_tn_rc($conn, $tn_tl);
}
$submit_date = date("Y-m-d", time());
$submit_ts = date("Y-m-d h:i:s", time());
$today_ts = time();
