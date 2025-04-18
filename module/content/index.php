<?php
require('../requireSubModule.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Outcome Based Education : ClassConnect</title>
  <?php require('../css.php'); ?>
</head>

<body>
  <?php require("../topBar.php"); ?>
  <div class="content">
    <div class="container-fluid moduleBody">
      <div class="row">
      <div class="col-1 p-0 m-0 pl-1 full-height">
          <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action show active cc" id="list-cc-list" data-toggle="list" href="#list-cc" role="tab" aria-controls="cc"> Constitute Committees </a>
            <a class="list-group-item list-group-item-action com" id="list-com-list" data-toggle="list" href="#list-com" role="tab" aria-controls="com"> Communications </a>
            <a class="list-group-item list-group-item-action mom" id="list-mom-list" data-toggle="list" href="#list-mom" role="tab" aria-controls="mom"> MoM Points </a>
            <a class="list-group-item list-group-item-action cdreport" id="list-cdreport-list" data-toggle="list" href="#list-cdreport" role="tab" aria-controls="cdreport"> Curriculum Report </a>
          </div>
        </div>
        <div class="col-11 leftLinkBody">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="list-cc" role="tabpanel" aria-labelledby="list-cc-list">
              <div class="row">
                <div class="col-sm-8 p-0">
                  <button class="btn btn-sm btn-secondary addSubject">New Committee</button>
                </div>
                <div class="col-sm-4">
                  <div>
                    <h5>Committees involved in Curriculum Design</h5>
                    Feedback Design, Feedback Analysis, Action Taken, Department Academic Affair, Board of Studies
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="list-com" role="tabpanel" aria-labelledby="list-com-list">
            </div>
          </div>
        </div>
      </div>
      <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php require("../bottom_bar.php");?>
    </div>
  </div>
  <h1>&nbsp;</h1>
</body>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
  $(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip();
    $(".topBarTitle").text("Academics");

    function getFormattedDate(ts, fmt) {
      var a = new Date(ts);
      var day = a.getDate();
      var month = a.getMonth() + 1;
      var year = a.getFullYear();
      var date = day + '-' + month + '-' + year;
      var dateYmd = year + '-' + month + '-' + day;
      if (fmt == "dmY") return date;
      else return dateYmd;
    }

  });
</script>

</html>