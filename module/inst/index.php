<?php
require('../requireSubModule.php');
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
        <h5 class="pt-3">Institute Settings</h5>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active si" id="list-si-list" data-toggle="list" href="#list-si" role="tab" aria-controls="si"> Setup Institute </a>
          <a class="list-group-item list-group-item-action mis" id="list-mis-list" data-toggle="list" href="#list-mis" role="tab" aria-controls="mis"> Manage School </a>
          <a class="list-group-item list-group-item-action mid" id="list-mid-list" data-toggle="list" href="#list-mid" role="tab" aria-controls="mid"> Manage Department </a>
          <a class="list-group-item list-group-item-action mip" id="list-mip-list" data-toggle="list" href="#list-mip" role="tab" aria-controls="mip"> Manage Programme </a>
          <a class="list-group-item list-group-item-action is" id="list-is-list" data-toggle="list" href="#list-is" role="tab" aria-controls="is"> Institute Structure </a>
        </div>
      </div>

      <div class="col-10 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="list-si" role="tabpanel" aria-labelledby="list-si-list">
            <div class="row">
              <div class="col-4">
                <div class="row">
                  <div class="col">
                    <h3><a class="fa fa-plus-circle p-0 addInst"></a> University/Group</h3>
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <div id="instShowList"></div>
                  </div>
                </div>
              </div>
              <div class="col-8">
                <div class="row">
                  <?php
                  $sql_school = "select * from school where school_status='0'";
                  $result = $conn->query($sql_school);
                  $school = mysqli_num_rows($result);
                  $sql_dept = "select * from department where dept_status='0'";
                  $result = $conn->query($sql_dept);
                  $dept = mysqli_num_rows($result);
                  $sql_prog = "select * from program where program_status='0'";
                  $result = $conn->query($sql_prog);
                  $program = mysqli_num_rows($result);
                  ?>
                  <div class="col-3 bg-three text-white p-1 ml-1 ">Schools</div>
                  <div class="col-1 bg-one text-white p-1 text-center">
                    <h4><?php echo $school; ?></h4>
                  </div>
                  <div class="col-3 bg-three text-white p-1 ml-1">Departments</div>
                  <div class="col-1 bg-one text-white p-1 text-center">
                    <h4><?php echo $dept; ?></h4>
                  </div>
                  <div class="col-2 bg-three text-white p-1 ml-1">Programs</div>
                  <div class="col-1 bg-one text-white p-1 text-center">
                    <h4><?php echo $program; ?></h4>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12 mx-auto mt-1 p-0">
                    <div id="accordionInfoUni" class="accordion shadow">
                      <div class="card">
                        <div id="headingOne" class="card-header bg-white shadow-sm border-0">
                          <h6 class="mb-0 font-weight-semibold"><a href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="d-block position-relative text-dark text-uppercase collapsible-link py-2">Basic Information</a></h6>
                        </div>
                        <div id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionInfoUni" class="collapse collapseAccordian">
                          <div class="card-body">
                            <form class="text w-100 p-0" id="basicInfoForm">
                              <input type="hidden" id="instIdHidden" name="instIdHidden">
                              <p>Name and Address of the University</p>
                              <div class="row">
                                <div class="col-12">
                                  <div class="form-group">
                                    <p class="text m-0"> Instituton Name</p>
                                    <input type="text" id="instName" class="form-control instForm" data-tag="inst_name">
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-12">
                                  <div class="form-group">
                                    <p class="text m-0">Address</p>
                                    <textarea id="instAddress" class="md-textarea form-control instForm" data-tag="inst_address" rows="3"></textarea>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group">
                                    <p class="text m-0">City</p>
                                    <input type="text" id="instCity" class="form-control instForm" data-tag="inst_city">
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <p class="text m-0">Pincode</p>
                                    <input type="text" id="instPIN" class="form-control instForm" data-tag="inst_pincode">
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group">
                                    <p class="text m-0">State</p>
                                    <input type="text" id="instState" class="form-control instForm" data-tag="inst_state">
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <p class="text m-0">Website</p>
                                    <input type="text" id="instWebsite" class="form-control instForm" data-tag="inst_url">
                                  </div>
                                </div>
                              </div>
                              <p>Nature of University</p>
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group">
                                    <p class="text m-0">Institution Status</p>
                                    <input type="text" id="instStatus" class="form-control instForm" data-tag="inst_status">
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <p class="text m-0">Type of University</p>
                                    <input type="text" id="instType" class="form-control instForm" data-tag="inst_type">
                                  </div>
                                </div>
                              </div>
                              <p class="h4">Establishment Details</p>
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group">
                                    <p class="text m-0">Establishment Date of the University</p>
                                    <input type="date" id="instEstDateUni" class="form-control instForm" data-tag="inst_est_date_uni">
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <div class="md-form md-outline m-0">
                                      <input type="date" id="instEstDate" class="form-control instForm" data-tag="inst_est_date">
                                      <label for="instEstDate">Establishment Date</label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-12">
                                  <div class="form-group">
                                    <div class="md-form md-outline m-0">
                                      <input type="text" id="instStatusEst" class="form-control instForm" data-tag="inst_status_est">
                                      <label for="instStatusEst">Status Prior to Establishment</label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <p class="m-0">Recognition Details</p>
                              <p>Date of Recognition as a University by UGC or Any Other National Agency</p>
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group">
                                    <div class="md-form md-outline m-0">
                                      <input type="date" id="underSection2f" class="form-control instForm" data-tag="inst_under2f">
                                      <label for="underSection2f">Under Section 2f of UGC</label>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <div class="md-form md-outline m-0">
                                      <input type="date" id="underSection12b" class="form-control instForm" data-tag="inst_under12b">
                                      <label for="underSection12b">Under Section 12B of UGC</label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <p>Is the University Recognised as a 'University with Potential for Excellence Yes No (UPE)' by the UGC?</p>
                              <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input inst_yesugcInst" id="inst_yesugcInst" name="defaultExampleRadios">
                                <label class="custom-control-label" for="inst_yesugcInst">Yes</label>
                              </div>

                              <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input inst_nougc" id="inst_nougc" name="defaultExampleRadios" checked>
                                <label class="custom-control-label" for="inst_nougc">No</label>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <div class="card">
                        <div id="headingTwo" class="card-header bg-white shadow-sm border-0">
                          <h6 class="mb-0 font-weight-semibold"><a href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="d-block position-relative collapsed text-dark text-uppercase collapsible-link py-2">Geographical Information</a></h6>
                        </div>
                        <div id="collapseTwo" aria-labelledby="headingTwo" data-parent="#accordionInfoUni" class="collapse collapseAccordian">
                          <div class="card-body">
                            <form class="text w-100 p-0" id="geoInfoForm">
                              <p>Location, Area and Activity of Campus</p>
                              <div class="row">
                                <div class="col-12">
                                  <div class="form-group">
                                    <div class="md-form md-outline m-0">
                                      <textarea id="instAddressCampus" class="md-textarea form-control instForm" data-tag="inst_address_campus" rows="3"></textarea>
                                      <label for="instAddressCampus">Address</label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-4">
                                  <div class="form-group">
                                    <div class="md-form md-outline m-0">
                                      <input type="text" id="campusType" class="form-control instForm" data-tag="inst_campus_type">
                                      <label for="campusType">Campus Type</label>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <div class="md-form md-outline m-0">
                                      <input type="text" id="campusArea" class="form-control instForm" data-tag="inst_campus_area">
                                      <label for="campusArea">Campus Area in acres</label>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="form-group">
                                    <div class="md-form md-outline m-0">
                                      <input type="text" id="campusBuiltupArea" class="form-control instForm" data-tag="inst_campus_builtup_area">
                                      <label for="campusBuiltupArea">BuiltUp Area in sq.mts.</label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-3">
                                  <div class="form-group">
                                    <div class="md-form md-outline m-0">
                                      <input type="text" id="campusProgrammes" class="form-control instForm" data-tag="inst_campus_programmes">
                                      <label for="campusProgrammes">Programmes Offered</label>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-3">
                                  <div class="form-group">
                                    <div class="md-form md-outline m-0">
                                      <input type="date" id="campusDate" class="form-control instForm" data-tag="inst_campus_date">
                                      <label for="campusDate">Date of Establishment</label>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <div class="md-form md-outline m-0">
                                      <input type="date" id="dateUGC" class="form-control instForm" data-tag="inst_dateUGC">
                                      <label for="dateUGC">Date of Recognition by UGC/MHRD</label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <p>Location</p>
                              <div class="row">
                                <div class="col-2">
                                  <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="urban" name="urban">
                                    <label class="custom-control-label" for="defaultUnchecked">Urban</label>
                                  </div>
                                </div>
                                <div class="col-2">
                                  <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="rural" name="rural">
                                    <label class="custom-control-label" for="defaultUnchecked">Rural</label>
                                  </div>
                                </div>
                                <div class="col-2">
                                  <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="tribal" name="tribal">
                                    <label class="custom-control-label" for="defaultUnchecked">Tribal</label>
                                  </div>
                                </div>
                                <div class="col-2">
                                  <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="hill" name="hill">
                                    <label class="custom-control-label" for="defaultUnchecked">Hill</label>
                                  </div>
                                </div>
                                <div class="col-4">
                                  <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="semiUrban" name="semiUrbanSchoo" checked>
                                    <label class="custom-control-label" for="defaultChecked">Semi Urban</label>
                                  </div>
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
          <div class="tab-pane fade" id="list-mis" role="tabpanel" aria-labelledby="list-mis-list">
            <div class="row">
              <div class="col-4">
                <h3><a class="fa fa-plus-circle p-0 addSchool"></a> School/Intitution</h3>
                <div class="mt-1 mb-1">
                  <p id="schoolShowList"></p>
                </div>
              </div>
              <div class="col-8">
                <h3>School/Intitution Details</h3>
                <div class="row">
                  <div class="col-lg-12 mx-auto">
                    <div id="accordionInfoSchool" class="accordion shadow">
                      <div class="card">
                        <div id="headingOne" class="card-header bg-white shadow-sm border-0">
                          <h6 class="mb-0 font-weight-semibold"><a href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="d-block position-relative text-dark text-uppercase collapsible-link py-2">Basic Information</a></h6>
                        </div>
                        <div id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionInfoSchool" class="collapse collapseAccordian">
                          <div class="card-body">
                            <form class="text w-100 p-0" id="basicSchoolInfoForm">
                              <!-- <input type="hidden" id="schoolIdHidden" name="schoolIdHidden"> -->
                              <p>Name and Address of the College</p>
                              <div class="row">
                                <div class="col-12">
                                  <div class="form-group">
                                    <div class="md-form m-0">
                                      <p class="text-muted m-0"> School/College Name</p>
                                      <input type="text" id="schoolName" class="form-control schoolForm" data-tag="school_name">
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-12">
                                  <div class="form-group">
                                    <div class="md-form md-outline m-0">
                                      <p class="text-muted m-0">Address</p>
                                      <textarea id="schoolAddress" class="md-textarea form-control schoolForm" data-tag="school_address" rows="3"></textarea>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group">
                                    <div class="md-form md-outline m-0">
                                      <p class="text-muted m-0">City</p>
                                      <input type="text" id="schoolCity" class="form-control schoolForm" data-tag="school_city">
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <div class="md-form md-outline m-0">
                                      <p class="text-muted m-0">Pin Code</p>
                                      <input type="text" id="schoolPIN" class="form-control schoolForm" data-tag="school_pincode">
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-6">
                                  <div class="form-group">
                                    <div class="md-form md-outline m-0">
                                      <p class="text-muted m-0">State</p>
                                      <input type="text" id="schoolState" class="form-control schoolForm" data-tag="school_state">
                                    </div>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                    <div class="md-form md-outline m-0">
                                      <p class="text-muted m-0">Website</p>
                                      <input type="text" id="schoolWebsite" class="form-control schoolForm" data-tag="school_url">
                                    </div>
                                  </div>
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
          <div class="tab-pane fade " id="list-mid" role="tabpanel" aria-labelledby="list-mid-list">
            <div class="row">
              <div class="col-6">
                <div class="mt-1 mb-1">
                  <h3><a class="fa fa-plus-circle p-0 addDept"></a> Department</h3>
                  <div class="mt-1 mb-1">
                    <p id="deptShowList"></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade " id="list-mip" role="tabpanel" aria-labelledby="list-mip-list">
            <div class="row">
              <div class="col-sm-8">
                <div class="mt-1 mb-1">
                  <h3>
                    <a class="fa fa-plus-circle p-0 addProgram"></a>
                    <a class="fa fa-arrow-circle-up p-0 uploadProgram"></a>
                    Programmes
                  </h3>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-8">
                <p id="programShowList"></p>
              </div>
            </div>
          </div>
          <div class="tab-pane fade " id="list-is" role="tabpanel" aria-labelledby="list-is-list">
            <div class="row">
              <div class="col-6">
                <div class="card border-info mb-3">
                  <div class="card-header">
                    Attach Department to School
                  </div>
                  <div class="card-body text-primary">
                    <form class="form-horizontal" id="schoolDeptForm">
                      <div class="row">
                        <div class="col-sm-6">
                          <?php
                          $sql_school = "select * from school where school_status='0'";
                          $result = $conn->query($sql_school);
                          if ($result) {
                            echo '<select class="form-control form-control-sm attachSchoolForm" name="sel_school" id="sel_school" data-tag="school_id" required>';
                            echo '<option selected disabled>Select School</option>';
                            while ($rows = $result->fetch_assoc()) {
                              $select_id = $rows['school_id'];
                              $select_name = $rows['school_name'];
                              echo '<option value="' . $select_id . '">' . $select_name . '</option>';
                            }
                            echo '</select>';
                          } else echo $conn->error;
                          if ($result->num_rows == 0) echo 'No Data Found';
                          ?>
                        </div>
                        <div class="col-sm-6">
                          <div class="input-group">
                            <?php
                            $sql_department = "select * from department where dept_status='0'";
                            $result = $conn->query($sql_department);
                            if ($result) {
                              echo '<select class="form-control form-control-sm" name="sel_dept" id="sel_dept" required>';
                              echo '<option selected disabled>Select Department</option>';
                              while ($rows = $result->fetch_assoc()) {
                                $select_id = $rows['dept_id'];
                                $select_name = $rows['dept_name'];
                                echo '<option value="' . $select_id . '">' . $select_name . '</option>';
                              }
                              echo '</select>';
                            } else echo $conn->error;
                            if ($result->num_rows == 0) echo 'No Data Found';
                            ?>
                            <div class="input-group-append">
                              <!-- <input type="hidden" id="action" name="action"> -->
                              <input type="hidden" id="schoolIdHidden" name="schoolIdHidden">
                              <input type="hidden" id="deptIdHidden" name="deptIdHidden">
                              <button class="btn btn-primary btn-sm m-0" type="submit">Submit</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="card border-info mb-3">
                  <div class="card-header">
                    Attach Program to Department
                  </div>
                  <div class="card-body text-primary">
                    <form class="form-horizontal" id="deptProgramForm">
                      <div class="row">
                        <div class="col-sm-6">
                          <?php
                          $sql_department = "select * from department where dept_status='0'";
                          $result = $conn->query($sql_department);
                          if ($result) {
                            echo '<select class="form-control form-control-sm" name="sel_deptProgram" id="sel_deptProgram" required>';
                            echo '<option selected disabled>Select Department</option>';
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
                        <div class="col-sm-6">
                          <div class="input-group">
                            <?php
                            $sql_program = "select * from program where program_status='0' order by sp_name";
                            $result = $conn->query($sql_program);
                            if ($result) {
                              echo '<select class="form-control form-control-sm" name="sel_program" id="sel_program" data-tag="program_id" required>';
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
                              <input type="hidden" id="actionDeptProgram" name="actionDeptProgram">
                              <input type="hidden" id="programIdHidden" name="programIdHidden">
                              <input type="hidden" id="deptIdHidden2" name="deptIdHidden2">
                              <button class="btn btn-primary btn-sm m-0" type="submit">Submit</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <p id="schoolDeptShowList"></p>
              </div>
              <div class="col-sm-6">
                <p id="deptProgramShowList"></p>
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
  $(document).ready(function() {
    $(".topBarTitle").text("Institution");
    instList();
    $('.selectPanel').hide();
    $('#accordionInfoUni').hide();
    $('#accordionInfoSchool').hide();


    $(document).on('click', '.mis', function() {
      schoolList();
      $('.selectPanel').hide();

    });
    $(document).on('click', '.si', function() {
      $('.selectPanel').hide();
    });
    $(document).on('click', '.mid', function() {
      $("#selectPanelTitle").text("Select School");
      deptList();
      $('.selectPanel').show();
      $('.selectSchool').show();
      $('.selectDept').hide();
      $('.teaching').show();
      $('.nonTeaching').show();

    });
    $(document).on('click', '.mip', function() {
      $("#selectPanelTitle").text("Select Department");
      programList();
      $('.selectPanel').show();
      $('.selectSchool').hide();
      $('.teaching').hide();
      $('.nonTeaching').hide();
      $('.selectDept').show();
    });
    $(document).on('click', '.is', function() {
      deptSchoolList();
      deptProgramList();
    });

    $(document).on('change', '#school_name', function() {
      $.alert("Changes School ");
      deptList();
    });
    $(document).on('change', '#dept_type', function() {
      //x=$('form input[type=radio]:checked').val();
      //$.alert("Changes " + x);
      deptList();
    });

    $(document).on('click', '.deleteSchoolDept', function() {
      var dept_id = $(this).attr("data-dept");
      var school_id = $(this).attr("data-school");
      // $.alert("Disabled "+school_id+dept_id);
      $.post("instSql.php", {
        deptId: dept_id,
        schoolId: school_id,
        action: "removeSchoolDept"
      }, function(data, status) {
        // $.alert("Data" + data)
        deptSchoolList();
      }, "text").fail(function() {
        $.alert("Error");
      })
    });

    $(document).on('click', '.deleteDeptProgram', function() {
      var dept_id = $(this).attr("data-dept");
      var prog_id = $(this).attr("data-program");
      $.post("instSql.php", {
        deptId: dept_id,
        progId: prog_id,
        action: "removeDeptProgram"
      }, function(data, status) {
        // $.alert("Data" + data)
        deptProgramList();
      }, "text").fail(function() {
        $.alert("Error");
      })
    });

    $(document).on('submit', '#schoolDeptForm', function() {
      event.preventDefault(this);
      var deptId = $("#sel_dept").val()
      var schoolId = $("#sel_school").val()
      // $.alert("Form Submitted " + formData)
      $.post("instSql.php", {
        deptId: deptId,
        schoolId: schoolId,
        action: "attachSchoolDept"
      }, function() {}, "text").done(function(data, success) {
        //$.alert(data)
      })
      deptSchoolList();
    });

    $(document).on('submit', '#deptProgramForm', function() {
      event.preventDefault(this);
      var deptId = $("#sel_deptProgram").val()
      var programId = $("#sel_program").val()
      $('#programIdHidden').val(programId)
      $('#deptIdHidden2').val(deptId)
      $("#actionDeptProgram").val("attachDeptProgram")
      var formData = $(this).serialize();
      // $.alert("Form Submitted " + formData)
      $.post("instSql.php", formData, function() {}, "text").done(function(data, success) {
        // $.alert(data)
      })
      deptProgramList()
    });

    $(document).on('submit', '#modalForm', function(event) {
      event.preventDefault(this);
      var x = $("#inst_name").val();
      var sn = $("#school_nameModal").val();
      var dn = $("#dept_name").val();
      var pn = $("#program_name").val();
      var seldn = $("#sel_dept").val();
      var action = $("#action").val();
      if (x === "" && (action == "addInst" || action == "updateInst")) $.alert("Institute Name cannot be blank!!");
      else if (sn === "" && action == "addSchool") $.alert("School Name cannot be blank!!" + sn);
      else if (dn === "" && action == "addDept") $.alert("Department Name cannot be blank!!");
      else if (action == "addProgram" && (pn === "" || seldn === "")) $.alert("Program Name/Department cannot be blank!! " + dn);
      else {
        var formData = $(this).serialize();
        $('#firstModal').modal('hide');
        $.alert(x + " Pressed" + action);
        $.post("instSql.php", formData, () => {}, "text").done(function(data) {
          $.alert("List " + data);
          if (action == "addInst" || action == "updateInst") instList();
          else if (action == "addSchool" || action == "updateSchool") schoolList();
          else if (action == "addDept" || action == "updateDept") deptList();
          else if (action == "addProgram" || action == "updateProgram") programList();
          $('#modalForm')[0].reset();
        }, "text").fail(function() {
          $.alert("fail in place of error");
        })
      }
    });

    $(document).on('click', '.inst_idD', function() {
      $.alert(" Disabled ");
    });

    $(document).on('click', '.inst_idE', function() {
      $('.deptForm').hide();
      $('.schoolForm').hide();
      $('.programForm').hide();

      var id = $(this).attr('id');
      //$.alert("Id " + id);

      $.post("instSql.php", {
        instId: id,
        action: "fetchInst"
      }, () => {}, "json").done(function(data) {
        $.alert("List " + data.inst_name);
        console.log("Error ", data);
        $('#modal_title').text("Update Institution [" + id + "]");
        $('#inst_name').val(data.inst_name);
        $('#inst_abbri').val(data.inst_abbri);
        $('#inst_url').val(data.inst_url);
        $('#inst_doi').val(data.inst_doi);

        $('#action').val("updateInst");
        $('#modalId').val(id);

        $('#firstModal').modal('show');
        $('.instForm').show();

        //$("#ccform").html(mydata);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.addInst', function() {
      $('.deptForm').hide();
      $('.schoolForm').hide();
      $('.programForm').hide();
      //$.alert("Add Inst");
      $('#modal_title').text("Add Institute");
      $('#action').val("addInst");
      $('#firstModal').modal('show');
      $('.instForm').show();
    });

    $(document).on('blur', '.instForm', function() {
      var instId = $("#instIdHidden").val()
      var tag = $(this).attr("data-tag")
      var value = $(this).val()
      // $.alert("Changes " + tag + " Value " + value + " Inst " + instId);
      $.post("instSql.php", {
        id_name: "inst_id",
        id: instId,
        tag: tag,
        value: value,
        action: "updateInst"
      }, function(data) {
        // $.alert("List " + data);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.basicInfoUni', function() {
      $('#accordionInfoUni').show();
      var id = $(this).attr("data-inst");
      $('#instIdHidden').val(id);
      $.post("instSql.php", {
        instId: id,
        action: "fetchInst"
      }, () => {}, "json").done(function(data) {
        $('#instName').val(data.inst_name);
        $('#instWebsite').val(data.inst_url);
        $('#instAddress').val(data.inst_address);
        $('#inst_doi').val(data.inst_doi);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.school_idD', function() {
      $.alert(" Disabled ");
    });

    $(document).on('click', '.school_idE', function() {
      $('.deptForm').hide();
      $('.instForm').hide();
      $('.programForm').hide();

      var id = $(this).attr('id');
      //$.alert("Id " + id);

      $.post("instSql.php", {
        schoolId: id,
        action: "fetchSchool"
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.inst_name);

        $('#modal_title').text("Update School [" + id + data.school_name + "]");
        $('#school_nameModal').val(data.school_name);
        $('#school_abbri').val(data.school_abbri);
        $('#school_url').val(data.school_url);
        $('#school_doi').val(data.school_doi);

        $('#action').val("updateSchool");
        $('#modalId').val(id);

        $('#firstModal').modal('show');
        $('.schoolForm').show();

        //$("#ccform").html(mydata);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.addSchool', function() {

      $('.deptForm').hide();
      $('.instForm').hide();
      $('.programForm').hide();
      //$.alert("Add School");
      $('#modal_title').text("Add School");
      $('#action').val("addSchool");
      $('#firstModal').modal('show');
      $('.schoolForm').show();
    });

    $(document).on('click', '.basicInfoCollege', function() {
      $('#accordionInfoSchool').show();
      var id = $(this).attr("data-school");
      $('#schoolIdHidden').val(id);
      $.post("instSql.php", {
        schoolId: id,
        action: "fetchSchool"
      }, () => {}, "json").done(function(data) {
        $('#schoolName').val(data.school_name);
        $('#schoolWebsite').val(data.school_url);
        $('#schoolAddress').val(data.school_address);
        $('#schoolEstDate').val(data.school_doi);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.dept_idD', function() {
      $.alert(" Disabled ");
    });

    $(document).on('click', '.editDept', function() {
      $('.schoolForm').hide();
      $('.instForm').hide();
      $('.programForm').hide();

      var id = $(this).attr("data-dept");
      //$.alert("Id " + id);

      $.post("instSql.php", {
        deptId: id,
        action: "fetchDept"
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.inst_name);

        $('#modal_title').text("Update Department [" + id + "]");
        $('#dept_name').val(data.dept_name);
        $('#dept_abbri').val(data.dept_abbri);
        $('#dept_type').val(data.dept_type);
        $('#dept_doi').val(data.dept_doi);
        $('#school_id').val(data.school_id);

        $('#action').val("updateDept");
        $('#modalId').val(id);

        $('#firstModal').modal('show');
        $('.deptForm').show();

        //$("#ccform").html(mydata);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.addDept', function() {
      var x = $("#school_name").val();
      var y = $("#dept_type").val();
      if (x === "") $.alert("You have NOT Selected a School for this Department !!");
      else {
        $('.schoolForm').hide();
        $('.instForm').hide();
        $('.programForm').hide();
        $.alert("Add Department");
        $('#modal_title').text("Add Department " + x);
        $('#action').val("addDept");
        $('#schoolIdModal').val(x);
        $('#deptTypeModal').val(y);
        $('#firstModal').modal('show');
        $('.deptForm').show();
      }
    });

    $(document).on('click', '.program_idE', function() {
      $('.schoolForm').hide();
      $('.instForm').hide();
      $('.deptForm').hide();

      var id = $(this).attr("data-id");
      $.alert("Id " + id);

      $.post("instSql.php", {
        programId: id,
        action: "fetchProgram"
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.inst_name);

        $('#modal_title').text("Update Program [" + id + "]");
        $('#program_name').val(data.program_name);
        $('#program_abbri').val(data.program_abbri);
        $('#program_duration').val(data.program_duration);
        $('#program_semester').val(data.program_semester);
        $('#program_year').val(data.program_year);
        $('#program_seat').val(data.program_seat);
        $('#program_code').val(data.program_mode);
        $('#sp_name').val(data.sp_name);
        $('#sp_abbri').val(data.sp_abbri);
        $('#deptIdModal').val(data.dept_id);

        $('#action').val("updateProgram");
        $('#modalId').val(id);

        $('#firstModal').modal('show');
        $('.programForm').show();

        //$("#ccform").html(mydata);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.addProgram', function() {
      x = $('#sel_dept').val();
      if (x === "") $.alert("Please Select a Department to Proceed!!");
      else {
        $('.schoolForm').hide();
        $('.instForm').hide();
        $('.deptForm').hide();
        //$.alert("Add Program");
        $('#modal_title').text("Add Program");
        $('#deptIdModal').val(x);
        $('#action').val("addProgram");
        $('#firstModal').modal('show');
        $('.programForm').show();
      }
    });


    $(document).on('click', '.uploadProgram', function() {
      var y = $("#sel_batch").val();
      $("#batch_idUpload").val(y);
      $('#actionUpload').val('uploadProgram')
      $('#button_action').show().val('Update Program');
      $('#formModal').modal('show');
      $('#modal_uploadTitle').text('Upload Program');
    });
    $(document).on('submit', '#upload_csv', function(event) {
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
          console.log(data);
        }
      })
    });

    function instList() {
      //$.alert("In List Function");
      $.post("instSql.php", {
        action: "instList"
      }, function(mydata, mystatus) {
        $("#instShowList").show();
        //$.alert("List " + mydata);
        $("#instShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function schoolList() {
      //$.alert("In List Function");
      $.post("instSql.php", {
        action: "schoolList"
      }, function(mydata, mystatus) {
        $("#schoolShowList").show();
        //$.alert("List " + mydata);
        $("#schoolShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function deptList() {
      var x = $("#school_name").val();
      var y = $('form input[type=radio]:checked').val();
      //$.alert("In List Function"+ x + y);

      $.post("instSql.php", {
        action: "deptList",
        schoolId: x,
        deptType: y
      }, function(mydata, mystatus) {
        $("#deptShowList").show();
        //$.alert("List " + mydata);
        $("#deptShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function programList() {
      //$.alert("In List Function");
      var x = $("#dept_name").val();

      $.post("instSql.php", {
        action: "programList",
        deptId: x,
      }, function(mydata, mystatus) {
        $("#programShowList").show();
        //$.alert("List " + mydata);
        $("#programShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function deptSchoolList() {
      //$.alert("In List Function");
      var x = $("#sel_dept").val();
      var y = $("#sel_school").val();
      $.post("instSql.php", {
        action: "deptSchoolList",
        deptId: x,
        schoolId: y
      }, function(mydata, mystatus) {
        $("#schoolDeptShowList").show();
        //$.alert("List " + mydata);
        $("#schoolDeptShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function deptProgramList() {
      //$.alert("In List Function");
      var x = $("#sel_deptProgram").val();
      var y = $("#sel_program").val();
      $.post("instSql.php", {
        action: "deptProgramList",
        deptId: x,
        programId: y
      }, function(mydata, mystatus) {
        $("#deptProgramShowList").show();
        //$.alert("List " + mydata);
        $("#deptProgramShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function totalSchools() {
      //$.alert("In List Function");
      var x = $("#sel_deptProgram").val();
      var y = $("#sel_program").val();
      $.post("instSql.php", {
        action: "deptProgramList",
        deptId: x,
        programId: y
      }, function(mydata, mystatus) {
        $("#deptProgramShowList").show();
        //$.alert("List " + mydata);
        $("#deptProgramShowList").html(mydata);
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
</script>
<!-- Modal Section-->
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
          <div class="instForm">
            <div class="row">
              <div class="col-7">
                <div class="form-group">
                  Institute Name
                  <input type="text" class="form-control form-control-sm" id="inst_name" name="inst_name" placeholder="Institute Name">
                </div>
              </div>
              <div class="col-5">
                <div class="form-group">
                  Institute Abbri
                  <input type="text" class="form-control form-control-sm" id="inst_abbri" name="inst_abbri" placeholder="Institute Abbri">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-7">
                <div class="form-group">
                  Institute URL
                  <input type="url" class="form-control form-control-sm" id="inst_url" name="inst_url" placeholder="Institute URL">
                </div>
              </div>
              <div class="col-5">
                <div class="form-group">
                  Date of Inception
                  <input type="date" class="form-control form-control-sm" id="inst_doi" name="inst_doi" value="<?php echo date("Y-m-d", time()); ?>">
                </div>
              </div>
            </div>
            <div class="form-group">
              <i>Top level in the campus. It could be name of the University, Campus, Group of Institution, Institution.</i>
            </div>
          </div>

          <div class="schoolForm">
            <div class="row">
              <div class="col-7">
                <div class="form-group">
                  School Name
                  <input type="text" class="form-control form-control-sm" id="school_nameModal" name="school_name" placeholder="School Name">
                </div>
              </div>
              <div class="col-5">
                <div class="form-group">
                  School Abbri
                  <input type="text" class="form-control form-control-sm" id="school_abbri" name="school_abbri" placeholder="School Abbri">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-7">
                <div class="form-group">
                  School URL
                  <input type="url" class="form-control form-control-sm" id="school_url" name="school_url" placeholder="School URL">
                </div>
              </div>
              <div class="col-5">
                <div class="form-group">
                  Date of Inception
                  <input type="date" class="form-control form-control-sm" id="school_doi" name="school_doi" value="<?php echo date("Y-m-d", time()); ?>">
                </div>
              </div>
            </div>

            <div class="form-group">
              <i>School is the academic unit of top level. It has to attached to Top Level.</i>
            </div>
          </div>

          <div class="deptForm">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  Department Name
                  <input type="text" class="form-control form-control-sm" id="dept_name" name="dept_name" placeholder="Department Name">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Department Abbri
                  <input type="text" class="form-control form-control-sm" id="dept_abbri" name="dept_abbri" placeholder="Department Abbri">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  Date of Inception
                  <input type="date" class="form-control form-control-sm" id="dept_doi" name="dept_doi" value="<?php echo date("Y-m-d", time()); ?>">
                </div>
              </div>
            </div>
            <hr>
            <div class="form-group">
              <i>Department is essentially attached to Top Level of the Campus. It may or may not be associated with School/College</i>
            </div>
          </div>

          <div class="programForm">
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Program Name
                  <input type="text" class="form-control form-control-sm" id="program_name" name="program_name" placeholder="Program Name">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Prg Abbri
                  <input type="text" class="form-control form-control-sm" id="program_abbri" name="program_abbri" placeholder="Program Abbri">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Prg Code
                  <input type="text" class="form-control form-control-sm" id="program_code" name="program_code" placeholder="Program Code">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Specialization Name
                  <input type="text" class="form-control form-control-sm" id="sp_name" name="sp_name" placeholder="Specialization Name">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Sp Abbri
                  <input type="text" class="form-control form-control-sm" id="sp_abbri" name="sp_abbri" placeholder="Sp Abbri">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Sp Code
                  <input type="text" class="form-control form-control-sm" id="sp_code" name="sp_code" placeholder="Sp code">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <div class="form-group">
                  Duration
                  <input type="number" class="form-control form-control-sm" id="program_duration" name="program_duration" placeholder="Program Duration">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Semester
                  <input type="number" class="form-control form-control-sm" id="program_semester" name="program_semester" placeholder="Semester">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Start Year
                  <input type="number" class="form-control form-control-sm" id="program_start" name="program_start">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Seats
                  <input type="number" class="form-control form-control-sm" id="program_seat" name="program_seat" placeholder="Seats">
                </div>
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="modalId" name="modalId">
          <input type="hidden" id="action" name="action">
          <input type="hidden" id="schoolIdModal" name="schoolIdModal">
          <input type="hidden" id="deptTypeModal" name="deptTypeModal">
          <input type="hidden" id="deptIdModal" name="deptIdModal">
          <button type="submit" class="btn btn-secondary" id="submitModalForm">Submit</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
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
              <div class="col-sm-10">
                <input type="file" name="csv_upload" />
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->
        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" name="action" id="actionUpload">
          <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" />
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div>

</html>