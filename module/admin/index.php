<?php
require('../requireSubModule.php');
?>
<!DOCTYPE html>
<html lang="en">

<style>
  input[type=text] {
    border: none;
    border-bottom: 2px solid;
    word-wrap: break-word;
  }
</style>

<head>
  <title>Outcome Based Education : ClassConnect</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <link rel="stylesheet" href="../../table.css">
  <link rel="stylesheet" href="../../style.css">
</head>

<body>
  <?php require("../topBar.php"); ?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-2">
        <div class="card text-center selectPanel">
          <span id="panelId"></span>
          <span class="m-1 p-0" id="selectPanelTitle"></span>
          <div class="col">
            <p class="selectProgram">
              <?php
              $sql = "select * from program where program_status='0'";
              selectList($conn, "", array(0, "program_id", "program_name", "sp_abbri", "sel_program"), $sql)
              ?>
            </p>
          </div>
        </div>

        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">

          <a class="list-group-item list-group-item-action active rt1" id="list-rt1-list" data-toggle="list" href="#list-rt1" role="tab" aria-controls="rt1"> Right Tab-1 </a>

          <a class="list-group-item list-group-item-action rt2" id="list-rt2-list" data-toggle="list" href="#list-rt2" role="tab" aria-controls="rt2"> Right Tab-2 </a>
        </div>
      </div>

      <div class="col-10">
        <div class="tab-content" id="nav-tabContent">

          <div class="tab-pane show active" id="list-rt1" role="tabpanel" aria-labelledby="list-rt1-list">
            <div class="row">
              <div class="col-5 mt-1 mb-1"><button class="btn btn-secondary btn-square-sm mt-1 addNew1">New1</button>
                <p id="rt1List"></p>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="list-rt2" role="tabpanel" aria-labelledby="list-rt2-list">
            <div class="row">
              <div class="col-8 mt-1 mb-1"><button class="btn btn-secondary btn-square-sm mt-1 addNew2">New2</button>
                <p id="rt2List"></p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
    <?php require("../bottom_bar.php");?>
  </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script>
  $(document).ready(function() {
    $(document).on('click', '.checkAll', function() {
      var id = $("#panelId").text();
      //$.alert("Panel Id" + id);
      if (id == "CS") $('.sclCS').prop('checked', true); // Checks it
      else $('.scb').prop('checked', true); // Checks it

    });

    $(document).on('click', '.uncheckAll', function() {
      var id = $("#panelId").text();
      //$.alert("Panel Id" + id);
      if (id == "CS") $('.sclCS').prop('checked', false);
      else $('.scb').prop('checked', false);

    });

    $(".topBarTitle").text("Not Subscribed!!");
    $(".selectPanel").show();
    $("#panelId").hide();

    $(document).on('click', '.addNew1', function() {
      $.alert("New-1 Pressed");
      $('#firstModal').modal().show;
      $('#modal_title').html("New Modal");
    });


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

<!-- Modal Section-->
<div class="modal" id="firstModal">
  <div class="modal-dialog modal-md">
    <div class="modal-content bg-secondary text-white">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title" id="modal_title">fdf</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div> <!-- Modal Header Closed-->

      <!-- Modal body -->
      <div class="modal-body">dfd
      </div> <!-- Modal Body Closed-->

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
      </div> <!-- Modal Footer Closed-->
    </div> <!-- Modal Conent Closed-->

  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->


</html>