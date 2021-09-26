<?php
require('../requireSubModule.php');
$phpFile = "feeReceiptSql.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Outcome Based Education : ClassConnect</title>
  <?php require("../css.php"); ?>
</head>

<body>
  <?php require("../topBar.php"); ?>
  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-2 p-0 m-0 pl-2 full-height">
        <div class="mt-3">
          <h5>Manage Receipt</h5>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active fr" id="list-fr-list" data-toggle="list" href="#list-fr" role="tab" aria-controls="fr">Fee Receipt</a>
          <a class="list-group-item list-group-item-action trans" id="list-trans-list" data-toggle="list" href="#list-trans" role="tab" aria-controls="trans">Transactions Details</a>
          <a class="list-group-item list-group-item-action feeConcession" id="list-feeConcession-list" data-toggle="list" href="#feeConcession" role="tab" aria-controls="trans">Fee Concession</a>

        </div>
      </div>
      <div class="col-10 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <div class="row">
            <div class="col-3 pr-0">
              <div class="card border-info">
                <div class="card-body text-primary">
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
            <div class="col-3">
              <div class="card border-info">
                <div class="card-body text-primary">
                  <input name="studentNameSearch" id="studentNameSearch" class="form-control form-control-sm" type="text" placeholder="Search Student" aria-label="Search">
                  <div class='list-group' id="studentAutoList"></div>
                  </button>
                </div>
              </div>
            </div>
            <div class="col-6 student_detail">
              <div class="container card myCard">
                <div class="row p-1">
                  <div class="col-3 m-0 p-0">
                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="70%">
                  </div>
                  <div class="col-9">
                    <div class="row p-1">
                      <div class="col-2 m-0 p-0">
                        <label>Name</label>
                      </div>
                      <div class="col-7">
                        <span class="student_name">Not Found</span> [<span class="student_rollno">000000</span>]
                      </div>
                      <div class="col-3">
                        [<span class="student_id">0000</span>]
                      </div>
                    </div>
                    <div class="row p-1">
                      <div class="col-2 m-0 p-0">
                        <label>Mobile</label>
                      </div>
                      <div class="col-10 student_mobile">
                        Not Found
                      </div>
                    </div>
                    <div class="row p-1">
                      <div class="col-2 m-0 p-0">
                        <label>Program</label>
                      </div>
                      <div class="col-7 student_program">
                        Enter Valid Data
                      </div>
                      <div class="col-3 m-0 p-0">
                        <label>Batch</label>:<span class="student_batch"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane show active" id="list-fr" role="tabpanel" aria-labelledby="list-fr-list">
            <div class="row">
              <div class="col pr-1">
                <div class="container card mt-2 myCard">
                  <!-- nav options -->
                  <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="pills_tablePersonalInfo" data-toggle="pill" href="#pills_personalInfo" role="tab" aria-controls="pills_personalInfo" aria-selected="true">Fee Transaction</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="pill" href="#feeRecord" role="tab" aria-controls="feeRecord" aria-selected="true">Fee Record</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="pill" href="#feeReceipt" role="tab" aria-controls="feeReceipt" aria-selected="true">Fee Receipt</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="pill" href="#reverse" role="tab" aria-controls="reverse" aria-selected="true">Reverse Entry</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="pills-tabContent p-3">
                    <!-- <h4> New Id <span class="newId"> - Not Created </span></h4> -->
                    <div class="tab-pane show active" id="pills_personalInfo" role="tabpanel" aria-labelledby="pills_personalInfo">
                      <input type="hidden" id="studentIdHidden" name="studentIdHidden">
                      <div class="row">
                        <div class="col-12">
                          <div class="row">
                            <div class="col-3 pr-1">
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
                            <div class="col-3 pl-1 pr-0">
                              <div class="form-group">
                                <label>Semester</label>
                                <input type="number" class="form-control form-control-sm" id="semester" min="1" name="semester" placeholder="Semester" value="1">
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
                            <div class="col-3 pr-1">
                              <div class="form-group">
                                <label>Receipt No</label>
                                <input type="number" class="form-control form-control-sm" id="fr_sno" name="fr_sno" placeholder="" data-tag="fr_sno">
                              </div>
                            </div>
                            <div class="col-3 pr-1">
                              <div class="form-group">
                                <label>Amount</label>
                                <input type="number" class="form-control form-control-sm" id="feeAmount" name="feeAmount" placeholder="" data-tag="fr_amount">
                              </div>
                            </div>
                            <div class="col-3 pr-1 pl-1">
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
                          <div class="row">
                            <div class="col-12">
                              <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control form-control-sm" id="fee_desc" name="fee_desc" rows="3" data-tag="fee_description"></textarea>
                              </div>
                            </div>
                          </div>
                          <input type="hidden" id="action" name="action" value="addFeeReceipt">
                          <button class="btn btn-sm" id="addFeeReceipt">Accept Transaction</button>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="feeRecord" role="tabpanel" aria-labelledby="feeRecord">
                      <div class="row">
                        <div class="col-5">
                          <h4>Debit Record</h4>
                          <table class="table table-bordered table-striped list-table-xs mt-3" id="feeDebitList">
                            <th class="text-center">Id</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Staff</th>
                            <th class="text-center">Date</th>
                          </table>
                        </div>
                        <div class="col-7">
                          <h4>Credit Record</h4>
                          <table class="table table-bordered table-striped list-table-xs mt-3" id="feeReceiptList">
                            <th class="text-center">Id</th>
                            <th class="text-center">Mode</th>
                            <th class="text-center">Fee Type</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">StaffId</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Date</th>
                            <th class="text-center"><i class="fa fa-eye"></i></th>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="feeReceipt" role="tabpanel" aria-labelledby="feeReceipt">
                      <div class="row">
                        <div class="col-1"></div>
                        <div class="col-md-3 pr-0">
                          <input type="text" class="form-control form-control-sm" id="frId" name="frId" placeholder="Fee Receipt Number" aria-label="frId">
                        </div>
                        <div class="col-md-1 pl-0">
                          <button type="button" class="btn btn-block btn-sm" id="searchReceipt"><i class="fas fa-search"></i></button>
                        </div>
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
                                  <div class="col-2 p-2"><img src="../../images/logo.jpg" width="70%"></div>
                                  <div class="col-10">
                                    <span class="xxlText"> Aryans Group of Colleges </span>
                                    <p class="largeText">Vill. Nepra/Thuha, Chandigarh - Patiala Highway, Tehsil Rajpura, District Patiala, Pincode 140 401</p>
                                    <p class="largeText">www.aryans.edu.in | +91 9876 29 9888</p>
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
                                    <span class="largeText" id="receiptMode" style="text-decoration: underline;"></span>
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
                    </div>
                    <div class="tab-pane fade" id="reverse" role="tabpanel" aria-labelledby="reverse">
                      <div class="row">
                        <div class="col-12">
                          <div class="row">
                            <div class="col-3 pr-1">
                              <div class="form-group">
                                <label>Receipt No</label>
                                <p id="frIdReverse"></p>
                              </div>
                            </div>
                            <div class="col-3 pr-1 pl-1">
                              <div class="form-group">
                                <label>Student ID</label>
                                <p id="receiptUserIdReverse"></p>
                              </div>
                            </div>
                            <div class="col-3 pr-1">
                              <div class="form-group">
                                <label>Amount</label>
                                <p id="receiptAmountReverse"></p>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12">
                              <div class="form-group">
                                <label>Reverse Description</label>
                                <textarea class="form-control form-control-sm" id="fre_desc" name="fre_desc" rows="3" data-tag="fre_desc"></textarea>
                              </div>
                            </div>
                          </div>
                          <button class="btn btn-sm" id="reverseSubmit">Reverse Transaction</button>
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
                <div class="container card mt-2 myCard">
                  <div class="row">
                    <div class="col-12">
                      <div class="row">
                        <div class="col">
                          <div class="form-group">
                            <label>Receipt From</label>
                            <input type="date" class="form-control form-control-sm" id="fr_from" name="fr_from" value="<?php echo $submit_date; ?>">
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <label>Receipt To</label>
                            <input type="date" class="form-control form-control-sm" id="fr_to" name="fr_to" value="<?php echo $submit_date; ?>">
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <label>Mode</label>
                            <p class="transMode"></p>
                          </div>
                        </div>

                        <div class="col mt-3">
                          <div class="form-group">
                            <button class="btn btn-sm" id="showTransaction">Show Transaction</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="container card mt-2 myCard" id="print" style="overflow: scroll;">
                  <div class="col-md-12 text-right">
                    <a class="fas fa-file-export" id="export"></a>
                  </div>
                  <table class="table table-bordered table-striped list-table-xxs mt-3" id="transactionList">
                    <th class="text-center">SNo</th>
                    <th class="text-center">Receipt Date</th>
                    <th class="text-center">ID</th>
                    <th class="text-center">Student</th>
                    <th class="text-center">StudentId</th>
                    <th class="text-center">Mode</th>
                    <th class="text-center">Fee Type</th>
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
          <div class="tab-pane fade" id="feeConcession" role="tabpanel" aria-labelledby="feeConcession">
            <div class="row">
              <div class="col-10">
                <div class="container card mt-2 myCard">
                  <div class="row">
                    <div class="col-12">
                      <div class="row">
                        <div class="col-3 pr-1">
                          <div class="form-group">
                            <label>Type</label>
                            <p id="feeTypeConcession"></p>
                          </div>
                        </div>
                        <div class="col-3 pl-1 pr-0">
                          <div class="form-group">
                            <label>Semester</label>
                            <input type="number" class="form-control form-control-sm" id="semesterConcession" min="1" name="semester" placeholder="Semester" value="1">
                          </div>
                        </div>
                        <div class="col-3 pr-1 pr-0">
                          <div class="form-group">
                            <label>Amount</label>
                            <input type="number" class="form-control form-control-sm" id="feeAmountConcession" name="feeAmount" placeholder="" data-tag="fr_amount">
                          </div>
                        </div>
                        <div class="col-3 pr-1">
                          <button class="btn btn-sm mt-4" id="proposeFeeConcession">Propose Concession</button>
                        </div>
                      </div>
                      <table class="table table-bordered table-striped list-table-xs mt-3" id="feeConcessionList">
                        <th class="text-center">Fee Type</th>
                        <th class="text-center">Semester</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">StaffId</th>
                      </table>
                    </div>
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
    <?php require("../bottom_bar.php"); ?>
  </div>
