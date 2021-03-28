<?php session_start();
require("../config_database.php");
require('../config_variable.php');
require('../php_function.php');
$dept_id = getField($conn, $myId, "staff", "staff_id", "dept_id");
$school_id = getField($conn, $dept_id, "department", "dept_id", "school_id");
$prog_id = getField($conn, $dept_id, "program", "dept_id", "program_id");
$sql = "select * from session where program_id='$prog_id' order by session_id desc";
$ses_id = getFieldValue($conn, "session_id", $sql);
if ($ses_id == "") {
  $sql = "select * from session where program_id='0' and school_id='$school_id' order by session_id desc";
  $ses_id = getFieldValue($conn, "session_id", $sql);
}

if (!isset($myScl) || !isset($myProg) || !isset($mySes)) {
  $myProg = $prog_id;
  $_SESSION['mypid'] = $prog_id;

  $myScl = $school_id;
  $_SESSION['mysclid'] = $school_id;

  $mySes = $ses_id;
  $_SESSION['mysid'] = $ses_id;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Outcome Based Education : ClassConnect</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <link rel="stylesheet" href="../table.css">
  <link rel="stylesheet" href="../style.css">

</head>

<body>
  <?php require("topBar.php"); ?>
  <div class="container-fluid">
    <h1>&nbsp;</h1>
    <h6>&nbsp;</h6>
    <?php
    //require("sync_data.php");
    ?>

    <div class="navbar navbar-expand-md navbar-dark bg-dark fixed-bottom">
      <div>
        <p class="text-white">Product of EISOFTECH INC</p>
      </div>
    </div>
  </div>
</body>
<!-- MDB -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.tiny.cloud/1/xjvk0d07c7h90fry9yq9z0ljb019ujam91eo2jk8uhlun307/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  $(document).ready(function() {

    $(document).on('change', '#sel_program', function() {
      var x = $("#sel_program").val();
      //$.alert("Program Changed " + x);
      $.post("../check_user.php", {
        action: "setProgram",
        programId: x
      }, function(mydata, mystatus) {
        //alert("- Program Updated -" + mydata);
        $("#prog").html(mydata);
        selSession(x);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    })

    $(document).on('change', '#sel_session', function() {
      var x = $("#sel_session").val();
      //$.alert("Session  Changed " + x);
      $.post("../check_user.php", {
        action: "setSession",
        sessionId: x
      }, function(mydata, mystatus) {
        //alert("- Session Updated -" + mydata);
        $("#ses").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    })

    function selSession(x) {
      //$.alert("Program in Session " + x)
      $.post("../check_user.php", {
        action: "selSession",
        programId: x
      }, function(mydata, mystatus) {
        //alert("- Session Obtained -" + mydata);
        $("#sesShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }
  });
</script>

</html>