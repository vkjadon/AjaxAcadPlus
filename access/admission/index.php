<?php
require('../../module/requireSubModule.php');
// echo "My School in SetDefault $myScl";
$myName = getField($conn, $myId, "staff", "staff_id", "staff_name");
$myUserId = getField($conn, $myId, "staff", "staff_id", "user_id");

if (isset($myScl)) $mySclAbbri = getField($conn, $myScl, "school", "school_id", "school_abbri");
else $mySclAbbri = "Select School";
if (isset($myDept)) $myDeptAbbri = getField($conn, $myDept, "department", "dept_id", "dept_abbri");
else $myDeptAbbri = "Select Dept";
if (isset($myProg)) $myProgAbbri = getField($conn, $myProg, "program", "program_id", "sp_abbri");
else $myProgAbbri = "Select Prog";
if (isset($mySes)) $mySesName = getField($conn, $mySes, "session", "session_id", "session_name");
else $mySesName = "Select Session";
if (isset($myBatch)) $myBatchName = getField($conn, $myBatch, "batch", "batch_id", "batch");
else $myBatchName = "Select Batch";
if (!isset($myProg)) $myProg = '';
if (!isset($myBatch)) $myBatch = '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Outcome Based Education : AcadPlus</title>
  <?php require("../css.php"); ?>

</head>

