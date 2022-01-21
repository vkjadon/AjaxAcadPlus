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
  <?php require("../css.php"); ?>

</head>

<body>
  <?php require("../topBar.php"); ?>
  <div class="container-fluid">
    <div class="row">
    <div class="col-2 p-0 m-0 pl-2 full-height">
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action cs" id="list-cs-list" data-toggle="list" href="#list-cs" role="tab" aria-controls="cs"> Show Classes </a>
        </div>
      </div>
      <div class="col-10 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade" id="list-stt" role="tabpanel" aria-labelledby="list-stt-list">
            <div id="sessionClassListSTT">Show TimeTable</div>
            <p id="showTimeTable"></p>
          </div>
          <div class="tab-pane fade" id="list-cs" role="tabpanel" aria-labelledby="list-cs-list">
            <div class="row">
              <div class="col-9 mt-1 mb-1">
                <p id="showSchedule"></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <?php require("../bottom_bar.php"); ?>
  </div>
</body>
<script>
  $(document).ready(function() {

    $(document).on('click', '.cs', function() {
      //$.alert("TL");

      $.post("commSql.php", {
        action: "showSchedule"
      }, function(data, status) {
        $('#showSchedule').html(data);
      }, "text").fail(function() {
        $.alert("Fail");
      })
    });

    $(document).on('click', '.sendLink', function() {
      $.alert(" SSID  ");
      $.post("commSql.php", {
        action: "sendLink"
      }, function() {}, "text").done(function(data, status) {
        $.alert("Success " + data)
      })
    });

    $(document).on('submit', '#modalForm', function(event) {
      event.preventDefault(this);
      var action = $("#action").val();
      //$.alert("Form Submitted " + action);
      var formData = $(this).serialize();
      $.alert(formData);
    });

    function sessionClass() {
      //$.alert("In List Function " + actionText + "Panel " + panelId);
      $.post("commSql.php", {
        action: "sessionClassList"
      }, function(data, status) {
        $.alert("Success " + data);
        $("#sessionClassList").html(data);
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