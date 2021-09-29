<?php
session_start();
require("config_database.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>AcadPlus</title>
  <?php require("../css.php"); ?>
</head>

<body>
  <h1 class="display-3"> ClassConnect-Support </h1>
  <div class="container">
    <h1>&nbsp;</h1>
    <div class="row">
      <div class="col-4">
        <p>&nbsp;</p>
        <p>&nbsp;</p>

        <img src="<?php //echo $setLogo;
                  ?>">
        <?php //echo $myFolder;
        ?>
      </div>
      <div class="col-4">
        <div class="card myCard">
          <div class="card-body">
            <h3 class="card-title">Connect</h3>
            <form method="post" id="userForm">
              <div class="form-group">
                <label>Email for OTP</label>
                <input type="text" name="username" minlength="5" id="username" class="form-control" />
                <label>Password</label>
                <input type="password" name="userpassword" id="userpassword" class="form-control" />
                <label>Institute Code</label>
                <input type="text" name="instCode" id="instCode" class="form-control" />
              </div>
              <div class="form-group">
                <input type="hidden" name="action" id="action" value="checkUser" />
                <button class="btn btn-sm" name="userlogin" id="userlogin">Login</button>
              </div>
            </form>
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
      $('#userForm').submit(function(event) {
        event.preventDefault(this);
        var formData = $(this).serialize();
        //alert(formData);
        $.post("check_support.php", formData, function(mydata, mystatus) {
          //alert(" success " + mydata.found);
        }, "json").done(function(data, mystatus) {
          // alert(data);
          // alert("Id " + data.user+ " User Found " +data.student);
          if (data.user > 0) {
            //alert(data.user+data.found);
            location.href = "setup/";
          } else alert("Not Found");
        }).fail(function() {
          alert("fail in place of error");
        })
      });
    });
  </script>

</body>

</html>