<body>
  <div class="container-fluid moduleBody">
    <div class="row m-3">
      <div class="col-md-1">
        <img src="<?php echo $setLogo; ?>" width="80%">
      </div>
      <div class="col-md-3 ml-2">
        <span class="inputLabel">
          <?php
          echo $myName . '[' . $myUserId . '] - ' . $myFolder;
          //echo "School ".$myScl;
          ?>
        </span>
        <h3 class="mb-0 py-0"> Admission Module </h3>
      </div>
      <div class="col-md-3 ml-2 text-center">
        <?php
        echo $mySclAbbri . '[' . $myDeptAbbri . '] ';
        echo '<b>' . $mySesName . '</b><br>';
        //echo "School ".$myScl;
        echo $myProgAbbri . '[' . $myProg . ']-' . $myBatchName . '[' . $myBatch . ']';
        //echo "School ".$myScl;
        ?>
      </div>
      <div class="col-2 mr-2 float-right">
        <!-- <a href="<?php echo $codePath . '/module/forms/'; ?>" class="float-right">&nbsp; Forms &nbsp;</a> -->
        <!-- <a href="" class="float-right">&nbsp; Downloads &nbsp;</a> -->
        <a href="<?php echo $codePath . '/logout.php'; ?>" class="float-right">&nbsp; Logout Admission &nbsp;</a>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 pr-2">
        <div class="container card mt-2 myCard">
          <!-- nav options -->
          <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="pills_tableHome" data-toggle="pill" href="#pills_home" role="tab" aria-controls="pills_home" aria-selected="true">Student Detail</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="pills_tablePersonalInfo" data-toggle="pill" href="#pills_personalInfo" role="tab" aria-controls="pills_personalInfo" aria-selected="true">Personal Info</a>
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
            <h4> New Id <span class="newId"> - Not Created </span></h4>
            <div class="tab-pane show active" id="pills_home" role="tabpanel" aria-labelledby="pills_home">
              <form id="newStudent">
                <div class="row">
                  <div class="col-md-12 text-center">
                    <h5>
                      <?php $batch = getField($conn, $myBatch, "batch", "batch_id", "batch"); ?>
                      <label>Batch: <?php echo $batch; ?> </label>
                      <label>Session: <?php echo getField($conn, $mySes, "session", "session_id", "session_name"); ?></label>
                    </h5>
                  </div>
                  <div class="col-md-4">
                    <label>Institute/School</label>
                    <p id="schoolOption"></p>
                    <label>Programme Course</label>
                    <p id="programOption">Select a Program</p>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Semester</label>
                      <input type="number" class="form-control form-control-sm" id="stdSemester" min="1" name="stdSemester" placeholder="Admission Semester" value="1">
                    </div>
                    <div class="form-group">
                      <label>Admission Batch</label>
                      <?php
                      $sql_batch = "select * from batch where batch_status<>'9' order by batch desc";
                      $result = $conn->query($sql_batch);
                      if ($result) {
                        echo '<select class="form-control form-control-sm" name="sel_admBatch" id="sel_admBatch" required>';
                        while ($rows = $result->fetch_assoc()) {
                          $batch_name = $rows['batch'];
                          $batch_id = $rows['batch_id'];
                          echo '<option value="' . $batch_id . '">' . $batch_name . '</option>';
                        }
                        echo '</select>';
                      } else echo $conn->error;
                      if ($result->num_rows == 0) echo 'No Data Found';
                      ?>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Registration Date</label>
                      <input type="date" class="form-control form-control-sm" id="stdAdmission" name="stdAdmission" value="<?php echo $submit_date; ?>">
                    </div>
                    <div class="form-group">
                      <label>Academic Batch</label>
                      <input type="number" class="form-control form-control-sm" id="stdAcademicBatch" name="stdAcademicBatch" length="4" value="<?php echo $batch; ?>">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <input type="checkbox" lass="form-check-input" id="stdLateralEntry" name="stdLateralEntry">
                      <label>Lateral Entry</label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <input type="checkbox" lass="form-check-input" id="stdScholarship" name="stdScholarship">
                      <label>Scholarship</label>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <input type="checkbox" lass="form-check-input" checked id="stdRegular" name="stdRegular">
                      <label>Regular</label>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <input type="hidden" id="userId" name="userId" value="0">
                    <input type="hidden" id="action" name="action" value="addNew">
                    <button class="btn btn-sm">Create/Update Id</button>
                  </div>
                </div>
              </form>
            </div>
            <div class="tab-pane fade" id="pills_personalInfo" role="tabpanel" aria-labelledby="pills_personalInfo">
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
                    <div class="col-2 pr-1">
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
                    <div class="col-2 pr-1">
                      <label>Scholarship</label>
                      <div class="row">
                        <div class="col">
                          <div class="form-check-inline">
                            <input type="radio" class="form-check-input studentUpdateForm" checked id="scholNo" name="scholarship" value="0" data-tag="student_scholarship">No
                          </div>
                          <div class="form-check-inline">
                            <input type="radio" class="form-check-input studentUpdateForm" id="scholYes" name="scholarship" value="1" data-tag="student_scholarship">Yes
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
                    <div class="col-4 pr-1">
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
                    <div class="col-4 pr-1 pl-1">
                      <div class="form-group">
                        <label>Adhaar Card Number</label>
                        <input type="text" class="form-control form-control-sm studentUpdateForm" id="stdAdhaar" name="stdAdhaar" placeholder="Adhaar Number" data-tag="student_adhaar">
                      </div>
                    </div>
                    <div class="col-4 pl-1">
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
          <p class="mt-3"><label>Data of Unsaved Students</label></p>
          <table class="table table-bordered table-striped list-table-xxs mt-3" id="unsavedList">
            <th>ID</th>
            <th>Program</th>
            <th><i class="fas fa-edit"></i></th>
          </table>
        </div>

      </div>
      <div class="col-md-6 pl-2">
        <div class="container card mt-2 myCard">
          <p class="applicationForm mt-3"><label>Please Select Institution/School and the Programme to Create New ID</label></p>
        </div>

      </div>
    </div>
  </div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</body>

