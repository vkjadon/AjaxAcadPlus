<?php
require('../requireSubModule.php');

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
            <a class="list-group-item list-group-item-action po" id="list-po-list" data-toggle="list" href="#list-po"> Programme Outcome </a>
            <a class="list-group-item list-group-item-action co" id="list-co-list" data-toggle="list" href="#list-co" role="tab" aria-controls="co"> Course Outcome </a>
            <a class="list-group-item list-group-item-action copo" id="list-copo-list" data-toggle="list" href="#list-copo" role="tab" aria-controls="copo"> CO-PO Map </a>
          </div>
        </div>
        <div class="col-10">
          <div class="tab-content" id="nav-tabContent">
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
            <div class="tab-pane fade show" id="list-co" role="tabpanel" aria-labelledby="list-co-list">
              <div class="row">
                <div class="col-sm-12">
                  <button class="btn btn-sm btn-secondary addCO m-0">Add</button>
                  <button class="btn btn-sm btn-primary uploadCo">Upload CO</button>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-9">
                  <span style="text-align:left" id="coShowList"></span>
                </div>
              </div>
            </div>
            <div class="tab-pane fade show" id="list-copo" role="tabpanel" aria-labelledby="list-copo-list">
              <div class="row">
                <div class="col-sm-8">
                  <span style="text-align:left" id="copoMap"></span>
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

<?php require("../js.php"); ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
  $(document).ready(function() {



    // Left Panel Block

    $(document).on('click', '.po', function() {
      $('#action').val("addPo");
      poList();
      poSummary();
    });

    $(document).on('click', '.co', function() {
      $('#action').val("addCo");
      coList();
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
        $.post("obaSettingsSql.php", formData, () => {}, "text").done(function(data) {
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
      $.post("obaSettingsSql.php", {
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
      $.post("obaSettingsSql.php", {
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

    // Functions


    function poList() {
      $.post("obaSettingsSql.php", {
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
      $.post("obaSettingsSql.php", {
        action: "poSummary"
      }, function(mydata, mystatus) {
        //$.alert("List " + mydata);
        $("#poSummary").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }
    function coList() {
      // $.alert("In List Function" + x);
      $.post("obaSettingsSql.php", {
        action: "coList"
      }, function(mydata, mystatus) {
        $("#coShowList").show();
        //$.alert("List " + mydata);
        $("#coShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
      $.post("obaSettingsSql.php", {
        action: "copoMap"
      }, function(mydata, mystatus) {
        //$.alert("List " + mydata);
        $("#copoMap").html(mydata);
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
        url: "uploadobaSettingsSql.php",
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