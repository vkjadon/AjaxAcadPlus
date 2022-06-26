<?php
require('../requireSubModule.php');
$phpFile = "scholarshipSql.php";
addActivity($conn, $myId, "Scholarship", $submit_ts);

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
    elseif (!in_array("44", $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
  }
	?>  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-1 p-0 m-0 pl-1 full-height">
        <div class="mt-3">
          <h5>Scholarship</h5>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active" id="list-ss-list" data-toggle="list" href="#list-ss" role="tab" aria-controls="ss">Scholarship</a>
          <a class="list-group-item list-group-item-action" id="list-stage-list" data-toggle="list" href="#list-stage" role="tab" aria-controls="stage">Update Stage</a>
        </div>
      </div>
      <div class="col-11 p-0">
        <div class="row bg-light p-2 m-0">
          <div class="col-md-6">
            <?php require("../setDefaultModule.php"); ?>
          </div>
          <div class="col-md-1">
            <div class="card border-info">
              <div class="input-group">
                <input type="number" class="form-control form-control-sm" id="ssSemester" name="ssSemester" min="1" value="1" title="Semester">
              </div>
            </div>
          </div>
        </div>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane show active fade" id="list-ss" role="tabpanel" aria-labelledby="list-ss-list">
            <div class="row">
              <div class="col-10">
                <div class="container card m-2 myCard">
                  <div class="row mt-2">
                    <div class="col-md-1">
                      <a href="#" class="fa fa-refresh showSSList" id="showSSList" title="Reload the Student List"></a>
                    </div>
                    <div class="col-md-10">
                      <div class="text-center text-primary footNote">Showing all the Students EXCEPT General in Caste Category</div>
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
                        <th>Prog-Sp</th>
                        <th>Roll No.</th>
                        <th>Mobile</th>
                        <th>Cat</th>
                        <th>FeeCat</th>
                        <th>Religion</th>
                        <th>Address</th>
                        <th>State</th>
                        <th>Scholarship</th>
                        <th>Action</th>
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
                        <th><i class="fa fa-clock largeText text-secondary"></i></th>
                        <th>Applied</th>
                        <th><i class="fa fa-clock largeText text-warning"></i></th>
                        <th>Sanctioned</th>
                        <th><i class="fa fa-clock largeText text-info"></i></th>
                        <th>Released</th>
                        <th><i class="fa fa-clock largeText text-primary"></i></th>
                        <th>Deposited</th>
                        <th><i class="fa fa-clock largeText text-success"></i></th>
                        <th><i class="fa fa-edit largeText text-danger"></i></th>
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

    studentList()
    // scholarshipStageList()
    function studentList() {
      var batchId = $("#sel_batch").val()
      var progId = $("#sel_program").val()
      var ssSemester = $("#ssSemester").val()
      // $.alert("leet " + leet + " Batch " + batchId + "Prog" + progId + " SS " + ssId);
      $.post("<?php echo $phpFile; ?>", {
        batchId: batchId,
        progId: progId,
        ssSemester: ssSemester,
        action: "studentList"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        // console.log(data);
        var card = '';
        var count = 1;
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td>' + count++ + '</td>';
          card += '<td>' + value.student_id + '</td>';
          card += '<td>' + value.user_id + '</td>';
          card += '<td>' + value.student_name + '</td>';
          card += '<td>' + value.student_fname + '</td>';
          card += '<td>' + "<?php echo $mySpAbbri; ?>" + '</td>';
          card += '<td>' + value.student_rollno + '</td>';
          card += '<td>' + value.student_mobile + '</td>';
          card += '<td title="Caste Category">' + value.student_category + '</td>';
          card += '<td title="Fee Category">' + value.student_fee_category + '</td>';
          card += '<td>' + value.student_religion + '</td>';
          card += '<td>' + value.permanent_address + '</td>';
          card += '<td>' + value.state + '</td>';
          card += '<td>';
          if (value.scholarship.length == 0) card += '--';
          else {
            $.each(value.scholarship, function(key2, value2) {
              card += value2.mn_name + "[" + value2.scholarship_amount + "]";
              card += '<a href="#" class="deleteScholarship" data-std="' + value.student_id + '" data-mn="' + value2.mn_id + '"><i class="fa fa-times"></i></a><br>';
            })
          }
          card += '</td>';

          card += '<td><span class="inputScholarship" id="scl' + value.student_id + '">';
          card += '<a href="#" class="fa fa-plus-circle largeText setScholarship" data-std="' + value.student_id + '"></a>';
          card += '</span></td>';
          card += '</tr>';
        });
        $("#studentStatusTable").find("tr:gt(0)").remove();
        $("#studentStatusTable").append(card);

      }).fail(function() {
        $.alert("Error !!");
      })
    }

    $(document).on("click", ".showSSList, .showStageList", function() {
      // $.alert("ds");
      scholarshipStageList()
      studentList()
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
        // console.log(data);
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
          card += '<td>' + value.scholarship_amount + '</td>';          
          card += '<td>' + value.scholarship_ts + '</td>';
          card += '<td>' + value.applied_amount + '</td>';          
          card += '<td>' + value.applied_ts + '</td>';
          card += '<td>' + value.sanctioned_amount + '</td>';
          card += '<td>' + value.sanctioned_ts + '</td>';
          card += '<td>' + value.released_amount + '</td>';
          card += '<td>' + value.released_ts + '</td>';
          card += '<td>' + value.deposited_amount + '</td>';
          card += '<td>' + value.deposited_ts + '</td>';
          card += '<td class="text-center"><a href="#" class="fa fa-edit largeText updateStage" data-std="' + value.student_id + '" data-mn="' + value.mn_id + '"></a>';
          card += '</tr>';
        });
        $("#scholarshipStageTable").find("tr:gt(0)").remove();
        $("#scholarshipStageTable").append(card);

      }).fail(function() {
        $.alert("Error !!");
      })
    }

    $(document).on("click", ".updateData", function() {
      var batchId = $("#sel_batch").val()
      var progId = $("#sel_program").val()
      var ssSemester = $("#ssSemester").val()
      // $.alert(" Batch " + batchId + "Prog" + progId);
      $.post("<?php echo $phpFile; ?>", {
        batchId: batchId,
        progId: progId,
        ssSemester: ssSemester,
        action: "updateData"
      }, function() {}, "text").done(function(data, status) {
        $.alert(data);
      }).fail(function() {
        $.alert("Error !!");
      })
    })

    $(document).on("click", ".setScholarship", function() {
      var selectScholarship = '';
      var student_id = $(this).attr("data-std");
      var semester = $("#ssSemester").val();
      // $.alert("Set Scholarship " + student_id + " Sem " + semester);
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
      // $.alert(formData);
      $.post("scholarshipSql.php", formData, () => {}, "text").done(function(data, status) {
        $.alert(data)
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

    $(document).on('change', '#sel_program', function() {
      var x = $("#sel_program").val();
      // $.alert("Program Changed " + x);
      $.post("../../util/session_variable.php", {
        action: "setProgram",
        programId: x
      }, function(mydata, mystatus) {
        // $.alert("- Program Updated -" + mydata);
        location.reload();
      }).fail(function() {
        $.alert("Error in Program!!");
      })
    })
    $(document).on('change', '#sel_batch', function() {
      var x = $("#sel_batch").val();
      //$.alert("Batch Changed " + x);
      $.post("../../util/session_variable.php", {
        action: "setBatch",
        batchId: x
      }, function(mydata, mystatus) {
        //$.alert("- Batch Updated -" + mydata);
        location.reload();
      }, "text").fail(function() {
        $.alert("Error in Natch !!");
      })
    })
    $(document).on('change', '#sel_dept', function() {
      var x = $("#sel_dept").val();
      //$.alert("Session  Changed " + x);
      $.post("../../util/session_variable.php", {
        deptId: x,
        action: "setDept"
      }, function(mydata, mystatus) {
        //alert("- Session Updated -" + mydata);
        location.reload();
      }, "text").fail(function() {
        $.alert("Erro Dept !!");
      })
    })
    $(document).on('change', '#sel_school', function() {
      var x = $("#sel_school").val();
      //$.alert("Session  Changed " + x);
      $.post("../../util/session_variable.php", {
        schoolId: x,
        action: "setSchool",
      }, function(mydata, mystatus) {
        //alert("- School Updated -" + mydata);
        location.reload();
        $("#sel_dept").val("0")
      }, "text").fail(function() {
        $.alert("Error in School!!");
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
                  <option value="2">Applied</option>
                  <option value="3">Sanctioned</option>
                  <option value="4">Released</option>
                  <option value="5">Deposited</option>
                </select>
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