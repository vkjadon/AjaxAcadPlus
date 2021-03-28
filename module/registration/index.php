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
        <div class="selectPanel">
          <p class="selectClass">
            <span class="m-1 p-0" id="selectPanelTitle"></span>
            <?php
            $sql = "select * from class where session_id='$mySes'";
            selectList($conn, "Select Class", array(0, "class_id", "class_name", "", "sel_class"), $sql)
            ?>
          </p>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active cr" id="list-cr-list" data-toggle="list" href="#list-cr" role="tab" aria-controls="cr"> Class Registration </a>
          <a class="list-group-item list-group-item-action sr" id="list-sr-list" data-toggle="list" href="#list-sr" role="tab" aria-controls="sr"> Subject Registration </a>
        </div>
      </div>
      <div class="col-10">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane show active" id="list-cc" role="tabpanel" aria-labelledby="list-cc-list">
            <div class="row">
              <div class="col-6">
                <p id="sbpList"></p>
              </div>
              <div class="col-6">
                <p class="mb-0">
                  <h5>&nbsp;</h5>
                </p>
                <p id="classSubjectList"></p>
                <p id="studentSubjectList"></p>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="list-tl" role="tabpanel" aria-labelledby="list-tl-list">
            <div class="col-6 mt-1 mb-1" id="crsList"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<?php require("../js.php");?>

<script>
  $(document).ready(function() {

    $(".topBarTitle").text("Registration");
    $("#selectPanelTitle").text("Student Registration");

    $(document).on('change', '#sel_class', function() {
      var classId = $("#sel_class").val();
      if (classId > 0) sbpList(classId, "25", "0");
      else $.alert(" Select a Class ");
    });

    $(document).on('click', '.register', function() {
      var classId = $("#sel_class").val();
      var rpp = $("#rpp").val();
      var startRecord = $("#currentRecord").text();
      var checkboxes_value = [];
      $('.sbp').each(function() {
        if (this.checked) {
          checkboxes_value.push($(this).val());
        }
      });
      //$.alert("Register Pressed " + checkboxes_value + "Start " + startRecord);
      $.post("registrationSql.php", {
        action: "register",
        checkboxes_value: checkboxes_value,
        classId: classId
      }, function(data, status) {
        //$.alert(data);
        sbpList(classId, rpp, startRecord);
      }, "text").fail(function() {
        $.alert("Fail");
      })
    });

    $(document).on('change', '.rpp', function() {
      var classId = $("#sel_class").val();
      var startRecord = $(this).attr('data-start');
      var rpp = $("#rpp").val();
      //$.alert("rpp " + rpp + " Class " + classId);
      if (classId > 0) sbpList(classId, rpp, startRecord);
      else $.alert("Select a Class ");
    });

    $(document).on('click', '.pageLink', function() {
      var x = $("#sel_class").val();
      var rpp = $("#rpp").val();
      var id = $(this).attr('id');
      var startRecord = $(this).attr('data-start');
      //$.alert(" Id " + id + " Start Record " + startRecord);
      $.post('registrationSql.php', {
        action: "sbpList",
        classId: x,
        startRecord: startRecord,
        rpp: rpp
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#sbpList").html(data);
        $("#currentRecord").hide();
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });

    $(document).on('click', '.checkAll', function() {
      $('.sbp').prop('checked', true); // Checks it
    });
    $(document).on('click', '.uncheckAll', function() {
      $('.sbp').prop('checked', false); // Unchecks it
    });

    $(document).on('click', '.classSubject', function() {
      var id = $('#sel_class').val();
      //$.alert("Class  Id " + id);
      classSubject(id);
    });

    $(document).on('click', '.updateClassButton', function() {
      var rsId = $(this).val();
      var subjectName = $(this).attr('data-subject');
      var className = $(this).attr('data-class');
      var classGroup = $(this).attr('data-group');
      $.alert("Registration Subject Id" + rsId);
      $('#modal_title').text("Update Class and Group");
      $('#action').val("updateClass");
      $('#subjectName').html(subjectName);
      $('#className').html(className);
      $('#classGroup').html(classGroup);
      $('#firstModal').modal('show');
    });

    $(document).on('click', '.studentSubjectButton', function() {
      var id = $('#sel_class').val();
      var stdId = $(this).attr("id");
      //$.alert("StdId" + stdId);
      studentSubject(id, stdId);
    });

    $(document).on('click', '.stdsubCheckbox', function() {
      var stdId = $(this).attr('data-std');
      var subId = $(this).val();
      var status = $(this).is(":checked");
      //$.alert("Subject Check Box StdId " + stdId + " Sub " + subId + " Status" + status);
      $.post('registrationSql.php', {
        action: "updateSub",
        stdId: stdId,
        subId: subId,
        status: status
      }, function(data, status) {
        $.alert("Registration Updated !! ");
      }, "text")
    });

    function studentSubject(x, y) {
      // $.alert("In Student-Subject Function Student Id" + x);
      $.post("registrationSql.php", {
        action: "stdSub",
        classId: x,
        stdId: y
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#classSubjectList").html(data);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function sbpList(x, y, z) {
      //$.alert("In Class-Subject Function Class Id" + x);
      $.post("registrationSql.php", {
        action: "sbpList",
        classId: x,
        rpp: y,
        startRecord: z
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#sbpList").html(data);
        $("#currentRecord").hide();
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function classSubject(x) {
      //$.alert("In Class-Subject Function Class Id" + x);
      $.post("registrationSql.php", {
        action: "clSub",
        classId: x
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#classSubjectList").html(data);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
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
          <div class="updateClassModalForm">
            <div class="row">
              <label class="col-md-3 text-right"><b>Subject</b></label>
              <div class="col-md-8" id="subjectName"></div>
            </div>
            <div class="row">
              <label class="col-md-3 text-right"><b>Class</b></label>
              <div class="col-md-3" id="className"></div>
              <label class="col-md-3 text-right"><b>Group</b></label>
              <div class="col-md-3" id="classGroup"></div>
            </div>
            <div class="row">
              <label class="col-md-3 text-right"><b>Class</b></label>
              <div class="col-md-3">
                <?php
                $sql = "select cl.* from class cl where cl.session_id='$mySes' and cl.class_status='0' order by class_name";
                selectList($conn, "Select Department", array("0", "class_id", "class_name", "class_section", "sel_classM"), $sql);
                ?></div>
              <label class="col-md-3 text-right"><b>Group</b></label>
              <div class="col-md-3">
                <input type="text" class="form-control form-control-sm" id="tl_groupM" name="tl_groupM">
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="modalId" name="modalId">
          <input type="hidden" id="action" name="action">
          <button type="submit" class="btn btn-success btn-sm" id="submitModalForm">Submit</button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->

    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

</html>