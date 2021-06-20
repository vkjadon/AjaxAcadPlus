<?php
require('../requireSubModule.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Outcome Based Education : AcadPlus</title>
  <?php require("../css.php"); ?>
  <style>
    .collapsible-link::before {
      content: '';
      width: 14px;
      height: 2px;
      background: #333;
      position: absolute;
      top: calc(50% - 1px);
      right: 1rem;
      display: block;
      transition: all 0.3s;
    }

    /* Vertical line */
    .collapsible-link::after {
      content: '';
      width: 2px;
      height: 14px;
      background: #333;
      position: absolute;
      top: calc(50% - 7px);
      right: calc(1rem + 6px);
      display: block;
      transition: all 0.3s;
    }

    .collapsible-link[aria-expanded='true']::after {
      transform: rotate(90deg) translateX(-1px);
    }

    .collapsible-link[aria-expanded='true']::before {
      transform: rotate(180deg);
    }

    .collapseAccordian {
      background-color: #e1f5fe;
    }

    .collapseHeader {
      background-color: #29b6f6;
    }
  </style>
</head>

<body>
  <?php require("../topBar.php"); ?>
  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-2 p-0 m-0 pl-2 full-height">
        <div class="mt-2">
          <h5>Manage Students</h5>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active as" id="list-as-list" data-toggle="list" href="#list-as" role="tab" aria-controls="as"> Add Student </a>
          <a class="list-group-item list-group-item-action sr" id="list-sr-list" data-toggle="list" href="#list-sr" role="tab" aria-controls="sr">Student Report</a>
          <a class="list-group-item list-group-item-action cbp" id="list-cbp-list" data-toggle="list" href="#list-cbp" role="tab" aria-controls="cbp">Change Batch/Program</a>
        </div>
      </div>
      <div class="col-10 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane show active" id="list-as" role="tabpanel" aria-labelledby="list-as-list">
            <div class="row">
              <div class="col-6">
                <div class="row ml-2">
                  <h3 class="mb-0 py-0">
                    <a class="fa fa-plus-circle addStudent"></a>
                    <a class="fa fa-arrow-circle-up uploadStudent"></a>
                  </h3>
                </div>
                <div class="container card mt-2 myCard">
                  <!-- nav options -->
                  <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="pill" href="#pills_home" role="tab" aria-controls="pills_home" aria-selected="true">Home</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="pill" href="#pills_personalInfo" role="tab" aria-controls="pills_personalInfo" aria-selected="true">Personal Info</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="pill" href="#pills_parentsInfo" role="tab" aria-controls="pills_parentsInfo" aria-selected="true">Parents Info</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link pills_qualification" data-toggle="pill" href="#pills_qualification" role="tab" aria-controls="pills_qualification" aria-selected="true">Qualification</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="pills-tabContent p-3">
                    <div class="tab-pane show active" id="pills_home" role="tabpanel" aria-labelledby="pills_home">
                      <div class="row p-1">
                        <div class="col-3 m-0 p-0">
                          <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="100">
                        </div>
                        <div class="col-9 m-0 p-0">
                          <div class="row p-1">
                            <div class="col-3 m-0 p-0">
                              <h7 class="mb-0 ">Name</h7>
                            </div>
                            <div class="col-9 text-secondary student_name">
                              Enter Valid Data
                            </div>
                          </div>
                          <div class="row p-1">
                            <div class="col-3 m-0 p-0">
                              <h7 class="mb-0 ">Roll Number</h7>
                            </div>
                            <div class="col-9 text-secondary student_rollno">
                              Enter Valid Data
                            </div>
                          </div>
                          <div class="row p-1">
                            <div class="col-3 m-0 p-0">
                              <h7 class="mb-0 ">Email</h7>
                            </div>
                            <div class="col-9 text-secondary student_email">
                              Enter Valid Data
                            </div>
                          </div>
                          <div class="row p-1">
                            <div class="col-3 m-0 p-0">
                              <h7 class="mb-0 ">Mobile</h7>
                            </div>
                            <div class="col-9 text-secondary student_mobile">
                              Enter Valid Data
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                    <div class="tab-pane fade" id="pills_personalInfo" role="tabpanel" aria-labelledby="pills_personalInfo">
                      <input type="hidden" id="studentIdHidden" name="studentIdHidden">
                      <div class="row">
                        <div class="col-12">
                          <div class="row">
                            <div class="col-4">
                              <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control form-control-sm studentUpdateForm" id="sName" name="sName" placeholder="Name of the Student" data-tag="student_name">
                              </div>
                            </div>
                            <div class="col-4">
                              <div class="form-group">
                                <label>Roll Number</label>
                                <input type="text" class="form-control form-control-sm studentUpdateForm" id="sRno" name="sRno" placeholder="Roll Number of the Student" data-tag="student_rollno">
                              </div>
                            </div>
                            <div class="col-4">
                              <div class="form-group">
                                <label>Mobile</label>
                                <input type="text" class="form-control form-control-sm studentUpdateForm" id="sMobile" name="sMobile" placeholder="Mobile Number of the Student" data-tag="student_mobile">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-6">
                              <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control form-control-sm studentUpdateForm" id="sEmail" name="sEmail" placeholder="Email ID of the Student" data-tag="student_email">
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-group">
                                <label>Date of Birth</label>
                                <input type="date" class="form-control form-control-sm studentUpdateForm" id="sDob" name="sDob" placeholder="Date of Birth" data-tag="student_dob">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-6">
                              <div class="form-check-inline">
                                <input type="radio" class="form-check-input studentUpdateForm" checked id="male" name="sGender" value="M" data-tag="student_gender">Male
                              </div>
                              <div class="form-check-inline">
                                <input type="radio" class="form-check-input studentUpdateForm" id="female" name="sGender" value="F" data-tag="student_gender">Female
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="form-check-inline">
                                <input type="radio" class="form-check-input studentUpdateForm" checked id="obc" name="sCategory" value="OBC" data-tag="student_category">OBC
                              </div>
                              <div class="form-check-inline">
                                <input type="radio" class="form-check-input studentUpdateForm" id="gen" name="sCategory" value="GEN" data-tag="student_category">General
                              </div>
                              <div class="form-check-inline">
                                <input type="radio" class="form-check-input studentUpdateForm" id="sc" name="sCategory" value="SC" data-tag="student_category">SC/ST
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12">
                              <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control form-control-sm studentUpdateForm" id="sAddress" name="sAddress" placeholder="" data-tag="student_address">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="pills_parentsInfo" role="tabpanel" aria-labelledby="pills_personalInfo">
                      <input type="hidden" id="studentIdHidden" name="studentIdHidden">
                      <div class="row">
                        <div class="col-4 pr-1">
                          <div class="form-group">
                            <label>Father Name</label>
                            <input type="text" class="form-control form-control-sm studentDetailForm" id="fName" name="fName" placeholder="Name of the Father" data-tag="student_fname">
                          </div>
                        </div>
                        <div class="col-4 pl-1 pr-1">
                          <div class="form-group">
                            <label>Occupation</label>
                            <input type="text" class="form-control form-control-sm studentDetailForm" id="fOccupation" name="fOccupation" placeholder="Occupation of the Father" data-tag="student_foccupation">
                          </div>
                        </div>
                        <div class="col-4 pl-1">
                          <div class="form-group">
                            <label>Designation</label>
                            <input type="text" class="form-control form-control-sm studentDetailForm" id="fDes" name="fDes" placeholder="Designation of the Father" data-tag="student_fdesignation">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-4 pr-1">
                          <div class="form-group">
                            <label>Mother Name</label>
                            <input type="text" class="form-control form-control-sm studentDetailForm" id="mName" name="mName" placeholder="Name of the Mother" data-tag="student_mname">
                          </div>
                        </div>
                        <div class="col-4 pr-1 pl-1">
                          <div class="form-group">
                            <label>Occupation</label>
                            <input type="text" class="form-control form-control-sm studentDetailForm" id="mOccupation" name="mOccupation" placeholder="Occupation of the Mother" data-tag="student_moccupation">
                          </div>
                        </div>
                        <div class="col-4 pl-1">
                          <div class="form-group">
                            <label>Designation</label>
                            <input type="text" class="form-control form-control-sm studentDetailForm" id="mDes" name="mDes" placeholder="Designation of the Mother" data-tag="student_mdesignation">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-3 pr-1">
                          <div class="form-group">
                            <label>Father Mobile</label>
                            <input type="text" class="form-control form-control-sm studentDetailForm" id="fMobile" name="fMobile" placeholder="Father's Mobile Number" data-tag="sc_fmobile">
                          </div>
                        </div>
                        <div class="col-3 pl-1 pr-1">
                          <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control form-control-sm studentDetailForm" id="fEmail" name="fEmail" placeholder="Father's Email Address" data-tag="sc_femail">
                          </div>
                        </div>
                        <div class="col-3 pl-1 pr-1">
                          <div class="form-group">
                            <label>Mother Mobile</label>
                            <input type="text" class="form-control form-control-sm studentDetailForm" id="mMobile" name="mMobile" placeholder="Mother's Mobile Number" data-tag="sc_mmobile">
                          </div>
                        </div>
                        <div class="col-3 pl-1">
                          <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control form-control-sm studentDetailForm" id="mEmail" name="mEmail" placeholder="Mother's Email Address" data-tag="sc_memail">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="pills_qualification" role="tabpanel" aria-labelledby="pills_qualification">
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            Qualification
                            <div class="row">
                              <div class="col">
                                <?php
                                $sql_qualification = "select * from qualification";
                                $result = $conn->query($sql_qualification);
                                if ($result) {
                                  echo '<select class="form-control form-control-sm sQualForm" name="sel_qual" id="sel_qual" data-tag="qualification_id" required>';
                                  echo '<option selected disabled>Select Qualification</option>';
                                  while ($rows = $result->fetch_assoc()) {
                                    $select_id = $rows['qualification_id'];
                                    $select_name = $rows['qualification_name'];
                                    echo '<option value="' . $select_id . '">' . $select_name . '</option>';
                                  }
                                  echo '</select>';
                                } else echo $conn->error;
                                if ($result->num_rows == 0) echo 'No Data Found';
                                ?>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            Institute
                            <input type="text" class="form-control form-control-sm sQualForm" id="sInst" name="sInst" placeholder="Name of the Institute" data-tag="sq_institute">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            Board
                            <input type="text" class="form-control form-control-sm sQualForm" id="sBoard" name="sBoard" placeholder="Board" data-tag="sq_board">
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            Year of Passing
                            <input type="text" class="form-control form-control-sm sQualForm" id="sYear" name="sYear" placeholder="Passing Year" data-tag="sq_year">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-4">
                          <div class="form-group">
                            Marks Obtained
                            <input type="text" class="form-control form-control-sm sQualForm" id="sMarksObt" name="sMarksObt" placeholder="Marks Obtained" data-tag="sq_marksObtained">
                          </div>
                        </div>
                        <div class="col-4">
                          <div class="form-group">
                            Maximum Marks
                            <input type="text" class="form-control form-control-sm sQualForm" id="sMaxMarks" name="sMaxMarks" placeholder="Maximum marks" data-tag="sq_marksMax">
                          </div>
                        </div>
                        <div class="col-4">
                          <div class="form-group">
                            Percentage/CGPA
                            <input type="text" class="form-control form-control-sm sQualForm" id="sCgpa" name="sCgpa" placeholder="Percentage/CGPA" data-tag="sq_percentage">
                          </div>
                        </div>
                      </div>
                      <p style="text-align:center" id="qualificationShowList"></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <h5 class="mb-3">Student List</h5>
                <div class="container card myCard">
                  <div class="input-group md-form form-sm form-2 mt-1">
                    <input name="studentSearch" id="studentSearch" class="form-control my-0 py-1 red-border" type="text" placeholder="Search Student" aria-label="Search">
                    <div class="input-group-append">
                      <span class="input-group-text cyan lighten-3" id="basic-text1"><i class="fas fa-search text-grey" aria-hidden="true"></i></span>
                    </div>
                  </div>
                  <div class='list-group' id="studentAutoList"></div>
                </div>
                <div class="container card mt-2 myCard">
                  <table class="table table-bordered table-striped list-table-xs mt-3" id="studentShowList">
                    <th><i class="fas fa-edit"></i></th>
                    <th>Name</th>
                    <th>RollNo</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Action</th>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-sr" role="tabpanel" aria-labelledby="list-sr-list">
            <div class="row">
              <div class="col-4">
                <p id="studentProgramReport"></p>
              </div>
              <div class="col-8">
                <canvas id="horizontalBar"></canvas>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-cbp" role="tabpanel" aria-labelledby="list-cbp-list">
            <div class="row">
              <div class="col-8">
                <table class="table table-bordered table-striped list-table-xs" id="studentProgramTable">
                  <tr>
                    <th><input type="checkbox" id="checkall" /></th>
                    <th>Name</th>
                    <th>Roll Number</th>
                    <th>Batch</th>
                    <th>Program</th>
                  </tr>
                </table>
              </div>
              <div class="col-4">
                <div class="row">
                  <div class="card border-info mb-3" style="width:300px">
                    <div class="card-header">
                      Change Batch
                    </div>
                    <div class="card-body text-primary">
                      <form class="form-horizontal" id="changeBatch">
                        <div class="input-group">
                          <?php
                          $sql_batch = "select * from batch";
                          $result = $conn->query($sql_batch);
                          if ($result) {
                            echo '<select class="form-control form-control-sm" name="sel_batch" id="sel_batch" required>';
                            echo '<option selected disabled>Select Batch</option>';
                            while ($rows = $result->fetch_assoc()) {
                              $select_id = $rows['batch_id'];
                              $select_name = $rows['batch'];
                              echo '<option value="' . $select_id . '">' . $select_name . '</option>';
                            }
                            echo '</select>';
                          } else echo $conn->error;
                          if ($result->num_rows == 0) echo 'No Data Found';
                          ?>
                          <div class="input-group-append">
                            <button class="btn btn-primary btn-sm m-0" type="submit">Submit</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="card border-info mb-3" style="width:300px">
                    <div class="card-header">
                      Change Programme
                    </div>
                    <div class="card-body text-primary">
                      <form class="form-horizontal" id="changeProgram">
                        <div class="input-group">
                          <?php
                          $sql_program = "select * from program";
                          $result = $conn->query($sql_program);
                          if ($result) {
                            echo '<select class="form-control form-control-sm" name="sel_program" id="sel_program" required>';
                            echo '<option selected disabled>Select Program</option>';
                            while ($rows = $result->fetch_assoc()) {
                              $select_id = $rows['program_id'];
                              $select_name = $rows['sp_name'];
                              echo '<option value="' . $select_id . '">' . $select_name . '</option>';
                            }
                            echo '</select>';
                          } else echo $conn->error;
                          if ($result->num_rows == 0) echo 'No Data Found';
                          ?>
                          <div class="input-group-append">
                            <button class="btn btn-primary btn-sm m-0" type="submit">Submit</button>
                          </div>
                        </div>
                      </form>
                    </div>
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

<?php require("../js.php"); ?>

<script>
  $(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip();
    $('#list-as').show();
    $('#list-sr').hide();
    $('.studentProfile').hide();
    $('#accordionStudent').hide();
    studentList();

    $('#studentSearch').keyup(function() {
      var query = $(this).val();
      // alert(query);
      if (query != '') {
        $.ajax({
          url: "admissionSql.php",
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

    $(document).on('submit', '#changeBatch', function() {
      event.preventDefault(this);
      var batchId = $("#sel_batch").val()
      var checkboxes_value = [];
      $('.checkitem').each(function() {
        if (this.checked) {
          checkboxes_value.push($(this).val());
        }
      });
      // $.alert("Change Batch Pressed " + checkboxes_value);
      $.post("admissionSql.php", {
        action: "changeBatch",
        batchId: batchId,
        checkboxes_value: checkboxes_value,
      }, function(data, status) {
        $.alert(data);
      }, "text").fail(function() {
        $.alert("Fail");
      })
    });

    $(document).on('click', '.autoList', function() {
      $('#studentSearch').val($(this).text());
      var stdId = $(this).attr("data-std");
      $('#studentAutoList').fadeOut();
      $('#studentShowList').show();
      $('.studentProfile').show();
      $('#accordionStudent').show();

      $.post("admissionSql.php", {
        studentId: stdId,
        action: "fetchStudent"
      }, () => {}, "json").done(function(data) {
        $("#sName").val(data.student_name);
        $("#sRno").val(data.student_rollno);
        $("#sMobile").val(data.student_mobile);
        $("#sEmail").val(data.student_email);
        $("#sDob").val(data.student_dob);
        $("#sGender").val(data.student_gender);
        $("#sGender").val(data.student_category);
        $("#sAddress").val(data.student_address);
        
        // $("#sAdhaar").val(data.student_adhaar);
        $("#fName").val(data.student_fname);
        $("#fOccupation").val(data.student_foccupation);
        $("#fDes").val(data.student_fdesignation);
        $("#mName").val(data.student_mname);
        $("#mOccupation").val(data.student_moccupation);
        $("#mDes").val(data.student_mdesignation);

      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.sr', function() {
      $('#list-sr').show();
      $('#list-cbp').hide();
      $('#list-as').hide();
      $('#studentProgramReport').show();
      studentProgramReport();
    });

    $(document).on('click', '.cbp', function() {
      $('#list-cbp').show();
      $('#list-sr').hide();
      $('#list-as').hide();

      $.post("admissionSql.php", {
        action: "updateStudentList",
      }, () => {}, "json").done(function(data) {
        var student_data = '';
        $.each(data, function(key, value) {
          student_data += '<tr>';
          student_data += '<td><input type="checkbox" class="checkitem" value="' + value.student_id + '"/></td>';
          student_data += '<td>' + value.student_name + '</td>';
          student_data += '<td>' + value.student_rollno + '</td>';
          student_data += '<td>' + value.batch_id + '</td>';
          student_data += '<td>' + value.program_id + '</td>';
          student_data += '</tr>';
        });
        $("#studentProgramTable").append(student_data);
      }, "json").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $("#checkall").change(function() {
      $(".checkitem").prop("checked", $(this).prop("checked"))
    })

    $(document).on('click', '.as', function() {
      $(".selectPanel").show();
      $('#list-as').show();
      $('#list-sr').hide();
      $('#list-cbp').hide();
    });

    $(document).on('click', '.addStudent', function() {
      $('#modal_title').text("Add Student");
      $('#action').val("addStudent");
      $('#firstModal').modal('show');
      $('.selectPanel').show();
    });

    $(document).on('click', '.uploadStudent', function() {
      $('#modal_uploadTitle').text("Upload Student");
      $('#formModal').modal('show');
    });

    $(document).on('submit', '#upload_csv', function(event) {
      event.preventDefault();
      var formData = $(this).serialize();
      // $.alert(formData);
      // action and test_id are passed as hidden
      $.ajax({
        url: "uploadStudentSql.php",
        method: "POST",
        data: new FormData(this),
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false
        success: function(data) {
          // $.alert("heloo"+data);
          $('#formModal').modal('hide');
        }
      })
    });

    $(document).on('click', '.editStudent', function() {
      $('.studentProfile').show();
      $('#accordionStudent').show();
      var id = $(this).attr("data-student");
      $("#studentIdHidden").val(id);
      // studentQualificationList(id);

      $.post("admissionSql.php", {
        studentId: id,
        action: "fetchStudent"
      }, () => {}, "json").done(function(data) {
        $(".student_email").text(data.student_email);
        $(".student_name").text(data.student_name);
        $(".student_rollno").text(data.student_rollno);
        $(".student_mobile").text(data.student_mobile);

        $("#sName").val(data.student_name);
        $("#sRno").val(data.student_rollno);
        $("#sMobile").val(data.student_mobile);
        $("#sEmail").val(data.student_email);
        $("#sDob").val(data.student_dob);
        $("#sGender").val(data.student_gender);
        $("#sGender").val(data.student_category);
        $("#sAddress").val(data.student_address);
        
        // $("#sAdhaar").val(data.student_adhaar);
        $("#fName").val(data.student_fname);
        $("#fOccupation").val(data.student_foccupation);
        $("#fDes").val(data.student_fdesignation);
        $("#mName").val(data.student_mname);
        $("#mOccupation").val(data.student_moccupation);
        $("#mDes").val(data.student_mdesignation);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('blur', '.studentUpdateForm', function() {
      var studentId = $("#studentIdHidden").val()
      var tag = $(this).attr("data-tag")
      var value = $(this).val()
      // $.alert("Changes " + tag + " Value " + value + " Student " + studentId);
      $.post("admissionSql.php", {
        id_name: "student_id",
        id: studentId,
        tag: tag,
        value: value,
        action: "updateStudent"
      }, function(data) {
        // $.alert("List " + data);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('blur', '.studentDetailForm', function() {
      var studentId = $("#studentIdHidden").val()
      var tag = $(this).attr("data-tag")
      var value = $(this).val()
      $.alert("Changes " + tag + " Value " + value + " Student " + studentId);
      $.post("admissionSql.php", {
        tag: tag,
        student_id: studentId,
        value: value,
        action: "updateDetails"
      }, function(data) {
        $.alert("List " + data);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });


    $(document).on('blur', '.sQualForm', function() {
      var studentId = $("#studentIdHidden").val()
      var qId = $('#sel_qual').val()
      var tag = $(this).attr("data-tag")
      var value = $(this).val()
      // $.alert("Changes " + tag + " Value " + value + " Student " + studentId);
      if (qId === null) {
        $.confirm({
          title: 'Encountered an error!',
          content: 'Please Select Qualification First',
          type: 'red',
          typeAnimated: true,
          buttons: {
            tryAgain: {
              text: 'Try again',
              btnClass: 'btn-red',
              action: function() {}
            },
          }
        });
      } else {
        $.post("admissionSql.php", {
          id_name: "qualification_id",
          id: qId,
          tag: tag,
          student_id: studentId,
          value: value,
          action: "updateStudentQualification"
        }, function(data) {
          $.alert("List " + data);
        }, "text").fail(function() {
          $.alert("fail in place of error");
        })
      }
    });

    $(document).on('click', '.addStudentQualification', function() {
      $('#modal_title').text("Add Student Qualifications");
      $('#firstModal').modal('show');
      var stdId = $('#panelId').val();
      $('#stdIdModal').val(stdId);
      $('#action').val("addStudentQualification");
    });

    $(document).on('click', '.sq_idE', function() {
      var id = $(this).attr('id');
      var stdId = $('#panelId').val();
      // $.alert("Id " + id + "std" + stdId);
      $.post("admissionSql.php", {
        action: "fetchStudentQualification",
        sqId: id,
        std_id: stdId
      }, () => {}, "json").done(function(data) {
        // $.alert("List " + data.student_id + "sq " + data.qualification_id);
        $("#sInst").val(data.sq_institute);
        $("#sBoard").val(data.sq_board);
        $("#sYear").val(data.sq_year);
        $("#sMarksObt").val(data.sq_marksObtained);
        $("#sMaxMarks").val(data.sq_marksMax);
        $("#sCgpa").val(data.sq_percentage);
        var qual = data.qualification_id;
        $("#sel_qual option[value='" + qual + "']").attr("selected", "selected");
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
      $(".studentForm").hide();
    });

    $(document).on('click', '.student_idE', function() {
      var id = $(this).attr('id');
      // $.alert("Id " + id);
      $.post("admissionSql.php", {
        action: "fetchStudent",
        studentId: id
      }, () => {}, "json").done(function(data) {
        //$.alert("List ");
        $('#modal_title').text("Update Student  [" + id + "]");
        $("#sName").val(data.student_name);
        $("#sRno").val(data.student_rollno);
        $("#sEmail").val(data.student_email);
        $("#sMobile").val(data.student_mobile);
        $("#action").val("updateStudent");
        $('#modalId').val(id);
        $('#firstModal').modal('show');


      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('submit', '#modalForm', function(event) {
      event.preventDefault(this);
      var action = $("#action").val();
      var sName = $("#sName").val();
      var sMobile = $("#sMobile").val();
      var sEmail = $("#sEmail").val();
      var sRno = $("#sRno").val();
      var stdId = $("#panelId").val();


      var error = "NO";
      var error_msg = "";
      if (action == "addStudent" || action == "updateStudent") {
        if ($('#sName').val() === "" || $('#sRno').val() === "") {
          error = "YES";
          error_msg = "Student Name and Roll Number cannot be blank";
        }
      }

      if (error == "NO") {
        var formData = $(this).serialize();
        $('#firstModal').modal('hide');
        alert(" Pressed" + formData);
        $.post("admissionSql.php", formData, () => {}, "text").done(function(data) {
          $.alert("List Updtaed" + data);
          if (action == "addSubject" || action == "updateSubject") {
            studentList();
          }
          if (action == "addStudentQualification" || action == "updateStudentQualification") {
            studentQualificationList(stdId);
          }
          $("#modalForm")[0].reset();
        }, "text").fail(function() {
          $.alert("fail in place of error");
        })
      } else {
        $.alert(error_msg);
      }
    });

    $(document).on('change', '#sel_batch, #sel_program', function() {
      studentList();
    });

    $(document).on('click', '.student_idContact', function() {
      var id = $(this).attr('id');
      $.alert("id" + id);
      $.post("admissionSql.php", {
          studentId: id,
          action: "fetchContact"
        }, function(data, status) {
          // $.alert("data " + data)
        },
        "json").done(function(data) {
        // $.alert("List " + data.sc_fmobile);
        $("#fMobile").val(data.sc_fmobile);
        $("#mMobile").val(data.sc_mmobile);
      }).fail(function() {
        $.alert("fail in place of error");
      })
      $('#modal_title').text("Update Contact Details");
      $('#firstModal').modal('show');
      $('#modalId').val(id);
      $('#action').val("addContact");
    });

    $(document).on('click', '.as', function() {
      $(".selectPanel").show();
    });

    function studentList() {
      //$.alert("In List Function" + y);
      $.post("admissionSql.php", {
        action: "studentList"
      }, function() {}, "json").done(function(data, status) {
        $("#studentShowList").show();
        // $.alert("List " + data);
        var listData = '';
        $.each(data, function(key, value) {
          listData += '<tr>';
          listData += '<td><a href="#" class="fa fa-edit editStudent" data-student="' + value.student_id + '"></a></td>';
          listData += '<td>' + value.student_name + '</td>';
          listData += '<td>' + value.student_rollno + '</td>';
          listData += '<td>' + value.student_mobile + '</td>';
          listData += '<td>' + value.student_email + '</td>';
          listData += '</tr>';
        });
        $("#studentShowList").find("tr:gt(0)").remove();
        $("#studentShowList").append(listData);

      }).fail(function() {
        $.alert("Error !!");
      })

    }

    function studentQualificationList(x) {
      // $.alert("In List Function" + x);
      $.post("admissionSql.php", {
        action: "studentQualificationList",
        stdId: x
      }, function(mydata, mystatus) {
        $("#qualificationShowList").show();
        // $.alert("List qulai" + mydata);

        $("#qualificationShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function studentProgramReport() {
      //  $.alert("In List Function");
      $.post("admissionSql.php", {
        action: "studentProgramList",
      }, function(mydata, mystatus) {
        $("#studentProgramReport").show();
        // $.alert("List qulai" + mydata);
        $("#studentProgramReport").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })

    }

  });
</script>

<!-- Modal/Insititution Section-->
<div class="modal" id="firstModal">
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" id="modalForm">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->

        <!-- Modal body -->
        <div class="modal-body">
          <div class="studentForm">
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Name
                  <input type="text" class="form-control form-control-sm" id="sName" name="sName" placeholder="Name of the Student">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  Roll Number
                  <input type="text" class="form-control form-control-sm" id="sRno" name="sRno" placeholder="Roll Number of the Student">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Email
                  <input type="text" class="form-control form-control-sm" id="sEmail" name="sEmail" placeholder="Email ID of the Student">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  Mobile
                  <input type="text" class="form-control form-control-sm" id="sMobile" name="sMobile" placeholder="Mobile Number of the Student">
                </div>
              </div>
            </div>
          </div>

        </div> <!-- Modal Body Closed-->
        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="modalId" name="modalId">
          <input type="hidden" id="action" name="action">
          <input type="hidden" id="stdIdModal" name="stdIdModal">
          <button type="submit" class="btn btn-secondary" id="submitModalForm">Submit</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

<div class="modal" id="formModal">
  <div class="modal-dialog modal-md">
    <form id="upload_csv">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_uploadTitle"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->

        <!-- Modal body -->
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6">
              <h5>Selected Batch</h5>
              <p class="selectedBatch"><b><?php echo $myBatchName; ?></b></p>
            </div>
            <div class="col-sm-6">
              <h5>Selected Program</h5>
              <p class="selectedProgram"><b><?php echo $myProgAbbri; ?></b></p>
            </div>
          </div>
          <hr>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-6">
                <input type="file" name="student_upload" />
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->
        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" />
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div>

</html>