<?php
require('../requireSubModule.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>OBCon | AcadPlus | ClassConnect | EISOFTECH </title>
  <?php require("../css.php"); ?>
</head>

<body>
  <?php require("../topBar.php"); ?>
  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-1 p-0 m-0 pl-1 full-height">
        <div class="mt-3 largeText">Settings</div>
        <div class="list-group list-group-mine" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active inst" id="list-inst-list" data-toggle="list" href="#list-inst" role="tab" aria-controls="inst"> Group </a>
          <a class="list-group-item list-group-item-action sch" id="list-sch-list" data-toggle="list" href="#list-sch" role="tab" aria-controls="sch"> Institution </a>
          <a class="list-group-item list-group-item-action mip" id="list-mip-list" data-toggle="list" href="#list-mip" role="tab" aria-controls="mip"> Programme </a>
          <a class="list-group-item list-group-item-action dept" id="list-dept-list" data-toggle="list" href="#list-dept" role="tab" aria-controls="dept"> Department </a>
          <a class="list-group-item list-group-item-action is" id="list-is-list" data-toggle="list" href="#list-is" role="tab" aria-controls="is"> Structure </a>
          <a class="list-group-item list-group-item-action com" data-toggle="list" href="#com" role="tab" aria-controls="com"> Committee </a>
          <a class="list-group-item list-group-item-action act" data-toggle="list" href="#act" role="tab" aria-controls="act"> Activities </a>
        </div>
      </div>
      <div class="col-11 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane show active" id="list-inst" role="tabpanel" aria-labelledby="list-inst-list">
            <div class="row">
              <div class="col-sm-9">
                <h3>
                  <a class="fa fa-plus-circle p-0 addInst"></a>
                </h3>
                <div class="container card mt-2 mb-2 myCard">
                  <div class="card-title-xs">
                    <a href="#" class="fa fa-pencil-alt editInst" id="instId"></a> University/Group
                  </div>
                  <div class="row mt-1">
                    <div class="col-2">
                      <p class="instLogo"></p>
                    </div>
                    <div class="col-2">
                    </div>
                    <div class="col-8">
                      <div class="row mt-1">
                        <div class="col-12">
                          <p class="xlText" id="instName"></p>
                          <p class="largeText" id="instURL"></p>
                          <p class="largeText" id="instAddress"></p>
                          <p class="largeText" id="instCity"></p>
                          <p>
                            <span class="largeText" id="instState""></span>
                            (<span class=" largeText" id="instPincode"></span>)
                          </p>
                          <p class="largeText" id="instAffiliation"></p>
                          <p class="largeText" id="instApproval"></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-sch" role="tabpanel" aria-labelledby="list-sch-list">
            <div class="row">
              <div class="col-sm-9">
                <h3>
                  <a class="fa fa-plus-circle p-0 addSchool"></a>
                </h3>
                <div class="container card mt-2 mb-2 myCard">
                  <div class="card-title-xs">School/Institution List</div>
                  <div class="row mt-1">
                    <div class="col">
                      <table class="table table-striped list-table-xs" id="schoolTable">
                        <tr class="align-center">
                          <th><i class="fas fa-edit"></i></th>
                          <th>#</th>
                          <th>Name</th>
                          <th>Abbri</th>
                          <th>Code</th>
                          <th><i class="fas fa-trash"></i></th>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-mip" role="tabpanel" aria-labelledby="list-mip-list">
            <div class="row">
              <div class="col-sm-8">
                <h3><a class="fa fa-plus-circle p-0 addProgram"></a></h3>
              </div>
              <div class="col-sm-2">
                <span><?php require("../selectBatch.php"); ?></span>
                <input type="hidden" id="prog_idHidden" name="program_id">
              </div>
              <div class="col-sm-1">
                <a class="fa fa-refresh p-0 largeText refreshDocList text-primary" title="Reload Document List"></a>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-8 pr-0">
                <div class="container card mt-2 mb-2 myCard">
                  <div class="card-title-xs">Program List</div>
                  <div class="row mt-1">
                    <div class="col">
                      <table class="table table-striped list-table-xs" id="programTable">
                        <tr class="align-center">
                          <th><i class="fas fa-edit"></i></th>
                          <th>#</th>
                          <th>Code</th>
                          <th>Program Name[Abbri]</th>
                          <th> Sp Name[Abbri]</th>
                          <th>Yrs[S/T]</th>
                          <th> Start </th>
                          <th> Sncd </th>
                          <th> Admtd </th>
                          <th> PO </th>
                          <th><i class="fas fa-list"></i></th>
                          <th><i class="fas fa-trash"></i></th>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 pl-1">
                <div class="container card mt-2 mb-2 myCard">
                  <div class="card-title-xs">Document List: <span id="programText"></span></div>
                  <div class="row mt-1">
                    <div class="col">
                      <table class="table table-striped list-table-xs" id="documentTable">
                        <tr class="align-center">
                          <th>#</th>
                          <th><input type="checkbox" class="checkUnCheck" disabled data-tag="doc"></th>
                          <th>Document</th>
                          <th>Mandatory</th>
                          <th>Remarks</th>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-dept" role="tabpanel" aria-labelledby="list-dept-list">
            <div class="row">
              <div class="col-sm-9">
                <h3>
                  <a class="fa fa-plus-circle p-0 addDept"></a>
                </h3>
                <div class="container card mt-2 mb-2 myCard">
                  <div class="card-title-xs">Department List</div>
                  <div class="row mt-1">
                    <div class="col">
                      <table class="table table-striped list-table-xs" id="deptTable">
                        <tr class="align-center">
                          <th><i class="fas fa-edit"></i></th>
                          <th>#</th>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Abbri</th>
                          <th>Type</th>
                          <th><i class="fas fa-trash"></i></th>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
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
                          <label>School/Institution</label>
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
                          <label>Department</label>
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
                          <label>Department</label>
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
                          <label>Program/Specialization</label>
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
                                $pa = $rows['program_abbri'];
                                echo '<option value="' . $select_id . '">[' . $pa . '] - ' . $select_name . '</option>';
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
                <div class="container card myCard mb-3">
                  <p class="mt-3" id="schoolDeptShowList"></p>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="container card myCard mb-3">
                  <p class="mt-3" id="deptProgramShowList"></p>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade " id="com" role="tabpanel" aria-labelledby="com">
            <div class="row">
              <div class="col-md-8 pr-0">
                <div class="container card myCard p-2">
                  <p class="largeText">Manage Committee</p>
                  <form class="form-horizontal" id="comForm">
                    <div class="row">
                      <div class="col-md-3 pr-0">
                        <div class="form-group">
                          <label>Committee Name</label>
                          <input type="text" class="form-control form-control-sm" id="com_name" name="com_name" required />
                        </div>
                      </div>
                      <div class="col-md-2 pl-1 pr-0">
                        <div class="form-group">
                          <label>Scope</label>
                          <select class="form-control form-control-sm" id="com_scope" name="com_scope">
                            <option value="Group">Group/University</option>
                            <option value="School">School/Institution</option>
                            <option value="Department">Department</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-1 pl-1 pr-0">
                        <div class="form-group">
                          <label>Duration</label>
                          <input type="number" class="form-control form-control-sm" id="com_term" name="com_term" min="1" value="1" />
                        </div>
                      </div>
                      <div class="col-md-2 pl-1 pr-0">
                        <div class="form-group">
                          <label>Proposer</label>
                          <input type="text" class="form-control form-control-sm" id="com_proposer" name="com_proposer" />
                        </div>
                      </div>
                      <div class="col-md-2 pl-1 pr-0">
                        <div class="form-group">
                          <label>Approver</label>
                          <input type="text" class="form-control form-control-sm" id="com_approver" name="com_approver" />
                        </div>
                      </div>
                      <div class="col-md-2 pl-1 ">
                        <div class="form-group">
                          <label>Rule Book</label>
                          <input type="text" class="form-control form-control-sm" id="com_book" name="com_book" />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3 pr-0">
                        <div class="form-group">
                          <label>Rule Book Reference</label>
                          <textarea class="form-control form-control-sm" rows="3" id="com_reference" name="com_reference"></textarea>
                        </div>
                      </div>
                      <div class="col-md-6 pl-1 pr-0">
                        <div class="form-group">
                          <label>Committee Responsibilities</label>
                          <textarea class="form-control form-control-sm" rows="3" id="com_responsibility" name="com_responsibility"></textarea>
                        </div>
                      </div>
                      <div class="col-md-3 pl-1">
                        <div class="form-group">
                          <label>Remarks</label>
                          <textarea class="form-control form-control-sm" rows="3" id="com_remarks" name="com_remarks"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <input type="hidden" id="comAction" name="action" value="updateCom">
                      <!-- Test id is required 0 for insert and other to update -->
                      <input type="hidden" id="com_idHidden" name="com_id" value="0">
                      <button class="btn btn-sm">Submit</button>
                    </div>
                  </form>
                </div>
                <div class="container card myCard mt-2">
                  <table class="table table-bordered table-striped list-table-xs mt-3" id="comList">
                    <tr>
                      <th><i class="fa fa-pencil-alt"></i></th>
                      <th>#</th>
                      <th>Name</th>
                      <th>Scope</th>
                      <th>Term</th>
                      <th>Proposer</th>
                      <th>Approver</th>
                      <th>Rule Book</th>
                      <th>Reference</th>
                      <th>Responsibility</th>
                      <th>Remarks</th>
                    </tr>
                  </table>
                </div>
              </div>
              <div class="col-md-4 pl-1">
                <div class="container card myCard p-2">
                  <p class="largeText">Structures of Committee</p>
                  <form class="form-horizontal" id="csForm">
                    <div class="row">
                      <div class="col-5 pr-0">
                        <div class="form-group">
                          <label>Name</label>
                          <input type="text" class="form-control form-control-sm" id="cs_name" name="cs_name" required />
                        </div>
                      </div>
                      <div class="col-2 pl-1 pr-0">
                        <div class="form-group">
                          <label>Number</label>
                          <input type="number" class="form-control form-control-sm" id="cs_number" name="cs_number" required />
                        </div>
                      </div>
                      <div class="col-5 pl-1">
                        <div class="form-group">
                          <label>Scope</label>
                          <select class="form-control form-control-sm" id="cs_scope" name="cs_scope">
                            <option value="Chairman">Chairman</option>
                            <option value="Coordinator">Coordinator</option>
                            <option value="Member">Member</option>
                            <option value="Ex-Officio">Ex-Officio</option>
                            <option value="Subject Expert">Subject Expert</option>
                            <option value="External Expert">External Expert</option>
                            <option value="Special Invitee">Special Invitee</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <label>Remarks</label>
                          <textarea class="form-control form-control-sm" rows="3" id="cs_remarks" name="cs_remarks"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <!-- cs_id is required:  0 for insert and other to update -->
                      <input type="hidden" id="csAction" name="action" value="csUpdate">
                      <input type="hidden" id="cs_com" name="com_id" value="0">
                      <input type="hidden" id="cs_idHidden" name="cs_id" value="0">
                      <button class="btn btn-sm">Submit</button>
                    </div>
                  </form>
                </div>
                <div class="container card myCard mt-2">
                  <table class="table table-bordered table-striped list-table-xs mt-3" id="csList">
                    <tr>
                      <th><i class="fa fa-pencil-alt"></i></th>
                      <th>#</th>
                      <th>Name</th>
                      <th>Scope</th>
                      <th>#</th>
                      <th>Remarks</th>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade " id="act" role="tabpanel" aria-labelledby="act">
            <div class="row">
              <div class="col-md-7 pr-0">
                <div class="container card myCard p-2">
                  <p class="largeText">Manage Activities</p>
                  <form class="form-horizontal" id="ahForm">
                    <div class="row">
                      <div class="col-md-2 pr-0">
                        <div class="form-group">
                          <label>Responsibility</label>
                          <?php
                          $sql = "select * from master_name where mn_code='res' and mn_status='0' order by mn_name desc";
                          $result = $conn->query($sql);
                          if ($result) {
                            echo '<select class="form-control form-control-sm" name="sel_resp" id="sel_resp" required>';
                            while ($rows = $result->fetch_assoc()) {
                              $select_id = $rows['mn_id'];
                              $select_name = $rows['mn_name'];
                              echo '<option value="' . $select_id . '">' . $select_name . '[' . $rows['mn_id'] . ']</option>';
                            }
                            // echo '<option value="ALL">ALL</option>';
                            echo '</select>';
                          } else echo $conn->error;
                          if ($result->num_rows == 0) echo 'No Data Found';
                          ?>
                        </div>
                      </div>
                      <div class="col-md-3 pl-1 pr-0">
                        <div class="form-group">
                          <label>Activity Name</label>
                          <input type="text" class="form-control form-control-sm" id="ah_name" name="ah_name" required />
                        </div>
                      </div>
                      <div class="col-md-1 pl-1 pr-0">
                        <div class="form-group">
                          <label>Module</label>
                          <input type="number" class="form-control form-control-sm" id="ah_module" name="ah_module" min="1" value="1" title=" 1 for Begining of Academic Session - 1 represents July-Dec and 2 represents Jan-June for semester system" />
                        </div>
                      </div>
                      <div class="col-md-1 pl-1 pr-0">
                        <div class="form-group">
                          <label>Start</label>
                          <input type="number" class="form-control form-control-sm" id="ah_start_week" name="ah_start_week" min="1" value="1" title="1- First week of the January " />
                        </div>
                      </div>
                      <div class="col-md-1 pl-1 pr-0">
                        <div class="form-group">
                          <label>End</label>
                          <input type="number" class="form-control form-control-sm" id="ah_end_week" name="ah_end_week" min="1" value="1" title="52- Last week of the December " />
                        </div>
                      </div>
                      <div class="col-md-4 pl-1">
                        <div class="form-group">
                          <label>Remarks</label>
                          <input type="text" class="form-control form-control-sm" id="ah_remarks" name="ah_remarks" />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <input type="hidden" id="ahAction" name="action" value="ahUpdate">
                      <!-- Test id is required 0 for insert and other to update -->
                      <input type="hidden" id="ah_idHidden" name="ah_id" value="0">
                      <button class="btn btn-sm">Submit</button>
                    </div>
                  </form>
                </div>
                <div class="container card myCard mt-2">
                  <table class="table table-bordered table-striped list-table-xs mt-3" id="ahList">
                    <tr>
                      <th><i class="fa fa-pencil-alt"></i></th>
                      <th>#</th>
                      <th>Name</th>
                      <th>Resp</th>
                      <th>Module</th>
                      <th>Start</th>
                      <th>End</th>
                      <th>Remarks</th>
                    </tr>
                  </table>
                </div>
              </div>
              <div class="col-md-5 pl-1">
                <div class="container card myCard p-2">
                  <p class="largeText">Activity Sub Heads</p>
                  <form class="form-horizontal" id="ashForm">
                    <div class="row">
                      <div class="col-md-3 pr-0">
                        <div class="form-group">
                          <label>Name</label>
                          <input type="text" class="form-control form-control-sm" id="ash_name" name="ash_name" required />
                        </div>
                      </div>
                      <div class="col-md-2 pl-1 pr-0">
                        <div class="form-group">
                          <label>Start</label>
                          <input type="number" class="form-control form-control-sm" id="ash_start_week" name="ash_start_week" min="1" max="52" value="1"/>
                        </div>
                      </div>
                      <div class="col-md-2 pl-1 pr-0">
                        <div class="form-group">
                          <label>End</label>
                          <input type="number" class="form-control form-control-sm" id="ash_end_week" name="ash_end_week"  min="1" max="52" value="1"/>
                        </div>
                      </div>
                      <div class="col-md-2 pl-1 pr-0">
                        <div class="form-group">
                          <label>SPOC</label>
                          <input type="text" class="form-control form-control-sm" id="ash_spoc" name="ash_spoc" required />
                        </div>
                      </div>
                      <div class="col-md-3 pl-1">
                        <div class="form-group">
                          <label>Remarks</label>
                          <input type="text" class="form-control form-control-sm" id="ash_remarks" name="ash_remarks" />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <!-- cs_id is required:  0 for insert and other to update -->
                      <input type="hidden" id="ashAction" name="action" value="ashUpdate">
                      <input type="hidden" id="ash_ah" name="ah_id" value="0">
                      <input type="hidden" id="ash_idHidden" name="ash_id" value="0">
                      <button class="btn btn-sm">Submit</button>
                    </div>
                  </form>
                </div>
                <div class="container card myCard mt-2">
                  <table class="table table-bordered table-striped list-table-xs mt-3" id="ashList">
                    <tr>
                      <th><i class="fa fa-pencil-alt"></i></th>
                      <th>#</th>
                      <th>Name</th>
                      <th>Strat</th>
                      <th>End</th>
                      <th>#</th>
                      <th>Remarks</th>
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
    </div>
  </div>
  <?php require("../bottom_bar.php"); ?>
</body>
<script>
  $(document).ready(function() {
    $(function() {
      $(document).tooltip();
    });

    instList();
    deptList();
    schoolList();
    programList();

    $(document).on('click', '.is', function() {
      deptSchoolList();
      deptProgramList();
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
        $.alert(data)
      })
      deptProgramList()
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
    // Manage Program
    $(document).on('submit', '#modalForm', function(event) {
      event.preventDefault(this);
      var instName = $("#inst_name").val();
      var pn = $("#program_name").val();
      var school_name = $("#school_name").val();
      var action = $("#action").val();
      // $.alert(" Action " + action);
      if (action == "addInst" && instName === "") $.alert("Group/University Name cannot be blank!! ");
      else if (action == "addProgram" && pn === "") $.alert("Program Name cannot be blank!! ");
      else if (action == "addSchool" && school_name === "") $.alert("School Name cannot be blank!! ");
      else if (action == "addDept" && dept_name === "") $.alert("Department Name cannot be blank!! ");
      else {
        var formData = $(this).serialize();
        $('#firstModal').modal('hide');
        // $.alert(formData);
        $.post("instSql.php", formData, () => {}, "text").done(function(data, status) {
          $.alert(data);
          if (action == "updateInst") instList();
          else if (action == "addProgram" || action == "updateProgram") programList();
          else if (action == "addSchool" || action == "updateSchool") schoolList();
          else if (action == "addDept" || action == "updateDept") deptList();
          $('#modalId').val("0");

          $('#modalForm')[0].reset();
        }).fail(function() {
          $.alert("fail in place of error");
        })
      }
    });

    $(document).on('click', '.editInst', function() {
      // var id = $(this).attr("data-id");
      var id = 1;
      //$.alert("Id " + id);
      $.post("instSql.php", {
        instId: id,
        action: "fetchInst"
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.inst_name);

        $('#modal_title').text("Update Institute [" + id + "]");
        $('#inst_name').val(data.inst_name);
        $('#inst_abbri').val(data.inst_abbri);
        $('#inst_address').val(data.inst_address);
        $('#inst_logo').val(data.inst_logo);

        if (data.inst_logo === null) $(".instLogo").html('<img  src="../../images/upload.jpg" width="100%">');
        else $(".instLogo").html('<img  src="<?php echo '../../' . $myFolder . '/'; ?>' + data.inst_logo + '" width="100%">');

        $('#inst_url').val(data.inst_url);
        $('#inst_approval').val(data.inst_approval);
        $('#inst_affiliation').val(data.inst_affiliation);
        $('#inst_city').val(data.inst_city);
        $('#inst_state').val(data.inst_state);
        $('#inst_pincode').val(data.inst_pincode);
        $('#inst_timelag').val(data.inst_timelag);

        $('#action').val("updateInst");
        $('#modalId').val(id);

        $('#firstModal').modal('show');
        $('.programForm').hide();
        $('.instForm').show();
        $('.schoolForm').hide();
        $('.departmentForm').hide();

        //$("#ccform").html(mydata);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.editProgram', function() {
      var id = $(this).attr("data-id");
      //$.alert("Id " + id);

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
        $('#sp_code').val(data.sp_code);
        $('#sp_name').val(data.sp_name);
        $('#sp_abbri').val(data.sp_abbri);
        $('#deptIdModal').val(data.dept_id);

        $('#action').val("updateProgram");
        $('#modalId').val(id);

        $('#firstModal').modal('show');
        $('.programForm').show();
        $('.instForm').hide();
        $('.schoolForm').hide();
        $('.departmentForm').hide();

        //$("#ccform").html(mydata);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });
    $(document).on('click', '.addProgram', function() {
      //$.alert("Add Program");
      $('#modal_title').text("Add Program");
      $('#action').val("addProgram");
      $('#firstModal').modal('show');
      $('.instForm').hide();
      $('.schoolForm').hide();
      $('.departmentForm').hide();
      $(".programForm").show();
    });

    function programList() {
      // $.alert("In List Function");
      $.post("instSql.php", {
        action: "programList"
      }, function(mydata, mystatus) {
        $("#programShowList").show();
        //$.alert("List " + mydata);
      }, "json").done(function(data, status) {
        if (data.success == "0") {
          var success = '<tr><td colspan="10">No Program Found. Please add Program only if you are Head of Institution or Department</td></tr>';
          $("#programTable").find("tr:gt(0)").remove();
          $("#programTable").append(success);

        } else {
          // $("#feedbackTable").html("Found")
          var card = '';
          var count = 1;
          $.each(data, function(key, value) {
            var status = value.program_status
            if (status != null) {
              var text = value.program_abbri + "[ " + value.sp_abbri + "]"
              card += '<tr>';
              card += '<td><a href="#" class="editProgram fa fa-pencil-alt" data-id="' + value.program_id + '"></td>';
              card += '<td class="text-center">' + count++ + '</td>';
              card += '<td class="text-center">' + value.sp_code + '</td>';
              card += '<td>' + value.program_name + ' [' + value.program_abbri + ']</td>';
              card += '<td>' + value.sp_name + ' [' + value.sp_abbri + ']</td>';
              card += '<td class="text-center">' + value.program_duration + ' [' + value.program_semester + ']</td>';
              card += '<td class="text-center">' + value.program_start + '</td>';
              card += '<td class="text-center">' + value.program_seat + '</td>';
              card += '<td class="text-center">' + value.program_seat + '</td>';
              card += '<td class="text-center"><a href="#" class="fa fa-arrow-circle-right largeText text-success programOutcome" data-id="' + value.program_id + '" title="Manage the Program Outcome"></td>';
              card += '<td class="text-center"><a href="#" class="fa fa-arrow-circle-right largeText documentProgram" data-id="' + value.program_id + '" data-text="' + text + '" title="Manage the required documents by the students"></td>';
              if (status == 0) card += '<td class="text-center"><a href="#" class="fa fa-trash trashProgram" data-id="' + value.program_id + '"></td>';
              else card += '<td class="text-center"><a href="#" class="fa fa-refresh resetProgram" data-id="' + value.program_id + '"></td>';
              card += '</tr>';
            }
          })
          $("#programTable").find("tr:gt(0)").remove();
          $("#programTable").append(card);
        }
      })
    }

    $(document).on('click', '.documentProgram', function() {
      var program_id = $(this).attr("data-id");
      var text = $(this).attr("data-text");
      $("#prog_idHidden").val(program_id)
      $("#programText").html(text)
      // $.alert(text)
      docList()
    });

    $(document).on('change', '#sel_batch', function() {
      docList()
    });

    function docList() {
      var program_id = $("#prog_idHidden").val()
      var batch_id = $("#sel_batch").val()
      // $.alert("Data" + program_id + "batch " + batch_id)
      $.post("instSql.php", {
        program_id: program_id,
        batch_id: batch_id,
        mn_code: "doc",
        action: "mnList"
      }, function() {}, "json").done(function(data, status) {
        // $.alert("Data" + data)
        var card = '';
        var count = 1;
        $.each(data, function(key, value) {
          var status = value.status
          if (status != null) {
            card += '<tr>';
            card += '<td class="text-center">' + count++ + '</td>';
            if (status == 1) card += '<td class="text-center"><input type="checkbox" checked class="doc" data-id="' + value.mn_id + '"></td>';
            else card += '<td class="text-center"><input type="checkbox" class="doc" data-id="' + value.mn_id + '"></td>';
            card += '<td class="text-center">' + value.mn_name + '</td>';
            card += '</tr>';
          }
        })
        $("#documentTable").find("tr:gt(0)").remove();
        $("#documentTable").append(card);
      }).fail(function() {
        $.alert("Error");
      })
    }

    $(document).on('click', '.checkUnCheck', function() {
      var status = $(this).is(":checked");
      var tag = $(this).attr("data-tag");
      if (status == false) $('.doc').prop('checked', false); // Unchecks it
      else $('.doc').prop('checked', true); // Unchecks it
    });

    $(document).on('click', '.doc', function() {
      if ($(this).is(":checked")) var status = "add";
      else var status = "remove";
      var program_id = $("#prog_idHidden").val()
      var batch_id = $("#sel_batch").val()
      var mn_id = $(this).attr("data-id")
      // $.alert(" Status " + status + " Program " + program_id + " mn_id " + mn_id + "Batch " + batch_id)
      $.post("instSql.php", {
        program_id: program_id,
        batch_id: batch_id,
        mn_id: mn_id,
        status: status,
        action: "updateDocument"
      }, function() {}, "text").done(function(data, status) {
        // $.alert("Data" + data)
      }).fail(function() {
        $.alert("Error");
      })
    });

    $(document).on('click', '.resetProgram', function() {
      var prog_id = $(this).attr("data-id");
      // $.alert("Data" + prog_id)
      $.post("instSql.php", {
        progId: prog_id,
        action: "resetProgram"
      }, function() {}, "text").done(function(data, status) {
        // $.alert("Data" + data)
        programList();
      }).fail(function() {
        $.alert("Error");
      })
    });
    $(document).on('click', '.trashProgram', function() {
      var prog_id = $(this).attr("data-id");
      // $.alert("Data" + prog_id)
      $.post("instSql.php", {
        progId: prog_id,
        action: "removeProgram"
      }, function() {}, "text").done(function(data, status) {
        // $.alert("Data" + data)
        programList();
      }).fail(function() {
        $.alert("Error");
      })
    });

    $(document).on('click', '.addSchool', function() {
      //$.alert("Add Program");
      $('#modal_title').text("Add School/Institution");
      $('#action').val("addSchool");
      $('#firstModal').modal('show');
      $('.instForm').hide();
      $('.schoolForm').show();
      $('.departmentForm').hide();
      $(".programForm").hide();
    });
    $(document).on('click', '.editSchool', function() {
      var id = $(this).attr("data-id");
      // $.alert("Id " + id);

      $.post("instSql.php", {
        schoolId: id,
        action: "fetchSchool"
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.inst_name);

        $('#modal_title').text("Update School/Institution [" + id + "]");
        $('#school_name').val(data.school_name);
        $('#school_abbri').val(data.school_abbri);
        $('#school_code').val(data.school_code);

        $('#action').val("addSchool");
        $('#modalId').val(id);

        $('#firstModal').modal('show');
        $('.instForm').hide();
        $('.schoolForm').show();
        $('.departmentForm').hide();
        $(".programForm").hide();

        //$("#ccform").html(mydata);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });
    $(document).on('click', '.resetSchool', function() {
      var id = $(this).attr("data-id");
      // $.alert("Data" + prog_id)
      $.post("instSql.php", {
        sclId: id,
        action: "resetSchool"
      }, function() {}, "text").done(function(data, status) {
        // $.alert("Data" + data)
        schoolList();
      }).fail(function() {
        $.alert("Error");
      })
    });
    $(document).on('click', '.trashSchool', function() {
      var id = $(this).attr("data-id");
      // $.alert("Data" + prog_id)
      $.post("instSql.php", {
        sclId: id,
        action: "removeSchool"
      }, function() {}, "text").done(function(data, status) {
        // $.alert("Data" + data)
        schoolList();
      }).fail(function() {
        $.alert("Error");
      })
    });

    function schoolList() {
      // $.alert("In List Function");
      $.post("instSql.php", {
        action: "schoolList"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data)
        var card = '';
        var count = 1;
        $.each(data, function(key, value) {
          var status = value.school_status
          if (status != null) {
            card += '<tr>';
            card += '<td><a href="#" class="editSchool fa fa-pencil-alt" data-id="' + value.school_id + '"></td>';
            card += '<td>' + count++ + '</td>';
            card += '<td>' + value.school_name + '</td>';
            card += '<td>' + value.school_abbri + '</td>';
            card += '<td>' + value.school_code + '</td>';
            if (status == 0) card += '<td><a href="#" class="fa fa-trash trashSchool" data-id="' + value.school_id + '"></td>';
            else card += '<td><a href="#" class="fa fa-refresh resetSchool" data-id="' + value.school_id + '"></td>';
            card += '</tr>';
          }
        })
        $("#schoolTable").find("tr:gt(0)").remove();
        $("#schoolTable").append(card);

      })
    }

    $(document).on('click', '.addDept', function() {
      //$.alert("Add Program");
      $('#modal_title').text("Add Department");
      $('#action').val("addDept");
      $('#firstModal').modal('show');
      $('.instForm').hide();
      $('.schoolForm').hide();
      $('.departmentForm').show();
      $(".programForm").hide();
    });
    $(document).on('click', '.editDept', function() {
      var id = $(this).attr("data-id");
      // $.alert("Id " + id);
      $.post("instSql.php", {
        deptId: id,
        action: "fetchDept"
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.inst_name);

        $('#modal_title').text("Update Department [" + id + "]");
        $('#dept_name').val(data.dept_name);
        $('#dept_abbri').val(data.dept_abbri);
        $('#dept_type').val(data.dept_type);

        $('#action').val("addDept");
        $('#modalId').val(id);

        $('#firstModal').modal('show');
        $('.instForm').hide();
        $('.schoolForm').hide();
        $('.departmentForm').show();
        $(".programForm").hide();

        //$("#ccform").html(mydata);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });
    $(document).on('click', '.resetDept', function() {
      var id = $(this).attr("data-id");
      // $.alert("Data" + prog_id)
      $.post("instSql.php", {
        deptId: id,
        action: "resetDept"
      }, function() {}, "text").done(function(data, status) {
        // $.alert("Data" + data)
        deptList();
      }).fail(function() {
        $.alert("Error");
      })
    });

    $(document).on('click', '.trashDept', function() {
      var id = $(this).attr("data-id");
      // $.alert("Data" + prog_id)
      $.post("instSql.php", {
        deptId: id,
        action: "removeDept"
      }, function() {}, "text").done(function(data, status) {
        // $.alert("Data" + data)
        deptList();
      }).fail(function() {
        $.alert("Error");
      })
    });

    function deptList() {
      // $.alert("In List Function");
      $.post("instSql.php", {
        action: "deptList"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data)
        var card = '';
        var count = 1;
        $.each(data, function(key, value) {
          var status = value.dept_status
          if (status != null) {
            card += '<tr>';
            card += '<td><a href="#" class="editDept fa fa-pencil-alt" data-id="' + value.dept_id + '"></td>';
            card += '<td>' + count++ + '</td>';
            card += '<td>' + value.dept_id + '</td>';
            card += '<td>' + value.dept_name + '</td>';
            card += '<td>' + value.dept_abbri + '</td>';
            if (value.dept_type == 0) card += '<td>Teaching</td>';
            else if (value.dept_type == 1) card += '<td>Non Teaching</td>';
            else card += '<td>Not Set</td>';
            if (status == 0) card += '<td><a href="#" class="fa fa-trash trashDept" data-id="' + value.dept_id + '"></td>';
            else card += '<td><a href="#" class="fa fa-refresh resetDept" data-id="' + value.dept_id + '"></td>';
            card += '</tr>';
          }
        })
        $("#deptTable").find("tr:gt(0)").remove();
        $("#deptTable").append(card);

      })
    }

    function instList() {
      // $.alert("In List Function");
      $.post("instSql.php", {
        action: "fetchInst"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data)
        $("#instName").html(data.inst_name)
        $("#instURL").html(data.inst_url)
        $("#instAbbri").html(data.inst_abbri)
        $("#instAddress").html(data.inst_address)
        $("#instApproval").html(data.inst_approval)
        $("#instAffiliation").html(data.inst_affiliation)
        $("#instCity").html(data.inst_city)
        $("#instState").html(data.inst_state)
        $("#instPincode").html(data.inst_pincode)
        $("#instTimelag").html(data.inst_timelag)

        if (data.inst_logo === null) $(".instLogo").html('<img  src="../../images/upload.jpg" width="100%">');
        else $(".instLogo").html('<img  src="<?php echo '../../' . $myFolder . '/'; ?>' + data.inst_logo + '" width="100%">');

      })
    }

    // Committee Block

    // Manage Committee - Block
    comList();

    $(document).on('submit', '#comForm', function(event) {
      event.preventDefault(this);
      var formData = $(this).serialize();
      $.alert(formData);
      $.post("instSql.php", formData, () => {}, "text").done(function(data) {
        $.alert("List Updtaed" + data);
        $("#comForm")[0].reset();
        comList();
        $("#com_idHidden").val("0");
        $("#bl_com").val("0");
      })
    });

    function comList() {
      // $.alert('hello');
      $.post("instSql.php", {
        action: "comList",
      }, () => {}, "json").done(function(data, status) {
        // $.alert(data);
        var card = '';
        var count = 1;
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td><a href="#" class="comEdit fa fa-pencil-alt" data-com="' + value.com_id + '"></td>';
          card += '<td>' + count++ + '</td>';
          card += '<td>' + value.com_name + '</td>';
          card += '<td>' + value.com_scope + '</td>';
          card += '<td>' + value.com_term + '</td>';
          card += '</tr>';
        });
        $("#comList").find("tr:gt(0)").remove()
        $("#comList").append(card);
      }).fail(function() {
        $.alert("Committee Not Responding");
      })
    }

    $(document).on("click", ".comEdit", function() {
      var com_id = $(this).attr("data-com")
      // $().removeClass();
      $(".comEdit").removeClass('fa-circle')
      $(".comEdit").addClass('fa-pencil-alt')

      $(this).removeClass('fa-pencil-alt');
      $(this).addClass('fa-circle')

      // $.alert("Edit - Fetch " + rp_id);
      $.post("instSql.php", {
        com_id: com_id,
        action: "comFetch"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        $("#com_name").val(data.com_name)
        $("#com_scope").val(data.com_scope)
        $("#com_term").val(data.com_term)
        $("#com_idHidden").val(data.com_id)
        $("#cs_com").val(data.com_id) // To be part of Committee Structure Form
        csList();
      })
    })

    // Manage Committee Structure - Committee
    // csList();

    $(document).on('submit', '#csForm', function(event) {
      event.preventDefault(this);
      var com_id = $("#cs_com").val()
      if ($("#cs_name").val() == " ") $.alert("Name Missing !!")
      else if (com_id > 0) {
        var formData = $(this).serialize();
        // $.alert(formData);
        $.post("instSql.php", formData, () => {}, "text").done(function(data) {
          // $.alert("List Updtaed" + data);
          $("#csForm")[0].reset();
          csList();
          $("#cs_idHidden").val("0");
          $("#cs_dept").val($("#sel_dept").val())
        })
      } else $.alert("Please select a Committee to Proceed !!!");
    });

    function csList() {
      var com_id = $("#cs_com").val()
      $.post("instSql.php", {
        com_id: com_id,
        action: "csList",
      }, () => {}, "json").done(function(data, status) {
        var card = '';
        var count = 1;
        // $.alert(data);
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td><a href="#" class="csEdit fa fa-pencil-alt" data-cs="' + value.cs_id + '"></td>';
          card += '<td>' + count++ + '</td>';
          card += '<td>' + value.cs_name + '</td>';
          card += '<td>' + value.cs_scope + '</td>';
          card += '<td>' + value.cs_number + '</td>';
          card += '<td>' + value.cs_remarks + '</td>';
          card += '</tr>';
        });
        $("#csList").find("tr:gt(0)").remove()
        $("#csList").append(card);
      }).fail(function() {
        $.alert("Committee-Structure Not Responding");
      })
    }

    $(document).on("click", ".csEdit", function() {
      var cs_id = $(this).attr("data-cs")
      // $().removeClass();
      $(".csEdit").removeClass('fa-circle')
      $(".csEdit").addClass('fa-pencil-alt')

      $(this).removeClass('fa-pencil-alt');
      $(this).addClass('fa-circle')

      // $.alert("Edit - Fetch " + rp_id);
      $.post("instSql.php", {
        cs_id: cs_id,
        action: "csFetch"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        $("#cs_name").val(data.cs_name)
        $("#cs_number").val(data.cs_number)
        $("#cs_scope").val(data.cs_scope)
        $("#cs_remarks").val(data.cs_remarks)
        $("#cs_idHidden").val(data.cs_id)
      })
    })

    // Activity Head Block

    // Manage Activity Head - Block
    ahList();

    $(document).on('submit', '#ahForm', function(event) {
      event.preventDefault(this);
      var formData = $(this).serialize();
      // $.alert(formData);
      $.post("instSql.php", formData, () => {}, "text").done(function(data) {
        // $.alert("List Updtaed" + data);
        $("#ahForm")[0].reset();
        ahList();
        $("#ah_idHidden").val("0");
        $("#ash_ah").val("0");
      })
    });

    function ahList() {
      // $.alert('hello');
      $.post("instSql.php", {
        action: "ahList",
      }, () => {}, "json").done(function(data, status) {
        // $.alert(data);
        var card = '';
        var count = 1;
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td><a href="#" class="ahEdit fa fa-pencil-alt" data-ah="' + value.ah_id + '"></td>';
          card += '<td>' + count++ + '</td>';
          card += '<td>' + value.ah_name + '</td>';
          card += '<td>' + value.mn_name + '</td>';
          card += '<td>' + value.ah_module + '</td>';
          card += '<td>Week-' + value.ah_start_week + '</td>';
          card += '<td>Week-' + value.ah_end_week + '</td>';
          card += '<td>' + value.ah_remarks + '</td>';
          card += '</tr>';
        });
        $("#ahList").find("tr:gt(0)").remove()
        $("#ahList").append(card);
      }).fail(function() {
        $.alert("Committee Not Responding");
      })
    }

    $(document).on("click", ".ahEdit", function() {
      var ah_id = $(this).attr("data-ah")
      // $().removeClass();
      $(".ahEdit").removeClass('fa-circle')
      $(".ahEdit").addClass('fa-pencil-alt')

      $(this).removeClass('fa-pencil-alt');
      $(this).addClass('fa-circle')

      $.alert("Edit - Fetch " + ah_id);

      $.post("instSql.php", {
        ah_id: ah_id,
        action: "ahFetch"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        $("#ah_name").val(data.ah_name)
        $("#sel_resp").val(data.mn_id)
        $("#ah_module").val(data.ah_module)
        $("#ah_start_week").val(data.ah_start_week)
        $("#ah_end_week").val(data.ah_end_week)
        $("#ah_remarks").val(data.ah_remarks)
        $("#ah_idHidden").val(data.ah_id)
        $("#ash_ah").val(data.ah_id) // To be part of Activity Sub Head Form
        ashList();
      })
    })


    // Manage Activity Sub Head - Block
    $(document).on('submit', '#ashForm', function(event) {
      event.preventDefault(this);
      var ah_id = $("#ash_ah").val()
      if ($("#ash_name").val() == " ") $.alert("Name Missing !!")
      else if (ah_id > 0) {
        var formData = $(this).serialize();
        $.alert(formData);
        $.post("instSql.php", formData, () => {}, "text").done(function(data) {
          $.alert("List Updtaed" + data);
          $("#ashForm")[0].reset();
          ashList();
          $("#ash_idHidden").val("0");
          // $("#cs_dept").val($("#sel_dept").val())
        })
      } else $.alert("Please select a Activity to Proceed !!!");
    });

    function ashList() {
      var ah_id = $("#ash_ah").val()
      $.post("instSql.php", {
        ah_id: ah_id,
        action: "ashList",
      }, () => {}, "json").done(function(data, status) {
        var card = '';
        var count = 1;
        // $.alert(data);
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td><a href="#" class="ashEdit fa fa-pencil-alt" data-ash="' + value.ash_id + '"></td>';
          card += '<td>' + count++ + '</td>';
          card += '<td>' + value.ash_name + '</td>';
          card += '<td>' + value.ash_spoc + '</td>';
          card += '<td>' + value.ash_start_week + '</td>';
          card += '<td>' + value.ash_end_week + '</td>';
          card += '<td>' + value.ash_remarks + '</td>';
          card += '</tr>';
        });
        $("#ashList").find("tr:gt(0)").remove()
        $("#ashList").append(card);
      }).fail(function() {
        $.alert("Activity-Sub-Head Not Responding");
      })
    }

    $(document).on("click", ".ashEdit", function() {
      var ash_id = $(this).attr("data-ash")
      // $().removeClass();
      $(".ashEdit").removeClass('fa-circle')
      $(".ashEdit").addClass('fa-pencil-alt')

      $(this).removeClass('fa-pencil-alt');
      $(this).addClass('fa-circle')

      // $.alert("Edit - Fetch " + rp_id);
      $.post("instSql.php", {
        ash_id: ash_id,
        action: "ashFetch"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        $("#ash_name").val(data.ash_name)
        $("#ash_spoc").val(data.ash_spoc)
        $("#ash_start_week").val(data.ash_start_week)
        $("#ash_end_week").val(data.ash_end_week)
        $("#ash_remarks").val(data.ash_remarks)
        $("#ash_idHidden").val(data.ash_id)
      })
    })
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
              <div class="col-6 pr-0">
                <div class="form-group">
                  <label>Group/University</label>
                  <input type="text" class="form-control form-control-sm" id="inst_name" name="inst_name" placeholder="Name">
                </div>
              </div>
              <div class="col-3 pl-1 pr-0">
                <div class="form-group">
                  <label>Abbri</label>
                  <input type="text" class="form-control form-control-sm" id="inst_abbri" name="inst_abbri" placeholder="Abbri">
                </div>
              </div>
              <div class="col-3 pl-1">
                <div class="form-group">
                  <label> Logo </label>
                  <input type="text" class="form-control form-control-sm" id="inst_logo" name="inst_logo" placeholder="Logo">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-7 pr-0">
                <div class="form-group">
                  <label>Address</label>
                  <input type="text" class="form-control form-control-sm" id="inst_address" name="inst_address" placeholder="Address">
                </div>
              </div>
              <div class="col-5 pl-1">
                <div class="form-group">
                  <label>URL</label>
                  <input type="text" class="form-control form-control-sm" id="inst_url" name="inst_url" placeholder="Abbri">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-4 pr-0">
                <div class="form-group">
                  <label>City</label>
                  <input type="text" class="form-control form-control-sm" id="inst_city" name="inst_city" placeholder="City" value=" " required>
                </div>
              </div>
              <div class="col-4 pl-1 pr-0">
                <div class="form-group">
                  <label>State</label>
                  <input type="text" class="form-control form-control-sm" id="inst_state" name="inst_state" placeholder="State">
                </div>
              </div>
              <div class="col-4 pl-1">
                <div class="form-group">
                  <label>Pin code</label>
                  <input type="number" class="form-control form-control-sm" id="inst_pincode" name="inst_pincode" placeholder="Pincode" value="101010" required>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-6 pr-0">
                <div class="form-group">
                  <label>Approval</label>
                  <input type="text" class="form-control form-control-sm" id="inst_approval" name="inst_approval" placeholder="Government Approval Body">
                </div>
              </div>
              <div class="col-6 pl-1">
                <div class="form-group">
                  <label>Affiliation</label>
                  <input type="text" class="form-control form-control-sm" id="inst_affiliation" name="inst_affiliation" placeholder="Affiliating University">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-4 pr-0">
                <div class="form-group">
                  <label>Time Lag</label>
                  <input type="number" class="form-control form-control-sm" id="inst_timelag" name="inst_timelag" placeholder="Time Lag" value="0" required>
                </div>
              </div>
            </div>

          </div>
          <div class="schoolForm">
            <div class="row">
              <div class="col-6 pr-0">
                <div class="form-group">
                  <label>School/Institution Name</label>
                  <input type="text" class="form-control form-control-sm" id="school_name" name="school_name" placeholder="Name">
                </div>
              </div>
              <div class="col-3 pl-1 pr-0">
                <div class="form-group">
                  <label>Abbri</label>
                  <input type="text" class="form-control form-control-sm" id="school_abbri" name="school_abbri" placeholder="Abbri">
                </div>
              </div>
              <div class="col-3 pl-1">
                <div class="form-group">
                  <label> Code</label>
                  <input type="text" class="form-control form-control-sm" id="school_code" name="school_code" placeholder="Code">
                </div>
              </div>
            </div>
          </div>
          <div class="departmentForm">
            <div class="row">
              <div class="col-6 pr-0">
                <div class="form-group">
                  <label>Department Name</label>
                  <input type="text" class="form-control form-control-sm" id="dept_name" name="dept_name" placeholder="Name">
                </div>
              </div>
              <div class="col-3 pl-1 pr-0">
                <div class="form-group">
                  <label>Abbri</label>
                  <input type="text" class="form-control form-control-sm" id="dept_abbri" name="dept_abbri" placeholder="Abbri">
                </div>
              </div>
              <div class="col-3 pl-1">
                <div class="form-group">
                  <label>Type</label>
                  <select class="form-control form-control-sm" id="dept_type" name="dept_type">
                    <option value="0">Teaching</option>
                    <option value="1">Non Teaching</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="programForm">
            <div class="row">
              <div class="col-9">
                <div class="form-group">
                  Program Name
                  <input type="text" class="form-control form-control-sm" id="program_name" name="program_name" placeholder="Program Name">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Prog Abbri
                  <input type="text" class="form-control form-control-sm" id="program_abbri" name="program_abbri" placeholder="Program Abbri">
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
                  <input type="text" class="form-control form-control-sm" id="sp_code" name="sp_code" placeholder="Sp code" value="00">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <div class="form-group">
                  Duration
                  <input type="number" class="form-control form-control-sm" id="program_duration" name="program_duration" placeholder="Program Duration" value="1">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Semester
                  <input type="number" class="form-control form-control-sm" id="program_semester" name="program_semester" placeholder="Semester" value="2">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Start Year
                  <input type="number" class="form-control form-control-sm" id="program_start" name="program_start" value="2000">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Seats
                  <input type="number" class="form-control form-control-sm" id="program_seat" name="program_seat" placeholder="Seats" value="60">
                </div>
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="modalId" name="modalId">
          <input type="hidden" id="action" name="action">
          <button type="submit" class="btn btn-sm" id="submitModalForm">Submit</button>
          <button type="button" class="btn btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->

    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

</html>