<?php
session_start();
require("../../config_database.php");
require('../../config_variable.php');
require('../../php_function.php');
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
  <?php require("../css.php");?>

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
              selectList($conn, "", array(0, "program_id", "sp_name", "sp_abbri", "sel_program"), $sql)
              ?>
            </p>
          </div>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action cs" id="list-cs-list" data-toggle="list" href="#list-cs" role="tab" aria-controls="cs"> Show Classes </a>
        </div>
      </div>
      <div class="col-10">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade" id="list-stt" role="tabpanel" aria-labelledby="list-stt-list">
            <div id="sessionClassListSTT">Show TimeTable</div>
            <p id="showTimeTable"></p>
          </div>
          <div class="tab-pane fade" id="list-cs" role="tabpanel" aria-labelledby="list-cs-list">
            <div class="row">
              <div class="col-3 mt-1 mb-1">
                <p id="sessionClassList"></p>
              </div>
              <div class="col-9 mt-1 mb-1">
                <div id="showScheduleForm">
                  <div class="row">
                    <div class="col">
                      <input type="date" class="form-control form-control-sm" id="date_from" name="date_from" min="2021-01-01" value="<?php echo date("Y-m-d", time()); ?>">
                    </div>
                    <div class="col">
                      <input type="date" class="form-control form-control-sm" id="date_to" name="date_to" max="2021-02-02" value="<?php echo date("Y-m-d", time()); ?>">
                    </div>
                    <div class="col">
                      <input type="hidden" id="schedule_action" name="schedule_action">
                      <button class="btn btn-info btn-square-sm scheduleButton"></button>
                    </div>
                  </div>
                </div>
                <p id="ssClass"></p>
                <p id="showSchedule"></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php require("../bottom_bar.php");?>
  </div>
</body>
<?php require("../js.php");?>


<script>
  $(document).ready(function() {
    $(".topBarTitle").text("Communication");
    var x = $("#sel_program").val();
    $("#panelId").hide();

    $(document).on('click', '.cs', function() {
      //$.alert("TL");
      $("#selectPanelTitle").text("Create Schedule");
      $('#showScheduleForm').hide();
      $("#panelId").html("CS");
      $(".selectPanel").show();
      $(".selectClass").hide();
      $(".selectProgram").show();
      $("#clListProgram").show();
      var programId = $("#sel_program").val();
      sessionClass(programId);
    });

    $(document).on('click', '.scheduleButton', function() {
      var c = $('#ssClass').text();
      var action = $('#schedule_action').val();
      var scheduleFrom = $('#date_from').val();
      var scheduleTo = $('#date_to').val();
      //$.alert("Show Schedule Pressed " + c + " Action " + action + "<br>From " + scheduleFrom + " To " + scheduleTo);

      $.post("commSql.php", {
        action: action,
        classId: c,
        scheduleFrom: scheduleFrom,
        scheduleTo: scheduleTo
      }, function(data, status) {
        $('#showSchedule').show();
        $('#showSchedule').html(data);
      }, "text").fail(function() {
        $.alert("Fail");
      })
    });

    $(document).on('click', '.sendLink', function() {
      var sasId = $(this).attr('data-sas');
      //$.alert("SSID  " + sasId);
      $.post("commSql.php", {
        action: "sendLink",
        sasId : sasId
      }, function() {}, "text").done(function(data, status){
        $.alert("Success " + data)
      })
    });

    $(document).on('click', '.showScheduleForm', function() {
      $('#showScheduleForm').show();
      var classId = $(this).attr('id');
      $('.scheduleButton').html("Show Schedule" + classId);
      $('#schedule_action').val("showSchedule");
      $('#ssClass').text(classId);
      $('#ssClass').hide();
      //$.alert("Show Schedule Form Pressed " + c);
    });

    $(document).on('change', '#sel_program', function() {
      var programId = $("#sel_program").val();
      var panelId = $("#panelId").text();
      //$.alert("Panel Id " + panelId + programId);
      if (programId > 0 && panelId == "CS") sessionClass(programId);
      else if (programId > 0) classList(programId);
    });

    $(document).on('submit', '#modalForm', function(event) {
      event.preventDefault(this);
      var action = $("#action").val();
      //$.alert("Form Submitted " + action);
        var formData = $(this).serialize();
        $.alert(formData);
    });

    function sessionClass(x) {
      var panelId = $('#panelId').text();
      if (panelId == "STT") var actionText = 'sessionClassListSTT';
      else var actionText = 'sessionClassList';
      //$.alert("In List Function " + actionText + "Panel " + panelId);
      $.post("commSql.php", {
        action: actionText,
        programId: x
      }, function(data, status) {
        //$.alert("Success " + data);
        if (panelId == "STT") $("#sessionClassListSTT").html(data);
        else $("#sessionClassList").html(data);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

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
    <form class="form-horizontal" id="modalForm">
      <div class="modal-content bg-secondary text-white">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->

        <!-- Modal body -->
        <div class="modal-body">
        </div> <!-- Modal Body Closed-->

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="modalId" name="modalId">
          <input type="hidden" id="action" name="action">

          <button type="submit" class="btn btn-success btn-sm" id="submitModalForm"></button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->

    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

</html>