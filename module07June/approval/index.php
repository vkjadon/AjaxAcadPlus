<?php
session_start();
require("../../config_database.php");
require('../../config_variable.php');
require('../../phpFunction/leaveFunction.php');
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
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">

          <a class="list-group-item list-group-item-action active sea" id="list-ea-list" data-toggle="list" href="#list-sea" role="tab" aria-controls="sea">Subject Extra Attendance </a>
          <!-- <a class="list-group-item list-group-item-action ea" id="list-ea-list" data-toggle="list" href="#list-ea" role="tab" aria-controls="ea"> Extra Attendance </a> -->
          <a class="list-group-item list-group-item-action ear" id="list-ear-list" data-toggle="list" href="#list-ear" role="tab" aria-controls="ear"> Extra Attendance Report</a>
        </div>

      </div>

      <div class="col-10">
        <div class="tab-content" id="nav-tabContent">

          <div class="tab-pane show active" id="list-sea" role="tabpanel" aria-labelledby="list-sea-list">
            <div class="row">
              <div class="col-12 mt-1 mb-1">
                <p id="sasEACList"></p>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="list-ea" role="tabpanel" aria-labelledby="list-ea-list">
            <div class="row">
              <div class="col-12 mt-1 mb-1">
                <p id="eaClaimList"></p>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-appLeave" role="tabpanel" aria-labelledby="list-appLeave-list">
            <div class="row">
              <div class="col-8 mt-1 mb-1"><button class="btn btn-secondary btn-square-sm mt-1 addNew2">New2</button>
                <p id="appLeaveList"></p>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-ear" role="tabpanel" aria-labelledby="list-ear-list">
            <div class="row">
              <div class="col-6 mt-1 mb-1">
                <div class="row">
                  <div class="col-6 p-0">
                    <p class="programList"></p>
                  </div>
                  <div class="col-6">
                    <p class="classList"></p>
                  </div>
                </div>
                <p id="classStudentList"></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

<?php require("../js.php");?>


<script>
  $(document).ready(function() {
    $(".topBarTitle").text("Approvals");
    eaClaimList();
    sasEACList();

    $(document).on('click', '.ear', function() {
      programSelectList();
    });

    $(document).on('change', '#sel_program', function() {
      var programId=$("#sel_program").val();
      //$.alert("Program " + programId);
      if(programId=="ALL")$.alert("ALL Program Disabled!!");
      else classSelectList();
    });

    $(document).on('change', '#sel_class', function() {
      classStudentList();

    });

    $(document).on('click', '.sasRejectButton', function() {
      var student_id = $(this).attr("data-std")
      var sas_id = $(this).attr("data-sas")
      //$.alert("Std " + student_id + " SAS " + sas_id);
      $.post("approvalSql.php", {
        action: "rejectSAS",
        student_id: student_id,
        sas_id: sas_id
      }, function(data, status) {
        //$.alert("Success " + data);
        sasEACList();
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });
    $(document).on('click', '.sasApproveButton', function() {
      var student_id = $(this).attr("data-std")
      var sas_id = $(this).attr("data-sas")
      //$.alert("Std " + student_id + " SAS " + sas_id);
      $.post("approvalSql.php", {
        action: "approveSAS",
        student_id: student_id,
        sas_id: sas_id
      }, function(data, status) {
        $.alert(data);
        sasEACList();
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });
    $(document).on('click', '.approveButton', function() {
      var text = $(this).attr("data-text")
      var student_id = $(this).attr("data-std")
      var eae_id = $(this).attr("data-eae")
      var eac_date = $(this).attr("data-eacDate")
      //$.alert("Std " + student_id + " Eae " + eae_id + " text " + text);
      $('#modalApproval').modal().show;
      $("#modalText").html(text);
      $("#student_id").val(student_id);
      $("#eae_id").val(eae_id);
      $("#eac_date").val(eac_date);
      $("#modalText").html(text);
    });
    $(document).on('click', '.rejectButton', function() {
      var student_id = $(this).attr("data-std")
      var eac_date = $(this).attr("data-eacDate")
      //$.alert("Std " + student_id + " Date " + eac_date);
      $.post("approvalSql.php", {
        action: "rejectEAC",
        student_id: student_id,
        eac_date: eac_date
      }, function(data, status) {
        //$.alert("Success " + data);
        eaClaimList();
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });

    $(document).on('submit', '#modalForm', function(event) {
      event.preventDefault(this);
      var action = $("#action").val();

      //$.alert("Form Submitted " + action);
      var error = "NO";
      var error_msg = "";
      if (action == "updateEAC" && $("#approved").val() === "") {
        error = "YES";
        error_msg = "Approved Value Cannot be blank";
      }
      if (error == "NO") {
        var formData = $(this).serialize();
        //$.alert(formData);
        $.post("approvalSql.php", formData, () => {}, "text").done(function(data) {
          //$.alert(data);
          eaClaimList();
          $('#modalApproval').modal('hide');
          $('#modalForm')[0].reset();
        }, "text").done(function(mydata, mystatus) {
          //$.alert("Data" + mydata);
        }).fail(function() {
          $.alert("fail in place of error");
        })
      } else {
        $.alert(error_msg);
      }
    });

    function classSelectList() {
      var programId=$("#sel_program").val();
      //$.alert("In Class List " + programId);
      $.post("attendanceReportSql.php", {
        programId:programId,
        action: "class"
      }, function(data, status) {
        //$.alert("Success " + data);
        $(".classList").html(data);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }
    function programSelectList() {
      //$.alert("In program List");
      $.post("attendanceReportSql.php", {
        action: "program"
      }, function(data, status) {
        //$.alert("Success " + data);
        $(".programList").html(data);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }    
    function classStudentList() {
      var classId=$("#sel_class").val();
      //$.alert("In Class Student List");
      $.post("attendanceReportSql.php", {
        classId: classId,
        action: "classStudentList"
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#classStudentList").html(data);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function sasEACList() {
      //$.alert("In SAS Claim List");
      $.post("approvalSql.php", {
        action: "sasEACList"
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#sasEACList").html(data);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }
    function sasEACReport() {
      //$.alert("In SAS Claim Report");
      $.post("attendanceReportSql.php", {
        action: "sasEACReport"
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#sasEACReport").html(data);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }
    function eaClaimList() {
      //$.alert("In Claim List");
      $.post("approvalSql.php", {
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
<div class="modal" id="modalApproval">
  <div class="modal-dialog modal-md">
    <div class="modal-content bg-secondary text-white">
      <form class="form-horizontal" id="modalForm">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4>Approve Extra Attendance </h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->
        <!-- Modal body -->
        <div class="modal-body">
          <div id="modalText"></div>
          Approved Attendances
          <input type="number" class="form-control" id="approved" name="approved">
        </div> <!-- Modal Body Closed-->

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="action" name="action" value="updateEAC">
          <input type="hidden" id="student_id" name="student_id">
          <input type="hidden" id="eac_date" name="eac_date">
          <button type="submit" class="btn btn-danger btn-sm eaApprovalForm">Submit</button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </form>
    </div> <!-- Modal Conent Closed-->

  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->


</html>