<?php
session_start();
require("../../config_database.php");
require('config_variable.php');
require('php_function.php');
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
  <?php
  $myProg = getField($conn, $myStdId, "student", "student_id", "program_id");
  //$mySes = getField($conn, $myProg, "session", "program_id", "session_id");

  require("topBarStd.php"); ?>
  <div class="container-fluid">
    <h1>&nbsp;</h1>
    <h4>&nbsp;</h4>
    <div class="row">
      <div class="col-2">
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <p id="session"></p>
          <a class="list-group-item list-group-item-action active sea" id="list-sea-list" data-toggle="list" href="#list-sea" role="tab" aria-controls="sea"> Subject Extra Attendance </a>
          <a class="list-group-item list-group-item-action eacf" id="list-eacf-list" data-toggle="list" href="#list-eacf" role="tab" aria-controls="eacf"> Extra Attendance </a>
          <a class="list-group-item list-group-item-action rt2" id="list-rt2-list" data-toggle="list" href="#list-rt2" role="tab" aria-controls="rt2"> Forego Credit </a>
        </div>
      </div>

      <div class="col-10">
        <?php //require("sync_data.php");
        ?>

        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane show active" id="list-sea" role="tabpanel" aria-labelledby="list-sea-list">
            <div class="row">
              <div class="col-4 mt-1 mb-1">
                <input type="date" class="form-control-sm" id="claim_date" value="<?php echo $submit_date; ?>">
                <p id="schedule"></p>
              </div>
              <div class="col-8 mt-1 mb-1">
                <p id="subjectEAClaimList"></p>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-eacf" role="tabpanel" aria-labelledby="list-eacf-list">
            <div class="row">
              <div class="col-8 mt-1 mb-1"><button class="btn btn-secondary btn-square-sm mt-1 addEacButton">New</button>
                <p id="eaClaimList"></p>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-rt2" role="tabpanel" aria-labelledby="list-rt2-list">
            <div class="row">
              <div class="col-8 mt-1 mb-1">--</button>
                <p id="rt2List"></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
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

    $(".topBarTitle").text("Student Dashboard");
    $(".selectPanel").show();
    $("#panelId").hide();
    eaClaimList();
    subjectEAClaimList();
    studentDailySchedule();
    selectSession();

    $(document).on("click", ".student_idEdit", function() {
      var id = $(this).attr("id")
      var claimDate = $(this).attr("data-eac_date")
      //$.alert("Extra Attendance Claim" + id + claimDate);
      $.post("requestSql.php", {
        student_id: id,
        eac_date: claimDate,
        action: "fetchEAC"
      }, () => {}, "json").done(function(data, status) {
        //$.alert("List " + data.eac_date);
        console.log(" Fetched Data  ", data);
        var eae_id = data.eae_id;
        //$.alert("EA " + eae_id);
        $("#sel_eae option[value='" + eae_id + "']").attr("selected", "selected");
        $('#ea_date').val(data.eac_date);
        $('#ea_claim').val(data.eac_claim);
        $('#ea_remarks').val(data.eac_remarks);
        $('#eac_dateM').val(claimDate);
        $('#student_idM').val(id);
        $("#firstModal").modal().show;
        $("#modal_title").html("Update Extra Attendance Claim Request");
        $("#action").val("updateEAC");
      })
    });
    $(document).on("click", ".sas_idD", function() {
      var id = $(this).attr("id")
      $.alert("Extra Attendance Claim" + id)
      $.post("requestSql.php", {
        sas_id: id,
        action: "removeSasEAC"
      }, () => {}, "html").done(function(data, status) {
        $.alert("Request Withdrawn"+data);
        subjectEAClaimList();
      })
    });
    $(document).on("change", "#claim_date", function() {
      studentDailySchedule();
    });
    $(document).on("change", "#sel_session", function() {
      setSession();
    });

    $(document).on("click", ".applyButton", function() {
      var claim_date = $("#claim_date").val()
      var sas_id = $(this).attr("id")
      $.alert("Extra Attendance Claim " + sas_id + "Claim Date" + claim_date);
      $("#firstModal").modal().show;
      $("#modal_title").html("Extra Attendance Claim");
      $("#action").val("addClaim");
      $("#ea_date").val(claim_date);
      $("#ea_claim").val(sas_id);
      $("#ea_date").attr("disabled", true);
      $("#ea_claim").attr("disabled", true);
      $("#eac_dateM").val(claim_date);
      $("#sas_idM").val(sas_id);
    });
    $(document).on("click", ".addEacButton", function() {
      //$.alert("Extra Attendance Claim");
      $("#firstModal").modal().show;
      $("#modal_title").html("Extra Attendance Claim");
      $("#action").val("addEAClaim");
      $("#ea_date").attr("disabled", false);
      $("#ea_claim").attr("disabled", false);
    });
    $(document).on("submit", "#modalForm", function(event) {
      event.preventDefault(this)
      var action = $("#action").val()
      var formData = $(this).serialize();
      $.alert("Action " + action);
      if ($("#ea_claim").val() === "" && action === "addEAClaim") $.alert("Attendance Claimed can not be Blank!!");
      else {
        $.alert("Extra Attendance Claim Form" + formData);
        $.post("requestSql.php", formData, () => {}, "text").done(function(data, status) {
          //$.alert("Done " + data);
          eaClaimList();
          subjectEAClaimList();
        })
      }
      $("#firstModal").modal("hide");
      $('#modalForm')[0].reset();

    });

    function setSession() {
      var sel_session = $("#sel_session").val()
      //$.alert("Extra Attendance Claim" + claim_date);
      $.post("setSessionSql.php", {
        sel_session: sel_session
      }, () => {}, "text").done(function(data, status) {
        selectSession();
        $.alert("Session Updated " + data);
      })
    }
    function selectSession() {
      $.post("selectSessionSql.php", {}, () => {}, "text").done(function(data, status) {
        $("#session").html(data)
      })
    }
    function studentDailySchedule() {
      var claim_date = $("#claim_date").val()
      var student_id=<?php echo $myStdId; ?>
      //$.alert("Extra Attendance Claim" + claim_date);
      $.post("requestSql.php", {
        claim_date: claim_date,
        student_id: student_id,
        action: "getSchedule"
      }, () => {}, "text").done(function(data, status) {
        //$.alert("List " + data);
        $("#schedule").html(data);
      })
    }
    function subjectEAClaimList() {
      //$.alert("In List Function");
      $.post("requestSql.php", {
        action: "sasClaimList"
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#subjectEAClaimList").html(data);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }
    function eaClaimList() {
      //$.alert("In List Function");
      $.post("requestSql.php", {
        action: "eaClaimList"
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#eaClaimList").html(data);
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
          <div class="eacForm">
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Claim Date
                  <input type="date" class="form-control form-control-sm" id="ea_date" name="ea_date" value="<?php echo $submit_date; ?>">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  Event
                  <?php
                  $sql = "select * from ea_event eae where eae.eae_status='A' order by eae_id";
                  selectList($conn, "", array("0", "eae_id", "eae_name", "eae_id", "sel_eae"), $sql);
                  ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <div class="form-group">
                  Attendance
                  <input type="number" class="form-control form-control-sm" id="ea_claim" name="ea_claim" placeholder="Attendance Claimed">
                </div>
              </div>

              <div class="col-8">
                <div class="form-group">
                  Remarks
                  <input type="text" class="form-control form-control-sm" id="ea_remarks" name="ea_remarks" placeholder="Remarks">
                </div>
              </div>
            </div>
            <hr>
            Please fill the Total Number of Attendance you are claiming for the Day.
          </div>
        </div> <!-- Modal Body Closed-->
        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="action" name="action">
          <input type="hidden" id="student_idM" name="student_id">
          <input type="hidden" id="eac_dateM" name="eac_dateM">
          <input type="hidden" id="sas_idM" name="sas_idM">
          <button type="submit" class="btn btn-success btn-sm" id="submit_eacf">Submit</button>
          <button class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>

  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->


</html>