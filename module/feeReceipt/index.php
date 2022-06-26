<?php
require('../requireSubModule.php');
$phpFile = "feeReceiptSql.php";
addActivity($conn, $myId, "Fee Receipt", $submit_ts);
$instituteName = getField($conn, "1", "institution", "inst_id", "inst_name");
$instituteAddress = getField($conn, "1", "institution", "inst_id", "inst_address");
$instituteAddress = getField($conn, "1", "institution", "inst_id", "inst_address");
$instituteCity = getField($conn, "1", "institution", "inst_id", "inst_city");
$institutePincode = getField($conn, "1", "institution", "inst_id", "inst_pincode");
$institutePhone1 = getField($conn, "1", "institution", "inst_id", "inst_phone_1");
$institutePhone2 = getField($conn, "1", "institution", "inst_id", "inst_phone_2");

// Block added on June 19, 2022 - To be deleted 
// This updated the school_id in Fee Receipts 

// $sql = "select fr_id, student_id from fee_receipt";
// $result = $conn->query($sql);
// while ($rowsFee = $result->fetch_assoc()) {
//   $fr_id = $rowsFee["fr_id"];
//   $program_id = getField($conn, $rowsFee["student_id"], "student", "student_id", "program_id");
//   $dept_id = getField($conn, $program_id, "dept_program", "program_id", "dept_id");
//   if (isset($dept_id)) $school_id = getField($conn, $dept_id, "school_dept", "dept_id", "school_id");
//   else $school_id = "";
//   $sql_update = "update fee_receipt set school_id='$school_id' where fr_id='$fr_id'";
//   $conn->query($sql_update);
// }
// Block Ended June, 19, 2022

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Outcome Based Education : ClassConnect</title>
  <?php require("../css.php"); ?>
</head>

