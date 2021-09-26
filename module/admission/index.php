<?php
require('../requireSubModule.php');
$phpFile = "admissionSql.php";
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
          <h5>Manage Students</h5>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action cbp" id="list-cbp-list" data-toggle="list" href="#list-cbp" role="tab" aria-controls="cbp">Change Batch/Program</a>
          <a class="list-group-item list-group-item-action ssr" id="list-ssr-list" data-toggle="list" href="#list-ssr" role="tab" aria-controls="ssr">Student Strength Report</a>
          <a class="list-group-item list-group-item-action sr" id="list-sr-list" data-toggle="list" href="#list-sr" role="tab" aria-controls="sr">Student Report</a>
          <a class="list-group-item list-group-item-action active as" id="list-as-list" data-toggle="list" href="#list-as" role="tab" aria-controls="as"> Update Student </a>
        </div>
      </div>
      <div class="col-10 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <div class="row">
            <div class="col-md-3 pr-0">
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
            <div class="col-md-3">
              <div class="card border-info">
                <div class="input-group">
                  <?php
                  $sql_program = "select * from program where program_status='0' order by sp_name";
                  $result = $conn->query($sql_program);
                  if ($result) {
                    echo '<select class="form-control form-control-sm" name="sel_program" id="sel_program" required>';
                    echo '<option selected disabled>Select Program</option>';
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
            <div class="col-md-1">
              <div class="row ml-2">
                <h3>
                  <a class="fa fa-arrow-circle-up uploadStudent"></a>
                </h3>
              </div>
            </div>
            <div class="col-md-3">
              <p class="smallText" id="totalStudents"></p>
            </div>
            <div class="col-md-1">
              <input type="checkbox" id="leet" name="leet" value="1">
              <span class="smallText">LEET</span>
            </div>
            <div class="col-md-1">
              <input type="checkbox" id="ay" name="ay_id" value="1">
              <span class="smallText">AY</span>
            </div>
          </div>
          <div class="tab-pane show active" id="list-as" role="tabpanel" aria-labelledby="list-as-list">
            <div class="row">
              <div class="col-4">
                <div class="card border-info mt-2">
                  <div class="card-header">
                    ENTER USER ID TO SEARCH
                  </div>
                  <div class="card-body text-primary">
                    <div class="row">
                      <div class="col-md-7 pr-0">
                        <input name="studentSearch" id="studentSearch" class="form-control form-control-sm" type="text" placeholder="Search Student" aria-label="Search">
                      </div>
                      <div class="col-md-2 pl-1">
                        <a class="fa fa-search xlText" id="searchStudent"></a>
                      </div>
                      <div class="col-md-3 pl-1">
                        <a class="fa fa-trash xlText float-right" id="dropStudent"></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-8">
                <div class="container card mt-2 myCard">
                  <!-- nav options -->
                  <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">

                    <li class="nav-item">
                      <a class="nav-link active" id="pills_tablePersonalInfo" data-toggle="pill" href="#pills_personalInfo" role="tab" aria-controls="pills_personalInfo" aria-selected="true">Personal Info</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="pills_tableParentsInfo" data-toggle="pill" href="#pills_parentsInfo" role="tab" aria-controls="pills_parentsInfo" aria-selected="true">Parents Info</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="pills_tableAddress" data-toggle="pill" href="#pills_address" role="tab" aria-controls="pills_address" aria-selected="true">Address Details</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link pills_qualification" id="pills_tableQualification" data-toggle="pill" href="#pills_qualification" role="tab" aria-controls="pills_qualification" aria-selected="true">Qualification</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link pills_reference" id="pills_tableReference" data-toggle="pill" href="#pills_reference" role="tab" aria-controls="pills_reference" aria-selected="true">Reference</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="pills-tabContent p-3">
                    <!-- <h4> New Id <span class="newId"> - Not Created </span></h4> -->
                    <div class="tab-pane" id="pills_home" role="tabpanel" aria-labelledby="pills_home">
                      <form id="newStudent">
                        <div class="row">
                          <div class="col-md-12 text-center">
                            <h5>
                              <?php $batch = getField($conn, $myBatch, "batch", "batch_id", "batch"); ?>
                              <label>Batch: <?php echo $batch; ?> </label>
                              <label>Session: <?php echo getField($conn, $mySes, "session", "session_id", "session_name"); ?></label>
                            </h5>
                          </div>
                          <!-- <div class="col-md-4">
                    <label>Institute/School</label>
                    <p id="schoolOption"></p>
                    <label>Programme Course</label>
                    <p id="programOption"></p>
                  </div> -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Semester</label>
                              <input type="number" class="form-control form-control-sm" id="stdSemester" min="1" name="stdSemester" placeholder="Admission Semester" value="1">
                            </div>
                            <div class="form-group">
                              <label>Academic Batch</label>
                              <input type="number" class="form-control form-control-sm" id="stdAcademicBatch" name="stdAcademicBatch" length="4" value="<?php echo $batch; ?>">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Registration Date</label>
                              <input type="date" class="form-control form-control-sm" id="stdAdmission" name="stdAdmission" value="<?php echo $submit_date; ?>">
                            </div>
                          </div>
                          <!-- <div class="col-md-4">
                    <div class="form-group">
                      <input type="checkbox" lass="form-check-input" id="stdLateralEntry" name="stdLateralEntry">
                      <label>Lateral Entry</label>
                    </div>
                  </div> -->
                          <div class="col-md-4">
                            <input type="hidden" id="userId" name="userId" value="0">
                            <input type="hidden" id="action" name="action" value="addNew">
                            <!-- <button class="btn btn-sm">Create/Update Id</button> -->
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="tab-pane fade show active" id="pills_personalInfo" role="tabpanel" aria-labelledby="pills_personalInfo">
                      <input type="hidden" id="studentIdHidden" name="studentIdHidden">
                      <div class="row">
                        <div class="col-12">
                          <div class="row">
                            <div class="col-4 pr-1">
                              <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control form-control-sm studentUpdateForm" id="stdName" name="stdName" placeholder="Name of the Student" data-tag="student_name">
                              </div>
                            </div>
                            <div class="col-4 pr-1 pl-1">
                              <div class="form-group">
                                <label>Roll Number</label>
                                <input type="text" class="form-control form-control-sm studentUpdateForm" id="stdRno" name="stdRno" placeholder="Roll Number of the Student" data-tag="student_rollno">
                              </div>
                            </div>
                            <div class="col-4 pl-1">
                              <div class="form-group">
                                <label>Mobile</label>
                                <input type="text" class="form-control form-control-sm studentUpdateForm" id="stdMobile" name="stdMobile" placeholder="Mobile Number of the Student" data-tag="student_mobile">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-4 pr-1">
                              <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control form-control-sm studentUpdateForm" id="stdEmail" name="stdEmail" placeholder="Email ID of the Student" data-tag="student_email">
                              </div>
                            </div>
                            <div class="col-4 pr-1 pl-1">
                              <div class="form-group">
                                <label>Date of Birth</label>
                                <input type="date" class="form-control form-control-sm studentUpdateForm" id="Dob" name="Dob" placeholder="Date of Birth" data-tag="student_dob">
                              </div>
                            </div>
                            <div class="col-4 pl-1">
                              <div class="form-group">
                                <label>WhatsApp Number</label>
                                <input type="text" class="form-control form-control-sm studentUpdateForm" id="stdWaMobile" name="stdWaMobile" placeholder="Whats App Number" data-tag="student_whatsapp">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-4 pr-1">
                              <label>Gender</label>
                              <div class="row">
                                <div class="col">
                                  <div class="form-check-inline">
                                    <input type="radio" class="form-check-input studentUpdateForm" checked id="male" name="sGender" value="M" data-tag="student_gender">Male
                                  </div>
                                  <div class="form-check-inline">
                                    <input type="radio" class="form-check-input studentUpdateForm" id="female" name="sGender" value="F" data-tag="student_gender">Female
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-4 pr-1 pl-1">
                              <div class="form-group">
                                <label>Caste</label>
                                <div class="row">
                                  <div class="col">
                                    <?php
                                    $sql_caste = "select * from master_name where mn_code='cst'";
                                    $result = $conn->query($sql_caste);
                                    if ($result) {
                                      echo '<select class="form-control form-control-sm studentUpdateForm" name="sel_caste" id="sel_caste" data-tag="student_category" required>';
                                      echo '<option value="0">Select Caste</option>';
                                      while ($rows = $result->fetch_assoc()) {
                                        $select_name = $rows['mn_name'];
                                        $abbri = $rows['mn_abbri'];
                                        echo '<option value="' . $abbri . '">' . $select_name . '</option>';
                                      }
                                      echo '</select>';
                                    } else echo $conn->error;
                                    if ($result->num_rows == 0) echo 'No Data Found';
                                    ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-4 pl-1">
                              <div class="form-group">
                                <label>Blood Group</label>
                                <div class="row">
                                  <div class="col">
                                    <?php
                                    $sql_bg = "select * from master_name where mn_code='bg'";
                                    $result = $conn->query($sql_bg);
                                    if ($result) {
                                      echo '<select class="form-control form-control-sm studentUpdateForm" name="sql_bg" id="sql_bg" data-tag="student_bg" required>';
                                      echo '<option value="">Blood Group</option>';
                                      while ($rows = $result->fetch_assoc()) {
                                        $select_name = $rows['mn_name'];
                                        $abbri = $rows['mn_abbri'];
                                        echo '<option value="' . $abbri . '">' . $select_name . '</option>';
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
                            <div class="col-3 pr-1">
                              <div class="form-group">
                                <label>Religion</label>
                                <div class="row">
                                  <div class="col">
                                    <?php
                                    $sql_rg = "select * from master_name where mn_code='rel'";
                                    $result = $conn->query($sql_rg);
                                    if ($result) {
                                      echo '<select class="form-control form-control-sm studentUpdateForm" name="sql_rg" id="sql_rg" data-tag="student_religion" required>';
                                      echo '<option value="">Religion</option>';
                                      while ($rows = $result->fetch_assoc()) {
                                        $abbri = $rows['mn_abbri'];
                                        $select_name = $rows['mn_name'];
                                        echo '<option value="' . $abbri . '">' . $select_name . '</option>';
                                      }
                                      echo '</select>';
                                    } else echo $conn->error;
                                    if ($result->num_rows == 0) echo 'No Data Found';
                                    ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-3 pr-1 pl-1">
                              <div class="form-group">
                                <label>Adhaar Card Number</label>
                                <input type="text" class="form-control form-control-sm studentUpdateForm" id="stdAdhaar" name="stdAdhaar" placeholder="Adhaar Number" data-tag="student_adhaar">
                              </div>
                            </div>
                            <div class="col-3 pr-1 pl-1">
                              <div class="form-group">
                                <label>Fee Category </label>
                                <div class="row">
                                  <div class="col">
                                    <?php
                                    $sql_fcg = "select * from master_name where mn_code='fcg'";
                                    $result = $conn->query($sql_fcg);
                                    if ($result) {
                                      echo '<select class="form-control form-control-sm studentUpdateForm" name="sql_fcg" id="sql_fcg" data-tag="student_fee_category" required>';
                                      echo '<option value="">Fee Category</option>';
                                      while ($rows = $result->fetch_assoc()) {
                                        $abbri = $rows['mn_abbri'];
                                        $select_name = $rows['mn_name'];
                                        echo '<option value="' . $abbri . '">' . $select_name . '</option>';
                                      }
                                      echo '</select>';
                                    } else echo $conn->error;
                                    if ($result->num_rows == 0) echo 'No Data Found';
                                    ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-3 pl-1">
                              <div class="form-group">
                                <label>Registration Date</label>
                                <input type="date" class="form-control form-control-sm studentUpdateForm" id="stdAdmission" name="stdAdmission" value="<?php echo $submit_date; ?>">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="pills_parentsInfo" role="tabpanel" aria-labelledby="pills_parentsInfo">
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
                            <input type="text" class="form-control form-control-sm studentDetailForm" id="fMobile" name="fMobile" placeholder="Father's Mobile Number" data-tag="student_fmobile">
                          </div>
                        </div>
                        <div class="col-3 pl-1 pr-1">
                          <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control form-control-sm studentDetailForm" id="fEmail" name="fEmail" placeholder="Father's Email Address" data-tag="student_femail">
                          </div>
                        </div>
                        <div class="col-3 pl-1 pr-1">
                          <div class="form-group">
                            <label>Mother Mobile</label>
                            <input type="text" class="form-control form-control-sm studentDetailForm" id="mMobile" name="mMobile" placeholder="Mother's Mobile Number" data-tag="student_mmobile">
                          </div>
                        </div>
                        <div class="col-3 pl-1">
                          <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control form-control-sm studentDetailForm" id="mEmail" name="mEmail" placeholder="Mother's Email Address" data-tag="student_memail">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="pills_address" role="tabpanel" aria-labelledby="pills_address">
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group">
                            <label>Permanent Address</label>
                            <textarea class="form-control form-control-sm sAddressForm" id="permanent_address" name="permanent_address" rows="3" data-tag="permanent_address"></textarea>
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

                      <div class="row">
                        <div class="col-12">
                          <div class="form-group">
                            <label>Correspondence Address</label>
                            <textarea class="form-control form-control-sm sAddressForm" id="correspondence_address" name="correspondence_address" rows="3" data-tag="correspondence_address"></textarea>
                          </div>
                        </div>
                      </div>

                    </div>
                    <div class="tab-pane fade" id="pills_qualification" role="tabpanel" aria-labelledby="pills_qualification">
                      <div class="row">
                        <div class="col-2 pr-1">
                          <div class="form-group">
                            <label>Qual</label>
                            <div class="row">
                              <div class="col">
                                <?php
                                $sql_qualification = "select * from master_name where mn_code='qt'";
                                $result = $conn->query($sql_qualification);
                                if ($result) {
                                  echo '<select class="form-control form-control-sm" name="sel_qual" id="sel_qual" data-tag="qualification_id" required>';
                                  echo '<option value="">Qualification</option>';
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
                        <div class="col-6 pl-0 pr-1">
                          <div class="form-group">
                            <label>Institute</label>
                            <input type="text" class="form-control form-control-sm sQualForm" id="sInst" name="sInst" placeholder="Name of the Institute" data-tag="sq_institute">
                          </div>
                        </div>
                        <div class="col-4 pl-0">
                          <div class="form-group">
                            <label>Board</label>
                            <input type="text" class="form-control form-control-sm sQualForm" id="sBoard" name="sBoard" placeholder="Board" data-tag="sq_board">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-2 pr-1">
                          <div class="form-group">
                            <label>MO</label>
                            <input type="number" class="form-control form-control-sm sQualForm" id="sMarksObt" name="sMarksObt" placeholder="Marks Obtained" data-tag="sq_mo">
                          </div>
                        </div>
                        <div class="col-2 pl-0 pr-1">
                          <div class="form-group">
                            <label>MM</label>
                            <input type="text" class="form-control form-control-sm sQualForm" id="sMaxMarks" name="sMaxMarks" placeholder="Maximum marks" data-tag="sq_mm">
                          </div>
                        </div>
                        <div class="col-4 pl-0 pr-1">
                          <div class="form-group">
                            <label>Percentage/CGPA</label>
                            <input type="text" class="form-control form-control-sm sQualForm" id="sCgpa" name="sCgpa" placeholder="Percentage/CGPA" data-tag="sq_percentage">
                          </div>
                        </div>
                        <div class="col-4 pl-0">
                          <div class="form-group">
                            <label>Year of Passing</label>
                            <input type="text" class="form-control form-control-sm sQualForm" id="sYear" name="sYear" placeholder="Passing Year" data-tag="sq_year">
                          </div>
                        </div>
                      </div>
                      <p style="text-align:center" id="qualificationShowList"></p>
                    </div>
                    <div class="tab-pane fade" id="pills_reference" role="tabpanel" aria-labelledby="pills_reference">
                      <div class="row">
                        <div class="col-6 pr-1">
                          <div class="form-group">
                            <label>Name of Consultant</label>
                            <input type="text" class="form-control form-control-sm refForm" id="cName" name="cName" placeholder="Name of the Consultant" data-tag="reference_name">
                          </div>
                        </div>
                        <div class="col-3 pl-0">
                          <div class="form-group">
                            <label>Contact Number</label>
                            <input type="text" class="form-control form-control-sm refForm" id="cNumber" name="cNumber" placeholder="Contact Number" data-tag="reference_mobile">
                          </div>
                        </div>
                        <div class="col-3 pr-1">
                          <div class="form-group">
                            <label>Incentive</label>
                            <input type="text" class="form-control form-control-sm refForm" id="cIncentive" name="cIncentive" placeholder="Incentive" data-tag="reference_incentive">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-6 pr-1">
                          <div class="form-group">
                            <label>Name of Staff</label>
                            <input type="text" class="form-control form-control-sm refForm" id="refStaff" name="refStaff" placeholder="Name of the Staff" data-tag="reference_staff">
                          </div>
                        </div>
                        <div class="col-3 pl-0">
                          <div class="form-group">
                            <label>Designation</label>
                            <input type="text" class="form-control form-control-sm refForm" id="refDesignation" name="refDesignation" placeholder="Designation" data-tag="reference_designation">
                          </div>
                        </div>
                        <div class="col-3 pl-0">
                          <div class="form-group">
                            <label>Contact</label>
                            <input type="text" class="form-control form-control-sm refForm" id="refContact" name="refContact" placeholder="Contact" data-tag="reference_contact">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group">
                            <label>Remarks</label>
                            <textarea class="form-control form-control-sm refForm" id="remarks" name="remarks" rows="3" data-tag="remarks"></textarea>
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
              <div class="col-md-12" style="overflow: scroll;">
                <div class="container card mt-2 myCard">
                  <div class="row m-2">
                    <div class="col-md-11 smallerText">
                      <input type="checkbox" checked id="courseField"> Course
                      <input type="checkbox" checked id="rollnoField"> RollNo
                      <input type="checkbox" checked id="mobileField"> Mobile
                      <input type="checkbox" checked id="semField"> Sem
                      <input type="checkbox" checked id="dorField"> DoR
                      <input type="checkbox" checked id="dobField"> DOB
                      <input type="checkbox" checked id="waField"> WApp
                      <input type="checkbox" checked id="adhaarField"> Adhaar
                      <input type="checkbox" checked id="catField"> Cat
                      <input type="checkbox" checked id="relField"> Rel
                      <input type="checkbox" checked id="bgField"> BG
                      <input type="checkbox" checked id="feeField"> Fee
                      <br>
                      <input type="checkbox" checked id="genderField"> Gender
                      <input type="checkbox" checked id="fNameField"> FName
                      <input type="checkbox" checked id="fDetailsField"> Family
                    </div>
                    <div class="col-md-1 text-right"><a onclick="printDiv('print')" class="fa fa-print"></a>
                      <a class="fas fa-file-export" id="export"></a>
                    </div>
                  </div>
                  <div id="print" style="overflow: scroll;">
                    <table class="table table-bordered table-striped list-table-xxs mt-3" id="studentShowList">
                      <!-- <th><i class="fas fa-edit"></i></th> -->
                      <th>S.No</th>
                      <th>ID</th>
                      <th>Name</th>
                      <th class="fNameField">Father's Name</th>
                      <th class="courseField">Course</th>
                      <th class="rollnoField">RollNo</th>
                      <th class="mobileField">Mobile</th>
                      <th class="semField">Sem</th>
                      <th class="dorField">DoR</th>
                      <th class="dobField">DoB</th>
                      <th class="waField">WA No</th>
                      <th>Address</th>
                      <th>City</th>
                      <th>District</th>
                      <th>State</th>
                      <th>Pincode</th>
                      <th class="adhaarField">Adhaar</th>
                      <th class="catField">Category</th>
                      <th class="relField">Religion</th>
                      <th class="bgField">Blood Group</th>
                      <th class="feeField">Fee</th>
                      <th class="genderField">Gender</th>
                      <th class="fDetailsField">FMobile</th>
                      <th class="fDetailsField">FEmail</th>
                      <th class="fDetailsField">FOccupation </th>
                      <th class="fDetailsField">FDeisgnation</th>
                      <th class="fDetailsField">MName</th>
                      <th class="fDetailsField">MMobile</th>
                      <th class="fDetailsField">MEmail</th>
                      <th>Reference Name</th>
                      <th>Reference Staff</th>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-ssr" role="tabpanel" aria-labelledby="list-ssr-list">
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
    studentList();
    studentProgramReport();
    totalStudents();

    $(document).on('click', '#dropStudent', function(event) {
      var data = $("#studentIdHidden").val();
      // $.alert(data);
      if (data > 0) {
        $.confirm({
          title: 'Please Confirm !',
          draggable: true,
          content: "<b><i>Are you Sure to Remove Student ? </i></b>",
          buttons: {
            confirm: {
              btnClass: 'btn-info',
              action: function() {
                $.post("<?php echo $phpFile; ?>", {
                  action: "dropStudent",
                  id: data,
                }, () => {}, "text").done(function(data) {
                  // $.alert(data);
                }, "text").fail(function() {
                  $.alert("fail in place of error");
                })
              }
            },
            cancel: {
              btnClass: "btn-danger",
              action: function() {}
            },
          }
        });
      } else {
        $.alert("No Student Selected !!");
      }
    });

    $(document).on('click', '#searchStudent', function(event) {
      var data = $("#studentSearch").val();
      // $.alert(data);
      $.post("<?php echo $phpFile; ?>", {
        action: "fetchStudent",
        userId: data,
      }, () => {}, "json").done(function(data, status) {
        // $.alert(status);
        if (data == null) {
          $.alert("No Student Found!!");
          $("#studentIdHidden").val(null);

        } else {
          $("#stdName").val(data.student_name);
          $("#stdRno").val(data.student_rollno);
          $("#stdMobile").val(data.student_mobile);
          $("#stdEmail").val(data.student_email);
          $("#Dob").val(data.student_dob);
          $("#stdWaMobile").val(data.student_whatsapp);
          // $("#stdNa").val(data.student_gender);
          $("#sel_caste").val(data.student_category);
          $("#sql_bg").val(data.student_bg);
          $("#sql_rg").val(data.student_religion);
          $("#stdAdhaar").val(data.student_adhaar);
          $("#sql_fcg").val(data.student_fee_category);
          $("#stdAdmission").val(data.student_admission);
          $("#fName").val(data.student_fname);
          $("#mName").val(data.student_mname);
          $("#fMobile").val(data.student_fmobile);
          $("#mMobile").val(data.student_mmobile);
          $("#fEmail").val(data.student_femail);
          $("#mEmail").val(data.student_memail);
          $("#permanent_address").val(data.permanent_address);
          $("#sCity").val(data.city);
          $("#sPincode").val(data.pincode);
          $("#sel_state").val(data.state_name);
          $("#sel_district").val(data.district_name);
          $("#mEmail").val(data.student_memail);
          $("#cName").val(data.reference_name);
          $("#cNumber").val(data.reference_mobile);
          $("#refStaff").val(data.reference_staff);
          $("#cIncentive").val(data.reference_incentive);
          $("#refDesignation").val(data.reference_designation);
          $("#refContact").val(data.reference_contact);
          $("#remarks").val(data.remarks);
          $("#studentIdHidden").val(data.student_id);
        }
        // $.alert(data);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '#state_id', function() {
      var student_id = $(this).attr("data-tag")
      // $.alert(student_id);
      $('#firstModal').modal('show');
      $(".studentForm").hide();
      $("#modalId").val(student_id);
    });

    $(document).on('submit', '#modalForm', function(event) {
      event.preventDefault();
      var formData = $(this).serialize();
      // $.alert(formData);
      $.post("<?php echo $phpFile; ?>", formData, () => {}, "text").done(function(data) {
        $.alert(data);
        studentList()
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
      $('#firstModal').modal('hide');

    });


    $(document).on('blur', '.studentUpdateForm', function() {
      var userId = $("#studentSearch").val();
      var tag = $(this).attr("data-tag")
      var value = $(this).val()
      // $.alert("Changes " + tag + " Value " + value + " Student " + userId);
      $.post("<?php echo $phpFile; ?>", {
        id_name: "user_id",
        id: userId,
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
      // $.alert("Changes " + tag + " Value " + value + " Student " + studentId);
      $.post("<?php echo $phpFile; ?>", {
        id_name: "student_id",
        id: studentId,
        tag: tag,
        value: value,
        action: "updateDetails"
      }, function(data) {
        // $.alert("List " + data);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('blur', '.sAddressForm', function() {
      var studentId = $("#studentIdHidden").val()
      var tag = $(this).attr("data-tag")
      var value = $(this).val()
      // $.alert("Changes " + tag + " Value " + value + " Student " + studentId);
      $.post("<?php echo $phpFile; ?>", {
        id_name: "student_id",
        id: studentId,
        tag: tag,
        value: value,
        action: "updateAddress"
      }, function(data) {
        // $.alert("List " + data);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('blur', '.refForm', function() {
      var studentId = $("#studentIdHidden").val()
      var tag = $(this).attr("data-tag")
      var value = $(this).val()
      // $.alert("Changes " + tag + " Value " + value + " Student " + studentId);
      $.post("<?php echo $phpFile; ?>", {
        id_name: "student_id",
        id: studentId,
        tag: tag,
        value: value,
        action: "updateReference"
      }, function(data) {
        // $.alert("List " + data);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
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
      $.post("<?php echo $phpFile; ?>", {
        action: "changeBatch",
        batchId: batchId,
        checkboxes_value: checkboxes_value,
      }, function(data, status) {
        $.alert(data);
      }, "text").fail(function() {
        $.alert("Fail");
      })
    });


    $(document).on('click', '.cbp', function() {
      $.post("<?php echo $phpFile; ?>", {
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

    $(document).on('click', '#courseField, #rollnoField, #mobileField, #semField, #dorField, #dobField, #waField, #adhaarField, #catField, #relField, #bgField, #feeField, #genderField, #fDetailsField', function() {
      if ($('#courseField').is(":checked")) $(".courseField").show();
      else $(".courseField").hide();
      if ($('#rollnoField').is(":checked")) $(".rollnoField").show();
      else $(".rollnoField").hide();
      if ($('#mobileField').is(":checked")) $(".mobileField").show();
      else $(".mobileField").hide();
      if ($('#semField').is(":checked")) $(".semField").show();
      else $(".semField").hide();
      if ($('#dorField').is(":checked")) $(".dorField").show();
      else $(".dorField").hide();
      if ($('#dobField').is(":checked")) $(".dobField").show();
      else $(".dobField").hide();
      if ($('#waField').is(":checked")) $(".waField").show();
      else $(".waField").hide();
      if ($('#adhaarField').is(":checked")) $(".adhaarField").show();
      else $(".adhaarField").hide();
      if ($('#catField').is(":checked")) $(".catField").show();
      else $(".catField").hide();
      if ($('#relField').is(":checked")) $(".relField").show();
      else $(".relField").hide();
      if ($('#bgField').is(":checked")) $(".bgField").show();
      else $(".bgField").hide();
      if ($('#feeField').is(":checked")) $(".feeField").show();
      else $(".feeField").hide();
      if ($('#genderField').is(":checked")) $(".genderField").show();
      else $(".genderField").hide();
      if ($('#fDetailsField').is(":checked")) $(".fDetailsField").show();
      else $(".fDetailsField").hide();
    });

    $("#checkall").change(function() {
      $(".checkitem").prop("checked", $(this).prop("checked"))
    })

    $(document).on('click', '.uploadStudent', function() {
      // $.alert("Session From");
      var selected_batch = $("#sel_batch").val()
      var selected_prog = $("#sel_program").val()
      // $.alert("Batch Not Selected" + selected_batch + "Prog" + selected_prog)
      if (selected_batch == null || selected_prog == null) $.alert("Batch or Program Not Selected")
      else {
        $(".selectedBatch").text($("#sel_batch option:selected").text());
        $(".selectedProg").text($("#sel_program option:selected").text());
        $("#selectedBatch").val(selected_batch)
        $("#selectedProg").val(selected_prog)
        $('#formModal').modal('show');
      }
    });

    $(document).on('submit', '#upload_csv', function(event) {
      event.preventDefault();
      var formData = $(this).serialize();
      // $.alert(formData);
      // action and other paramenters are passed as hidden
      $.ajax({
        url: "uploadStudentSql.php",
        method: "POST",
        data: new FormData(this),
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false
        success: function(data) {
          $.alert(data);
          studentList()
          $('#formModal').modal('hide');
        }
      })
    });


    $(document).on('change', '#sel_batch, #sel_program', function() {
      studentList();
      totalStudents();
    });

    $(document).on('click', '#ay', function() {
      studentList();
      totalStudents();
    });

    $(document).on('click', '#leet', function() {
      studentList();
      totalStudents();
    });

    function studentList() {
      var batchId = $("#sel_batch").val()
      var progId = $("#sel_program").val()
      if ($('#leet').is(":checked")) var leet = 1;
      else var leet = 0;
      if ($('#ay').is(":checked")) var ay = 1;
      else var ay = 0;
      // $.alert("checked " + $('#leet').is(":checked") + "leet " + leet);
      $.post("<?php echo $phpFile; ?>", {
        batchId: batchId,
        progId: progId,
        leet: leet,
        ay: ay,
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
            // card += '<td><a href="#" class="fa fa-edit editStudent" data-student="' + value.student_id + '"></a></td>';
            card += '<td>' + count++ + '</td>';
            card += '<td>' + value.user_id + '</td>';
            card += '<td>' + value.student_name + '</td>';
            card += '<td class="fnameField">' + value.student_fname + '</td>';
            card += '<td class="courseField">' + value.program_name + '</td>';
            card += '<td class="rollnoField">' + value.student_rollno + '</td>';
            card += '<td class="mobileField">' + value.student_mobile + '</td>';
            card += '<td class="semField">' + value.student_semester + '</td>';
            card += '<td class="dorField">' + getFormattedDate(value.student_admission, "dmY") + '</td>';
            card += '<td class="dobField">' + getFormattedDate(value.student_dob, "dmY") + '</td>';
            card += '<td class="waField">' + value.student_whatsapp + '</td>';
            card += '<td>' + value.permanent_address + '</td>';
            card += '<td>' + value.city + '</td>';
            card += '<td>' + value.district_name + '</td>';
            card += '<td id="state_id" data-tag="' + value.student_id + '">' + value.state_name + '</td>';
            card += '<td>' + value.pincode + '</td>';
            card += '<td class="adhaarField">' + value.student_adhaar + '</td>';
            card += '<td class="catField">' + value.student_category + '</td>';
            card += '<td class="relField">' + value.student_religion + '</td>';
            card += '<td class="bgField">' + value.student_bg + '</td>';
            card += '<td class="feeField">' + value.student_fee_category + '</td>';
            card += '<td class="genderField">' + value.student_gender + '</td>';
            card += '<td class="fDetailsField">' + value.student_fmobile + '</td>';
            card += '<td class="fDetailsField">' + value.student_femail + '</td>';
            card += '<td class="fDetailsField">' + value.student_foccupation + '</td>';
            card += '<td class="fDetailsField">' + value.student_fdesignation + '</td>';
            card += '<td class="fDetailsField">' + value.student_mname + '</td>';
            card += '<td class="fDetailsField">' + value.student_mmobile + '</td>';
            card += '<td class="fDetailsField">' + value.student_memail + '</td>';
            card += '<td>' + value.reference_name + '</td>';
            card += '<td>' + value.reference_staff + '</td>';
            card += '</tr>';
          }
        });
        $("#studentShowList").find("tr:gt(0)").remove();
        $("#studentShowList").append(card);

      }).fail(function() {
        $.alert("Error !!");
      })

    }

    function studentQualificationList() {
      var studentId = $("#studentIdHidden").val()

      // $.alert("In List Function" + x);
      $.post("<?php echo $phpFile; ?>", {
        stdId: studentId,
        action: "studentQualificationList"
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
      $.post("<?php echo $phpFile; ?>", {
        action: "studentProgramList",
      }, function(mydata, mystatus) {
        $("#studentProgramReport").show();
        // $.alert("List qulai" + mydata);
        $("#studentProgramReport").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })

    }

    function totalStudents() {
      var batchId = $("#sel_batch").val()
      var programId = $("#sel_program").val()
      if ($('#leet').is(":checked")) var leet = 1;
      else var leet = 0;
      if ($('#ay').is(":checked")) var ay = 1;
      else var ay = 0;

      //  $.alert("In List Function" + programId);
      $.post("<?php echo $phpFile; ?>", {
        programId: programId,
        batchId: batchId,
        leet: leet,
        ay: ay,
        action: "totalStudents"
      }, function(mydata, mystatus) {
        $("#totalStudents").show();
        // $.alert("List qulai" + mydata);
        $("#totalStudents").html(mydata);
      }, "text").fail(function() {
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
          <div class="stateForm">
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  State
                  <?php
                  $sql = "select * from states";
                  selectInput($conn, "Select State", "state_id", "state_name", "", "sel_state", $sql);
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->
        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="modalId" name="modalId">
          <input type="hidden" id="action" name="action" value="updateState">
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
              <p class="selectedBatch"></p>
            </div>
            <div class="col-sm-6">
              <h5>Selected Program</h5>
              <p class="selectedProg"></p>
            </div>
          </div>
          <hr>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-5">
                <input type="file" name="student_upload" />
                <p>&nbsp;</p>
                <p class="warning">Only .csv File to be uploaded</p>
                <p class="warning">First Row is header row</p>
                <p class="warning">Data from Row 2</p>
              </div>
              <div class="col-sm-7 smallerText">
                <ul>
                  <li>Column A - SNo</li>
                  <li>Column B - User Id</li>
                  <li>Column C - Roll Number</li>
                  <li>Column D - Student Name</li>
                  <li>Column E - Father Name</li>
                  <li>Column F - Moile</li>
                  <!-- <li>Column G - Batch</li> -->
                </ul>
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->
        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" name="selectedBatch" id="selectedBatch" />
          <input type="hidden" name="selectedProg" id="selectedProg" />
          <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" />
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div>

</html>