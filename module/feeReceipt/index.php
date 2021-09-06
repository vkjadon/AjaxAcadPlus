<?php
require('../requireSubModule.php');
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
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action fr" id="list-fr-list" data-toggle="list" href="#list-fr" role="tab" aria-controls="fr">Fee Receipt</a>
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
                      <div class="col-3 m-0 p-0">
                        <label>Name</label>
                      </div>
                      <div class="col-9 text-secondary ">
                        <span class="student_name">No Student Found</span>[<span class="student_rollno">000000</span>]
                      </div>
                    </div>
                    <div class="row p-1">
                      <div class="col-3 m-0 p-0">
                        <label>Mobile</label>
                      </div>
                      <div class="col-9 text-secondary student_mobile">
                        Enter Valid Data
                      </div>
                    </div>
                    <div class="row p-1">
                      <div class="col-3 m-0 p-0">
                        <label>Program</label>
                      </div>
                      <div class="col-6 text-secondary student_program">
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
              <div class="col-6">
                <div class="container card mt-2 myCard">
                  <!-- nav options -->
                  <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="pills_tablePersonalInfo" data-toggle="pill" href="#pills_personalInfo" role="tab" aria-controls="pills_personalInfo" aria-selected="true">Fee Transaction</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="pill" href="#feeReceipt" role="tab" aria-controls="feeReceipt" aria-selected="true">Fee Receipt</a>
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
                                <p id="feeMode"></p>
                              </div>
                            </div>
                            <div class="col-3 pl-1 pr-0">
                              <div class="form-group">
                                <label>Semester</label>
                                <input type="number" class="form-control form-control-sm" id="semester" min="1" name="semester" placeholder="Semester" value="1">
                              </div>
                            </div>
                            <div class="col-3 pl-1">
                              <div class="form-group">
                                <label>Receipt Date</label>
                                <input type="date" class="form-control form-control-sm" id="fr_date" min="1" name="semester" value=<?php echo $submit_date; ?>>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-4 pr-1">
                              <div class="form-group">
                                <label>Amount</label>
                                <input type="number" class="form-control form-control-sm" id="feeAmount" name="feeAmount" placeholder="" data-tag="fr_amount">
                              </div>
                            </div>
                            <div class="col-4 pr-1 pl-1">
                              <div class="form-group">
                                <label>Transaction ID</label>
                                <input type="number" class="form-control form-control-sm" id="tId" name="tId" placeholder="Transaction ID" data-tag="transaction_id">
                              </div>
                            </div>
                            <div class="col-4 pl-1">
                              <div class="form-group">
                                <label>Transaction Date</label>
                                <input type="date" class="form-control form-control-sm" id="transaction_date" name="transaction_date" placeholder="" data-tag="transaction_date">
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
                    <div class="tab-pane fade" id="feeReceipt" role="tabpanel" aria-labelledby="feeReceipt">
                      <div class="row">
                        <div class="col-12" id="page1">
                          <div class="float-right"><a onclick="printDiv('page1')" class="fa fa-print"></a></div>
                          <div class="row">
                            <div class="col-12 text-center">
                              <h2>Aryans College of Engineering</h2>
                              <span class="smallText">Vill. Nepra/Thua, Chandigarh - Patiala Highway, Near Chandigarh</span>
                            </div>
                          </div>
                          <hr>
                          <div class="row">
                            <div class="col-12 text-center">
                              <h4>Payment Receipt</h4>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-3">
                              <label for="receiptNumber">Receipt Number : </label>
                            </div>
                            <div class="col-3">
                              <span id="receiptNumber"></span>
                            </div>
                            <div class="col-3">
                              <label for="receiptDate">Date : </label><span id="receiptDate"></span>
                            </div>
                            <div class="col-3">
                              <label for="receiptDate">Time : </label><span id="receiptTime"></span>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-3">
                              <label for="receiptName">Received From : </label>
                            </div>
                            <div class="col-9">
                              <span class="smallText" style="text-decoration: underline;" id="receiptName"></span>
                              &nbsp; s/o &nbsp;<span class="smallText" style="text-decoration: underline;" id="receiptFatherName"></span>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-3">
                              <label for="receiptCourse">Programme/Course : </label>
                            </div>
                            <div class="col-3">
                              <span class="smallText" id="receiptCourse"></span>
                            </div>
                            <div class="col-3">
                              <label for="receiptBatch">Batch : </label>
                              <span class="smallText" id="receiptBatch"></span>
                            </div>
                            <div class="col-3">
                              <label for="receiptSemester">Semester : </label>
                              <span class="smallText" id="receiptSemester"></span>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-3">
                              <label for="receiptRollNumber">Uni Roll Number : </label>
                            </div>
                            <div class="col-3">
                              <p id="receiptRollNumber"></p>
                            </div>
                            <div class="col-3">
                              <label for="receiptUserId">ID/Reg No : </label>
                              <span id="receiptUserId"></span>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-12">
                              <label for="receiptMode">Through : </label>
                              <span id="receiptMode"></span>
                              <label for="receiptType">On Account of:</label>
                              <span id="receiptType"></span>
                              <label for="transactionId"> with transaction Id : </label>
                              <span id="transactionId"></span>
                              <label for="transactionDate"> dated : </label>
                              <span id="transactionDate"></span>
                            </div>
                          </div>
                          <hr>
                          <div class="row mt-2">
                            <div class="col-12">
                              <label for="receiptRemarks">Remarks : </label>
                              <p id="receiptRemarks"></p>
                            </div>
                          </div>
                          <hr>
                          <div class="row mt-2">
                            <div class="col-3 border ml-3">
                              &#8377; <span id="receiptAmount"></span>
                            </div>
                            <div class="col-sm-6">
                              <span id="receiptAmountWord"></span>
                            </div>
                            <div class="col-sm-2">
                              <label id="receiptSign">Signature</label>
                            </div>
                          </div>
                        </div> <!-- Modal Body Closed-->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="container card mt-2 myCard" id="print" style="overflow: scroll;">
                  <table class="table table-bordered table-striped list-table-xs mt-3" id="feeReceiptList">
                    <th class="text-center">ID</th>
                    <th class="text-center">Mode</th>
                    <th class="text-center">Fee Type</th>
                    <th class="text-center">Amount</th>
                    <th class="text-center"><i class="fa fa-eye"></i></th>
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

    feeType();
    feeMode();
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

        $(".student_name").text(data.student_name);
        $(".student_rollno").text(data.student_rollno);
        $(".student_mobile").text(data.student_mobile);
        $(".student_batch").text(data.batch);
        $(".student_program").text(data.program_name);
        $("#studentIdHidden").val(data.student_id);
        $("#receiptFatherName").text(data.student_fname);
        
        
        feeReceiptList();
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
        $(".student_name").text(data.student_name);
        $(".student_rollno").text(data.student_rollno);
        $(".student_mobile").text(data.student_mobile);
        $(".student_batch").text(data.batch);
        $(".student_program").text(data.program_name);
        $("#studentIdHidden").val(data.student_id);
        feeReceiptList();
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on("click", ".trashTask", function() {
      var atask_id = $(this).attr("data-task");
      $.alert(' atask ' + atask_id);
      $.confirm({
        title: 'Please Confirm!',
        draggable: true,
        content: "<b><i>The Selected Task will be removed !!</i></b>",
        buttons: {
          confirm: {
            btnClass: 'btn-info',
            action: function() {
              $.post("coaSql.php", {
                atask_id: atask_id,
                action: "deleteTask"
              }, () => {}, "text").done(function(data, status) {
                // $.alert(data);
              })
              talkList()
            }
          },
          cancel: {
            btnClass: "btn-danger",
            action: function() {}
          },
        }
      });
    });

    $(document).on('click', '#addFeeReceipt', function(event) {
      var studentId = $("#studentIdHidden").val();
      if (studentId > 0) {
        var feeType = $("#sel_ft").val();
        var feeMode = $("#sel_fm").val();
        var sem = $("#semester").val();
        var feeAmount = $("#feeAmount").val();
        var tId = $("#tId").val();
        var feeDesc = $("#fee_desc").val();
        var transaction_date = $("#transaction_date").val();
        var fr_date = $("#fr_date").val();
        // $.alert(feeAmount);
        $.post("feeReceiptSql.php", {
          id: studentId,
          feeType: feeType,
          feeMode: feeMode,
          sem: sem,
          feeAmount: feeAmount,
          tId: tId,
          feeDesc: feeDesc,
          fr_date: fr_date,
          transaction_date: transaction_date,
          action: "addFeeReceipt"
        }, function(data) {
          $.alert(data);
          feeReceiptList();
        }, "text").fail(function() {
          $.alert("fail in place of error");
        })
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
          card += '<tr>';
          card += '<td class="text-center">' + value.fr_id + '</td>';
          card += '<td class="text-center">' + value.fee_mode + '</td>';
          card += '<td class="text-center">' + value.fee_type + '</td>';
          card += '<td class="text-center">' + value.fr_amount + '</td>';
          card += '<td class="text-center"><a href="#" class="showReceipt" data-fr="' + value.fr_id + '"><i class="fas fa-eye"></i></a></td>';
          card += '</tr>';
        });
        $("#feeReceiptList").find("tr:gt(0)").remove();
        $("#feeReceiptList").append(card);

      }).fail(function() {
        $.alert("Error !!");
      })

    }

    $(document).on("click", ".showReceipt", function() {
      var fr_id = $(this).attr("data-fr");
      // $.alert("Fr Id " + fr_id + $("#studentSearch").val());
      $.post("feeReceiptSql.php", {
        frId: fr_id,
        action: "fetchReceipt"
      }, () => {}, "json").done(function(data, status) {
        // $.alert(data.fr_id);
        // console.log(data)
        $('#receiptNumber').html(data.fr_id)
        $("#receiptDate").html(getFormattedDate(data.fr_date, "dmY"));
        $("#receiptTime").html(getTime(data.update_ts, "dmY"));
        $("#receiptName").text($(".student_name").text());
        $("#receiptCourse").text($(".student_program").text());
        $("#receiptBatch").text($(".student_batch").text());
        $("#receiptSemester").html(data.fee_semester);
        $("#receiptMode").html(data.fee_mode);
        $("#receiptType").html(data.fee_type);
        $("#receiptUserId").text($("#studentSearch").val());
        $("#transactionId").html(data.transaction_id);
        $("#transactionDate").html(data.transaction_date);
        $("#receiptAmount").text(data.fr_amount + '/-');
        $("#receiptAmountWord").text(numberToWords(parseInt(data.fr_amount)) + ' only');
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

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
        $("#feeType").html(list);

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
    $.alert("In print");
    var backup = document.body.innerHTML;
    var divContent = document.getElementById(print).innerHTML;
    document.body.innerHTML = divContent;
    window.print();
    document.body.innerHTML = backup;
  }
</script>

</html>