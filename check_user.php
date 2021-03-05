<?php
session_start();
require("config_database.php");
require("config_variable.php");
require("php_function.php");

if ($_POST['action'] == 'checkUser') {
  $myUn = $_POST['username'];
  $myPwd = $_POST['userpassword'];
  $url = $setUrl . '/acadplus/api/check_user.php?u=' . $myUn . '&&p=' . $myPwd.'&&mf='.$myFolder;
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  $output = curl_exec($curl);
  $id = json_decode($output, true);
  curl_close($curl);
  echo $output;
  $_SESSION['myid'] = $id["user"];
  $_SESSION['myStdId'] = $id["student"];
  $_SESSION['un'] = $myUn;
  $_SESSION['pwd'] = $myPwd;

} elseif ($_POST['action'] == 'setProgram') {
  $mpid = $_POST['programId'];
  $prog=getField($conn, $myProg, "program", "program_id", "sp_abbri");
  //echo $prog;
  $_SESSION['mypid'] = $mpid;

} elseif ($_POST['action'] == 'selSession') {
  $mpid = $_POST['programId'];

  $sql = "select * from session where program_id='$mpid'";
  selectList($conn, "Select Session", array("2", "session_id", "session_name", "", "sel_session"), $sql);
} elseif ($_POST['action'] == 'setSession') {
  $msid = $_POST['sessionId'];
  //echo 'Ses [' . $msid . ']';
  $_SESSION['mysid'] = $msid;
}
