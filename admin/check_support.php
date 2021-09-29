<?php
session_start();
require("config_database.php");
if ($_POST['action'] == 'checkUser') {
  $myUn = $_POST['username'];
  $myPwd = $_POST['userpassword'];
  $instCode = $_POST['instCode'];
  $response = array();
  $sql="select * from staff where staff_email='$myUn' and staff_status='0'";
  $result=$conn->query($sql);
  if($result && $result->num_rows>0){
    $rows=$result->fetch_assoc();
    $response["found"] = 'yes';
    $response["user"] = $rows["staff_id"];
    $jsonOutput = json_encode($response);

    echo $jsonOutput;
    $_SESSION['myid'] = $rows["staff_id"];
    $_SESSION['un'] = $myUn;
    $_SESSION['pwd'] = $myPwd;
    $_SESSION['instCode'] = $instCode;
  }
  else{
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
}
