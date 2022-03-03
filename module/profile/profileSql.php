<?php
require('../requireSubModule.php');
//echo $_POST['action'];
if (isset($_POST['action'])) {
  if ($_POST['action'] == 'fetchStaff') {
    $sql = "select * FROM staff where staff_id='$myId'";
    $result = $conn->query($sql);
    $output = $result->fetch_assoc();
    echo json_encode($output);
  } elseif ($_POST['action'] == 'changePassword') {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];
    $error = 0;
    $msg = 'Password Successfully Changed';
    if ($newPassword <> $confirmPassword) {
      $error = '1';
      $msg = "New Password and Current Password do not Match";
    } elseif (strlen($newPassword) < 8) {
      $error = '1';
      $msg = "Password length is Less than 8 characters";
    }
    if ($error == '0') {
      $mail = getField($conn, $myId, "staff", "staff_id", "staff_email");
      $encripted = sha1($newPassword);
      $sql = "update user set user_password='$encripted' where staff_id='$myId'";
      $result = $conn->query($sql);
      if (!$result) echo $conn->error;
      else {
        $subject = "Password Change successful";
        $message = '<html><head><title>HTML email</title></head>
        <body>
        <h4>You have successfully changed your password.</h4>
        <h5>Your New password is ' . $newPassword . '</h5>
        <h4>Regards</h4>
        </body>
        </html>';

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: <info@classconnect.in>';
        mail($mail, $subject, $message, $headers);
        echo "The password is sent to registered email [" . $mail . "].";
      }
    } else echo $msg;
  }elseif ($_POST['action'] == 'staffUpdate') {
    $id = $_POST['staff_id'];
    $tag = $_POST['tag'];
    $value = $_POST['value'];
    $sql="update staff set $tag='$value' where staff_id='$id'";
    $result = $conn->query($sql);
    if (!$result) echo $conn->error;
    else echo "Updated $tag=$value";
  }
}
