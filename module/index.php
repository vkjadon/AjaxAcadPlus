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
  <title>AcadPlus</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <link rel="stylesheet" href="../table.css">
  <link rel="stylesheet" href="../style.css">

</head>

<body>
  <nav class="navbar fixed-top bg-secondary text-white">
    <!-- <a class="navbar-brand" href="#">
      <img src="<?php echo $setLogo; ?>" width="60%">
    </a> -->
    <h1 class="display-4">AcadPlus</h1>
    <div class="text-right">
      <span class="navbar-brand text-white topBarText">[<?php echo $myUn; ?>]<?php echo $myFolder; ?></span>
      <a class="navbar-brand text-white topBarText" href="../logout.php">Logout</a>
    </div>
  </nav>

  <div class="container-fluid bg-light">
    <h1>&nbsp;</h1>
    <h6>&nbsp;</h6>
    <?php
    require("sync_data.php");
    ?>

    <div class="row">
      <div class="col-2 mr-1 mb-1 ml-1" style="background-color: rgb(220, 220, 220)">
        <h6 class="text-center p-2">Frequently Used</h6>
        <a href="aa/"> Academics </a>
        <?php
        echo "School $myScl Prog $myProg Ses $mySes"; ?>
      </div>
      <div class="col-9">
        <div class="row">
          <div class="card bg-primary mr-1 mb-1">
            <a href="aa/" class="text-warning btn">
              <div class="card-body py-0">
                <h1 class="display-4">Academics</h1>
              </div>
            </a>
          </div>
          <div class="card bg-warning mr-1 mb-1">
            <a href="notsub/" class="text-danger btn">
              <div class="card-body py-0">
                <h1 class="display-4">Accounts</h1>
              </div>
            </a>
          </div>
          <div class="card bg-info mr-1 mb-1">
            <a href="admission/" class="text-warning btn">
              <div class="card-body py-0">
                <h1 class="display-4">Admission</h1>
              </div>
            </a>
          </div>
          <div class="card bg-danger mr-1 mb-1">
            <a href="admin/" class="btn">
              <div class="card-body py-0">
                <h1 class="display-4">Admin</h1>
              </div>
            </a>
          </div>
          <div class="card bg-warning mr-1 mb-1">
            <a href="approval/" class="text-danger btn">
              <div class="card-body py-0">
                <h1 class="display-4">Approvals</h1>
              </div>
            </a>
          </div>
          <div class="card bg-success mr-1 mb-1">
            <a href="comm/" class="btn text-white">
              <div class="card-body py-0">
                <h1 class="display-4">Comm</h1>
              </div>
            </a>
          </div>
          <div class="card bg-danger mr-1 mb-1">
            <a href="dept/" class="btn text-white">
              <div class="card-body py-0">
                <h1 class="display-4">Dept</h1>
              </div>
            </a>
          </div>
          <div class="card bg-secondary mr-1 mb-1">
            <a href="notsub/" class="btn text-white">
              <div class="card-body py-0">
                <h1 class="display-4">ECA</h1>
              </div>
            </a>
          </div>
          <div class="card bg-primary mr-1 mb-1">
            <a href="office/" class="btn text-white">
              <div class="card-body py-0">
                <h1 class="display-4">eOffice</h1>
              </div>
            </a>
          </div>
          <div class="card bg-info mr-1 mb-1">
            <a href="exam/" class="text-warning btn">
              <div class="card-body py-0">
                <h1 class="display-4">Exam</h1>
              </div>
            </a>
          </div>
          <div class="card bg-success mr-1 mb-1">
            <a href="feedback/" class="btn">
              <div class="card-body py-0">
                <h1 class="display-4">Feedback</h1>
              </div>
            </a>
          </div>
          <div class="card bg-primary mr-1 mb-1">
            <a href="hr/" class="text-white btn">
              <div class="card-body py-0">
                <h1 class="display-4">HR</h1>
              </div>
            </a>
          </div>
          <div class="card bg-secondary mr-1 mb-1">
            <a href="inst/" class="text-white btn">
              <div class="card-body py-0">
                <h1 class="display-4">Institute</h1>
              </div>
            </a>
          </div>
          <div class="card bg-warning mr-1 mb-1">
            <a href="library/" class="btn">
              <div class="card-body py-0">
                <h1 class="display-4">Library</h1>
              </div>
            </a>
          </div>
          <div class="card bg-dark mr-1 mb-1">
            <a href="leave/" class="text-warning btn">
              <div class="card-body py-0">
                <h1 class="display-4">Leave</h1>
              </div>
            </a>
          </div>
          <div class="card bg-primary mr-1 mb-1">
            <a href="lms/" class="text-white btn">
              <div class="card-body py-0">
                <h1 class="display-4">LMS</h1>
              </div>
            </a>
          </div>
          <div class="card bg-secondary mr-1 mb-1">
            <a href="notsub/" class="btn">
              <div class="card-body py-0">
                <h1 class="display-4">Mentoring</h1>
              </div>
            </a>
          </div>
          <div class="card bg-danger mr-1 mb-1">
            <a href="obe/" class="text-white btn">
              <div class="card-body py-0">
                <h1 class="display-4">OBE</h1>
              </div>
            </a>
          </div>
          <div class="card bg-info mr-1 mb-1">
            <a href="notsub/" class="btn">
              <div class="card-body py-0">
                <h1 class="display-4">R&D</h1>
              </div>
            </a>
          </div>
          <div class="card bg-warning mr-1 mb-1">
            <a href="registration/" class="text-danger btn">
              <div class="card-body py-0">
                <h1 class="display-4">Registration</h1>
              </div>
            </a>
          </div>
          <div class="card bg-secondary mr-1 mb-1">
            <a href="notsub/" class="text-white btn">
              <div class="card-body py-0">
                <h1 class="display-4">Result</h1>
              </div>
            </a>
          </div>
          <div class="card bg-success mr-1 mb-1">
            <a href="notsub/" class="text-white btn">
              <div class="card-body py-0">
                <h1 class="display-4">SA</h1>
              </div>
            </a>
          </div>
          <div class="card bg-danger mr-1 mb-1">
            <a href="schedule/" class="text-warning btn">
              <div class="card-body py-0">
                <h1 class="display-4">Schedule</h1>
              </div>
            </a>
          </div>
          <div class="card bg-primary mr-1 mb-1">
            <a href="notsub/" class="btn text-white">
              <div class="card-body py-0">
                <h1 class="display-4">Store</h1>
              </div>
            </a>
          </div>
          <div class="card bg-secondary mr-1 mb-1">
            <a href="student/" class="btn text-white">
              <div class="card-body py-0">
                <h1 class="display-4">Student</h1>
              </div>
            </a>
          </div>

        </div>
      </div>
    </div>

    <div class="navbar navbar-expand-md navbar-dark bg-dark fixed-bottom">
      <div>
        <p class="text-white">Product of EISOFTECH INC</p>
      </div>
    </div>
  </div>
