<?php
require('../requireSubModule.php');
$phpFile = "hostelSql.php";
addActivity($conn, $myId, "Manage Student - Admission", $submit_ts);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Outcome Based Education : AcadPlus</title>
  <?php require("../css.php"); ?>
</head>

<body>
  <?php require("../topBar.php");
  if ($myId > 3) {
    if (!isset($_GET['tag'])) die("Illegal Attempt !! The token is Missing");
    elseif (!in_array($_GET['tag'], $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
    elseif (!in_array("26", $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
  }
  ?>
  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-1 p-0 m-0 pl-1 full-height">
        <div class="mt-3">
          <h5>Students</h5>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active ha" data-toggle="list" href="#ha" role="tab" aria-controls="ha"> Hostel Allotment</a>
          <a class="list-group-item list-group-item-action" data-toggle="list" href="#da" role="tab" aria-controls="da">Daily Attendance</a>
          <a class="list-group-item list-group-item-action sl" data-toggle="list" href="#sl" role="tab" aria-controls="sr">Student List</a>
        </div>
      </div>
      <div class="col-11 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <div class="row">
            <div class="col-md-1 pr-0">
              <div class="card border-info">
                <div class="input-group">
                  <?php
                  $sql_batch = "select * from batch where batch_status='0' order by batch desc";
                  $result = $conn->query($sql_batch);
                  if ($result) {
                    echo '<select class="form-control form-control-sm" name="sel_batch" id="sel_batch" required>';
                    // echo '<option selected disabled>Select Batch</option>';
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
            <div class="col-md-1 pl-1 pr-0">
              <div class="card border-info">
                <div class="input-group">
                  <select class="form-control form-control-sm" name="sel_gender" id="sel_gender">
                    <option value="M">Male</option>';
                    <option value="F">Female</option>';
                    <option value="ALL">ALL</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-1 mt-2">
              <a class="largeText fa fa-refresh ShowStudentList" style="color:yellowgreen"></a>
            </div>
            <div class="col-3">
              <div class="row">
                <div class="col-md-7 pr-0">
                  <div class="card border-info">
                    <div class="input-group">
                      <input name="studentSearch" id="studentSearch" class="form-control form-control-sm" type="text" placeholder="Search Student" aria-label="Search">
                    </div>
                  </div>
                </div>
                <div class="col-md-3 pl-1 pr-0">
                  <a class="fa fa-search xlText" id="searchStudent"></a>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane show active" id="ha" role="tabpanel" aria-labelledby="ha">
            <div class="row mt-2">
              <div class="col-md-9 pr-0">
                <div class="container card myCard">
                  <div class="row mt-2">
                    <div class="col-md-2 pr-0">
                      <input type="date" class="form-control form-control-sm" id="sel_date" name="sel_date" value="<?php echo $submit_date; ?>" />
                    </div>
                    <div class="col-md-8 pl-1 pr-0 mt-2">
                    <a class="largeText fa fa-refresh ShowStudentList text-secondary"></a>
                    </div>
                    <div class="col-md-1 pl-1 pr-0">
                      <div class="card border-info">
                        <div class="input-group">
                          <?php
                          $sql = "select * from block where block_type='Hostel'";
                          $result = $conn->query($sql);
                          if ($result) {
                            echo '<select class="form-control form-control-sm" id="sel_block" name="sel_block">';
                            while ($rows = $result->fetch_assoc()) {
                              $select_id = $rows['block_id'];
                              $select_name = $rows['block_name'];
                              echo '<option value="' . $select_id . '">' . $select_name . '</option>';
                            }
                            echo '<option value="0">No Hostel</option>';
                            echo '</select>';
                          } else echo $conn->error;
                          if ($result->num_rows == 0) echo 'No Data Found';
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-1 pl-1 pr-0 mt-2">
                      <a class="largeText fa fa-refresh text-danger" id="hostelUpdate" title="Assign the Checked Students to the Selected Hostel"></a>
                    </div>
                  </div>
                  <table class="table table-bordered table-striped list-table-xs mt-2" id="studentStatusTable">
                    <tr>
                      <th>#</th>
                      <th><input type="checkbox" id="checkall" /></th>
                      <th>Id</th>
                      <th>UserId</th>
                      <th>Roll No.</th>
                      <th>Name</th>
                      <th>Morng</th>
                      <th>Evng</th>
                      <th>M/F</th>
                      <th>Father Name</th>
                      <th>Prog[Sp]</th>
                      <th>Mobile</th>
                      <th>Acad</th>
                      <th>Adms</th>

                    </tr>
                  </table>
                </div>
              </div>
              <div class="col-md-3 pl-1 pr-0">
                <div class="container card myCard">
                  <div class="row mt-2">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-9">
                          <table width="100%">
                            <tr>
                              <td width="60%"><span class="footNote">User Id </span></td>
                              <td class="footNote" id="studentIdPill">---</td>
                            </tr>
                            <tr>
                              <td width="60%"><span class="footNote">Admission Year </span></td>
                              <td class="footNote batchName">---</td>
                            </tr>
                            <tr>
                              <td><span class="footNote">Program </span></td>
                              <td class="footNote progName">---</td>
                            </tr>
                            <tr>
                              <td><span class="footNote">Admission Semester </span></td>
                              <td class="footNote semesterName">---</td>
                            </tr>
                            <tr>
                              <td><span class="footNote">Academic Year </span></td>
                              <td class="footNote ayName">---</td>
                            </tr>
                            <tr>
                              <td><span class="footNote"> Current Status </span></td>
                              <td class="warning">
                                <h4><span id="status">---</span></h4>
                              </td>
                            </tr>
                            <tr>
                              <td width="60%"><span class="footNote"> Id </span></td>
                              <td class="footNote homeId">---</td>
                            </tr>
                          </table>

                        </div>
                        <div class="col-md-3"></div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="da" role="tabpanel" aria-labelledby="da">
            <div class="row">
              <div class="col-10">
                <div class="container card m-2 myCard">

                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="sl" role="tabpanel" aria-labelledby="sl">
            <div class="row">
              <div class="col-6">
                <div class="card m-2 myCard">
                  <div class="row m-2 mb-0">
                    <div class="col-md-12">
                      <div class="text-right">
                        <a class="fa fa-refresh largeText text-primary stdStrength"></a>
                      </div>
                      <p id="studentProgramReport"></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <p class="hostelList"></p>
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

    studentList();

    function studentList() {
      var batchId = $("#sel_batch").val()
      var blockId = $("#sel_block").val()
      var gender = $("#sel_gender").val()
      var sel_date = $("#sel_date").val()

      // $.alert(" Batch " + batchId + "Prog" + progId);
      $.post("<?php echo $phpFile; ?>", {
        batchId: batchId,
        blockId: blockId,
        sel_date: sel_date,
        gender: gender,
        action: "studentList"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        console.log(data);
        var card = '';
        var count = 1;
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td>' + count++ + '</td>';
          if (value.hs == "1") card += '<td class="text-center"><input type="checkbox" class="checkitem" checked value="' + value.student_id + '"/></td>';
          else card += '<td class="text-center"><input type="checkbox" class="checkitem" value="' + value.student_id + '"/></td>';
          card += '<td>' + value.student_id + '</td>';
          card += '<td>' + value.user_id + '</td>';
          card += '<td>' + value.student_rollno + '</td>';
          card += '<td>' + value.student_name + '</td>';
          card += '<td class="text-center">';
          if (value.haM == "1") card += '<label class="switch"><input type="checkbox" checked class="hostelAttendance" data-std="' + value.student_id + '" data-tag="ha_morning"><span class="slider round"></span></label>'
          else card += '<label class="switch"><input type="checkbox" class="hostelAttendance" data-std="' + value.student_id + '" data-tag="ha_morning"><span class="slider round"></span></label>'
          card += '</td>';
          card += '<td class="text-center">';
          if (value.haE == "1") card += '<label class="switch"><input type="checkbox" class="hostelAttendance" checked data-std="' + value.student_id + '" data-tag="ha_evening"><span class="slider round"></span></label>'
          else card += '<label class="switch"><input type="checkbox" class="hostelAttendance" data-std="' + value.student_id + '" data-tag="ha_evening"><span class="slider round"></span></label>'
          card += '</td>';
          card += '<td>' + value.student_gender + '</td>';
          card += '<td>' + value.student_fname + '</td>';
          card += '<td>' + value.sp_abbri + '</td>';
          card += '<td>' + value.student_mobile + '</td>';
          card += '<td>' + value.student_batch + '</td>';
          card += '<td>' + value.student_ay + '</td>';
          card += '</tr>';
        });
        $("#studentStatusTable").find("tr:gt(0)").remove();
        $("#studentStatusTable").append(card);
      }).fail(function() {
        $.alert("Error !!");
      })
    }

    $(document).on('click', ".ShowStudentList", function() {
      studentList();
    });

    $(document).on('change', "#sel_block", function() {
      studentList();
    });

    $(document).on('click', ".hostelAttendance", function() {
      var sel_date = $("#sel_date").val()
      var student_id = $(this).attr("data-std")
      var tag = $(this).attr("data-tag")

      if ($(this).is(":checked")) var attendance = 1;
      else var attendance = 0;

      // $.alert(student_id + " Tag" + tag + " - " + attendance + "date " + sel_date)
      $.post("<?php echo $phpFile; ?>", {
        student_id: student_id,
        tag: tag,
        attendance: attendance,
        sel_date: sel_date,
        action: "attendanceUpdate"
      }, function() {}, "text").done(function(data, status) {
        // $.alert(data)
      }).fail(function() {
        $.alert("Fail");
      })
    });

    $(document).on('click', '#hostelUpdate', function() {
      var batchId = $("#sel_batch").val()
      var blockId = $("#sel_block").val()

      var checkboxes_value = [];
      $('.checkitem').each(function() {
        if (this.checked) {
          checkboxes_value.push($(this).val());
        }
      });
      // $.alert("Batch " + batchId + " Prog " + progId + " blockId " + blockId + " Cheked " + checkboxes_value);
      $.post("<?php echo $phpFile; ?>", {
        batchId: batchId,
        blockId: blockId,
        checkboxes_value: checkboxes_value,
        action: "hostelUpdate"
      }, function() {}, "text").done(function(data, status) {
        $.alert("Updated")
      }).fail(function() {
        $.alert("Fail");
      })
    });

    $(document).on('click', '#searchStudent', function(event) {
      var data = $("#studentSearch").val();
      // $.alert(data);
      $.post("<?php echo $phpFile; ?>", {
        action: "fetchStudent",
        userId: data,
      }, () => {}, "json").done(function(data, status) {
        // $.alert(data);
        if (data == null) {
          $.alert("No Student Found!!");
          $("#studentIdHidden").val(null);
        } else {
          $("#studentIdHidden").val(data.student_id);

          if (data.student_status == '9') $("#status").html("Deleted");
          else if (data.student_status == '0') $("#status").html("Active");


          $("#stdName").val(data.student_name);
          $("#stdRno").val(data.student_rollno);
          $("#stdMobile").val(data.student_mobile);
          $("#stdEmail").val(data.student_email);

          $("#sel_srs").val(data.student_residential_status);

          $("#stdAdmission").val(data.student_admission);
          $("#fName").val(data.student_fname);
          $("#mName").val(data.student_mname);

          var text = data.program_abbri + " : " + data.sp_abbri
          $(".progName").html(text);

          $(".batchName").html(data.batch);
          $(".semesterName").html(data.student_semester);
          $(".homeId").html(data.student_id);
          $.post("<?php echo $phpFile; ?>", {
            userId: data.user_id,
            action: "fetchAcademicBatch"
          }, () => {}, "json").done(function(data, status) {
            $(".ayName").html(data.batch);
          })
        }
        // $.alert(data);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    $("#checkall").change(function() {
      $(".checkitem").prop("checked", $(this).prop("checked"))
    })

    $(document).on('click', '.stdStrength', function() {
      var batchId = $("#sel_batch").val()
      //  $.alert("In List Function");
      $.post("<?php echo $phpFile; ?>", {
        batchId: batchId,
        action: "studentProgramList",
      }, function(mydata, mystatus) {
        // $.alert("List qulai" + mydata);
        $("#studentProgramReport").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
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

</html>