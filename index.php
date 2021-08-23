<?php
session_start();
if (isset($_SESSION["setLogo"])) $setLogo = $_SESSION['setLogo'];
if (isset($_SESSION["setCodePath"])) $codePath = $_SESSION['setCodePath'];
require("util/config_database.php");
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
    <h1>&nbsp;</h1>
    <div class="row">
      
      <div class="col-sm-2"></div>
      <div class="col-sm-4">
        <div class="card myCard">
          <div class="card-body">
            <div class="text-center mb-3">
              <img src="https://engineeringinfo.in/images/logo-text.png" width="50%">
            </div>
            <form method="post" id="userForm">
              <div class="form-group">
                <label>User Id (Email for OTP)</label>
                <input type="text" name="username" minlength="5" id="username" class="form-control" />
                <label>Password</label>
                <input type="password" name="userpassword" id="userpassword" class="form-control" />
              </div>

              <div class="form-group">
                <input type="hidden" name="action" id="action" value="checkUser" />
                <button class="btn btn-sm" name="userlogin" id="userlogin">Login</button>
                <span><a href="#" class="atag otp">OTP Login</a></span>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-sm-4 bg-danger text-center">
        <p>&nbsp;</p>
        <h3 class="text-white">Welcome to </h3>
        <p>&nbsp;</p>
        <?php
        if (isset($_SESSION["myFolder"])) $myFolder = $_SESSION["myFolder"];
        else {
          echo "<h5>The institute Tag Missing. <br>Please use https://classconnect.in/acadplus/InstTag. </h5>";
          echo '<h5>For demo use https://classconnect.in/acadplus/demo. or <a href="https://classconnect.in/acadplus/demo">Click Here</a></h5>';
          die();
        }
        ?>
        <img src="<?php echo $setLogo; ?>">
        <!-- <?php echo $myFolder; ?>        -->
      </div>
      <div class="col-md-4 text-center mt-4 py-3">

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
      $('#userForm').submit(function(event) {
        event.preventDefault(this);
        var formData = $(this).serialize();
        //alert(formData);
        $.post("util/check_user.php", formData, function(mydata, mystatus) {
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
          alert("fail in place of error");
        })
      });
    });
  </script>

</body>

</html>