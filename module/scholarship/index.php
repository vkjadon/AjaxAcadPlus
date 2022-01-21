<?php
require('../requireSubModule.php');
$phpFile = "scholarshipSql.php";
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
      <div class="col-1 p-0 m-0 pl-1 full-height">
        <div class="mt-3">
          <h5>Scholarship</h5>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <?php
          if (in_array("14", $myLinks)) echo '<a class="list-group-item list-group-item-action ss" id="list-ss-list" data-toggle="list" href="#list-ss" role="tab" aria-controls="ss">Scholarship</a>';
          if (in_array("14", $myLinks)) echo '<a class="list-group-item list-group-item-action stage" id="list-stage-list" data-toggle="list" href="#list-stage" role="tab" aria-controls="stage">Update Stage</a>';
          ?>
        </div>
      </div>
      <div class="col-11 p-0">
        <div class="row bg-light p-2 m-0">
          <div class="col-md-2 pr-0">
            <div class="card border-info">
              <div class="input-group">
                <?php
                $sql_batch = "select * from batch where batch_status='0' order by batch desc";
                $result = $conn->query($sql_batch);
                if ($result) {
                  echo '<select class="form-control form-control-sm" name="sel_batch" id="sel_batch" required>';
                  echo '<option selected disabled> Batch</option>';
                  while ($rows = $result->fetch_assoc()) {
                    $select_id = $rows['batch_id'];
                    $select_name = $rows['batch'];
                    echo '<option value="' . $select_id . '">' . $select_name . '</option>';
                  }
                  // echo '<option value="ALL">ALL</option>';
                  echo '</select>';
                } else echo $conn->error;
                if ($result->num_rows == 0) echo 'No Data Found';
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-2 pl-1 pr-0">
            <div class="card border-info">
              <div class="input-group">
                <?php
                $sql_program = "select * from program where program_status='0' order by sp_name";
                $result = $conn->query($sql_program);
                if ($result) {
                  echo '<select class="form-control form-control-sm" name="sel_program" id="sel_program" required>';
                  echo '<option selected disabled> Program-Specialization</option>';
                  while ($rows = $result->fetch_assoc()) {
                    $select_id = $rows['program_id'];
                    $select_name = $rows['sp_name'];
                    echo '<option value="' . $select_id . '">' . $select_name . '</option>';
                  }
                  echo '<option value="ALL">ALL</option>';
                  echo '</select>';
                } else echo $conn->error;
                if ($result->num_rows == 0) echo 'No Data Found';
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-1 pl-1 pr-0">
            <div class="card border-info">
              <div class="input-group">
                <input type="number" class="form-control form-control-sm" id="ssSemester" name="ssSemester" min="1" value="1" title="Semester">
              </div>
            </div>
          </div>
          <!-- <div class="col-md-3 pl-3">
            <input type="checkbox" checked id="ay" name="ay_id" value="1">
            <span class="smallText">AY</span>
            <input type="checkbox" id="leet" name="leet" value="1">
            <span class="smallText">LEET</span>
            <input type="checkbox" id="deleted" name="deleted" value="1">
            <span class="smallText">Deleted</span>
          </div> -->
        </div>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade" id="list-ss" role="tabpanel" aria-labelledby="list-ss-list">
            <div class="row">
              <div class="col-10">
                <div class="container card m-2 myCard">
                  <div class="row mt-2">
                    <div class="col-md-11">
                      <a href="#" class="fa fa-refresh showSSList" id="showSSList" title="Reload the Student List"></a>
                    </div>
                    <div class="col-md-1 text-right">
                      <a onclick="printDiv('printSS')" class="fa fa-print mt-2 largeText"></a>
                      <a onclick="export_data()"><i class="fas fa-file-export"></i></a>
                    </div>
                  </div>

                  <div id="printSS">
                    <table class="table table-bordered table-striped list-table-xs mt-4" id="studentStatusTable">
                      <tr>
                        <th>#</th>
                        <th>Id</th>
                        <th>UserId</th>
                        <th>Name</th>
                        <th>Father Name</th>
                        <th>Specialization</th>
                        <th>Roll No.</th>
                        <th>Mobile</th>
                        <th>Scholarship</th>
                        <th>Add</th>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-stage" role="tabpanel" aria-labelledby="list-stage-list">
            <div class="row">
              <div class="col-10">
                <div class="container card m-2 myCard">
                  <div class="row mt-2">
                    <div class="col-md-11">
                      <a href="#" class="fa fa-refresh showStageList" id="showStageList" title="Reload the Student Stage List"></a>
                    </div>
                    <div class="col-md-1 text-right">
                      <a onclick="printDiv('printStage')" class="fa fa-print mt-2 largeText"></a>
                      <a onclick="export_stage()"><i class="fas fa-file-export"></i></a>
                    </div>
                  </div>

                  <div id="printStage">
                    <table class="table table-bordered table-striped list-table-xs mt-4" id="scholarshipStageTable">
                      <tr>
                        <th>#</th>
                        <th>UserId</th>
                        <th>Name</th>
                        <th>Father Name</th>
                        <th>Roll No.</th>
                        <th>Scholarship</th>
                        <th>Amount</th>
                        <th>Stage</th>
                        <th>Update Date</th>
                        <th>Action</th>
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

    $(document).on("click", "#exportQual", function() {
      // $.alert("ds");
      $("#qualificationTable").table2excel({
        filename: "qualification.xls"
      });
    })

    $(document).on("click", ".stage, .showStageList", function() {
      // $.alert("ds");
      scholarshipStageList()
    })

    $(document).on("click", ".updateStage", function() {
      var student_id = $(this).attr("data-std");
      var mn_id = $(this).attr("data-mn");
      var semester = $("#ssSemester").val();
      // $.alert("Set Scholarship " + student_id);
      $('#firstModalTitle').html("Update Scholarship Stages");
      $('#firstModalAction').val('updateStage');
      $('#modalId').val(student_id);
      $('#mnModalId').val(mn_id);
      $('#semesterModalId').val(semester);
      $("#scholarshipForm").hide();
      $("#stageForm").show();
      $('#firstModal').modal('show');
      // studentList()
    })

    $(document).on("click", ".removeStage", function() {
      var student_id = $(this).attr("data-std");
      var mn_id = $(this).attr("data-mn");
      var sscl_stage = $(this).attr("data-stage");
      // $.alert("Remove Stage " + student_id);
      $.post("<?php echo $phpFile; ?>", {
        student_id: student_id,
        mn_id: mn_id,
        sscl_stage: sscl_stage,
        action: "removeStage"
      }, function() {}, "text").done(function(data, status) {
        $.alert(data)
        scholarshipStageList()
      })
    })

    function scholarshipStageList() {
      var batchId = $("#sel_batch").val()
      var progId = $("#sel_program").val()
      var ssId = $("#sel_ss").val()
      var ssSemester = $("#ssSemester").val()

      // $.alert("leet " + leet + " Batch " + batchId + "Prog" + progId + " SS " + ssId);
      $.post("<?php echo $phpFile; ?>", {
        batchId: batchId,
        progId: progId,
        ssSemester: ssSemester,
        mn_id: ssId,
        action: "scholarshipStageList"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        console.log(data);
        var card = '';
        var count = 1;
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td>' + count++ + '</td>';
          card += '<td>' + value.user_id + '</td>';
          card += '<td>' + value.student_name + '</td>';
          card += '<td>' + value.student_fname + '</td>';
          card += '<td>' + value.student_rollno + '</td>';
          card += '<td>' + value.mn_name + '</td>';
          card += '<td>' + value.sscl_amount + '</td>';
          if (value.sscl_stage == "1") card += '<td>Scholarship Type</td>';
          else if (value.sscl_stage == "2") card += '<td class="text-center">Applied</td>';
          else if (value.sscl_stage == "3") card += '<td class="text-center">Sacntioned</td>';
          else if (value.sscl_stage == "4") card += '<td class="text-center">Released</td>';
          else if (value.sscl_stage == "5") card += '<td class="text-center">Deposited</td>';
          else card += '<td class="text-center">--</td>';
          card += '<td>' + getFormattedDate(value.sscl_date, "dmY") + '</td>';
          card += '<td class="text-center"><a href="#" class="fa fa-plus-circle largeText updateStage" data-std="' + value.student_id + '" data-mn="' + value.mn_id + '"></a>';
          card += '<a href="#" class="largeText warning removeStage" data-std="' + value.student_id + '" data-mn="' + value.mn_id + '" data-stage="' + value.sscl_stage + '"><i class="fa fa-times"></i></a></td>';
          card += '</tr>';
        });
        $("#scholarshipStageTable").find("tr:gt(0)").remove();
        $("#scholarshipStageTable").append(card);

      }).fail(function() {
        $.alert("Error !!");
      })
    }

    $(document).on("click", ".ss, .showSSList", function() {
      // $.alert("ds");
      studentList()
    })

    $(document).on("click", ".setScholarship", function() {
      var selectScholarship = '';
      var student_id = $(this).attr("data-std");
      var semester = $("#ssSemester").val();
      $.alert("Set Scholarship " + student_id + " Sem " + semester);
      $('#firstModalTitle').html("Update Scholarship");
      $('#firstModalAction').val('updateScholarship');
      $('#modalId').val(student_id);
      $('#semesterModalId').val(semester);
      $("#scholarshipForm").show();
      $("#stageForm").hide();
      $('#firstModal').modal('show');
      // studentList()
    })

    $(document).on('submit', "#firstModalForm", function() {
      var action = $("#firstModalAction").val();
      // $("#scl" + student_id).html(scholarship)
      event.preventDefault();
      var formData = $(this).serialize();
      $.alert(formData);
      $.post("scholarshipSql.php", formData, () => {}, "text").done(function(data, status) {
        // $.alert(data)
        if (action == "updateScholarship") studentList();
        else if (action == "updateStage") scholarshipStageList();
      })
      $("#firstModalForm")[0].reset;
      $('#firstModal').modal('hide');
    })

    $(document).on("click", ".deleteScholarship", function() {
      var student_id = $(this).attr("data-std");
      var mn_id = $(this).attr("data-mn");
      // $.alert("Delete Scholarship " + student_id + " mn " + mn_id);
      $('#deletetModalTitle').html("Remove Scholarship");
      $('#deleteModalAction').val('deleteScholarship');
      $('#deleteButtonModal').html('Delete');
      $('#deleteModalId').val(student_id);
      $('#deleteScholarshipId').val(mn_id);
      $('#deleteModal').modal('show');
      // studentList()
    })

    $(document).on('submit', "#deleteModalForm", function() {
      var student_id = $("#modalId").val();
      var mn_id = $("#sel_ss").val();
      event.preventDefault();
      var formData = $(this).serialize();
      // $.alert(formData);
      $.post("scholarshipSql.php", formData, () => {}, "text").done(function(data, status) {
        // $.alert(data)
        studentList();
      })
      $('#deleteModal').modal('hide');
    })

    function studentList() {
      var batchId = $("#sel_batch").val()
      var progId = $("#sel_program").val()
      var ssId = $("#sel_ss").val()
      var ssSemester = $("#ssSemester").val()
      if ($('#leet').is(":checked")) var leet = 1;
      else var leet = 0;
      if ($('#ay').is(":checked")) var ay = 1;
      else var ay = 0;
      if ($('#deleted').is(":checked")) var deleted = 1;
      else var deleted = 0;
      // $.alert("leet " + leet + " Batch " + batchId + "Prog" + progId + " SS " + ssId);
      $.post("<?php echo $phpFile; ?>", {
        batchId: batchId,
        progId: progId,
        ssSemester: ssSemester,
        mn_id: ssId,
        leet: leet,
        ay: ay,
        deleted: deleted,
        action: "studentList"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        console.log(data);
        var card = '';
        var count = 1;
        $.each(data, function(key, value) {
          var student_lateral = value.student_lateral;
          if (leet == '1' && leet != student_lateral) var skip = 'Y'
          else var skip = 'N'
          if (skip == 'N') {
            card += '<tr>';
            card += '<td>' + count++ + '</td>';
            card += '<td>' + value.student_id + '</td>';
            card += '<td>' + value.user_id + '</td>';
            card += '<td>' + value.student_name + '</td>';
            card += '<td>' + value.student_fname + '</td>';
            card += '<td>' + value.sp_abbri + '</td>';
            card += '<td>' + value.student_rollno + '</td>';
            card += '<td>' + value.student_mobile + '</td>';
            card += '<td>';
            if (value.scholarship.length == 0) card += '--';
            else {
              $.each(value.scholarship, function(key2, value2) {
                card += value2.mn_name + "[" + value2.sscl_amount + "]";
                card += '<a href="#" class="deleteScholarship" data-std="' + value.student_id + '" data-mn="' + value2.mn_id + '"><i class="fa fa-times"></i></a><br>';
              })
            }
            card += '</td>';
            card += '<td class="click text-center"><span class="inputScholarship" id="scl' + value.student_id + '">';
            card += '<a href="#" class="fa fa-plus-circle largeText setScholarship" data-std="' + value.student_id + '"></a>';
            card += '</span></td>';
            card += '</tr>';
          }
        });
        $("#studentStatusTable").find("tr:gt(0)").remove();
        $("#studentStatusTable").append(card);

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
  });

  function printDiv(print) {
    // $.alert("In print");
    var backup = document.body.innerHTML;
    var divContent = document.getElementById(print).innerHTML;
    document.body.innerHTML = divContent;
    window.print();
    document.body.innerHTML = backup;
  }

  function export_data() {
    let data = document.getElementById('studentStatusTable');
    var fp = XLSX.utils.table_to_book(data, {
      sheet: 'sheet1'
    });
    XLSX.write(fp, {
      bookType: 'xlsx',
      type: 'base64'
    });
    XLSX.writeFile(fp, 'studentStatusTable.xlsx');
  }
  function export_stage() {
    let data = document.getElementById('scholarshipStageTable');
    var fp = XLSX.utils.table_to_book(data, {
      sheet: 'sheet1'
    });
    XLSX.write(fp, {
      bookType: 'xlsx',
      type: 'base64'
    });
    XLSX.writeFile(fp, 'scholarshipStageTable.xlsx');
  }
</script>
<div class="modal" id="firstModal">
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" id="firstModalForm">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="firstModalTitle"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->
        <!-- Modal body -->
        <div class="modal-body">
          <div id="scholarshipForm">
            <div class="form-group row">
              <label class="control-label col-6" for="batch">Update Scholarship</label>
              <div class="col-sm-6">
                <?php
                $sql = "select * from master_name where mn_code='scl'";
                $result = $conn->query($sql);
                if ($result) {
                  $html = '<select class="form-control form-control-sm" name="sel_ss" id="sel_ss">';
                  $html .= '<option selected disabled>Scholarship</option>';
                  while ($rows = $result->fetch_assoc()) {
                    $select_id = $rows['mn_id'];
                    $select_name = $rows['mn_name'];
                    $html .= '<option value="' . $select_id . '">' . $select_name . '</option>';
                  }
                  $html .= '</select>';
                } else echo $conn->error;
                if ($result->num_rows == 0) echo 'No Data Found';
                echo $html;
                ?>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-6" for="batch">Scholarship Amount</label>
              <div class="col-sm-6">
                <input type="number" class="form-control form-control-sm" id="sscl_amount" name="sscl_amount" value="1" min="1">
              </div>
            </div>
          </div>
          <div id="stageForm">
            <div class="form-group row">
              <label class="control-label col-6" for="batch">Update Scholarship</label>
              <div class="col-sm-6">
                <select class="form-control form-control-sm" name="sel_stage" id="sel_stage">';
                  <option selected disabled>Scholarship Stage</option>
                  <option value="2">Applied</option>
                  <option value="3">Sanctioned</option>
                  <option value="4">Released</option>
                  <option value="5">Deposited</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-6" for="batch">Updated On</label>
              <div class="col-sm-6">
                <input type="date" class="form-control form-control-sm" id="sscl_date" name="sscl_date" value="<?php echo $submit_date; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="control-label col-6" for="batch">Amount</label>
              <div class="col-sm-6">
                <input type="number" class="form-control form-control-sm" id="stage_amount" name="stage_amount" value="1" min="1">
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="firstModalAction" name="action">
          <input type="hidden" id="modalId" name="student_id">
          <input type="hidden" id="mnModalId" name="mn_id">
          <input type="hidden" id="semesterModalId" name="ssSemester">
          <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->
<div class="modal" id="deleteModal">
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" id="deleteModalForm">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Please Confirm !! </h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->
        <!-- Modal body -->
        <div class="modal-body">
          <p class="warning largeText">Deleting Scholarship will remove all data pertaining to the Scholarship of the Selected Student.</p>
          <span class="warning">Are you Sure??</span>
        </div> <!-- Modal Body Closed-->

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="deleteModalAction" name="action">
          <input type="hidden" id="deleteModalId" name="student_id">
          <input type="hidden" id="deleteScholarshipId" name="mn_id">
          <button type="submit" class="btn btn-secondary btn-sm" id="deleteButtonModal"></button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->