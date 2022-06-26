<?php
require('../requireSubModule.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>OBCon | AcadPlus | ClassConnect | EISOFTECH </title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php require("../css.php"); ?>
</head>

<body>
  <?php require("../topBar.php");
  if ($myId > 3) {
    if (!isset($_GET['tag'])) die("Illegal Attempt !! The token is Missing");
    elseif (!in_array($_GET['tag'], $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
    elseif (!in_array("34", $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
  }
  ?>

  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-1 p-0 m-0 pl-1 full-height">
        <h5 class="pt-3">PO Settings</h5>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action  show active po" data-toggle="list" href="#list-po" role="tab" aria-controls="po"> Program Outcome </a>
          <a class="list-group-item list-group-item-action sub" data-toggle="list" href="#list-sub" role="tab" aria-controls="sub"> Assign CC </a>
          <a class="list-group-item list-group-item-action alm" data-toggle="list" href="#list-alm" role="tab" aria-controls="alm"> Manage Alumni </a>
        </div>
      </div>
      <div class="col-sm-11 p-0">
        <div class="tab-content" id="nav-tabContent">
          <div class="row bg-light p-2 m-0">
            <div class="col-md-3 pr-0" title="Program/Specialization">
              <?php require("../selectProgram.php"); ?>
            </div>
            <div class="col-md-2">

            </div>
            <div class="col-sm-2 pr-0">
            </div>
            <div class="col-sm-2 pl-1">
            </div>
          </div>
          <div class="tab-pane show active" id="list-po" role="tabpanel" aria-labelledby="list-po-list">
            <div class="row m-1">
              <div class="col-sm-8">
                <div class="container card mt-2 mb-2 myCard">
                  <div class="largeText">
                    Program Outcome[<?php echo $tn_po; ?>]
                    <a class="fa fa-plus-circle p-0 addPo"></a>&nbsp;
                    <a class="fa fa-arrow-circle-up p-0 uploadPo"></a>
                  </div>
                  <div class="row mt-1">
                    <div class="col">
                      <table class="table table-striped list-table-xs" id="poTable">
                        <tr class="align-center">
                          <th><i class="fas fa-edit"></i></th>
                          <th>#</th>
                          <th>PO Sno</th>
                          <th>PO Statement</th>
                          <th><i class="fas fa-trash"></i></th>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-sub" role="tabpanel" aria-labelledby="list-sub-list">
            <div class="row m-1">
              <div class="col-sm-10">
                <div class="container card mt-2 mb-2 myCard">
                  <div class="largeText">Subjects</div>
                  <div class="row mt-1">
                    <div class="col">
                      <table class="table table-striped list-table-xs" id="subjectTable">
                        <tr class="align-center">
                          <th>#</th>
                          <th>ID</th>
                          <th>Sem</th>
                          <th>Code</th>
                          <th>Subject Name</th>
                          <th>Added</th>
                          <th>COs</th>
                          <th>COC Email</th>
                          <th>Add</th>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-alm" role="tabpanel" aria-labelledby="list-alm-list">
            <div class="row">
              <div class="col-sm-12">
                <h3>
                  <a class="fa fa-plus-circle p-0 addAlumni"></a>
                  <!-- <a class="fa fa-arrow-circle-up p-0 uploadAlumni"></a> -->
                </h3>
                <div class="container card mt-2 mb-2 myCard">
                  <div class="card-title-xs">Alumni</div>
                  <div class="row mt-1">
                    <div class="col">
                      <table class="table table-striped list-table-xs" id="almTable">
                        <tr class="align-center">
                          <th><i class="fas fa-edit"></i></th>
                          <th>Name</th>
                          <th>Roll No</th>
                          <th>Organization</th>
                          <th>Designation</th>
                          <th>Email Id</th>
                          <th>Feedback Link</th>
                          <th><i class="fas fa-trash"></i></th>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
    </div>
  </div>
  <?php require("../bottom_bar.php"); ?>
</body>

<script>
  $(document).ready(function() {
    $(function() {
      $(document).tooltip();
    });
    //Program Outcome
    $(document).on('click', '.po', function() {
      poList();
    });
    $(document).on('click', '.addPo', function() {
      $('#modal_title').html("Add PO");
      $('#action').val("addPo");
      $('#firstModal').modal('show');
      $('.almForm').hide();
      $('.poForm').show();
      $("#modalForm")[0].reset();
    });

    $(document).on('submit', '#modalForm', function(event) {
      event.preventDefault(this);
      var poStatement = $("#poStatement").val();
      var action = $("#action").val();
      if (action == "addPo" && poStatement === "") $.alert("PO Statement cannot be blank!! ");
      else if (action == "addAlumni" && almEmail === "") $.alert("Alumni Email cannot be blank!! ");
      else {
        var formData = $(this).serialize();
        // $.alert(formData);
        $('#firstModal').modal('hide');
        // $.alert(" Action " + action);
        $.post("obeProgramSql.php", formData, () => {}, "text").done(function(data, status) {
          // $.alert("List " + data);
          if (action == "addPo" || action == "updatePo") poList();
          else if (action == "addAlumni" || action == "updateAlumni") almList();
          $('#modalForm')[0].reset();
        }).fail(function() {
          $.alert("fail in place of error");
        })
      }
    });

    $(document).on('click', '.editPo', function() {
      var id = $(this).attr("data-id");
      // $.alert("Id " + id);

      $.post("obeProgramSql.php", {
        id: id,
        action: "fetchPo"
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.inst_name);

        $('#modal_title').text("Update PO");
        $('#poSno').val(data.po_sno);
        $('#poStatement').val(data.po_statement);

        $('#action').val("updatePo");
        $('#modalId').val(id);

        $('#firstModal').modal('show');
        $('.empForm').hide();
        $('.almForm').hide();
        $('.subjectForm').hide();
        $('.studentForm').hide();
        $('.poForm').show();

        //$("#ccform").html(mydata);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });
    $(document).on('click', '.uploadPo', function() {
      //$.alert("Session From");
      $('#modal_uploadTitle').html("Upload PO");
      $('#uploadModal').modal('show');
    });

    $(document).on('submit', '#upload_csv', function(event) {
      event.preventDefault();
      var formData = $(this).serialize();
      //$('#subjectList').hide();
      //$.alert(formData);
      // action and test_id are passed as hidden
      $.ajax({
        url: "uploadSql.php",
        method: "POST",
        data: new FormData(this),
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false
        success: function(data) {
          $.alert("List " + data);
          poList();
          //subjectList()
        }
      })
      $("#upload_csv")[0].reset;
      $('#uploadModal').modal('hide');
      $('#uploadSubjectModal').modal('hide');
    });

    function poList() {
      // $.alert("In PO Function");
      $.post("obeProgramSql.php", {
        action: "poList"
      }, function(mydata, mystatus) {
        //$.alert("List " + mydata);
      }, "json").done(function(data, status) {
        //$.alert(data)
        // $.alert(data.success)
        if (data.success == "0") {
          var success = "<tr><td colspan='5'></td>";
          $("#poTable").find("tr:gt(0)").remove();
          $("#poTable").append(success);

          var success = "<tr><td colspan='5'>No PO Found. Please add PO in case you are Program In-charge or Head of Department</td></tr>";
          $("#poTable").find("tr:gt(0)").remove();
          $("#poTable").append(success);

        } else {
          var card = '';
          var count = 1;
          $.each(data, function(key, value) {
            var status = value.po_status
            if (status != null) {
              card += '<tr>';
              var update_id = value.update_id
              if (update_id == <?php echo $myId; ?>) card += '<td><a href="#" class="editPo fa fa-pencil-alt" data-id="' + value.po_id + '"></td>';
              else card += '<td>--</td>';
              card += '<td>' + value.po_id + '</td>';
              card += '<td>' + value.po_sno + '</td>';
              card += '<td>' + value.po_statement + '</td>';
              card += '<td><a href="#" class="trashPo" data-id="' + value.po_id + '"><i class="fa fa-trash"></i></td>';
              card += '</tr>';
            }
          })
          $("#poTable").find("tr:gt(0)").remove();
          $("#poTable").append(card);
        }
      })
    }

    $(document).on('click', '.sub', function() {
      subjectList();
    });

    function subjectList() {
      // $.alert("In Subject");
      $.post("obeProgramSql.php", {
        action: "subjectList"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data)
        if (data.success == "0") {
          var success = "<tr><td colspan='9'>No subject Found. Please add Subjects</td></tr>";
          $("#subjectTable").find("tr:gt(0)").remove();
          $("#subjectTable").append(success);

        } else {
          var card = '';
          var count = 1;
          $.each(data, function(key, value) {
            var status = value.subject_status
            if (status != null) {
              card += '<tr>';
              var update_id = value.update_id
              card += '<td>' + count++ + '</td>';
              card += '<td>' + value.subject_id + '</td>';
              card += '<td>' + value.subject_semester + '</td>';
              card += '<td>' + value.subject_code + '</td>';
              card += '<td>' + value.subject_name + '</td>';
              card += '<td>' + value.email_1 + '@' + value.email_2 + '</td>';
              card += '<td>' + value.cos + '</td>';
              card += '<td><input type="text" class="form-control form-control-sm" id="' + value.subject_id + '" value="' + value.subject_coordinator + '"></td>'
              card += '<td><a href="#" class="footNote addCoC text-primary" data-id="' + value.subject_id + '">Update</td>';
              card += '<td><a href="#" class="sendEmail" data-id="' + value.subject_id + '" title="Send Mail"><i class="fa fa-envelope largeText"></i></td>';
              card += '</tr>';
            }
          })
          $("#subjectTable").find("tr:gt(0)").remove();
          $("#subjectTable").append(card);
        }
      })
    }

    $(document).on('click', '.addCoC', function() {
      var subject_id = $(this).attr("data-id");
      var coc = $("#" + subject_id).val();
      // $.alert("Subject " + subject_id + "COC " + coc);
      if (coc.length > 10) {
        $.post("obeProgramSql.php", {
          id: subject_id,
          coc: coc,
          action: "updateCoc"
        }, function() {}, "text").done(function(data, status) {
          $.alert(data)
        }).fail(function() {
          $.alert("Error in Adding COC")
        })
      } else $.alert(" Please add the corrdinator Email !! ");
    });

    $(document).on('click', '.sendEmail', function() {
      var subject_id = $(this).attr("data-id");
      var coc = $("#" + subject_id).val();
      $.alert("Subject " + subject_id + "COC " + coc);
      $.post("obeProgramSql.php", {
        id: subject_id,
        coc: coc,
        action: "sendMailCO"
      }, function() {}, "text").done(function(data, status) {
        $.alert(data)
      }).fail(function() {
        $.alert("Error in Adding COC")
      })
    });

    // Alumni
    $(document).on('click', '.addAlumni', function() {
      $('#modal_title').html("Add Employer");
      $('#action').val("addAlumni");
      $('#modalId').val("0");
      $('#firstModal').modal('show');
      $('.empForm').hide();
      $('.almForm').show();
      $('.coForm').hide();
      $('.poForm').hide();
      $('.batchForm').hide();
      $('.programForm').hide();
      $('.subjectForm').hide();
      $('.studentForm').hide();
    });

    function almList() {
      // $.alert("In Alumni");
      $.post("obeProgramSql.php", {
        action: "almList"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data)
        if (data.success == "0") {
          var success = "<tr><td colspan='9'>No Alumni Found. Please add Student</td></tr>";
          $("#almTable").find("tr:gt(0)").remove();
          $("#almTable").append(success);

        } else {
          var card = '';
          var count = 1;
          $.each(data, function(key, value) {
            var status = value.alm_status
            if (status != null) {
              card += '<tr>';
              var update_id = value.update_id
              if (update_id == <?php echo $myId; ?>) card += '<td><a href="#" class="editAlumni fa fa-pencil-alt" data-id="' + value.alm_id + '"></td>';
              else card += '<td>--</td>';
              card += '<td>' + value.alm_name + '</td>';
              card += '<td>' + value.alm_rollno + '</td>';
              card += '<td>' + value.alm_organization + '</td>';
              card += '<td>' + value.alm_designation + '</td>';
              card += '<td>' + value.alm_email + '</td>';
              card += '<td>https://obeconsulting.in/alumni/?id=' + value.alm_id + '&p=<?php echo $myProg; ?>&b=<?php echo $myBatch; ?><a href="https://obeconsulting.in/alumni/?id=' + value.alm_id + '&p=<?php echo $myProg; ?>&b=<?php echo $myBatch; ?>" target="_blank">Click</a></td>';
              // card += '<td></td>';
              card += '<td><a href="#" class="trashAlumni" data-id="' + value.alm_id + '"><i class="fa fa-trash"></i></td>';
              card += '</tr>';
            }
          })
          $("#almTable").find("tr:gt(0)").remove();
          $("#almTable").append(card);
        }
      })
    }

    $(document).on('change', '#sel_program', function() {
      var x = $("#sel_program").val();
      // $.alert("Program Changed " + x);
      $.post("../../util/session_variable.php", {
        action: "setProgram",
        programId: x
      }, function() {}, "text").done(function(mydata, mystatus) {
        // $.alert("- Program Updated -" + mydata);
        // location.reload();
      })
    }).fail(function() {
      $.alert("Error in Program!!");
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
          <div class="poForm">
            <div class="row">
              <div class="col-md-2 pr-0">
                <div class="form-group">
                  SNo
                  <input type="number" class="form-control form-control-sm" id="poSno" name="poSno" placeholder="Serial Order">
                </div>
              </div>
              <div class="col-md-10 pl-1">
                PO statement
                <input type="text" class="form-control form-control-sm" id="poStatement" name="poStatement" placeholder="Enter PO Statement">
              </div>
            </div>
          </div>
          <div class="almForm">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  Name
                  <input type="text" class="form-control form-control-sm" id="almName" name="almName" placeholder="Name">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  Roll Number
                  <input type="text" class="form-control form-control-sm" id="almRollno" name="almRollno" placeholder="Alumni Roll No">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  Present Organization
                  <input type="text" class="form-control form-control-sm" id="almIndustry" name="almIndustry" placeholder="Alumni Industry">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  Present Designation
                  <input type="text" class="form-control form-control-sm" id="almDesignation" name="almDesignation" placeholder="Alumni Designation">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  Email
                  <input type="text" class="form-control form-control-sm" id="almEmail" name="almEmail" placeholder="Alumni Email">
                </div>
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="modalId" name="modalId">
          <input type="hidden" id="action" name="action">
          <button type="submit" class="btn btn-sm" id="submitModalForm">Submit</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->

    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

<div class="modal" id="uploadModal">
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" id="upload_csv">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-titlePO"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->

        <!-- Modal body -->
        <div class="modal-body">
          <div class="uploadPOForm">
            <div class="form-group">
              <div class="row">
                <div class="col-sm-5">
                  <input type="file" name="csv_upload" />
                  <p>&nbsp;</p>
                  <p class="warning">First Row is header row</p>
                  <p class="warning">Data from Row 2</p>
                </div>
                <div class="col-sm-7 smallerText">
                  <ul>
                    <li>Column A - SNo</li>
                    <li>Column B - PO Statement</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->
        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" name="action" value="uploadPO">
          <input type="submit" name="button_action" value="Upload PO" class="btn btn-sm" />
          <button type="button" class="btn btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div>

</html>