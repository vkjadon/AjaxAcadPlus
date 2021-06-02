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
  <link rel="stylesheet" href="aa.css">

</head>

<body>
  <?php require("../topBar.php"); ?>
  <div class="content">

    <div class="container-fluid moduleBody">
      <div class="row">
        <div class="col-sm-2">
          <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active master" id="list-master-list" data-toggle="list" href="#list-master"> Academic Master Data </a>
            <a class="list-group-item list-group-item-action  bs" id="list-bs-list" data-toggle="list" href="#list-bs"> Batch/Session </a>
            <a class="list-group-item list-group-item-action po" id="list-po-list" data-toggle="list" href="#list-po"> Programme Outcome </a>
          </div>
        </div>
        <div class="col-10">
          <div class="tab-content" id="nav-tabContent">

            <div class="tab-pane show active" id="list-master" role="tabpanel">
              <div class="row">
                <div class="col-7 mt-1 mb-1">
                  <div class="container card shadow d-flex justify-content-center mt-2" id="card_aa">
                    <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab">
                      <li class="nav-item">
                        <a class="nav-link active tabLink" data-toggle="pill" href="#rt" data-tag="rt">Resource Type</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link tabLink" data-toggle="pill" href="#ss" data-tag="ss">Staff Specialization</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link tabLink" data-toggle="pill" href="#obam" data-tag="obam">OBA Methods </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link tabLink" data-toggle="pill" href="#obat" data-tag="obat">OBA Technique</a>
                      </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent p-3">
                      <div class="tab-pane show active" id="rt">
                        <form class="form-horizontal" id="rtForm">
                          <div class="row">
                            <div class="col-6">
                              <div class="form-group">
                                <label>Resource Type</label>
                                <input type="text" class="form-control form-control-sm" id="resource_type" name="resource_type">
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group">
                                <label>Remarks</label>
                                <input type="text" class="form-control form-control-sm" id="resource_remarks" name="resource_remarks">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col">
                              <button type="submit" class="btn btn-sm">Submit</button>
                            </div>
                          </div>
                        </form>
                      </div>
                      <div class="tab-pane fade" id="ss">
                        <form class="form-horizontal" id="fsForm">
                          <div class="row">
                            <div class="col-6">
                              <div class="form-group">
                                <label>Staff Specialization</label>
                                <input type="text" class="form-control form-control-sm" id="ss_name" name="ss_name">
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group">
                                <label>Remarks</label>
                                <input type="text" class="form-control form-control-sm" id="ss_remarks" name="ss_remarks">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col">
                              <button type="submit" class="btn btn-sm">Submit</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>

                  </div>
                </div>
                <div class="col-5 mt-1 mb-1">
                  <p id="tabList"></p>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="list-bs">
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

    // Left Panel Block
    $(document).on('click', '.bs', function() {
      batchList();
    });
    $(document).on('click', '.po', function() {
      $('#action').val("addPo");
      poList();
      poSummary();
    });
    

    $(document).on('submit', '#modalForm', function(event) {
      event.preventDefault(this);
      var action = $("#action").val();
      var batch = $("#newBatch").val();
      var selBatch = $("#batchId").val();
      var poc = $("#poCode").val();
      var poS = $("#poStatemnt").val();

      var sessionName = $("#session_name").val();

      var error = "NO";
      var error_msg = "";
      if (action == "addSession" || action == "updateSession") {
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
      } 

      if (error == "NO") {
        var formData = $(this).serialize();
        $('#firstModal').modal('hide');
        //$.alert(" Pressed" + formData);
        $.post("aaSql.php", formData, () => {}, "text").done(function(data) {
          //$.alert("List " + data);
          if (action == "addBatch" || action == "updateBatch") {
            batchList();
          } else if (action == "addPo" || action == "updatePo") {
            poList();
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
      var selBatch = $("#batchId").val();
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

    $(document).on('click', '.uploadPo', function() {
      // $.alert("Upload PO");
      $('#actionUpload').val('uploadPO')
      $('#button_action').show().val('Update PO');
      $('#formModal').modal('show');
      $('#modal_uploadTitle').html("Upload PO [<?php echo $myProgAbbri . '-' . $myBatchName . ']'; ?>");
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
        </div> <!-- Modal Body Closed-->
        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="modalId" name="modalId">
          <input type="hidden" id="action" name="action">
          <input type="hidden" id="batchIdModal" name="batchIdModal">
          <input type="hidden" id="programIdModal" name="programIdModal">
          <button type="submit" class="btn btn-secondary" id="submitModalForm">Submit</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->

    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

<!-- Modal Section-->
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