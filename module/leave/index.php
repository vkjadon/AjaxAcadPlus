<?php
require('../requireSubModule.php');

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

<head>
  <title>Leave Module : ClassConnect</title>
  <?php require("../css.php"); ?>
</head>
<body>
  <?php require("../topBar.php"); ?>

  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-2 p-0 m-0 pl-2 full-height">
        <div class="mt-2">
          <h5>Leave</h5>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action lf" id="list-lf-list" data-toggle="list" href="#list-lf" role="tab" aria-controls="lf">Leave Form</a>
          <a class="list-group-item list-group-item-action lc" id="list-lc-list" data-toggle="list" href="#list-lc" role="tab" aria-controls="lc">Leave Credit</a>
          <a class="list-group-item list-group-item-action pl" id="list-pl-list" data-toggle="list" href="#list-pl" role="tab" aria-controls="pl">Process Leave</a>
          <a class="list-group-item list-group-item-action lr" id="list-lr-list" data-toggle="list" href="#list-lr" role="tab" aria-controls="lr">Leave Report</a>
          <a class="list-group-item list-group-item-action lt" id="list-lt-list" data-toggle="list" href="#list-lt" role="tab" aria-controls="lt">Master Data</a>
        </div>
        <div class="mr-2">
          <?php require("../searchBar.php"); ?>
        </div>
      </div>
      <div class="col-10 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane show active" id="list-lf" role="tabpanel" aria-labelledby="list-lf-list">
            <div class="row">
              <div class="col-5">
                <div class="container card mt-2 myCard">
                  <!-- nav options -->
                  <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="pills_leaveForm" data-toggle="pill" href="#pills_form" role="tab" aria-controls="pills_form" aria-selected="true">Leave Form</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="pills_leaveBalance" data-toggle="pill" href="#pills_balance" role="tab" aria-controls="pills_balance" aria-selected="true">Leave Balance</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link pills_cpl" data-toggle="pill" href="#pills_cpl" role="tab" aria-controls="pills_claim" aria-selected="true">CPL Claim</a>
                    </li>
                  </ul> <!-- content -->
                  <div class="tab-content" id="pills-tabContent p-3">
                    <div class="tab-pane fade show active" id="pills_form" role="tabpanel" aria-labelledby="pills_leaveForm">
                      <form class="form-horizontal" id="leaveStaffForm">
                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label>From </label>
                              <input type="datetime-local" class="form-control form-control-sm" id="leaveFrom" name="leaveFrom" value="<?php echo date("d-m-Y h:i:s", time()); ?>">
                            </div>
                          </div>

                          <div class="col-6">
                            <div class="form-group">
                              <label>To</label>
                              <input type="datetime-local" class="form-control form-control-sm" id="leaveTo" name="leaveTo" value="<?php echo date("d-m-Y h:i:s", time()); ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label>Leave Type</label>
                              <?php
                              $sql_lt = "select * from leave_type";
                              $result = $conn->query($sql_lt);
                              if ($result) {
                                echo '<select class="form-control form-control-sm" name="sel_lt" id="sel_lt" required>';
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
                          <div class="col-6">
                            <div class="form-group">
                              <label>Days</label>
                              <input type="number" class="form-control form-control-sm" id="leaveDays" name="leaveDays" step="0.25" value="1">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group">
                              <label>Reason</label>
                              <input type="text" class="form-control form-control-sm" id="leaveReason" name="leaveReason">
                            </div>
                          </div>
                        </div>
                        <input type="hidden" id="actionLeaveForm" name="action" value="addLeave">
                        <button type="submit" class="btn btn-sm">Submit</button>
                      </form>
                    </div>
                    <div class="tab-pane fade" id="pills_balance" role="tabpanel" aria-labelledby="pills_balance">
                      <div class="row">
                        <div class="col-12">
                          <table class="table table-striped list-table-xs mt-2" id="leaveBalanceTable">
                            <tr class="align-center">
                              <th>Leave Type </th>
                              <th>Credit</th>
                              <th>Debit</th>
                              <th>Balance</th>
                            </tr>
                          </table>
                          <a href="#" class="atag leaveCredit">Credit Details</a>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="pills_cpl" role="tabpanel" aria-labelledby="pills_cpl">
                      <form class="form-horizontal" id="cplForm">
                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label>CPL Date </label>
                              <input type="date" class="form-control form-control-sm" id="cplDate" name="cplDate" value="<?php echo $submit_date; ?>">
                            </div>
                          </div>

                          <div class="col-6">
                            <div class="form-group">
                              <label>Order Reference</label>
                              <input type="text" class="form-control form-control-sm" id="cplOrder" name="cplOrder" placeholder="Reference of Duty Order">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-12">
                            <div class="form-group">
                              <label>Reason</label>
                              <input type="text" class="form-control form-control-sm" id="cplReason" name="cplReason">
                            </div>
                          </div>
                        </div>
                        <input type="hidden" id="actionCPLForm" name="action" value="addCPL">
                        <button type="submit" class="btn btn-sm">Submit</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-7">
                <div class="container card shadow mt-2 mb-2 myCard">
                  <div class="card-title-xs leaveTableTitle" id="leaveTableTitle">Leave Application Status</div>
                </div>
                <div class="container card m-0 myCard">
                  <table class="table table-striped list-table-xs mt-2" id="leaveApplicationTable">
                    <tr class="align-center">
                      <th>Id</th>
                      <th>From</th>
                      <th>To</th>
                      <th>#</th>
                      <th>Type</th>
                      <th>Submit</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </table>
                  <table class="table table-bordered table-striped list-table-xs mt-3 leaveSetupTable">
                    <th><i class="fas fa-edit"></i></th>
                    <th>Leave Type</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Male</th>
                    <th>Female</th>
                  </table>

                  <table class="table table-bordered table-striped list-table-xs mt-3 cplTable">
                    <th><i class="fas fa-edit"></i></th>
                    <th>Claim Date</th>
                    <th>Order</th>
                    <th>Reason</th>
                    <th>Claimed On</th>
                    <th>Status</th>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-lc" role="tabpanel" aria-labelledby="list-lc-list">
            <div class="row">
              <div class="col-5">
                <div class="container card myCard mt-2">
                  <!-- nav options -->
                  <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="pills_leaveType" data-toggle="pill" href="#pills_type" role="tab" aria-controls="pills_type" aria-selected="true">Leave Credit</a>
                    </li>
                  </ul> <!-- content -->
                  <div class="tab-content" id="pills-tabContent p-3">
                    <div class="tab-pane fade show active" id="pills_type" role="tabpanel" aria-labelledby="pills_leaveType">
                      <form class="form-horizontal" id="addLeaveSetup">
                        <div class="row">
                          <?php
                          $months = array(" ", "January", "Feburary", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                          echo '<div class="col-6">';
                          echo '<div class="form-group">';
                          echo '<select class="form-control form-control-sm" name="sel_month" id="sel_month" required>';
                          echo '<option selected disabled>Select Month</option>';
                          for ($i = 1; $i < 13; $i++) echo '<option value="' . $i . '">' . $months[$i] . '</option>';
                          echo '</select>';
                          echo '</div>';
                          echo '</div>';
                          ?>
                          <?php
                          $sql_lt = "select * from leave_type where lt_status='0' order by lt_name";
                          $result = $conn->query($sql_lt);
                          echo '<div class="col-6">';
                          echo '<div class="form-group">';
                          if ($result) {
                            echo '<select class="form-control form-control-sm" name="sel_lt" id="sel_lt" required>';
                            echo '<option selected disabled>Select Leave Type</option>';
                            while ($rows = $result->fetch_assoc()) echo '<option value="' . $rows['lt_id'] . '">' . $rows['lt_name'] . '</option>';
                            echo '</select>';
                          } else echo $conn->error;
                          echo '</div></div>';
                          if ($result->num_rows == 0) echo 'No Data Found';
                          ?>
                        </div>
                        <div class="row">
                          <div class="col-4">
                            <div class="form-group">
                              <label>Year</label>
                              <input type="number" class="form-control form-control-sm" id="lsYear" name="lsYear" min="2020" value="<?php echo date("Y", time()); ?>">
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="form-group">
                              <label>Male</label>
                              <input type="number" class="form-control form-control-sm" id="lsMale" name="lsMale" value="0">
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="form-group">
                              <label>Female</label>
                              <input type="number" class="form-control form-control-sm" id="lsFemale" name="lsFemale" value="0">
                            </div>
                          </div>
                        </div>
                    </div>
                    <input type="hidden" id="lsId" name="lsId" value="0">
                    <input type="hidden" id="actionLeaveSetup" name="action" value="addLeaveSetup">
                    <button class="btn btn-sm m-0" type="submit">Submit</button>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-7">
                <div class="container card shadow mt-2 mb-2 myCard">
                  <label>Leave Credit</label>
                </div>
                <div class="container card shadow m-0 myCard">
                  <table class="table table-bordered table-striped list-table-xs mt-3 leaveSetupTable" id="leaveSetupTable">
                    <th><i class="fas fa-edit"></i></th>
                    <th>Leave Type</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Male</th>
                    <th>Female</th>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-pl" role="tabpanel" aria-labelledby="list-pl-list">
            <div class="row">
              <div class="col-sm-9 pr-1">
                <div class="container card mt-2 myCard">
                  <!-- nav options -->
                  <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="pill" href="#pills_leaveRequest" role="tab" aria-controls="pills_leaveRequest" aria-selected="true">Leave Request</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="pill" href="#pills_updateRequest" role="tab" aria-controls="pills_updateRequest" aria-selected="true">Update Request</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="pill" href="#pills_claimRequest" role="tab" aria-controls="pills_claimRequest" aria-selected="true">Claim Request</a>
                    </li>
                  </ul> <!-- content -->
                  <div class="tab-content" id="pills-tabContent p-3">
                    <div class="tab-pane fade show active" id="pills_leaveRequest" role="tabpanel" aria-labelledby="pills_leaveRequest">
                      <table class="table table-striped list-table-xs mt-2" id="leaveRequestTable">
                        <tr class="align-center">
                          <th>Id</th>
                          <th>Staff</th>
                          <th>UserId</th>
                          <th>From</th>
                          <th>To</th>
                          <th>#</th>
                          <th>Type</th>
                          <th>Submit</th>
                          <th>Remarks</th>
                          <th>Action</th>
                        </tr>
                      </table>
                    </div>
                    <div class="tab-pane fade" id="pills_updateRequest" role="tabpanel" aria-labelledby="pills_updateRequest">

                    </div>
                    <div class="tab-pane fade" id="pills_claimRequest" role="tabpanel" aria-labelledby="pills_claimRequest">
                      <table class="table table-striped list-table-xs mt-2" id="leaveClaimTable">
                        <tr class="align-center">
                          <th>Id</th>
                          <th>Staff</th>
                          <th>UserId</th>
                          <th>Worked On</th>
                          <th>Reference</th>
                          <th>Reason</th>
                          <th>Claimed On</th>
                          <th>Action</th>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3 pl-1">
                <div class="container card mt-2 mb-2 myCard">
                  <div class="card-title-xs lpTitle" id="lpTitle">Process Comments<div>
                    </div>
                    <div class="container card shadow m-0 myCard">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-lr" role="tabpanel" aria-labelledby="list-lr-list">
            <div class="row">
              <div class="col-4">
                <div class="container card myCard">
                  <div class="row">
                    <div class="col-5 pt-3 pr-0">
                      <div class="form-group">
                        <input type="date" class="form-control form-control-sm reportFormText" id="report_from" name="report_from" value="<?php echo date("Y-m-d", time()); ?>">
                      </div>
                    </div>
                    <div class="col-5 pt-3 pl-1 pr-1">
                      <div class="form-group">
                        <input type="date" class="form-control form-control-sm reportFormText" id="report_to" name="report_to" value="<?php echo date("Y-m-d", time()); ?>">
                      </div>
                    </div>
                    <div class="col-2 pt-3 pl-0">
                      <div class="form-group">
                        <input type="submit" class="btn btn-sm reportFormButton" name="submit" value="Show">
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="col-3 p-0">
                <div class="container card myCard">
                  <div class="row">
                    <div class="col-9 pt-3 pr-0">
                      <div class="form-group">
                        <input type="text" class="form-control form-control-sm reportFormText" id="staffReport" name="staffReport" placeholder="StaffId/UserId">
                      </div>
                    </div>

                    <div class="col-3 pt-3 pl-0">
                      <div class="form-group">
                        <input type="submit" class="btn btn-sm reportFormButton" name="submit" value="Show">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="container card myCard mt-2">
              <!-- nav options -->
              <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="pill" href="#pills_deptReport" role="tab" aria-controls="pills_deptReport" aria-selected="true">Department</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="pill" href="#pills_staffReport" role="tab" aria-controls="pills_staffReport" aria-selected="true">Staff</a>
                </li>
              </ul>
              <!-- content -->
              <div class="tab-content" id="pills-tabContent p-3">
                <div class="tab-pane fade show active" id="pills_deptReport" role="tabpanel" aria-labelledby="pills_deptReport">
                  <table class="table table-striped list-table-xs mt-2" id="leaveReportTable">
                    <tr class="align-center">
                      <th>Id</th>
                      <th>Name</th>
                      <th>UserId</th>
                      <th>Leave Type</th>
                      <th>From</th>
                      <th>To</th>
                      <th>Days</th>
                      <th>Submitted On</th>
                    </tr>
                  </table>
                </div>
                <div class="tab-pane fade" id="pills_staffReport" role="tabpanel" aria-labelledby="pills_staffReport">
                  <div class="row">
                    <div class="col-12">
                      <div class="input-group md-form form-sm form-2 mt-1">

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-lt" role="tabpanel" aria-labelledby="list-lt-list">
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
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="pill" href="#pills_ss" role="tab" aria-controls="pills_ss" aria-selected="true">Special Staff</a>
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
                    <div class="tab-pane fade" id="pills_ss" role="tabpanel" aria-labelledby="pills_ss">
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
          <div class="tab-pane fade" id="list-ss" role="tabpanel" aria-labelledby="list-ss-list">
            <div class="row">
              <div class="col-5">
                <div class="container card shadow d-flex justify-content-center mt-2" id="card_leave">
                  <!-- nav options -->
                  <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">

                  </ul> <!-- content -->
                  <div class="tab-content" id="pills-tabContent p-3">

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
  <?php require("../bottom_bar.php"); ?>
  </div>
</body>

<?php require("../js.php"); ?>

<script>
  $(document).ready(function() {
    lrStatusTextClass = ["", "", "under-process", "under-process", "under-process", "approved", "", "rejected", "warning", "warning"];
    lrStatusText = ["Saved", "Submitted", "Comments", "Comments Received", "Forwarded", "Approved", "", "Rejected(F)", "Rejected(A)", "Withdrawn"];

    leaveTypeList();
    leaveSetupTable();
    leaveApplicationTable();
    cplTable();
    leaveRequestList();
    leaveClaimList();
    $('.leaveSetupTable').hide();
    $('.cplTable').hide();

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
    $(document).on('click', '#pills_leaveType', function() {
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
      leaveYearTable();
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

    // Leave Duration
    $(document).on('click', '#pills_leaveDuration', function() {
      $('#leaveYearTable').hide();
      $('#leaveTypeTable').hide();
      $('#leaveDurationTable').show();
    });

    //Special Staff
    $(document).on('submit', '#specialStaffForm', function() {
      event.preventDefault(this);
      $("#actionSpecialStaffForm").val("specialStaff")
      var formData = $(this).serialize();
      // $.alert("Form Submitted " + formData)
      $.post("leaveSql.php", formData, function() {}, "text").done(function(data, success) {
        $.alert(data)
      })
    });

    // Leave Credit
    $(document).on('submit', '#addLeaveSetup', function() {
      event.preventDefault(this);
      if ($("#sel_month").val() === null) $.alert("Month Required !!");
      else if ($("#sel_lt").val() === null) $.alert(" Leave Type Required !!");
      else {
        var formData = $(this).serialize();
        $.alert("Form Submitted " + formData)
        $.post("leaveSql.php", formData, function() {}, "text").done(function(data, success) {
          //$.alert(data)
          $("#addLeaveSetup")[0].reset();
          leaveSetupTable()
        })
      }
    });
    $(document).on('click', '.editLeaveSetup', function() {
      var id = $(this).attr('data-leaveSetup');
      $.alert("Id " + id);
      $.post("leaveSql.php", {
        lsId: id,
        action: "fetchLeaveSetup"
      }, () => {}, "json").done(function(data) {
        $('#sel_month').val(data.ls_month);
        $('#sel_lt').val(data.lt_id);
        $('#lsYear').val(data.ls_year);
        $('#lsMale').val(data.ls_male);
        $('#lsFemale').val(data.ls_female);
        $('#lsId').val(id);
      }).fail(function() {
        $.alert("Leave Credit Not Fetched ");
      })
    });

    function leaveSetupTable() {
      $(".leaveTableTitle").text("Leave Credit Record");
      $.post("leaveSql.php", {
        action: "leaveSetupList"
      }, () => {}, "json").done(function(data) {
        var leave_setup = '';
        $.each(data, function(key, value) {
          leave_setup += '<tr>';
          leave_setup += '<td><a href="#" class="fas fa-edit editLeaveSetup" data-leaveSetup="' + value.ls_id + '"></a></td>';
          leave_setup += '<td>' + value.lt_name + '</td>';
          leave_setup += '<td>' + GetMonthName(value.ls_month) + '</td>';
          leave_setup += '<td>' + value.ls_year + '</td>';
          leave_setup += '<td>' + value.ls_male + '</td>';
          leave_setup += '<td>' + value.ls_female + '</td>';
          leave_setup += '</tr>';
        });
        $(".leaveSetupTable").find("tr:gt(0)").remove()
        $(".leaveSetupTable").append(leave_setup);
      }, "json").fail(function() {
        $.alert("fail in place of error");
      })
    }

    // Leave Application Form
    $(document).on('click', '.lf, #pills_leaveForm', function() {
      // $.alert("Leave Form Clicked")
      $(".leaveTableTitle").text("Leave Application Status");
      $("#leaveApplicationTable").show();
      leaveBalanceList()
      $(".leaveSetupTable").hide();
      $(".cplTable").hide();
    });
    $(document).on('click', '.leaveCredit, .lc', function() {
      $(".leaveTableTitle").text("Leave Credit Record");
      $(".leaveSetupTable").show();
      $("#leaveApplicationTable").hide();
      $(".cplTable").hide();
    });
    $(document).on('submit', '#leaveStaffForm', function() {
      event.preventDefault(this);
      var formData = $(this).serialize();
      $.alert("Form Submitted " + formData)
      $.post("leaveSql.php", formData, function() {}, "text").done(function(data, success) {
        // $.alert(data)
        leaveApplicationTable()
        $("#leaveStaffForm")[0].reset();
      })
    });
    $(document).on('click', '.pills_cpl', function() {
      // $.alert("CPL Claim  Clicked")
      $(".leaveTableTitle").text("CPL Claim Status");
      $("#leaveApplicationTable").hide();
      $(".leaveSetupTable").hide();
      $(".cplTable").show();
    });
    $(document).on('submit', '#cplForm', function() {
      event.preventDefault(this);
      var formData = $(this).serialize();
      $.alert("CPL Form Submitted " + formData)
      $.post("leaveSql.php", formData, function() {}, "text").done(function(data, success) {
        // $.alert(data)
        cplTable();
        $("#leaveStaffForm")[0].reset();
      })
    });

    function leaveApplicationTable() {
      $.post("leaveSql.php", {
        action: "leaveApplicationList",
      }, () => {}, "json").done(function(data) {
        //$.alert("sds");
        var table = '';
        $.each(data, function(key, value) {
          var status = value.ll_status;
          table += '<tr>';
          table += '<td>' + value.ll_id + '</td>';
          table += '<td>' + getFormattedDate(value.ll_from, "dmY") + '<br>[';
          table += getTime(value.ll_from, "dmY") + ']</td>';
          table += '<td>' + getFormattedDate(value.ll_to, "dmY") + '<br>[';
          table += getTime(value.ll_to, "dmY") + ']</td>';
          table += '<td>' + value.ll_days + '</td>';
          table += '<td>' + value.lt_name + '</td>';
          table += '<td>' + getFormattedDate(value.update_ts, "dmY") + '</td>';
          table += '<td class="' + lrStatusTextClass[status] + '">' + lrStatusText[status] + '</td>';
          if (status < "2") table += '<td><button type="button" class="btn btn-sm  btn-block ulrButton" data-llId="' + value.ll_id + '">Withdraw</button></td>';
          else if (status == "5") table += '<td><button type="button" class="btn btn-sm btn-block btn-approve ulrButton" data-llId="' + value.ll_id + '">Update</button></td>';
          else table += '<td><label>--</label></td>';
          table += '</tr>';
        });
        $("#leaveApplicationTable").find("tr:gt(0)").remove()
        $("#leaveApplicationTable").append(table);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    }

    function leaveBalanceList() {
      // $.alert("Leave Balane");
      $.post("leaveSql.php", {
        action: "leaveBalance",
      }, () => {}, "text").done(function(data, status) {
        const myObj = JSON.parse(data);
        var lbList = '';
        $.each(myObj, function(key, value) {
          lbList += '<tr>';
          lbList += '<td>' + value.lt_name + '</td>';
          lbList += '<td>' + value.ls_male + '</td>';
          lbList += '<td>--</td>';
          lbList += '<td>--</td>';
          lbList += '</tr>';

        })
        $("#leaveBalanceTable").find("tr:gt(0)").remove()
        $("#leaveBalanceTable").append(lbList);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    }

    function cplTable() {
      $.post("leaveSql.php", {
        action: "cplList",
      }, () => {}, "json").done(function(data) {
        // $.alert("sds");
        var cpl = '';
        $.each(data, function(key, value) {
          cpl += '<tr>';
          cpl += '<td>' + value.lc_id + '</td>';
          cpl += '<td>' + getFormattedDate(value.lc_date, "dmY") + '</td>';
          cpl += '<td>' + value.lc_order + '</td>';
          cpl += '<td>' + value.lc_reason + '</td>';
          cpl += '<td>' + getFormattedDate(value.update_ts, "dmY") + '[';
          cpl += getTime(value.update_ts, "dmY") + ']</td>';
          cpl += '<td>' + value.lc_status + '</td>';
          cpl += '</tr>';
        });
        $(".cplTable").find("tr:gt(0)").remove()
        $(".cplTable").append(cpl);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    }

    // Leave Process
    $(document).on('click', '.prButton', function() {
      var id = $(this).attr('data-llId');
      //$.alert("llId " + id);
      $.post("leaveSql.php", {
        ll_id: id,
        action: "lrDetails"
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.staff_name);

        lr_name = data.staff_name;
        lr_user = data.user_id;
        lr_from_date = getFormattedDate(data.ll_from, "dmY");
        lr_from_time = getTime(data.ll_from);
        lr_to_date = getFormattedDate(data.ll_to, "dmY");
        lr_to_time = getTime(data.ll_to);
        $('#lr_staff').html("<label>" + lr_name + "</label>");
        $('#lr_user').html(lr_user);

        $('#lr_from_date').html(lr_from_date);
        $('#lr_from_time').html(lr_from_time);
        $('#lr_to_date').html(lr_to_date);
        $('#lr_to_time').html(lr_to_time);

        lr_status = data.ll_status;

        lr_reason = data.ll_reason;
        $('#lr_reason').html(lr_reason);
        $('#actionModal').val("llStatusUpdate");
        $('#llModalId').val(id);

        if (lr_status < 4) {
          $('#lrApproved').val("4");
          $('#lrRejected').val("7");
        } else if (lr_status == 4) {
          $('#lrApproved').val("5");
          $('#lrRejected').val("8");
        }
        $('#firstModal').modal('show');
        //$("#ccform").html(mydata);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });
    $(document).on('submit', '#modalForm', function(event) {
      event.preventDefault(this);
      var formData = $(this).serialize();
      $('#firstModal').modal('hide');
      $.alert("Pressed" + formData);

      $.post("leaveSql.php", formData, () => {}, "text").done(function(data, status) {
        //$.alert("List " + data);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    function leaveRequestList() {
      $.post("leaveSql.php", {
        action: "leaveApplicationList",
      }, () => {}, "json").done(function(data) {
        //$.alert("sds");
        var table = '';
        $.each(data, function(key, value) {
          var status = value.ll_status;
          if (status < 5) {
            table += '<tr>';
            table += '<td>' + value.ll_id + '</td>';
            table += '<td>' + value.staff_name + '</td>';
            table += '<td>' + value.user_id + '</td>';
            table += '<td>' + getFormattedDate(value.ll_from, "dmY") + '<br>[';
            table += getTime(value.ll_from, "dmY") + ']</td>';
            table += '<td>' + getFormattedDate(value.ll_to, "dmY") + '<br>[';
            table += getTime(value.ll_to, "dmY") + ']</td>';
            table += '<td>' + value.ll_days + '</td>';
            table += '<td>' + value.lt_name + '</td>';
            table += '<td>' + getFormattedDate(value.update_ts, "dmY") + '</td>';
            table += '<td>' + value.ll_reason + '</td>';
            if (status < "4") table += '<td><button type="button" class="btn btn-sm prButton" data-llId="' + value.ll_id + '">Forward</button></td>';
            else if (status == "4") table += '<td><button type="button" class="btn btn-sm btn-approve prButton" data-llId="' + value.ll_id + '">Approve</button></td>';
            else table += '<td><label>Approved</label></td>';
            table += '</tr>';
          }
        });
        $("#leaveRequestTable").find("tr:gt(0)").remove()
        $("#leaveRequestTable").append(table);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    }

    function leaveClaimList() {
      $.post("leaveSql.php", {
        action: "cplList",
      }, () => {}, "json").done(function(data) {
        //$.alert("Leave Claim List");
        var table = '';
        $.each(data, function(key, value) {
          var status = value.lc_status;
          if (status < 5) {
            table += '<tr>';
            table += '<td>' + value.lc_id + '</td>';
            table += '<td>' + value.staff_name + '</td>';
            table += '<td>' + value.user_id + '</td>';
            table += '<td>' + getFormattedDate(value.lc_date, "dmY") + '</td>';
            table += '<td>' + value.lc_order + '</td>';
            table += '<td>' + value.lc_reason + '</td>';
            table += '<td>' + getFormattedDate(value.update_ts, "dmY") + '</td>';
            if (status < "4") table += '<td><button type="button" class="btn btn-sm lcButton" data-lcId="' + value.lc_id + '">Forward</button></td>';
            else if (status == "4") table += '<td><button type="button" class="btn btn-sm btn-approve lcButton" data-lcId="' + value.lc_id + '">Approve</button></td>';
            else table += '<td><label>Approved</label></td>';
            table += '</tr>';
          }
        });
        $("#leaveClaimTable").find("tr:gt(0)").remove()
        $("#leaveClaimTable").append(table);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    }

    // Leave Report
    $(document).on("click", ".lr", function() {
      //$.alert("Leave Report");
      leaveReportList();
    });

    $(document).on("submit", "#leaveReportForm", function() {
      event.preventDefault(this);
      //$.alert("Leave Report");
    });

    function leaveReportList() {
      $.post("leaveSql.php", {
        action: "leaveApplicationList",
      }, () => {}, "json").done(function(data) {
        //$.alert("sds");
        var table = '';
        $.each(data, function(key, value) {
          var status = value.ll_status;
          if (status == 5) {
            table += '<tr>';
            table += '<td>' + value.ll_id + '</td>';
            table += '<td>' + value.staff_name + '</td>';
            table += '<td>' + value.user_id + '</td>';
            table += '<td>' + value.lt_name + '</td>';
            table += '<td>' + getFormattedDate(value.ll_from, "dmY") + '<br>[';
            table += getTime(value.ll_from, "dmY") + ']</td>';
            table += '<td>' + getFormattedDate(value.ll_to, "dmY") + '<br>[';
            table += getTime(value.ll_to, "dmY") + ']</td>';
            table += '<td>' + value.ll_days + '</td>';
            table += '<td>' + getFormattedDate(value.update_ts, "dmY") + '</td>';
            table += '</tr>';
          }
        });
        $("#leaveReportTable").find("tr:gt(0)").remove()
        $("#leaveReportTable").append(table);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    }

    $(document).on('click', '.deleteLeave', function() {
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

    function getTime(ts) {
      var a = new Date(ts);
      var time = a.getHours() + ':' + a.getMinutes();
      return time;
    }

    function GetMonthName(monthNumber) {
      var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
      return months[monthNumber - 1];
    }

  });
</script>

<!-- Modal Section-->
<div class="modal" id="firstModal">
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" id="modalForm">
      <div class="modal-content">
        <!-- Modal body -->
        <div class="lrModalForm">
          <div class="card myCard ml-3 mr-3 mt-3 mb-1">
            <div class="card-title-xs">Leave Data</div>
            <div class="row topBarText mb-2">
              <div class="col ml-2">
                <div id="lr_staff"></div>
                <div id="lr_user"></div>
              </div>
              <div class="col-sm-3">
                <div id="lr_from_date"></div>
                <div id="lr_from_time"></div>
              </div>
              <div class="col-1 mt-2">
                <label> To </label>
              </div>
              <div class="col-sm-3">
                <div id="lr_to_date"></div>
                <div id="lr_to_time"></div>
              </div>
            </div>
          </div>
          <div class="card myCard ml-3 mr-3 mt-3 mt-0">
            <div class="card-title-xs">Process Status</div>
            <div class="row">
              <div class="col-sm-3 text-center">
                <div class="topBarText">Load</div>
                <h2><i class="fa fa-times-circle"></i></h2>
              </div>
              <div class="col-sm-3 text-center">
                <div class=" topBarText">Forwarded</div>
                <h2><i class="fa fa-times-circle"></i></h2>
              </div>
              <div class="col-sm-3 text-center">
                <div class=" topBarText">Additional</div>
                <h2><i class="fa fa-times-circle"></i></h2>
              </div>
              <div class="col-sm-3 text-center">
                <div class=" topBarText">Approved</div>
                <h2><i class="fa fa-times-circle"></i></h2>
              </div>
            </div>
          </div>
          <div class="card myCard ml-3 mr-3 mt-3 mt-0">
            <div class="card-title-xs">Comments</div>
            <div class="row">
              <div class="col-sm-12 m-2" id="lr_reason"></div>
            </div>
          </div>
          <div class="card myCard m-3">
            <div class="card-title-xs" id="remarks">You Action..</div>
            <div class="form-group m-2">
              <input class="form-control form-control-sm" id="comments" name="comments" placeholder="Enter your Comments" required>
            </div>
            <div class="form-group m-2">
              <div class="form-check-inline">
                <label class="form-check-label">
                  <input type="radio" class="form-check-input" id="lrApproved" checked name="llStatus">Approve/Forward
                </label>
              </div>
              <div class="form-check-inline">
                <label class="form-check-label">
                  <input type="radio" class="form-check-input" id="lrRejected" name="llStatus">Reject
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="card myCard">
          <div class="row">
            <input type="hidden" id="actionModal" name="action">
            <input type="hidden" id="llModalId" name="modalId">
            <div class="col">
              <button class="btn btn-sm btn-approve" data-dismiss="modal">Close</button>
              <button class="btn btn-sm" id="submitModalForm">Submit</button>
            </div>
          </div>
        </div>
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

</html>