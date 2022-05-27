<?php
require('../requireSubModule.php');
$phpFile = "salarySql.php";
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
      <div class="col-1 p-0 m-0 full-height">
        <div class="mt-3">
          <h5 class="pr-2"> Salary </h5>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active ds" id="list-ds-list" data-toggle="list" href="#list-ds" role="tab" aria-controls="ds">Disburse Salary</a>
        </div>
      </div>
      <div class="col-11 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <div class="row">
            <div class="col-md-2 pr-0">
              <div class="card border-info">
                <div class="card-body text-primary">
                  <div class="row">
                    <div class="col-9 pr-0">
                      <input name="staffSearch" id="staffSearch" class="form-control form-control-sm" type="text" placeholder="Search User" aria-label="Search">
                    </div>
                    <div class="col-3 pl-1">
                      <button type="button" class="btn btn-block btn-sm" id="searchStaff"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-2 pl-1 pr-0">
              <div class="card border-info">
                <div class="card-body text-primary">
                  <input name="staffNameSearch" id="staffNameSearch" class="form-control form-control-sm" type="text" placeholder="Search Staff" aria-label="Search">
                  <div class='list-group' id="staffAutoList"></div>
                </div>
              </div>
            </div>
            <div class="col-md-8 pl-1 staff_detail">
              <div class="container card myCard border-info">
                <div class="row p-1">
                  <div class="col-2 m-0 p-0 staffImage">
                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="38%">
                  </div>
                  <div class="col-10 smallerText">
                    <div class="row mt-1 p-0">
                      <div class="col-3 m-0 p-0">
                        <span class="staff_name">Not Found</span>
                      </div>
                      <div class="col-3 p-0 user_id">--</div>
                      <div class="col-3 p-0 staff_id">--</div>
                      <div class="col-3 p-0 staff_fname">--</div>
                    </div>
                    <div class="row p-0">
                      <div class="col-3 p-0 staff_mobile">--</div>
                      <div class="col-3 p-0 staff_email">--</div>
                      <div class="col-3 p-0 staff_dob">--</div>
                      <div class="col-3 p-0 staff_doj">--</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane show active" id="list-ds" role="tabpanel" aria-labelledby="list-ds-list">
            <div class="row">
              <div class="col-md-12">
                <div class="card mt-2 p-3 myCard">
                  <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active currentOnRollStaff" data-toggle="pill" href="#currentOnRollStaff" role="tab" aria-controls="currentOnRollStaff" aria-selected="true">On Roll Staff</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link monthlySalary" data-toggle="pill" href="#monthlySalary" role="tab" aria-controls="monthlySalary" aria-selected="true">Monthly Salary</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="pill" href="#salary" role="tab" aria-controls="salary" aria-selected="true">Salary</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="pills-tabContent p-3">
                    <div class="mt-2 p-3 myCard">
                      <form class="form-horizontal" id="monthlySalaryForm">
                        <div class="row">
                          <div class="col-sm-1 pr-1">
                            <div class="form-group">
                              <label>Month </label>
                              <select class="form-control form-control-sm" name="salaryMonth" id="salaryMonth" required>';
                                <option value="<?php echo date("n"); ?>"><?php echo date("M"); ?></option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-1 pl-0 pr-1">
                            <div class="form-group">
                              <label>Year</label>
                              <input type="number" class="form-control form-control-sm" id="salaryYear" name="salaryYear" min="2015" max="2030" value="<?php echo date("Y"); ?>">
                            </div>
                          </div>
                          <div class="col-sm-1 pl-0 pr-1">
                            <div class="form-group">
                              <label>Month Days</label>
                              <input type="number" class="form-control form-control-sm" id="monthDaysDis" disabled>
                              <input type="hidden" id="monthDays" name="monthDays">
                            </div>
                          </div>
                          <div class="col-sm-1 pl-0 pr-1">
                            <div class="form-group">
                              <label>FinYear</label>
                              <input type="text" disabled class="form-control form-control-sm" id="finYearDis">
                              <input type="hidden" id="finYear" name="finYear">
                            </div>
                          </div>
                          <div class="col-sm-6 pl-0 pr-1">
                            <div class="form-group">
                              <label>Remarks</label>
                              <input type="text" class="form-control form-control-sm" id="monthlySalaryRemarks" name="monthlySalaryRemarks">
                            </div>
                          </div>
                          <div class="col-sm-1 pl-0 pr-1 mt-4">
                            <div class="form-group">
                              <input type="hidden" name="action" value="currentOnRollStaff">
                              <input type="submit" class="btn btn-sm btn-block" value="Process">
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="tab-pane show active" id="currentOnRollStaff" role="tabpanel" aria-labelledby="currentOnRollStaff">

                      <table class="table table-bordered table-striped list-table-xs mt-3" id="currentOnRollList">
                        <th class="text-center">SNo</th>
                        <th class="text-center">UserId</th>
                        <th class="text-center">Staff</th>
                        <th class="text-center">Department</th>
                        <th class="text-center">Mobile</th>
                        <th class="text-center">Salary</th>
                        <th class="text-center">Deduction</th>
                        <th class="text-center">Payable</th>
                      </table>
                    </div>
                    <div class="tab-pane fade" id="monthlySalary" role="tabpanel" aria-labelledby="monthlySalary">
                      <table class="table table-bordered table-striped list-table-xs mt-3" id="monthlySalaryList">
                        <th class="text-center">SNo</th>
                        <th class="text-center">UserId</th>
                        <th class="text-center">Staff</th>
                        <th class="text-center">Department</th>
                        <th class="text-center">Mobile</th>
                        <th class="text-center">Salary</th>
                        <th class="text-center">Deduction</th>
                        <th class="text-center">LWP</th>
                        <th class="text-center">Payable</th>
                        <th class="text-center">Bank</th>
                        <th class="text-center">Account Number</th>
                        <th class="text-center">IFSC Code</th>
                        <th class="text-center">Update Salary</th>
                      </table>
                    </div>
                    <div class="tab-pane fade" id="salary" role="tabpanel" aria-labelledby="salary">
                      <input type="hidden" id="staffIdHidden" name="staffIdHidden" value="0">
                      <div class="row">
                        <div class="col-6 pr-0">
                          <div class="form-group">
                            <label>Components</label>
                            <p id="salaryComponents"></p>
                          </div>
                        </div>
                        <div class="col-6 pl-1">
                          <div class="form-group">
                            <label>Deduction</label>
                            <p id="salaryDeductions"></p>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Remarks</label>
                        <textarea class="form-control form-control-sm" id="salaryRemarks" name="salaryRemarks" rows="2"></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-support" role="tabpanel" aria-labelledby="list-support-list">
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

    var month = $('#salaryMonth').val()
    var year = $('#salaryYear').val()

    getDaysInMonth(month, year)

    $(document).on('change', '#salaryMonth, #salaryYear', function() {
      var month = $('#salaryMonth').val()
      var year = $('#salaryYear').val()
      getDaysInMonth(month, year)
    });

    $(document).on('submit', '#monthlySalaryForm', function(event) {
      event.preventDefault(this);
      // $.alert("Form Submitted ");
      var formData = $(this).serialize();
      // $.alert(formData);
      $.post("salarySql.php", formData, () => {}, "json").done(function(data, status) {
        // $.alert(data);
        console.log(data);
        var card = '';
        var count = 1;
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td class="text-center">' + count++ + '</td>';
          card += '<td>' + value.user_id + '</td>';
          card += '<td>' + value.staff_name + '</td>';
          card += '<td>--</td>';
          card += '<td>' + value.staff_mobile + '</td>';
          card += '<td>' + value.ss + '</td>';
          card += '<td>' + value.ssd + '</td>';
          card += '<td>' + value.ss_payable + '</td>';
          card += '</tr>';
        });
        $("#currentOnRollList").find("tr:gt(0)").remove();
        $("#currentOnRollList").append(card);
        // $.alert("Updated Data" + mydata);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.monthlySalary', function(event) {
      var salaryMonth = $('#salaryMonth').val()
      var salaryYear = $('#salaryYear').val()
      var monthDays = $("#monthDays").val()
      var finYear = $("#finYear").val()
      // $.alert(salaryMonth + salaryYear + monthDays + finYear);

      $.post("salarySql.php", {
        salaryMonth: salaryMonth,
        salaryYear: salaryYear,
        monthDays: monthDays,
        finYear: finYear,
        action: "monthlySalary"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        console.log(data);
        var card = '';
        var count = 1;
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td class="text-center">' + count++ + '</td>';
          card += '<td>' + value.user_id + '</td>';
          card += '<td>' + value.staff_name + '</td>';
          card += '<td>--</td>';
          card += '<td>' + value.staff_mobile + '</td>';
          card += '<td>' + value.ssal_salary + '</td>';
          card += '<td>' + value.ssal_deduction + '</td>';
          var netSalary = parseInt(value.ssal_salary) - parseInt(value.ssal_deduction)
          card += '<td width="6%"><input type="number" class="form-control form-control-sm lwp" data-id="' + value.user_id + '" data-sss="' + value.sss_id + '" data-net="' + netSalary + '" name="lwp" value="' + value.ssal_lwp + '"></td>';
          card += '<td><span class="' + value.user_id + '">' + value.ssal_payable + '</span></td>';
          card += '<td>' + value.staff_bank + '</td>';
          card += '<td>' + value.staff_account + '</td>';
          card += '<td>' + value.staff_ifsc + '</td>';
          card += '<td><a href="#" class="approve addToSalary" data-sss="' + value.sss_id + '" data-id="' + value.user_id + '">Update Salary</a></td>';
          card += '</tr>';
        });
        $("#monthlySalaryList").find("tr:gt(0)").remove();
        $("#monthlySalaryList").append(card);
        // $.alert("Updated Data" + mydata);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.addToSalary', function() {
      var user_id = $(this).attr("data-id")
      var sss_id = $(this).attr("data-sss")
      $.alert(" Staff " + user_id + " sss " + sss_id);
      $.post("salarySql.php", {
        user_id: user_id,
        sss_id: sss_id,
        action: "addToSalary"
      }, function() {}, "text").done(function(data, status) {
        // $.alert(data);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('change', '.lwp', function() {
      var user_id = $(this).attr("data-id")
      var sss_id = $(this).attr("data-sss")
      var net = $(this).attr("data-net")
      var lwp = $(this).val()
      var monthDays = $("#monthDays").val()
      var finYear = $("#finYear").val()

      var payable = Math.ceil((net / monthDays) * (monthDays - lwp))
      $("." + user_id).html(payable)

      // $.alert(" lwp " + lwp + " monthDays " + monthDays + " SSS " + sss_id + " net " + net + " payable " + payable);
      $.post("salarySql.php", {
        user_id: user_id,
        lwp: lwp,
        net: net,
        sss_id: sss_id,
        monthDays: monthDays,
        finYear: finYear,
        action: "lwpUpdate"
      }, function() {}, "text").done(function(data, status) {
        // $.alert(data);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });
    $(document).on('blur', '.salaryUpdateForm', function() {
      var staff_id = $("#staffIdHidden").val();
      if (staff_id > 0) {
        var mn_id = $(this).attr("data-id")
        var tag = $(this).attr("data-tag")
        var value = $(this).val()
        // $.alert("Tag " + tag + " Value " + value + " Staff " + staff_id + " mn_id " + mn_id);
        $.post("salarySql.php", {
          userId: staff_id,
          mn_id: mn_id,
          tag: tag,
          value: value,
          action: "staffSalary"
        }, function() {}, "text").done(function(data, status) {
          // $.alert(data);
        }).fail(function() {
          $.alert("fail in place of error");
        })
      } else $.alert("Please select a Staff !!")
    });

    $(document).on('blur', '.salaryUpdateForm', function() {
      var staff_id = $("#staffIdHidden").val();
      if (staff_id > 0) {
        var mn_id = $(this).attr("data-id")
        var tag = $(this).attr("data-tag")
        var value = $(this).val()
        // $.alert("Tag " + tag + " Value " + value + " Staff " + staff_id + " mn_id " + mn_id);
        $.post("salarySql.php", {
          userId: staff_id,
          mn_id: mn_id,
          tag: tag,
          value: value,
          action: "staffSalary"
        }, function() {}, "text").done(function(data, status) {
          // $.alert(data);
        }).fail(function() {
          $.alert("fail in place of error");
        })
      } else $.alert("Please select a Staff !!")
    });
    $(document).on('blur', '.salaryDeductionForm', function() {
      var staff_id = $("#staffIdHidden").val();
      if (staff_id > 0) {
        var mn_id = $(this).attr("data-id")
        var tag = $(this).attr("data-tag")
        var value = $(this).val()
        // $.alert("Tag " + tag + " Value " + value + " Staff " + staff_id + " mn_id " + mn_id);
        $.post("salarySql.php", {
          userId: staff_id,
          mn_id: mn_id,
          tag: tag,
          value: value,
          action: "staffSalaryDeduction"
        }, function() {}, "text").done(function(data, status) {
          $.alert(data);
        }).fail(function() {
          $.alert("fail in place of error");
        })
      } else $.alert("Please select a Staff !!")
    });
    $('#staffNameSearch').keyup(function() {
      var query = $(this).val();
      // $.alert(query);
      if (query != '') {
        $.ajax({
          url: "salarySql.php",
          method: "POST",
          data: {
            query: query
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

    $(document).on('click', '.autoList', function() {
      $('#staffNameSearch').val($(this).text());
      var staffId = $(this).attr("data-std");
      $('#staffAutoList').fadeOut();
      // $.alert(staffId);
      $.post("salarySql.php", {
        userId: staffId,
        action: "fetchStaffAutoList"
      }, () => {}, "json").done(function(data, status) {
        // $.alert(data)
        $(".staff_id").text(data.staff_id);
        $(".staff_name").text(data.staff_name);
        $(".user_id").text(data.user_id);
        $(".staff_mobile").text(data.staff_mobile);
        $("#staffIdHidden").val(data.staff_id);
        $("#staffSearch").val(data.user_id)
        salaryComponents(staffId);
        salaryDeductions(staffId);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    function salaryComponents(id) {
      // $.alert("Department ");
      $.post("salarySql.php", {
        userId: id,
        action: "salaryComponents"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var list = '';
        var totalSalary = 0;
        $.each(data, function(key, value) {
          list += '<div class="row m-1"><div class="col-md-5">' + value.mn_name + '</div>';
          if (value.mn_type == 1) list += '<div class="col-md-3">%<input type="radio" checked="checked" class="salaryUpdateForm" name="' + value.mn_id + '" data-tag="mn_type" data-id="' + value.mn_id + '" value="1">Yes';
          else list += '<div class="col-md-3">%<input type="radio" class="salaryUpdateForm" name="' + value.mn_id + '" data-tag="mn_type" data-id="' + value.mn_id + '" value="1">Yes';
          if (value.mn_type == 0) list += '<input type="radio" checked="checked" class="salaryUpdateForm" name="' + value.mn_id + '" data-tag="mn_type" data-id="' + value.mn_id + '" value="0">No</div>';
          else list += '<input type="radio" class="salaryUpdateForm" name="' + value.mn_id + '" data-tag="mn_type" data-id="' + value.mn_id + '" value="0">No</div>';
          list += '<div class="col-md-4"><input type="number" class="form-control form-control-sm salaryUpdateForm" data-tag="ss_value" data-id="' + value.mn_id + '" value="' + value.ss_value + '"></div>';
          list += '</div>';
          totalSalary = parseInt(totalSalary) + parseInt(value.ss_value)
        });
        list += '<h4>Total Salary ' + totalSalary + '</h4>';
        $("#salaryComponents").html(list);
      }).fail(function() {
        $.alert("Error !!");
      })
    }

    function salaryDeductions(id) {
      // $.alert("Department ");
      $.post("salarySql.php", {
        userId: id,
        action: "salaryDeductions"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var list = '';
        var totalDeduction = 0;

        $.each(data, function(key, value) {
          list += '<div class="row m-1"><div class="col-md-5">' + value.mn_name + '</div>';
          if (value.mn_type == 1) list += '<div class="col-md-3">%<input type="radio" checked="checked" class="salaryDeductionForm" name="' + value.mn_id + '" data-tag="mn_type" data-id="' + value.mn_id + '" value="1">Yes';
          else list += '<div class="col-md-3">%<input type="radio" class="salaryDeductionForm" name="' + value.mn_id + '" data-tag="mn_type" data-id="' + value.mn_id + '" value="1">Yes';
          if (value.mn_type == 0) list += '<input type="radio" checked="checked" class="salaryDeductionForm" name="' + value.mn_id + '" data-tag="mn_type" data-id="' + value.mn_id + '" value="0">No</div>';
          else list += '<input type="radio" class="salaryDeductionForm" name="' + value.mn_id + '" data-tag="mn_type" data-id="' + value.mn_id + '" value="0">No</div>';
          list += '<div class="col-md-4"><input type="number" class="form-control form-control-sm salaryDeductionForm" data-tag="ss_value" data-id="' + value.mn_id + '" value="' + parseInt(value.ss_value) + '"></div>';
          list += '</div>';
          totalDeduction = parseInt(totalDeduction) + parseInt(value.ss_value)

        });
        list += '<h4>Total Deduction ' + totalDeduction + '</h4>';

        $("#salaryDeductions").html(list);
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

    function getDaysInMonth(month, year) {
      // Here January is 1 based
      //Day 0 is the last day in the previous month
      var days = new Date(year, month, 0).getDate();
      $("#monthDaysDis").val(days)
      $("#monthDays").val(days)
      if (month > 3) {
        var next = parseInt(year) - 1999
        var finYear = year + '_' + next
      } else {
        var first = parseInt(year) - 1
        var next = parseInt(year) - 2000
        var finYear = first + '_' + next
      }
      $("#finYearDis").val(finYear)
      $("#finYear").val(finYear)

      // alert("days " + days)
    };

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
</script>

</html>