</html>
<script>
  $(document).ready(function() {

    window.onload = function() {
      document.onkeydown = function(e) {
        return (e.which || e.keyCode) != 116;
      }
    }

    $('[data-toggle="tooltip"]').tooltip();
    schoolOption();
    stateOption();
    unsavedStudentList();

    function schoolOption() {
      // $.alert("Department ");
      $.post("admissionSql.php", {
        action: "schoolOption"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var list = '';
        list += '<select class="form-control form-control-sm" name="sel_school" id="sel_school" required>';
        list += '<option value="0">Select Institution/School</option>'
        $.each(data, function(key, value) {
          list += '<option value=' + value.school_id + '>' + value.school_name + '</option>';
        });
        list += '</select>';
        $("#schoolOption").html(list);

      }).fail(function() {
        $.alert("Error !!");
      })
    }

    function programOption() {
      var schoolId = $("#sel_school").val()
      // $.alert("Dept " + schoolId);
      $.post("admissionSql.php", {
        schoolId: schoolId,
        action: "progOption"
      }, function() {}, "json").done(function(data, status) {
        // $.alert("List " + data);
        var list = '';
        list += '<select class="form-control form-control-sm" name="sel_prog" id="sel_prog">';
        list += '<option value="0">Select a Program</option>'
        $.each(data, function(key, value) {
          list += '<option value=' + value.program_id + '>' + value.program_name + '</option>';
        });
        list += '</select>';
        $("#programOption").html(list);

      }).fail(function() {
        $.alert("Error !!");
      })

    }

    $(document).on('change', '#sel_school', function() {
      programOption();
    });
    $(document).on('submit', '#newStudent', function(event) {
      event.preventDefault(this);
      var data = $("#userId").val();
      // $.alert("Name");
      var error = "NO";
      var error_msg = "";
      if ($('#sel_prog').val() === "0" || $('#sel_school').val() === "0") {
        error = "YES";
        error_msg = "Department and/or Program Missing.";
      }
      if (error == "NO") {
        var formData = $(this).serialize();
        alert(" Pressed" + formData);
        $.post("admissionSql.php", formData, () => {}, "text").done(function(data) {
          // $.alert(data);
          $(".newId").html(data);
          $("#userId").val(data);
          $("#stdRno").val(data);
          $("#action").val("updateId");
          studentDisp();
        }, "text").fail(function() {
          $.alert("fail in place of error");
        })
      } else {
        $.alert(error_msg);
      }
    });

    $(document).on('click', '.editUnsaved', function(event) {
      var userId = $(this).attr("data-student");
      $(".newId").html(userId)
      $("#userId").val(userId)
      // $.alert(userId);
      $.post("admissionSql.php", {
        userId: userId,
        action: "fetchStudent"
      }, () => {}, "json").done(function(data, status) {
        // $.alert(data);
        if (data == null) {
          $.alert("No Student Found!!");
          $("#studentIdHidden").val(null);

        } else {
          $("#studentIdHidden").val(data.student_id);
          $("#action").val("updateId");
          $("#stdName").val(data.student_name);
          $("#stdRno").val(data.student_rollno);
          $("#stdMobile").val(data.student_mobile);
          $("#stdEmail").val(data.student_email);
          $("#stdSemester").val(data.student_semester);
          $("#Dob").val(data.student_dob);
          $("#stdWaMobile").val(data.student_whatsapp);

          if (data.student_gender == 'M') $("#male").prop("checked", true);
          else $("#female").prop("checked", true);
          if (data.student_lateral == '1') $("#yes_leet").prop("checked", true);
          else $("#no_leet").prop("checked", true);

          //$("#sGender").val(data.student_gender);
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
          $("#uploadId").val(data.student_id);
          $("#studentIdPill").html(data.user_id);
          if (data.student_image === null) $(".studentImage").html('<img  src="../../images/upload.jpg" width="100%">');
          else $(".studentImage").html('<img  src="<?php echo '../../' . $myFolder . '/studentImages/'; ?>' + data.student_image + '" width="100%">');
          $(".progName").html(data.program_name);
          $(".batchName").html(data.batch);
          $(".semesterName").html(data.student_semester);
          studentDisp()
        }
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    function unsavedStudentList() {
      // $.alert('hello');
      $.post("admissionSql.php", {
        action: "unsavedStudentList",
      }, () => {}, "json").done(function(data) {
        var card = '';
        // $.alert(data.student_id);
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td>' + value.user_id + '</td>';
          card += '<td>' + value.program_name + '</td>';
          card += '<td><a href="#" class="editUnsaved" data-student="' + value.user_id + '"><i class="fas fa-edit"></i></a></td>';
          card += '</tr>';
        });
        $("#unsavedList").find("tr:gt(0)").remove()
        $("#unsavedList").append(card);
      }).fail(function() {
        $.alert("Not Responding");
      })
    }

    $(document).on('blur', '.studentUpdateForm', function() {
      var studentId = $("#userId").val()
      var tag = $(this).attr("data-tag")
      var value = $(this).val()
      // $.alert("Changes " + tag + " Value " + value + " Student " + studentId);
      $.post("admissionSql.php", {
        id: studentId,
        tag: tag,
        value: value,
        action: "updateStudent"
      }, function() {}, "text").done(function(data, status) {
        studentDisp();
        // $.alert(data);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('blur', '.studentDetailForm', function() {
      var studentId = $("#userId").val()
      var tag = $(this).attr("data-tag")
      var value = $(this).val()
      //   $.alert("Changes " + tag + " Value " + value + " Student " + studentId);
      $.post("admissionSql.php", {
        tag: tag,
        id: studentId,
        value: value,
        action: "updateParentsInfo"
      }, function(data) {
        // $.alert("List " + data);
        studentDisp();
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('blur', '.sAddressForm', function() {
      var studentId = $("#userId").val()
      var tag = $(this).attr("data-tag")
      var value = $(this).val()
      // $.alert("Changes " + tag + " Value " + value + " Student " + studentId);
      $.post("admissionSql.php", {
        tag: tag,
        id: studentId,
        value: value,
        action: "updateAddress"
      }, function(data) {
        // $.alert(data);
        studentDisp();

      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('blur', '.refForm', function() {
      var studentId = $("#userId").val()
      var tag = $(this).attr("data-tag")
      var value = $(this).val()
      // $.alert("Changes " + tag + " Value " + value + " Student " + studentId);
      $.post("admissionSql.php", {
        tag: tag,
        id: studentId,
        value: value,
        action: "updateReference"
      }, function(data) {
        // $.alert(data);
        studentDisp();

      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    function studentDisp() {
      var studentId = $("#userId").val()
      // $.alert(" Student Display Functio  Id " + studentId);
      $.post("admissionSql.php", {
        userId: studentId,
        action: "studentDisp"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var card = '<label><span class="warning">Submit and Save to Use the Added Student Data.</span></label>';
        card += '<button class="btn btn-sm saveData"> Submit and Save </button>';
        card += '<table class="table list-table-xs">';
        card += '<tr><td colspan="6"><h4>Student Information</h4></td></tr>'
        card += '<tr>';
        card += '<td> Student Id </td><td>' + data.user_id + '</td>';
        card += '<td> Program Name </td><td>' + data.program_name + '</td>';
        card += '<td> Batch </td><td>' + data.batch + '</td>';
        card += '</tr>';
        card += '<tr>';
        card += '<td> Semester </td><td>' + data.student_semester + '</td>';
        card += '<td> Admission </td><td>' + getFormattedDate(data.student_admission, "dmY") + '</td>';
        card += '<td> Lateral </td><td>' + data.student_lateral + '</td>';
        card += '</tr>';
        card += '<tr>';
        if (data.student_name == null) card += '<td> Name<span class="warning">*</span><span class="smallerText warning"> [Missing]</span></td><td>--</td>';
        else card += '<td> Name<span class="warning">*</span> </td><td>' + data.student_name + '</td>';
        if (getFormattedDate(data.student_dob, "dmY") == "1-1-1970") card += '<td> Dob <span class="warning">*</span><span class="smallerText warning"> [Missing]</span></td><td>--</td>';
        else card += '<td> Dob <span class="warning">*</span></td><td>' + getFormattedDate(data.student_dob, "dmY") + '</td>';
        if (data.student_email == null) card += '<td> Email </td><td>--</td>';
        else card += '<td> Email </td><td>' + data.student_email + '</td>';
        card += '</tr>';

        card += '<tr>';
        if (data.student_mobile == null) card += '<td> Mobile <span class="warning">*</span><span class="smallerText warning"> [Missing]</span></td><td>--</td>';
        else card += '<td> Mobile <span class="warning">*</span></td><td>' + data.student_mobile + '</td>';
        if (data.student_whatsapp == null) card += '<td> Whatsapp <span class="warning">*</span><span class="smallerText warning"> [Missing]</span></td><td>--</td>';
        else card += '<td> Whatsapp <span class="warning">*</span></td><td>' + data.student_whatsapp + '</td>';
        if (data.student_adhaar == null) card += '<td> Adhaar</td><td>--</td>';
        else card += '<td> Adhaar</td><td>' + data.student_adhaar + '</td>';
        card += '</tr>';

        card += '<tr>';
        if (data.student_category == null) card += '<td> Category <span class="warning">*</span><span class="smallerText warning"> [Missing]</span></td><td>--</td>';
        else card += '<td> Category <span class="warning">*</span></td><td>' + data.student_category + '</td>';
        if (data.student_religion == null) card += '<td> Religion <span class="warning">*</span><span class="smallerText warning"> [Missing]</span></td><td>--</td>';
        else card += '<td> Religion <span class="warning">*</span></td><td>' + data.student_religion + '</td>';
        if (data.student_bg == null) card += '<td> Blood Group</td><td>--</td>';
        else card += '<td> Blood Group </td><td>' + data.student_bg + '</td>';
        card += '</tr>';

        card += '<tr>';
        if (data.student_fee_category == null) card += '<td> Fee Category <span class="warning">*</span><span class="smallerText warning"> [Missing]</span></td><td>--</td>';
        else card += '<td> Fee Category <span class="warning">*</span></td><td>' + data.student_fee_category + '</td>';
        if (data.student_gender == null) card += '<td> Gender</td><td>--</td>';
        else card += '<td> Gender </td><td>' + data.student_gender + '</td>';
        card += '</tr>';

        card += '<tr><td colspan="6"><h4>Parents Information</h4></td></tr>'

        card += '<tr>';
        if (data.student_fname == null) card += '<td> Father Name <span class="warning">*</span><span class="smallerText warning"> [Missing]</span></td><td>--</td>';
        else card += '<td> Father Name <span class="warning">*</span></td><td>' + data.student_fname + '</td>';
        if (data.student_fmobile == null) card += '<td> Mobile</td><td>--</td>';
        else card += '<td> Mobile </td><td>' + data.student_fmobile + '</td>';
        if (data.student_femail == null) card += '<td> Email</td><td>--</td>';
        else card += '<td> Email</td><td>' + data.student_femail + '</td>';
        card += '</tr>';

        card += '<tr>';
        if (data.student_foccupation == null) card += '<td> Father Occupation </td><td colspan="2">--</td>';
        else card += '<td> Father Occupation</td><td colspan="2">' + data.student_foccupation + '</td>';
        if (data.student_fdesignation == null) card += '<td> Designation</td><td colspan="2">--</td>';
        else card += '<td > Designation </td><td colspan="2">' + data.student_fdesignation + '</td>';
        card += '</tr>';

        card += '<tr>';
        if (data.student_mname == null) card += '<td> Mother Name <span class="warning">*</span><span class="smallerText warning"> [Missing]</span></td><td>--</td>';
        else card += '<td> Mother Name <span class="warning">*</span></td><td>' + data.student_mname + '</td>';
        if (data.student_mmobile == null) card += '<td> Mobile</td><td>--</td>';
        else card += '<td> Mobile</td><td>' + data.student_mmobile + '</td>';
        if (data.student_memail == null) card += '<td> Email</td><td>--</td>';
        else card += '<td> Email</td><td>' + data.student_memail + '</td>';
        card += '</tr>';

        card += '<tr>';
        if (data.student_moccupation == null) card += '<td> Mother Occupation </td><td colspan="2">--</td>';
        else card += '<td> Mother Occupation</td><td colspan="2">' + data.student_moccupation + '</td>';
        if (data.student_mdesignation == null) card += '<td> Designation</td><td colspan="2">--</td>';
        else card += '<td> Designation</td><td colspan="2">' + data.student_mdesignation + '</td>';
        card += '</tr>';

        card += '<tr><td colspan="6"><h4>Address Details</h4></td></tr>'

        card += '<tr>';
        if (data.permanent_address == null) card += '<td> Permanent Address <span class="warning">*</span><span class="smallerText warning"> [Missing]</span></td><td colspan="5">--</td>';
        else card += '<td> Permanent Address <span class="warning">*</span></td><td colspan="5">' + data.permanent_address + '<br>' + $("#sel_state option:selected").text(); + '</td>';
        card += '</tr>';

        card += '<tr>';
        if (data.city == null) card += '<td> City </td><td colspan="2">--</td>';
        else card += '<td> City </td><td colspan="2">' + data.city + '</td>';
        if (data.pincode == null) card += '<td> Pincode </td><td colspan="2">--</td>';
        else card += '<td> Pincode </td><td colspan="2">' + data.pincode + '</td>';
        card += '</tr>';

        card += '<tr>';
        if (data.correspondence_address == null) card += '<td> Correspondence Address</td><td colspan="5">--</td>';
        else card += '<td> Correspondence Address </td><td colspan="5">' + data.correspondence_address + '</td>';
        card += '</tr>';

        card += '<tr><td colspan="6"><h4>Reference Details</h4></td></tr>'

        card += '<tr>';
        if (data.reference_name == null) card += '<td> Name </td><td colspan="2">--</td>';
        else card += '<td> Name </td><td colspan="2">' + data.reference_name + '</td>';
        if (data.reference_mobile == null) card += '<td> Mobile </td><td colspan="2">--</td>';
        else card += '<td> Mobile </td><td colspan="2">' + data.reference_mobile + '</td>';
        card += '</tr>';

        card += '<tr>';
        if (data.reference_staff == null) card += '<td> Staff </td><td colspan="2">--</td>';
        else card += '<td> Staff </td><td colspan="2">' + data.reference_staff + '</td>';
        if (data.reference_designation == null) card += '<td> Designation </td><td colspan="2">--</td>';
        else card += '<td> Designation </td><td colspan="2">' + data.reference_designation + '</td>';
        card += '</tr>';
        card += '</table>';
        $(".applicationForm").html(card);
        return data;
      }).fail(function() {
        $.alert("Could not Fetch Student Data!!");
      })
    }

    $(document).on('click', '.saveData', function() {
      var studentId = $("#userId").val()
      // $.alert(" Student Display Functio  Id " + studentId);
      $.post("admissionSql.php", {
        userId: studentId,
        action: "studentDisp"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var card = '';
        var error = 'N'
        card += '<h5>Check if the Mandatory Fields are Missing</h5>'
        card += '<table class="table list-table-xs">';
        if (data.student_name == null) {
          card += '<tr><td> Name <span class="smallerText warning"> is missing</span></td></tr>';
          error = 'Y';
        }
        if (getFormattedDate(data.student_dob, "dmY") == "1-1-1970") {
          card += '<tr><td> DoB <span class="smallerText warning"> is missing</span></td></tr>';
          error = 'Y';
        }
        if (data.student_mobile == null) {
          card += '<tr><td> Mobile <span class="smallerText warning"> is missing</span></td></tr>';
          error = 'Y';
        }
        if (data.student_whatsapp == null) {
          card += '<tr><td> WhatsApp <span class="smallerText warning"> is missing</span></td></tr>';
          error = 'Y';
        }
        if (data.student_category == null) {
          card += '<tr><td> Category <span class="smallerText warning"> is missing</span></td></tr>';
          error = 'Y';
        }
        if (data.student_religion == null) {
          card += '<tr><td> Religion <span class="smallerText warning"> is missing</span></td></tr>';
          error = 'Y';
        }
        if (data.student_fee_category == null) {
          card += '<tr><td> Fee Category <span class="smallerText warning"> is missing</span></td></tr>';
          error = 'Y';
        }
        if (data.student_fname == null) {
          card += '<tr><td> Father Name <span class="smallerText warning"> is missing</span></td></tr>';
          error = 'Y';
        }
        if (data.student_mname == null) {
          card += '<tr><td> Mother Name <span class="smallerText warning"> is missing</span></td></tr>';
          error = 'Y';
        }
        if (data.permanent_address == null) {
          card += '<tr><td> MPermanent Address <span class="smallerText warning"> is missing</span></td></tr>';
          error = 'Y';
        }
        card += '</table>';
        if (error == "Y") $.alert(card);
        else {
          $.post("admissionSql.php", {
            userId: studentId,
            action: "saveStudent"
          }, function() {}, "text").done(function(data, status) {
            $.alert("Student Saved !!");
          })
        }
      })
    });

    $(document).on('change', '#sel_state', function() {
      districtOption();
    });

    function stateOption() {
      // $.alert("Department ");
      $.post("admissionSql.php", {
        action: "stateOption"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var list = '';
        list += '<select class="form-control form-control-sm sAddressForm" name="sel_state" id="sel_state" data-tag="state_id">';
        list += '<option value="0">Select State</option>'
        $.each(data, function(key, value) {
          list += '<option value="' + value.state_id + '" data-state="' + value.state_name + '">' + value.state_name + '</option>';
        });
        list += '</select>';
        $("#stateOption").html(list);

      }).fail(function() {
        $.alert("Error in State Options !!");
      })
    }

    function districtOption() {
      var stateId = $("#sel_state").val()
      // $.alert("Dept " + stateId);
      $.post("admissionSql.php", {
        stateId: stateId,
        action: "districtOption"
      }, function() {}, "json").done(function(data, status) {
        // $.alert("List " + data);
        var list = '';
        list += '<select class="form-control form-control-sm sAddressForm" name="sel_district" id="sel_district" data-tag="district_id">';
        list += '<option value="0">Select a Distrcit</option>'
        $.each(data, function(key, value) {
          list += '<option value=' + value.district_id + '>' + value.district_name + '</option>';
        });
        list += '</select>';
        $("#districtOption").html(list);

      }).fail(function() {
        $.alert("Error !!");
      })

    }

    function studentList() {
      var studentId = $("#userId").val()
      $.post("admissionSql.php", {
        action: "studentList",
        id: studentId
      }, () => {}, "json").done(function(data) {
        var card = '';
        // $.alert(data.student_id);
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td>' + value.user_id + '</td>';
          card += '<td>' + value.student_semester + '</td>';
          card += '<td>' + getFormattedDate(value.student_admission, "dmY") + '</td>';
          card += '<td>' + value.program_name + '</td>';
          card += '<td>' + value.batch + '</td>';
          card += '</tr>';
        });
        $("#studentTable").find("tr:gt(0)").remove()
        $("#studentTable").append(card);
      }).fail(function() {
        $.alert("Not Responding");
      })
    }

    function personalList() {
      var studentId = $("#userId").val()
      $.post("admissionSql.php", {
        action: "personalList",
        id: studentId
      }, () => {}, "json").done(function(data) {
        var card = '';
        // $.alert(data.student_id);
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td>' + value.student_name + '</td>';
          card += '<td>' + value.student_rollno + '</td>';
          card += '<td>' + value.student_mobile + '</td>';
          card += '<td>' + value.student_email + '</td>';
          card += '<td>' + getFormattedDate(value.student_dob, "dmY") + '</td>';
          card += '<td>' + value.student_adhaar + '</td>';
          card += '</tr>';
        });
        $("#personalTable").find("tr:gt(0)").remove()
        $("#personalTable").append(card);
      }).fail(function() {
        $.alert("Not Responding");
      })
    }

    $(document).on('click', '.editStudent', function() {
      $('.studentProfile').show();
      var id = $(this).attr("data-student");
      // $.alert(id);
      $("#studentIdHidden").val(id);
      studentQualificationList();
      $.post("admissionSql.php", {
        studentId: id,
        action: "fetchStudent"
      }, () => {}, "json").done(function(data) {
        // $.alert(data)
        console.log(data)
        $(".student_email").text(data.student_email);
        $(".student_name").text(data.student_name);
        $(".student_rollno").text(data.student_rollno);
        $(".student_mobile").text(data.student_mobile);

        $("#stdName").val(data.student_name);
        $("#stdRno").val(data.student_rollno);
        $("#stdMobile").val(data.student_mobile);
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

    $(document).on('blur', '.sQualForm', function() {
      var studentId = $("#userId").val()
      var qId = $('#sel_qual').val()
      var tag = $(this).attr("data-tag")
      var value = $(this).val()
      // $.alert("Changes " + tag + " Value " + value + " Student " + studentId + " qaul " + qId);
      if (qId === "" || studentId == "") {
        $.confirm({
          title: 'Encountered an error!',
          content: 'Please Select Qualification and Student ',
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
          mn_id: qId,
          tag: tag,
          id: studentId,
          value: value,
          action: "updateStudentQualification"
        }, function(data) {
          // $.alert("List " + data);
        }, "text").fail(function() {
          $.alert("fail in place of error");
        })
      }
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

    function studentQualificationList() {
      var studentId = $("#studentIdHidden").val()
      // $.alert("In List Function" + x);
      $.post("admissionSql.php", {
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
  });
</script>

</html>