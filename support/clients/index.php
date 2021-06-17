<?php
session_start();
require("../config_database.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>AcadPlus</title>
  <?php require("../../css.php"); ?>
</head>

<body>
  <h1 class="display-3"> ClassConnect-Clients </h1>
  <div class="container">
    <h1>&nbsp;</h1>
    <div class="row">
      <div class="col-4">
        <div class="card myCard">
          <div class="card-body">
            <h3 class="card-title">Demo</h3>
            <div class="form-group">
              <a href="http://localhost/acadplus/module/?myFolder=demo" class="atag btn btn-sm" id="demo">Demo</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
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
            location.href = "clients/";
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