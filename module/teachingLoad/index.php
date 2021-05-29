<?php
session_start();
require("../../config_database.php");
require('../../config_variable.php');
require('../../php_function.php');
require('../../phpFunction/teachingLoadFunction.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Outcome Based Education : ClassConnect</title>
  <?php require("../css.php"); ?>
  <link rel="stylesheet" href="teachingLoad.css">

</head>

<body>
  <?php require("../topBar.php"); ?>
  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-2">
        <span id="panelId"></span>
        <?php
        $sql = "select * from class where session_id='$mySes' and dept_id='$myDept'";
        selectList($conn, "", array(0, "class_id", "class_name", "class_section", "sel_class"), $sql)
        ?>

        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active cc" id="list-cc-list" data-toggle="list" href="#list-cc" role="tab" aria-controls="cc"> Class Groups </a>
          <a class="list-group-item list-group-item-action semLoad" id="list-semLoad-list" data-toggle="list" href="#list-semLoad" role="tab" aria-controls="semLoad"> Semester Load </a>
          <a class="list-group-item list-group-item-action subChoice" id="list-subChoice-list" data-toggle="list" href="#list-subChoice" role="tab" aria-controls="subChoice"> Subject Choice Filling </a>
          <a class="list-group-item list-group-item-action tl" id="list-tl-list" data-toggle="list" href="#list-tl" role="tab" aria-controls="tl"> Assign Load </a>
        </div>
      </div>
      <div class="col-10">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane show active" id="list-cc" role="tabpanel">
            <div class="row">
              <div class="col-6 mt-1 mb-1"><button class="btn btn-secondary btn-square-sm mt-1 addClass">New</button>
                <p id="clList"></p>
              </div>
              <div class="col-6 mt-1 mb-1" id="classSubject"></div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-semLoad" role="tabpanel">
            <div class="col-8 mt-1 mb-1">
              <div class="container card shadow d-flex justify-content-center mt-2" id="card_tl">
                <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab">
                  <?php
                  $sql = "select * from class where session_id='$mySes' and program_id='$myProg' and class_status='0' order by class_semester";
                  $result = $conn->query($sql);
                  $count = 0;
                  while ($rowsClass = $result->fetch_assoc()) {
                    $class_id[$count] = $rowsClass["class_id"];
                    $class_name[$count] = $rowsClass["class_name"];
                    if ($count == '0') $active = 'active';
                    else $active = '';
                    echo '<li class="nav-item">
                    <a class="nav-link ' . $active . '" data-toggle="pill" href="#p' . $class_name[$count] . '">' . $class_name[$count] . '</a></li>';
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
                    echo '<div class="tab-pane fade ' . $active . '" id="p' . $class_name[$i] . '">';
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
              <div class="col-8 mt-1 mb-1" id="subjectChoiceList"></div>
              <div class="col-4 mt-1 mb-1" id="myChoiceList"></div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-tl" role="tabpanel" aria-labelledby="list-tl-list">
            <div class="row">
              <div class="col-9 mt-1 mb-1" id="tlList"></div>
              <div class="col-3 mt-1 mb-1" id="subAllChoices"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <h1>&nbsp;</h1>
    <h1>&nbsp;</h1>
    <h1>&nbsp;</h1>
  </div>
</body>
<?php require("../js.php"); ?>


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

    $(".topBarTitle").text("Schedule");
    var x = $("#sel_program").val();
    classList(x);
    $(".selectClass").hide();
    //$(".selectPanel").hide();
    $("#panelId").hide();

    $(document).on('click', '.tl', function() {
      //$.alert("TL");
      $("#panelId").html("TL");
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

    $(document).on('change', '#sel_class', function() {
      var classId = $("#sel_class").val();
      var panelId = $("#panelId").text();
      //$.alert("Panel Id " + panelId);
      if (classId > 0 && panelId == "TL") tlList(classId);
      else if (classId > 0 && panelId == "TT") ttList(classId);
      else $.alert("Class " + classId);
    });

    $(document).on('click', '.increDecre', function() {
      var id = $(this).attr('id');
      var value = $(this).attr("data-value");
      $.alert("Id " + id + "Value" + value);
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
        //$.alert("Updated !! " + data);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });

    $(document).on('click', '.class_idP', function() {
      var id = $(this).attr('id');
      $.alert("Process Id " + id);
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
        console.log("Error ", data);
        $('#modal_title').text("Update Class [" + id + "]");
        $('#class_name').val(data.class_name);
        $('#class_section').val(data.class_section);
        $('#class_semester').val(data.class_semester);

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
      }, "text").fail(function() {
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
      var tl_id=$(this).attr("data-tl")
      $.alert("Class Modal" + tl_id);
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

      //$.alert("Form Submitted " + action);
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
        //$.alert(formData);
        $.post("teachingLoadSql.php", formData, () => {}, "text").done(function(data) {
          //$.alert(data);
          if (action == "addClass" || action == "updateClass") {
            var x = $("#sel_program").val();
            classList(x);
          } else if (action == "assignStaff" || action == "updateStaff") {
            var classId = $("#sel_class").val();
            if (classId > 0) tlList(classId);
            else $.alert(" Select Class ");
          } else {
            //$.alert("Updated");
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
      $.alert(" Subject All Choices " + x);
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
              <div class="col-6">
                <div class="form-group">
                  Class Name
                  <input type="text" class="form-control form-control-sm" id="class_name" name="class_name" placeholder="Class Name">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Semester
                  <input type="number" class="form-control form-control-sm" id="class_semester" name="class_semester" placeholder="semester">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Section
                  <input type="text" class="form-control form-control-sm" id="class_section" name="class_section" placeholder="Section">
                </div>
              </div>
            </div>
            <div class="row">

              <div class="col">
                <div class="form-check-inline"> Class Shift </div>
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
                selectList($conn, "Select New Department", array("0", "dept_id", "dept_abbri", "dept_id", "sel_dept"), $sql);
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