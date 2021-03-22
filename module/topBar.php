<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" ></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">

<!--Navbar-->
<nav class="navbar navbar-expand-lg fixed-top navbar-dark primary-color ">

  <!-- Navbar brand -->
  <a class="navbar-brand" href="../">ACADPLUS</a>

  <!-- Collapse button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
    aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Collapsible content -->
  <div class="collapse navbar-collapse" id="basicExampleNav">

    <!-- Links -->
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home
          <span class="sr-only">(current)</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>

      <!-- Dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">Dropdown</a>
        <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>

    </ul>
    <!-- Links -->

    <form class="form-inline">
      <div class="md-form my-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      </div>
    </form>
  </div>
  <!-- Collapsible content -->

</nav>
<!--/.Navbar-->
<!--/.Navbar -->


<!-- <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
    <div class="navbar-nav">
      <a href="../" class="nav-item nav-link active">Home</a>
      <div class="nav-item dropdown">
        <a href="academics/" class="nav-link dropdown-toggle" data-toggle="dropdown">Administration</a>
        <div class="dropdown-menu menuDouble">
          <div class="row">
            <div class="col-6">
              <a href="<?php echo $codePath . '/module/inst/'; ?>" class="dropdown-item">SetUp Institite</a>
              <a href="<?php echo $codePath . '/module/admission/'; ?>" class="dropdown-item">Admission</a>
              <a href="<?php echo $codePath . '/module/approval/'; ?>" class="dropdown-item">Approvals</a>
            </div>
            <div class="col-6">
              <a href="<?php echo $codePath . '/module/sop/'; ?>" class="dropdown-item">SOP</a>
              <a href="<?php echo $codePath . '/module/committee/'; ?>" class="dropdown-item">Committees</a>
            </div>
          </div>
        </div>
      </div>

      <div class="nav-item dropdown">
        <a href="academics/" class="nav-link dropdown-toggle" data-toggle="dropdown">Academics</a>
        <div class="dropdown-menu menuDouble">
          <div class="row">
            <div class="col-6">
              <a href="<?php echo $codePath . '/module/aa/'; ?>" class="dropdown-item">Setting </a>
              <a href="<?php echo $codePath . '/module/schedule/'; ?>" class="dropdown-item">Schedule</a>
              <a href="<?php echo $codePath . '/module/registration/'; ?>" class="dropdown-item">Registration</a>
            </div>
            <div class="col-6">
              <a href="<?php echo $codePath . '/module/lms/'; ?>" class="dropdown-item">LMS</a>
              <a href="<?php echo $codePath . '/module/online/'; ?>" class="dropdown-item">Online Assessment</a>
            </div>
          </div>
        </div>
      </div>

      <div class="nav-item dropdown">
        <a href="academics/" class="nav-link dropdown-toggle" data-toggle="dropdown">Examination</a>
        <div class="dropdown-menu menuDouble">
          <div class="row">
            <div class="col-6">
              <a href="<?php echo $codePath . '/module/comm/'; ?>" class="dropdown-item"> Conduct </a>
              <a href="<?php echo $codePath . '/module/comm/'; ?>" class="dropdown-item"> Evaluation </a>
            </div>
            <div class="col-6">
              <a href="<?php echo $codePath . '/module/feedback/'; ?>" class="dropdown-item"> Internal Assessment </a>
              <a href="<?php echo $codePath . '/module/feedback/'; ?>" class="dropdown-item"> Semester Result </a>
            </div>
          </div>
        </div>
      </div>

      <div class="nav-item dropdown">
        <a href="academics/" class="nav-link dropdown-toggle" data-toggle="dropdown">Communication</a>
        <div class="dropdown-menu menuDouble">
          <div class="row">
            <div class="col-6">
              <a href="<?php echo $codePath . '/module/comm/'; ?>" class="dropdown-item"> Email </a>
              <a href="<?php echo $codePath . '/module/comm/'; ?>" class="dropdown-item"> SMS </a>
            </div>
            <div class="col-6">
              <a href="<?php echo $codePath . '/module/feedback/'; ?>" class="dropdown-item"> Feedback </a>
              <a href="<?php echo $codePath . '/module/feedback/'; ?>" class="dropdown-item"> Mentoring </a>
            </div>
          </div>
        </div>
      </div>

      <div class="nav-item dropdown">
        <a href="academics/" class="nav-link dropdown-toggle" data-toggle="dropdown">HR</a>
        <div class="dropdown-menu">
          <a href="<?php echo $codePath . '/module/leave/'; ?>" class="dropdown-item"> Leave </a>
          <a href="<?php echo $codePath . '/module/support/'; ?>" class="dropdown-item"> Support </a>
        </div>
      </div>

      <div class="nav-item dropdown">
        <a href="academics/" class="nav-link dropdown-toggle" data-toggle="dropdown">eOffice</a>
        <div class="dropdown-menu">
          <a href="<?php echo $codePath . '/module/office/'; ?>" class="dropdown-item"> eOffice </a>
        </div>
      </div>

      <div class="nav-item dropdown">
        <a href="academics/" class="nav-link dropdown-toggle" data-toggle="dropdown">OBE</a>
        <div class="dropdown-menu">
          <a href="<?php echo $codePath . '/module/obe/'; ?>" class="dropdown-item"> CO Attainment </a>
          <a href="<?php echo $codePath . '/module/obeFeedback/'; ?>" class="dropdown-item"> OBE Feedback </a>
          <a href="<?php echo $codePath . '/module/obe/'; ?>" class="dropdown-item"> PO Attainment </a>
        </div>
      </div>

    </div>
    <div class="navbar-nav">
      <a href="<?php echo $codePath . '/module/profile/'; ?>" class="nav-item nav-link">Profile</a>
      <a href="<?php echo $codePath . '/logout.php'; ?>" class="nav-item nav-link">Logout</a>
    </div>
  </div>
</nav> -->

<!-- <nav class="navbar fixed-top bg-secondary text-white">
  <a class="navbar-brand" href="../">
  <img src="<?php echo $setLogo; ?>" width="60%">
</a>
  <h1 class="display-4 topBarTitle"></h1>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item active">
      <a class="navbar-brand text-white topBarText" href="../">Home</a>
      <span class="navbar-brand text-white topBarText">[<?php echo $myUn . $myId; ?>]<?php echo $myFolder; ?></span>
      <span class="navbar-brand text-white topBarText"><?php echo getField($conn, $myProg, "program", "program_id", "sp_abbri"); ?></span>
      <span class="navbar-brand text-white topBarText">[<?php if (isset($mySes)) echo getField($conn, $mySes, "session", "session_id", "session_name"); ?>]</span>
      <a class="navbar-brand text-white topBarText" href="../../logout.php">Logout</a>
    </li>
  </ul>
</nav> -->
<h1>&nbsp;</h1><h5>&nbsp;</h5>