</body>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap-extended.min.css">
<link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/fonts/simple-line-icons/style.min.css">
<link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/colors.min.css">
<link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
<link rel="stylesheet" href="card.css">

<div class=" grey-bg  container-fluid col-4 offset-8">
  <div class="row">
    <div class="col-4 mr-0 p-0">
      <?php
      $sql = "select * from school where school_id='$school_id'";
      selectList($conn, "", array("2", "school_id", "school_abbri", "", "sel_school"), $sql);
      ?>
    </div>
    <div class="col-4 ml-0 p-0">
      <p id="sesShowList">
        <?php
        //$sql = "select * from session where school_id='$school_id' order by session_id desc";
        $sql = "select * from session where session_status='0' order by session_id desc";
        selectList($conn, "", array("2", "session_id", "session_name", "session_remarks", "sel_session"), $sql);
        ?>
      </p>
    </div>
    <div class="col-4 ml-0 p-0">
      <p id="progShowList">
        <?php
        $sql = "select * from program where program_status='0'";
        selectList($conn, "", array("2", "program_id", "sp_name", "sp_abbri", "sel_prog"), $sql);
        ?>
      </p>
    </div>
  </div>
</div>
<div class="grey-bg container-fluid">
  <section id="minimal-statistics">
    <div class="row">
      <div class="col-12 mt-3 mb-1">
        <h4 class="text-uppercase">Minimal Statistics Cards</h4>
        <p>Statistics on minimal cards.</p>
      </div>
    </div>
    <div class="row">
      <div class="col-2">
        <div class="h-100">
          <div class="card ">
            <div class="card-content">
              <div class="card-body">
                <div class="media d-flex">
                  <div class="align-self-center">
                  </div>
                  <div class="media-body text-left">
                    <h6 class="text-uppercase">Frequently Used</h6>
                    <a href="aa/"> Academics </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-10">
        <div class="row">
          <div class="col-xl-4 col-sm-6 col-12">
            <div class="card">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="align-self-center">
                      <i class="icon-user-follow primary font-large-2 float-left"></i>
                    </div>
                    <div class="media-body text-right">
                      <a href="aa/">
                        <h3>Admission</h3>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-4 col-sm-6 col-12">
            <div class="card">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="align-self-center">
                      <i class="icon-notebook warning font-large-2 float-left"></i>
                    </div>
                    <div class="media-body text-right">
                      <a href="aa/">
                        <h3>Academics</h3>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-sm-6 col-12">
            <div class="card">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="align-self-center">
                      <i class="icon-graph success font-large-2 float-left"></i>
                    </div>
                    <div class="media-body text-right">
                      <a href="hr/">
                        <h3>Human Resource</h3>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="row">
          <div class="col-xl-4 col-sm-6 col-12">
            <div class="card">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="align-self-center">
                      <i class="icon-pointer danger font-large-2 float-left"></i>
                    </div>
                    <div class="media-body text-right">
                    <a href="institute/">
                        <h3>Institute</h3>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-sm-6 col-12">
            <div class="card">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="media-body text-left">
                    <a href="dept/">
                        <h3>Department</h3>
                      </a>
                    </div>
                    <div class="align-self-center">
                      <i class="icon-rocket danger font-large-2 float-right"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-sm-6 col-12">
            <div class="card">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="media-body text-left">
                    <a href="lms/">
                        <h3>LMS</h3>
                      </a>
                    </div>
                    <div class="align-self-center">
                      <i class="icon-direction danger font-large-2 float-right"></i>
                    </div>
                  </div>
                  <div class="progress mt-1 mb-0" style="height: 7px;">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="row">

          <div class="col-xl-4 col-sm-6 col-12">
            <div class="card">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="media-body text-left">
                    <a href="registration/">
                        <h3>Registration</h3>
                      </a>
                    </div>
                    <div class="align-self-center">
                      <i class="icon-user success font-large-2 float-right"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-4 col-sm-6 col-12">
            <div class="card">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="media-body text-left">
                    <a href="result/">
                        <h3>Result</h3>
                      </a>
                    </div>
                    <div class="align-self-center">
                      <i class="icon-pie-chart warning font-large-2 float-right"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-sm-6 col-12">
            <div class="card">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="media-body text-left">
                    <a href="aa/">
                        <h3>Academics</h3>
                      </a>
                    </div>
                    <div class="align-self-center">
                      <i class="icon-support primary font-large-2 float-right"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xl-4 col-sm-6 col-12">
            <div class="card">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="media-body text-left">
                    <a href="aa/">
                        <h3>Academics</h3>
                      </a>
                    </div>
                    <div class="align-self-center">
                      <i class="icon-book-open primary font-large-2 float-right"></i>
                    </div>
                  </div>
                  <div class="progress mt-1 mb-0" style="height: 7px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-sm-6 col-12">
            <div class="card">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="media-body text-left">
                    <a href="aa/">
                        <h3>Academics</h3>
                      </a>
                    </div>
                    <div class="align-self-center">
                      <i class="icon-bubbles warning font-large-2 float-right"></i>
                    </div>
                  </div>
                  <div class="progress mt-1 mb-0" style="height: 7px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-4 col-sm-6 col-12">
            <div class="card">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="media-body text-left">
                    <a href="aa/">
                        <h3>Academics</h3>
                      </a>
                    </div>
                    <div class="align-self-center">
                      <i class="icon-cup success font-large-2 float-right"></i>
                    </div>
                  </div>
                  <div class="progress mt-1 mb-0" style="height: 7px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>


  </section>

  <section id="stats-subtitle">
    <div class="row">
      <div class="col-12 mt-3 mb-1">
        <h4 class="text-uppercase">Statistics With Subtitle</h4>
        <p>Statistics on minimal cards with Title &amp; Sub Title.</p>
      </div>
    </div>

    <div class="row">
      <div class="col-xl-6 col-md-12">
        <div class="card overflow-hidden">
          <div class="card-content">
            <div class="card-body cleartfix">
              <div class="media align-items-stretch">
                <div class="align-self-center">
                  <i class="icon-pencil primary font-large-2 mr-2"></i>
                </div>
                <div class="media-body">
                  <h4>Total Posts</h4>
                  <span>Monthly blog posts</span>
                </div>
                <div class="align-self-center">
                  <h1>18,000</h1>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-6 col-md-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body cleartfix">
              <div class="media align-items-stretch">
                <div class="align-self-center">
                  <i class="icon-speech warning font-large-2 mr-2"></i>
                </div>
                <div class="media-body">
                  <h4>Total Comments</h4>
                  <span>Monthly blog comments</span>
                </div>
                <div class="align-self-center">
                  <h1>84,695</h1>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xl-6 col-md-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body cleartfix">
              <div class="media align-items-stretch">
                <div class="align-self-center">
                  <h1 class="mr-2">$76,456.00</h1>
                </div>
                <div class="media-body">
                  <h4>Total Sales</h4>
                  <span>Monthly Sales Amount</span>
                </div>
                <div class="align-self-center">
                  <i class="icon-heart danger font-large-2"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-6 col-md-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body cleartfix">
              <div class="media align-items-stretch">
                <div class="align-self-center">
                  <h1 class="mr-2">$36,000.00</h1>
                </div>
                <div class="media-body">
                  <h4>Total Cost</h4>
                  <span>Monthly Cost</span>
                </div>
                <div class="align-self-center">
                  <i class="icon-wallet success font-large-2"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
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