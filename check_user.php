<?php
session_start();
require("config_database.php");
require("config_variable.php");
require("php_function.php");

if ($_POST['action'] == 'checkUser') {
  $myUn = $_POST['username'];
  $myPwd = $_POST['userpassword'];
  $url = $setUrl . '/acadplus/api/check_user.php?u=' . $myUn . '&&p=' . $myPwd . '&&mf=' . $myFolder;
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
} elseif ($_POST['action'] == 'setProgram') $_SESSION['mypid'] = $_POST['programId'];
elseif ($_POST['action'] == 'setSession') $_SESSION['mysid'] = $_POST['sessionId'];
elseif ($_POST['action'] == 'setSchool') $_SESSION['mysclid'] = $_POST['schoolId'];
elseif ($_POST['action'] == 'setDept') $_SESSION['mydeptid'] = $_POST['deptId'];
