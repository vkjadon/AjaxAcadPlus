<?php
session_start();
require("../../config_database.php");
require('../../config_variable.php');
require('../../php_function.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Outcome Based Education : AcadPlus</title>
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
  <!-- MDB -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <link rel="stylesheet" href="../../table.css">
  <link rel="stylesheet" href="../../style.css">

</head>

<body>
  <?php require("../topBar.php"); ?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-2">
        <div class="card text-left selectPanel">
          <span id="panelId"></span>
          <span class="m-1 p-0" id="selectPanelTitle"></span>
          <div class="col">
            <form>
              <p class="selectProgram">
                <?php
                $sql = "select * from program where program_status='0'";
                selectList($conn, '', array("0", 'program_id', 'sp_name', 'program_abbri', 'sel_program'), $sql);
                ?>
              </p>
              <p class="selectBatch">
                <?php
                $sql = "select * from batch where batch_status='0' order by batch desc";
                selectList($conn, '', array("0", 'batch_id', 'batch', '', 'sel_batch'), $sql);
                ?>
              </p>
            </form>
          </div>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active as" id="list-as-list" data-toggle="list" href="#list-as" role="tab" aria-controls="as"> Add Student </a>
          <a class="list-group-item list-group-item-action sq" id="list-sq-list" data-toggle="list" href="#list-sq" role="tab" aria-controls="sq"> Student Qualification </a>
        </div>
      </div>

      <div class="col-10">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane show active" id="list-as" role="tabpanel" aria-labelledby="list-as-list">
            <div class="row">
              <div class="col-12 mt-1 mb-1">
                <button class="btn btn-secondary btn-square-sm mt-1 addStudent">Add</button>
                <p style="text-align:center" id="studentShowList"></p>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-sq" role="tabpanel" aria-labelledby="list-sq-list">
            <div class="row">
              <div class="col-3">
                <input type="text" name="student" id="student" class="form-control form-control-sm" placeholder="Name of the Student">
                <div class='list-group' id="studentAutoList"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-5 mt-1 mb-1"><button class="btn btn-secondary btn-square-sm mt-1 addStudentQualification">Add</button>
                <p style="text-align:center" id="qualificationShowList"></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

<!-- MDB -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script>
  $(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip();
    $(".topBarTitle").text("Admission");
    var y = $("#sel_batch").val();
    var z = $("#sel_program").val();
    if (y > 0 && z > 0) studentList(y, z);
    $('#programIdModal').val(z);
    $('#batchIdModal').val(y);
    $('#list-as').show();
    $('#list-sq').hide();
    $('.studentProfile').hide();


    $('#student').keyup(function() {
      var query = $(this).val();
      alert(query);
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

    $(document).on('click', '.autoList', function() {
      $('#student').val($(this).text());
      var stdId = $(this).attr("data-std");
      $('#panelId').val(stdId);
      studentQualificationList(stdId);

      // $.alert('hello'+stdId);
      $('#studentAutoList').fadeOut();
      $('.studentProfile').show();

      $.post("admissionSql.php", {
        action: "fetchStudent",
        studentId: stdId
      }, () => {}, "json").done(function(data) {
        // $.alert("List " + data.student_name);
        $(".fetchStudentName").html(data.student_name);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });


    $(document).on('click', '.sq', function() {
      $(".selectPanel").show();
      $('#list-sq').show();
      $('#list-as').hide();
      $('#studentShowList').show();
    });

    $(document).on('click', '.as', function() {
      $(".selectPanel").show();
      $('#list-as').show();
      $('#list-sq').hide();

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
      $.alert("Id " + id + "std" + stdId);
      $.post("admissionSql.php", {
        action: "fetchStudentQualification",
        sqId: id,
        std_id: stdId
      }, () => {}, "json").done(function(data) {
        $.alert("List " + data.student_id + "sq " + data.qualification_id);
        $('#modal_title').text("Update Student Qualification [" + id + "]");
        $("#sInst").val(data.sq_institute);
        $("#sBoard").val(data.sq_board);
        $("#sYear").val(data.sq_year);
        $("#sMarksObt").val(data.sq_marksObtained);
        $("#sMaxMarks").val(data.sq_marksMax);
        $("#modalId").val(id);
        $("#action").val("updateStudentQualification");
        var qual = data.qualification_id;
        $("#sel_qual option[value='" + qual + "']").attr("selected", "selected");
        $('#firstModal').modal('show');
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
      $(".studentForm").hide();
      $(".studentContactForm").hide();
      $(".studentQualificationForm").show();
      $(".studentDetailForm").hide();
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
      var selProgram = $("#sel_program").val();
      var selBatch = $("#sel_batch").val();
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
            studentList(selProgram, selBatch);
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
      var y = $("#sel_batch").val();
      var z = $("#sel_program").val();
      studentList(y, z);
    });

    $(document).on('click', '.student_idDetails', function() {
      var id = $(this).attr('id');
      // $.alert("id" + id);
      $.post("admissionSql.php", {
          studentId: id,
          action: "fetchDetails"
        }, function(data, status) {
          // $.alert("data " + data)
        },
        "json").done(function(data) {
        $("#fName").val(data.sd_fname);
        $("#mName").val(data.sd_mname);
        $("#sDob").val(data.sd_dob);
      }).fail(function() {
        $.alert("fail in place of error");
      })
      $('#modal_title').text("Add Student Details");
      $('#firstModal').modal('show');
      $(".studentDetailForm").show();
      $(".studentForm").hide();
      $(".studentContactForm").hide();
      $('#modalId').val(id);
      $('#action').val("addDetails");
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

    function studentList(y, z) {
      //$.alert("In List Function" + y);
      $.post("admissionSql.php", {
        action: "studentList",
        batchId: y,
        programId: z
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
  });
</script>

<!-- Modal/Insititution Section-->
<div class="modal" id="firstModal">
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" id="modalForm">
      <div class="modal-content bg-secondary text-white">

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
          <div class="studentDetailForm">
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Father Name
                  <input type="text" class="form-control form-control-sm" id="fName" name="fName" placeholder="Name of the Father">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  Mother Name
                  <input type="text" class="form-control form-control-sm" id="mName" name="mName" placeholder="Name of the Mother">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Father Occupation
                  <input type="text" class="form-control form-control-sm" id="fOccupation" name="fOccupation" placeholder="Occupation of the Father">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  Father Designation
                  <input type="text" class="form-control form-control-sm" id="fDes" name="fDes" placeholder="Designation of the Father">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Date of Birth
                  <input type="date" class="form-control form-control-sm" id="sDob" name="sDob" placeholder="Date of Birth">
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-4">
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" checked id="male" name="sGender" value="Male">Male
                </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" id="female" name="female" value="sGender">Female
                </div>
              </div>
              <div class="col-8">
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" checked id="obc" name="sCategory" value="OBC">OBC
                </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" id="gen" name="sCategory" value="General">General
                </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" id="sc" name="sCategory" value="SC">SC
                </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" id="st" name="sCategory" value="ST">ST
                </div>
              </div>
            </div>
          </div>
          <div class="studentContactForm">
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Father Mobile
                  <input type="text" class="form-control form-control-sm" id="fMobile" name="fMobile" placeholder="Father's Mobile Number">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  Mother Mobile
                  <input type="text" class="form-control form-control-sm" id="mMobile" name="mMobile" placeholder="Mother's Mobile Number">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Father Email
                  <input type="text" class="form-control form-control-sm" id="fEmail" name="fEmail" placeholder="Father's Email Address">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  Mother Email
                  <input type="text" class="form-control form-control-sm" id="mEmail" name="mEmail" placeholder="Mother's Email Address">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  Address
                  <input type="text" class="form-control form-control-sm" id="sAddress" name="sAddress" placeholder="">
                </div>
              </div>
            </div>
          </div>
          <div class="studentQualificationForm">
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
                        echo '<select class="form-control form-control-sm" name="sel_qual" id="sel_qual" required>';
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
                  <input type="text" class="form-control form-control-sm" id="sInst" name="sInst" placeholder="Name of the Institute">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Board
                  <input type="text" class="form-control form-control-sm" id="sBoard" name="sBoard" placeholder="Board">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  Year of Passing
                  <input type="text" class="form-control form-control-sm" id="sYear" name="sYear" placeholder="Passing Year">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <div class="form-group">
                  Marks Obtained
                  <input type="text" class="form-control form-control-sm" id="sMarksObt" name="sMarksObt" placeholder="Marks Obtained">
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  Maximum Marks
                  <input type="text" class="form-control form-control-sm" id="sMaxMarks" name="sMaxMarks" placeholder="Maximum marks">
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  Percentage/CGPA
                  <input type="text" class="form-control form-control-sm" id="sCgpa" name="sCgpa" placeholder="Percentage/CGPA">
                </div>
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->
        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="modalId" name="modalId">
          <input type="hidden" id="action" name="action">
          <input type="hidden" id="programIdModal" name="programIdModal">
          <input type="hidden" id="batchIdModal" name="batchIdModal">
          <input type="hidden" id="stdIdModal" name="stdIdModal">
          <button type="submit" class="btn btn-success btn-sm" id="submitModalForm">Submit</button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

</html>