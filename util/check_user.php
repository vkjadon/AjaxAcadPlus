<?php
session_start();
require("config_database.php");
require("../php_function.php"); 
require("config_variable.php");

if ($_POST['action'] == 'checkUser') {
  $myUn = $_POST['username'];
  $myPwd = $_POST['userpassword'];
  $response = array();
  $sql = "select * from staff where user_id='$myUn'";
  $result = $conn->query($sql);
  if ($result && $result->num_rows > 0) {
    $rows = $result->fetch_assoc();
    $response["found"] = 'yes';
    $response["user"] = $rows["staff_id"];
    $jsonOutput = json_encode($response);

    echo $jsonOutput;
    $_SESSION['myid'] = $rows["staff_id"];
    $_SESSION['un'] = $myUn;
    $_SESSION['pwd'] = $myPwd;
  } elseif (!$result) {
    echo $conn->error;
  } else {
    $response["found"] = 'no';
    $jsonOutput = json_encode($response);
    echo $jsonOutput;
  }
  /*$url = $setUrl . '/acadplus/api/check_user.php?u=' . $myUn . '&&p=' . $myPwd . '&&mf=' . $myFolder;
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  $output = curl_exec($curl);
  $id = json_decode($output, true);
  curl_close($curl);
  echo $output;*/
  //$id = json_decode($output, true);
} elseif ($_POST['action'] == 'setProgram') $_SESSION['mypid'] = $_POST['programId'];
elseif ($_POST['action'] == 'setSession') $_SESSION['mysid'] = $_POST['sessionId'];
elseif ($_POST['action'] == 'setSchool') $_SESSION['mysclid'] = $_POST['schoolId'];
elseif ($_POST['action'] == 'setDept') $_SESSION['mydeptid'] = $_POST['deptId'];
elseif ($_POST['action'] == 'setBatch') $_SESSION['myBatch'] = $_POST['batchId'];
