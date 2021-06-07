<?php
session_start();
require("../../config_database.php");
require('../../config_variable.php');
require('../../php_function.php');
$sql = "select * from leave_duration";
$result = $conn->query($sql);
if ($result) {
  while ($rowsArray = $result->fetch_assoc()) {
    $short_leave = $rowsArray['short_leave'];
    $half_day = $rowsArray['half_day'];
    $update_ts = $rowsArray['update_ts'];
    $update_id = $rowsArray['update_id'];
  }
} else echo $conn->error;

?>
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="leave.css">

<head>
  <title>Admin Login : ClassConnect</title>
  <?php require("../css.php"); ?>
  <link rel="stylesheet" href="leave.css">
</head>

<body>
  <?php require("../topBar.php"); ?>

  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-2">
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active lt" id="list-lt-list" data-toggle="list" href="#list-lt" role="tab" aria-controls="lt">Leave Type</a>
          <a class="list-group-item list-group-item-action lc" id="list-lc-list" data-toggle="list" href="#list-lc" role="tab" aria-controls="lc">Leave Credit</a>
          <a class="list-group-item list-group-item-action lf" id="list-lf-list" data-toggle="list" href="#list-lf" role="tab" aria-controls="lf">Leave Form</a>
          <a class="list-group-item list-group-item-action ss" id="list-ss-list" data-toggle="list" href="#list-ss" role="tab" aria-controls="ss">Special Staff</a>
          <a class="list-group-item list-group-item-action ccfList" id="list-ccf-list" data-toggle="list" href="#list-ccf" role="tab" aria-controls="ccf">Compensatory Claim Form/Status</a>
          <a class="list-group-item list-group-item-action ccfApprove" id="list-laf-list" data-toggle="list" href="#list-laf" role="tab" aria-controls="laf">Leave Forward/Approve Request</a>
          <a class="list-group-item list-group-item-action leaveReport" id="list-lr-list" data-toggle="list" href="#list-lr" role="tab" aria-controls="lr">Leave Report</a>
        </div>
      </div>

      <div class="col-10">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="list-lt" role="tabpanel" aria-labelledby="list-lt-list">
            <div class="row">
              <div class="col-5">
                <div class="container card mt-2 myCard">
                  <!-- nav options -->
                  <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="pills_leaveType" data-toggle="pill" href="#pills_type" role="tab" aria-controls="pills_type" aria-selected="true">Leave Type</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="pills_leaveYear" data-toggle="pill" href="#pills_year" role="tab" aria-controls="pills_year" aria-selected="false">Leave Year</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="pills_leaveDuration" data-toggle="pill" href="#pills_duration" role="tab" aria-controls="pills_duration" aria-selected="false">Leave Duration</a>
                    </li>
                  </ul>
                  <!-- content -->
                  <div class="tab-content" id="pills-tabContent p-3">
                    <div class="tab-pane show active" id="pills_type" role="tabpanel" aria-labelledby="pills_leaveType">
                      <form class="form-horizontal" id="leaveTypeForm">
                        <div class="row">
                          <div class="col-8">
                            <div class="form-group">
                              <input type="text" class="form-control form-control-sm" id="leave_name" name="leave_name" placeholder="Leave Type" />
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="form-group">
                              <input type="text" class="form-control form-control-sm" id="leave_abbri" name="leave_abbri" placeholder="Abbri(4)" />
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-4">
                            <div class="form-group">
                              <input type="number" class="form-control form-control-sm" id="leave_male" name="leave_male" min="0" placeholder="Male">
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="form-group">
                              <input type="number" class="form-control form-control-sm" id="leave_female" name="leave_female" min="0" placeholder="Female">
                            </div>
                          </div>

                          <div class="col-4">
                            <div class="form-group">
                              <input type="number" class="form-control form-control-sm" id="leave_monthly" name="leave_monthly" min="0" step="0.5" placeholder="Monthly Restriction">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-4">
                            <input type="checkbox" id="leave_check" name="leave_check"> Balance Check
                          </div>
                          <div class="col-4">
                            <input type="checkbox" id="leave_carry" name="leave_carry"> Carry Forward
                          </div>
                          <div class="col-4">
                            <div class="form-group">
                              <input type="number" class="form-control form-control-sm" id="leave_max" name="leave_max" min="0" placeholder="Ceiling">
                            </div>
                          </div>
                        </div>
                        <input type="hidden" id="actionLeaveType" name="action" value="addLeaveType">
                        <input type="hidden" id="ltId" name="leaveId" value="0">
                        <button type="submit" class="btn btn-sm">Submit</button>
                      </form>
                    </div>
                    <div class="tab-pane fade" id="pills_year" role="tabpanel" aria-labelledby="pills_leaveYear">
                      <form class="form-horizontal" id="leaveYearForm">
                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label>From</label>
                              <input type="date" class="form-control form-control-sm" id="ly_from" name="ly_from" value="<?php echo $submit_date; ?>" placeholder="">
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label>To</label>
                              <input type="date" class="form-control form-control-sm" id="ly_to" name="ly_to" value="<?php echo $submit_date; ?>" placeholder="">
                            </div>
                          </div>
                        </div>
                        <input type="hidden" id="actionLeaveYear" name="action" value="addLeaveYear">
                        <input type="hidden" id="lyId" name="lyId" value="0">
                        <button type="submit" class="btn btn-sm">Submit</button>
                      </form>
                    </div>
                    <div class="tab-pane fade" id="pills_duration" role="tabpanel" aria-labelledby="pills_leaveDuration">
                      <div class="row">
                        <div class="col-3">
                          <div class="form-group">
                            <label>Short Leave</label>
                            <input type="text" class="form-control form-control-sm" value="<?php echo $short_leave; ?>" />
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="form-group">
                            <label>Half Day</label>
                            <input type="text" class="form-control form-control-sm" type="text" value="<?php echo $half_day; ?>" />
                          </div>
                        </div>
                        <div class="col-6 text-center">
                          Last updated by</br>
                          <label>
                            <?php
                            echo getField($conn, $update_id, "staff", "staff_id", "staff_name");
                            echo '<br>' . date("d-m-Y h-m", strtotime($update_ts));
                            ?>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-7">
                <div class="container card shadow d-flex justify-content-center mt-2">
                  <table class="table table-striped list-table-xs mt-3" id="leaveTypeTable">
                    <tr class="align-center">
                      <th><i class="fas fa-edit"></i></th>
                      <th>Leave Type</th>
                      <th>Abbri</th>
                      <th>Male</th>
                      <th>Female</th>
                      <th>Monthly</th>
                      <th>Check</th>
                      <th>Carry</th>
                      <th>Ceiling</th>
                    </tr>
                  </table>
                </div>
                <div class="container card shadow d-flex justify-content-center mt-1">
                  <table class="table table-bordered table-striped list-table-xs mt-3" id="leaveYearTable">
                    <tr class="align-center">
                      <th><i class="fas fa-edit"></i></th>
                      <th>From</th>
                      <th>To</th>
                      <th>Set Current Year</th>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="list-lc" role="tabpanel" aria-labelledby="list-lc-list">
            <div class="row">
              <div class="col-5">
                <div class="container card shadow d-flex justify-content-center mt-2" id="card_leave">
                  <!-- nav options -->
                  <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="pills_leaveType" data-toggle="pill" href="#pills_type" role="tab" aria-controls="pills_type" aria-selected="true">Leave Credit</a>
                    </li>
                  </ul> <!-- content -->
                  <div class="tab-content" id="pills-tabContent p-3">
                    <div class="tab-pane fade show active" id="pills_type" role="tabpanel" aria-labelledby="pills_leaveType">
                      <form class="form-horizontal" id="addLeaveSetup">
                        <div class="form-group">
                          <?php
                          $months = array(" ", "January", "Feburary", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                          echo '<div class="row">';
                          echo '<div class="col-6">';
                          echo '<select class="form-control form-control-sm" name="sel_month" id="sel_month" required>';
                          echo '<option selected disabled>Select Month</option>';
                          for ($i = 1; $i < 13; $i++) echo '<option value="' . $i . '">' . $months[$i] . '</option>';
                          echo '</select>';
                          echo '</div>';
                          ?>
                          <?php
                          $sql_lt = "select * from leave_type";
                          $result = $conn->query($sql_lt);
                          echo '<div class="col-6">';
                          if ($result) {
                            echo '<select class="form-control form-control-sm" name="sql_lt" id="sql_lt" required>';
                            echo '<option selected disabled>Select Leave Type</option>';
                            while ($rows = $result->fetch_assoc())echo '<option value="' . $rows['lt_id'] . '">' . $rows['lt_name'] . '</option>';
                            echo '</select>';
                            echo '</div></div>';
                          } else echo $conn->error;
                          if ($result->num_rows == 0) echo 'No Data Found';
                          ?>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <label>Gender</label>
                            <div class="form-group">
                              <div class="form-check-inline">
                                <input type="radio" class="form-check-input" checked id="lcMale" name="lcGender" value="Male">Male
                              </div>
                              <div class="form-check-inline">
                                <input type="radio" class="form-check-input" id="lcFemale" name="lcGender" value="Female">Female
                              </div>
                              <div class="form-check-inline">
                                <input type="radio" class="form-check-input" id="lcBoth" name="lcGender" value="Both">Both
                              </div>
                            </div>
                          </div>
                        </div>
                        <label>Add Value for leave</label>
                        <div class="input-group mb-3">
                          <input class="form-control form-control-sm" type="text" id="leaveValue" name="leaveValue" placeholder="" />
                          <div class="input-group-append">
                            <input type="hidden" id="actionLeaveSetup" name="actionLeaveSetup">
                            <input type="hidden" id="lyIdHidden" name="lyIdHidden" value="<?php echo $ly_id ?>">
                            <button class="btn btn-sm m-0 addLeaveSetup" type="submit">Submit</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-7">
                <div class="container card shadow d-flex justify-content-center mt-2">
                  <table class="table table-bordered table-striped list-table-sm mt-3" id="leaveSetupTable">
                    <th><i class="fas fa-edit"></i></th>
                    <th>Leave Type</th>
                    <th>Month</th>
                    <th>Number of Leaves</th>
                    <th>Gender</th>
                  </table>
                </div>
              </div>
            </div>
          </div>

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

          <div class="tab-pane fade" id="list-lf" role="tabpanel" aria-labelledby="list-lf-list">
            <div class="row">
              <div class="col-5">
                <div class="container card shadow d-flex justify-content-center mt-2" id="card_leave">
                  <!-- nav options -->
                  <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="pills_leaveForm" data-toggle="pill" href="#pills_form" role="tab" aria-controls="pills_form" aria-selected="true">Leave Form</a>
                    </li>
                  </ul> <!-- content -->
                  <div class="tab-content" id="pills-tabContent p-3">
                    <div class="tab-pane fade show active" id="pills_form" role="tabpanel" aria-labelledby="pills_leaveForm">
                      <form class="form-horizontal" id="leaveStaffForm">
                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label>FROM DATE </label>
                              <input type="date" class="form-control form-control-sm" id="leaveFromDate" name="leaveFromDate" placeholder="">
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label>TO DATE</label>
                              <input type="date" class="form-control form-control-sm" id="leaveToDate" name="leaveToDate" placeholder="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label>FROM TIME</label>
                              <input type="time" class="form-control form-control-sm" id="leaveFromTime" name="leaveFromTime" placeholder="">
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label>TO TIME</label>
                              <input type="time" class="form-control form-control-sm" id="leaveToTime" name="leaveToTime" placeholder="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group">
                              <label>Leave Type</label>
                              <?php
                              $sql_lt = "select * from leave_type";
                              $result = $conn->query($sql_lt);
                              if ($result) {
                                echo '<select class="form-control form-control-sm" name="leaveTypeStaff" id="leaveTypeStaff" required>';
                                echo '<option selected disabled>Select Leave Type</option>';
                                while ($rows = $result->fetch_assoc()) {
                                  $select_id = $rows['lt_id'];
                                  $select_name = $rows['lt_name'];
                                  echo '<option value="' . $select_id . '">' . $select_name . '</option>';
                                }
                                echo '</select>';
                              } else echo $conn->error;
                              if ($result->num_rows == 0) echo 'No Data Found';
                              ?>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group">
                              <label>Reason</label>
                              <textarea class="form-control" id="leaveReason" name="leaveReason" rows="3"></textarea>
                            </div>
                          </div>
                        </div>
                        <input type="hidden" id="actionLeaveForm" name="actionLeaveForm">
                        <button type="submit" class="btn btn-sm">Submit</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-7">
                <div class="container card shadow d-flex justify-content-center mt-2">
                  <h2 class="card-header-title mt-2">Leave Balance</h2>
                  <table class="table table-bordered table-striped list-table-sm mt-2" id="leaveBalanceTable">
                    <tr class="align-center">
                      <th>Leave Type </th>
                      <th>Credit</th>
                      <th>Debit</th>
                      <th>Balance</th>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="container card shadow d-flex justify-content-center mt-2 ml-0">
                  <h2 class="card-header-title mt-2">Leave Application Status</h2>
                  <table class="table table-bordered table-striped list-table-sm mt-2" id="leaveApplicationTable">
                    <tr class="align-center">
                      <th>ID</th>
                      <th>FROM</th>
                      <th>TO</th>
                      <th>LD</th>
                      <th>Leave Type</th>
                      <th>Apply Date</th>
                      <th>Apply Time</th>
                      <th>Load Status</th>
                      <th>Approval Status</th>
                      <th>Action</th>
                    </tr>
                  </table>
                </div>
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

          <div class="tab-pane fade" id="list-ccf" role="tabpanel" aria-labelledby="list-ccf-list">
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

          <div class="tab-pane fade" id="list-ss" role="tabpanel" aria-labelledby="list-ss-list">
            <div class="row">
              <div class="col-5">
                <div class="container card shadow d-flex justify-content-center mt-2" id="card_leave">
                  <!-- nav options -->
                  <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="pills_leaveForm" data-toggle="pill" href="#pills_form" role="tab" aria-controls="pills_form" aria-selected="true">Special Staff</a>
                    </li>
                  </ul> <!-- content -->
                  <div class="tab-content" id="pills-tabContent p-3">
                    <div class="tab-pane fade show active" id="pills_form" role="tabpanel" aria-labelledby="pills_leaveForm">
                      <form class="form-horizontal" id="specialStaffForm">
                        <div class="row">
                          <div class="col-12">
                            <div class="input-group md-form form-sm form-2 mt-1">
                              <input name="staffSearch" id="staffSearch" class="form-control form-control-sm" type="text" placeholder="Search Staff" aria-label="Search">
                              <div class="input-group-append">
                                <span class="input-group-text cyan lighten-3" id="basic-text1"><i class="fas fa-search text-grey" aria-hidden="true"></i></span>
                              </div>
                            </div>
                            <div class='list-group' id="staffAutoList"></div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label>Approver</label>
                              <input type="text" class="form-control form-control-sm" id="approverSearch" name="approver" placeholder="">
                            </div>
                            <div class='list-group' id="approverAutoList"></div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label>Forwarder</label>
                              <input type="text" class="form-control form-control-sm" id="forwarderSearch" name="forwarder" placeholder="">
                              <p class='list-group' id="forwarderAutoList"></p>
                            </div>
                          </div>
                        </div>
                        <input type="hidden" id="specialStaffIdHidden" name="specialStaffIdHidden">
                        <input type="hidden" id="approverIdHidden" name="approverIdHidden">
                        <input type="hidden" id="forwarderIdHidden" name="forwarderIdHidden">
                        <input type="hidden" id="actionSpecialStaffForm" name="actionSpecialStaffForm">
                        <button type="submit" class="btn btn-sm">Submit</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

<?php require("../js.php"); ?>

<script>
  $(document).ready(function() {

    leaveTypeList();
    leaveYearTable();
    //leaveApplicationStatusTable();
    //leaveSetupTable();
    $('#leaveYearTable').hide();

    $('#staffSearch').keyup(function() {
      var specialStaffquery = $(this).val();
      // alert(specialStaffquery);
      if (specialStaffquery != '') {
        $.ajax({
          url: "leaveSql.php",
          method: "POST",
          action: "specialStaff",
          data: {
            specialStaffquery: specialStaffquery,
          },
          success: function(data) {
            $('#staffAutoList').fadeIn();
            $('#staffAutoList').html(data);
          }
        });
      } else {
        $('#staffAutoList').fadeOut();
        $('#staffAutoList').html("");
      }
    });

    $('#approverSearch').keyup(function() {
      var approverQuery = $(this).val();
      // alert(query);
      if (approverQuery != '') {
        $.ajax({
          url: "leaveSql.php",
          method: "POST",
          search: "approver",
          data: {
            approverQuery: approverQuery,
          },
          success: function(data) {
            $('#approverAutoList').fadeIn();
            $('#approverAutoList').html(data);
          }
        });
      } else {
        $('#approverAutoList').fadeOut();
        $('#approverAutoList').html("");
      }
    });

    $('#forwarderSearch').keyup(function() {
      var forwarderQuery = $(this).val();
      // alert(query);
      if (forwarderQuery != '') {
        $.ajax({
          url: "leaveSql.php",
          method: "POST",
          search: "forwarder",
          data: {
            forwarderQuery: forwarderQuery,
          },
          success: function(data) {
            $('#forwarderAutoList').fadeIn();
            $('#forwarderAutoList').html(data);
          }
        });
      } else {
        $('#forwarderAutoList').fadeOut();
        $('#forwarderAutoList').html("");
      }
    });

    $(document).on('click', '.specialStaffAutoList', function() {
      $('#staffSearch').val($(this).text());
      var stfId = $(this).attr("data-std");
      $('#specialStaffIdHidden').val(stfId);
      $('#staffAutoList').fadeOut();
    });

    $(document).on('click', '.approverAutoList', function() {
      $('#approverSearch').val($(this).text());
      var stfId = $(this).attr("data-std");
      $('#approverIdHidden').val(stfId);
      $('#approverAutoList').fadeOut();
    });

    $(document).on('click', '.forwarderAutoList', function() {
      $('#forwarderSearch').val($(this).text());
      var stfId = $(this).attr("data-std");
      $('#forwarderIdHidden').val(stfId);
      $('#forwarderAutoList').fadeOut();
    });

    $(document).on('click', '.sr', function(event) {
      var lf = $("#leave_from").val();
      var lt = $("#leave_to").val();
      var deptId = $("#sel_dept").val();
      event.preventDefault(this);
      if (lt < lf) $.alert("From date (" + getFormattedDate(lf, "dmY") + ") greater than To Date (" + getFormattedDate(lt, "dmY") + ")");
      else leaveList(lf, lt, deptId);
    });

    //Leave Type Block
    $(document).on('click', '.lt', function() {
      $('#leaveYearTable').hide();
      $('#leaveTypeTable').show();
      $('#leaveDurationTable').hide();
    });

    $(document).on('submit', '#leaveTypeForm', function(event) {
      event.preventDefault(this);
      //$.alert("Form Submitted ");
      var formData = $(this).serialize();
      //$.alert(formData);
      $.post("leaveSql.php", formData, () => {}, "text").done(function(mydata, mystatus) {
        //$.alert("Updated Data" + mydata);
        leaveTypeList();
        $('#leaveTypeForm')[0].reset();
        $("#ltId").val("0")
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });
    $(document).on('click', '.editLeaveType', function() {
      var id = $(this).attr('data-id');
      // $.alert("Id " + id);
      $.post("leaveSql.php", {
        ltId: id,
        action: "fetchLeaveType"
      }, () => {}, "json").done(function(data) {
        console.log(data);
        $('#leave_name').val(data.lt_name);
        $('#leave_abbri').val(data.lt_abbri);
        $('#leave_max').val(data.lt_max);
        $('#leave_male').val(data.lt_male);
        $('#leave_female').val(data.lt_female);
        $('#leave_monthly').val(data.lt_monthly);
        var check = data.lt_check;
        var carry = data.lt_carry;
        if (carry == "1") $("#leave_carry").prop("checked", true);
        else $("#leave_carry").prop("checked", false);
        if (check == "1") $("#leave_check").prop("checked", true);
        else $("#leave_check").prop("checked", false);
        $('#ltId').val(id);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });
    $(document).on('blur', '.editable', function() {
      var id = $(this).attr("data-id");
      var field = $(this).attr("data-field");
      var cellText = $(this).html();
      $.alert("Edit  Clicked " + id + " text " + cellText + " Field " + field);
      $.post("leaveSql.php", {
        id: id,
        field: field,
        text: cellText,
        action: "updateLT"
      }, function(data, status) {}, "text").done(function(data, status) {
        $.alert("Updated " + data);
      })
    });

    function leaveTypeList() {
      $.post("leaveSql.php", {
        action: "leaveTypeList",
      }, () => {}, "json").done(function(data) {
        var ltt_name = '';
        $.each(data, function(key, value) {
          ltt_name += '<tr>';
          ltt_name += '<td><a href="#" class="fas fa-edit editLeaveType" data-id="' + value.lt_id + '"></a></td>';
          ltt_name += '<td>' + value.lt_name + '</td>';
          ltt_name += '<td>' + value.lt_abbri + '</td>';
          ltt_name += '<td>' + value.lt_male + '</td>';
          ltt_name += '<td>' + value.lt_female + '</td>';
          ltt_name += '<td>' + value.lt_monthly + '</td>';
          ltt_name += '<td>' + value.lt_check + '</td>';
          ltt_name += '<td>' + value.lt_carry + '</td>';
          ltt_name += '<td>' + value.lt_max + '</td>';
          ltt_name += '</tr>';
        });

        $("#leaveTypeTable").find("tr:gt(0)").remove();
        $("#leaveTypeTable").append(ltt_name);
      }).fail(function() {
        $.alert("Leave Type is not Responding");
      })
    }

    // Leave Year Block
    $(document).on('click', '#pills_leaveYear', function() {
      $('#leaveYearTable').show();
      $('#leaveTypeTable').hide();
      $('#leaveDurationTable').hide();
    });
    $(document).on('submit', '#leaveYearForm', function() {
      event.preventDefault(this);
      // $.alert('hello');
      $("#actionLeaveYear").val("addLeaveYear")
      var formData = $(this).serialize();
      // $.alert("Form Submitted " + formData)
      $.post("leaveSql.php", formData, function() {}, "text").done(function(data, success) {
        // $.alert(data)
        $("#leaveYearForm")[0].reset();
        leaveYearTable();
      })
    });
    $(document).on('click', '.editLeaveYear', function() {
      var id = $(this).attr('data-id');
      // $.alert("Id " + id);
      $.post("leaveSql.php", {
        lyId: id,
        action: "fetchLeaveYear"
      }, () => {}, "json").done(function(data) {
        console.log(data);
        $('#ly_from').val(data.ly_from);
        $('#ly_to').val(data.ly_to);
        $('#lyId').val(data.ly_id);
      }).fail(function() {
        $.alert("Could Not Fetch");
      })
    });

    function leaveYearTable() {
      // Leave Year Table
      $.post("leaveSql.php", {
        action: "leaveYearList",
      }, () => {}, "json").done(function(data) {
        var leave_year = '';
        $.each(data, function(key, value) {
          leave_year += '<tr>';
          leave_year += '<td><a href="#" class="fas fa-edit editLeaveYear" data-id="' + value.ly_id + '"></a></td>';
          leave_year += '<td>' + getFormattedDate(value.ly_from, "dmY") + '</td>';
          leave_year += '<td>' + getFormattedDate(value.ly_to, "dmY") + '</td>';
          leave_year += '<td><button type="button" class="btn btn-square-xs btn-primary currentLeaveYear" data-leaveYearButton="' + value.ly_id + '">Set Current</button></td>';
          leave_year += '</tr>';
        });
        $("#leaveYearTable").find("tr:gt(0)").remove();
        $("#leaveYearTable").append(leave_year);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    }

    $(document).on('click', '.currentLeaveYear', function() {
      var id = $(this).attr("data-leaveYearButton");
      $.alert('hello' + id);
      $.post("leaveSql.php", {
        id: id,
        action: "setCurrentLeaveYear"
      }, function(data) {}, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    // Leave Credit
    $(document).on('click', '.lc', function() {

    });

    //Compensatory
    $(document).on('click', '.ccfList', function() {
      $('#list-lt').hide();
      $('#list-ccf').show();
      $('#list-lf').hide();
      $('#list-lc').hide();
      $('#list-ss').hide();
      ccfList();
    });


    $(document).on('click', '.lf', function(event) {

    });

    $(document).on('click', '.ss', function(event) {});


    $(document).on('submit', '#specialStaffForm', function() {
      event.preventDefault(this);
      $("#actionSpecialStaffForm").val("specialStaff")
      var formData = $(this).serialize();
      // $.alert("Form Submitted " + formData)
      $.post("leaveSql.php", formData, function() {}, "text").done(function(data, success) {
        $.alert(data)
      })
    });


    $(document).on('submit', '#leaveStaffForm', function() {
      event.preventDefault(this);
      $.alert('hello');
      $("#actionLeaveForm").val("addStaffLeave")
      var formData = $(this).serialize();
      $.alert("Form Submitted " + formData)
      $.post("leaveSql.php", formData, function() {}, "text").done(function(data, success) {
        $.alert(data)
      })
    });

    $(document).on('click', '.editLeaveSetup', function() {
      var id = $(this).attr('data-leaveSetup');
      $.alert("Id " + id);
      $.post("leaveSql.php", {
        lsId: id,
        action: "fetchLeaveSetup"
      }, () => {}, "json").done(function(data) {
        console.log(data);
        $('#sel_month').val(data.ls_month);
        $('#lcGender').val(data.ls_gender);
        $('#leaveValue').val(data.ls_value);
        $('#sql_lt').val(data.lt_name);
        $('#lsId').val(id);
        leaveSetupTable()
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('submit', '#addLeaveSetup', function() {
      event.preventDefault(this);
      var sel_month = $('#sel_month').val()
      var lt = $('#sql_lt').val()
      $("#actionLeaveSetup").val("addLeaveSetup")
      var formData = $(this).serialize();
      // $.alert("Form Submitted " + formData)
      $.post("leaveSql.php", formData, function() {}, "text").done(function(data, success) {
        // $.alert(data)
        leaveSetupTable()
      })
    });

    $(document).on('click', '#pills_leaveType', function() {
      $('#leaveYearTable').hide();
      $('#leaveTypeTable').show();
      $('#leaveDurationTable').hide();
    });

    $(document).on('click', '#pills_leaveDuration', function() {
      $('#leaveYearTable').hide();
      $('#leaveTypeTable').hide();
      $('#leaveDurationTable').show();

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

    function leaveApplicationStatusTable() {
      //Leave Application Status Table
      $.post("leaveSql.php", {
        action: "leaveApplicationList",
      }, () => {}, "json").done(function(data) {
        var leave_application = '';
        $.each(data, function(key, value) {
          leave_application += '<tr>';
          leave_application += '<td>' + value.ll_id + '</td>';
          leave_application += '<td>' + getFormattedDate(value.leave_from, "dmY") + '</td>';
          leave_application += '<td>' + getFormattedDate(value.leave_to, "dmY") + '</td>';
          leave_application += '<td>' + +'</td>';
          leave_application += '<td>' + value.lt_name + '</td>';
          leave_application += '<td>' + getFormattedDate(value.submit_date, "dmY") + '</td>';
          leave_application += '<td>' + value.submit_time + '</td>';
          leave_application += '</tr>';
        });
        $("#leaveApplicationTable").append(leave_application);
      }, "json").fail(function() {
        $.alert("fail in place of error");
      })
    }

    function leaveSetupTable() {
      // Leave Setup table
      var lt_id = $(this).attr("data-leaveType");
      $.post("leaveSql.php", {
        action: "leaveSetupList",
        id: lt_id
      }, () => {}, "json").done(function(data) {
        var leave_setup = '';
        $.each(data, function(key, value) {
          leave_setup += '<tr>';
          leave_setup += '<td><a href="#" class="fas fa-edit editLeaveSetup" data-leaveSetup="' + value.ls_id + '"></a></td>';
          leave_setup += '<td>' + value.lt_name + '</td>';
          leave_setup += '<td>' + GetMonthName(value.ls_month) + '</td>';
          leave_setup += '<td>' + value.ls_value + '</td>';
          leave_setup += '<td>' + value.ls_gender + '</td>';
          leave_setup += '</tr>';
        });
        $("#leaveSetupTable").find("tr:gt(0)").remove()
        $("#leaveSetupTable").append(leave_setup);
      }, "json").fail(function() {
        $.alert("fail in place of error");
      })
    }

    function leaveDurationTable() {
      // Leave duration table
      $.post("leaveSql.php", {
        action: "leaveDurationList",
      }, () => {}, "json").done(function(data) {
        var leave_duration = '';
        $.each(data, function(key, value) {
          leave_duration += '<tr>'
          leave_duration += '<td><a href="#" class="fas fa-edit editLeaveDuration" data-leaveDuration="' + value.lt_id + '"></a></td>';
          leave_duration += '<td>' + value.ld_name + '</td>';
          leave_duration += '<td>' + value.ld_value + '</td>';
          leave_duration += '</tr>';
        });
        $("#leaveDurationTable").append(leave_duration);
      }, "json").fail(function() {
        $.alert("fail in place of error");
      })
    }

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
            deptId: deptId,
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

    function GetMonthName(monthNumber) {
      var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
      return months[monthNumber - 1];
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