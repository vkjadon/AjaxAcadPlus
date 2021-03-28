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
      <div class="col-sm-2">
        <div class="card text-left selectPanel">
          <span id="panelId"></span>
          <span class="m-1 p-0" id="selectPanelTitle"></span>
          <div class="col">
            <form>
              <p class="selectDept">
                <?php
                $sql = "select * from department where dept_status='0'";
                selectList($conn, "Select a Department", array("0", "dept_id", "dept_name", "dept_abbri", "sel_dept"), $sql);
                ?>
              </p>
            </form>
          </div>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active as" id="list-as-list" data-toggle="list" href="#list-as" role="tab" aria-controls="as"> Add Staff </a>
          <a class="list-group-item list-group-item-action sq" id="list-sq-list" data-toggle="list" href="#list-sq" role="tab" aria-controls="sq"> Staff Qualification </a>
        </div>
      </div>
      <div class="col-sm-10">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="list-as" role="tabpanel" aria-labelledby="list-as-list">
            <div class="row">
              <div class="col-5 mt-1 mb-1"><button class="btn btn-secondary btn-square-sm mt-1 addStaff">Add</button>
                <p style="text-align:center" id="staffList"></p>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="list-sq" role="tabpanel" aria-labelledby="list-sq-list">
            <div class="row">
              <div class="col-3">
                <input type="text" name="staff" id="staff" class="form-control form-control-sm" placeholder="Faculty Name">
                <div class='list-group' id="staffAutoList"></div>
              </div>
            </div>

            <div class="row">
              <div class="col-5 mt-1 mb-1"><button class="btn btn-secondary btn-square-sm mt-1 addStaffQualification">Add</button>
                <p style="text-align:center" id="qualificationShowList"></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</html>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
  function resetForm() {
    document.getElementById("formStaff").reset();
  }

  $(document).ready(function() {
    $('#list-as').show();
    $('#list-sq').hide();
    var z = $("#sel_dept").val();
    if (z > 0) staffList(z);
    $(".topBarTitle").text("HR");
    $('#deptIdModal').val(z);

    $('#staff').keyup(function() {
      var query = $(this).val();
      // alert(query);
      if (query != '') {
        $.ajax({
          url: "hrSql.php",
          method: "POST",
          data: {
            query: query
          },
          success: function(data) {
            $('#staffAutoList').fadeIn();
            $('#staffAutoList').html(data);
          }
        });
      } else {
        $('#staffAutoList').fadeOut();
        $('#staffAutoList').html("");
      }
    });

    $(document).on('click', '.autoList', function() {
      $('#staff').val($(this).text());
      var stfId = $(this).attr("data-std");
      $('#panelId').val(stfId);
      staffQualificationList(stfId);
      $('#staffAutoList').fadeOut();
    });


    $(document).on('click', '.sq', function() {
      $(".selectPanel").show();
      $('#list-sq').show();
      $('#list-as').hide();
      $('#staffShowList').show();
    });

    $(document).on('click', '.as', function() {
      $(".selectPanel").show();
      $('#list-as').show();
      $('#list-sq').hide();
    });

    $(document).on('click', '.addStaff', function() {
      $('#modal_title').text("Add Staff");
      $('#action').val("addStaff");
      $('#firstModal').modal('show');
      $('.staffForm').show();
      $('.selectPanel').show();
      $(".staffDetailForm").hide();
      $(".staffQualificationForm").hide();
    });

    $(document).on('click', '.staff_idE', function() {
      var id = $(this).attr('id');
      //  $.alert("Id " + id);
      $.post("hrSql.php", {
        action: "fetchStaff",
        staffId: id
      }, () => {}, "json").done(function(data) {
        // $.alert("List ");
        $('#modal_title').text("Update Staff  [" + id + "]");
        $("#sName").val(data.staff_name);
        var desig = data.designation_id;
        $("#sel_desig option[value='" + desig + "']").attr("selected", "selected");
        $("#sEmail").val(data.staff_email);
        $("#sMobile").val(data.staff_mobile);
        $("#action").val("updateStaff");
        $('#modalId').val(id);
        $('#firstModal').modal('show');
        $(".staffQualificationForm").hide();
        $(".staffDetailForm").hide();
        $(".staffForm").show();
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.staff_idDetails', function() {
      var id = $(this).attr('id');
      // $.alert("id" + id);
      $.post("hrSql.php", {
          studentId: id,
          action: "fetchStaffDetails"
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
      $('#modal_title').text("Add Staff Details");
      $('#firstModal').modal('show');
      $(".staffDetailForm").show();
      $(".staffForm").hide();
      $(".studentQualificationForm").hide();
      $('#modalId').val(id);
      $('#action').val("addDetails");
    });

    $(document).on('click', '.stq_idView', function() {
      var id = $(this).attr('id');
      $.alert("id" + id);
      $('#stqIdM').val(id);
      $("#viewModal").modal('show');
    });

    $(document).on('click', '.stq_idUpload', function() {
      var id = $(this).attr('id');
      //$.alert("id" + id);
      $('#stqIdM').val(id);
      $("#uploadModal").modal('show');
    });

    $(document).on('submit', '#uploadModalForm', function(event) {
      event.preventDefault();
      var formData = $(this).serialize();
      //$.alert(formData);
      // action and test_id are passed as hidden
      $.ajax({
        url: "uploadSql.php",
        method: "POST",
        data: new FormData(this),
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false
        success: function(data) {
          $.alert("List " + data);
          $('#uploadModal').modal('hide');
        }
      })
    });

    $(document).on('click', '.addStaffQualification', function() {
      $('#modal_title').text("Add Staff Qualifications");
      $('#firstModal').modal('show');
      var stfId = $('#panelId').val();
      $('#stfIdModal').val(stfId);
      $('.studentForm').hide();
      $('.selectPanel').show();
      $(".staffQualificationForm").show();
      $(".staffDetailForm").hide();
      $(".staffForm").hide();
      $('#action').val("addStaffQualification");
    });

    $(document).on('click', '.stq_idE', function() {
      var id = $(this).attr('id');
      var stfId = $('#panelId').val();
      //  $.alert("Id " + id + "std" + stdId);
      $.post("hrSql.php", {
        action: "fetchStaffQualification",
        stqId: id,
        stf_id: stfId
      }, () => {}, "json").done(function(data) {
        // $.alert("List " + data.student_id + "sq " + data.qualification_id);
        $('#modal_title').text("Update Staff Qualification [" + id + "]");
        $("#sInst").val(data.stq_institute);
        $("#sBoard").val(data.stq_board);
        $("#sYear").val(data.stq_year);
        $("#sMarksObt").val(data.stq_marksObtained);
        $("#sMaxMarks").val(data.stq_marksMax);
        $("#sCgpa").val(data.stq_percentage);
        $("#modalId").val(id);
        $("#action").val("updateStaffQualification");
        var qual = data.qualification_id;
        $("#sel_qual option[value='" + qual + "']").attr("selected", "selected");
        $('#firstModal').modal('show');
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
      $(".staffForm").hide();
      $(".staffQualificationForm").show();
      $(".staffDetailForm").hide();
    });

    $(document).on('submit', '#modalForm', function(event) {
      event.preventDefault(this);
      var action = $("#action").val();
      var selDept = $("#sel_dept").val();
      var sName = $("#sName").val();
      var stfId = $("#panelId").val();


      var error = "NO";
      var error_msg = "";
      if (action == "addStaff" || action == "updateStaff") {
        if ($('#sName').val() === "") {
          error = "YES";
          error_msg = "Staff Name cannot be blank";
        }
      }

      if (error == "NO") {
        var formData = $(this).serialize();
        $('#firstModal').modal('hide');
        alert(" Pressed" + formData);
        $.post("hrSql.php", formData, () => {}, "text").done(function(data) {
          $.alert("List Updtaed" + data);
          if (action == "addStaff" || action == "updateStaff") {
            staffList(selDept);
          }
          if (action == "addStaffQualification" || action == "updateStaffQualification") {
            staffQualificationList(stfId);
          }
          $("#modalForm")[0].reset();
        }, "text").fail(function() {
          $.alert("fail in place of error");
        })
      } else {
        $.alert(error_msg);
      }
    });

    $(document).on('change', '#sel_dept', function() {
      var y = $("#sel_dept").val();
      staffList(y);
    });

    function staffList(y) {
      $.post("hrSql.php", {
        deptId: y,
        action: "staffList"
      }, function(mydata, mystatus) {
        $("#staffList").show();
        //	alert("List ");
        $("#staffList").html(mydata);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    }

    function staffQualificationList(x) {
      $.alert("In List Function" + x);
      $.post("hrSql.php", {
        action: "staffQualificationList",
        stfId: x
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
          <div class="staffForm">
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Staff Name
                  <input type="text" class="form-control form-control-sm" id="sName" name="sName" placeholder="Staff Name">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  Designation
                  <div class="row">
                    <div class="col">
                      <?php
                      $sql_desigantion = "select * from designation";
                      $result = $conn->query($sql_desigantion);
                      if ($result) {
                        echo '<select class="form-control form-control-sm" name="sel_desig" id="sel_desig" required>';
                        while ($rows = $result->fetch_assoc()) {
                          $select_id = $rows['designation_id'];
                          $select_name = $rows['designation_name'];
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
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Email
                  <input type="text" class="form-control form-control-sm" id="sEmail" name="sEmail" placeholder="Staff Email Id">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  Mobile Number
                  <input type="text" class="form-control form-control-sm" id="sMobile" name="sMobile" placeholder="Staff Mobile Number">
                </div>
              </div>
            </div>
          </div>
          <div class="staffDetailForm">
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
                  Date of Birth
                  <input type="date" class="form-control form-control-sm" id="sDob" name="sDob" placeholder="Date of Birth">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  Date of Joining
                  <input type="date" class="form-control form-control-sm" id="sDoj" name="sDoj" placeholder="Date of Joining">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  Address
                  <input type="text" class="form-control form-control-sm" id="sAddress" name="sAddress" placeholder="Address">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  Adhaar Number
                  <input type="text" class="form-control form-control-sm" id="sAdhaar" name="sAdhaar" placeholder="12 Digit Adhaar Number">
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-5">
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" checked id="male" name="sGender" value="Male">Male
                </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" id="female" name="female" value="sGender">Female
                </div>
              </div>
              <div class="col-7">
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" checked id="Teaching" name="sTeaching" value="Teaching">Teaching
                </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" id="NonTeaching" name="sTeaching" value="NonTeaching">Non-Teaching
                </div>
              </div>
            </div>
          </div>
          <div class="staffQualificationForm">
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
          <input type="hidden" id="deptIdModal" name="deptIdModal">
          <input type="hidden" id="stfIdModal" name="stfIdModal">
          <button type="submit" class="btn btn-success btn-sm" id="submitModalForm">Submit</button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

<div class="modal" id="uploadModal">
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" id="uploadModalForm">
      <div class="modal-content bg-secondary text-white">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Upload Document</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->

        <!-- Modal body -->
        <div class="modal-body">
          <div class="uploadForm">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <input type="file" name="upload_file">
                </div>
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->
        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" name="action" value="upload">
          <input type="hidden" id="stqIdM" name="stqIdM">
          <button type="submit" class="btn btn-success btn-sm">Submit</button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

<div class="modal" id="viewModal">
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" id="viewModalForm">
      <div class="modal-content bg-secondary text-white">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Document Uploaded</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->

        <!-- Modal body -->
        <div class="modal-body">
          <?php
          $stq_id = $_POST['stqIdM'];
          $sql = "select stq.* from staff_qualification stq where stq.stq_id='$stq_id'";
          $conn->query($sql);
          $folder = '../../' . $myFolder . '/qualification';
          $file = $folder . '/' . $stq_id;
          ?>
          <embed src="<?php echo $file; ?>" width="100%" height="600" alt=”pdf” pluginspage=”http://www.adobe.com/products/acrobat/readstep2.html”></embed>
        </div> <!-- Modal Body Closed-->
        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" name="action" value="view">
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->
</html>