</body>
<?php require("../js.php"); ?>


<script>
  $(document).ready(function() {

    feeType();
    feeMode();
    transactionMode();

    $('#studentNameSearch').keyup(function() {
      var query = $(this).val();
      // alert(query);
      if (query != '') {
        $.ajax({
          url: "feeReceiptSql.php",
          method: "POST",
          data: {
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
    });

    $(document).on('click', '#searchStudent', function(event) {
      var data = $("#studentSearch").val();
      // $.alert(data);
      $.post("feeReceiptSql.php", {
        action: "fetchStudent",
        userId: data,
      }, () => {}, "json").done(function(data) {
        // console.log(data)
        $(".student_id").text(data.student_id);
        $(".student_name").text(data.student_name);
        $(".student_rollno").text(data.student_rollno);
        $(".student_mobile").text(data.student_mobile);
        $(".student_batch").text(data.batch);
        $(".student_program").text(data.program_name);
        $("#studentIdHidden").val(data.student_id);
        if (data.student_gender == 'F') $("#receiptSonDaughter").text(" d/o ");
        else $("#receiptSonDaughter").text(" s/o ");
        $("#receiptFatherName").text(data.student_fname);
        $("#receiptName").text(data.student_name);
        feeConcessionList();
        feeReceiptList();
        feeDebitList();
        // $.alert(data);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.autoList', function() {
      $('#studentNameSearch').val($(this).text());
      var stdId = $(this).attr("data-std");
      $('#studentAutoList').fadeOut();
      $.alert(stdId);
      $.post("feeReceiptSql.php", {
        userId: stdId,
        action: "fetchStudentAutoList"
      }, () => {}, "json").done(function(data) {
        // $.alert(data)
        $(".student_id").text(data.student_id);
        $(".student_name").text(data.student_name);
        $(".student_rollno").text(data.student_rollno);
        $(".student_mobile").text(data.student_mobile);
        $(".student_batch").text(data.batch);
        $(".student_program").text(data.program_name);
        $("#studentIdHidden").val(data.student_id);
        if (data.student_gender == 'F') $("#receiptSonDaughter").text(" d/o ");
        else $("#receiptSonDaughter").text(" s/o ");
        $("#receiptFatherName").text(data.student_fname);
        $("#receiptName").text(data.student_name);

        $("#studentSearch").val(data.user_id)
        feeConcessionList();
        feeReceiptList();
        feeDebitList();
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on("click", "#showTransaction", function() {
      var dateFrom = $("#fr_from").val();
      var dateTo = $("#fr_to").val();
      var mode = $("#sel_tm").val();
      // $.alert("From " + dateFrom + "To " + dateTo + " Mode " + mode);
      $.post("<?php echo $phpFile; ?>", {
        dateFrom: dateFrom,
        dateTo: dateTo,
        mode: mode,
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
          card += '<td class="text-center">' + value.fee_mode + '</td>';
          card += '<td class="text-center">' + value.fee_type + '</td>';

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
    });

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
          card+= '<div class="container card mt-2 myCard">'
          card += '<h5 class="text-center">' + value.mode + '</h5>';
          card += '<h6 class="p-1">' + value.amount + '/-</h6>';
          card+= '</div>'

        });

        $(".transactionHead").html(card);

      }).fail(function() {
        $.alert("Error !!");
      })
    }

    $(document).on('click', '#proposeFeeConcession', function(event) {
      var studentId = $("#studentIdHidden").val();
      if (studentId > 0) {
        var feeType = $("#sel_ftConcession").val();
        var sem = $("#semesterConcession").val();
        var feeAmount = $("#feeAmountConcession").val();
        // $.alert(" Sem " + sem + " Fee Type " + feeType + " Fee Amount " + feeAmount);
        $.post("feeReceiptSql.php", {
          id: studentId,
          feeType: feeType,
          sem: sem,
          feeAmount: feeAmount,
          action: "proposeConcession"
        }, function(data) {
          $.alert(data);
          feeConcessionList()
          // feeReceiptList();
        }, "text").fail(function() {
          $.alert("fail in place of error");
        })
      } else $.alert("Student not Selected !!");
    });

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
          card += '<td class="text-center">' + value.mn_name + '</td>';
          card += '<td class="text-center">' + value.fee_semester + '</td>';
          card += '<td class="text-center">' + value.fc_amount + '</td>';
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
    });
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
    });

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
        $.each(data, function(key, value) {
          if (value.frev_id > 0) card += '<tr style="color:red">';
          else card += '<tr>';
          card += '<td class="text-center">' + value.fr_id + '</td>';
          card += '<td class="text-center">' + value.fee_mode + '</td>';
          card += '<td class="text-center">' + value.fee_type + '</td>';
          if (value.fr_desc == null) card += '<td class="text-center">--</td>';
          else card += '<td class="text-center">' + value.fr_desc + '</td>';
          card += '<td class="text-center">' + value.user_id + '</td>';
          card += '<td class="text-center">' + value.fr_amount + '</td>';
          card += '<td class="text-center">' + getFormattedDate(value.fr_date, "dmY") + '</td>';
          card += '<td class="text-center"><a href="#" class="showReceipt" data-fr="' + value.fr_id + '"><i class="fas fa-eye"></i></a></td>';
          card += '</tr>';
        });
        $("#feeReceiptList").find("tr:gt(0)").remove();
        $("#feeReceiptList").append(card);

      }).fail(function() {
        $.alert("Error !!");
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
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td class="text-center">' + value.fr_id + '</td>';
          card += '<td class="text-center">' + value.fr_amount + '</td>';
          if (value.frev_desc == null) card += '<td class="text-center">--</td>';
          else card += '<td class="text-center">' + value.frev_desc + '</td>';
          card += '<td class="text-center">' + value.user_id + '</td>';
          card += '<td class="text-center">' + getFormattedDate(value.update_ts, "dmY") + '</td>';
          card += '</tr>';
        });
        $("#feeDebitList").find("tr:gt(0)").remove();
        $("#feeDebitList").append(card);

      }).fail(function() {
        $.alert("Error !!");
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
        $("#receiptType").html(data.fee_type);
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
        $.each(data, function(key, value) {
          list += '<option value=' + value.mn_id + '>' + value.mn_name + '</option>';
        });
        list += '<option value="ALL">ALL</option>';
        list += '</select>';
        $(".transMode").html(list);

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
  });

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