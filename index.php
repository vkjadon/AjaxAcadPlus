<?php
session_start();
//session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>AcadPlus</title>
  <?php require("css.php"); ?>
</head>

<body>
  <div class="container">
    <h1>&nbsp;</h1>
    <h1>&nbsp;</h1>
    <div class="row">
      <div class="col-sm-4">
        <div class="container card myCard">
          <div class="card-body">
            <div class="text-center mb-3">
              <img src="https://engineeringinfo.in/images/logo-text.png" width="50%">
            </div>
            <div class="form-group">
              <label class="mb-0">Institute Code</label>
              <input type="text" name="instCode" minlength="2" id="instCode" class="form-control" required />
              <label class="mt-2 mb-0">User Id</label>
              <input type="text" name="username" minlength="5" id="username" class="form-control" required />
              <label class="mt-2 mb-0">Password</label>
              <input type="password" name="userpassword" id="userpassword" class="form-control" required />
            </div>
            <div class="form-group">
              <input type="hidden" name="action" id="action" value="checkUser" />
              <button class="btn btn-sm btn-primary otp" name="otplogin" id="otplogin">OTP Login</button>
              <button class="btn btn-sm login" name="userlogin" id="userlogin">Login</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script>
    $(document).ready(function() {
      $(document).on('click', '.otp', function(event) {
        event.preventDefault(this);
        var username = $("#username").val();
        var instCode = $("#instCode").val();
        // alert("Code " + instCode.length);
        if (instCode.length > 2) {
          // alert("Code " + instCode);
          $.post("util/check_user.php", {
            username: username,
            instCode: instCode,
            action: "forgot"
          }, () => {}, "text").done(function(data) {
            alert(data);
          }).fail(function() {
            alert("One or More Credentials are NOT Correct!!");
          })
        } else alert("Please Enter a Valid Institute Code !!")
      });

      $(document).on('click', '.login', function(event) {
        event.preventDefault(this);
        var username = $("#username").val();
        var userpassword = $("#userpassword").val();
        var instCode = $("#instCode").val();
        if (instCode.length > 2) {
          $.post("util/check_user.php", {
            username: username,
            userpassword: userpassword,
            instCode: instCode,
            action: "checkUser"
          }, function(mydata, mystatus) {
            //alert(" success " + mydata.found);
          }, "json").done(function(data, mystatus) {
            // alert(data);
            // alert("Id " + data.user+ " User Found " +data.student);
            if (data.user > 0) {
              //alert(data.user+data.found);
              location.href = "module/";
            } else if (data.student > 0) {
              //alert(data.user+data.found);
              location.href = "module/student";
            } else alert("Not Found");
          }).fail(function() {
            alert("One or More Credentials are NOT Correct!!");
          })
        } else alert("Please Enter a Valid Institute Code !!")
      });



    });
  </script>

</body>

</html>