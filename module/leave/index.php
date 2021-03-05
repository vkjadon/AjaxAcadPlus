<?php
session_start();
require("../../config_database.php");
require('../../config_variable.php');
require('../../php_function.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Admin Login : ClassConnect</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <link rel="stylesheet" href="../../table.css">
	<link rel="stylesheet" href="../../style.css">
</head>

<body>
<?php require("../topBar.php");?>

  <div class="container-fluid">
    <div class="row">
      <div class="col-3">
        <?php
        $url = $setUrl . '/acadplus/api/check_dept_head.php?u=' . $myUn . '&&p=' . $myPwd;
        $dept_head = check_dept_head($url);
        echo $dept_head.$myUn.$myId.$setUrl;
        ?>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active ccfList" id="list-ccf-list" data-toggle="list" href="#list-ccf" role="tab" aria-controls="ccf">Compensatory Claim Form/Status</a>
          <?php
          if ($dept_head == '1') {
            echo '<a class="list-group-item list-group-item-action ccfApprove" id="list-laf-list" data-toggle="list" href="#list-laf" role="tab" aria-controls="laf">Leave Forward/Approve Request</a>';
            echo '<a class="list-group-item list-group-item-action leaveReport" id="list-lr-list" data-toggle="list" href="#list-lr" role="tab" aria-controls="lr">Leave Report</a>';
          }
          ?>
        </div>
      </div>

      <div class="col-9">
        <div class="tab-content" id="nav-tabContent">

          <div class="tab-pane fade" id="list-laf" role="tabpanel" aria-labelledby="list-laf-list">
            <div class="card">
              <div class="card-header">
                <h5>Compensatory Claim Request</h5>
              </div>

              <div class="card-body">
                <p id="ccfForwarderPendingTitle"></p>
                <p id="ccfForwarderPendingList"></p>
                <p id="ccfApproverPendingTitle"></p>
                <p id="ccfApproverPendingList"></p>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="list-lr" role="tabpanel" aria-labelledby="list-lr-list">
            <div class="card">
              <div class="card-header">
                <h5>Leave Report Duration</h5>
              </div>

              <div class="card-body">
                <form>
                  <div class="row">
                    <div class="col">
                      <?php
                      $curl = curl_init();
                      $url = 'https://instituteerp.net/acadplus/api/select/get_department.php';
                      curl_setopt($curl, CURLOPT_URL, $url);
                      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                      $output = curl_exec($curl);
                      //echo $output;      
                      $session = json_decode($output, true);
                      //echo $session["data"][0][2];
                      echo '<select class="form-control form-control-sm" name="sel_dept" id="sel_dept">';
                      for ($i = 0; $i < count($session["data"]); $i++) {
                        echo '<option value="' . $session["data"][$i][0] . '">' . $session["data"][$i][0] . '-' . $session["data"][$i][1] . '</option>';
                      }
                      echo '<option value="00">ALL</option>';
                      echo '</select>';
                      curl_close($curl);
                      ?>
                    </div>
                    <div class="col">
                      <input type="date" class="form-control form-control-sm" id="leave_from" name="leave_from" value="<?php echo date("Y-m-d", time()); ?>">
                    </div>
                    <div class="col">
                      <input type="date" class="form-control input-sm" id="leave_to" name="leave_to" value="<?php echo date("Y-m-d", time()); ?>">
                    </div>
                    <div class="col">
                      <input type="submit" class="btn btn-primary btn-sm sr" name="submit" value="Show Report">
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <h5>Leave Report</h5>
              </div>
              <div class="card-body">
                <div class="bg-light leaveList">
                  <table class="table table-striped table-bordered list-table-xs" id="userTable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Staff Name</th>
                        <th>Leave Type</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Reason</th>
                      </tr>
                    </thead>
                  </table>
                </div>

              </div>
            </div>
          </div>

          <div class="tab-pane fade show active" id="list-ccf" role="tabpanel" aria-labelledby="list-ccf-list">
                <div class="card">
                  <div class="card-header">
                    <h5>Compensatory Claim Form</h5>
                  </div>
                  <div class="card-body">
                    <form class="ccform" id="ccform">
                      <div class="row">
                        <div class="col">
                          <input id="duty_date" name="duty_date" type="date" class="form-control input-sm" required>
                        </div>

                        <div class="col">
                          <input class="form-control input-sm" id="reason" name="reason" placeholder="Enter your remarks" required></textarea>
                        </div>

                        <div class="col">
                          <button type="submit" class="btn btn-primary btn-sm" id="ccfSubmit">Submit</button>
                          <input type="hidden" name="action" id="action">
                          <input type="hidden" name="id" id="lccfId">
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              

                <div class="card">
                  <div class="card-header">
                    <h5>Compensatory Leave Status</h5>
                  </div>
                  <div class="card-body">
                    <p id="ccfShowList"></p>
                  </div>
                </div>
              </div>
          </div>
      </div>
    </div>
  </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script>
  $(document).ready(function() {
    $(".topBarTitle").text("Leave Management");
    var un = "<?php echo $myUn; ?>";
    $('.leaveList').hide();

    ccfList();
    $('#action').val("add");

    $(document).on('click', '.sr', function(event) {
      var lf = $("#leave_from").val();
      var lt = $("#leave_to").val();
      var deptId = $("#sel_dept").val();
      event.preventDefault(this);
      if (lt < lf) $.alert("From date (" + getFormattedDate(lf, "dmY") + ") greater than To Date (" + getFormattedDate(lt, "dmY") + ")");
      else leaveList(lf, lt, deptId);
    });

    $(document).on('click', '.ccfList', function() {
      ccfList();
    });

    $(document).on('click', '.ccfApprove', function() {
      ccfForwarderPendingList();
      ccfApproverPendingList();
    });

    $(document).on('submit', '#modalForm', function(event) {
      event.preventDefault(this);
      var formData = $(this).serialize();
      $('#firstModal').modal('hide');
      $.alert("Pressed" + formData);

      $.post("leaveSql.php", formData, () => {}, "text").done(function(data) {
        $.alert("List ");
        ccfForwarderPendingList();
        ccfApproverPendingList();
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });


    $(document).on('click', '.lccf_idP', function() {

      var id = $(this).attr('id');
      //$.alert("lccf " + id);

      $.post("leaveSql.php", {
        lccfId: id,
        action: "fetch"
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.lccf_claim_date);

        $('#modal_title').text("CPL Claim Application [" + id + "]");

        $('#remarks').show();
        $('#submitModalForm').show();

        $('#actionM').val("approve");
        $('#modal_lccfId').val(id);
        $('#modal_status').val(data.lccf_status);

        claim_date = getFormattedDate(data.lccf_claim_date, "dmY");
        $('#modal_dutyDate').html(claim_date);

        submit_date = getFormattedDate(data.submit_ts, "dmY");
        $('#modal_submitTs').html(submit_date);

        update_date = getFormattedDate(data.update_ts, "dmY");
        $('#modal_updateTs').html(update_date);

        if (data.lccf_status == 2) {
          forward_date = getFormattedDate(data.lccf_forward_ts, "dmY");
          $('#modal_forwardDate').html("Forwarded On " + forward_date);
        } else {
          $('#modal_forwardDate').text("Forwarding Awaited");
        }

        if (data.lccf_status == 3) {
          approval_date = getFormattedDate(data.lccf_approver_ts, "dmY");
          $('#modal_approvalDate').html("Approved On " + approval_date);
        } else {
          $('#modal_approvalDate').text("Approval Awaited");
        }
        $('#modal_remarks').html(data.lccf_reason);
        $('#modal_comments').val(data.lccf_reason);

        $('#firstModal').modal('show');

        //$("#ccform").html(mydata);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.lccf_idI', function() {

      var id = $(this).attr('id');
      //$.alert("lccf " + id);

      $.post("leaveSql.php", {
        lccfId: id,
        action: "fetch"
      }, function() {}, "json").done(function(data) {
        //$.alert("List " + data.lccf_claim_date);

        $('#modal_title').text("CPL Claim Application [" + id + "]");
        $('#remarks').hide();
        $('#submitModalForm').hide();

        claim_date = getFormattedDate(data.lccf_claim_date, "dmY");
        $('#modal_dutyDate').html(claim_date);

        submit_date = getFormattedDate(data.submit_ts, "dmY");
        $('#modal_submitTs').html(submit_date);

        update_date = getFormattedDate(data.update_ts, "dmY");
        $('#modal_updateTs').html(update_date);

        if (data.lccf_status == 2) {
          forward_date = getFormattedDate(data.lccf_forward_ts, "dmY");
          $('#modal_forwardDate').html("Forwarded On " + forward_date);
        } else {
          $('#modal_forwardDate').text("Forwarding Awaited");
        }

        if (data.lccf_status == 3) {
          approval_date = getFormattedDate(data.lccf_approver_ts, "dmY");
          $('#modal_approvalDate').html("Approved On " + approval_date);
        } else {
          $('#modal_approvalDate').text("Approval Awaited");
        }
        $('#modal_remarks').html(data.lccf_reason);

        $('#firstModal').modal('show');

        //$("#ccform").html(mydata);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.lccf_idD', function() {
      var deleteId = $(this).attr('id');
      //$.alert("FDID " + deleteId);
      $.confirm({
        title: 'Confirm!',
        content: 'Please confirm to Proceed to Delete',
        buttons: {
          confirm: function() {
            $.post("leaveSql.php", {
              deleteId: deleteId,
              action: "delete"
            }, function(mydata, mystatus) {
              //$.alert(" Status: Deleted " + mydata + "Status " + mystatus);
            }, "text").done(function(data) {
              //$.alert("Data Added/Updated Successfully");
              ccfList();
            }).fail(function() {
              $.alert("Error !! ");
            })
          },
          cancel: function() {
            $.alert('Canceled!');
          },
        }
      });
    });


    $(document).on('click', '.lccf_idE', function() {
      $('#ccform').hide();
      var id = $(this).attr("id");
      //$.alert("Edit  Clicked !!"+id);
      $.post("leaveSql.php", {
        lccfId: id,
        action: "fetch"
      }, function(requestData, requestStatus) {}, "json").done(function(data) {
        //$.alert("List "+ data.lccf_claim_date);

        $('#duty_date').val(data.lccf_claim_date);
        $('#reason').val(data.lccf_reason);
        $('#lccfId').val(id);
        $('#action').val("edit");
        if (data.lccf_status > 0) {
          $('#ccfSubmit').hide();
        } else {
          $('#ccfSubmit').show();
        }

        $("#ccform").show();

        //$("#ccform").html(mydata);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $('#ccform').submit(function(event) {
      event.preventDefault();
      var formData = $(this).serialize();
      //$.alert(formData);

      $.post("leaveSql.php", formData, function() {}, "text").done(function(data) {
        $.alert("Data Added/Updated Successfully");
        $('#ccform')[0].reset();
        ccfList();
      }).fail(function() {
        $.alert("Error !! ");
      })
    });

    function ccfForwarderPendingList() {
      //$.alert("In List Function");
      $.post("leaveSql.php", {
        action: "ccfForwarderPendingList"
      }, function(mydata, mystatus) {
        $("#ccfForwarderPendingList").show();
        //$.alert("List " + mydata);
        $("#ccfForwarderPendingTitle").html("<h5>Pending for Forward</h5>");
        $("#ccfForwarderPendingList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function ccfApproverPendingList() {
      //$.alert("In List Function");
      $.post("leaveSql.php", {
        action: "ccfApproverPendingList"
      }, function(mydata, mystatus) {
        $("#ccfApproverPendingList").show();
        //$.alert("List " + mydata);
        $("#ccfApproverPendingTitle").html("<h5>Pending for Approval</h5>");
        $("#ccfApproverPendingList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function ccfList() {
      //$.alert("In List Function");
      $.post("leaveSql.php", {
        action: "ccfList"
      }, function(mydata, mystatus) {
        $("#ccfShowList").show();
        //$.alert("List " + mydata);
        $("#ccfShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function leaveList(lf, lt, deptId) {
      //$.alert("In List Function"+deptId);
      $('.leaveList').show();
      //$('#userTable').DataTable();
      $("#userTable").dataTable().fnDestroy();
      $('#userTable').DataTable({
        ajax: {
          url: 'leaveSql.php',
          data: {
            action: "leaveReport",
            deptId:deptId,
            lf: lf,
            lt: lt
          },
          type: 'post',
          dataSrc: 'data'
        },
        columns: [{
            "data": "0"
          },
          {
            "data": "1"
          },
          {
            "data": "2"
          },
          {
            "data": "3"
          },
          {
            "data": "4"
          },
          {
            "data": "5"
          }
        ]
      });
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
  <div class="modal-dialog modal-lg">
    <form class="form-horizontal" id="modalForm">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->

        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <div class="col-12" align="center">
                Submitted Information
                <table class="table list-table-xs" style="width: 90%;" align="center">
                  <tr>
                    <td><b>Duty Date</b></td>
                    <td id="modal_dutyDate"></td>
                    <td><b>Submit Date</b></td>
                    <td id="modal_submitTs"></td>
                    <td><b>Last Update</b></td>
                    <td id="modal_updateTs"></td>
                  </tr>
                </table>
                Approval Status
                <table class="table list-table-xs" style="width: 90%;" align="center">
                  <tr>
                    <td><b>Forwading Status</b></td>
                    <td id="modal_forwardDate"></td>
                    <td><b>Approval Status</b></td>
                    <td id="modal_approvalDate"></td>
                  </tr>
                </table>
                Communications
                <table class="table list-table-xs" style="width: 90%;" align="center">
                  <tr>
                    <td id="modal_remarks"></td>
                  </tr>
                </table>
                <div id="remarks">
                  <legend class="text-center header">Remarks</legend>
                  <table class="table list-table-xs" style="width: 90%;" align="center">
                    <tr>
                      <td>
                        <textarea class="form-control" id="comments" name="comments" placeholder="Enter your Comments" rows="2" required></textarea>
                      </td>
                    </tr>
                    <tr></tr>
                  </table>
                  <div class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" checked name="approve" value="1">Approve/Forward
                    </label>
                  </div>
                  <div class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="approve" value="0">Reject
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="modal_lccfId" name="modal_lccfId">
          <input type="hidden" id="actionM" name="action">
          <input type="hidden" id="modal_comments" name="modal_comments">
          <input type="hidden" id="modal_status" name="modal_status">
          <button type="submit" class="btn btn-success btn-sm" id="submitModalForm">Submit</button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->

    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

</html>