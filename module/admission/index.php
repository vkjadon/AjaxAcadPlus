<?php
require('../requireSubModule.php');
$phpFile = "admissionSql.php";
addActivity($conn, $myId, "Manage Student - Admission");

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
          <h5>Students</h5>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <?php
          if (in_array("13", $myLinks)) echo '<a class="list-group-item list-group-item-action as" id="list-as-list" data-toggle="list" href="#list-as" role="tab" aria-controls="as"> Update Student </a>';
          if (in_array("13", $myLinks)) echo '<a class="list-group-item list-group-item-action" data-toggle="list" href="#list-qual" role="tab" aria-controls="qual">Qualification Report</a>';
          if (in_array("14", $myLinks)) echo '<a class="list-group-item list-group-item-action ss" id="list-ss-list" data-toggle="list" href="#list-ss" role="tab" aria-controls="ss">Student Status</a>';
          if (in_array("15", $myLinks)) echo '<a class="list-group-item list-group-item-action sr" id="list-sr-list" data-toggle="list" href="#list-sr" role="tab" aria-controls="sr">Student Report</a>';
          if (in_array("16", $myLinks)) echo '<a class="list-group-item list-group-item-action ssr" id="list-ssr-list" data-toggle="list" href="#list-ssr" role="tab" aria-controls="ssr">Student Strength</a>';
          ?>
        </div>
      </div>
      <div class="col-11 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <div class="row">
            <div class="col-md-2 pr-0">
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
            <div class="col-md-2">
              <div class="card border-info">
                <div class="input-group">
                  <?php
                  $sql_program = "select * from program where program_status='0' order by sp_name";
                  $result = $conn->query($sql_program);
                  if ($result) {
                    echo '<select class="form-control form-control-sm" name="sel_program" id="sel_program" required>';
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
            <div class="col-md-2">
              <p class="smallText"> Students : <span id="totalStudents"></span></p>
            </div>
            <div class="col-md-5">
              <input type="checkbox" checked id="ay" name="ay_id" value="1">
              <span class="smallText">AY</span>
              <input type="checkbox" id="leet" name="leet" value="1">
              <span class="smallText">LEET</span>
              <input type="checkbox" id="deleted" name="deleted" value="1">
              <span class="smallText">Deleted</span>
              <input type="checkbox" checked id="hostel" name="hostel">
              <span class="smallText">Hostel</span>
              <input type="checkbox" checked id="transport" name="transport">
              <span class="smallText">Transport</span>
              <input type="checkbox" checked id="dayScholar" name="dayScholar">
              <span class="smallText">Day Scholar</span>
            </div>
          </div>
          <div class="tab-pane fade" id="list-as" role="tabpanel" aria-labelledby="list-as-list">
            <div class="row">
              <div class="col-4">
                <div class="card border-info mt-2">
                  <div class="card-header">
                    ENTER USER ID TO SEARCH
                  </div>
                  <div class="card-body text-primary p-1">
                    <div class="row">
                      <div class="col-md-7 pr-0">
                        <input name="studentSearch" id="studentSearch" class="form-control form-control-sm" type="text" placeholder="Search Student" aria-label="Search">
                      </div>
                      <div class="col-md-3 pl-1">
                        <a class="fa fa-search xlText float-right" id="searchStudent"></a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card border-info mt-2">
                  <div class="card-body text-primary p-1">
                    <div class="row">
                      <div class="col-md-7 pr-0">
                        <?php
                        $sql = "select * from master_name where mn_code='dse' and mn_status='0'";
                        selectInput($conn, "Select Reason", "mn_id", "mn_name", "mn_abbri", "sel_mn", $sql);
                        ?>
                      </div>
                      <div class="col-md-3 pl-1">
                        <a class="fa fa-trash xlText float-right" id="dropStudent"></a>
                      </div>
                      <div class="col-md-2 pl-1">
                        <a class="fa fa-refresh xlText float-right" style="color: yellowgreen;" id="resetStudent"></a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card border-info mt-2">
                  <div class="card-body text-primary p-1">
                    <div class="row">
                      <div class="col-md-7 pr-0">
                        <?php
                        $sql = "select * from program where program_status='0'";
                        selectInput($conn, "Select New Prog/Branch", "program_id", "sp_name", "sp_abbri", "new_prog", $sql);
                        ?>
                      </div>
                      <div class="col-md-3 pl-1">
                        <a class="fa fa-exchange-alt xlText float-right" id="changeBranch"></a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card border-info mt-2">
                  <div class="card-body text-primary p-1">
                    <div class="row">
                      <div class="col-md-7 pr-0">
                        <?php
                        $sql = "select * from batch where batch_status='0'";
                        selectInput($conn, "Select New Admission Batch", "batch_id", "batch", "batch_id", "new_adBatch", $sql);
                        ?>
                      </div>
                      <div class="col-md-3 pl-1">
                        <a class="fa fa-exchange-alt xlText float-right" id="changeAdBatch"></a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card border-info mt-2">
                  <div class="card-body text-primary p-1">
                    <div class="row">
                      <div class="col-md-7 pr-0">
                        <?php
                        $sql = "select * from batch where batch_status='0'";
                        selectInput($conn, "Select New Academic Batch", "batch_id", "batch", "batch_id", "new_acBatch", $sql);
                        ?>
                      </div>
                      <div class="col-md-3 pl-1">
                        <a class="fa fa-exchange-alt xlText float-right" id="changeAcBatch"></a>
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
                      <a class="nav-link active" data-toggle="pill" href="#home" role="tab" aria-controls="home" aria-selected="true">Student Home</a>
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
                    <div class="tab-pane show active" id="home" role="tabpanel" aria-labelledby="home">
                      <div class="row">
                        <div class="col-12">
                          <div class="row">
                            <div class="col-3 pr-1 text-center">
                              <span class="studentImage"><img src="../../images/upload.jpg" width="100%"></span>
                              <form class="form-horizontal" id="uploadModalForm">
                                <div class="form-group">
                                  <input type="file" name="upload_file">
                                  <input type="hidden" name="studentId" id="uploadId">
                                  <input type="hidden" name="action" value="uploadImage"><br>
                                  <button type="submit" class="btn btn-sm btn-block">Upload Image</button>
                                </div>
                              </form>
                            </div>
                            <div class="col-9 pr-1">
                              <div class="row">
                                <div class="col-md-9">
                                  <table width="100%">
                                    <tr>
                                      <td width="60%"><span class="largeText">User Id </span></td>
                                      <td class="largeText" id="studentIdPill">---</td>
                                    </tr>
                                    <tr>
                                      <td width="60%"><span class="largeText">Admission Year </span></td>
                                      <td class="largeText batchName">---</td>
                                    </tr>
                                    <tr>
                                      <td><span class="largeText">Program </span></td>
                                      <td class="largeText progName">---</td>
                                    </tr>
                                    <tr>
                                      <td><span class="largeText">Admission Semester </span></td>
                                      <td class="largeText semesterName">---</td>
                                    </tr>
                                    <tr>
                                      <td><span class="largeText">Academic Year </span></td>
                                      <td class="largeText ayName">---</td>
                                    </tr>
                                    <tr>
                                      <td><span class="largeText"> Current Status </span></td>
                                      <td class="warning"><h4><span id="status">---</span></h4></td>
                                    </tr>
                                    <tr>
                                      <td width="60%"><span class="largeText"> Id </span></td>
                                      <td class="largeText homeId">---</td>
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
                    <div class="tab-pane fade" id="pills_personalInfo" role="tabpanel" aria-labelledby="pills_personalInfo">
                      <input type="hidden" class="studentIdHidden" id="studentIdHidden" name="studentIdHidden">
                      <div class="row">
                        <div class="col-12">
                          <div class="row">
                            <div class="col-4 pr-1">
                              <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control form-control-sm studentUpdateForm" id="stdName" name="stdName" placeholder="Name of the Student" data-tag="student_name">
                              </div>
                            </div>
                            <div class="col-3 pr-1 pl-1">
                              <div class="form-group">
                                <label>Roll Number</label>
                                <input type="text" class="form-control form-control-sm studentUpdateForm" id="stdRno" name="stdRno" placeholder="Roll Number of the Student" data-tag="student_rollno">
                              </div>
                            </div>
                            <div class="col-3 pl-1 pr-1">
                              <div class="form-group">
                                <label>Mobile</label>
                                <input type="text" class="form-control form-control-sm studentUpdateForm" id="stdMobile" name="stdMobile" placeholder="Mobile Number of the Student" data-tag="student_mobile">
                              </div>
                            </div>
                            <div class="col-md-2 pl-1">
                              <div class="form-group">
                                <label>Semester</label>
                                <input type="number" class="form-control form-control-sm studentUpdateForm" id="stdSemester" min="1" name="stdSemester" placeholder="Admission Semester" data-tag="student_semester">
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
                            <div class="col-3 pr-1 pl-1">
                              <div class="form-group">
                                <label>Date of Birth</label>
                                <input type="date" class="form-control form-control-sm studentUpdateForm" id="Dob" name="Dob" placeholder="Date of Birth" data-tag="student_dob">
                              </div>
                            </div>
                            <div class="col-3 pr-1 pl-1">
                              <div class="form-group">
                                <label>Registration Date</label>
                                <input type="date" class="form-control form-control-sm studentUpdateForm" id="stdAdmission" name="stdAdmission" data-tag="student_admission" value="<?php echo $submit_date; ?>">
                              </div>
                            </div>
                            <div class="col-2 pl-1">
                              <div class="form-group">
                                <label>WhatsApp</label>
                                <input type="text" class="form-control form-control-sm studentUpdateForm" id="stdWaMobile" name="stdWaMobile" placeholder="Whats App Number" data-tag="student_whatsapp">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-3 pr-1">
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
                            <div class="col-2 pr-1 pl-1">
                              <label>Scholarship</label>
                              <div class="row">
                                <div class="col">
                                  <div class="form-check-inline">
                                    <input type="radio" class="form-check-input studentUpdateForm" id="yes_scholarship" name="scholarship" value="1" data-tag="student_scholarship">Yes
                                  </div>
                                  <div class="form-check-inline">
                                    <input type="radio" class="form-check-input studentUpdateForm" checked id="no_scholarship" name="scholarship" value="0" data-tag="student_scholarship">No
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-2 pr-1 pl-1">
                              <label>LEET</label>
                              <div class="row">
                                <div class="col">
                                  <div class="form-check-inline">
                                    <input type="radio" class="form-check-input studentUpdateForm" checked id="yes_leet" name="sLeet" value="1" data-tag="student_lateral">Yes
                                  </div>
                                  <div class="form-check-inline">
                                    <input type="radio" class="form-check-input studentUpdateForm" id="no_leet" name="sLeet" value="0" data-tag="student_lateral">No
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-3 pr-1 pl-1">
                              <label>Regular</label>
                              <div class="row">
                                <div class="col">
                                  <div class="form-check-inline">
                                    <input type="radio" class="form-check-input studentUpdateForm" checked id="yes_regular" name="sRegular" value="1" data-tag="student_regular">Yes
                                  </div>
                                  <div class="form-check-inline">
                                    <input type="radio" class="form-check-input studentUpdateForm" id="no_regular" name="sRegular" value="0" data-tag="student_regular">No
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-2 pr-1">
                              <div class="form-group">
                                <label>Adhaar</label>
                                <input type="text" class="form-control form-control-sm studentUpdateForm" id="stdAdhaar" name="stdAdhaar" placeholder="Adhaar Number" data-tag="student_adhaar">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-2 pr-1">
                              <label>Residential Status</label>
                              <div class="row">
                                <div class="col">
                                  <div class="form-group">
                                    <select class="form-control form-control-sm studentUpdateForm" name="sel_srs" id="sel_srs" data-tag="student_residential_status">
                                      <option value="0">Day Scholar</option>
                                      <option value="1">Hostller</option>
                                      <option value="2">Transport</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-2 pr-1 pl-1">
                              <div class="form-group">
                                <label>Religion</label>
                                <div class="row">
                                  <div class="col">
                                    <?php
                                    $sql_rg = "select * from master_name where mn_code='rel'";
                                    $result = $conn->query($sql_rg);
                                    if ($result) {
                                      echo '<select class="form-control form-control-sm studentUpdateForm" name="sel_rg" id="sel_rg" data-tag="student_religion" required>';
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
                            <div class="col-2 pr-1 pl-1">
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
                            <div class="col-2 pr-1 pl-1">
                              <div class="form-group">
                                <label>Blood Group</label>
                                <div class="row">
                                  <div class="col">
                                    <?php
                                    $sql_bg = "select * from master_name where mn_code='bg'";
                                    $result = $conn->query($sql_bg);
                                    if ($result) {
                                      echo '<select class="form-control form-control-sm studentUpdateForm" name="sel_bg" id="sel_bg" data-tag="student_bg" required>';
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
                            <div class="col-2 pl-1">
                              <div class="form-group">
                                <label>Fee Category </label>
                                <div class="row">
                                  <div class="col">
                                    <?php
                                    $sql_fcg = "select * from master_name where mn_code='fcg'";
                                    $result = $conn->query($sql_fcg);
                                    if ($result) {
                                      echo '<select class="form-control form-control-sm studentUpdateForm" name="sel_fcg" id="sel_fcg" data-tag="student_fee_category" required>';
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
                            <div class="col-2 pl-1">
                              <div class="form-group">
                                <label>Admn Cat</label>
                                <div class="row">
                                  <div class="col">
                                    <?php
                                    $sql_fcg = "select * from master_name where mn_code='adc'";
                                    $result = $conn->query($sql_fcg);
                                    if ($result) {
                                      echo '<select class="form-control form-control-sm studentUpdateForm" name="sel_adc" id="sel_adc" data-tag="student_admission_category" required>';
                                      echo '<option value="">Admission Category</option>';
                                      while ($rows = $result->fetch_assoc()) {
                                        $id = $rows['mn_id'];
                                        $select_name = $rows['mn_name'];
                                        echo '<option value="' . $id . '">' . $select_name . '</option>';
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
                    <div class="tab-pane fade" id="pills_qualification" role="tabpanel" aria-labelledby="pills_qualification">
                      <form id="qualForm">
                        <div class="row">
                          <div class="col-1 pr-1">
                            <div class="form-group">
                              <label>Qual</label>
                              <div class="row">
                                <div class="col">
                                  <?php
                                  $sql_qualification = "select * from master_name where mn_code='qt'";
                                  $result = $conn->query($sql_qualification);
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
                        <input type="hidden" id="studentIdQual" name="studentIdQual">
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
              <div class="col-md-12">
                <div class="card mt-2 myCard">
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
                      <input type="checkbox" checked id="genderField"> Gender
                      <input type="checkbox" checked id="fNameField"> FName
                      <input type="checkbox" checked id="fDetailsField"> Family
                    </div>
                    <div class="col-md-1 text-right">
                      <a onclick="printDiv('print')" class="fa fa-print"></a>
                      <a class="fas fa-file-export" id="export"></a>
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
                        <th>Acd Yr</th>
                        <th>LEET</th>
                        <th>Regular</th>
                        <th>Scholarship</th>
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
          <div class="tab-pane fade" id="list-ss" role="tabpanel" aria-labelledby="list-ss-list">
            <div class="row">
              <div class="col-10">
                <div class="container card m-2 myCard">
                  <div class="row mt-2">
                    <div class="col-md-3 pr-0">
                      <label>Status Type</label>
                      <?php
                      $sql = "select * from master_name where mn_code='sts'";
                      $result = $conn->query($sql);
                      if ($result) {
                        echo '<select class="form-control form-control-sm" name="sel_ss" id="sel_ss">';
                        while ($rows = $result->fetch_assoc()) {
                          $select_id = $rows['mn_id'];
                          $select_name = $rows['mn_name'];
                          echo '<option value="' . $select_id . '">' . $select_name . '</option>';
                        }
                        // echo '<option value="ALL">ALL</option>';
                        echo '</select>';
                      } else echo $conn->error;
                      if ($result->num_rows == 0) echo 'No Data Found';
                      ?>
                    </div>
                    <div class="col-md-1 pl-1 pr-0">
                      <label>Semester</label>
                      <input type="number" class="form-control form-control-sm" id="ssSemester" name="ssSemester" min="1" value="1">
                    </div>
                    <div class="col-md-2 pl-1">
                      <button type="button" class="btn btn-sm mt-4" id="showSSList">Refresh List</button>
                    </div>
                    <div class="col-md-6 text-right">
                      <a onclick="printDiv('printSS')" class="fa fa-print mt-2 xlText"></a>
                      <button type="button" class="btn btn-sm" id="updateStatus">Update Status</button>
                    </div>
                  </div>
                  <div id="printSS">
                    <table class="table table-bordered table-striped list-table-xs mt-4" id="studentStatusTable">
                      <tr>
                        <th>#</th>
                        <th><input type="checkbox" id="checkall" /></th>
                        <th>Id</th>
                        <th>UserId</th>
                        <th>Name</th>
                        <th>Father Name</th>
                        <th>Specialization</th>
                        <th>AY</th>
                        <th>LEET</th>
                        <th>Roll No.</th>
                        <th>Mobile</th>
                        <th>Remarks</th>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-qual" role="tabpanel" aria-labelledby="list-qual-list">
            <div class="row">
              <div class="col-10">
                <div class="container card m-2 myCard">
                  <div class="col text-right">
                    <a onclick="printDiv('printQual')" class="fa fa-print largeText"></a>
                    <a class="fa fa-file-export largeText" id="exportQual"></a>
                  </div>
                  <div id="printQual">
                    <table class="table table-bordered table-striped list-table-xs mt-4" id="qualificationTable">
                      <tr>
                        <th>#</th>
                        <th>Id</th>
                        <th>UserId</th>
                        <th>Name</th>
                        <th>Father Name</th>
                        <th>Specialization</th>
                        <th>Qual</th>
                        <th>MO</th>
                        <th>MM</th>
                        <th>%</th>
                        <th>CGPA</th>
                        <th>Year</th>
                        <th>Institute</th>
                        <th>Board</th>
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

    $('[data-toggle="tooltip"]').tooltip();

    $(document).on("click", "#exportQual", function() {
      // $.alert("ds");
      $("#qualificationTable").table2excel({
        filename: "qualification.xls"
      });
    })
    studentList();
    studentProgramReport();
    stateOption()
    // districtOption()

    function stateOption() {
      // $.alert(" State ");
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

    $(document).on('change', '#sel_state', function() {
      districtOption();
    });

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

    $(document).on('submit', '#uploadModalForm', function(event) {
      event.preventDefault();
      var formData = $(this).serialize();
      $.alert(formData);
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

    $(document).on('click', '#dropStudent', function(event) {
      var data = $("#studentIdHidden").val();
      var mn_id = $("#sel_mn").val();
      // $.alert(mn_id);
      if (data > 0 && mn_id > 0) {
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
                  mn_id: mn_id,
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
        $.alert("Student or Reason not Selected!!");
      }
    });

    $(document).on('click', '#resetStudent', function(event) {
      var data = $("#studentIdHidden").val();
      // $.alert(data);
      if (data > 0) {
        $.confirm({
          title: 'Please Confirm !',
          draggable: true,
          content: "<b><i>Are you Sure to Re-instate the Student ? </i></b>",
          buttons: {
            confirm: {
              btnClass: 'btn-info',
              action: function() {
                $.post("<?php echo $phpFile; ?>", {
                  action: "resetStudent",
                  id: data,
                }, () => {}, "text").done(function(data) {
                  // $.alert(data);
                }).fail(function() {
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
        $.alert("Student or Reason not Selected!!");
      }
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
          $("#studentIdQual").val(null);

        } else {
          $("#studentIdHidden").val(data.student_id);
          $("#studentIdQual").val(data.student_id);
          
          if (data.student_status == '9') $("#status").html("Deleted");
          else if (data.student_status == '0') $("#status").html("Active");
          
          
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
          if (data.student_scholarship == '1') $("#yes_scholarship").prop("checked", true);
          else $("#no_scholarship").prop("checked", true);
          if (data.student_regular == '1') $("#yes_regular").prop("checked", true);
          else $("#no_regular").prop("checked", true);
          
          $("#stdAdhaar").val(data.student_adhaar);
          
          $("#sel_srs").val(data.student_residential_status);
          $("#sel_rg").val(data.student_religion);
          $("#sel_caste").val(data.student_category);
          $("#sel_bg").val(data.student_bg);
          $("#sel_fcg").val(data.student_fee_category);
          $("#sel_adc").val(data.student_admission_category);
          
          $("#stdAdmission").val(data.student_admission);
          $("#fName").val(data.student_fname);
          $("#mName").val(data.student_mname);
          $("#fMobile").val(data.student_fmobile);
          $("#mMobile").val(data.student_mmobile);
          $("#fEmail").val(data.student_femail);
          $("#mEmail").val(data.student_memail);
          $("#sCity").val(data.city);
          $("#sPincode").val(data.pincode);
          
          var address = data.permanent_address;
          $("#permanent_address").val(address);
          
          var state_id = data.state_id;
          var district_id = data.district_id;
          
          $("#mEmail").val(data.student_memail);
          $("#cName").val(data.reference_name);
          $("#cNumber").val(data.reference_mobile);
          $("#refStaff").val(data.reference_staff);
          $("#cIncentive").val(data.reference_incentive);
          $("#refDesignation").val(data.reference_designation);
          $("#refContact").val(data.reference_contact);
          $("#remarks").val(data.remarks);
          $("#uploadId").val(data.student_id);
          $("#studentIdPill").html(data.user_id);
          if (data.student_image === null) $(".studentImage").html('<img  src="../../images/upload.jpg" width="100%">');
          else $(".studentImage").html('<img  src="<?php echo '../../' . $myFolder . '/studentImages/'; ?>' + data.student_image + '" width="100%">');
          $(".progName").html(data.program_name);
          $(".batchName").html(data.batch);
          $(".semesterName").html(data.student_semester);
          $(".homeId").html(data.student_id);
          $.post("<?php echo $phpFile; ?>", {
            userId: data.user_id,
            action: "fetchAcademicBatch"
          }, () => {}, "json").done(function(data, status) {
            $(".ayName").html(data.batch);
          })
          $.post("<?php echo $phpFile; ?>", {
            state_id: state_id,
            action: "fetchState"
          }, () => {}, "json").done(function(data, status) {
            $("#stateName").html(data.state_name)
            // address = address + data.state_name;
          })
          $.post("<?php echo $phpFile; ?>", {
            district: district_id,
            action: "fetchDistrict"
          }, () => {}, "json").done(function(data, status) {
            $("#districtName").html(data.district_name)
            // address = address + data.district_name;
          })
        }
        studentQualificationList()
        // $.alert(data);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('submit', '#modalForm', function(event) {
      event.preventDefault();
      var formData = $(this).serialize();
      // $.alert(formData);
      $.post("<?php echo $phpFile; ?>", formData, () => {}, "text").done(function(data) {
        $.alert(data);
        studentList()
      }).fail(function() {
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

    $(document).on('submit', '#qualForm', function(event) {
      event.preventDefault();
      var studentId = $("#studentIdQual").val();
      var sel_qual = $("#sel_qual").val();
      if (studentId > 0 && sel_qual > 0) {
        var formData = $(this).serialize();
        // $.alert(formData);
        $.post("<?php echo $phpFile; ?>", formData, () => {}, "text").done(function(data) {
          // $.alert(data);
          studentQualificationList()
        }).fail(function() {
          $.alert("fail in place of error");
        })
      } else $.alert("Please select Student and Qualification !!")
    });

    function studentQualificationList() {
      var studentId = $("#studentIdHidden").val()
      // $.alert("In List Function" + studentId);
      $.post("<?php echo $phpFile; ?>", {
        stdId: studentId,
        action: "studentQualificationList"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data)
        var card = '';
        var count = 1;
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td><a class="fa fa-pencil-alt editQual" data-sq="' + value.sq_id + '"></a>' + value.sq_id + '</td>';
          card += '<td>' + value.mn_name + '</td>';
          card += '<td>' + value.sq_institute + '</td>';
          card += '<td>' + value.sq_board + '</td>';
          card += '<td>' + value.sq_mo + '/' + value.sq_mm + '</td>';
          card += '<td>' + value.sq_percentage + '/' + value.sq_cgpa + '</td>';
          card += '<td>' + value.sq_year + '</td>';
          card += '</tr>';
        });
        $("#qualificationShowList").find("tr:gt(0)").remove();
        $("#qualificationShowList").append(card);
      }).fail(function() {
        $.alert("Could not Fetch Student Qualification !!");
      })
    }
    $(document).on('click', '.editQual', function() {
      var mn_id = $(this).attr("data-sq")
      var studentId = $("#studentIdHidden").val();
      // $.alert("Change  " + progId + " Student Id " + studentId);
      if (studentId > 0 && mn_id > 0) {
        $.post("<?php echo $phpFile; ?>", {
          mn_id: mn_id,
          studentId: studentId,
          action: "fetchStudentQualification",
        }, function() {}, "json").done(function(data, status) {
          // $.alert(data.sq_id)
          $('#sel_qual').val(data.mn_id);
          $("#sq_mo").val(data.sq_mo)
          $("#sq_year").val(data.sq_year)
        }).fail(function() {
          $.alert("Error in Qualification !!");
        })
      } else $.alert("Please select Student and New Programme!!")
    })

    $(document).on('click', '#changeBranch', function() {
      var progId = $("#new_prog").val()
      var studentId = $("#studentIdHidden").val();

      // $.alert("Change  " + progId + " Student Id " + studentId);
      if (studentId > 0 && progId > 0) {
        $.post("<?php echo $phpFile; ?>", {
          progId: progId,
          studentId: studentId,
          action: "changeBranch",
        }, function() {}, "text").done(function(data, status) {
          $.alert(data)
        }).fail(function() {
          $.alert("Error in Change Branch!!");
        })
      } else $.alert("Please select Student and New Programme!!")
    });

    $(document).on('click', '#changeAdBatch', function() {
      var batchId = $("#new_adBatch").val()
      var studentId = $("#studentIdHidden").val();

      // $.alert("Change  " + progId + " Student Id " + studentId);
      if (studentId > 0 && batchId > 0) {
        $.post("<?php echo $phpFile; ?>", {
          batchId: batchId,
          studentId: studentId,
          action: "changeAdBatch",
        }, function() {}, "text").done(function(data, status) {
          $.alert(data)
        }).fail(function() {
          $.alert("Error in Change Branch!!");
        })
      } else $.alert("Please select Student and New Admission Batch!!")
    });

    $(document).on('click', '#changeAcBatch', function() {
      var batchId = $("#new_acBatch").val()
      var studentId = $("#studentIdHidden").val();

      // $.alert("Change  " + progId + " Student Id " + studentId);
      if (studentId > 0 && batchId > 0) {
        $.post("<?php echo $phpFile; ?>", {
          batchId: batchId,
          studentId: studentId,
          action: "changeAcBatch",
        }, function() {}, "text").done(function(data, status) {
          $.alert(data)
        }).fail(function() {
          $.alert("Error in Change Branch!!");
        })
      } else $.alert("Please select Student and New Academic Batch!!")
    });


    $(document).on('click', '#updateStatus', function() {
      var batchId = $("#sel_batch").val()
      var progId = $("#sel_program").val()
      var ssId = $("#sel_ss").val()
      var ssSemester = $("#ssSemester").val()

      var checkboxes_value = [];
      $('.checkitem').each(function() {
        if (this.checked) {
          checkboxes_value.push($(this).val());
        }
      });
      // $.alert("Batch " + batchId + " Prog " + progId + " ssId " + ssId + " Cheked " + checkboxes_value);
      $.post("<?php echo $phpFile; ?>", {
        batchId: batchId,
        progId: progId,
        ssId: ssId,
        ssSemester: ssSemester,
        checkboxes_value: checkboxes_value,
        action: "updateStatus"
      }, function() {}, "text").done(function(data, status) {
        $.alert("Updated")
      }).fail(function() {
        $.alert("Fail");
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

    $(document).on('change', '#sel_batch, #sel_program, #sel_ss', function() {
      studentList();
    });

    $(document).on('click', '#ay, #leet, #deleted, #showSSList, #hostel, #transport, #dayScholar', function() {
      studentList();
    });

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
      if ($('#hostel').is(":checked")) var hostel = 1;
      else var hostel = 0;
      if ($('#transport').is(":checked")) var transport = 1;
      else var transport = 0;
      if ($('#dayScholar').is(":checked")) var dayScholar = 1;
      else var dayScholar = 0;
      // $.alert("leet " + leet + " Batch " + batchId + "Prog" + progId + " SS " + ssId);
      $.post("<?php echo $phpFile; ?>", {
        batchId: batchId,
        progId: progId,
        ssSemester: ssSemester,
        mn_id: ssId,
        leet: leet,
        ay: ay,
        deleted: deleted,
        hostel: hostel,
        transport: transport,
        dayScholar: dayScholar,
        action: "studentList"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        console.log(data);
        var card = '';
        var count = 1;
        $.each(data, function(key, value) {
          $("#totalStudents").html(count);
          var student_lateral = value.student_lateral;
          // if (leet == '1' && leet != student_lateral) var skip = 'Y'
          // else var skip = 'N'
          // if (skip == 'N') {
          card += '<tr>';
          // card += '<td><a href="#" class="fa fa-edit editStudent" data-student="' + value.student_id + '"></a></td>';
          card += '<td>' + count++ + '</td>';
          card += '<td>' + value.user_id + '</td>';
          card += '<td>' + value.student_name + '</td>';
          card += '<td class="fnameField">' + value.student_fname + '</td>';
          card += '<td class="courseField">' + value.program_name + '</td>';
          card += '<td class="rollnoField">' + value.student_rollno + '</td>';

          card += '<td>' + value.student_ay + '</td>';
          if (value.student_lateral == '1') card += '<td>Y</td>';
          else card += '<td>N</td>';

          if (value.student_regular == '1') card += '<td>Y</td>';
          else card += '<td>N</td>';

          if (value.student_scholarship == '1') card += '<td>Y</td>';
          else card += '<td>N</td>';

          var address= value.permanent_address;
          if(address!=null)address=address.replace("#","")

          card += '<td class="mobileField">' + value.student_mobile + '</td>';
          card += '<td class="semField">' + value.student_semester + '</td>';
          card += '<td class="dorField">' + getFormattedDate(value.student_admission, "dmY") + '</td>';
          card += '<td class="dobField">' + getFormattedDate(value.student_dob, "dmY") + '</td>';
          card += '<td class="waField">' + value.student_whatsapp + '</td>';
          card += '<td>' + address + '</td>';
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
          // }
        });
        $("#studentShowList").find("tr:gt(0)").remove();
        $("#studentShowList").append(card);

        var card = '';
        var count = 1;
        $.each(data, function(key, value) {
          var student_lateral = value.student_lateral;
          if (leet == '1' && leet != student_lateral) var skip = 'Y'
          else var skip = 'N'
          if (skip == 'N') {
            card += '<tr>';
            card += '<td>' + count++ + '</td>';
            if (value.ss == "1") card += '<td class="text-center"><input type="checkbox" class="checkitem" checked value="' + value.student_id + '"/></td>';
            else card += '<td class="text-center"><input type="checkbox" class="checkitem" value="' + value.student_id + '"/></td>';
            card += '<td>' + value.student_id + '</td>';
            card += '<td>' + value.user_id + '</td>';
            card += '<td>' + value.student_name + '</td>';
            card += '<td>' + value.student_fname + '</td>';
            card += '<td>' + value.sp_abbri + '</td>';
            card += '<td>' + value.student_ay + '</td>';
            if (value.student_lateral == '1') card += '<td>LEET</td>';
            else card += '<td>--</td>';
            card += '<td>' + value.student_rollno + '</td>';
            card += '<td>' + value.student_mobile + '</td>';
            card += '<td>' + value.remarks + '</td>';
            card += '</tr>';
          }
        });
        $("#studentStatusTable").find("tr:gt(0)").remove();
        $("#studentStatusTable").append(card);

        var card = '';
        var count = 1;
        $.each(data, function(key, value) {
          var student_lateral = value.student_lateral;
          if (leet == '1' && leet != student_lateral) var skip = 'Y'
          else var skip = 'N'
          if (skip == 'N') {
            var qual = value.qualification.length;
            if (qual == 0) {
              card += '<tr>';
              card += '<td>' + count++ + '</td>';
              card += '<td>' + value.student_id + '</td>';
              card += '<td>' + value.user_id + '</td>';
              card += '<td>' + value.student_name + '</td>';
              card += '<td>' + value.student_fname + '</td>';
              card += '<td>' + value.sp_abbri + '</td>';
              card += '<td>--</td>';
              card += '<td>--</td>';
              card += '<td>--</td>';
              card += '<td>--</td>';
              card += '<td>--</td>';
              card += '<td>--</td>';
              card += '<td>--</td>';
              card += '<td>--</td>';
              card += '</tr>';
            } else {
              for (var i = 0; i < qual; i++) {
                card += '<tr>';
                card += '<td>' + count++ + '</td>';
                card += '<td>' + value.student_id + '</td>';
                card += '<td>' + value.user_id + '</td>';
                card += '<td>' + value.student_name + '</td>';
                card += '<td>' + value.student_fname + '</td>';
                card += '<td>' + value.sp_abbri + '</td>';
                card += '<td>' + value.qualification[i].mn_name + '</td>';
                card += '<td>' + value.qualification[i].sq_mo + '</td>';
                card += '<td>' + value.qualification[i].sq_mm + '</td>';
                card += '<td>' + value.qualification[i].sq_percentage + '</td>';
                card += '<td>' + value.qualification[i].sq_cgpa + '</td>';
                card += '<td>' + value.qualification[i].sq_year + '</td>';
                card += '<td>' + value.qualification[i].sq_institute + '</td>';
                card += '<td>' + value.qualification[i].sq_board + '</td>';
                card += '</tr>';
              }
            }
          }
        });
        $("#qualificationTable").find("tr:gt(0)").remove();
        $("#qualificationTable").append(card);

      }).fail(function() {
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