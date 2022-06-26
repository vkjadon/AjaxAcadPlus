<?php
require('../requireSubModule.php');
$phpFile = "accountsSql.php";
addActivity($conn, $myId, "Accounts", $submit_ts);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Outcome Based Education : ClassConnect</title>
  <?php require("../css.php"); ?>
</head>

<body>
<?php require("../topBar.php"); 
	if($myId>3){
    if (!isset($_GET['tag'])) die("Illegal Attempt !! The token is Missing");
    elseif (!in_array($_GET['tag'], $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
    elseif (!in_array("47", $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
  }
	?> 
  <input type="hidden" id="studentIdHidden" name="studentIdHidden">
  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-1 p-0 m-0 full-height">
        <div class="mt-3">
          <h5 class=" text-center pr-2"> Receipt </h5>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active feeConcession" id="list-feeConcession-list" data-toggle="list" href="#feeConcession" role="tab" aria-controls="trans"> Dues/Concession</a>
          <a class="list-group-item list-group-item-action reverse" data-toggle="list" href="#reverse" role="tab" aria-controls="trans"> Reverse Entry</a>
          <a class="list-group-item list-group-item-action rer" data-toggle="list" href="#rer" role="tab" aria-controls="trans"> Reverse Entry Reports</a>
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
                <div class="card-body text-primary">
                  <input name="studentNameSearch" id="studentNameSearch" class="form-control form-control-sm" type="text" placeholder="Search Student" aria-label="Search">
                  <div class='list-group' id="studentAutoList"></div>
                </div>
              </div>
            </div>
            <div class="col-md-2 pl-1 pr-0">
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
            <div class="col-md-2 pl-1 pr-0">
              <div class="card border-info">
                <div class="card-body text-primary">
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
            <div class="col-md-1 pl-1 pr-0">
              <div class="card border-info">
                <div class="card-body text-primary pl-0 pr-0">
                  <input type="date" class="form-control form-control-sm" id="fr_from" name="fr_from" value="<?php echo $submit_date; ?>" title="From Date">
                </div>
              </div>
            </div>
            <div class="col-md-1 pl-1">
              <div class="card border-info">
                <div class="card-body text-primary pl-0 pr-0">
                  <input type="date" class="form-control form-control-sm" id="fr_to" name="fr_to" value="<?php echo $submit_date; ?>" title="To Date">
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-1">
            <div class="col-md-10 student_detail">
              <div class="container card myCard border-info">
                <div class="row p-1">
                  <div class="col-2 m-0 p-0 studentImage">
                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="30%">
                  </div>
                  <div class="col-10 smallerText">
                    <div class="row mt-1 p-0">
                      <div class="col-3 m-0 p-0">
                        <span class="student_name">Not Found</span>
                      </div>
                      <div class="col-3 p-0 student_fname">--</div>
                      <div class="col-3 p-0 student_rollno">--</div>
                      <div class="col-3 p-0 student_id">--</div>
                    </div>
                    <div class="row p-0">
                      <div class="col-3 p-0 student_program">--</div>
                      <div class="col-3 p-0 student_fcg">--</div>
                      <div class="col-3 p-0">
                        Adm : <span class="student_batch">--</span>
                      </div>
                      <div class="col-3 p-0">
                        Acad: <span class="student_ay">--</span>
                      </div>
                    </div>
                    <div class="row p-0">
                      <div class="col-3 p-0 current_class">--</div>
                      <div class="col-3 p-0 current_semester">--</div>
                      <div class="col-3 p-0 current_group">--</div>
                      <div class="col-3 p-0">
                        <span class="student_mobile">--</span>
                        <i class="fa fa-phone"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane active show fade" id="feeConcession" role="tabpanel" aria-labelledby="feeConcession">
            <div class="row">
              <div class="col-8 pr-0">
                <div class="container card mt-2 myCard">
                  <div class="row">
                    <div class="col-12">
                      <div class="row">
                        <div class="col-2 pr-0">
                          <div class="form-group">
                            <label>Type</label>
                            <p id="feeTypeConcession"></p>
                          </div>
                        </div>
                        <div class="col-1 pl-1 pr-0">
                          <div class="form-group">
                            <label>Sem</label>
                            <input type="number" class="form-control form-control-sm" id="semesterConcession" min="1" name="semester" placeholder="Semester" value="1">
                          </div>
                        </div>
                        <div class="col-2 pl-1 pr-0">
                          <div class="form-group">
                            <label>Dues</label>
                            <input type="number" class="form-control form-control-sm" id="feeAmountConcession" name="feeAmount" min="0" placeholder="Fee Dues" value="0">
                          </div>
                        </div>
                        <div class="col-2 pl-1 pr-0">
                          <div class="form-group">
                            <label>Concsn</label>
                            <input type="number" class="form-control form-control-sm" id="fcAmount" name="fcAmount" min="0" placeholder="Concession" value="0">
                          </div>
                        </div>
                        <div class="col-3 pl-1 pr-0">
                          <div class="form-group">
                            <label>Remarks</label>
                            <input type="text" class="form-control form-control-sm" id="fdRemarks" name="fdRemarks" placeholder="Remarks">
                          </div>
                        </div>
                        <div class="col-2 pl-1 pr-1">
                          <button class="btn btn-sm mt-4" id="proposeFeeConcession">Update</button>
                        </div>
                      </div>
                      <table class="table table-bordered table-striped list-table-xs mt-3" id="feeConcessionList">
                        <th class="text-center">Fee Type</th>
                        <th class="text-center">Semester</th>
                        <th class="text-center">Fee Dues</th>
                        <th class="text-center">Concession</th>
                        <th class="text-center">Remarks</th>
                        <th class="text-center">StaffId</th>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-4 pl-1">
                <div class="container card mt-2 myCard">
                  <div class="row">
                    <div class="col-12 mt-2">
                      <h5 class="text-center">Fee Structure</h5>
                      <table class="table table-bordered table-striped list-table-xs mt-3" id="feeStructureList">
                        <th>Fee Type</th>
                        <th>Amount</th>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="reverse" role="tabpanel" aria-labelledby="reverse">
            <div class="row">
              <div class="col-10">
                <div class="container card mt-2 myCard">
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
          <div class="tab-pane fade" id="rer" role="tabpanel" aria-labelledby="list-rer-list">
            <div class="row">
              <div class="col-10 pr-0">
                <div class="container card mt-2 myCard" id="print" style="overflow: scroll;">
                  <div class="row">
                    <div class="col-md-3 mt-4">
                      <div class="form-group">
                        <button class="btn btn-sm btn-block" id="rerShow">Show Reverse Entries</button>
                      </div>
                    </div>
                    <div class="col-md-9 mt-5 text-right">
                      <a class="fas fa-file-export" id="rerExport"></a>
                    </div>
                  </div>
                  <table class="table table-bordered table-striped list-table-xs mt-3" id="rerList">
                    <th class="text-center">SNo</th>
                    <th class="text-center">Receipt Date</th>
                    <th class="text-center">Reverse Date</th>
                    <th class="text-center">Receipt ID</th>
                    <th class="text-center">Student</th>
                    <th class="text-center">StudentId</th>
                    <th class="text-center">Fee Type</th>
                    <th class="text-center">Amount</th>
                    <th class="text-center">Receipt By</th>
                    <th class="text-center">Description</th>
                  </table>
                </div>
              </div>
              <div class="col-md-2 pl-1">
                <div class="container card mt-2 myCard">
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
            url: "accountsSql.php",
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

    $(document).on('click', '#searchStudent', function(event) {
      var data = $("#studentSearch").val();
      // $.alert(data);
      $.post("accountsSql.php", {
        action: "fetchStudent",
        userId: data,
      }, () => {}, "json").done(function(data) {
        // console.log(data)
        $(".student_id").text(data.student_id);
        $(".student_name").text(data.student_name);
        $(".student_fname").text(data.student_fname);
        $(".student_rollno").text(data.student_rollno);
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
        feeDebitList();
        feeStructure();
        // $.alert(data);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    })

    $(document).on('click', '.autoList', function() {
      $('#studentNameSearch').val($(this).text());
      var stdId = $(this).attr("data-std");
      $('#studentAutoList').fadeOut();
      $.alert(stdId);
      $.post("accountsSql.php", {
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
        feeStructure();
        feeDebitList();
      }).fail(function() {
        $.alert("fail in place of error");
      })
    })

    $(document).on('click', '.feeRecord', function(event) {
      feeBalance();
    })

    function feeStructure() {
      var studentId = $("#studentIdHidden").val();
      var fee_semester = $("#semesterConcession").val()
      $.alert("studentId " + studentId + "Sem " + fee_semester);
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
        $.post("accountsSql.php", {
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
      $.post("accountsSql.php", {
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
        $.alert("Error in Fee Concession !!");
      })

    }

    function feeDebitList() {
      var studentId = $("#studentIdHidden").val();
      // $.alert("studentId" + studentId);
      $.post("accountsSql.php", {
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
      $.post("accountsSql.php", {
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
                $.post("accountsSql.php", {
                  id: fr_sno,
                  frev_desc: frev_desc,
                  action: "addFeeReverse"
                }, function(data) {
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

    function showReceipt(x) {
      // $.alert("Fr Id " + x);
      $.post("accountsSql.php", {
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
      $.post("accountsSql.php", {
        action: "feeType"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var listConcession = '';
        listConcession += '<select class="form-control form-control-sm" name="sel_ft" id="sel_ftConcession" required>';
        // listConcession += '<option value="0">Select Fee Type</option>';
        $.each(data, function(key, value) {
          listConcession += '<option value=' + value.mn_id + '>' + value.mn_name + '</option>';
        });
        listConcession += '</select>';
        // $("#feeType").html(list);
        $("#feeTypeConcession").html(listConcession);
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

  document.getElementById('rerExport').onclick = function() {
    var tableId = document.getElementById('rerList').id;
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