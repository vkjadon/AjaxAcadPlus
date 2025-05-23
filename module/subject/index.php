<?php
require('../requireSubModule.php');
addActivity($conn, $myId, "Subjects", $submit_ts);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Outcome Based Education : ClassConnect</title>
  <?php require('../css.php'); ?>
</head>

<body>
  <?php require("../topBar.php"); 
  if($myId>3){
    if (!isset($_GET['tag'])) die("Illegal Attempt !! The token is Missing");
    elseif (!in_array($_GET['tag'], $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
    elseif (!in_array("9", $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
  }
  ?>
  <div class="content">

    <div class="container-fluid moduleBody">
      <div class="row">
        <div class="col-1 p-0 m-0 full-height">
          <div class="mt-3">
            <h5> Manage Sub </h5>
          </div>
          <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action show active sub" id="list-sub-list" data-toggle="list" href="#list-sub" role="tab" aria-controls="sub"> Courses/Subjects </a>
            <a class="list-group-item list-group-item-action se" id="list-se-list" data-toggle="list" href="#list-se" role="tab" aria-controls="se">Session Electives</a>
            <a class="list-group-item list-group-item-action subReport" id="list-subReport-list" data-toggle="list" href="#list-subReport" role="tab" aria-controls="subReport"> Subject Report </a>
          </div>
          <div class="mr-2">
            <?php //require("../searchBar.php"); 
            ?>
          </div>
        </div>
        <div class="col-11 leftLinkBody">
          <div class="tab-content" id="nav-tabContent">
            <?php require("../setDefaultModule.php"); ?>
            <div class="tab-pane fade show active" id="list-sub" role="tabpanel" aria-labelledby="list-sub-list">
              <div class="row mt-2">
                <div class="col-sm-7">
                  <div class="row">
                    <div class="col-md-2">
                      <span class="largeText">Subjects </span>
                    </div>
                    <div class="col-md-3">
                      <h4>
                        <a class="fa fa-plus-circle p-0 addSubject"></a>
                        <a class="fa fa-arrow-circle-up p-0 uploadSubject"></a>
                        <a class="fa fa-copy p-0 copySubject"></a>
                      </h4>
                    </div>
                  </div>
                  <div id="subShowList"></div>
                  <div class="card myCard m-2 p-2">
                    <span class="smallText warning">In case you are unable to see any subject in the list. Please follow the following points:</span>
                    <div class="footNote">
                      <ul>
                        <li>Select the department from the <i>"Set Default"</i> section of the Home Page .</li>
                        <li>Change the specializations/batch from select menu at the last of the left menu bar.</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-sm-5">
                  <h3>Elective List</h3>
                  <div class="card myCard">
                    <div id="electiveList"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="list-se" role="tabpanel" aria-labelledby="list-se-list">
              <div class="row">
                <div class="col-sm-8">
                  <h5 class="disabled">Set Elective/CBCS Schedule</h5>
                  <div id="electivePool"></div>
                </div>
                <div class="col-sm-4">
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="list-subReport" role="tabpanel" aria-labelledby="list-subReport-list">
              <div class="row">
                <div class="col-sm-7">
                  <h5>Subject List</h5>
                  <div class="card myCard p-2">
                    <table class="table table-striped table-bordered list-table-xs" id="subReport">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Subject Code</th>
                          <th>Subject Name</th>
                          <th>L-T-P</th>
                          <th>Credit</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
                <div class="col-sm-5">
                  <h5>Subject Summary</h5>
                  <div id="subjectSummary"></div>
                </div>
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
  <h1>&nbsp;</h1>
</body>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
  $(document).ready(function() {

    $(function() {
      $(document).tooltip();
    });

    $(".topBarTitle").text("Academics");
    subjectList();
    electiveList();
    subReport();

    $(document).on('click', '.sub', function() {
      subjectList();
      electiveList();
    });

    $(document).on('click', '.se', function() {
      electivePool();
    });

    $(document).on('submit', '#modalForm', function(event) {
      event.preventDefault(this);
      var sn = $("#subject_name").val();
      var staff = $("#sel_staff").val();
      var action = $("#action").val();
      var batch = $("#newBatch").val();
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
        $.post("subjectSql.php", formData, () => {}, "text").done(function(data) {
          $.alert(data);
          if (action == "addSubject" || action == "updateSubject") {
            subjectList();
            electiveList();
          } else if (action == "addBatch" || action == "updateBatch") {
            batchList();
          } else if (action == "addPo" || action == "updatePo") {
            poList();
          } else if (action == "addCo" || action == "updateCo") {
            coList();
          } else if (action == "addSession" || action == "updateSession") {
            batchSession(<?php echo $myBatch; ?>);
          }
          $("#modalForm")[0].reset();
        }, "text").fail(function() {
          $.alert("fail in place of error");
        })
      } else {
        $.alert(error_msg);
      }
    });

    $(document).on("change", "#sel_subject", function() {
      var subject_id = $("#sel_subject").val();
      // $.alert("Changed Subject " + subject_id);
      $("#hiddenSubjectCO").val(subject_id);
      coList();
    });

    // Manage Subject
    $(document).on('click', '.subject_idD', function() {
      var id = $(this).attr("data-id");
      $.alert("Disabled " + id);
      $.post("subjectSql.php", {
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
      $.post("subjectSql.php", {
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
      $.post("subjectSql.php", {
        action: "fetchSubject",
        subjectId: id
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.inst_name);

        $('#modal_title').text("Update Subject [" + id + "]");

        $('#action').val("updateSubject");
        $('#subject_id').val(id);
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
        $('#sel_newProg').val(data.program_id);
        $('#sel_newBatch').val(data.batch_id);
        var staff = data.staff_id;
        //$.alert("Staff " + staff);
        $("#sel_staff option[value='" + staff + "']").attr("selected", "selected");
        var subType = data.subject_type;
        if (subType == 'DE') $("#stDE").prop("checked", true);
        else if (subType == 'OE') $("#stOE").prop("checked", true);
        else if (subType == 'DC') $("#stDC").prop("checked", true);
        else if (subType == 'OC') $("#stOC").prop("checked", true);

        var subMode = data.subject_mode;
        // if (subMode == 'Online') {
        //   document.getElementById("smOn").checked = true;
        // } else if (subMode == 'Offline') {
        //   document.getElementById("smOff").checked = true;
        // }

        // var subCat = data.subject_category;
        // if (subCat == 'Theory') {
        //   document.getElementById("scTh").checked = true;
        // } else if (subCat == 'Practical') {
        //   document.getElementById("scPr").checked = true;
        // } else if (subCat == 'Project') {
        //   document.getElementById("scPrj").checked = true;
        // } else if (subCat == 'Field Work') {
        //   document.getElementById("scFW").checked = true;
        // }
        $('#firstModal').modal('show');
        $('.subjectForm').show();
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });
    $(document).on('click', '.addSubject', function() {
      var x = $("#sel_batch").val();
      var y = <?php echo $myProg; ?>;
      $.alert("Subject" + x + " Prog ");
      if (x === "") $.alert("Please select Batch !!");
      else {
        $('#modal_title').html("Add Subject [<?php echo $myProgAbbri . '-' . $myBatchName . ']'; ?> ");
        $('#batchIdModal').val(x);
        $('#sel_newProg').val(y);
        $('#action').val("addSubject");
        $('#firstModal').modal('show');
        $('.coForm').hide();
        $('.subjectForm').show();
      }
    });
    $(document).on('submit', '#modalSecondForm', function(event) {
      event.preventDefault(this);
      var formData = $(this).serialize();
      $('#secondModal').modal("hide");
      // $.alert(" Pressed" + formData);
      $.post("subjectSql.php", formData, () => {}, "text").done(function(data) {
        $.alert(data);
        $("#modalSecondForm")[0].reset();
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });
    $(document).on('click', '.copySubject', function() {
      $('#modal_titleSecond').html("Copy Subject [<?php echo $myProgAbbri . '-' . $myBatchName . ']'; ?> ");
      $('#actionSecond').val("copySubject");
      $('#secondModal').modal('show');
    });
    $(document).on('click', '.vac', function() {
      var id = $(this).attr("data-id");
      var code = $(this).attr("data-code");
      var field = $(this).attr("data-field");
      var action = $(this).attr("data-action");
      var ep = $(this).attr("data-ep");
      // $.alert("Disabled " + id + " Code " + code + " Action " + action);
      $.post("subjectSql.php", {
        id: id,
        ep: ep,
        code: code,
        field: field,
        action: action
      }, function(data, status) {
        //$.alert("Data" + data)
        if (action === "vac") subjectList();
        else if (action === "se") electiveList();
        else electivePool();
      }, "text").fail(function() {
        $.alert("Error in BatchSession Function");
      })

    });

    // Functions
    function subReport() {
      $.post("subjectSql.php", {
        action: "subReport",
      }, () => {}, "json").done(function(data) {
        var table_row = '';
        $.each(data, function(key, value) {
          //$.alert(value.subject_name);
          table_row += '<tr>';
          table_row += '<td>' + value.subject_id + '</td>';
          table_row += '<td>' + value.subject_code + '</td>';
          table_row += '<td>' + value.subject_name + '</td>';
          table_row += '<td>' + value.subject_lecture + '-' + value.subject_tutorial + '-' + value.subject_practical + '</td>';
          table_row += '<td>' + value.subject_credit + '</td>';
          table_row += '</tr>';
        });
        $("#subReport").append(table_row);

      }).fail(function() {
        $.alert("fail in place of error");
      })
    }

    function electiveList() {
      //$.alert(" Select a Batch X = " + x);
      $.post("subjectSql.php", {
        action: "electiveList"
      }, function(mydata, mystatus) {
        //$.alert("List " + mydata);
        $("#electiveList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
      subjectSummary();
    }

    function electivePool() {
      //$.alert(" Pool ");
      $.post("subjectSql.php", {
        action: "electivePool"
      }, function(mydata, mystatus) {
        //$.alert("List " + mydata);
        $("#electivePool").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
      subjectSummary();
    }

    function subjectList() {
      //$.alert(" Select a Batch X = " + x);
      $.post("subjectSql.php", {
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
      $.post("subjectSql.php", {
        action: "subjectSummary"
      }, () => {}, "text").done(function(result, status) {
        //$.alert(status+result);
        $("#subjectSummary").html(result);
      }, "text").fail(function() {
        $.alert("Error 123 !!");
      })
    }

    function selectSubject() {
      var x = $("#sel_batch").val();
      $.alert("Batch In SelSub Function" + x);
      $.post("subjectSql.php", {
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

    function programSelectList() {
      var x = $("#sel_school").val();
      var y = $("#sel_batch").val();
      //$.alert("In Program Select List Function" + x);
      $.post("subjectSql.php", {
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

    $(document).on('change', '#sel_program', function() {
      var x = $("#sel_program").val();
      // $.alert("Program Changed " + x);
      $.post("../../util/session_variable.php", {
        action: "setProgram",
        programId: x
      }, function(mydata, mystatus) {
        // $.alert("- Program Updated -" + mydata);
        location.reload();
      }).fail(function() {
        $.alert("Error in Program!!");
      })
    })
    $(document).on('change', '#sel_batch', function() {
      var x = $("#sel_batch").val();
      //$.alert("Batch Changed " + x);
      $.post("../../util/session_variable.php", {
        action: "setBatch",
        batchId: x
      }, function(mydata, mystatus) {
        //$.alert("- Batch Updated -" + mydata);
        location.reload();
      }, "text").fail(function() {
        $.alert("Error in Natch !!");
      })
    })
    $(document).on('change', '#sel_dept', function() {
      var x = $("#sel_dept").val();
      //$.alert("Session  Changed " + x);
      $.post("../../util/session_variable.php", {
        deptId: x,
        action: "setDept"
      }, function(mydata, mystatus) {
        //alert("- Session Updated -" + mydata);
        location.reload();
      }, "text").fail(function() {
        $.alert("Erro Dept !!");
      })
    })
    $(document).on('change', '#sel_school', function() {
      var x = $("#sel_school").val();
      //$.alert("Session  Changed " + x);
      $.post("../../util/session_variable.php", {
        schoolId: x,
        action: "setSchool",
      }, function(mydata, mystatus) {
        //alert("- School Updated -" + mydata);
        location.reload();
        $("#sel_dept").val("0")
      }, "text").fail(function() {
        $.alert("Error in School!!");
      })
    })
  });
</script>

<!-- Modal Section-->
<div class="modal" id="firstModal">
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" id="modalForm">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->
        <!-- Modal body -->
        <div class="modal-body">
          <div class="subjectForm">
            <div class="row">
              <div class="col-6 pr-0">
                <div class="form-group">
                  Subject Name
                  <input type="text" class="form-control form-control-sm" id="subject_name" name="subject_name" placeholder="Subject Name"><span id="subject_id"></span>
                </div>
              </div>
              <div class="col-2 pl-1 pr-0">
                <div class="form-group">
                  Code
                  <input type="text" class="form-control form-control-sm" id="subject_code" name="subject_code" placeholder="Subject Code">
                </div>
              </div>

              <div class="col-2 pl-1 pr-0">
                <div class="form-group">
                  Semester
                  <input type="number" class="form-control form-control-sm" id="subject_semester" name="subject_semester" placeholder="Semester">
                </div>
              </div>
              <div class="col-2 pl-1">
                <div class="form-group">
                  SNo
                  <input type="number" class="form-control form-control-sm" id="subject_sno" name="subject_sno" placeholder="SNo">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-2 pr-0">
                <div class="form-group">
                  Lecture
                  <input type="number" class="form-control form-control-sm" id="subject_lecture" name="subject_lecture" placeholder="subject_lecture">
                </div>
              </div>
              <div class="col-2 pl-1 pr-0">
                <div class="form-group">
                  Tutorial
                  <input type="text" class="form-control form-control-sm" id="subject_tutorial" name="subject_tutorial" placeholder="subject_tutorial">
                </div>
              </div>
              <div class="col-2 pl-1 pr-0">
                <div class="form-group">
                  Practical
                  <input type="text" class="form-control form-control-sm" id="subject_practical" name="subject_practical" placeholder="subject_practical">
                </div>
              </div>
              <div class="col-2 pl-1 pr-0">
                <div class="form-group">
                  Credit
                  <input type="text" class="form-control form-control-sm" id="subject_credit" name="subject_credit" placeholder="Credit">
                </div>
              </div>
              <div class="col-2 pl-1 pr-0">
                <div class="form-group">
                  Program
                  <select class="form-control form-control-sm" name="sel_newProg" id="sel_newProg">
                    <?php
                    $sql = "select * from program where program_status='0' order by sp_name";
                    $result = $conn->query($sql);

                    while ($progRows = $result->fetch_assoc()) {
                      echo '<option value="' . $progRows["program_id"] . '">' . $progRows["sp_abbri"] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-2 pl-1">
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
            </div>
            <hr>
            <div class="row">
              <div class="col">
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" checked id="stDC" name="subject_type" title="Core Subject" value="DC">DC
                </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" id="stDE" name="subject_type" title="Elective Subject" value="DE">DE
                </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" id="stDP" name="subject_type" title="Elective Pool" value="EP">EP
                </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" id="stGB" name="subject_type" title="Governing Body" value="EP">GB
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col">
                <ul>
                  <li>EP (Elective Pool) is Elective subjects List for a Particular DE (Elective)</li>
                  <li>GB (Governing Body). The subjects suggested by UGC/AICTE etc</li>
                </ul>
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
          <button type="submit" class="btn btn-sm" id="submitModalForm">Submit</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">Close</button>
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
              <label class="control-label col-3" for="batch">Copy to Batch:</label>
              <div class="col-sm-9">
                <?php
                $sql_batch = "select * from batch where batch_status='0' order by batch desc";
                $result_batch = $conn->query($sql_batch);
                if ($result_batch) {
                  echo '<select class="form-control form-control-sm" name="newBatch" id="newBatch" required>';
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
              <label class="control-label col-sm-3" for="batch">Program:</label>
              <div class="col-sm-5">
                <select class="form-control form-control-sm" name="newProg" id="newProg">
                  <?php
                  $sql = "select p.* from program p, dept_program dp where dp.dept_id='$myDept' and dp.program_id=p.program_id and p.program_status='0' order by p.sp_name";
                  $result = $conn->query($sql);
                  while ($progRows = $result->fetch_assoc()) {
                    echo '<option value="' . $progRows["program_id"] . '">' . $progRows["sp_abbri"] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <label class="control-label col-sm-2" for="batch">Semester:</label>
              <div class="col-sm-2">
                <input type="number" class="form-control form-control-sm" id="newSemester" name="newSemester" value="1" min="1">
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="actionSecond" name="action">
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