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
  <?php require("../css.php"); ?>

</head>

<body>
  <?php require("../topBar.php"); ?>
  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-2">
        <?php
        $sql = "select * from class where session_id='$mySes' and program_id='$myProg'";
        selectList($conn, "", array(0, "class_id", "class_name", "class_section", "sel_class"), $sql)
        ?>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active cr" id="list-cr-list" data-toggle="list" href="#list-cr" role="tab"> Class Registration </a>
          <a class="list-group-item list-group-item-action subjectRegistration" id="list-subjectRegistration-list" data-toggle="list" href="#list-subjectRegistration" role="tab"> Subject Registration </a>
          <a class="list-group-item list-group-item-action stdReg" id="list-stdReg-list" data-toggle="list" href="#list-stdReg" role="tab"> Student Registration </a>

        </div>
      </div>
      <div class="col-10">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane show active" id="list-cr" role="tabpanel">
            <div class="row">
              <div class="col-8">
                <p id="sbpList"></p>
                <span style="font-size: 12px;">
                  <ul>
                    <li>The Students will be registered in the Class and Group.</li>
                    <li>These are the default classes and groups for all academic purposes.</li>
                    <li>The Class and Group can be changed for different Subjects.</li>
                    <li>The <i>Daily Class Attendance</i> and <i>Subject Marks Entry</i> will be entered for the Class they are registered for that Subject.</li>
                    <li>So, Class wise students list will consider Class Registration and the Subject wise data entry will consider Subject Registration.</li>
                  </ul>
                </span>
              </div>
              <div class="col-4">
                <h5>Update Class Registration</h5>
                <div class="card mt-4">
                  <div class="col-sm-3 p-0">
                    <input type="number" class="form-control form-control-sm" id="new_group" name="new_group" min='1' value="1">
                  </div>
                  <div class="col-sm-9 p-0">
                    <button class="btn btn-default btn-block m-0 updateRegistration" data-tag="rc_group">Update Group</button>
                  </div>
                </div>
                <div class="card mt-4 border">
                  <div class="col-sm-6 p-0">
                    <input type="date" class="form-control form-control-sm" id="new_dor" name="new_dor" value="<?php echo $submit_date; ?>">
                  </div>
                  <div class="col-sm-9 p-0">
                    <button class="btn btn-default btn-block m-0 updateRegistration" data-tag="rc_date">Update Reg. Date</button>
                  </div>
                </div>
                <div class="card mt-4">
                  <div class="col-sm-6 p-0">
                    <?php
                    $sql = "select * from class where session_id='$mySes' and program_id='$myProg'";
                    selectList($conn, "", array(0, "class_id", "class_name", "class_section", "new_class"), $sql)
                    ?>
                  </div>
                  <div class="col-sm-9 p-0">
                    <button class="btn btn-default btn-block m-0 updateRegistration" data-tag="class_id">Update Class</button>
                  </div>
                </div>
                <div class="card mt-4">
                  <div class="col-sm-6 p-0">
                    <input type="text" class="form-control form-control-sm" id="ur_remarks" name="ur_remarks" placeholder="Remarks">
                  </div>
                  <div class="col-sm-9 p-0">
                    <button class="btn btn-default btn-block m-0 updateRegistration" data-tag="rc_status">Unregister</button>
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col">
                    <b><i>Only Selected Registered Students will be affected by Update</b></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-subjectRegistration">
            <div class="row">
              <div class="col-6 mt-1 mb-1">
                <p id="classList"></p>
              </div>
              <div class="col-6 mt-1 mb-1">
                <p id="classSubjectList"></p>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-sr" role="tabpanel" aria-labelledby="list-sr-list">
            <div class="col-6 mt-1 mb-1" id="crsList"> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<?php require("../js.php"); ?>

