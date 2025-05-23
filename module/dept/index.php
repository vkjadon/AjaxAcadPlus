<?php
require('../requireSubModule.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Outcome Based Education : ClassConnect</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <link rel="stylesheet" href="../../table.css">
  <link rel="stylesheet" href="../../style.css">
</head>

<body>
  <?php require("../topBar.php"); ?>
  <div class="container-fluid">
    <h1>&nbsp;</h1>
    <h1>&nbsp;</h1>
    <div class="row">
      <div class="col-2">
        <div class="card text-center selectPanel">
          <span id="panelId"></span>
          <span class="m-1 p-0" id="selectPanelTitle"></span>
          <div class="col">
            <form>
              <p class="selectProgram">
                <?php
                $sql = "select * from program where program_status='0'";
                selectList($conn, 'Select Program', array("0", "program_id", "sp_name", "program_abbri", "sel_program"), $sql);
                ?>
              </p>
              <p class="selectBatch">
                <?php
                $sql = "select * from batch where batch_status='0' order by batch desc";
                selectList($conn, "Select Batch", array("0", "batch_id", "batch", "", "sel_batch"), $sql);
                ?>
              </p>
              <p class="selectSubject">
                <?php
                $sql = "select sb.* from subject sb where sb.staff_id='$myId' and sb.subject_status='0'";
                selectList($conn, "Select Subject", array("0", "subject_id", "subject_name", "subject_code", "sel_subject"), $sql);
                ?>
              </p>
          </div>
          </form>
        </div>

        <?php
        $url = $setUrl . '/acadplus/api/check_dept_head.php?u=' . $myUn . '&&p=' . $myPwd;
        $dept_head = check_dept_head($url);
        ?>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active bs" id="list-bs-list" data-toggle="list" href="#list-bs" role="tab" aria-controls="bs"> Batch/Session </a>
          <a class="list-group-item list-group-item-action po" id="list-po-list" data-toggle="list" href="#list-po" role="tab" aria-controls="po"> Programme Outcome </a>
          <a class="list-group-item list-group-item-action sub" id="list-sub-list" data-toggle="list" href="#list-sub" role="tab" aria-controls="sub"> Courses/Subjects </a>
          <a class="list-group-item list-group-item-action co" id="list-co-list" data-toggle="list" href="#list-co" role="tab" aria-controls="co"> Course Outcome </a>
        </div>
      </div>

      <div class="col-10">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="list-bs" role="tabpanel" aria-labelledby="list-bs-list">
            <div class="row">
              <div class="col-5 mt-1 mb-1"><button class="btn btn-secondary btn-square-sm mt-1 addBatch">Batch</button>
                <p style="text-align:center" id="batchShowList"></p>
              </div>
              <div class="col-7 mt-1 mb-1" id="batchSession">
              </div>
            </div>
          </div>

          <div class="tab-pane fade show" id="list-po" role="tabpanel" aria-labelledby="list-po-list">
            <div class="row">
              <div class="mt-1 mb-1"><button class="btn btn-secondary btn-square-sm mt-1 addPo">Add</button>
                <p style="text-align:left" id="poShowList"></p>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="list-sub" role="tabpanel" aria-labelledby="list-sub-list">
            <div class="row">
              <div class="mt-1 mb-1"><button class="btn btn-secondary btn-square-sm mt-1 addSubject">New Subject</button>
                <button class="btn btn-secondary btn-square-sm mt-1 copySubject">Copy Subject</button>

                <p id="subShowList"></p>
                <p id="subCoordinator"></p>
              </div>
            </div>
          </div>

          <div class="tab-pane fade show" id="list-co" role="tabpanel" aria-labelledby="list-co-list">
            <div class="row">
              <div class="mt-1 mb-1"><button class="btn btn-secondary btn-square-sm mt-1 addCo">Add</button>
                <p style="text-align:left" id="coShowList"></p>
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

<script>
  $(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip();
    $(".topBarTitle").text("Academics");
    $(".selectBatch").hide();
    $(".selectSubject").hide();
    batchList();
    poList();
    coList();

    // Select Panel
    $(document).on("change", "#sel_program", function() {
      var batch_id = $("#sel_batch").val();
      var program_id = $("#sel_program").val();
      // $.alert("Changed Program " + batch_id + program_id);
      subjectList(batch_id, program_id);
      $("#hiddenProgram").val(program_id);
      $("#hiddenBatchPO").val(batch_id);
      poList();
    });
    $(document).on("change", "#sel_batch", function() {
      var batch_id = $("#sel_batch").val();
      var program_id = $("#sel_program").val();
      // $.alert("Changed Program "+ batch_id + program_id);
      subjectList(batch_id, program_id);
      $("#hiddenProgram").val(program_id);
      $("#hiddenBatchPO").val(batch_id);
      poList();
    });

    // Left Panel Block
    $(document).on('click', '.bs', function() {
      $('#list-po').hide();
      $('#list-bs').show();
      $('#list-co').hide();
      $('#list-sub').hide();

      $(".selectBatch").hide();
      $(".selectSubject").hide();
      $(".selectProgram").show();

      batchList();
    });
    $(document).on('click', '.po', function() {
      $('#action').val("addPo");
      $('#list-bs').hide();
      $('#list-po').show();
      $('#list-co').hide();
      $('#list-sub').hide();
      $(".selectPanel").show();
      $(".selectBatch").show();
      $(".selectProgram").show();
      $(".selectSubject").hide();

    });
    $(document).on('click', '.co', function() {
      $(".selectPanel").hide();
      $('#action').val("addCo");
      $('#list-po').hide();
      $('#list-bs').hide();
      $('#list-co').show();
      $('#list-sub').hide();
      $(".selectPanel").show();
      $(".selectBatch").hide();
      $(".selectProgram").hide();
      $(".selectSubject").show();
    });
    $(document).on('click', '.sub', function() {
      $(".selectPanel").show();
      $('#list-po').hide();
      $('#list-bs').hide();
      $('#list-co').hide();
      $('#list-sub').show();
      $(".selectPanel").show();
      $(".selectBatch").show();
      $(".selectProgram").show();
      $(".selectSubject").hide();
    });

    $(document).on('submit', '#modalForm', function(event) {
      event.preventDefault(this);
      var sn = $("#subject_name").val();
      var staff = $("#sel_staff").val();
      var action = $("#action").val();
      var batch = $("#newBatch").val();
      var selProgram = $("#sel_program").val();
      var selBatch = $("#sel_batch").val();
      var selSubject = $("#sel_subject").val();
      var poc = $("#poCode").val();
      var poS = $("#poStatemnt").val();
      var coc = $("#coCode").val();
      var coS = $("#coStatemnt").val();

      var sessionName = $("#session_name").val();

      var error = "NO";
      var error_msg = "";
      if (action == "addSubject" || action == "updateSubject") {
        if ($('#subject_name').val() === "" || $('#sel_staff').val() === "") {
          error = "YES";
          error_msg = "Subject Name and Coordinator cannot be blank";
        }
      } else if (action == "addSession" || action == "updateSession") {
        if ($("#session_name").val() == "") {
          error = "YES";
          error_msg = "Session cannot be Blank!!";
        }
      } else if (action == "addBatch" || action == "updateBatch") {
        if ($("#newBatch").val() == "") {
          error = "YES";
          error_msg = "Batch is empty";
        }
      } else if (action == "addPo" || action == "uopdatePo") {
        if (selProgram === "" || selBatch === "") {
          error = "YES";
          error_msg = "Please Select Program and Batch to Proceed";
        } else if (poc === "" || poS === "") {
          error = "YES";
          error_msg = "Enter PO Code and PO to Proceed !!";
        }
      } else if (action == "addCo" || action == "updateCo") {
        if (selSubject === "") {
          error = "YES";
          error_msg = "Please Select Subject to Proceed";
        } else if (coc === "" || coS === "") {
          error = "YES";
          error_msg = "Enter CO Code and CO to Proceed !!";
        }
      }

      if (error == "NO") {
        var formData = $(this).serialize();
        $('#firstModal').modal('hide');
        $.alert(" Pressed" + formData);
        $.post("aaSql.php", formData, () => {}, "text").done(function(data) {
          $.alert("List " + data);
          if (action == "addSubject" || action == "updateSubject") {
            subjectList();
          } else if (action == "addBatch" || action == "updateBatch") {
            batchList();
          } else if (action == "addPo" || action == "updatePo") {
            poList();
          } else if (action == "addCo" || action == "updateCo") {
            coList();
          } else if (action == "addSession" || action == "updateSession") {
            x = $("#panelId").val();
            batchSession(x);
          }
          $("#modalForm")[0].reset();
        }, "text").fail(function() {
          $.alert("fail in place of error");
        })
      } else {
        $.alert(error_msg);
      }
    });

    // Manage Course Outcome
    $(document).on('click', '.addCo', function() {
      x = $('#sel_subject').val();
      // $.alert("x" + x);
      $('#subjectIdModal').val(x);
      $('#modal_title').text("Add Course Outcome");
      $('#action').val("addCo");
      $('#firstModal').modal('show');
      $('.subjectForm').hide();
      $('.batchForm').hide();
      $('.poForm').hide();
      $('.coForm').show();
      $("#modalForm")[0].reset();
      $('.selectPanel').show();
    });
    $(document).on('click', '.co_idD', function() {
      $.alert("Disabled");
    });
    $(document).on('click', '.co_idE', function() {
      var id = $(this).attr('id');
      // $.alert("Id " + id);
      $.post("aaSql.php", {
        action: "fetchCo",
        coId: id
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data);
        $('#modal_title').text("Update CO [" + id + "]");
        $("#coCode").val(data.co_code);
        $("#coStatement").val(data.co_name);
        $("#coSno").val(data.co_sno);
        $("#action").val("updateCo");
        $('#modalId').val(id);
        $('#firstModal').modal('show');
        $('.batchForm').hide();
        $('.subjectForm').hide();
        $('.poForm').hide();
        $('.coForm').show();

      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });
    $(document).on("change", "#sel_subject", function() {
      var subject_id = $("#sel_subject").val();
      // $.alert("Changed Subject " + subject_id);
      $("#hiddenSubjectCO").val(subject_id);
      coList();
    });

    // Manage Program Outcome
    $(document).on('click', '.addPo', function() {
      x = $('#sel_program').val();
      y = $('#sel_batch').val();
      // $.alert("x" + x);
      $('#programIdModal').val(x);
      $('#batchIdModal').val(y);
      $('#modal_title').text("Add Program Course");
      $('#action').val("addPo");
      $('#firstModal').modal('show');
      $('.subjectForm').hide();
      $('.batchForm').hide();
      $('.poForm').show();
      $('.coForm').hide();
      $('.sessionForm').hide();
      $('.selectPanel').show();
      $("#modalForm")[0].reset();
    });
    $(document).on('click', '.po_idD', function() {
      $.alert("Disabled");
    });
    $(document).on('click', '.po_idE', function() {
      var id = $(this).attr('id');
      //$.alert("Id " + id);
      $.post("aaSql.php", {
        action: "fetchPo",
        poId: id
      }, () => {}, "json").done(function(data) {
        //$.alert("List ");
        $('#modal_title').text("Update PO [" + id + "]");
        $("#poCode").val(data.po_code);
        $("#poStatement").val(data.po_name);
        $("#poSno").val(data.po_sno);
        $("#action").val("updatePo");
        $('#modalId').val(id);
        $('#firstModal').modal('show');
        $('.batchForm').hide();
        $('.subjectForm').hide();
        $('.poForm').show();
        $('.coForm').hide();
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    // Manage Session
    $(document).on('click', '.session_idD', function() {
      $.alert("Disabled");
    });
    $(document).on('click', '.addSessionButton', function(event) {
      var programId = $("#sel_program").val();
      var batchId = $("#panelId").val();
      if (programId === "") $.alert("Please Select the Program. ALL for creating General Session.")
      else {
        $.alert("Program " + programId + batchId);
        $('#modal_title').text("Add Session");
        $('#batchIdModal').val(batchId);
        $('#programIdModal').val(programId);
        $('#action').val("addSession");
        $("#firstModal").modal('show');
        $(".batchForm").hide();
        $(".poForm").hide();
        $(".coForm").hide();
        $(".subjectForm").hide();
        $(".sessionForm").show();
      }
    });
    $(document).on('click', '.batch_idP', function() {
      var id = $(this).attr('id');
      $("#panelId").val(id);
      //$.alert("Process Id " + id);
      batchSession(id);
    });
    $(document).on('click', '.session_idE', function() {
      var id = $(this).attr('id');
      $.alert("Id " + id);
      $.post("aaSql.php", {
        action: "fetchSession",
        sessionId: id
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.batch);
        $("#session_name").val(data.session_name);
        $("#session_remarks").val(data.session_remarks);
        $("#session_start").val(data.session_start);
        $("#session_end").val(data.session_end);
        $('#modal_title').text("Update Session [" + id + "]");
        $('#action').val("updateSession");
        $('#modalId').val(id);

        $(".batchForm").hide();
        $(".poForm").hide();
        $(".coForm").hide();
        $(".subjectForm").hide();
        $(".sessionForm").show();

        $('#submitModalForm').html("Submit");
        $('#firstModal').modal().show;


      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    // Manage Batch
    $(document).on('click', '.addBatch', function() {
      $('#modal_title').text("Add Batch");
      $('#action').val("addBatch");
      $('#firstModal').modal('show');
      $('.subjectForm').hide();
      $('.batchForm').show();
      $('.poForm').hide();
      $('.coForm').hide();
      $('.sessionForm').hide();
    });
    $(document).on('click', '.batch_idD', function() {
      $.alert("Disabled");
    });
    $(document).on('click', '.batch_idE', function() {
      var id = $(this).attr('id');
      //$.alert("Id " + id);
      $.post("aaSql.php", {
        action: "fetchBatch",
        batchId: id
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.batch);
        $("#newBatch").val(data.batch);
        $('#modal_title').text("Update Batch [" + id + "]");
        $('#action').val("updateBatch");
        $('#modalId').val(id);
        $(".batchForm").show();
        $(".poForm").hide();
        $(".coForm").hide();
        $(".subjectForm").hide();
        $(".sessionForm").hide();
        $('#submitModalForm').html("Submit");
        $('#firstModal').modal().show;


      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    // Manage Subject
    $(document).on('click', '.subject_idD', function() {
      $.alert("Disabled");
    });
    $(document).on('click', '.subject_idE', function() {
      var x = $("#sel_batch").val();
      var y = $("#sel_program").val();
      var id = $(this).attr('id');
      //$.alert("Id " + id);

      if (x === "" || y == "") $.alert("Please select Program and Batch");
      else {

        $.post("aaSql.php", {
          action: "fetchSubject",
          subjectId: id
        }, () => {}, "json").done(function(data) {
          //$.alert("List " + data.inst_name);

          $('#modal_title').text("Update Subject [" + id + "]");

          $('#action').val("updateSubject");
          $('#modalId').val(id);
          $('#subject_name').val(data.subject_name);
          $('#subject_code').val(data.subject_code);
          $('#subject_semester').val(data.subject_semester);
          $('#subject_credit').val(data.subject_credit);
          $('#subject_lecture').val(data.subject_lecture);
          $('#subject_tutorial').val(data.subject_tutorial);
          $('#subject_practical').val(data.subject_practical);
          $('#subject_internal').val(data.subject_internal);
          $('#subject_external').val(data.subject_external);
          var staff = data.staff_id;
          //$.alert("Staff " + staff);
          $("#sel_staff option[value='" + staff + "']").attr("selected", "selected");
          var subType = data.subject_type;
          if (subType == 'DE') {
            document.getElementById("stDE").checked = true;
          } else if (subType == 'OE') {
            document.getElementById("stOE").checked = true;
          } else if (subType == 'DC') {
            document.getElementById("stDC").checked = true;
          } else if (subType == 'OC') {
            document.getElementById("stOC").checked = true;
          }

          var subMode = data.subject_mode;
          if (subMode == 'Online') {
            document.getElementById("smOn").checked = true;
          } else if (subMode == 'Offline') {
            document.getElementById("smOff").checked = true;
          }

          var subCat = data.subject_category;
          if (subCat == 'Theory') {
            document.getElementById("scTh").checked = true;
          } else if (subCat == 'Practical') {
            document.getElementById("scPr").checked = true;
          } else if (subCat == 'Project') {
            document.getElementById("scPrj").checked = true;
          } else if (subCat == 'Field Work') {
            document.getElementById("scFW").checked = true;
          }

          $('#firstModal').modal('show');
          $('.batchForm').hide();
          $('.subjectForm').show();
          $('.poForm').hide();
          $('.coForm').hide();
          $('.sessionForm').hide();

          //$("#ccform").html(mydata);
        }, "text").fail(function() {
          $.alert("fail in place of error");
        })
      }
    });
    $(document).on('click', '.addSubject', function() {
      var x = $("#sel_batch").val();
      var y = $("#sel_program").val();
      $.alert("Add Subject" + x + "-" + y);
      if (x === "" || y == "") $.alert("Please select Program and Batch");
      else {

        $('#modal_title').text("Add Subject");
        $('#programIdModal').val(y);
        $('#batchIdModal').val(x);
        $('#action').val("addSubject");
        $('#firstModal').modal('show');
        $('.batchForm').hide();
        $('.poForm').hide();
        $('.coForm').hide();
        $('.sessionForm').hide();
        $('.subjectForm').show();
      }
    });
    $(document).on('submit', '#modalSecondForm', function(event) {
      event.preventDefault(this);
      var formData = $(this).serialize();
      $('#secondModal').modal("hide");
      $.alert(" Pressed" + formData);
      $.post("aaSql.php", formData, () => {}, "text").done(function(data) {
        $.alert("List " + data);
        $("#modalSecondForm")[0].reset();
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });
    $(document).on('click', '.copySubject', function() {
      var x = $("#sel_batch").val();
      var y = $("#sel_program").val();
      $.alert("Add Subject" + x + "-" + y);
      if (x === "" || y == "") $.alert("Please select Program and Batch");
      else {

        $('#modal_titleSecond').text("Copy Subject");
        $('#originalProgram').val(y);
        $('#originalBatch').val(x);
        $('#actionSecond').val("copySubject");
        $('#secondModal').modal('show');
      }
    });

    // Functions
    function batchSession(x) {
      $.post("aaSql.php", {
        action: "batchSession",
        batchId: x
      }, function(data, status) {
        //$.alert("Data" + data)
        $("#batchSession").html(data);
      }, "text").fail(function() {
        $.alert("Error in BatchSession Function");
      })
    }

    function subjectList(x, y) {
      var x = $("#sel_batch").val();
      var y = $("#sel_program").val();
      //$.alert("In List Function"+ x + y);
      $.post("aaSql.php", {
        action: "subList",
        batchId: x,
        programId: y
      }, function(mydata, mystatus) {
        $("#subShowList").show();
        //$.alert("List " + mydata);
        $("#subShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function batchList() {
      //$.alert("In List Function"+ x + y);
      $.post("aaSql.php", {
        action: "batchList"
      }, function(mydata, mystatus) {
        $("#batchShowList").show();
        //$.alert("List " + mydata);
        $("#batchShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function sessionList() {
      var x = $("#sel_school").val();
      var y = $("#sel_batch").val();
      //$.alert("In List Function");
      $.post("aaSql.php", {
        actionSession: "sessionList",
        schoolId: x,
        batchId: y
      }, function(mydata, mystatus) {
        $("#sessionShowList").show();
        //$.alert("List " + mydata);
        $("#sessionShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function poList() {
      var x = $("#sel_program").val();
      var y = $("#sel_batch").val();
      //$.alert("In List Function" + x + y);

      $.post("aaSql.php", {
        action: "poList",
        programId: x,
        batchId: y
      }, function(mydata, mystatus) {
        $("#poShowList").show();
        //$.alert("List " + mydata);
        $("#poShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function coList() {
      var x = $("#sel_subject").val();
      // $.alert("In List Function" + x);

      $.post("aaSql.php", {
        action: "coList",
        subjectId: x
      }, function(mydata, mystatus) {
        $("#coShowList").show();
        //$.alert("List " + mydata);
        $("#coShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function programSelectList() {
      var x = $("#sel_school").val();
      var y = $("#sel_batch").val();
      //$.alert("In Program Select List Function" + x);
      $.post("aaSql.php", {
        actionSession: "programSelectList",
        schoolId: x,
        batchId: y
      }, function(mydata, mystatus) {
        $("#programShowList").show();
        //$.alert("List " + mydata);
        $("#programShowList").html(mydata);
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
          <div class="subjectForm">
            <div class="row">
              <div class="col-7">
                <div class="form-group">
                  Subject Name
                  <input type="text" class="form-control form-control-sm" id="subject_name" name="subject_name" placeholder="Subject Name">
                </div>
              </div>
              <div class="col-5">
                <div class="form-group">
                  Subject Code
                  <input type="text" class="form-control form-control-sm" id="subject_code" name="subject_code" placeholder="Subject Code">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <div class="form-group">
                  Semester
                  <input type="number" class="form-control form-control-sm" id="subject_semester" name="subject_semester" placeholder="Semester">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Credit
                  <input type="text" class="form-control form-control-sm" id="subject_credit" name="subject_credit" placeholder="Credit">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Internal
                  <input type="text" class="form-control form-control-sm" id="subject_internal" name="subject_internal" placeholder="Internal">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  External
                  <input type="text" class="form-control form-control-sm" id="subject_external" name="subject_external" placeholder="External">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <div class="form-group">
                  Lecture
                  <input type="number" class="form-control form-control-sm" id="subject_lecture" name="subject_lecture" placeholder="subject_lecture">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Tutorial
                  <input type="text" class="form-control form-control-sm" id="subject_tutorial" name="subject_tutorial" placeholder="subject_tutorial">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Practical
                  <input type="text" class="form-control form-control-sm" id="subject_practical" name="subject_practical" placeholder="subject_practical">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">

                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col">
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" checked id="stDC" name="subject_type" value="DC">DC
                </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" id="stOC" name="subject_type" value="OC">OC
                </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" id="stDE" name="subject_type" value="DE">DE
                </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" id="stOE" name="subject_type" value="OE">OE
                </div>
              </div>
              <div class="col">
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" checked id="smOff" name="subject_mode" value="Offline">Offline
                </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" id="smOn" name="subject_mode" value="Online">Online
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col">
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" checked id="scTh" name="subject_category" value="Theory">Theory
                </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" id="scPr" name="subject_category" value="Practical">Practical
                </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" id="scPrj" name="subject_category" value="Project">Project
                </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" id="scFW" name="subject_category" value="FieldWork">Field Work
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col">
                <?php
                $sql_staff = "select * from staff where staff_status='0' order by staff_name";
                $result_staff = $conn->query($sql_staff);
                if ($result_staff) {
                  echo '<select class="form-control form-control-sm" name="sel_staff" id="sel_staff" required>';
                  //echo '<option value="0">Select Coordinator</option>';
                  while ($rows_staff = $result_staff->fetch_assoc()) {
                    $select_id = $rows_staff['staff_id'];
                    $select_name = $rows_staff['staff_name'];
                    if ($abbri <> '') {
                      $select_abbri = $rows_staff[$abbri];
                      echo '<option value="' . $select_id . '">' . $select_name . '(' . $select_abbri . ')</option>';
                    } else echo '<option value="' . $select_id . '">' . $select_name . '</option>';
                  }
                  //echo '<option value="ALL">ALL</option>';
                  echo '</select>';
                } else echo $conn->error;
                if ($result_staff->num_rows == 0) echo 'No Data Found';
                ?>
              </div>
            </div>
          </div>
          <div class="batchForm">
            <div class="form-horizontal">
              <div class="form-group">
                <label class="control-label col-sm-2" for="batch">Batch:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control form-control-sm" id="newBatch" name="newBatch" placeholder="Batch">
                </div>
              </div>
            </div>
          </div>

          <div class="sessionForm">
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Session Name
                  <input type="text" class="form-control form-control-sm" id="session_name" name="session_name" placeholder="Session Name">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  Session Remarks
                  <input type="text" class="form-control form-control-sm" id="session_remarks" name="session_remarks" placeholder="Remarks">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                Start Date
                <input type="date" class="form-control form-control-sm" id="session_start" name="session_start" placeholder="Strat Date" value="<?php echo $submit_date; ?>">
              </div>
              <div class="col-6">
                End Date
                <input type="date" class="form-control form-control-sm" id="session_end" name="session_end" placeholder="Strat Date" value="<?php echo $submit_date; ?>">
              </div>
            </div>
          </div>

          <div class="poForm">
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Enter Code
                  <input type="text" class="form-control form-control-sm" id="poCode" name="poCode" placeholder="PO Code">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  Serial Order of PO
                  <input type="text" class="form-control form-control-sm" id="poSno" name="poSno" placeholder="Serial Order">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                PO statement
                <input type="text" class="form-control form-control-sm" id="poStatement" name="poStatement" placeholder="Enter PO Statement">
              </div>
            </div>
          </div>

          <div class="coForm">
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Enter Code
                  <input type="text" class="form-control form-control-sm" id="coCode" name="coCode" placeholder="CO Code">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  Serial Order of CO
                  <input type="text" class="form-control form-control-sm" id="coSno" name="coSno" placeholder="Serial Order">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                CO statement
                <input type="text" class="form-control form-control-sm" id="coStatement" name="coStatement" placeholder="Enter CO Statement">
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="modalId" name="modalId">
          <input type="hidden" id="action" name="action">
          <input type="hidden" id="batchIdModal" name="batchIdModal">
          <input type="hidden" id="programIdModal" name="programIdModal">
          <input type="hidden" id="subjectIdModal" name="subjectIdModal">
          <button type="submit" class="btn btn-success btn-sm" id="submitModalForm">Submit</button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->

    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

<!-- Modal Section-->
<div class="modal" id="secondModal">
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" id="modalSecondForm">
      <div class="modal-content bg-secondary text-white">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_titleSecond"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->
        <!-- Modal body -->
        <div class="modal-body">
          <div class="copySubjectForm">
            <div class="form-group row">
              <label class="control-label col-4"  for="batch">Copy to Batch:</label>
              <div class="col-sm-8">
                <?php
                $sql_batch = "select * from batch where batch_status='0' order by batch desc";
                $result_batch = $conn->query($sql_batch);
                if ($result_batch) {
                  echo '<select class="form-control form-control-sm" name="copy_batch" id="copy_batch" required>';
                  while ($rows_batch = $result_batch->fetch_assoc()) {
                    $select_id = $rows_batch['batch_id'];
                    $select_name = $rows_batch['batch'];
                    echo '<option value="' . $select_id . '">' . $select_name . '</option>';
                  }
                  //echo '<option value="ALL">ALL</option>';
                  echo '</select>';
                } else echo $conn->error;
                if ($result_batch->num_rows == 0) echo 'No Data Found';
                ?>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-sm-4" for="batch">Copy Semester:</label>
              <div class="col-sm-8">
                <input type="number" class="form-control form-control-sm" id="copy_semester" name="copy_semester" placeholder="Semester">
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="actionSecond" name="action">
          <input type="hidden" id="originalProgram" name="programId">
          <input type="hidden" id="originalBatch" name="batchId">
          <button type="submit" class="btn btn-success btn-sm">Submit</button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

</html>