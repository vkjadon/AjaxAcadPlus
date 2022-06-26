<?php
require('../requireSubModule.php');
$phpFile = "feeSql.php";
addActivity($conn, $myId, "FEE", $submit_ts);

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
    elseif (!in_array("3", $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
  }
	?>
    <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-1 p-0 m-0 full-height">
        <div class="mt-3 pl-1">
          <h5>Fee </h5>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active feeStructure" data-toggle="list" href="#feeStructure" role="tab" aria-controls="feeStructure"> Fee Structure </a>
          <a class="list-group-item list-group-item-action feeSchedule" data-toggle="list" href="#feeSchedule" role="tab" aria-controls="feeSchedule"> Fee Schedule </a>
          <a class="list-group-item list-group-item-action ledgerStatus" data-toggle="list" href="#ledgerStatus" role="tab" aria-controls="ledgerStatus"> Fee Status </a>
        </div>
      </div>
      <div class="col-11 leftLinkBody">
        <div class="card p-2 myCard">
          <form id="newFee">
            <div class="row">
              <div class="col-md-1 pr-0">
                <label>Batch</label>
                <p id="batchOption"></p>
              </div>
              <div class="col-md-2 pl-1 pr-0">
                <label>Institute/School</label>
                <p id="schoolOption"></p>
              </div>
              <div class="col-md-2 pl-1 pr-0">
                <label>Programme</label>
                <p id="programOption">
                  <input type="text" class="form-control form-control-sm" disabled placeholder="Program">
                </p>
              </div>
              <div class="col-md-2 pl-1 pr-0">
                <label>Category</label>
                <p id="feeCategory"></p>
              </div>
              <div class="col-md-1 pl-1 pr-0">
                <label>Type</label>
                <p id="feeType"></p>
              </div>
              <div class="col-md-2 pl-1 pr-0">
                <label>Component</label>
                <p id="feeComponent"></p>
              </div>
              <div class="col-md-1 pl-1 pr-0">
                <div class="form-group">
                  <label>Semester</label>
                  <input type="number" class="form-control form-control-sm" id="semester" min="1" name="semester" placeholder="Semester" value="1">
                </div>
              </div>
              <div class="col-md-1 pl-1">
                <div class="form-group">
                  <label>Fee</label>
                  <input type="number" class="form-control form-control-sm" id="fee" min="0" name="fee" placeholder="Fee" value="0">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8">
              </div>
              <div class="col-md-2 pl-0">
                <button class="btn btn-sm btn-info" id="postDues">Post Dues</button>
              </div>
              <div class="col-md-2 pl-0">
                <input type="hidden" id="action" name="action" value="addFee">
                <button class="btn btn-sm">Add/Update/Refresh</button>
              </div>
            </div>
          </form>
        </div>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane active" id="feeStructure" role="tabpanel" aria-labelledby="list-feeStructure-list">
            <div class="row">
              <div class="col-md-12">
                <div class="card mt-2 myCard" style="overflow: scroll;">
                  <div class="row m-1">
                    <div class="col-md-1">
                      <a href="#" class="fa fa-refresh" id="showFeeStructure"></a>
                    </div>
                    <div class="col-md-8">
                    </div>
                    <div class="col-md-1 pr-0 text-right">
                      <input type="number" class="form-control form-control-sm" id="copyBatch" name="copyBatch" minlength="4" min="2000" value="2020">
                    </div>
                    <div class="col-md-2 pl-0">
                      <button class="btn btn-sm btn-block" id="copyBatchBtn">Copy Fee Structure</button>
                    </div>

                  </div>
                  <h5 class="largeText mt-3 text-center">Fee Structure</h5>
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered table-striped list-table-xs mt-3" id="feeStructureList">
                        <th class="text-center"><i class="fa fa-trash"></i></th>
                        <th>Batch</th>
                        <th>Institute</th>
                        <th>Programme</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Component</th>
                        <th>Semester</th>
                        <th>Fee</th>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="feeSchedule" role="tabpanel" aria-labelledby="list-feeSchedule-list">
            <table class="table table-bordered table-striped list-table-xs mt-3" id="feeScheduleList">
              <th>Batch</th>
              <th>Institute</th>
              <th>Programme</th>
              <th>Category</th>
              <th>Type</th>
              <th>Semester</th>
              <th>Fee</th>
              <th>Last Date</th>
            </table>
          </div>
          <div class="tab-pane" id="ledgerStatus" role="tabpanel" aria-labelledby="list-ledgerStatus-list">
            <div class="row">
              <div class="col-md-10">
              </div>
              <div class="col-md-2">
                <div class="text-right">
                  <a onclick="export_data()"><i class="fas fa-file-export"></i></a>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <table class="table table-bordered table-striped list-table-xs mt-3" id="ledgerStatusList">
                  <th>Student ID</th>
                  <th>Name</th>
                  <th>Father Name</th>
                  <th>Program</th>
                  <th>Roll Number</th>
                  <th>Sem</th>
                  <th>Mobile</th>
                  <th>Fee Category</th>
                  <th>Dues</th>
                  <th>Concsn</th>
                  <th>Credit</th>
                  <th>Balance</th>
                  <?php
                  $sql = "select * from master_name where mn_code='sts' order by mn_id";
                  $result = $conn->query($sql);
                  while ($rowsArray = $result->fetch_assoc()) {
                    echo '<th>' . $rowsArray['mn_abbri'] . '</th>';
                  }
                  ?>
                </table>
                <p id="totalDebit"></p>
                <p id="totalCredit"></p>
                <p id="totalBalance"></p>
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
    batchOption();
    schoolOption();
    feeCategory();
    feeComponent();
    feeType();
    // $("#feeScheduleList").hide()
    // $("#feeStructureList").hide()
    // $("#ledgerStatusList").hide()

    // feeStructureList();

    $(document).on('click', '.ledgerStatus', function(event) {
      // $.alert("Name");
      $("#ledgerStatusList").show()

      var error = "NO";
      var error_msg = "";
      if ($('#sel_prog').val() === "0" || $('#sel_school').val() === "0" || $('#sel_batch').val() === "0") {
        error = "YES";
        error_msg = "Please check Department, Program and Fee are added.";
      }
      if (error == "NO") {
        // alert(" Pressed" + formData);
        $.post("<?php echo $phpFile; ?>", {
          sel_batch: $('#sel_batch').val(),
          sel_prog: $('#sel_prog').val(),
          sel_school: $('#sel_school').val(),
          ft: $("#sel_ft").val(),
          semester: $('#semester').val(),
          action: "ledgerStatusList"
        }, () => {}, "json").done(function(data) {
          // $.alert(data);
          console.log(data);
          var card = '';
          var total_debit = 0;
          var total_credit = 0;
          var total_balance = 0;

          $.each(data.ledger, function(key, value) {
            total_debit = parseInt(total_debit) + parseInt(value.debit);
            total_credit = parseInt(total_credit) + parseInt(value.credit);
            total_balance = parseInt(total_balance) + parseInt(value.balance);
            card += '<tr>';
            card += '<td>' + value.user_id + '</td>';
            card += '<td>' + value.student_name + '</td>';
            card += '<td>' + value.student_fname + '</td>';
            card += '<td>' + value.program_name + '</td>';
            card += '<td>' + value.student_rollno + '</td>';
            card += '<td>' + value.semester + '</td>';
            card += '<td>' + value.student_mobile + '</td>';
            card += '<td>' + value.student_fee_category + '</td>';
            card += '<td>' + value.debit + '</td>';
            card += '<td>' + value.concession + '</td>';
            card += '<td>' + value.credit + '</td>';
            card += '<td>' + value.balance + '</td>';
            $.each(data.status[key].mn_name, function(key2, value2) {
              if (data.status[key].mn_name[key2] == 'No') card += '<td class="tdRejected">' + data.status[key].mn_name[key2] + '</td>';
              else card += '<td class="approved">[' + data.status[key].mn_name[key2] + ']</td>';
            })
            card += '</tr>';
          });
          $("#ledgerStatusList").find("tr:gt(0)").remove();
          $("#ledgerStatusList").append(card);
          $("#totalDebit").html("<h5> Total Debit " + total_debit + "</h5>")
          $("#totalCredit").html("<h5> Total Credit " + total_credit + "</h5>")
          $("#totalBalance").html("<h5> Total Balance " + total_balance + "</h5>")
        }).fail(function() {
          $.alert("fail in place of error");
        })
      } else {
        $.alert(error_msg);
      }
    });

    $(document).on('click', '.feeSchedule', function(event) {
      $(".tableTitle").text("Fee Schedule")
      feeSchedule()
    });

    function feeSchedule() {
      var batchId = $("#sel_batch").val()
      var ft = $("#sel_ft").val()
      // $.alert("Batch " + batchId + " FT " + ft);
      $.post("<?php echo $phpFile; ?>", {
        sel_batch: batchId,
        ft: ft,
        action: "feeScheduleList"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        // console.log(data);
        var card = '';
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td>' + value.batch + '</td>';
          card += '<td>' + value.school_name + '</td>';
          card += '<td>' + value.program_name + '</td>';
          card += '<td>' + value.fee_category + '</td>';
          card += '<td>' + value.fee_type + '</td>';
          card += '<td>' + value.fee_semester + '</td>';
          card += '<td>' + value.fsch_amount + '</td>';
          card += '<td class="text-center"><input type="date" class="form-control form-control-sm updateSchedule" value="' + value.last_date + '"></td>';
          card += '</tr>';
        });
        $("#feeScheduleList").find("tr:gt(0)").remove();
        $("#feeScheduleList").append(card);

      }).fail(function() {
        $.alert("Error !!");
      })

    }

    $(document).on('click', '#copyBatchBtn', function(event) {
      var batch = $("#sel_batch option:selected").text()
      var copyBatch = $("#copyBatch").val()
      $.confirm({
        title: 'Please Confirm !',
        draggable: true,
        content: "<b><i>Copy Fee Structure of Batch " + batch + " to Batch " + copyBatch + "</i></b>",
        buttons: {
          confirm: {
            btnClass: 'btn-info',
            action: function() {
              $.post("<?php echo $phpFile; ?>", {
                batch: batch,
                copyBatch: copyBatch,
                action: "copyFee"
              }, () => {}, "text").done(function(data, status) {
                $.alert(data);
              })
            }
          },
          cancel: {
            btnClass: "btn-danger",
            action: function() {}
          },
        }
      });
    });

    $(document).on('click', '#showFeeStructure', function(event) {
      $(".tableTitle").text("Fee Structure")
      feeStructureList()
    });

    $(document).on('submit', '#newFee', function(event) {
      event.preventDefault(this);
      // $.alert("Name");
      var error = "NO";
      var error_msg = "";
      if ($('#sel_prog').val() === "0" || $('#sel_school').val() === "0" || $('#fee').val() === "0") {
        error = "YES";
        error_msg = "Please check Department, Program and Fee are added.";
      }
      if (error == "NO") {
        var formData = $(this).serialize();
        // alert(" Pressed" + formData);
        $.post("<?php echo $phpFile; ?>", formData, () => {}, "text").done(function(data) {
          // $.alert(data);
          feeStructureList()
        }, "text").fail(function() {
          $.alert("fail in place of error");
        })
      } else {
        $.alert(error_msg);
      }
    });

    function feeStructureList() {
      var batchId = $("#sel_batch").val()
      // $.alert(batchId);
      $.post("<?php echo $phpFile; ?>", {
        sel_batch: batchId,
        action: "feeStructureList"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        // console.log(data);
        var card = '';
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td class="text-center"><a href="#" class="dropFee" data-fee="' + value.fs_id + '"><i class="fas fa-trash"></i></a></td>';
          card += '<td>' + value.batch + '</td>';
          card += '<td>' + value.school_name + '</td>';
          card += '<td>' + value.program_name + '</td>';
          card += '<td>' + value.mn_name + '</td>';
          card += '<td>' + value.fee_type + '</td>';
          card += '<td>' + value.fee_component + '</td>';
          card += '<td>' + value.fee_semester + '</td>';
          card += '<td>' + value.fs_amount + '</td>';
          card += '</tr>';
        });
        $("#feeStructureList").find("tr:gt(0)").remove();
        $("#feeStructureList").append(card);

      }).fail(function() {
        $.alert("Error !!");
      })

    }

    function feeType() {
      // $.alert("Department ");
      $.post("<?php echo $phpFile; ?>", {
        action: "feeType"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var list = '';
        list += '<select class="form-control form-control-sm" name="sel_ft" id="sel_ft" required>';
        $.each(data, function(key, value) {
          list += '<option value=' + value.mn_id + '>' + value.mn_name + '</option>';
        });
        list += '<option value="ALL">ALL</option>';
        list += '</select>';
        $("#feeType").html(list);

      }).fail(function() {
        $.alert("Error !!");
      })
    }

    function feeCategory() {
      // $.alert("Department ");
      $.post("<?php echo $phpFile; ?>", {
        action: "feeCategory"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var list = '';
        list += '<select class="form-control form-control-sm" name="sel_fcg" id="sel_fcg" required>';
        $.each(data, function(key, value) {
          list += '<option value=' + value.mn_id + '>' + value.mn_name + '</option>';
        });
        list += '</select>';
        $("#feeCategory").html(list);

      }).fail(function() {
        $.alert("Error !!");
      })
    }

    function feeComponent() {
      // $.alert("Department ");
      $.post("<?php echo $phpFile; ?>", {
        action: "feeComponent"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var list = '';
        list += '<select class="form-control form-control-sm" name="sel_fc" id="sel_fc" required>';
        $.each(data, function(key, value) {
          list += '<option value=' + value.mn_id + '>' + value.mn_name + '</option>';
        });
        list += '</select>';
        $("#feeComponent").html(list);

      }).fail(function() {
        $.alert("Error !!");
      })
    }

    function batchOption() {
      // $.alert("Department ");
      $.post("<?php echo $phpFile; ?>", {
        action: "batchOption"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var list = '';
        list += '<select class="form-control form-control-sm" name="sel_batch" id="sel_batch" required>';
        $.each(data, function(key, value) {
          list += '<option value=' + value.batch_id + '>' + value.batch + '</option>';
        });
        list += '</select>';
        $("#batchOption").html(list);

      }).fail(function() {
        $.alert("Error !!");
      })
    }

    function schoolOption() {
      // $.alert("Department ");
      $.post("<?php echo $phpFile; ?>", {
        action: "schoolOption"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var list = '';
        list += '<select class="form-control form-control-sm" name="sel_school" id="sel_school" required>';
        list += '<option value="0">Select Institution/School</option>'
        $.each(data, function(key, value) {
          list += '<option value=' + value.school_id + '>' + value.school_name + '</option>';
        });
        list += '</select>';
        $("#schoolOption").html(list);

      }).fail(function() {
        $.alert("Error !!");
      })
    }

    function programOption() {
      var schoolId = $("#sel_school").val()
      // $.alert("Dept " + schoolId);
      $.post("<?php echo $phpFile; ?>", {
        schoolId: schoolId,
        action: "progOption"
      }, function() {}, "json").done(function(data, status) {
        // $.alert("List " + data);
        var list = '';
        list += '<select class="form-control form-control-sm" name="sel_prog" id="sel_prog">';
        $.each(data, function(key, value) {
          list += '<option value=' + value.program_id + '>' + value.program_name + '</option>';
        });
        list += '<option value="ALL">ALL</option>';
        list += '</select>';
        $("#programOption").html(list);

      }).fail(function() {
        $.alert("Error !!");
      })

    }

    $(document).on('change', '#sel_school', function() {
      programOption();
    });

    $(document).on("click", ".dropFee", function() {
      var fs_id = $(this).attr("data-fee");
      // $.alert('fs' + fs_id);
      $.confirm({
        title: 'Please Confirm!',
        draggable: true,
        content: "<b><i>The Selected Fee Structure will be removed !!</i></b>",
        buttons: {
          confirm: {
            btnClass: 'btn-info',
            action: function() {
              $.post("<?php echo $phpFile; ?>", {
                fs_id: fs_id,
                action: "deleteFee"
              }, () => {}, "text").done(function(data, status) {
                $.alert(data);
              })
              feeStructureList()
            }
          },
          cancel: {
            btnClass: "btn-danger",
            action: function() {}
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
  });
</script>

<script>
  function export_data() {
    let data = document.getElementById('ledgerStatusList');
    var fp = XLSX.utils.table_to_book(data, {
      sheet: 'vishal'
    });
    XLSX.write(fp, {
      bookType: 'xlsx',
      type: 'base64'
    });
    XLSX.writeFile(fp, 'test.xlsx');
  }
</script>

</html>