<?php
require('../requireSubModule.php');
$phpFile = "paymentSql.php";
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
          <h5>Manage Payments</h5>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active pv" id="list-pv-list" data-toggle="list" href="#list-pv" role="tab" aria-controls="pv">Payment Voucher</a>
          <a class="list-group-item list-group-item-action trans" id="list-trans-list" data-toggle="list" href="#list-trans" role="tab" aria-controls="trans">Payment Transactions</a>
        </div>
      </div>
      <div class="col-10 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <!-- <div class="row">
            <div class="col-6 pr-0">
              <div class="card border-info">
                <div class="card-body text-primary">
                  <div class="row">
                    <div class="col-3 pr-0">
                      <input type="text" class="form-control form-control-sm" id="studentId" name="studentId" placeholder="Student Id" aria-label="studentId">
                    </div>
                    <div class="col-3 pl-1 pr-0">
                      <button type="button" class="btn btn-block btn-sm" id="searchStudent">Student <i class="fas fa-search"></i></button>
                    </div>
                    <div class="col-3 pl-1 pr-0">
                      <button type="button" class="btn btn-block btn-sm" id="staffSearch">Staff <i class="fas fa-search"></i></button>
                    </div>
                    <div class="col-3 pl-1">
                      <button type="button" class="btn btn-block btn-sm" id="vendorSearch">Vendor <i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6 pr-0">
              <div class="card border-info">
                <div class="card-body text-primary">
                  <div class="row">
                    <div class="col-6 pr-0">
                      <p id="name"></p>
                    </div>
                    <div class="col-6 pl-1">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div> -->
          <div class="tab-pane show active" id="list-pv" role="tabpanel" aria-labelledby="list-pv-list">
            <div class="row">
              <div class="col-9 pr-1">
                <div class="container card mt-2 myCard">
                  <!-- nav options -->
                  <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="pill" href="#pt" role="tab" aria-controls="pt" aria-selected="true">Payment Transaction</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="pill" id="pvDailyPill" href="#pvDaily" role="tab" aria-controls="pvDaily" aria-selected="true">Daily Voucher</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="pill" href="#pvShow" role="tab" aria-controls="pvShow" aria-selected="true">Payment Voucher</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="pills-tabContent p-3">
                    <div class="tab-pane show active" id="pt" role="tabpanel" aria-labelledby="pt">
                      <form id="pvForm" name="pvForm">
                        <div class="row">
                          <div class="col-12">
                            <div class="row">
                              <div class="col-3 pr-1">
                                <div class="form-group">
                                  <label>Payment Type</label>
                                  <p id="paymentHead"></p>
                                </div>
                              </div>
                              <div class="col-3 pl-1 pr-0">
                                <div class="form-group">
                                  <label>Bill No</label>
                                  <input type="number" class="form-control form-control-sm" id="bill_no" min="1" name="bill_no" placeholder="Semester" value="1">
                                </div>
                              </div>
                              <div class="col-3 pl-1">
                                <div class="form-group" id="cash">
                                  <label>Bill Date</label>
                                  <input type="date" class="form-control form-control-sm" id="bill_date" name="bill_date" value=<?php echo $submit_date; ?>>
                                </div>
                              </div>
                              <div class="col-3 pl-1">
                                <div class="form-group" id="cash">
                                  <label>Bill Amount</label>
                                  <input type="number" class="form-control form-control-sm" id="bill_amount" name="bill_amount" min="0" value="0">
                                </div>
                              </div>

                            </div>
                            <div class="row">
                              <div class="col-3 pr-0">
                                <div class="form-group">
                                  <label>Payee Name</label>
                                  <input type="text" class="form-control form-control-sm" id="payee_name" name="payee_name">
                                </div>
                              </div>
                              <div class="col-3 pr-1">
                                <div class="form-group">
                                  <label>Payee Mobile</label>
                                  <input type="number" class="form-control form-control-sm" id="payee_mobile" name="payee_mobile">
                                </div>
                              </div>
                              <div class="col-3 pr-1 pl-1">
                                <div class="form-group">
                                  <label>Payee Id</label>
                                  <input type="text" class="form-control form-control-sm" id="payee_id" name="payee_id">
                                </div>
                              </div>
                              <div class="col-3 pl-1">
                                <div class="form-group">
                                  <label>Amount Paid</label>
                                  <input type="number" class="form-control form-control-sm" id="pv_amount" name="pv_amount">
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-3 pr-0">
                                <div class="form-group">
                                  <label>Payment Mode</label>
                                  <p id="feeMode"></p>
                                </div>
                              </div>
                              <div class="col-3 pr-1 pl-1">
                                <div class="form-group">
                                  <label>Transaction ID</label>
                                  <input type="text" class="form-control form-control-sm" id="transaction_id" name="transaction_id" placeholder="Transaction ID">
                                </div>
                              </div>
                              <div class="col-3 pl-1">
                                <div class="form-group">
                                  <label>Transaction Date</label>
                                  <input type="date" class="form-control form-control-sm" id="transaction_date" name="transaction_date" value=<?php echo $submit_date; ?> data-tag="transaction_date">
                                </div>
                              </div>
                              <div class="col-3 pl-1">
                                <div class="form-group">
                                  <label>Payment Type</label><br>
                                  <input type="radio" checked id="credit" name="pv_type" value="Credit"> Credit
                                  <input type="radio" id="debit" name="pv_type" value="Debit"> Debit
                                </div>
                              </div>
                            </div>
                            <div class="row">

                              <div class="col-12">
                                <div class="form-group">
                                  <label>Description</label>
                                  <textarea class="form-control form-control-sm" id="pv_desc" name="pv_desc" rows="3" data-tag="pv_description"></textarea>
                                </div>
                              </div>
                            </div>
                            <input type="hidden" id="action" name="action" value="addPayment">
                            <button class="btn btn-sm" id="addPayment">Accept Transaction</button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="tab-pane fade" id="pvDaily" role="tabpanel" aria-labelledby="pvDaily">
                      <table class="table table-bordered table-striped list-table-xxs mt-3" id="dailyVoucher">
                        <th class="text-center">SNo</th>
                        <th class="text-center">Voucher Date</th>
                        <th class="text-center">ID</th>
                        <th class="text-center">Payee</th>
                        <th class="text-center">Mobile</th>
                        <th class="text-center">Head</th>
                        <th class="text-center">Mode</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">TransId</th>
                        <th class="text-center">TransDate</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">StaffId</th>
                        <th class="text-center"><i class="fa fa-eye"></i></th>
                      </table>
                    </div>
                    <div class="tab-pane fade" id="pvShow" role="tabpanel" aria-labelledby="pvShow">
                      <div class="float-right"><a onclick="printDiv('page1')" class="fa fa-print"></a></div>
                      <div class="row" id="page1">
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
                                    <h4 class="largeText" style="text-decoration: underline;">Payment Voucher</h4>
                                  </div>
                                </div>
                                <div class="row m-2">
                                  <div class="col-3">
                                    <span class="largeText">Voucher Number : </span>
                                  </div>
                                  <div class="col-4">
                                    <span class="largeText" id="pvNumber"></span>
                                  </div>
                                  <div class="col-5">
                                    <span class="largeText">Date : </span><span class="largeText" id="pvDate"></span>
                                  </div>
                                </div>
                                <div class="row m-2">
                                  <div class="col-3">
                                    <span class="largeText">Bill Details : </span>
                                  </div>
                                  <div class="col-4">
                                    <span class="largeText" id="billNo"></span>
                                    <span class="largeText"> Dated : </span>
                                    <span class="largeText" id="billDate"></span>
                                  </div>
                                  <div class="col-5">
                                    <span class="largeText"> Amount : </span>
                                    <span class="largeText" id="billAmount"></span>
                                  </div>
                                </div>
                                <div class="row m-2">
                                  <div class="col-3">
                                    <span class="largeText">Payee Name : </span>
                                  </div>
                                  <div class="col-4">
                                    <span class="largeText" id="payeeName"></span>
                                  </div>
                                  <div class="col-5">
                                    <span class="largeText">Mobile : </span>
                                    <span class="largeText" id="payeeMobile"></span>
                                  </div>
                                </div>
                                <div class="row m-2">
                                  <div class="col-12">
                                    <span class="largeText">Through : </span>
                                    <span class="largeText" id="pvMode" style="text-decoration: underline;"></span>
                                    <span class="largeText"> on Account of: </span>
                                    <span class="largeText" id="pvHead" style="text-decoration: underline;"></span>
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
                                <div class="border mt-0 mb-2" style="color: black;">
                                  &#8377; <span class="largeText" id="pvAmount"></span>
                                </div>
                              </td>
                              <td>
                                <span class="largeText" id="pvAmountWord"></span>
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
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-trans" role="tabpanel" aria-labelledby="list-trans-list">
            <div class="row">
              <div class="col-10">
                <div class="container card mt-2 myCard">
                  <div class="row">
                    <div class="col-12">
                      <div class="row">
                        <div class="col">
                          <div class="form-group">
                            <label>Payment From</label>
                            <input type="date" class="form-control form-control-sm" id="pv_from" name="pv_from" value="<?php echo $submit_date; ?>">
                          </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                            <label>Payment To</label>
                            <input type="date" class="form-control form-control-sm" id="pv_to" name="pv_to" value="<?php echo $submit_date; ?>">
                          </div>
                        </div>
                        <div class="col mt-3">
                          <div class="form-group">
                            <button class="btn btn-sm" id="showPayment">Show Payement</button>
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
                    <th class="text-center">Voucher Date</th>
                    <th class="text-center">ID</th>
                    <th class="text-center">Payee</th>
                    <th class="text-center">Mobile</th>
                    <th class="text-center">Head</th>
                    <th class="text-center">Mode</th>
                    <th class="text-center">Amount</th>
                    <th class="text-center">TransId</th>
                    <th class="text-center">TransDate</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">StaffId</th>
                  </table>
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
    paymentHead();
    feeMode();

    $(document).on("click", "#pvDailyPill", function() {
      // $.alert("Daily ");
      $.post("<?php echo $phpFile; ?>", {
        action: "pvDaily"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        // console.log(data);
        var card = '';
        var count = 1;
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td class="text-center">' + count++ + '</td>';
          card += '<td class="text-center">' + value.update_ts + '</td>';
          card += '<td class="text-center">' + value.pv_id + '</td>';
          card += '<td>' + value.payee_name + '</td>';
          card += '<td>' + value.payee_mobile + '</td>';
          card += '<td class="text-center">' + value.pv_head + '</td>';
          card += '<td class="text-center">' + value.pv_mode + '</td>';
          card += '<td class="text-center">' + value.pv_amount + '</td>';
          if (value.transaction_id == null) card += '<td class="text-center">--</td>';
          else card += '<td class="text-center">' + value.transaction_id + '</td>';
          card += '<td class="text-center">' + value.transaction_date + '</td>';
          card += '<td class="text-center">' + value.pv_type + '</td>';
          card += '<td class="text-center">' + value.staff_id + '</td>';
          card += '<td class="text-center"><a href="#" class="showVoucher" data-pv="' + value.pv_id + '"><i class="fas fa-eye"></i></a></td>';
          card += '</tr>';
        });
        $("#dailyVoucher").find("tr:gt(0)").remove();
        $("#dailyVoucher").append(card);

      }).fail(function() {
        $.alert("Error !!");
      })
    });

    $(document).on("click", ".showVoucher", function() {
      var pv_id = $(this).attr("data-pv");
      // $.alert("Fr Id " + pv_id );
      $.post("<?php echo $phpFile; ?> ", {
        pv_id: pv_id,
        action: "fetchVoucher"
      }, () => {}, "json").done(function(data, status) {
        // $.alert(data.fr_id);
        // console.log(data)
        $('#pvNumber').html(data.pv_id)
        $("#pvDate").html(getFormattedDate(data.update_ts, "dmY"));
        $("#pvMode").html(data.pv_mode);
        $("#pvHead").html(data.pv_head);
        $("#pvType").html(data.pv_type);
        $('#billNo').html(data.bill_no)
        $('#billDate').html(data.bill_date)
        $('#billAmount').html(data.bill_amount)

        $('#payeeName').html(data.payee_name)
        $('#payeeMobile').html(data.payee_mobile)

        $("#transactionId").html(data.transaction_id);
        $("#transactionDate").html(getFormattedDate(data.transaction_date, "dmY"));
        $("#pvAmount").text(data.pv_amount + '/-');
        $("#pvAmountWord").text(numberToWords(parseInt(data.pv_amount)) + ' only');
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('submit', '#pvForm', function(event) {
      event.preventDefault(this);
      // $.alert("Name");
      var error = "NO";
      var error_msg = "";
      if ($('#pv_amount').val() < "1") {
        error = "YES";
        error_msg = "Payment Amount is Missing!! .";
      }
      if (error == "NO") {
        var formData = $(this).serialize();
        // $.alert(formData)
        $.confirm({
          title: 'Please Confirm !',
          draggable: true,
          content: "<b><i>Are you Sure to Make payement ? </i></b>",
          buttons: {
            confirm: {
              btnClass: 'btn-info',
              action: function() {
                $.post("paymentSql.php", formData, function() {}, "text").done(function(data, status) {
                  $.alert(data);

                }).fail(function() {
                  $.alert("Payment Voucher could not be added!!")
                });
              }
            },
            cancel: {
              btnClass: "btn-danger",
              action: function() {}
            },
          }
        });
      } else {
        $.alert(error_msg);
      }
    });

    $(document).on("click", "#showPayment", function() {
      var dateFrom = $("#pv_from").val();
      var dateTo = $("#pv_to").val();
      $.alert("From " + dateFrom + "To " + dateTo);
      $.post("<?php echo $phpFile; ?>", {
        dateFrom: dateFrom,
        dateTo: dateTo,
        action: "paymentList"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        // console.log(data);
        var card = '';
        var count = 1;
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td class="text-center">' + count++ + '</td>';
          card += '<td class="text-center">' + value.update_ts + '</td>';
          card += '<td class="text-center">' + value.pv_id + '</td>';
          card += '<td>' + value.payee_name + '</td>';
          card += '<td>' + value.payee_mobile + '</td>';
          card += '<td class="text-center">' + value.pv_head + '</td>';
          card += '<td class="text-center">' + value.pv_mode + '</td>';
          card += '<td class="text-center">' + value.pv_amount + '</td>';
          if (value.transaction_id == null) card += '<td class="text-center">--</td>';
          else card += '<td class="text-center">' + value.transaction_id + '</td>';
          card += '<td class="text-center">' + value.transaction_date + '</td>';
          card += '<td class="text-center">' + value.pv_type + '</td>';
          card += '<td class="text-center">' + value.staff_id + '</td>';
          card += '</tr>';
        });
        $("#transactionList").find("tr:gt(0)").remove();
        $("#transactionList").append(card);

      }).fail(function() {
        $.alert("Error !!");
      })
    });

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

    function feeReceiptList() {
      // $.alert("Batch");
      var studentId = $("#studentIdHidden").val();
      $.post("<?php echo $phpFile; ?> ", {
        action: "feeReceiptList",
        id: studentId,
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        // console.log(data);
        var card = '';
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td class="text-center">' + value.fr_id + '</td>';
          card += '<td class="text-center">' + value.fee_mode + '</td>';
          card += '<td class="text-center">' + value.pv_type + '</td>';
          card += '<td class="text-center">' + value.fr_amount + '</td>';
          if (value.fr_desc == null) card += '<td class="text-center">--</td>';
          else card += '<td class="text-center">' + value.fr_desc + '</td>';
          card += '<td class="text-center">' + value.user_id + '</td>';
          card += '<td class="text-center"><a href="#" class="showReceipt" data-fr="' + value.fr_id + '"><i class="fas fa-eye"></i></a></td>';
          card += '</tr>';
        });
        $("#feeReceiptList").find("tr:gt(0)").remove();
        $("#feeReceiptList").append(card);

      }).fail(function() {
        $.alert("Error !!");
      })

    }

    function paymentHead() {
      // $.alert("Department ");
      $.post("<?php echo $phpFile; ?> ", {
        action: "paymentHead"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var list = '';
        list += '<select class="form-control form-control-sm" name="pv_head" id="pv_head" required>';
        $.each(data, function(key, value) {
          list += '<option value=' + value.mn_id + '>' + value.mn_name + '</option>';
        });
        list += '</select>';
        $("#paymentHead").html(list);

      }).fail(function() {
        $.alert("No Data Found - Payment Head !!");
      })
    }

    function feeMode() {
      // $.alert("Department ");
      $.post("<?php echo $phpFile; ?> ", {
        action: "feeMode"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var list = '';
        list += '<select class="form-control form-control-sm" name="pv_mode" id="pv_mode" required>';
        $.each(data, function(key, value) {
          list += '<option value=' + value.mn_id + '>' + value.mn_name + '</option>';
        });
        list += '</select>';
        $("#feeMode").html(list);

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