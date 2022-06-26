<?php
require('../requireSubModule.php');
addActivity($conn, $myId, "Student Status", $submit_ts);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Outcome Based Education : AcadPlus</title>
  <?php require("../css.php"); ?>
</head>

<body>
  <?php require("../topBar.php"); 
  if($myId>3){
    if (!isset($_GET['tag'])) die("Illegal Attempt !! The token is Missing");
    elseif (!in_array($_GET['tag'], $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
    elseif (!in_array("48", $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
  }
  ?>
  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-1 p-0 m-0 pl-1 full-height">
        <div class="mt-3">
          <h5 class="largeText">Std Status</h5>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active ud" data-toggle="list" href="#ud" role="tab" aria-controls="ud"> Upload Docs </a>
          <a class="list-group-item list-group-item-action sr" data-toggle="list" href="#sr" role="tab" aria-controls="sr">Status Report</a>
          <a class="list-group-item list-group-item-action dr" data-toggle="list" href="#dr" role="tab" aria-controls="dr"> Doc Report </a>
        </div>
      </div>
      <div class="col-11 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <div class="row">
            <div class="col-5">
              <?php require("../setDefaultModule.php"); ?>
            </div>
            <div class="col-2">
                <input name="studentNameSearch" id="studentNameSearch" class="form-control form-control-sm" type="text" placeholder="Search Student" aria-label="Search">
                <div class='list-group' id="studentAutoList"></div>
            </div>
            <div class="col-md-5">
              <input type="checkbox" checked id="ay" name="ay_id" value="1">
              <span class="smallText">AY</span>
              <input type="checkbox" id="leet" name="leet" value="1">
              <span class="smallText">LEET</span>
              <input type="checkbox" id="deleted" name="deleted" value="1">
              <span class="smallText">Deleted</span>
              <input type="checkbox" checked id="hostel" name="hostel">
              <span class="smallText">Hostel</span>
              <input type="checkbox" checked id="transport" name="transport">
              <span class="smallText">Transport</span>
              <input type="checkbox" checked id="dayScholar" name="dayScholar">
              <span class="smallText">Day Scholar</span>
            </div>
          </div>
          <div class="tab-pane active show" id="ud" role="tabpanel" aria-labelledby="list-ud-list">
            <div class="row">
              <div class="col-md-6">
                <div class="card myCard mt-3">
                  <form class="form-horizontal" id="uploadModalForm">
                    <div class="row m-3">
                      <div class="col-4 pr-0">
                        <select class="form-control form-control-sm">
                          <option value="0">Document Type</option>
                        </select>
                      </div>
                      <div class="col-4 pl-1 pr-0">
                        <input type="file" name="upload_file">
                      </div>
                      <div class="col-3 pl-1 pr-0">
                        <input type="hidden" name="studentId" id="studentId">
                        <input type="hidden" name="action" value="uploadImage">
                        <button type="submit" class="btn btn-sm btn-block">Upload Image</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-sr" role="tabpanel" aria-labelledby="list-sr-list">
            <div class="row">
              <div class="col-10">
                <div class="container card m-2 myCard">
                  <div class="row mt-2">
                    <div class="col-md-3 pr-0">
                      <label>Status Type</label>
                      <?php
                      $sql = "select * from master_name where mn_code='sts'";
                      $result = $conn->query($sql);
                      if ($result) {
                        echo '<select class="form-control form-control-sm" name="sel_ss" id="sel_ss">';
                        while ($rows = $result->fetch_assoc()) {
                          $select_id = $rows['mn_id'];
                          $select_name = $rows['mn_name'];
                          echo '<option value="' . $select_id . '">' . $select_name . '</option>';
                        }
                        // echo '<option value="ALL">ALL</option>';
                        echo '</select>';
                      } else echo $conn->error;
                      if ($result->num_rows == 0) echo 'No Data Found';
                      ?>
                    </div>
                    <div class="col-md-1 pl-1 pr-0">
                      <label>Semester</label>
                      <input type="number" class="form-control form-control-sm" id="ssSemester" name="ssSemester" min="1" value="1">
                    </div>
                    <div class="col-md-2 pl-1">
                      <button type="button" class="btn btn-sm mt-4" id="showSSList">Refresh List</button>
                    </div>
                    <div class="col-md-6 text-right">
                      <a onclick="printDiv('printSS')" class="fa fa-print mt-2 xlText"></a>
                      <button type="button" class="btn btn-sm" id="updateStatus">Update Status</button>
                    </div>
                  </div>
                  <div id="printSS">
                    <table class="table table-bordered table-striped list-table-xs mt-4" id="studentStatusTable">
                      <tr>
                        <th>#</th>
                        <th><input type="checkbox" id="checkall" /></th>
                        <th>Id</th>
                        <th>UserId</th>
                        <th>Name</th>
                        <th>Father Name</th>
                        <th>Specialization</th>
                        <th>AY</th>
                        <th>LEET</th>
                        <th>Roll No.</th>
                        <th>Mobile</th>
                        <th>Remarks</th>
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
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <?php require("../bottom_bar.php"); ?>
  </div>
</body>

</html>
<script>
  $(document).ready(function() {

    $(function() {
      $(document).tooltip();
    });

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
            url: "studentStatusSql.php",
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
    })

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

</script>

</html>