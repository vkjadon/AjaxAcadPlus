<?php
session_start();
require("../../config_database.php");
require('../../config_variable.php');
require('../../php_function.php');
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
        <div class="col-sm-2">
          <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active master" id="list-master-list" data-toggle="list" href="#list-master"> Guest Lecture </a>
            <a class="list-group-item list-group-item-action  bs" id="list-bs-list" data-toggle="list" href="#list-bs"> Industrial Visit </a>
            <a class="list-group-item list-group-item-action po" id="list-po-list" data-toggle="list" href="#list-po"> Collaborative Event </a>
          </div>
        </div>
        <div class="col-10">
          <div class="tab-content" id="nav-tabContent">

            <div class="tab-pane show active" id="list-master" role="tabpanel">
              <div class="row">
                <div class="col-5 mt-1 mb-1">
                  <div class="container card mt-2" id="myCard">
                    <h5 class="card-title">Guest Lecture Form</h5>
                    <form class="form-horizontal" id="rtForm">
                      <div class="row mt-2">
                        <div class="col-6">
                          <div class="form-group">
                            <label>Resource Type</label>
                            <input type="text" class="form-control form-control-sm" id="resource_type" name="resource_type">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label>Remarks</label>
                            <input type="text" class="form-control form-control-sm" id="resource_remarks" name="resource_remarks">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <button type="submit" class="btn btn-sm">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="col-7 mt-1 mb-1">
                  <p id="tabList"></p>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="list-bs">
              <div class="row">
                <div class="col-sm-6">
                  <button class="btn btn-secondary btn-sm addBatch">New Batch</button>
                  <p style="text-align: center;" id="batchShowList"></p>
                </div>
                <div class="col-6">
                  <button class="btn btn-secondary btn-sm addSessionButton">New Session</button>
                  <input type="hidden" id="batchId" name="batchId">
                  <p id="batchSession"></p>
                </div>
              </div>
            </div>
            <div class="tab-pane fade show" id="list-po">
              <div class="row">
                <div class="col-sm-8">
                  <button class="btn btn-sm btn-secondary m-0 addPo">Add PO</button>
                  <button class="btn btn-sm btn-primary uploadPo">Upload PO</button>
                  <div class="p-2" id="poShowList"></div>
                </div>
                <div class="col-sm-4 mt-2">
                  <h5>PO Summary [Batch - <?php echo $myBatchName; ?>]</h5>
                  <div id="poSummary"></div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="list-fs">

              <div class="row">
                <div class="col-sm-8">Form to add New Sp and Faculty List with Specialization
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <h1>&nbsp;</h1>
</body>

<?php require("../js.php"); ?>
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