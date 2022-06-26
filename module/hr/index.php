<?php
require('../requireSubModule.php');
addActivity($conn, $myId, "Manage Staff - HR", $submit_ts);

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
    elseif (!in_array("4", $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
  }
  ?>
  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-1 p-0 m-0 pl-1 full-height">
        <h5 class="pt-3 largeText">Staff</h5>
        <div class="list-group list-group-mine" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active as" data-toggle="list" href="#as" role="tab" aria-controls="as"> Add Staff </a>
          <a class="list-group-item list-group-item-action" data-toggle="list" href="#dr" role="tab" aria-controls="dr"> Detail Report </a>
        </div>
      </div>
      <div class="col-sm-11 p-0">
        <div class="row bg-light p-2 m-0">
          <div class="col-md-3 pr-0" title="Institution/School">
            <?php require("../selectInstitution.php"); ?>
          </div>
          <div class="col-md-3 pr-0" title="Institution/School">
            <?php require("../selectDepartment.php"); ?>
          </div>
          <div class="col-md-2">
            <input type="text" class="form-control form-control-sm" id="staffSearch" name="staffSearch" placeholder="Search Staff" aria-label="Search">
            <p class='list-group overlapList' id="staffAutoList"></p>
          </div>
          <div class="col-sm-2 pr-0">
            <button class="btn btn-sm m-0 addStaff">New Staff</button>
          </div>
          <div class="col-sm-2 pl-1">
            <button class="btn btn-sm m-0 uploadStaff">Upload Staff</button>
          </div>
        </div>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="as" role="tabpanel" aria-labelledby="as">
            <div class="row m-1">
              <div class="col-md-4 pr-0">
                <div class="card myCard mt-2">
                  <p class="largeText pl-2">List of Active Staff</p>
                  <p id="staffList"></p>
                </div>
              </div>
              <div class="col-md-8 pl-1">
                <div class="container card myCard mt-2">
                  <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="pill" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="pill" href="#pills_basicInfo" role="tab" aria-controls="pills_basicInfo" aria-selected="true">Basic Info</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link pills_qualification" data-toggle="pill" href="#pills_qualification" role="tab" aria-controls="pills_qualification" aria-selected="true">Qualification</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link pills_reference" data-toggle="pill" href="#pills_experience" role="tab" aria-controls="pills_experience" aria-selected="true">Experience</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="pill" href="#pills_address" role="tab" aria-controls="pills_address" aria-selected="true">Address Details</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="pills-tabContent p-3">
                    <div class="tab-pane show active" id="home" role="tabpanel" aria-labelledby="home">
                      <div class="row">
                        <div class="col-12">
                          <div class="row">
                            <div class="col-3 pr-1 text-center">
                              <span class="studentImage"><img src="../../images/upload.jpg" width="70%"></span>
                              <div class="border">
                                <form class="form-horizontal" id="uploadModalForm">
                                  <input type="file" name="upload_file">
                                  <input type="hidden" name="staffId" id="uploadId">
                                  <input type="hidden" name="action" value="uploadImage"><br>
                                  <button type="submit" class="btn btn-sm btn-block">Upload Image</button>
                                </form>
                              </div>
                            </div>
                            <div class="col-9 pr-1">
                              <div class="row">
                                <div class="col-md-9">
                                  <table width="100%">
                                    <tr>
                                      <td width="60%"><span class="largeText">Name </span></td>
                                      <td class="largeText staff_name">---</td>
                                    </tr>
                                    <tr>
                                      <td width="60%"><span class="largeText">Employee Id </span></td>
                                      <td class="largeText staff_userId">---</td>
                                    </tr>
                                    <tr>
                                      <td width="60%"><span class="largeText"> Department </span></td>
                                      <td class="largeText staff_dept">---</td>
                                    </tr>
                                    <tr>
                                      <td><span class="largeText"> Designation </span></td>
                                      <td class="largeText staff_deignation">---</td>
                                    </tr>
                                    <tr>
                                      <td><span class="largeText">Mobile</span></td>
                                      <td class="largeText staff_mobile">---</td>
                                    </tr>
                                    <tr>
                                      <td><span class="largeText">Email </span></td>
                                      <td class="largeText staff_email">---</td>
                                    </tr>
                                    <tr>
                                      <td><span class="largeText">DoJ </span></td>
                                      <td class="largeText staff_doj">---</td>
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
                    <div class="tab-pane" id="pills_basicInfo" role="tabpanel" aria-labelledby="pills_basicInfo">
                      <form class="form-horizontal">
                        <input type="hidden" id="staffIdHidden" name="staffIdHidden">
                        <div class="row">
                          <div class="col-3 pr-0">
                            <div class="form-group">
                              Staff Name
                              <input type="text" class="form-control form-control-sm staffForm" id="sNameAccordian" name="sNameAccordian" placeholder="Staff Name" data-tag="staff_name">
                            </div>
                          </div>
                          <div class="col-3 pl-1 pr-0">
                            <div class="form-group">
                              Mobile Number
                              <input type="text" class="form-control form-control-sm staffForm" id="sMobileAccordian" name="sMobileAccordian" placeholder="Staff Mobile Number" data-tag="staff_mobile">
                            </div>
                          </div>
                          <div class="col-3 pl-1 pr-0">
                            <div class="form-group">
                              Email
                              <input type="text" class="form-control form-control-sm staffForm" id="sEmailAccordian" name="sEmailAccordian" placeholder="Staff Email Id" data-tag="staff_email">
                            </div>
                          </div>
                          <div class="col-3 pl-1">
                            <div class="form-group">
                              Date of Birth
                              <input type="date" class="form-control form-control-sm staffForm" id="sDobAccordian" name="sDobAccordian" placeholder="Date of Birth" data-tag="staff_dob">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-3 pr-0">
                            <div class="form-group">
                              Father Name
                              <input type="text" class="form-control form-control-sm staffForm" id="fName" name="fName" placeholder="Name of the Father" data-tag="staff_fname">
                            </div>
                          </div>
                          <div class="col-3 pl-1 pr-0">
                            <div class="form-group">
                              Mother Name
                              <input type="text" class="form-control form-control-sm staffForm" id="mName" name="mName" placeholder="Name of the Mother" data-tag="staff_mname">
                            </div>
                          </div>
                          <div class="col-3 pl-1 pr-0">
                            <div class="form-group">
                              Date of Joining
                              <input type="date" class="form-control form-control-sm staffForm" id="sDojAccordian" name="sDojAccordian" placeholder="Date of Joining" data-tag="staff_doj">
                            </div>
                          </div>
                          <div class="col-3 pl-1">
                            <div class="form-group">
                              Adhaar Number
                              <input type="text" class="form-control form-control-sm staffForm" id="sAdhaar" name="sAdhaar" placeholder="12 Digit Adhaar Number" data-tag="staff_adhaar">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-3 pr-0">
                            <div class="form-group">
                              Name in Account
                              <input type="text" class="form-control form-control-sm staffForm" id="staff_name_account" name="staff_name_account" placeholder="Name as in Account" data-tag="staff_name_account">
                            </div>
                          </div>
                          <div class="col-3 pl-1 pr-0">
                            <div class="form-group">
                              Bank Name
                              <input type="text" class="form-control form-control-sm staffForm" id="staff_bank" name="staff_bank" placeholder="Bank Name" data-tag="staff_bank">
                            </div>
                          </div>
                          <div class="col-3 pl-1 pr-0">
                            <div class="form-group">
                              Account Number
                              <input type="text" class="form-control form-control-sm staffForm" id="staff_account" name="staff_account" placeholder="Account Number" data-tag="staff_account">
                            </div>
                          </div>
                          <div class="col-3 pl-1">
                            <div class="form-group">
                              IFSC Number
                              <input type="text" class="form-control form-control-sm staffForm" id="staff_ifsc" name="staff_ifsc" placeholder="IFSC Number" data-tag="staff_ifsc">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-3 pr-0">
                            <div class="form-group">
                              Department
                              <?php
                              $sel = "select * from department where dept_status='0' order by dept_name, dept_type";
                              $result = $conn->query($sel);
                              if ($result) {
                                echo '<select class="form-control form-control-sm staffForm" name="sel_dept" id="sel_newDept" data-tag="dept_id">';
                                echo '<option value="0"> Select Departmrnt </option>';
                                while ($rows = $result->fetch_assoc()) {
                                  $select_id = $rows['dept_id'];
                                  $select_name = $rows['dept_name'];
                                  echo '<option value="' . $select_id . '">' . $select_name . '</option>';
                                }
                                echo '</select>';
                              } else echo $conn->error;
                              if ($result->num_rows == 0) echo 'No Data Found';
                              ?>
                            </div>
                          </div>
                          <div class="col-3 pr-0">
                            <div class="form-group">
                              Designation
                              <?php
                              $sel = "select * from master_name where mn_code='dg'";
                              $result = $conn->query($sel);
                              if ($result) {
                                echo '<select class="form-control form-control-sm staffForm" name="sel_des" id="sel_des" data-tag="mn_id">';
                                echo '<option value="0"> Select Designation </option>';
                                while ($rows = $result->fetch_assoc()) {
                                  $select_id = $rows['mn_id'];
                                  $select_name = $rows['mn_name'];
                                  echo '<option value="' . $select_id . '">' . $select_name . '</option>';
                                }
                                echo '</select>';
                              } else echo $conn->error;
                              if ($result->num_rows == 0) echo 'No Data Found';
                              ?>
                            </div>
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-md-3 pr-0">
                            <div class="form-check-inline">
                              <input type="radio" class="form-check-input staffForm" checked id="male" name="sGender" value="M" data-tag="staff_gender">Male
                            </div>
                            <div class="form-check-inline">
                              <input type="radio" class="form-check-input staffForm" id="female" name="sGender" value="F" data-tag="staff_gender">Female
                            </div>
                          </div>
                          <div class="col-md-5 pl-1 pr-0">
                            <div class="form-check-inline">
                              <input type="radio" class="form-check-input staffForm" checked id="faculty" name="sPrivilege" value="0" data-tag="staff_privilege">Faculty
                            </div>
                            <div class="form-check-inline">
                              <input type="radio" class="form-check-input staffForm" id="staff" name="sPrivilege" value="1" data-tag="staff_privilege">Staff
                            </div>
                            <div class="form-check-inline">
                              <input type="radio" class="form-check-input staffForm" id="admin" name="sPrivilege" value="9" data-tag="staff_privilege">Admin
                            </div>
                          </div>
                          <div class="col-md-4 pl-1">
                            <div class="form-check-inline">
                              <input type="radio" class="form-check-input staffForm" id="nonTeaching" name="sTeaching" value="0" data-tag="staff_teaching">Non-Teaching
                            </div>
                            <div class="form-check-inline">
                              <input type="radio" class="form-check-input staffForm" checked id="teaching" name="sTeaching" value="1" data-tag="staff_teaching">Teaching
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="tab-pane fade" id="pills_qualification" role="tabpanel" aria-labelledby="pills_qualification">
                      <form id="qualForm">
                        <div class="row">
                          <div class="col-1 pr-1">
                            <div class="form-group">
                              <label>Qual</label>
                              <div class="row">
                                <div class="col">
                                  <?php
                                  $sel_des = "select * from master_name where mn_code='qt'";
                                  $result = $conn->query($sel_des);
                                  if ($result) {
                                    echo '<select class="form-control form-control-sm" name="sel_qual" id="sel_qual">';
                                    echo '<option value="0">Qualification</option>';
                                    while ($rows = $result->fetch_assoc()) {
                                      $select_id = $rows['mn_id'];
                                      $select_name = $rows['mn_name'];
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
                          <div class="col-3 pl-0 pr-1">
                            <div class="form-group">
                              <label>Institute</label>
                              <input type="text" class="form-control form-control-sm" id="sq_institute" name="sq_institute" placeholder="Name of the Institute">
                            </div>
                          </div>
                          <div class="col-3 pl-0 pr-1">
                            <div class="form-group">
                              <label>Board</label>
                              <input type="text" class="form-control form-control-sm" id="sq_board" name="sq_board" placeholder="Board">
                            </div>
                          </div>
                          <div class="col-1 pl-0 pr-1">
                            <div class="form-group">
                              <label>MO</label>
                              <input type="number" class="form-control form-control-sm" id="sq_mo" name="sq_mo" placeholder="Marks Obtained" value="0">
                            </div>
                          </div>
                          <div class="col-1 pl-0 pr-1">
                            <div class="form-group">
                              <label>MM</label>
                              <input type="number" class="form-control form-control-sm" id="sq_mm" name="sq_mm" placeholder="Maximum marks" value="100">
                            </div>
                          </div>
                          <div class="col-1 pl-0 pr-1">
                            <div class="form-group">
                              <label>CGPA</label>
                              <input type="number" class="form-control form-control-sm" id="sq_cgpa" name="sq_cgpa" placeholder="CGPA" value="0" step=".01">
                            </div>
                          </div>
                          <div class="col-1 pl-0 pr-1">
                            <div class="form-group">
                              <label>Per(%)</label>
                              <input type="number" class="form-control form-control-sm" id="sq_percentage" name="sq_percentage" placeholder="Percentage" value="0" step=".1">
                            </div>
                          </div>
                          <div class="col-1 pl-0">
                            <div class="form-group">
                              <label>Year</label>
                              <input type="number" class="form-control form-control-sm" id="sq_year" name="sq_year" placeholder="Passing Year" value="2000">
                            </div>
                          </div>
                        </div>
                        <input type="hidden" id="staffIdQual" name="staffIdQual">
                        <input type="hidden" name="action" value="updateQualification">
                        <button class="btn btn-sm" name="submit_qual" id="submit_qual">Update/Add</button>
                      </form>
                      <table class="table table-bordered table-striped list-table-xs mt-2" id="qualificationShowList">
                        <tr>
                          <th>Id</th>
                          <th>Qualification</th>
                          <th>Institute</th>
                          <th>Board</th>
                          <th>MO/MM</th>
                          <th>%/CGPA</th>
                          <th>Year</th>
                        </tr>
                      </table>
                    </div>
                    <div class="tab-pane fade" id="pills_address" role="tabpanel" aria-labelledby="pills_address">
                      <div class="row">
                        <div class="col-6 pr-0">
                          <div class="form-group">
                            <label>Permanent Address</label>
                            <textarea class="form-control form-control-sm sAddressForm" id="permanent_address" name="permanent_address" rows="3" data-tag="permanent_address"></textarea>
                          </div>
                        </div>
                        <div class="col-3 pr-0 pl-1">
                          <div class="form-group">
                            <label>Correspondence Address</label>
                            <textarea class="form-control form-control-sm sAddressForm" id="correspondence_address" name="correspondence_address" rows="3" data-tag="correspondence_address"></textarea>
                          </div>
                        </div>
                        <div class="col-3 pl-1">
                          <div class="form-group">
                            <label>State</label>
                            <div id="stateName"></div>
                            <label>District</label>
                            <p id="districtName"></p>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-3 pr-1">
                          <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control form-control-sm sAddressForm" id="sCity" name="sCity" placeholder="City" data-tag="city">
                          </div>
                        </div>
                        <div class="col-3 pl-0 pr-1">
                          <div class="form-group">
                            <label>Pin Code</label>
                            <input type="text" class="form-control form-control-sm sAddressForm" id="sPincode" name="sPincode" placeholder="Pincode" data-tag="pincode">
                          </div>
                        </div>
                        <div class="col-3 pl-0 pr-1">
                          <div class="form-group">
                            <label>State</label>
                            <p id="stateOption"></p>
                          </div>
                        </div>
                        <div class="col-3 pl-0 ">
                          <div class="form-group">
                            <label>District</label>
                            <p id="districtOption"></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="dr" role="tabpanel" aria-labelledby="list-dr-list">
            <div class="row m-2">
              <div class="col-md-12">
                <div class="text-right">
                  <a href="export_report.php" class="fas fa-file-export" target="_blank">Export to Excel</a>
                </div>
                <table id="staffListDataTable" width="100%" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>User</th>
                      <th>Department</th>
                      <th>Name</th>
                      <th>DOB</th>
                      <th>Email</th>
                      <th>Gender</th>
                      <th>Mobile</th>
                    </tr>
                  </thead>
                </table>
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

<script>
  function resetForm() {
    document.getElementById("formStaff").reset();
  }

  $(document).ready(function() {

    $(function() {
      $(document).tooltip();
    });

    // $('#example').DataTable()

    $('#staffListDataTable').DataTable({
      "lengthMenu": [ [25, 50, 100], [25, 50, 100] ],
      "pageLength": 25,
      'processing': true,
      'serverSide': true,
      'serverMethod': 'post',
      'ajax': {
        'url': 'hrDataTable.php'
      },
      'columns': [{
          data: 'sno'
        },
        {
          data: 'user_id'
        },
        {
          data: 'staff_name'
        },
        {
          data: 'staff_dob'
        },
        {
          data: 'dept_id'
        },
        {
          data: 'staff_email'
        },
        {
          data: 'staff_gender'
        },
        {
          data: 'staff_mobile'
        },
      ],
      dom: 'Blfrtip',
        buttons: [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 5 ]
                }
            },
            'colvis'
        ]
    });

    staffList();

    $('#staffSearch').keyup(function() {
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

    // Show Add Staff Modal

    $(document).on('click', '.addStaff', function() {
      $('#modal_title').text("Add Staff");
      $('#action').val("addStaff");
      $('#firstModal').modal('show');
    });

    $(document).on('submit', '#modalForm', function(event) {
      event.preventDefault(this);
      var action = $("#action").val();
      var sName = $("#sName").val();
      var stfId = $("#panelId").val();
      var error = "NO";
      var error_msg = "";
      if ($('#sName').val() === "") {
        error = "YES";
        error_msg = "Staff Name cannot be blank";
      } else if ($('#sEmail').val() === "") {
        error = "YES";
        error_msg = "Staff Email cannot be blank";
      }
      if (error == "NO") {
        var formData = $(this).serialize();
        $('#firstModal').modal('hide');
        alert(" Pressed" + formData);
        $.post("hrSql.php", formData, () => {}, "text").done(function(data) {
          $.alert("List Updtaed" + data);
          if (action == "addStaff" || action == "updateStaff") {
            staffList();
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

    $(document).on('click', '.addUser', function() {
      var id = $(this).attr("data-id");
      //$.alert("Disabled " + id);
      $.post("hrSql.php", {
        id: id,
        action: "addUser"
      }, function() {}, "text").done(function(data, status) {
        $.alert(data)
        staffList();
      }).fail(function() {
        $.alert("Error in Add User Function");
      })
    });

    $(document).on('click', '.removeUser', function() {
      var id = $(this).attr("data-id");
      // $.alert("Disabled " + id);
      $.post("hrSql.php", {
        id: id,
        action: "removeUser"
      }, function(data, status) {
        // $.alert("Data" + data)
        staffList();
      }, "text").fail(function() {
        $.alert("Error in BatchSession Function");
      })
    });

    $(document).on('click', '.uploadStaff', function() {
      var dept_id = "<?php if (isset($myDept)) echo $myDept;
                      else echo "0" ?>"
      // $.alert("dept_id " + dept_id);
      if (dept_id > 0) {
        $('#actionUpload').val('uploadStaff')
        $('#button_action').show().val('Update Staff');
        $('#formModal').modal('show');
        $('#modal_uploadTitle').text('Upload Staff');
      } else $.alert("Please select the Deprtment !!")
    });

    $(document).on('submit', '#upload_csv', function(event) {
      event.preventDefault();
      var formData = $(this).serialize();
      // action and test_id are passed as hidden
      $.alert(formData);

      $.ajax({
        url: "uploadStaffSql.php",
        method: "POST",
        data: new FormData(this),
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false
        success: function(data) {
          console.log(data);
        }
      })
    });

    $(document).on('click', '.editStaff, .autoList', function() {

      $('#staffAutoList').fadeOut();
      $('#staffSearch').val($(this).text());

      var id = $(this).attr("data-staff");
      $('#staffIdHidden').val(id);
      staffQualificationList(id);
      $.post("hrSql.php", {
        staffId: id,
        action: "fetchStaff"
      }, () => {}, "json").done(function(data) {
        // $.alert("hello" + data.staff_name);
        $("#sEmailAccordian").val(data.staff_email);
        $("#sNameAccordian").val(data.staff_name);
        $("#sMobileAccordian").val(data.staff_mobile);
        $("#sDobAccordian").val(data.staff_dob);

        $("#fName").val(data.staff_fname);
        $("#mName").val(data.staff_mname);
        $("#sAdhaar").val(data.staff_adhaar);
        $("#sAddress").val(data.staff_address);

        if (data.staff_gender == 'M') $("#male").prop("checked", true);
        else if (data.staff_gender == 'F') $("#female").prop("checked", true);

        if (data.staff_teaching == '0') $("#nonTeaching").prop("checked", true);
        else if (data.staff_teaching == '1') $("#teaching").prop("checked", true);

        if (data.staff_privilege == '0') $("#Faculty").prop("checked", true);
        else if (data.staff_privilege == '1') $("#staff").prop("checked", true);
        else if (data.staff_privilege == '9') $("#admin").prop("checked", true);

        $("#sDojAccordian").val(data.staff_doj);
        $("#staff_title").text(data.staff_name);
        $(".staff_email").text(data.staff_email);
        $(".staff_name").text(data.staff_name);
        $(".staff_mobile").text(data.staff_mobile);
        $(".staff_doj").text(data.staff_doj);
        $(".staff_userId").text(data.user_id);
        $("#staff_name_account").val(data.staff_name_account);
        $("#staff_bank").val(data.staff_bank);
        $("#staff_account").val(data.staff_account);
        $("#staff_ifsc").val(data.staff_ifsc);
        $("#sel_newDept").val(data.dept_id);
        $("#sel_des").val(data.mn_id);
        $('.staffProfile').show();
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('blur', '.staffForm', function() {
      var staffId = $("#staffIdHidden").val()
      var tag = $(this).attr("data-tag")
      var value = $(this).val()
      // $.alert("Changes " + tag + " Value " + value + " Staff " + staffId);
      $.post("hrSql.php", {
        id_name: "staff_id",
        id: staffId,
        tag: tag,
        value: value,
        action: "updateStaff"
      }, function(data) {
        // $.alert("List " + data);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('blur', '.staffQualificationForm', function() {
      var staffId = $("#staffIdHidden").val()
      var qId = $('#sel_qual').val()
      var tag = $(this).attr("data-tag")
      var value = $(this).val()
      // $.alert("Changes " + tag + " Value " + value + " Staff " + staffId + "q" + qId);
      if (qId === null) {
        $.confirm({
          title: 'Encountered an error!',
          content: 'Please Select Qualification First',
          type: 'red',
          typeAnimated: false,
          buttons: {
            tryAgain: {
              text: 'Try again',
              btnClass: 'btn-red',
              action: function() {}
            },
          }
        });
      } else {
        $.post("hrSql.php", {
          id_name: "qualification_id",
          id: qId,
          staff_id: staffId,
          tag: tag,
          value: value,
          action: "updateStaffQualification"
        }, function(data) {
          // $.alert(data);
        }, "text").fail(function() {
          $.alert("fail in place of error");
        })
      }
    });

    $(document).on('click', '.addStaffQualification', function() {
      $('#modal_title').text("Add Staff Qualifications");
      $('#firstModal').modal('show');
      var stfId = $('#panelId').val();
      $('#stfIdModal').val(stfId);
      $('.staffForm').hide();
      $('.selectPanel').show();
      $(".staffDetailForm").hide();
      $(".staffForm").hide();
      $('#action').val("addStaffQualification");
    });

    $(document).on('click', '.staff_idE', function() {
      var id = $(this).attr('id');
      $('#stqIdHidden').val(id);
      var stfId = $('#panelId').val();
      //  $.alert("Id " + id + "std" + stdId);
      $.post("hrSql.php", {
        action: "fetchStaffQualification",
        stqId: id,
        stf_id: stfId
      }, () => {}, "json").done(function(data) {
        // $.alert("List " + data.staff_id + "sq " + data.qualification_id);
        $("#sInst").val(data.staff_institute);
        $("#sBoard").val(data.staff_board);
        $("#sYear").val(data.staff_year);
        $("#sMarksObt").val(data.staff_marksObtained);
        $("#sMaxMarks").val(data.staff_marksMax);
        $("#sCgpa").val(data.staff_percentage);
        $("#modalId").val(id);
        $("#action").val("updateStaffQualification");
        var qual = data.qualification_id;
        $("#sel_qual option[value='" + qual + "']").attr("selected", "selected");
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    function staffList() {
      $.post("hrSql.php", {
        action: "staffList"
      }, function() {}, "text").done(function(data, status) {
        // $.alert("Staff List ");
        $("#staffList").html(data);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    }

    function staffQualificationList(x) {
      // $.alert("In List Function" + x);
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
      <div class="modal-content">

        <!-- Modal body -->
        <div class="modal-body">
          <div class="staffForm">
            <div class="row">
              <div class="col-12 text-center">
                <h4 class="modal-title" id="modal_title"></h4>
              </div>
            </div>
            <div class="row">
              <div class="col-4 pr-0">
                <div class="form-group">
                  Staff Name
                  <input type="text" class="form-control form-control-sm" id="sName" name="sName" placeholder="Staff Name">
                </div>
              </div>
              <div class="col-4 pl-1 pr-0">
                <div class="form-group">
                  Email
                  <input type="text" class="form-control form-control-sm" id="sEmail" name="sEmail" placeholder="Staff Email Id">
                </div>
              </div>
              <div class="col-4 pl-1">
                <div class="form-group">
                  Mobile Number
                  <input type="text" class="form-control form-control-sm" id="sMobile" name="sMobile" placeholder="Staff Mobile Number">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-4 pr-0">
                <div class="form-group">
                  Date of Joining
                  <input type="date" class="form-control form-control-sm" id="sDoj" name="sDoj" placeholder="Date of Joining">
                </div>
              </div>
              <div class="col-4 pl-1 pr-0">

              </div>
              <div class="col-4 p1-1">

              </div>
            </div>
          </div>
          <input type="hidden" id="modalId" name="modalId">
          <input type="hidden" id="action" name="action">
          <input type="hidden" id="stfIdModal" name="stfIdModal">
          <button type="submit" class="btn btn-success btn-sm" id="submitModalForm">Submit</button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

<div class="modal" id="formModal">
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" id="upload_csv">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_uploadTitle"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->

        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-group">
            <div class="row">
              <div class="col-sm-12">
                <h5>
                  Selected Department
                  <span class="selectedDepartment largeText"><?php echo $myDeptAbbri; ?></span>
                </h5>
                <hr>
                <input type="file" name="csv_upload" />
                <hr>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <p class="warning">Upload Only .csv File<br> First Row is header row<br> Data from Row 2</p>
              </div>
              <div class="col-sm-6 smallerText">
                <ul>
                  <li>Column A - Staff Name</li>
                  <li>Column B - Mobile</li>
                  <li>Column C - Email</li>
                  <!-- <li>Column G - Batch</li> -->
                </ul>
              </div>
            </div>
          </div>
          <hr>
        </div> <!-- Modal Body Closed-->
        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" name="action" id="actionUpload">
          <input type="submit" name="button_action" id="button_action" class="btn btn-sm" />
          <button type="button" class="btn btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div>

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
          $staff_id = $_POST['sqIdM'];
          $sql = "select stq.* from staff_qualification stq where stq.staff_id='$staff_id'";
          $conn->query($sql);
          $folder = '../../' . $myFolder . '/qualification';
          $file = $folder . '/' . $staff_id;
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