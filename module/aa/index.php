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
            <a class="list-group-item list-group-item-action active bs" id="list-bs-list" data-toggle="list" href="#list-bs"> Batch/Session </a>
            <a class="list-group-item list-group-item-action po" id="list-po-list" data-toggle="list" href="#list-po"> Programme Outcome </a>
            <a class="list-group-item list-group-item-action fs" id="list-fs-list" data-toggle="list" href="#list-fs"> Faculty Specializations </a>
          </div>
        </div>
        <div class="col-10">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="list-bs">
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
    batchList();
    coList();

    $(document).on("change", "#sel_subject", function() {
      coList();
    });
    // Left Panel Block
    $(document).on('click', '.bs', function() {
      batchList();
    });
    $(document).on('click', '.po', function() {
      $('#action').val("addPo");
      poList();
      poSummary();
    });
    $(document).on('click', '.co', function() {
      $('#action').val("addCo");
      coList();
    });
    $(document).on('click', '.sub', function() {
      subjectList();
    });

    $(document).on('submit', '#modalForm', function(event) {
      event.preventDefault(this);
      var sn = $("#subject_name").val();
      var staff = $("#sel_staff").val();
      var action = $("#action").val();
      var batch = $("#newBatch").val();
      var selBatch = $("#batchId").val();
      var selSubject = $("#sel_subject").val();
      var poc = $("#poCode").val();
      var poS = $("#poStatemnt").val();
      var coc = $("#coCode").val();
      var coS = $("#coStatemnt").val();

      var sessionName = $("#session_name").val();

      var error = "NO";
      var error_msg = "";
      if (action == "addSubject" || action == "updateSubject") {
        if ($('#subject_name').val() === "" || $('#subject_semester').val() === "") {
          error = "YES";
          error_msg = "Subject Name and Semester cannot be blank";
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
        if (selBatch === "") {
          error = "YES";
          error_msg = "Please Select Batch to Proceed";
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
        //$.alert(" Pressed" + formData);
        $.post("aaSql.php", formData, () => {}, "text").done(function(data) {
          //$.alert("List " + data);
          if (action == "addSubject" || action == "updateSubject") {
            subjectList();
          } else if (action == "addBatch" || action == "updateBatch") {
            batchList();
          } else if (action == "addPo" || action == "updatePo") {
            poList();
          } else if (action == "addCo" || action == "updateCo") {
            coList();
          } else if (action == "addSession" || action == "updateSession") {
            batchSession(selBatch);
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
    $(document).on('click', '.addCO', function() {
      x = $('#sel_subject').val();
      //$.alert("x" + x);
      $('#subjectIdModal').val(x);
      $('#modal_title').text("Course Outcome");
      $('#action').val("addCo");
      $('#firstModal').modal('show');
      $('.subjectForm').hide();
      $('.batchForm').hide();
      $('.sessionForm').hide();
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
      $('#modal_title').html("Add PO [<?php echo $myProgAbbri; ?> - <?php echo $myBatchName; ?>]");
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
      $.alert("Id " + id);
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
      var selBatch=$("#batchId").val();
      $.alert("New Session ");
      $('#modal_title').text("Add Session" + selBatch);
      $('#batchIdModal').val(selBatch);
      $('#action').val("addSession");
      $("#firstModal").modal('show');
      $(".batchForm").hide();
      $(".poForm").hide();
      $(".coForm").hide();
      $(".subjectForm").hide();
      $(".sessionForm").show();
    });
    $(document).on('click', '.batch_idSession', function() {
      var id = $(this).attr('data-id');
      //$.alert("Process Id " + id);
      batchSession(id);
    });
    $(document).on('click', '.session_idE', function() {
      var id = $(this).attr('data-id');
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
      var id = $(this).attr("data-id");
      $.alert("Disabled " + id);
      $.post("aaSql.php", {
        id: id,
        action: "deleteSubject"
      }, function(data, status) {
        $.alert("Data" + data)
        subjectList();
      }, "text").fail(function() {
        $.alert("Error in BatchSession Function");
      })

    });
    $(document).on('click', '.subject_idR', function() {
      var id = $(this).attr("data-id");
      $.alert("Disabled " + id);
      $.post("aaSql.php", {
        id: id,
        action: "resetSubject"
      }, function(data, status) {
        //$.alert("Data" + data)
        subjectList();
      }, "text").fail(function() {
        $.alert("Error in BatchSession Function");
      })
    });
    $(document).on('click', '.subject_idE', function() {
      var id = $(this).attr("data-id");
      //$.alert("Id " + id);
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
        $('#subject_sno').val(data.subject_sno);
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
    });
    $(document).on('click', '.addSubject', function() {
      var x = $("#sel_batch").val();
      //$.alert("Add Subject" + x);
      if (x === "") $.alert("Please select Batch !!");
      else {
        $('#modal_title').html("Add Subject [<?php echo $myProgAbbri . '-' . $myBatchName . ']'; ?> ");
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
        //$.alert("List " + data);
        $("#modalSecondForm")[0].reset();
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });
    $(document).on('click', '.copySubject', function() {
      var x = $("#sel_batch").val();
      var y = $("#sel_program").val();
      //$.alert("Add Subject" + x + "-" + y);
      if (x === "" || y == "") $.alert("Please select Program and Batch");
      else {

        $('#modal_titleSecond').html("Copy Subject [<?php echo $myProgAbbri . '-' . $myBatchName . ']'; ?> ");
        $('#originalProgram').val(y);
        $('#originalBatch').val(x);
        $('#actionSecond').val("copySubject");
        $('#secondModal').modal('show');
      }
    });
    $(document).on('click', '.vac', function() {
      var id = $(this).attr("data-id");
      var code = $(this).attr("data-code");
      var field = $(this).attr("data-field");
      $.alert("Disabled " + id);
      $.post("aaSql.php", {
        id: id,
        code: code,
        field: field,
        action: "vac"
      }, function(data, status) {
        //$.alert("Data" + data)
        subjectList();
      }, "text").fail(function() {
        $.alert("Error in BatchSession Function");
      })

    });
    // Functions
    function batchSession(x) {
      //$.alert("Batch " + x);
      $.post("aaSql.php", {
        action: "batchSession",
        batchId: x
      }, function(data, status) {
        //$.alert("Data" + data)
        $("#batchSession").html(data);
        $("#batchId").val(x);
      }, "text").fail(function() {
        $.alert("Error in BatchSession Function");
      })
    }

    function subjectList() {
      //$.alert(" Select a Batch X = " + x);
      $.post("aaSql.php", {
        action: "subList"
      }, function(mydata, mystatus) {
        //$.alert("List " + mydata);
        $("#subShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
      subjectSummary();
    }

    function subjectSummary() {
      $.post("aaSql.php", {
        action: "subjectSummary"
      }, () => {}, "text").done(function(result, status) {
        //$.alert(status+result);
        $("#subjectSummary").html(result);
      }, "text").fail(function() {
        $.alert("Error 123 !!");
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

    function poList() {
      $.post("aaSql.php", {
        action: "poList"
      }, function(mydata, mystatus) {
        $("#poShowList").show();
        //$.alert("List " + mydata);
        $("#poShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function poSummary() {
      $.post("aaSql.php", {
        action: "poSummary"
      }, function(mydata, mystatus) {
        //$.alert("List " + mydata);
        $("#poSummary").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function selectSubject() {
      var x = $("#sel_batch").val();
      $.alert("Batch In SelSub Function" + x);
      $.post("aaSql.php", {
        batch_id: x,
        action: "selectSubject"
      }, function(mydata, mystatus) {
        //$.alert("List " + mydata);
        //$(".selectSubject").show();
        $(".selectSubject").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function coList() {
      // $.alert("In List Function" + x);
      $.post("aaSql.php", {
        action: "coList"
      }, function(mydata, mystatus) {
        $("#coShowList").show();
        //$.alert("List " + mydata);
        $("#coShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
      $.post("aaSql.php", {
        action: "copoMap"
      }, function(mydata, mystatus) {
        //$.alert("List " + mydata);
        $("#copoMap").html(mydata);
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

    $(document).on('click', '.uploadSubject', function() {
      //$.alert("Session From");
      //var batch = $(this).attr("data-batch");
      $('#modal_uploadTitle').html("Upload Subject [<?php echo $myProgAbbri . '-' . $myBatchName . ']'; ?> ");
      //$('#program').val(program);
      //$('#batch').val(batch);
      var y = $("#sel_batch").val();
      $("#batch_idUpload").val(y);
      $('#button_action').show().val('Update Subject');
      $('#actionUpload').val('uploadSubject');
      $('#formModal').modal('show');
    });
    $(document).on('click', '.uploadPo', function() {
      // $.alert("Upload PO");
      $('#actionUpload').val('uploadPO')
      $('#button_action').show().val('Update PO');
      $('#formModal').modal('show');
      $('#modal_uploadTitle').html("Upload PO [<?php echo $myProgAbbri . '-' . $myBatchName . ']'; ?>");
    });
    $(document).on('click', '.uploadCo', function() {
      // $.alert("Session From");
      $('#actionUpload').val('uploadCO')
      $('#button_action').show().val('Update CO');
      $('#formModal').modal('show');
      $('#modal_uploadTitle').text("Upload CO  [<?php echo $myProgAbbri . '-' . $myBatchName . ']'; ?>");
    });
    $(document).on('submit', '#upload_csv', function(event) {
      event.preventDefault();
      var formData = $(this).serialize();
      $('#subjectList').hide();
      //$.alert(formData);
      // action and test_id are passed as hidden
      $.ajax({
        url: "uploadSubjectSql.php",
        method: "POST",
        data: new FormData(this),
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false
        success: function(data) {
          $.alert("List " + data);
        }
      })
      $("#formModal")[0].reset;
      $('#formModal').modal('hide');
    });


  });
</script>

<!-- Modal Section-->
<div class="modal" id="firstModal">
  <div class="modal-dialog">
    <form class="form-horizontal" id="modalForm">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->
        <!-- Modal body -->
        <div class="modal-body">
          <div class="batchForm">
            <div class="form-horizontal">
              <div class="form-group">
                <div class="row">
                  <div class="col-sm-4">
                    Batch<input type="text" class="form-control form-control-sm" id="newBatch" name="newBatch" placeholder="Batch">
                  </div>
                  <div class="col-sm-4">
                    Batch<input type="text" class="form-control form-control-sm" id="newBatch" name="newBatch" placeholder="Batch">
                  </div>
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
          <button type="submit" class="btn btn-secondary" id="submitModalForm">Submit</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->

    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

<!-- Modal Section-->
<div class="modal" id="secondModal">
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" id="modalSecondForm">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_titleSecond"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->
        <!-- Modal body -->
        <div class="modal-body">
          <div class="copySubjectForm">
            <div class="form-group row">
              <label class="control-label col-4" for="batch">Copy to Batch:</label>
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
          <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

<div class="modal" id="formModal">
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" id="upload_csv">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_uploadTitle"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->

        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <div class="col-sm-10">
                <input type="file" name="csv_upload" />
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->
        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" name="action" id="actionUpload">
          <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" />
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div>

</html>