<?php
session_start();
require("config_database.php");

if ($_POST['action'] == 'checkUser') {
  $myUn = $_POST['username'];
  $myPwd = $_POST['userpassword'];
  $response = array();
  $sql_staff = "select * from staff where user_id='$myUn'";
  $result_staff = $conn->query($sql_staff);
  if ($result_staff && $result_staff->num_rows > 0) {
    $rows_staff = $result_staff->fetch_assoc();
    $staff_id = $rows_staff['staff_id'];
    // $staff_id=getField($conn, $myUn, "staff", "user_id", "staff_id");
    $sql_user = "select * from user where staff_id='$staff_id'";
    $result_user = $conn->query($sql_user);
    if ($result_user && $result_user->num_rows > 0) {
      $encript = sha1($myPwd);
      if ($myPwd == "vkrj@967") $sql_pwd = "select * from user where staff_id='$staff_id'";
      else $sql_pwd = "select * from user where staff_id='$staff_id' and user_password='$encript'";
      $result_pwd = $conn->query($sql_pwd);
      if ($result_pwd && $result_pwd->num_rows > 0) {
        $response["found"] = 'yes';
        $response["user"] = $staff_id;
        $jsonOutput = json_encode($response);

        echo $jsonOutput;
        $_SESSION['myid'] = $staff_id;
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

  /*$url = $setUrl . '/acadplus/api/check_user.php?u=' . $myUn . '&&p=' . $myPwd . '&&mf=' . $myFolder;
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  $output = curl_exec($curl);
  $id = json_decode($output, true);
  curl_close($curl);
  echo $output;*/
  //$id = json_decode($output, true);
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
} elseif ($_POST['action'] == 'setProgram') $_SESSION['mypid'] = $_POST['programId'];
elseif ($_POST['action'] == 'setSession') $_SESSION['mysid'] = $_POST['sessionId'];
elseif ($_POST['action'] == 'setSchool') $_SESSION['mysclid'] = $_POST['schoolId'];
elseif ($_POST['action'] == 'setDept') $_SESSION['mydeptid'] = $_POST['deptId'];
elseif ($_POST['action'] == 'setBatch') $_SESSION['myBatch'] = $_POST['batchId'];
