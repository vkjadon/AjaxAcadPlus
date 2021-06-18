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
              <div class="col-4">
                <div class="card myCard">
                  <div class="input-group md-form form-sm form-2 mt-1">
                    <input name="studentSearch" id="studentSearch" class="form-control my-0 py-1 red-border" type="text" placeholder="Search Student" aria-label="Search">
                    <div class="input-group-append">
                      <span class="input-group-text cyan lighten-3" id="basic-text1"><i class="fas fa-search text-grey" aria-hidden="true"></i></span>
                    </div>
                  </div>
                  <div class='list-group' id="studentAutoList"></div>
                  <div class="row">
                    <div class="col-sm-6">
                      <button class="btn btn-sm addStudent">New Student</button>
                    </div>
                    <div class="col-sm-6">
                      <button class="btn btn-sm uploadStudent">Upload Student</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-8">
                <div class="card border-info mb-3 studentProfile">
                  <div class="card-header">Student Profile</div>
                  <div class="card-body text-primary">
                    <div class="row">
                      <div class="col-3">
                        <div class="card">
                          <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                              <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="100">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-9">
                        <div class="card h-100">
                          <div class="card-body">
                            <div class="row">
                              <div class="col-3">
                                <h7 class="mb-0 ">Full Name</h7>
                              </div>
                              <div class="col-9 text-secondary student_name">
                                Kenneth Valdez
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-3">
                                <h7 class="mb-0 ">Roll Number</h7>
                              </div>
                              <div class="col-9 text-secondary student_rollno">
                                Kenneth Valdez
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-3">
                                <h7 class="mb-0 ">Email</h7>
                              </div>
                              <div class="col-9 text-secondary student_email">
                                Kenneth Valdez
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-3">
                                <h7 class="mb-0 ">Mobile</h7>
                              </div>
                              <div class="col-9 text-secondary student_mobile">
                                Kenneth Valdez
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-4 mt-1 mb-1">
                <p id="studentShowList"></p>
              </div>
              <div class="col-8">
                <div id="accordionStudent" class="accordion shadow">
                  <div class="card">
                    <div id="headingOne" class="card-header bg-white shadow-sm border-0">
                      <h6 class="mb-0 font-weight-semibold"><a href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="d-block position-relative text-dark text-uppercase collapsible-link py-2">Edit Details</a></h6>
                    </div>
                    <div id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionStudent" class="collapse collapseAccordian">
                      <div class="card-body">
                        <form class="form-horizontal">
                          <input type="hidden" id="studentIdHidden" name="studentIdHidden">
                          <div class="row">
                            <div class="col-12">
                              <div class="studentFormAccordian">
                                <div class="row">
                                  <div class="col-4">
                                    <div class="form-group">
                                      Student Name
                                      <input type="text" class="form-control form-control-sm sForm" id="sNameA" name="sNameA" placeholder="Name of the Student" data-tag="student_name">
                                    </div>
                                  </div>
                                  <div class="col-4">
                                    <div class="form-group">
                                      Student Roll Number
                                      <input type="text" class="form-control form-control-sm sForm" id="sRnoA" name="sRnoA" placeholder="Roll Number of the Student" data-tag="student_rollno">
                                    </div>
                                  </div>
                                  <div class="col-4">
                                    <div class="form-group">
                                      Mobile Number
                                      <input type="text" class="form-control form-control-sm sForm" id="sMobileA" name="sMobileA" placeholder="Mobile Number of the Student" data-tag="student_mobile">
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-6">
                                    <div class="form-group">
                                      Email
                                      <input type="text" class="form-control form-control-sm sForm" id="sEmailA" name="sEmailA" placeholder="Email ID of the Student" data-tag="student_email">
                                    </div>
                                  </div>
                                  <div class="col-6">
                                    <div class="form-group">
                                      Date of Birth
                                      <input type="date" class="form-control form-control-sm sDetailForm" id="sDobA" name="sDobA" placeholder="Date of Birth" data-tag="sd_dob">
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="studentDetailFormAccordian">
                                <div class="row">
                                  <div class="col-6">
                                    <div class="form-group">
                                      Father Name
                                      <input type="text" class="form-control form-control-sm sDetailForm" id="fName" name="fName" placeholder="Name of the Father" data-tag="sd_fname">
                                    </div>
                                  </div>
                                  <div class="col-6">
                                    <div class="form-group">
                                      Mother Name
                                      <input type="text" class="form-control form-control-sm sDetailForm" id="mName" name="mName" placeholder="Name of the Mother" data-tag="sd_mname">
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-6">
                                    <div class="form-group">
                                      Father Occupation
                                      <input type="text" class="form-control form-control-sm sDetailForm" id="fOccupation" name="fOccupation" placeholder="Occupation of the Father" data-tag="sd_foccupation">
                                    </div>
                                  </div>
                                  <div class="col-6">
                                    <div class="form-group">
                                      Father Designation
                                      <input type="text" class="form-control form-control-sm sDetailForm" id="fDes" name="fDes" placeholder="Designation of the Father" data-tag="sd_fdesignation">
                                    </div>
                                  </div>
                                </div>
                                <hr>
                                <div class="row">
                                  <div class="col-6">
                                    <div class="form-check-inline">
                                      <input type="radio" class="form-check-input sDetailForm" checked id="male" name="sGender" value="Male" data-tag="sd_gender">Male
                                    </div>
                                    <div class="form-check-inline">
                                      <input type="radio" class="form-check-input sDetailForm" id="female" name="female" value="sGender" data-tag="sd_gender">Female
                                    </div>
                                  </div>
                                  <div class="col-6">
                                    <div class="form-check-inline">
                                      <input type="radio" class="form-check-input sDetailForm" checked id="obc" name="sCategory" value="OBC" data-tag="sd_category">OBC
                                    </div>
                                    <div class="form-check-inline">
                                      <input type="radio" class="form-check-input sDetailForm" id="gen" name="sCategory" value="General" data-tag="sd_category">General
                                    </div>
                                    <div class="form-check-inline">
                                      <input type="radio" class="form-check-input sDetailForm" id="sc" name="sCategory" value="SC" data-tag="sd_category">SC
                                    </div>
                                    <div class="form-check-inline">
                                      <input type="radio" class="form-check-input sDetailForm" id="st" name="sCategory" value="ST" data-tag="sd_category">ST
                                    </div>
                                  </div>
                                </div>
                                <hr>
                              </div>
                              <div class="studentContactFormAccordian">
                                <div class="row">
                                  <div class="col-6">
                                    <div class="form-group">
                                      Father Mobile
                                      <input type="text" class="form-control form-control-sm sContactForm" id="fMobile" name="fMobile" placeholder="Father's Mobile Number" data-tag="sc_fmobile">
                                    </div>
                                  </div>
                                  <div class="col-6">
                                    <div class="form-group">
                                      Mother Mobile
                                      <input type="text" class="form-control form-control-sm sContactForm" id="mMobile" name="mMobile" placeholder="Mother's Mobile Number" data-tag="sc_mmobile">
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-6">
                                    <div class="form-group">
                                      Father Email
                                      <input type="text" class="form-control form-control-sm sContactForm" id="fEmail" name="fEmail" placeholder="Father's Email Address" data-tag="sc_femail">
                                    </div>
                                  </div>
                                  <div class="col-6">
                                    <div class="form-group">
                                      Mother Email
                                      <input type="text" class="form-control form-control-sm sContactForm" id="mEmail" name="mEmail" placeholder="Mother's Email Address" data-tag="sc_memail">
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-12">
                                    <div class="form-group">
                                      Address
                                      <input type="text" class="form-control form-control-sm sContactForm" id="sAddress" name="sAddress" placeholder="" data-tag="sc_address">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="card">
                    <div id="headingTwo" class="card-header bg-white shadow-sm border-0">
                      <h6 class="mb-0 font-weight-semibold"><a href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="d-block position-relative collapsed text-dark text-uppercase collapsible-link py-2">Add Qualification</a></h6>
                    </div>
                    <div id="collapseTwo" aria-labelledby="headingTwo" data-parent="#accordionStudent" class="collapse collapseAccordian">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-12">
                            <div class="studentQualificationFormAccordian">
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
                            </div>
                            <p style="text-align:center" id="qualificationShowList"></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
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
        $(".student_email").text(data.student_email);
        $(".student_name").text(data.student_name);
        $(".student_rollno").text(data.student_rollno);
        $(".student_mobile").text(data.student_mobile);
        $("#sEmail").val(data.student_email);
        $("#sName").val(data.student_name);
        $("#sRno").val(data.student_rollno);
        $("#sMobile").val(data.student_mobile);
        $("#sDob").val(data.student_dob);
        $("#fName").val(data.student_fname);
        $("#mName").val(data.student_mname);
        $("#sAdhaar").val(data.student_adhaar);
        $("#sAddress").val(data.student_address);
        $("#sGender").val(data.student_gender);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })

      $.post("admissionSql.php", {
        studentId: stdId,
        action: "fetchDetails"
      }, () => {}, "json").done(function(data) {
        $("#fName").val(data.sd_fname);
        $("#mName").val(data.sd_mname);
        $("#sGender").val(data.sd_gender);
        $("#sCategory").val(data.sd_category);
        $("#fOccupation").val(data.sd_foccupation);
        $("#fDes").val(data.sd_fdesignation);
        $("#sDob").val(data.sd_dob);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })

      $.post("admissionSql.php", {
        studentId: stdId,
        action: "fetchContact"
      }, () => {}, "json").done(function(data) {
        $("#fEmail").val(data.sc_femail);
        $("#mEmail").val(data.sc_memail);
        $("#sAddress").val(data.sc_address);
        $("#fMobile").val(data.sc_fmobile);
        $("#mMobile").val(data.sc_mmobile);
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
      $('.studentForm').show();
      $('.selectPanel').show();
      $(".studentContactForm").hide();
      $(".studentDetailForm").hide();
      $(".studentQualificationForm").hide();
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
      studentQualificationList(id);

      $.post("admissionSql.php", {
        studentId: id,
        action: "fetchStudent"
      }, () => {}, "json").done(function(data) {
        $(".student_email").text(data.student_email);
        $(".student_name").text(data.student_name);
        $(".student_rollno").text(data.student_rollno);
        $(".student_mobile").text(data.student_mobile);
        $("#sEmailA").val(data.student_email);
        $("#sNameA").val(data.student_name);
        $("#sRnoA").val(data.student_rollno);
        $("#sMobileA").val(data.student_mobile);
        $("#sDobA").val(data.student_dob);
        $("#fName").val(data.student_fname);
        $("#mName").val(data.student_mname);
        $("#sAdhaar").val(data.student_adhaar);
        $("#sAddress").val(data.student_address);
        $("#sGender").val(data.student_gender);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })

      $.post("admissionSql.php", {
        studentId: id,
        action: "fetchDetails"
      }, () => {}, "json").done(function(data) {
        $("#fName").val(data.sd_fname);
        $("#mName").val(data.sd_mname);
        $("#sGender").val(data.sd_gender);
        $("#sCategory").val(data.sd_category);
        $("#fOccupation").val(data.sd_foccupation);
        $("#fDes").val(data.sd_fdesignation);
        $("#sDob").val(data.sd_dob);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })

      $.post("admissionSql.php", {
        studentId: id,
        action: "fetchContact"
      }, () => {}, "json").done(function(data) {
        $("#fEmail").val(data.sc_femail);
        $("#mEmail").val(data.sc_memail);
        $("#sAddress").val(data.sc_address);
        $("#fMobile").val(data.sc_fmobile);
        $("#mMobile").val(data.sc_mmobile);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
      $('studentContactFormAccordian').trigger("reset");

    });

    $(document).on('blur', '.sForm', function() {
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

    $(document).on('blur', '.sDetailForm', function() {
      var studentId = $("#studentIdHidden").val()
      var tag = $(this).attr("data-tag")
      var value = $(this).val()
      // $.alert("Changes " + tag + " Value " + value + " Student " + studentId);
      $.post("admissionSql.php", {
        id_name: "student_id",
        id: studentId,
        tag: tag,
        student_id: studentId,
        value: value,
        action: "updateDetails"
      }, function(data) {
        // $.alert("List " + data);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('blur', '.sContactForm', function() {
      var studentId = $("#studentIdHidden").val()
      var tag = $(this).attr("data-tag")
      var value = $(this).val()
      // $.alert("Changes " + tag + " Value " + value + " Student " + studentId);
      $.post("admissionSql.php", {
        id_name: "student_id",
        id: studentId,
        tag: tag,
        student_id: studentId,
        value: value,
        action: "updateContact"
      }, function(data) {
        // $.alert("List " + data);
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
      $('.studentForm').hide();
      $('.selectPanel').show();
      $(".studentContactForm").hide();
      $(".studentQualificationForm").show();
      $(".studentDetailForm").hide();
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
        $(".studentQualificationForm").hide();
        $(".studentContactForm").hide();
        $(".studentDetailForm").hide();


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
      $(".studentForm").hide();
      $(".studentContactForm").show();
      $(".studentDetailForm").hide();
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
      }, function(mydata, mystatus) {
        $("#studentShowList").show();
        // $.alert("List " + mydata);
        $("#studentShowList").html(mydata);
      }, "text").fail(function() {
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
                  Student Name
                  <input type="text" class="form-control form-control-sm" id="sName" name="sName" placeholder="Name of the Student">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  Student Roll Number
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
                  Mobile Number
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