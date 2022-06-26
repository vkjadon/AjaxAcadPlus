<?php
require('../requireSubModule.php');
require('../../phpFunction/teachingLoadFunction.php');
addActivity($conn, $myId, "Teaching Load", $submit_ts);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Outcome Based Education : ClassConnect</title>
  <?php require("../css.php"); ?>
</head>

<body>
  <?php require("../topBar.php");
  if($myId>3){
    if (!isset($_GET['tag'])) die("Illegal Attempt !! The token is Missing");
    elseif (!in_array($_GET['tag'], $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
    elseif (!in_array("37", $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
  }
   ?>
  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-1 p-0 m-0 full-height">
        <h5 class="pt-3 smallText">Teaching Load</h5>
        <span id="panelId"></span>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active cc" id="list-cc-list" data-toggle="list" href="#list-cc" role="tab" aria-controls="cc"> Class Groups </a>
          <a class="list-group-item list-group-item-action semLoad" id="list-semLoad-list" data-toggle="list" href="#list-semLoad" role="tab" aria-controls="semLoad"> Semester Load </a>
          <a class="list-group-item list-group-item-action subChoice" id="list-subChoice-list" data-toggle="list" href="#list-subChoice" role="tab" aria-controls="subChoice"> Subject Choice </a>
          <a class="list-group-item list-group-item-action" id="list-tl-list" data-toggle="list" href="#list-tl" role="tab" aria-controls="tl"> Assign Load </a>
        </div>
        <hr>
        <p class="text-center smallText under-process m-0"><?php echo $mySesName; ?></p>
        <hr>
        <p class="text-center xsText">Session Class</p>
        <?php
        $sql = "select * from class where session_id='$mySes' and dept_id='$myDept' order by program_id, class_semester";
        selectList($conn, "", array(0, "class_id", "class_name", "class_section", "sel_class"), $sql)
        ?>
      </div>
      <div class="col-11 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane show active" id="list-cc" role="tabpanel">
            <div class="row">
              <div class="col-6 mt-1 mb-1">
                <div class="mt-1 mb-1">
                  <h3>
                    <a class="fa fa-plus-circle p-0 addClass"></a> Classes
                  </h3>
                </div>
                <div class="card myCard p-2">
                  <div id="clList"></div>
                </div>
                The Semester and Batch cannot be edited once the Teaching Load Groups are created.
              </div>
              <div class="col-6 mt-1 mb-1">
                <h3>Create Groups of the Class</h3>
                <div class="card myCard">
                  <div class="p-2" id="classSubject"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-semLoad" role="tabpanel">
            <div class="col-8 mt-1 mb-1">
              <div class="container card myCard" id="card_tl">
                <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab">
                  <?php
                  $sql = "select * from class where session_id='$mySes' and dept_id='$myDept' and class_status='0' order by program_id, class_semester";
                  $result = $conn->query($sql);
                  $count = 0;
                  while ($rowsClass = $result->fetch_assoc()) {
                    $class_id[$count] = $rowsClass["class_id"];
                    $class_name[$count] = $rowsClass["class_name"];
                    if ($count == '0') $active = 'active';
                    else $active = '';
                    echo '<li class="nav-item">
                    <a class="nav-link ' . $active . '" data-toggle="pill" href="#p' . $class_id[$count] . '">' . $class_name[$count] . '</a></li>';
                    $count++;
                  }
                  ?>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#setSchedule">Set Schedule</a>
                  </li>
                </ul>
                <div class="tab-content" id="pills-tabContent p-3">
                  <?php
                  for ($i = 0; $i < $count; $i++) {
                    if ($i == '0') $active = 'show active';
                    else $active = '';
                    echo '<div class="tab-pane fade ' . $active . '" id="p' . $class_id[$i] . '">';
                    // echo $class_id[$i];
                    sessionLoad($conn, $class_id[$i], $tn_tlg);
                    echo '</div>';
                  }
                  ?>
                  <div class="tab-pane fade" id="setSchedule">
                    <form class="form-horizontal" id="setScheduleForm">
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            <label>Chioce Filling Start</label>
                            <input type="date" class="form-control form-control-sm" id="choiceFrom" name="choiceFrom">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label>Choice Filling End</label>
                            <input type="date" class="form-control form-control-sm" id="choiceTo" name="choiceTo">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-6">
                          <b><i>Schedule will be Set for the Default Programme</i></b>
                        </div>
                        <input type="hidden" id="actionSetSchedule" name="actionSetSchedule">
                        <div class="col-6">
                          <button type="submit" class="btn btn-sm">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-subChoice" role="tabpanel" aria-labelledby="list-subChoice-list">
            <div class="row">
              <div class="col-8 mt-1 mb-1">
                <div class="container card myCard p-2" id="card_tl">
                  <h3>Choice Filling Form</h3>
                  <div id="subjectChoiceList"></div>
                </div>
              </div>
              <div class="col-4 mt-1 mb-1">
                <div id="myChoiceList"></div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-tl" role="tabpanel" aria-labelledby="list-tl-list">
            <div class="row">
              <div class="col-9 mt-1 mb-1">
                <div class="row">
                  <div class="col-md-9">
                    <h3>
                      <span class="xlText">Assign Teaching Load</span>
                    </h3>
                  </div>
                  <div class="col-md-3 text-right">
                    <h3>
                      <a class="fa fa-refresh tl" style="color:yellowgreen"></a>
                    </h3>
                  </div>
                </div>
                <div class="container card myCard p-2" id="card_tl">
                  <div id="tlList"></div>
                </div>
              </div>
              <div class="col-3 mt-1 mb-1" id="subAllChoices"></div>
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

    var x = $("#sel_program").val();
    classList(x);
    tlList()

    $(document).on('click', '.tl', function() {
      tlList();
    });

    $(document).on('click', '.subChoice', function() {
      subjectChoiceList();
      myChoiceList();
    });

    $(document).on('click', '.subAllChoices', function() {
      var tlg_id = $(this).attr("data-tlg")
      //$.alert(tlg_id)
      subAllChoices(tlg_id);
    });

    $(document).on('click', '.clList, .cc', function() {
      //$.alert("Class Modal");
      $(".selectClass").hide();
      $(".addClass").show();
      $("#clList").show();
    });

    $(document).on('click', '.increDecre', function() {
      var id = $(this).attr('id');
      var value = $(this).attr("data-value");
      // $.alert("Id " + id + "Value" + value);
      $.post('teachingLoadSql.php', {
        id: id,
        value: value,
        action: "increDecre"

      }, function(data, status) {
        classList();
        //$.alert("Updated !! " + data);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });

    $(document).on('click', '.decrement', function() {
      var id = $(this).attr('id');
      var value = $("." + id).text();
      //$.alert("Decrement " + id + "Value" + value);
      $.post('teachingLoadSql.php', {
        action: "decrement",
        tlg_id: id,
        value: value
      }, function(data, status) {
        var newValue = Number(value) - 1;
        if (newValue > 0) $("." + id).html(newValue);
        else $("." + id).html(value);
        //$.alert("Updated !! " + data);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });

    $(document).on('click', '.increment', function() {
      var id = $(this).attr('id');
      var value = $("." + id).text();
      //$.alert("Increment " + id + "Value" + value);
      $.post('teachingLoadSql.php', {
        action: "increment",
        tlg_id: id,
        value: value
      }, function(data, status) {
        var newValue = Number(value) + 1;
        $("." + id).html(newValue);
        //$.alert("Updated !! " + newValue);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });

    $(document).on('click', '.class_idP', function() {
      var id = $(this).attr('id');
      // $.alert("Process Id " + id);
      classSubject(id);
    });

    $(document).on("click", ".openModalAssignStaff", function() {
      var tlg_id = $(this).attr('id');
      var group = $(this).attr('data-group');
      var subject = $(this).attr('data-subject');
      var type = $(this).attr('data-type');
      //$.alert("tlg " + tlg_id + " Group " + group + " Subject " + subject);
      $('#modal_titleClass').text("Assign Staff");
      $('#action').val("assignStaff");
      $('#submitModalForm').show();
      $('#submitModalForm').html("Submit");

      $('#subjectName').html(subject);
      $('#loadType').html(type);
      $('#tlg_idM').val(tlg_id);
      $('#tl_groupM').val(group);
      if (type == "L") $('#loadGroup').html("LG-" + group);
      else if (type == "T") $('#loadGroup').html("TG-" + group);
      else $('#loadGroup').html("PG-" + group);

      $(".classForm").hide()
      $(".updateDeptForm").hide()
      $(".clashForm").hide()

      $(".assignStaff").show()
      $('#firstModal').modal('show');

    });

    $(document).on('click', '.class_idE', function() {
      var id = $(this).attr('id');
      //$.alert("Id " + id);

      $.post("teachingLoadSql.php", {
        classId: id,
        action: "fetchClass"
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.class_name);
        // console.log("Error ", data);
        $('#modal_title').text("Update Class [" + id + "]");
        $('#class_name').val(data.class_name);
        $('#class_section').val(data.class_section);
        $('#class_semester').val(data.class_semester);
        $('#sel_newProg').val(data.program_id);
        $('#sel_newBatch').val(data.batch_id);

        var class_shift = data.class_shift;
        if (class_shift == 'Morning') {
          document.getElementById("morning").checked = true;
        } else if (class_shift == 'Evening') {
          document.getElementById("evening").checked = true;
        }

        var batchId = data.batch_id;
        $("#sel_batch option[value='" + batchId + "']").attr("selected", "selected");

        $('#action').val("updateClass");
        $('#modalId').val(id);
        $('#submitModalForm').show();
        $('#submitModalForm').html("Submit");

        $(".updateDeptForm").hide()
        $('.assignStaff').hide();
        $('.clashForm').hide();

        $('.classForm').show();

        $('#firstModal').modal('show');
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.addClass', function() {
      var programId = $("#sel_program").val()
      //$.alert("Class Modal");
      $('#modal_titleClass').html("Add New Class [<?php echo $myProgAbbri . '-' . $myBatchName; ?>]");
      $('#action').val("addClass");
      $('#submitModalForm').show();
      $('#submitModalForm').html("Submit");

      $(".assignStaff").hide()
      $(".updateDeptForm").hide()
      $(".clashForm").hide()

      $(".classForm").show()
      $('#firstModal').modal('show');
    });
    $(document).on('click', '.unassign', function() {
      var tl_id = $(this).attr("data-tl")
      // $.alert("Class Modal" + tl_id);
      $.post("teachingLoadSql.php", {
        tl_id: tl_id,
        action: "tlDelete"
      }, function(mydata, mystatus) {
        //$.alert("List " + mydata);
        tlList();
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('submit', '#modalForm', function(event) {
      event.preventDefault(this);
      var action = $("#action").val();
      var tlg_id = $("#tlg_idM").val();

      // $.alert("Form Submitted " + action + " TlgId " + tlg_id);
      var error = "NO";
      var error_msg = "";
      if (action == "addClass" || action == "updateClass") {
        if ($('#class_name').val() === "" || $('#sel_batch').val() === "") {
          error = "YES";
          error_msg = "Class/Batch cannot be blank";
        }
      } else if (action == "assignStaff" || action == "updateStaff") {
        if ($('#sel_staff').val() === "") {
          error = "YES";
          error_msg = "Select Staff to Assign Staff for the Selected Load";
        }
      }
      if (error == "NO") {
        var formData = $(this).serialize();
        // $.alert(formData);
        $.post("teachingLoadSql.php", formData, () => {}, "text").done(function(data) {
          // $.alert(data);
          if (action == "addClass" || action == "updateClass") {
            var x = $("#sel_program").val();
            classList(x);
          } else if (action == "assignStaff" || action == "updateStaff") {
            var classId = $("#sel_class").val();
            if (classId > 0) tlList(classId);
            else $.alert(" Select Class ");
          } else {
            // $.alert("Updated" + data);
            $("#dept" + tlg_id).html(data)
          }
          $('#firstModal').modal('hide');
          $('#modalForm')[0].reset();
        }).fail(function() {
          $.alert("fail in place of error");
        })
      } else {
        $.alert(error_msg);
      }
    });
    $(document).on('click', '.modalFormUpdateDept', function() {
      var tlgId = $(this).attr('data-tlg');

      //$.alert("Class Modal");
      $('#modal_titleClass').html("Update Department for Teaching Load");
      $('#action').val("updateTlgDept");
      $('#tlg_idM').val(tlgId);
      $('#submitModalForm').show();
      $('#submitModalForm').html("Submit");

      $(".assignStaff").hide()
      $(".classForm").hide()

      $(".updateDeptForm").show()
      $('#firstModal').modal('show');
    });
    $(document).on('click', '.setChoice', function() {
      var tlg_id = $(this).attr('data-tlg');
      var value = $(this).attr('data-choice');
      //$.alert("TlgId " + tlg_id + "Value" + value);
      $.post('teachingLoadSql.php', {
        action: "setChoice",
        tlg_id: tlg_id,
        value: value
      }, function(data, status) {
        //$("#c"+value+"tlg" + tlg_id).text(value);
        $.alert(data);
        subjectChoiceList()
        myChoiceList();
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });

    function tlList() {
      var classId = $("#sel_class").val();
      //$.alert("Class " + classId);
      $.post("teachingLoadSql.php", {
        classId: classId,
        action: "tl"
      }, function(mydata, mystatus) {
        $("#tlList").show();
        //$.alert("List " + mydata);
        $("#tlList").html(mydata);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    }

    function myChoiceList() {
      //$.alert(" Subject Choice ");
      $.post("teachingLoadSql.php", {
        action: "myChoiceList"
      }, function(mydata, mystatus) {
        $("#myChoiceList").show();
        //$.alert("List " + mydata);
        $("#myChoiceList").html(mydata);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    }

    function subAllChoices(x) {
      // $.alert(" Subject All Choices " + x);
      $.post("teachingLoadSql.php", {
        tlg_id: x,
        action: "subAllChoices"
      }, function(mydata, mystatus) {
        //$.alert("List " + mydata);
        $("#subAllChoices").html(mydata);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    }

    function subjectChoiceList() {
      //$.alert(" Subject Choice ");
      $.post("teachingLoadSql.php", {
        action: "subChoiceList"
      }, function(mydata, mystatus) {
        $("#subjectChoiceList").show();
        //$.alert("List " + mydata);
        $("#subjectChoiceList").html(mydata);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    }

    function classList(programId) {
      //$.alert("In List Function" + programId);
      $.post("teachingLoadSql.php", {
        action: "clList",
        programId: programId
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#clList").html(data);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function classSubject(x) {
      //$.alert("In Class-Subject Function Class Id" + x);
      $.post("teachingLoadSql.php", {
        action: "clSub",
        classId: x
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#classSubject").html(data);
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
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_titleClass"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->

        <!-- Modal body -->
        <div class="modal-body">
          <div class="classForm">
            <div class="row">
              <div class="col-6 pr-0">
                <div class="form-group">
                  Class Name
                  <input type="text" class="form-control form-control-sm" id="class_name" name="class_name" placeholder="Class Name">
                </div>
              </div>
              <div class="col-2 pl-1 pr-0">
                <div class="form-group">
                  Semester
                  <input type="number" class="form-control form-control-sm" id="class_semester" name="class_semester" placeholder="semester">
                </div>
              </div>
              <div class="col-2 pl-1 pr-0">
                <div class="form-group">
                  Section
                  <input type="text" class="form-control form-control-sm" id="class_section" name="class_section" placeholder="Section">
                </div>
              </div>
              <div class="col-2 pl-1">
                <div class="form-group">
                  Group
                  <input type="number" class="form-control form-control-sm" id="class_group" name="class_group" value="1" placeholder="Group">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-4 pr-0">
                <div class="form-group">
                  Program
                  <select class="form-control form-control-sm" name="sel_newProg" id="sel_newProg">
                    <?php
                    $sql = "select p.* from program p, dept_program dp where dp.dept_id='$myDept' and dp.program_id=p.program_id and p.program_status='0' order by p.sp_name";
                    $result = $conn->query($sql);
                    while ($progRows = $result->fetch_assoc()) {
                      echo '<option value="' . $progRows["program_id"] . '">' . $progRows["sp_abbri"] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-2 pl-1 pr-0">
                <div class="form-group">
                  Batch
                  <select class="form-control form-control-sm" name="sel_newBatch" id="sel_newBatch">
                    <?php
                    $sql = "select * from batch where batch_status='0' order by batch desc";
                    $result_batch = $conn->query($sql);
                    while ($batchRows = $result_batch->fetch_assoc()) {
                      echo '<option value="' . $batchRows["batch_id"] . '">' . $batchRows["batch"] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col">
                <p>Class Shift</p>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" checked id="morning" name="class_shift" value="Morning">Morning
                </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" id="evening" name="class_shift" value="Evening">Evening
                </div>
              </div>
            </div>
          </div>
          <div class="updateDeptForm">
            <div class="row">
              <div class="col">
                <?php
                $sql = "select * from department where dept_status='0' and dept_type='0' order by dept_abbri";
                selectList($conn, "Sel Department", array("0", "dept_id", "dept_abbri", "dept_id", "sel_dept"), $sql);
                ?>
              </div>
            </div>
          </div>
          <div class="assignStaff">
            <div class="row">
              <label class="col-md-3 text-right"><b>Subject</b></label>
              <div class="col-md-8" id="subjectName"></div>
            </div>
            <div class="row">
              <label class="col-md-3 text-right"><b>Type</b></label>
              <div class="col-md-3" id="loadType"></div>
              <label class="col-md-3 text-right"><b>Group</b></label>
              <div class="col-md-3" id="loadGroup"></div>
            </div>
            <div class="row">
              <label class="col-md-3 text-right"><b>Staff</b></label>
              <div class="col-md-9">
                <?php
                $sql = "select s.* from staff s where s.staff_status='0' order by staff_name";
                selectList($conn, "Select Staff", array("0", "staff_id", "staff_name", "staff_id", "sel_staff"), $sql);
                ?>
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="modalId" name="modalId">
          <input type="hidden" id="action" name="action">
          <input type="hidden" id="tlg_idM" name="tlg_idM">
          <input type="hidden" id="tl_groupM" name="tl_groupM">
          <input type="hidden" id="tlIdM" name="tlIdM">
          <input type="hidden" id="classIdM" name="classIdM">

          <button type="submit" class="btn btn-success btn-sm" id="submitModalForm"></button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->

    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

</html>