<script>
  $(document).ready(function() {

    $(".topBarTitle").text("Registration");
    sbpList("25", "0");
    classSubject();

    $(document).on('change', '#sel_class', function() {
      sbpList("25", "0");
      classSubject();
      classList("25", "0");
    });

    $(document).on('click', '.subjectRegistration', function() {
      //$.alert("Registration");
      classList("25", "0");
      classSubject();
    });

    $(document).on('click', '.cr', function() {
      //$.alert("Registration");
      sbpList("25", "0");
      classSubject();
    });

    $(document).on('click', '.register', function() {
      var classId = $("#sel_class").val();
      var class_group = $("#sel_cg").val();
      var rpp = $("#sbp_rpp").val();
      var startRecord = $("#currentRecord").text();
      var checkboxes_value = [];
      $('.sbp').each(function() {
        if (this.checked) {
          checkboxes_value.push($(this).val());
        }
      });
      //$.alert("Register Pressed " + checkboxes_value + "Start " + startRecord + "CG " + class_group);
      $.post("registrationSql.php", {
        checkboxes_value: checkboxes_value,
        classId: classId,
        class_group: class_group,
        action: "register"

      }, function(data, status) {
        //$.alert(data);
        sbpList(rpp, startRecord);
      }, "text").fail(function() {
        $.alert("Fail");
      })
    });

    $(document).on('click', '.updateRegistration', function() {
      var tag = $(this).attr("data-tag");
      if (tag == "rc_group") var value = $("#new_group").val();
      else if (tag == "class_id") var value = $("#new_class").val();
      else if (tag == "rc_date") var value = $("#new_dor").val();
      else var value = '9';
      var rpp = $("#rpp").val();
      var startRecord = $("#currentRecord").text();
      var checkboxes_value = [];
      $('.sbp').each(function() {
        if (this.checked) {
          checkboxes_value.push($(this).val());
        }
      });
      //$.alert("Register Pressed " + checkboxes_value + "Start " + startRecord + "Value " + value + " tag " + tag);
      $.post("registrationSql.php", {
        checkboxes_value: checkboxes_value,
        value: value,
        tag: tag,
        action: "updateRegistration"

      }, function(data, status) {
        $.alert(data);
        sbpList(rpp, startRecord);
      }, "text").fail(function() {
        $.alert("Fail");
      })
    });

    $(document).on('change', '.sbp_rpp, .cl_rpp', function() {
      var classId = $("#sel_class").val();
      var startRecord = $(this).attr('data-start');
      var tag = $(this).attr('data-tag');
      var rpp = $("#" + tag + "_rpp").val();
      //$.alert("rpp " + rpp + " Class " + classId + " Tag " + tag);
      if (tag == "sbp") sbpList(rpp, startRecord);
      else if (tag == "cl") classList(rpp, startRecord);
      else $.alert("Select a Class ");
    });

    $(document).on('click', '.pageLink', function() {
      var classId = $("#sel_class").val();
      var startRecord = $(this).attr('data-start');
      var tag = $(this).attr('data-tag');
      var rpp = $("#" + tag + "_rpp").val();
      if (tag == "sbp") var action = "sbpList";
      else var action = "classList";
      $.alert("rpp " + rpp + "Start " + startRecord + " Class " + classId + " Tag " + tag + " action " + action);
      $.post('registrationSql.php', {
        classId: classId,
        startRecord: startRecord,
        rpp: rpp,
        action: action
      }, function(data, status) {
        //$.alert("Success " + data);
        if (tag == "sbp") $("#sbpList").html(data);
        else $("#classList").html(data);
        $("#currentRecord").hide();
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });

    $(document).on('click', '.checkUnCheck', function() {
      var status = $(this).is(":checked");
      if (status == false) $('.sbp').prop('checked', false); // Unchecks it
      else $('.sbp').prop('checked', true); // Unchecks it
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
      $.alert("Subject Check Box StdId " + stdId + " Sub " + subId + " Status" + status);
      $.post('registrationSql.php', {
        action: "updateSub",
        stdId: stdId,
        subId: subId,
        status: status
      }, function(data, status) {
        $.alert("Registration Updated !! " + data);
      }, "text")
    });

    function classList(y, z) {
      var x = $("#sel_class").val();
      //$.alert("In Class-Subject Function Class Id" + x);
      $.post("registrationSql.php", {
        classId: x,
        rpp: y,
        startRecord: z,
        action: "classList"
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#classList").html(data);
        $("#currentRecord").hide();
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

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

    function sbpList(y, z) {
      var x = $("#sel_class").val();
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

    function classSubject() {
      var x = $("#sel_class").val();
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