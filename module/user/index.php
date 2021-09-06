<?php
require('../requireSubModule.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Outcome Based Education : AcadPlus</title>
  <?php require("../css.php"); ?>
</head>

<body>
  <?php require("../topBar.php"); ?>
  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-2 p-0 m-0 pl-2 full-height">
        <div class="mt-3">
          <h5>Manage Users</h5>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action show active aru" id="list-aru-list" data-toggle="list" href="#list-aru" role="tab" aria-controls="aru">Add/Remove User</a>
          <a class="list-group-item list-group-item-action ml" id="list-ml-list" data-toggle="list" href="#list-ml" role="tab" aria-controls="ml">Manage Links</a>
          <a class="list-group-item list-group-item-action ulr" id="list-ulr-list" data-toggle="list" href="#list-ulr" role="tab" aria-controls="ulr">User Log Report</a>
        </div>
      </div>
      <div class="col-10 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <div class="row">
            <div class="col-6">
              <div class="card border-info">
                <div class="card-body text-primary">
                  <div class="row">
                    <div class="col-6 pr-0">
                      <input name="userId" id="userId" class="form-control form-control-sm" type="text" placeholder="Search User" aria-label="Search">
                    </div>
                    <div class="col-3 pl-1 pr-0">
                      <button type="button" class="btn btn-block btn-sm" id="searchStudent"><i class="fas fa-search"></i>Student</button>
                    </div>
                    <div class="col-3 pl-1">
                      <button type="button" class="btn btn-block btn-sm" id="searchStaff"><i class="fas fa-search"></i>Staff</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane show active" id="list-aru" role="tabpanel" aria-labelledby="list-aru-list">
            <div class="row">
              <div class="col-6">
                <div class="container card mt-2 myCard">
                  <div class="row">
                    <div class="col-12">
                      <p class="applicationForm"></p>
                    </div>
                  </div>
                  <h4>User History</h4>
                </div>
              </div>
              <div class="col-6">
                <div class="container card mt-2 myCard">
                  <div class="row">
                    <div class="col-12">
                      <p class="text-center"><h1>User Status : <span class="userStatus"></span> </h1></p>
                      <button class="btn btn-success">Create User</button>
                      <button class="btn">Suspend User</button>
                      <button class="btn btn-danger">Remove User</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-ulr" role="tabpanel" aria-labelledby="list-ulr-list">

          </div>
          <div class="tab-pane fade" id="list-ml" role="tabpanel" aria-labelledby="list-ml-list">
            <div class="row">
              <div class="col-4">
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

</html>

<?php require("../js.php"); ?>

<script>
  $(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip();

    
    $(document).on('click', '#searchStudent', function(event) {
      var userId = $("#userId").val();
      $.alert(userId);
      $.post("userSql.php", {
        action: "fetchUser",
        userId: userId,
      }, () => {}, "json").done(function(data) {
        // $.alert(data);
        studentDisp();
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    function studentDisp() {
      var userId = $("#userId").val()
      // $.alert(" Student Display Functio  Id " + studentId);
      $.post("userSql.php", {
        userId: userId,
        action: "studentDisp"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var card = '<h4>' + data.student_name + ' [' + data.user_id + ']</h4>';
        card += '<table class="table list-table-xs">';
        card += '<tr>';
        card += '<td> Program Name </td><td>' + data.program_name + '</td>';
        card += '<td> Batch </td><td>' + data.batch + '</td>';
        card += '</tr>';

        card += '<tr>';
        card += '<td> Mobile </td><td>' + data.student_mobile + '</td>';
        card += '<td> Email </td><td>' + data.student_email + '</td>';
        card += '</tr>';

        card += '<tr><td colspan="4"><h4>Parents Information</h4></td></tr>'

        card += '<tr>';
        card += '<td> Father Name </td><td>' + data.student_fname + '</td>';
        card += '<td>' + data.student_fmobile + '</td>';
        card += '<td>' + data.student_femail + '</td>';
        card += '</tr>';

        card += '</table>';
        $(".applicationForm").html(card);

      }).fail(function() {
        $.alert("Could not Fetch Student Data!!");
      })
    }

    $(document).on('click', '#searchStaff', function(event) {
      var userId = $("#userId").val();
      $.alert(userId);
      $.post("userSql.php", {
        action: "fetchStaff",
        userId: userId
      }, () => {}, "json").done(function(data) {
        // $.alert(data);
        staffDisp();
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    function staffDisp() {
      var userId = $("#userId").val()
      // $.alert(" Student Display Functio  Id " + studentId);
      $.post("userSql.php", {
        userId: userId,
        action: "staffDisp"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var card = '<h4>' + data.staff_name + ' [' + data.user_id + ']</h4>';
        card += '<table class="table list-table-xs">';
        card += '<tr>';
        card += '<td> Mobile </td><td>' + data.staff_mobile + '</td>';
        card += '</tr>';

        card += '<tr>';
        card += '<td> Email </td><td>' + data.staff_email + '</td>';
        card += '</tr>';        
        card += '</table>';
        $(".applicationForm").html(card);

      }).fail(function() {
        $.alert("Could not Fetch Student Data!!");
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
    var tableId = document.getElementById('studentShowList').id;
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