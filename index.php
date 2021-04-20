<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>AcadPlus</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<?php require("config_database.php"); ?>
<?php require("config_variable.php"); ?>

<body>
  <h1 class="display-3"> AcadPlus LMS </h1>
  <div class="container">
    <h1>&nbsp;</h1>
    <div class="row">
      <div class="col-4">
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <?php 
        if(isset($_SESSION["myFolder"]))$myFolder=$_SESSION["myFolder"];
        else {
          echo "<h5>The institute Tag Missing. <br>Please use https://classconnect.in/acadplus/InstTag. </h5>";
          echo '<h5>For demo use https://classconnect.in/acadplus/demo. or <a href="https://classconnect.in/acadplus/demo">Click Here</a></h5>';
          die();
        }
        ?>
        <img src="<?php echo $setLogo;?>"> 
        <?php // echo $myFolder;?>       
      </div>
      <div class="col-4">
        <div class="card bg-secondary text-white">
          <h3 class="text-center">AcadPlus Login</h1>
            <div class="card-body">
              <form method="post" id="userForm">
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" name="username" minlength="5" id="username" class="form-control" />
                  <span id="username_error" class="text-warning"></span>
                  <label>Password</label>
                  <input type="password" name="userpassword" id="userpassword" class="form-control" />
                  <span id="userpassword_error" class="text-warning"></span>
                </div>

                <div class="form-group">
                <input type="hidden" name="action" id="action" value="checkUser" />
                <input type="submit" name="userlogin" id="userlogin" class="btn btn-info btn-block" value="Login" />
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
        $.post("check_user.php", formData, function(mydata, mystatus) {
          //alert(" success " + mydata.found);
        }, "json").done(function(data, mystatus) {
          alert("Id " + data.user+ " User Found " +data.student);
          if(data.user>0)
          {
            alert(data.user+data.found);
            location.href = "module/";
          }
          else if(data.student>0)
          {
            //alert(data.user+data.found);
            location.href = "module/student";
          }
          else alert("Not Found");
        }).fail(function() {
          alert("fail in place of error");
        })
      });
    });
  </script>

</body>

</html>