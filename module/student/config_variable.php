<?php
if (isset($_SESSION["msd"])) $mySes = $_SESSION["msd"];
else $mySes=50;

if (isset($_SESSION["vkuname"])) $myUn = $_SESSION['vkuname'];
elseif (isset($_SESSION['un'])) $myUn = $_SESSION['un'];

if (isset($_SESSION['myStdId']) > 0) $myStdId = $_SESSION["myStdId"];
if (isset($_SESSION['myssid']) > 0) $myStdId = $_SESSION['myssid'];

if (isset($mySes)) {

  $tn_class = 'class'.$mySes;
  //check_tn_rs($conn, $tn_class);

  $tn_rc = 'registration_class'.$mySes;
  //check_tn_rc($conn, $tn_rc);

  $tn_res = 'resource_subject'.$mySes;
  //check_tn_rs($conn, $tn_tl);

  $tn_rs = 'registration_subject'.$mySes;
  //check_tn_rs($conn, $tn_rs);

  $tn_tlg = 'tl_group'.$mySes;
  //check_tn_tl($conn, $tn_tlg);

  $tn_tl = 'teaching_load'.$mySes;
  //check_tn_tl($conn, $tn_tl);

  $tn_tt = 'time_table'.$mySes;
  //check_tn_tl($conn, $tn_tt);

  $tn_sbt = 'subject_topic'.$mySes;
  //check_tn_rs($conn, $tn_sbt);

  $tn_sas = 'student_attendance_setup' . $mySes;
  //check_tn_sas($conn, $tn_sas);
  //echo $tn_sas;
}
$submit_date = date("Y-m-d", time());
$submit_ts = date("Y-m-d h:i:s", time());
$today_ts = time();
