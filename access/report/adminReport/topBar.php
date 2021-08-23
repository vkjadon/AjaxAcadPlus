<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <!-- <a href="#" class="navbar-brand">Brand</a> -->
  <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
    <div class="navbar-nav">
      <a href="../" class="nav-item nav-link active">Home</a>
      <div class="nav-item dropdown">
        <a href="academics/" class="nav-link dropdown-toggle" data-toggle="dropdown">Student</a>
        <div class="dropdown-menu menuDouble">
          <div class="row">
            <div class="col-6">
              <a href="<?php echo $codePath . '/module/inst/'; ?>" class="dropdown-item">Attendance</a>
            </div>
            <div class="col-6">
            <a href="<?php echo $codePath . '/module/admission/'; ?>" class="dropdown-item">Marks</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="navbar-nav">
      <a href="<?php echo $codePath . '/logout.php'; ?>" class="nav-item nav-link">Logout</a>
    </div>
  </div>
</nav>
<h1>&nbsp;</h1>