<body>
  <?php require("../topBar.php");
  if ($myId > 3) {
    if (!isset($_GET['tag'])) die("Illegal Attempt !! The token is Missing");
    elseif (!in_array($_GET['tag'], $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
    elseif (!in_array("5", $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
  }
  ?>
  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-1 p-0 m-0 full-height">
        <div class="mt-3">
          <h5 class=" text-center pr-2"> Receipt </h5>
        </div>
        <div class="list-group list-group-mine active mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active fr" id="list-fr-list" data-toggle="list" href="#list-fr" role="tab" aria-controls="fr"> Fee Receipt</a>
          <a class="list-group-item list-group-item-action trans" id="list-trans-list" data-toggle="list" href="#list-trans" role="tab" aria-controls="trans"> Transactions </a>
        </div>
      </div>
      <div class="col-11 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <div class="row">
            <div class="col-md-2 pr-0">
              <div class="card border-info">
                <div class="card-body text-primary">
                  <div class="row">
                    <div class="col-12 pl-0 pr-0">
                      <select class="form-control form-control-sm" id="sel_school" name="sel_school">
                        <option value="0">Select School/Institution</option>
                        <?php
                        $sql = "select * from school s where school_status='0' order by school_abbri";
                        $result = $conn->query($sql);
                        while ($rows = $result->fetch_assoc()) {
                          echo '<option value="' . $rows["school_id"] . '">' . $rows["school_abbri"] . '-' . $rows["school_name"] . '</option>';
                        }
                        ?>
                        <option value="ALL">ALL</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-2 pl-1 pr-0">
              <div class="card border-info">
                <div class="card-body pl-1 pr-1">
                  <input name="studentNameSearch" id="studentNameSearch" class="form-control form-control-sm" type="text" placeholder="Search Student" aria-label="Search">
                  <div class='list-group' id="studentAutoList"></div>
                </div>
              </div>
            </div>
            <div class="col-md-2 pl-1 pr-0">
              <div class="card border-info">
                <div class="card-body pl-1 pr-1">
                  <div class="row">
                    <div class="col-9 pr-0">
                      <input name="studentSearch" id="studentSearch" class="form-control form-control-sm" type="text" placeholder="Search User" aria-label="Search">
                    </div>
                    <div class="col-3 pl-1">
                      <button type="button" class="btn btn-block btn-sm" id="searchStudent"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-2 pl-1 pr-0">
              <div class="card border-info">
                <div class="card-body pl-1 pr-1">
                  <div class="row">
                    <div class="col-9 pr-0">
                      <input type="text" class="form-control form-control-sm" id="frId" name="frId" placeholder="Fee Receipt Number" aria-label="frId">
                    </div>
                    <div class="col-3 pl-1">
                      <button type="button" class="btn btn-block btn-sm" id="searchReceipt"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-2 pl-1 pr-0">
              <div class="card border-info">
                <div class="card-body text-primary pl-1 pr-1">
                  <input type="date" class="form-control form-control-sm" id="fr_from" name="fr_from" value="<?php echo $submit_date; ?>" title="From Date">
                </div>
              </div>
            </div>
            <div class="col-md-2 pl-1">
              <div class="card border-info">
                <div class="card-body text-primary pl-1 pr-1">
                  <input type="date" class="form-control form-control-sm" id="fr_to" name="fr_to" value="<?php echo $submit_date; ?>" title="To Date">
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-1">
            <div class="col-md-12 student_detail">
              <div class="card myCard border-info">
                <div class="row p-1">
                  <div class="col-2 studentImage">
                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="30%">
                  </div>
                  <div class="col-10 smallerText">
                    <div class="row mt-1 p-0">
                      <div class="col-3 m-0 p-0 student_name">Not Found</div>
                      <div class="col-3 p-0"> RNo : <span class="student_rollno">--</span></div>
                      <div class="col-3 p-0 ">Id : <span class="student_id">--</span></div>
                      <div class="col-3 p-0 user_id">UID : <span class="user_id">--</span></div>
                    </div>
                    <div class="row p-0">
                      <div class="col-3 p-0 student_fname">--</div>
                      <div class="col-3 p-0">Adm : <span class="student_batch">--</span></div>
                      <div class="col-3 p-0">Acad: <span class="student_ay">--</span></div>
                      <div class="col-3 p-0 ">FeeCat: <span class="student_fcg">--</span></div>
                    </div>
                    <div class="row p-0">
                      <div class="col-3 p-0 student_program">--</div>
                      <div class="col-3 p-0 current_semester">--</div>
                      <div class="col-3 p-0 current_class">--</div>
                      <div class="col-3 p-0"><span class="student_mobile">--</span><i class="fa fa-phone"></i></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane show active" id="list-fr" role="tabpanel" aria-labelledby="list-fr-list">
            <div class="row">
              <div class="col-12">
                <div class="card mt-2 p-3 myCard">
                  <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="pill" href="#feeTrans" role="tab" aria-controls="feeTrans" aria-selected="true">Fee Transaction</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link feeRecord" data-toggle="pill" href="#feeRecord" role="tab" aria-controls="feeRecord" aria-selected="true">Fee Record</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="pill" href="#feeReceipt" role="tab" aria-controls="feeReceipt" aria-selected="true">Fee Receipt</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="pills-tabContent p-3">
                    <div class="tab-pane show active" id="feeTrans" role="tabpanel" aria-labelledby="feeTrans">
                      <input type="hidden" id="studentIdHidden" name="studentIdHidden">
                      <div class="row">
                        <div class="col-9">
                          <div class="row">
                            <div class="col-3 pr-0">
                              <div class="form-group">
                                <label>Type</label>
                                <p id="feeType"></p>
                              </div>
                            </div>
                            <div class="col-3 pl-1 pr-0">
                              <div class="form-group">
                                <label>Mode</label>
                                <p class="feeMode"></p>
                              </div>
                            </div>
                            <div class="col-1 pl-1 pr-0">
                              <div class="form-group">
                                <label>Semester</label>
                                <input type="number" class="form-control form-control-sm" id="semester" min="1" name="semester" placeholder="Semester" value="1">
                              </div>
                            </div>
                            <div class="col-2 pl-1 pr-0">
                              <div class="form-group">
                                <label>Old Receipt No</label>
                                <input type="number" class="form-control form-control-sm" id="fr_sno" name="fr_sno" placeholder="" data-tag="fr_sno">
                              </div>
                            </div>
                            <div class="col-3 pl-1">
                              <div class="form-group" id="cash">
                                <label>Receipt Date</label>
                                <input type="date" class="form-control form-control-sm" id="fr_date" name="fr_date" value=<?php echo $submit_date; ?>>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-3 pr-0">
                              <div class="form-group">
                                <label>Bank Name</label>
                                <input type="text" class="form-control form-control-sm" id="fr_bank" name="fr_bank" placeholder="Bank Name">
                              </div>
                            </div>
                            <div class="col-3 pl-1 pr-0">
                              <div class="form-group">
                                <label>Amount</label>
                                <input type="number" class="form-control form-control-sm" id="feeAmount" name="feeAmount" placeholder="" data-tag="fr_amount">
                              </div>
                            </div>
                            <div class="col-3 pr-0 pl-1">
                              <div class="form-group">
                                <label>Transaction ID</label>
                                <input type="text" class="form-control form-control-sm" id="tId" name="tId" placeholder="Transaction ID" data-tag="transaction_id">
                              </div>
                            </div>
                            <div class="col-3 pl-1">
                              <div class="form-group">
                                <label>Transaction Date</label>
                                <input type="date" class="form-control form-control-sm" id="transaction_date" name="transaction_date" value=<?php echo $submit_date; ?> data-tag="transaction_date">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control form-control-sm" id="fee_desc" name="fee_desc" rows="5"></textarea>
                          </div>
                        </div>
                      </div>
                      <input type="hidden" id="action" name="action" value="addFeeReceipt">
                      <button class="btn btn-sm" id="addFeeReceipt">Accept Transaction</button>
                    </div>
                    <div class="tab-pane fade" id="feeRecord" role="tabpanel" aria-labelledby="feeRecord">
                      <div class="row">
                        <div class="col-md-12 mt-5 text-right">
                          <a class="fas fa-file-export" id="frExport"></a>
                        </div>
                        <div class="col-12">
                          <h4>Debit/Concession Record</h4>
                          <table class="table table-bordered table-striped list-table-xs mt-3" id="feeDebitList">
                            <th class="text-center">Id</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Semester</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Fee Type</th>
                            <th class="text-center">Mode</th>
                            <th class="text-center">Debit</th>
                            <th class="text-center">Credit</th>
                            <th class="text-center">Staff</th>
                            <th class="text-center"><i class="fa fa-eye"></i></th>
                          </table>
                          <h4>Credit Record</h4>
                          <table class="table table-bordered table-striped list-table-xs mt-3" id="feeReceiptList">
                            <th class="text-center">Id</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Semester</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Fee Type</th>
                            <th class="text-center">Mode</th>
                            <th class="text-center">Debit</th>
                            <th class="text-center">Credit</th>
                            <th class="text-center">StaffId</th>
                            <th class="text-center"><i class="fa fa-eye"></i></th>
                          </table>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <h5>Total Debit <input type="text" id="totalDebit" disabled></h5>
                        </div>
                        <div class="col-md-4">
                          <h5>Total Credit <input type="text" id="totalCredit" disabled></h5>
                        </div>
                        <div class="col-md-4">
                          <h5>Total Balance <input type="text" id="totalBalance" disabled></h5>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <table class="table table-bordered table-striped list-table-xs mt-3" id="feeRecordList">
                            <th class="text-center">Id</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Semester</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Fee Type</th>
                            <th class="text-center">Mode</th>
                            <th class="text-center">Debit</th>
                            <th class="text-center">Credit</th>
                            <th class="text-center">Balance</th>
                            <th class="text-center">StaffId</th>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="feeReceipt" role="tabpanel" aria-labelledby="feeReceipt">
                      <div class="row">
                        <div class="col-1"></div>
                        <div class="col-md-7">
                          <div class=" float-right">
                            <a onclick="printDiv('page1')" class="fa fa-print"></a>
                          </div>
                        </div>
                      </div>
                      <div class="row mt-3" id="page1">
                        <div class="col-1"></div>
                        <div class="col-11">
                          <table border="1" width="100%">
                            <tr>
                              <td class="text-center" colspan="3">
                                <div class="row m-3">
                                  <div class="col-1 p-2"><img src="<?php echo $setLogo; ?>" width="70%"></div>
                                  <div class="col-10">
                                    <span class="xxlText"><?php echo $instituteName; ?> </span>
                                    <p class="largeText"><?php echo $instituteAddress; ?>, <?php echo $instituteCity; ?> [<?php echo $institutePincode; ?>] </p>
                                    <p class="largeText"><?php echo $setUrl; ?> | <?php echo $institutePhone1; ?>, <?php echo $institutePhone2; ?> </p>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3">
                                <div class="row">
                                  <div class="col-md-6">
                                    <span class="footNote">Institute </span> : <span class="footNote schoolName"></span>
                                  </div>
                                  <div class="col-md-6 text-right">
                                    <span class="footNote">Department </span> : <span class="footNote deptName"></span>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3">
                                <div class="row m-2">
                                  <div class="col-12 text-center">
                                    <h4 class="largeText" style="text-decoration: underline;">Fee Receipt</h4>
                                  </div>
                                </div>
                                <div class="row m-2">
                                  <div class="col-3">
                                    <span class="largeText">Receipt Number : </span>
                                  </div>
                                  <div class="col-4">
                                    <span class="largeText" id="receiptNumber"></span>
                                    [<span class="largeText" id="frSno">--</span>]
                                  </div>
                                  <div class="col-5">
                                    <span class="largeText">Date : </span><span class="largeText" id="receiptDate"></span>
                                  </div>
                                </div>
                                <div class="row m-2">
                                  <div class="col-3">
                                    <span class="largeText">Received From : </span>
                                  </div>
                                  <div class="col-9">
                                    <span class="largeText" style="text-decoration: underline;" id="receiptName"></span>
                                    &nbsp; <span class="largeText" style="text-decoration: underline;" id="receiptSonDaughter"></span> &nbsp;<span class="largeText" style="text-decoration: underline;" id="receiptFatherName"></span>
                                  </div>
                                </div>
                                <div class="row m-2">
                                  <div class="col-3">
                                    <span class="largeText">Programme : </span>
                                  </div>
                                  <div class="col-4">
                                    <span class="largeText" id="receiptCourse"></span>
                                  </div>
                                  <div class="col-5">
                                    <span class="largeText">Batch : </span>
                                    <span class="largeText" id="receiptBatch"></span>
                                    <span class="largeText">Semester : </span>
                                    <span class="largeText" id="receiptSemester"></span>
                                  </div>
                                </div>
                                <div class="row m-2">
                                  <div class="col-3">
                                    <span class="largeText">Uni Roll Number : </span>
                                  </div>
                                  <div class="col-4">
                                    <span class="largeText" id="receiptRollNumber"></span>
                                  </div>
                                  <div class="col-5">
                                    <span class="largeText">ID/Reg No : </span>
                                    <span class="largeText" id="receiptUserId"></span>
                                  </div>
                                </div>
                                <div class="row m-2">
                                  <div class="col-12">
                                    <span class="largeText">Through : </span>
                                    <span class="largeText" id="receiptMode" style="text-decoration: underline;"></span>&nbsp;[
                                    <span class="largeText" id="receiptBank" style="text-decoration: underline;"> --- </span>]&nbsp;
                                    <span class="largeText">On Account of:</span>
                                    <span class="largeText" id="receiptType" style="text-decoration: underline;"></span>
                                    <span class="largeText"> with transaction Id : </span>
                                    <span class="largeText" id="transactionId" style="text-decoration: underline;"></span>
                                    <span class="largeText"> dated : </span>
                                    <span class="largeText" id="transactionDate" style="text-decoration: underline;"></span>
                                  </div>
                                </div>

                              </td>
                            </tr>
                            <tr>
                              <td width="20%">
                                <span class="smallerText">Non Refundable</span>
                                <div class="border mt-0 mb-2" style="color: black;">
                                  &#8377; <span class="largeText" id="receiptAmount"></span>
                                </div>
                              </td>
                              <td>
                                <span class="largeText" id="receiptAmountWord"></span>
                              </td>
                              <td width="20%">
                                <br>
                                <span class="largeText mt-4 p-3">Signature</span>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      <div class="row m-2">
                        <div class="col-12 ml-3 pl-4">
                          <p class="largeText ml-3 pl-4">Description </p>
                          <span class="ml-3 pl-4" id="receiptDesc">---</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-trans" role="tabpanel" aria-labelledby="list-trans-list">
            <div class="row">
              <div class="col-10 pr-0">
                <div class="container card mt-2 myCard" id="print" style="overflow: scroll;">
                  <div class="row">
                    <div class="col-md-2 pr-0">
                      <div class="form-group">
                        <label>Mode</label>
                        <p class="transMode"></p>
                      </div>
                    </div>
                    <div class="col-md-2 pl-1 pr-0">
                      <div class="form-group">
                        <label>Fee Type</label>
                        <p class="transactionFeeType"></p>
                      </div>
                    </div>
                    <div class="col-md-2 mt-4 pl-1">
                      <div class="form-group">
                        <button class="btn btn-sm btn-block" id="showTransaction">Show Transaction</button>
                      </div>
                    </div>
                    <div class="col-md-6 mt-4 text-right">
                      <a class="fas fa-file-export" id="export"></a>
                    </div>
                  </div>
                  <table class="table table-bordered table-striped list-table-xs mt-3" id="transactionList">
                    <th class="text-center">SNo</th>
                    <th class="text-center">Receipt Date</th>
                    <th class="text-center">ID</th>
                    <th class="text-center">Student</th>
                    <th class="text-center">StudentId</th>
                    <th class="text-center">Prog</th>
                    <th class="text-center">Fee Type</th>
                    <th class="text-center">Mode</th>
                    <th class="text-center">Bank</th>
                    <th class="text-center">Amount</th>
                    <th class="text-center">TransId</th>
                    <th class="text-center">TransDate</th>
                    <th class="text-center">StaffId</th>
                  </table>
                  <h5 id="totalAmount"></h5>
                </div>
              </div>
              <div class="col-md-2 pl-1">
                <div class="container card mt-2 myCard">
                  <p class="transactionHead"></p>
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
</body>
<script>
  $(document).ready(function() {
    $(function() {
      $(document).tooltip();
    });
    feeType();
    feeMode();
    transactionMode();
    transactionFeeType();

    $(document).on('keyup', '#studentNameSearch', function() {
      var query = $(this).val();
      var sel_school = $("#sel_school").val();
      if (sel_school == "0") {
        $.alert("Please Select an Institution");
        $('#studentAutoList').fadeOut();
        $('#studentAutoList').html("");
      } else {
        // alert(query);
        if (query != '') {
          $.ajax({
            url: "feeReceiptSql.php",
            method: "POST",
            data: {
              sel_school: sel_school,
              query: query
            },
            success: function(data) {
              $('#studentAutoList').fadeIn();
              $('#studentAutoList').html(data);
            }
          });
        } else {
          $('#studentAutoList').fadeOut();
          $('#studentAutoList').html("");
        }
      }
    })

    $(document).on('click', '.autoList', function() {
      $('#studentNameSearch').val($(this).text());
      var id = $(this).attr("data-std");
      $('#studentAutoList').fadeOut();
      // $.alert("Student Id " + id);
      displayStudentData("student_id", id)
    })

    $(document).on('click', '#searchStudent', function(event) {
      var id = $("#studentSearch").val();
      // $.alert("User Id" + data);
      displayStudentData("user_id", id)
    })

    function displayStudentData(field_tag, id) {
      // $.alert(field_tag + " ID " + id);
      $.post("feeReceiptSql.php", {
        field_tag: field_tag,
        id: id,
        action: "fetchStudent",
      }, () => {}, "json").done(function(data) {
        // $.alert(data)
        // console.log(data)
        $(".student_id").text(data.student_id);
        $(".student_name").text(data.student_name);
        $(".student_fname").text(data.student_fname);
        $(".student_rollno").text(data.student_rollno);
        $(".user_id").text(data.user_id);
        $(".student_mobile").text(data.student_mobile);
        $(".student_batch").text(data.batch);
        $(".student_ay").text(data.ay);
        $(".student_program").text(data.program_name);
        $(".student_fcg").text(data.fcg);
        $("#studentIdHidden").val(data.student_id);
        if (data.student_gender == 'F') $("#receiptSonDaughter").text(" d/o ");
        else $("#receiptSonDaughter").text(" s/o ");
        $("#receiptFatherName").text(data.student_fname);
        $("#receiptName").text(data.student_name);
        if (data.student_image === null) $(".studentImage").html('<img  src="../../images/upload.jpg" width="40%">');
        else $(".studentImage").html('<img  src="<?php echo '../../' . $myFolder . '/studentImages/'; ?>' + data.student_image + '" width="40%">');

        feeConcessionList();
        feeReceiptList();
        feeDebitList();
        $("#studentSearch").val(data.user_id)

      }).fail(function() {
        $.alert("fail in place of error");
      })
    }

    $(document).on('click', '.feeRecord', function(event) {
      feeBalance();
    })

    $(document).on("click", "#showTransaction", function() {
      var dateFrom = $("#fr_from").val();
      var dateTo = $("#fr_to").val();
      var mode = $("#sel_tm").val();
      var ft = $("#sel_tft").val();
      var school_id = $("#sel_school").val();
      if (school_id == "0") $.alert("Please Select an Institution");
      else {
        $.alert("From " + dateFrom + "To " + dateTo + " Mode " + mode + " FT " + ft);
        $.post("<?php echo $phpFile; ?>", {
          dateFrom: dateFrom,
          dateTo: dateTo,
          mode: mode,
          ft: ft,
          school_id: school_id,
          action: "transactionList"
        }, function() {}, "json").done(function(data, status) {
          // $.alert(data);
          // console.log(data);
          var card = '';
          var count = 1;
          var total = 0;
          $.each(data, function(key, value) {
            card += '<tr>';
            card += '<td class="text-center">' + count++ + '</td>';
            card += '<td>' + getFormattedDate(value.fr_date, "dmY") + '</td>';
            card += '<td class="text-center">' + value.fr_id + '</td>';
            card += '<td>' + value.student_name + '</td>';
            card += '<td>' + value.user_id + '</td>';
            card += '<td>' + value.sp_abbri + '</td>';
            card += '<td class="text-center">' + value.fee_type + '</td>';
            card += '<td class="text-center">' + value.fee_mode + '</td>';
            card += '<td class="text-center">' + value.fee_bank + '</td>';

            card += '<td class="text-center">' + value.fr_amount + '</td>';
            if (value.transaction_id == null) card += '<td class="text-center">--</td>';
            else card += '<td class="text-center">' + value.transaction_id + '</td>';
            card += '<td class="text-center">' + value.transaction_date + '</td>';
            card += '<td class="text-center">' + value.staff_id + '</td>';
            card += '</tr>';
            total = total + parseInt(value.fr_amount)
          });

          $("#transactionList").find("tr:gt(0)").remove();
          totalText = '<span class="text-center"> Total ' + total + '</span>';
          $("#transactionList").append(card);
          $("#totalAmount").html(totalText);
          transactionHead();

        }).fail(function() {
          $.alert("Error !!");
        })
      }
    })

    function transactionHead() {
      var dateFrom = $("#fr_from").val();
      var dateTo = $("#fr_to").val();
      // $.alert("From " + dateFrom + "To " + dateTo);
      $.post("<?php echo $phpFile; ?>", {
        dateFrom: dateFrom,
        dateTo: dateTo,
        action: "transactionHead"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        // console.log(data);
        var card = '';
        $.each(data, function(key, value) {
          card += '<div class="container card mt-2 myCard">'
          card += '<h5 class="text-center">' + value.mode + '</h5>';
          card += '<h6 class="p-1">' + value.amount + '/-</h6>';
          card += '</div>'

        });

        $(".transactionHead").html(card);

      }).fail(function() {
        $.alert("Error !!");
      })
    }

    $(document).on('click', '#proposeFeeConcession', function(event) {
      var studentId = $("#studentIdHidden").val();
      if (studentId == 0) $.alert("Student not Selected !!");
      else if ($("#sel_ftConcession").val() == 0) $.alert("Fee Type not Selected !!");
      // else if ($("#feeAmountConcession").val() <= 0) $.alert("Fee Dues not Specified !!");
      else {
        var feeType = $("#sel_ftConcession").val();
        var sem = $("#semesterConcession").val();
        var feeAmount = $("#feeAmountConcession").val();
        var fcAmount = $("#fcAmount").val();
        var fdRemarks = $("#fdRemarks").val();
        // $.alert(" Sem " + sem + " Fee Type " + feeType + " Fee Amount " + feeAmount);
        $.post("feeReceiptSql.php", {
          id: studentId,
          feeType: feeType,
          sem: sem,
          feeAmount: feeAmount,
          fcAmount: fcAmount,
          fdRemarks: fdRemarks,
          action: "proposeConcession"
        }, function(data) {
          $.alert(data);
          feeConcessionList()
        }).fail(function() {
          $.alert("fail in place of error");
        })
      }
    })

    function feeConcessionList() {
      // $.alert("Batch");
      var studentId = $("#studentIdHidden").val();
      $.post("feeReceiptSql.php", {
        action: "feeConcessionList",
        id: studentId,
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        // console.log(data);
        var card = '';
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td>' + value.mn_name + '</td>';
          card += '<td class="text-center">' + value.fee_semester + '</td>';
          card += '<td class="text-center">' + value.fd_dues + '</td>';
          card += '<td class="text-center">' + value.fd_concession + '</td>';
          card += '<td class="text-center">' + value.fd_remarks + '</td>';
          card += '<td class="text-center">' + value.user_id + '</td>';
          card += '</tr>';
        });
        $("#feeConcessionList").find("tr:gt(0)").remove();
        $("#feeConcessionList").append(card);

      }).fail(function() {
        $.alert("Error !!");
      })

    }

    $(document).on('change', '#sel_fm', function(event) {
      var mode = $("#sel_fm option:selected").text()
      if (mode == "Cash") {
        // $.alert(mode)
        $("#tId").val('00-00-00');
        $("#tId").prop('disabled', true);
        $("#transaction_date").val("00-00-0000");
        $("#transaction_date").prop('disabled', true);
      } else {
        $("#tId").prop('disabled', false);
        $("#transaction_date").prop('disabled', false);
      }
    })

    function feeStructure() {
      var studentId = $("#studentIdHidden").val();
      var fee_semester = $("#semesterConcession").val()
      // $.alert("studentId " + studentId + "Sem " + fee_semester);
      $.post("<?php echo $phpFile; ?>", {
        student_id: studentId,
        fee_semester: fee_semester,
        action: "feeStructure"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        // console.log(data);
        var card = '';
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td>' + value.fee_type + '</td>';
          card += '<td>' + value.amount + '</td>';
          card += '</tr>';
        });
        $("#feeStructureList").find("tr:gt(0)").remove();
        $("#feeStructureList").append(card);
      }).fail(function() {
        $.alert("Error !!");
      })
    }

    $(document).on('click', '#addFeeReceipt', function(event) {
      var studentId = $("#studentIdHidden").val();
      var fr_sno = $("#fr_sno").val();
      var feeAmount = $("#feeAmount").val();
      var feeType = $("#sel_ft").val();
      var feeMode = $("#sel_fm").val();
      var sem = $("#semester").val();
      var tId = $("#tId").val();
      var feeDesc = $("#fee_desc").val();
      var transaction_date = $("#transaction_date").val();
      var fr_date = $("#fr_date").val();
      var fr_bank = $("#fr_bank").val();
      if (studentId > 0) {
        $.confirm({
          title: 'Please Confirm !',
          draggable: true,
          content: "<b><i>Fee of " + $(".student_name").text() + " of amount " + feeAmount + "</i></b>",
          buttons: {
            confirm: {
              btnClass: 'btn-info',
              action: function() {
                $.post("feeReceiptSql.php", {
                  id: studentId,
                  feeType: feeType,
                  feeMode: feeMode,
                  sem: sem,
                  fr_sno: fr_sno,
                  feeAmount: feeAmount,
                  tId: tId,
                  feeDesc: feeDesc,
                  fr_date: fr_date,
                  transaction_date: transaction_date,
                  fr_bank: fr_bank,
                  action: "addFeeReceipt"
                }, function(data) {
                  feeReceiptList();
                  feeDebitList();
                  $.alert(data);
                  $("#feeAmount").val("0");
                }, "text").fail(function() {
                  $.alert("fail in place of error");
                })
              }
            },
            cancel: {
              btnClass: "btn-danger",
              action: function() {}
            },
          }
        });
        // $.alert(feeAmount);
      } else $.alert("Student not Selected !!");
    })

    function feeReceiptList() {
      // $.alert("Batch");
      var studentId = $("#studentIdHidden").val();
      $.post("feeReceiptSql.php", {
        action: "feeReceiptList",
        id: studentId,
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        // console.log(data);
        var card = '';
        var totalCredit = 0;
        $.each(data, function(key, value) {
          totalCredit = parseInt(totalCredit) + parseInt(value.fr_amount)
          if (value.frev_id > 0) card += '<tr style="color:red">';
          else card += '<tr>';
          card += '<td class="text-center">' + value.fr_id + '</td>';
          card += '<td class="text-center">' + getFormattedDate(value.fr_date, "dmY") + '</td>';
          card += '<td class="text-center">' + value.semester + '</td>';
          if (value.fr_desc == null) card += '<td class="text-center">--</td>';
          else card += '<td>' + value.fr_desc + '</td>';
          card += '<td class="text-center">' + value.fee_type + '</td>';
          card += '<td class="text-center">' + value.fee_mode + '</td>';
          card += '<td class="text-center"></td>';
          card += '<td class="text-center">' + value.fr_amount + '</td>';
          card += '<td class="text-center">' + value.user_id + '</td>';
          if (value.frev_id > 0) card += '<td class="text-center"></td>';
          else card += '<td class="text-center"><a href="#" class="showReceipt" data-fr="' + value.fr_id + '"><i class="fas fa-eye"></i></a></td>';
          card += '</tr>';
        });
        $("#feeReceiptList").find("tr:gt(0)").remove();
        $("#feeReceiptList").append(card);
        $("#totalCredit").val(totalCredit);

      }).fail(function() {
        $.alert("Error in Receipt!!");
      })

    }

    function feeDebitList() {
      // $.alert("Batch");
      var studentId = $("#studentIdHidden").val();
      $.post("feeReceiptSql.php", {
        action: "feeDebitList",
        id: studentId,
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        // console.log(data);
        var card = '';
        var totalDebit = 0;
        $.each(data, function(key, value) {
          totalDebit = parseInt(totalDebit) + parseInt(value.fr_amount)
          card += '<tr>';
          card += '<td class="text-center">' + value.fr_id + '</td>';
          card += '<td class="text-center">' + getFormattedDate(value.update_ts, "dmY") + '</td>';
          card += '<td class="text-center">' + value.semester + '</td>';
          if (value.fr_desc == null) card += '<td class="text-center">--</td>';
          else card += '<td>' + value.fr_desc + '</td>';
          card += '<td class="text-center">' + value.fee_type + '</td>';
          card += '<td class="text-center">' + value.fee_mode + '</td>';
          card += '<td class="text-center">' + value.fr_amount + '</td>';
          card += '<td class="text-center"></td>';
          card += '<td class="text-center">' + value.user_id + '</td>';
          card += '<td class="text-center">--</td>';
          card += '</tr>';
        });
        $("#feeDebitList").find("tr:gt(0)").remove();
        $("#feeDebitList").append(card);
        $("#totalDebit").val(totalDebit);
      }).fail(function() {
        $.alert("Error in Debit List!!");
      })
    }

    function feeBalance() {
      var credit = $("#totalCredit").val();
      var debit = $("#totalDebit").val();
      var balance = parseInt(debit) - parseInt(credit);
      $("#totalBalance").val(balance);
      // $.alert(credit + "Debit" + debit + "Bal" + balance)
    }

    function feeRecordList() {
      // $.alert("Batch");
      var studentId = $("#studentIdHidden").val();
      $.post("feeReceiptSql.php", {
        action: "feeRecordList",
        id: studentId,
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        // console.log(data);
        var card = '';
        var netBalance = 0;
        var totalDebit = 0;
        var totalCredit = 0;
        $.each(data, function(key, value) {
          totalDebit = totalDebit + parseInt(value.fr_debit)
          totalCredit = totalCredit + parseInt(value.fr_amount)
          netBalance = netBalance - parseInt(value.fr_amount) + parseInt(value.fr_debit)
          if (value.frev_id > 0) card += '<tr style="color:red">';
          else card += '<tr>';
          card += '<td class="text-center">' + value.fr_id + '</td>';
          card += '<td class="text-center">' + getFormattedDate(value.fr_date, "dmY") + '</td>';
          card += '<td class="text-center">' + value.semester + '</td>';
          if (value.fr_desc == null) card += '<td class="text-center">--</td>';
          else card += '<td>' + value.fr_desc + '</td>';
          card += '<td class="text-center">' + value.fee_type + '</td>';
          card += '<td class="text-center">' + value.fee_mode + '</td>';
          if (parseInt(value.fr_debit) > 0) card += '<td class="text-center">' + value.fr_debit + '</td>';
          else card += '<td class="text-center"></td>';
          if (parseInt(value.fr_amount) > 0) card += '<td class="text-center">' + value.fr_amount + '</td>';
          else card += '<td class="text-center"></td>';
          card += '<td class="text-center">' + netBalance + '</td>';
          card += '<td class="text-center">' + value.user_id + '</td>';
          card += '</tr>';
        });
        card += '<tr><td colspan="6"></td><td>' + totalDebit + '</td><td>' + totalCredit + '</td><td>' + netBalance + '</td></tr>'
        $("#feeRecordList").find("tr:gt(0)").remove();
        $("#feeRecordList").append(card);
        // $("#totalCredit").val(totalCredit);

      }).fail(function() {
        $.alert("Error in Fee Record!!");
      })

    }

    $(document).on('click', '#reverseSubmit', function(event) {
      var fr_sno = $("#frId").val();
      var frev_desc = $("#fre_desc").val();
      if (fr_sno > 0) {
        $.confirm({
          title: 'Please Confirm !',
          draggable: true,
          content: "<b><i>Fee Receipt No " + fr_sno + " is being Reversed !! <br> Remarks : " + frev_desc + "</i></b>",
          buttons: {
            confirm: {
              btnClass: 'btn-info',
              action: function() {
                $.post("feeReceiptSql.php", {
                  id: fr_sno,
                  frev_desc: frev_desc,
                  action: "addFeeReverse"
                }, function(data) {
                  feeReceiptList();
                  feeDebitList();
                  $("#fre_desc").val("");
                  $.alert(data);
                }, "text").fail(function() {
                  $.alert("fail in place of error");
                })
              }
            },
            cancel: {
              btnClass: "btn-danger",
              action: function() {}
            },
          }
        });


        // $.alert(feeAmount);

      } else $.alert("Student not Selected !!");
    });

    $(document).on("click", "#rerShow", function() {
      var dateFrom = $("#fr_from").val();
      var dateTo = $("#fr_to").val();
      $.alert("From " + dateFrom + "To " + dateTo);
      $.post("<?php echo $phpFile; ?>", {
        dateFrom: dateFrom,
        dateTo: dateTo,
        action: "rerList"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        // console.log(data);
        var card = '';
        var count = 1;
        var total = 0;
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td class="text-center">' + count++ + '</td>';
          card += '<td>' + getFormattedDate(value.fr_date, "dmY") + '</td>';
          card += '<td>' + getFormattedDate(value.frev_date, "dmY") + '</td>';
          card += '<td class="text-center">' + value.fr_id + '</td>';
          card += '<td>' + value.student_name + '</td>';
          card += '<td>' + value.user_id + '</td>';
          card += '<td class="text-center">' + value.fee_type + '</td>';
          card += '<td class="text-center">' + value.fr_amount + '</td>';
          card += '<td class="text-center">' + value.staff_id + '</td>';
          card += '<td>' + value.frev_desc + '</td>';
          card += '</tr>';
          // total = total + parseInt(value.fr_amount)
        });
        $("#rerList").find("tr:gt(0)").remove();
        totalText = '<span class="text-center"> Total ' + total + '</span>';
        $("#rerList").append(card);
      }).fail(function() {
        $.alert("Error !!");
      })
    });

    $(document).on("click", "#searchReceipt", function() {
      var fr_id = $("#frId").val();
      // $.alert("Fr Id " + fr_id);
      showReceipt(fr_id)
    });

    $(document).on("click", ".showReceipt", function() {
      var fr_id = $(this).attr("data-fr");
      // $.alert("Fr Id " + fr_id + $("#studentSearch").val());
      showReceipt(fr_id)
    });

    function showReceipt(x) {
      // $.alert("Fr Id " + x);
      $.post("feeReceiptSql.php", {
        frId: x,
        action: "fetchReceipt"
      }, () => {}, "json").done(function(data, status) {
        // $.alert(data.fr_id);
        // console.log(data)
        $('#receiptNumber').html(data.fr_id)
        $('.schoolName').html(data.school_name)
        $('.deptName').html(data.dept_name)
        if (data.fr_sno == null) $('#frSno').html("----")
        else $('#frSno').html(data.fr_sno)
        $("#receiptDate").html(getFormattedDate(data.fr_date, "dmY"));
        $("#receiptTime").html(getTime(data.update_ts, "dmY"));
        $("#receiptName").html(data.student_name);
        $("#receiptFatherName").html(data.student_fname);
        $("#receiptCourse").html(data.student_program);
        $("#receiptBatch").html(data.student_batch);
        $("#receiptSemester").html(data.fee_semester);
        $("#receiptMode").html(data.fee_mode);
        $("#receiptBank").html(data.fee_bank);
        $("#receiptType").html(data.fee_type);
        $("#receiptDesc").html(data.fr_desc);
        $("#receiptUserId").html(data.user_id);
        $("#transactionId").html(data.transaction_id);
        $("#transactionDate").html(getFormattedDate(data.transaction_date, "dmY"));
        $("#receiptAmount").text(data.fr_amount + '/-');
        $("#receiptAmountWord").text(numberToWords(parseInt(data.fr_amount)) + ' only');

        $("#frId").val(data.fr_id);
        $("#frIdReverse").html(data.fr_id);
        $("#receiptUserIdReverse").html(data.user_id);
        $("#receiptAmountReverse").text(data.fr_amount + '/-');

      }).fail(function() {
        $.alert("fail in place of error");
      })
    }

    function feeType() {
      // $.alert("Department ");
      $.post("feeReceiptSql.php", {
        action: "feeType"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var list = '';
        list += '<select class="form-control form-control-sm" name="sel_ft" id="sel_ft" required>';
        $.each(data, function(key, value) {
          list += '<option value=' + value.mn_id + '>' + value.mn_name + '</option>';
        });
        list += '</select>';
        var listConcession = '';
        listConcession += '<select class="form-control form-control-sm" name="sel_ft" id="sel_ftConcession" required>';
        listConcession += '<option value="0">Select Fee Type</option>';
        $.each(data, function(key, value) {
          listConcession += '<option value=' + value.mn_id + '>' + value.mn_name + '</option>';
        });
        listConcession += '</select>';
        $("#feeType").html(list);
        $("#feeTypeConcession").html(listConcession);
      }).fail(function() {
        $.alert("Error !!");
      })
    }

    function feeMode() {
      // $.alert("Department ");
      $.post("feeReceiptSql.php", {
        action: "feeMode"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var list = '';
        list += '<select class="form-control form-control-sm" name="sel_fm" id="sel_fm" required>';
        $.each(data, function(key, value) {
          list += '<option value=' + value.mn_id + '>' + value.mn_name + '</option>';
        });
        list += '</select>';
        $(".feeMode").html(list);

      }).fail(function() {
        $.alert("Error !!");
      })
    }

    function transactionMode() {
      // $.alert("Department ");
      $.post("feeReceiptSql.php", {
        action: "feeMode"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var list = '';
        list += '<select class="form-control form-control-sm" name="sel_tm" id="sel_tm" required>';
        list += '<option value="ALL">ALL</option>';
        $.each(data, function(key, value) {
          list += '<option value=' + value.mn_id + '>' + value.mn_name + '</option>';
        });
        list += '</select>';
        $(".transMode").html(list);

      }).fail(function() {
        $.alert("Error !!");
      })
    }

    function transactionFeeType() {
      // $.alert("Department ");
      $.post("feeReceiptSql.php", {
        action: "feeType"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var list = '';
        list += '<select class="form-control form-control-sm" name="sel_ft" id="sel_tft" required>';
        list += '<option value="ALL">ALL</option>';
        $.each(data, function(key, value) {
          list += '<option value=' + value.mn_id + '>' + value.mn_name + '</option>';
        });
        list += '</select>';
        $(".transactionFeeType").html(list);
      }).fail(function() {
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

    function getTime(ts) {
      var a = new Date(ts);
      var time = a.getHours() + ':' + a.getMinutes();
      return time;
    }

    function numberToWords(number) {
      var digit = ['zero', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
      var elevenSeries = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
      var countingByTens = ['Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
      var shortScale = ['', 'Thousand', 'million', 'billion', 'trillion'];

      number = number.toString();
      number = number.replace(/[\, ]/g, '');
      if (number != parseFloat(number)) return 'not a number';
      var x = number.indexOf('.');
      if (x == -1) x = number.length;
      if (x > 15) return 'too big';
      var n = number.split('');
      var str = '';
      var sk = 0;
      for (var i = 0; i < x; i++) {
        if ((x - i) % 3 == 2) {
          if (n[i] == '1') {
            str += elevenSeries[Number(n[i + 1])] + ' ';
            i++;
            sk = 1;
          } else if (n[i] != 0) {
            str += countingByTens[n[i] - 2] + ' ';
            sk = 1;
          }
        } else if (n[i] != 0) {
          str += digit[n[i]] + ' ';
          if ((x - i) % 3 == 0) str += 'Hundred ';
          sk = 1;
        }
        if ((x - i) % 3 == 1) {
          if (sk) str += shortScale[(x - i - 1) / 3] + ' ';
          sk = 0;
        }
      }
      if (x != number.length) {
        var y = number.length;
        str += 'point ';
        for (var i = x + 1; i < y; i++) str += digit[n[i]] + ' ';
      }
      str = str.replace(/\number+/g, ' ');
      return str.trim();
    }
  })

  function printDiv(print) {
    // $.alert("In print");
    var backup = document.body.innerHTML;
    var divContent = document.getElementById(print).innerHTML;
    document.body.innerHTML = divContent;
    window.print();
    document.body.innerHTML = backup;
  }

  document.getElementById('export').onclick = function() {
    var tableId = document.getElementById('transactionList').id;
    htmlTableToExcel(tableId, filename = '');
  }

  document.getElementById('frExport').onclick = function() {
    var tableId = document.getElementById('feeRecordList').id;
    htmlTableToExcel(tableId, filename = '');
  }
  var htmlTableToExcel = function(tableId, fileName = '') {
    var excelFileName = 'excel_table_data';
    var TableDataType = 'application/vnd.ms-excel';
    var selectTable = document.getElementById(tableId);
    var htmlTable = selectTable.outerHTML.replace(/ /g, '%20');

    filename = filename ? filename + '.xls' : excelFileName + '.xls';
    var excelFileURL = document.createElement("a");
    document.body.appendChild(excelFileURL);

    if (navigator.msSaveOrOpenBlob) {
      var blob = new Blob(['\ufeff', htmlTable], {
        type: TableDataType
      });
      navigator.msSaveOrOpenBlob(blob, fileName);
    } else {

      excelFileURL.href = 'data:' + TableDataType + ', ' + htmlTable;
      excelFileURL.download = fileName;
      excelFileURL.click();
    }
  }
</script>

</html>