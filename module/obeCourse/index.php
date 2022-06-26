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
    <input type="hidden" id="subject_name" value="Subject Not Selected">
    <div class="row">
      <div class="col-md-1 p-0 m-0 pl-2 full-height">
        <h5 class="pt-3">Course Settings</h5>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active" data-toggle="list" href="#scopeList" role="tab" aria-controls="scopeList"> Scope </a>
          <a class="list-group-item list-group-item-action" data-toggle="list" href="#contentList" role="tab" aria-controls="content"> Content </a>
          <a class="list-group-item list-group-item-action" data-toggle="list" href="#resource" role="tab" aria-controls="resource"> Resources </a>
          <a class="list-group-item list-group-item-action co" id="list-co-list" data-toggle="list" href="#list-co" role="tab" aria-controls="co"> Update COs </a>
          <a class="list-group-item list-group-item-action ap" id="list-ap-list" data-toggle="list" href="#list-ap" role="tab" aria-controls="ap"> Assess Planning </a>
          <a class="list-group-item list-group-item-action cho" data-toggle="list" href="#choList" role="tab" aria-controls="choList"> Course Guide </a>
          <a class="list-group-item list-group-item-action ad" id="list-ad-list" data-toggle="list" href="#list-ad" role="tab" aria-controls="ad"> Assess Design </a>
        </div>
      </div>
      <div class="col-md-11 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <?php //echo $myEmail . $myProg . $tn_sub; 
          ?>
          <p id="mySubject"></p>
          <div class="tab-pane show active" id="scopeList" role="tabpanel" aria-labelledby="scope">
            <div class="row">
              <div class="col-md-12">
                <div class="card myCard">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <form class="scopeForm" id="scopeForm">
                          <input type="hidden" name="action" value="scope">
                          <input type="hidden" id="scope_sub" name="subject_id" value="0">
                          <vkj class="scope" id="scope" name="scope"></vkj>
                          <button type="submit" class="btn btn-sm">Save/Update</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="contentList" role="tabpanel" aria-labelledby="content">
            <div class="row">
              <div class="col-md-6 pr-0">
                <div class="card myCard">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <form class="contentForm" id="contentForm">
                          <input type="hidden" id="actionContent" name="action" value="content">
                          <input type="hidden" id="content_sub" name="subject_id" value="0">
                          <vkj class="content" id="content" name="content"></vkj>
                          <button type="submit" class="btn btn-sm">Save/Update</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 pl-1">
                <div class="card myCard">
                  <div class="card-body">
                    <div class="stForm border">
                      <div class="row">
                        <div class="col-6 pr-1">
                          <div class="form-group">
                            <label>Topic Name</label>
                            <input type="text" class="form-control form-control-sm" id="sbt_name" name="sbt_name" placeholder="Topic">
                          </div>
                        </div>
                        <div class="col-2 pl-0 pr-1">
                          <div class="form-group">
                            <label>Wt (%)</label>
                            <input type="number" class="form-control form-control-sm" id="sbt_weight" name="sbt_weight" min="1" placeholder="Weight in %" value="1">
                          </div>
                        </div>
                        <div class="col-2 pl-0 pr-1">
                          <div class="form-group">
                            <label>CHr</label>
                            <input type="number" class="form-control form-control-sm" id="sbt_slot" name="sbt_slot" min="1" placeholder="Contact Hours Required" value="1">
                          </div>
                        </div>
                        <div class="col-2 pl-0">
                          <div class="form-group">
                            <label>Unit</label>
                            <input type="number" class="form-control form-control-sm" id="sbt_unit" name="sbt_unit" min="1" placeholder="Unit Number" value="1">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-6 mt-3">
                          <div class="form-check-inline">
                            <input type="radio" class="form-check-input" checked id="syllabus" name="sbt_syllabus" value="0">Syllabus
                          </div>
                          <div class="form-check-inline">
                            <input type="radio" class="form-check-input" id="additional" name="sbt_syllabus" value="1">Additional
                          </div>
                        </div>
                        <div class="col-3 pl-1">
                          <div class="form-group">
                            <button class="btn btn-sm submit_sbt mt-4" id="submit_sbt">Submit</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="subjectTopics">
                      <label>List of Topics</label>
                      <p id="subjectTopicList"></p>
                      <span class="smText">Syllabus Topics are not editable. These are as approved by BOS. The faculty can add additional Topics in the interest of students based on current trends and industry requirements.</span>
                      <div class="col">
                        <span class="smText">
                          <li>Subject Topics will be same for one Subject irrespective of the Class and Faculty.</li>
                          <li> It signifies the Syllabus.</li>
                          <li> You can add any additional topic.</li>
                        </span>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="resource" role="tabpanel" aria-labelledby="resource">
            <div class="row">
              <div class="col-5 pr-0">
                <div class="card myCard">
                  <div class="card-body">
                    <div class="border">
                      <div class="row">
                        <div class="col-4 pr-0">
                          <div class="form-group">
                            Title
                            <input type="text" class="form-control form-control-sm" id="sbk_name" name="sbk_name" placeholder="Title of the Book/Journal">
                          </div>
                        </div>
                        <div class="col-4 pl-1 pr-0">
                          <div class="form-group">
                            Publisher
                            <input type="text" class="form-control form-control-sm" id="sbk_publisher" name="sbk_publisher" placeholder="Publisher Name">
                          </div>
                        </div>
                        <div class="col-4 pl-1">
                          <div class="form-group">
                            <label>Author</label>
                            <input type="text" class="form-control form-control-sm" id="sbk_author" name="sbk_author" placeholder="Author Name">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-4 pr-0">
                          <div class="form-group">
                            ISBN/ISSN
                            <input type="text" class="form-control form-control-sm" id="sbk_isbn" name="sbk_isbn" placeholder="Title of the Book/Journal">
                          </div>
                        </div>
                        <div class="col-4 pl-1 pr-0">
                          <div class="form-group">
                            DOI
                            <input type="text" class="form-control form-control-sm" id="sbk_doi" name="sbk_doi" placeholder="DOI">
                          </div>
                        </div>
                        <div class="col-4 pl-1">
                          <div class="form-group">
                            <label>Edition/Vol(No)</label>
                            <input type="text" class="form-control form-control-sm" id="sbk_edition" name="sbk_edition" placeholder="Edition Vol(No)">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-8 pr-0">
                          <div class="form-check-inline">
                            <input type="radio" class="form-check-input" checked id="book" name="sbk_type" value="book">
                            Book
                          </div>
                          <div class="form-check-inline">
                            <input type="radio" class="form-check-input" id="journal" name="sbk_type" value="journal">Journal
                          </div>
                        </div>
                        <div class="col-3 pl-1">
                          <div class="form-group">
                            <button class="btn btn-sm" id="submit_sbBook">Submit</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <label>Text/Reference Books <span id="bookList" class="bookList fa fa-eye"></span></label>
                    <p id="subjectBooks"></p>
                  </div>
                </div>
              </div>
              <div class="col-7 pl-1">
                <div class="card myCard">
                  <div class="card-body">
                    <div class="border">
                      <div class="row p-1">
                        <div class="col-3 pr-0">
                          <div class="form-group">
                            Resource Title/Name
                            <input type="text" class="form-control form-control-sm" id="sbr_name" name="sbr_name" placeholder="Title of the Resource">
                          </div>
                        </div>
                        <div class="col-3 pl-1 pr-0">
                          <div class="form-group">
                            URL
                            <input type="text" class="form-control form-control-sm" id="sbr_url" name="sbr_url" placeholder="Complete URL including http://">
                          </div>
                        </div>
                        <div class="col-2 pl-1 pr-0">
                          <div class="form-group">
                            <label>Type</label>
                            <?php
                            $sql = "select * from master_name where mn_code='rt'";
                            selectList($conn, "", array("0", "mn_id", "mn_name", "", "sel_mn"), $sql);
                            ?>
                          </div>
                        </div>
                        <div class="col-md-2 pl-1 pr-0">
                          <label>Status</label>
                          <div class="form-check">
                            <input type="radio" class="form-check-input" checked id="private" name="sbr_type" value="Private">
                            Private
                          </div>
                          <div class="form-check-inline">
                            <input type="radio" class="form-check-input" id="public" name="sbr_type" value="Public">Public
                          </div>
                        </div>
                        <div class="col-2 pl-1">
                          <br>
                          <div class="form-group">
                            <button class="btn btn-sm" id="submit_sbResource">Submit</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="subjectResource">
                      <label>List of Resources</label>
                      <p id="resourceList"></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-co" role="tabpanel" aria-labelledby="list-co-list">
            <span class="largeText">Course Outcome</span>
            <div class="row">
              <div class="col-sm-12">
                <div class="card myCard p-2">
                  <table class="table table-striped list-table-xs" id="coTable">
                    <tr class="align-center">
                      <th width="5%"><i class="fa fa-pencil-alt"></i></th>
                      <th width="15%">Course Code</th>
                      <th width="5%">SNo</th>
                      <th>Course Outcome</th>
                      <th width="5%">Wt(%)</th>
                      <th width="5%"><i class="fa fa-trash"></i></th>
                    </tr>
                  </table>
                  <span class="smallerText warning">Use <i class="fa fa-pencil-alt"></i> to Retrieve the Deleted Entry</span>
                  <div class="row">
                    <div class="col-2 pr-0">
                      <div class="form-group">
                        <label>CO Sno</label>
                        <input type="number" class="form-control form-control-sm" id="co_sno" name="co_sno" placeholder="#" min="1" value="1">
                      </div>
                    </div>
                    <div class="col-7 pr-0">
                      <div class="form-group">
                        <label>CO Statement </label>
                        <input type="text" class="form-control form-control-sm" id="co_statement" name="co_statement" placeholder="CO Statement">
                        <input type="hidden" id="subject_id" name="subject_id" value="0">
                        <input type="hidden" id="co_id" name="co_id" value="0">
                      </div>
                    </div>
                    <div class="col-2 pr-0">
                      <div class="form-group">
                        <label>Wt(%)</label>
                        <input type="number" class="form-control form-control-sm" id="co_weight" name="co_weight" placeholder="%">
                      </div>
                    </div>
                    <div class="col-1 pl-1 pr-1">
                      <div class="form-group">
                        <label>&nbsp;</label>
                        <a href="#" class="atag p-0 m-0 addCO" title="Save">
                          <h3><i class="fa fa-floppy-o"></i></h3>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <span class="largeText">CO-PO Map</span>
            <div class="card myCard p-2">
              <table class="table table-striped list-table-xs mt-3" id="copoTable">
                <tr class="align-center">
                  <th>Course Outcome Statement</th>
                  <?php
                  $sql = "select * from $tn_po where program_id='$myProg' and po_status='0' order by po_sno";
                  $result = $conn->query($sql);
                  if (!$result) echo $conn->error;
                  else {
                    while ($rowsArray = $result->fetch_assoc()) {
                  ?>
                      <th><span title="<?php echo $rowsArray['po_statement']; ?>">PO-<?php echo $rowsArray['po_sno']; ?></span></th>
                  <?php
                    }
                  }
                  ?>
                </tr>
              </table>
            </div>
          </div>
          <div class="tab-pane" id="choList" role="tabpanel" aria-labelledby="choList">
            <div class="row">
              <div class="col-md-9">
                <div class="card myCard">
                  <div class="card-body">
                    <table class="table table-bordered table-striped list-table-xs" id="choHeaderTable">
                      <tr>
                        <td width="20%">Institute/School/College Name</td>
                        <td colspan="3" width="80%"><span id="choSchoolName"></span></td>
                      </tr>
                      <tr>
                        <td>Department/Center Name</td>
                        <td colspan="3"><span id="choDeptName"></span></td>
                      </tr>
                      <tr>
                        <td>Program[Specialization] Name</td>
                        <td colspan="3"><span id="choProgramName"></span></td>
                      </tr>
                      <tr>
                        <td>Course Name</td>
                        <td><span id="choSubjectName"></span></td>
                        <td width="15%">Course Code</td>
                        <td><span id="choSubjectCode"></span></td>
                      </tr>
                      <tr>
                        <td>Semester</td>
                        <td><span id="choSubjectName"></span></td>
                        <td>Session</td>
                        <td><span id="choSubjectCode"></span></td>
                      </tr>
                      <tr>
                        <td>L/T/P</td>
                        <td><span id="choLTP"></span></td>
                        <td>Credit</td>
                        <td><span id="choCredit"></span></td>
                      </tr>
                      <tr>
                        <td>Coordinator</td>
                        <td><span id="choCOC"></span></td>
                        <td>Team</td>
                        <td><span id="choTeam"></span></td>
                      </tr>
                    </table>
                  </div>
                </div>

                <div class="card myCard mt-2">
                  <div class="card-body">
                    <table class="table table-bordered table-striped list-table-xs" id="choScopeTable">
                      <tr>
                        <td>
                          <p class="smallText">Scope and Objective</p>
                          <p id="choScope"></p>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>

                <div class="card myCard mt-2">
                  <div class="card-body">
                    <table class="table table-striped list-table-xs" id="choCOTable">
                      <tr class="align-center">
                        <th width="5%">SNo</th>
                        <th>Course Outcome</th>
                        <th width="5%">Wt(%)</th>
                      </tr>
                    </table>
                  </div>
                </div>

                <div class="card myCard mt-2">
                  <div class="card-body">
                    <table class="table table-striped list-table-xs mt-3" id="choCOPOTable">
                      <tr class="align-center">
                        <th>Course Outcome Statement</th>
                        <?php
                        $sql = "select * from $tn_po where program_id='$myProg' and po_status='0' order by po_sno";
                        $result = $conn->query($sql);
                        if (!$result) echo $conn->error;
                        else {
                          while ($rowsArray = $result->fetch_assoc()) {
                        ?>
                            <th><span title="<?php echo $rowsArray['po_statement']; ?>">PO-<?php echo $rowsArray['po_sno']; ?></span></th>
                        <?php
                          }
                        }
                        ?>
                      </tr>
                    </table>
                  </div>
                </div>

                <div class="card myCard mt-2">
                  <div class="card-body">
                    <table class="table table-bordered table-striped list-table-xs" id="choAssessmentTasksTable">
                      <tr>
                        <th>#</th>
                        <th>Tools</th>
                        <th>Marks</th>
                      </tr>
                    </table>
                  </div>
                </div>

                <div class="card myCard mt-2">
                  <div class="card-body">
                    <table class="table table-striped list-table-xs mt-1" id="choTaskToolTable">
                      <tr>
                        <th width="4%">#</th>
                        <th width="8%"> Task-Id</th>
                        <th width="8%">Temp-Id</th>
                        <th width="8%">Task #</th>
                        <th width="8%">Component</th>
                        <th width="20%">Task Name</th>
                        <th width="8%">Marks</th>
                        <th width="8%">Wt (%)</th>
                        <th width="8%">Questions</th>
                        <th>Publish Date</th>
                        <th>Submission Date</th>
                      </tr>
                    </table>
                  </div>
                </div>

                <div class="card myCard mt-2">
                  <div class="card-body">
                    <table class="table table-bordered table-striped list-table-xs" id="choContentTable">
                      <tr>
                        <td>
                          <p class="smallText">Syllabus</p>
                          <p id="choContent"></p>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-ap" role="tabpanel">
            <div class="row">
              <div class="col-md-12">
                <div class="card myCard p-2">
                  <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                    <!-- <li class="nav-item">
                      <a class="nav-link active" data-toggle="pill" href="#pills_help" role="tab">Check List</a>
                    </li> -->
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="pill" href="#pills_template" role="tab">Template</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link assessments" data-toggle="pill" href="#pills_assessments" role="tab">Assessment Tasks</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="pill" href="#taskList" id="tt" role="tab">Task Tools</a>
                    </li>
                    <!-- <li class="nav-item">
                      <a class="nav-link coScale" data-toggle="pill" href="#coScale" role="tab">Scale</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link coFB" data-toggle="pill" href="#coFB" role="tab">Feedback</a>
                    </li> -->
                  </ul>
                  <!-- content -->
                  <div class="tab-content" id="pills-tabContent p-3">
                    <p class="warning subName"></p>
                    <!-- <div class="tab-pane show active" id="pills_help" role="tabpanel">
                      <div class="row">
                        <div class="col-6">
                          <label>Subject Selected </label>
                          <span class="" id="subjectStatus"></span>
                        </div>
                        <div class="col-5">
                          <label>Template Attached </label>
                          <span class="fa fa-times" id="templateStatus"></span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12"><label>Tasks and Question marks</label></div>
                        <div class="col-12"><span id="marksMatchingStatus"></span></div>
                      </div>
                    </div> -->
                    <div class="tab-pane show active" id="pills_template" role="tabpanel">
                      <span class="subjectTemplate"></span>
                    </div>
                    <div class="tab-pane fade" id="pills_assessments" role="tabpanel">
                      <table class="table table-bordered table-striped list-table-xs" id="assessmentTasksTable">
                        <tr>
                          <th>#</th>
                          <th>Template</th>
                          <th>Tools</th>
                          <th>Marks</th>
                          <th>Tasks</th>
                        </tr>
                      </table>
                      <span class="footerNote">Please use the left and right double arrow to increase of decrease the assessment tasks. This will also populate the table required for selecting the assessment tool for the tasks. Please click on the left double arrow for only one task.</span>
                    </div>
                    <div class="tab-pane fade" id="taskList" role="tabpanel">
                      <div class="col-12">
                        <span class="smallerText">Weightage of marks is 100% if we are considering marks as it is for evaluation. It is 50% if we are allotting double. </span>
                      </div>
                      <table class="table table-striped list-table-xs mt-1" id="taskToolTable">
                        <tr>
                          <th width="4%">#</th>
                          <th width="8%"> Task-Id</th>
                          <th width="8%">Temp-Id</th>
                          <th width="8%">Task #</th>
                          <th width="8%">Component</th>
                          <th width="15%">Tool</th>
                          <th width="20%">Task Name</th>
                          <th width="8%">Marks</th>
                          <th width="8%">Wt (%)</th>
                          <th width="8%">Questions</th>
                          <th>Publish Date</th>
                          <th>Submission Date</th>
                          <th width="5%"><i class="fa fa-trash"></i></th>
                        </tr>
                      </table>
                    </div>
                    <div class="tab-pane fade" id="coScale" role="tabpanel">
                      <div class="row">
                        <div class="col-3">
                          <label>CO Scale</label>
                        </div>
                        <div class="col-9">
                          <p class="under-process">Please add the percentage of students scoring more than equal to X % marks.</p>
                        </div>
                      </div>
                      <form class="coScaleForm">
                        <div class="row">
                          <div class="col-3 pr-0">
                            <div class="form-group">
                              <label>High [3]</label>
                              <input type="number" class="form-control form-control-sm" id="cs_ha" name="cs_ha">
                            </div>
                          </div>
                          <div class="col-3 pl-1 pr-0">
                            <div class="form-group">
                              <label>Average [2]</label>
                              <input type="number" class="form-control form-control-sm" id="cs_aa" name="cs_aa">
                            </div>
                          </div>
                          <div class="col-3 pl-1 pr-0">
                            <div class="form-group">
                              <label>Low [1]</label>
                              <input type="number" class="form-control form-control-sm" id="cs_la" name="cs_la" value="0" disabled>
                            </div>
                          </div>
                          <div class="col-3 pl-1">
                            <div class="form-group">
                              <label>Marks[X]</label>
                              <input type="number" class="form-control form-control-sm" id="cs_marks" name="cs_marks" value="60" disabled>
                            </div>
                          </div>
                        </div>
                        <p class="smallerText">If 60,50 and 0 are added in the above for High, Average and Low respectively, it means that if atleast 60% of the students secure X % marks or more, then attainment is High. If less than 50% students secure X % marks, the attainment is Low and else it is Average attainment.</p>
                        <button class="btn btn-sm">Update</button>
                      </form>
                    </div>
                    <div class="tab-pane fade" id="pills_ts" role="tabpanel">
                      <label>Template-<span id="saTemplate"></span></label>
                      <table class="table table-bordered table-striped list-table-xs" id="taskListTable">
                        <tr>
                          <th>#</th>
                          <th>Tools</th>
                          <th>Task </th>
                          <th>Marks</th>
                          <th>Wt(%)</th>
                          <th>Start</th>
                          <th>Design</th>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-ad" role="tabpanel">
            <div class="row">
              <div class="col-md-12">
                <div class="card myCard p-2">
                  <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active qCo" data-toggle="pill" href="#pills_qCO" role="tab">Question Map</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link ps" data-toggle="pill" href="#pills_schedule" role="tab">Show/Upload Marks</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="pill" href="#pills_taskTemplate" role="tab">Task Template</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="pill" href="#pills_rubric" role="tab">Rubric</a>
                    </li>

                  </ul>
                  <!-- content -->
                  <div class="tab-content" id="pills-tabContent p-3">
                    <div class="row">
                      <div class="col-md-3 pr-0">
                        <p class="ataskSelect"></p>
                      </div>
                      <div class="col-md-4">
                        <p class="warning subName"></p>
                      </div>
                      <div class="col-md-3">
                        <p class="under-process">Assessment Tool - <span class="warning" id="tool_name">Not Selected </span></p>
                      </div>
                      <div class="col-md-2">
                        <p class="under-process">Task Number - <span class="warning" id="task_no">Not Selected</span></p>
                      </div>
                    </div>
                    <div class="tab-pane active" id="pills_qCO" role="tabpanel">
                      <div class="row border m-1">
                        <div class="col-2 pr-0">
                          <div class="form-group">
                            <label>QNo</label>
                            <input type="number" class="form-control form-control-sm" id="atq_sno" name="atq_sno" value="1" min="1">
                          </div>
                        </div>
                        <div class="col-2 pl-1 pr-0">
                          <div class="form-group">
                            <label>Marks</label>
                            <input type="number" class="form-control form-control-sm" id="atq_marks" name="atq_marks" placeholder="Q Marks" value="1" min="1">
                          </div>
                        </div>
                        <div class="col-3 pl-1 pr-0">
                          <div class="form-group">
                            <label>Difficulty Level (DL)</label>
                            <select class="form-control form-control-sm" id="atq_level" name="atq_level">
                              <option value="1">Easy</option>
                              <option value="2">Medium</option>
                              <option value="3">Difficult</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-3 pl-1 pr-0">
                          <div class="form-group">
                            <label>BT Level (BTL)</label>
                            <select class="form-control form-control-sm" id="atq_bt" name="atq_bt">
                              <option value="1">Remembering</option>
                              <option value="2">Understanding</option>
                              <option value="3">Applying</option>
                              <option value="4">Analyzing</option>
                              <option value="5">Evaluating</option>
                              <option value="6">Creating</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-2 pl-1 pr-1">
                          <div class="form-group">
                            <label>&nbsp;</label>
                            <br>
                            <input type="hidden" id="atm_id" name="atm_id" value="0">
                            <a href="#" class="largeText updateQuestionMap" title="Save"><i class="fa fa-floppy-o"></i></a>
                            <a href="#" class="largeText refreshQuestionMap" title="Refresh"><i class="fa fa-refresh"></i></a>
                          </div>
                        </div>
                      </div>
                      <table class="table table-bordered list-table-xs mt-3" id="questionTable">
                        <tr class="align-center">
                          <th width="5%">QNo</th>
                          <th width="40%">Statement</th>
                          <th width="5%">Marks</th>
                          <th width="5%">DL/BTL</th>
                          <th>CO</th>
                          <th width="5%"><i class="fa fa-trash"></i></th>
                        </tr>
                      </table>
                      <span class="footerNote">Only highet BT Level must be added.</span>
                    </div>
                    <div class="tab-pane fade" id="pills_schedule" role="tabpanel">
                      <div class="row">
                        <div class="col-5">
                          <div id="qCOCheck"></div>
                        </div>
                        <div class="col-7">
                          <label>Please select the Task Number from <span class="under-process">Assessments</span> >> <span class="under-process">Design</span> to display Task Marks </label>
                          <p><label><span class="qMapNote"></span></label></p>
                          <label> The marks of the questions will be considered only if the questions are mapped with BT Level and Course Outcome. </label>
                          <input type="hidden" id="atask_id">
                          <button class="btn uploadMarks" id="errorFlag">Upload Marks</button>
                        </div>
                      </div>

                      <table class="table table-bordered table-striped list-table-xs mt-3" id="taskMarksTable">
                        <tr>
                          <th>#</th>
                          <th>RollNo</th>
                          <th>Marks</th>
                        </tr>
                      </table>
                    </div>
                    <div class="tab-pane fade" id="pills_taskTemplate" role="tabpanel">
                      <label>Not Subscribed</label>
                      <!-- <form class="taskTemplate">
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group">
                              <label>Nature</label>
                              <textarea class="form-control form-control-sm" id="task_nature" name="task_marks" placeholder="Marks of the Task"></textarea>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group">
                              <label>Objective</label>
                              <textarea class="form-control form-control-sm" id="task_objective" name="task_weight" placeholder="Objective of the Assessment Task"></textarea>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label>Publish Date</label>
                              <input type="date" class="form-control form-control-sm" id="task_publish_date" name="task_date" value="<?php echo $submit_date; ?>">
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label>Submission Date</label>
                              <input type="date" class="form-control form-control-sm" id="task_submission_date" name="task_date" value="<?php echo $submit_date; ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group">
                              <label>Instructions</label>
                              <textarea class="form-control form-control-sm" id="task_objective" name="task_weight" placeholder="Objective of the Assessment Task"></textarea>
                            </div>
                          </div>
                        </div>
                      </form> -->
                    </div>
                    <div class="tab-pane fade" id="pills_rubric" role="tabpanel">
                      <label>Not Subscribed</label>
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
    </div>
  </div>
  <?php require("../bottom_bar.php"); ?>
</body>
<script src="https://cdn.tiny.cloud/1/xjvk0d07c7h90fry9yq9z0ljb019ujam91eo2jk8uhlun307/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
  tinymce.init({
    selector: 'vkj',
    plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    toolbar_mode: 'floating',
    height: "520",
  });
</script>
<script>
  $(document).ready(function() {
    $(function() {
      $(document).tooltip();
    });

    $(".subName").text("Subject Not Selected")

    // Top Subject List Bar
    myLoadList();

    function myLoadList() {
      // $.alert('hello');
      $.post("coaSql.php", {
        action: "mySubject",
      }, () => {}, "json").done(function(data, status) {
        var card = '';
        var count = 1;
        // $.alert(data);
        card += '<div class="row">';
        $.each(data, function(key, value) {
          var status = value.subject_status
          if (status != null) {
            card += '<div class="col-md-3">';
            card += '<a href="#" class="subjectEdit fa fa-pencil-alt" data-id="' + value.subject_id + '" data-subName="' + value.subject_name + '">';
            card += ' ' + value.subject_code;
            // card += ' : ' + value.subject_name;
            card += '</a>';
            // card += '<span class="fa fa-plus-circle mt-2"></span>';
            // card += '<span class="fa fa-bar-chart mt-2"></span>';
            card += '</div>';
          }
        });
        card += '</div>';
        $("#mySubject").append(card);
      }).fail(function() {
        $.alert("Test is Not Responding");
      })
    }

    $(document).on("click", ".subjectEdit", function() {
      var id = $(this).attr("data-id")

      $(".subjectEdit").removeClass('fa-circle').addClass('fa-pencil-alt')
      $(this).removeClass('fa-pencil-alt').addClass('fa-circle')

      // $.alert("Edit - Fetch " + id);
      $("#subject_id").val(id);
      $("#content_sub").val(id); //For content
      $("#scope_sub").val(id); //For content
      coList(id);
      copoMap(id);
      var name = $(this).attr("data-subName");
      $("#subject_name").val(name)
      $.post("coaSql.php", {
        id: id,
        action: "fetchSubjectTemplate"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var card = '';
        var count = 1;
        // $.alert(data.check);
        card += '<div class="row">'

        $.each(data, function(key, value) {
          var check = value.check;
          card += '<div class="col-md-2">'
          card += '<table class="table table-bordered table-striped list-table-xs">'
          card += '<tr>';
          if (check == '1') card += '<td><input type="radio" class="radioAtmp" checked data-id="' + value.atmp_template + '" name="radioAtmp">';
          else card += '<td><input type="radio" class="radioAtmp" data-id="' + value.atmp_template + '" name="radioAtmp">';
          card += ' Template-' + value.atmp_template;
          card += '</td>';
          card += '</tr>';
          card += '<tr>';
          card += '<td>' + value.text + '</td>';
          card += '</tr>';
          card += '</table>';
          card += '</div>';
        });
        card += '</div>';
        $(".subjectTemplate").html(card);
        $(".subName").text(name + "[" + id + "]")
        assessmentComponentList();
        ataskSelect();
        checkTemplate();
        checkQuestionMarks();
        fetchCOScale()

        $.post("coaSql.php", {
          subject_id: id,
          action: "fetchContent"
        }, function() {}, "json").done(function(data, status) {
          //$.alert("Fecth" + data.content);
          tinyMCE.get('content').setContent(data.content)
          tinyMCE.get('scope').setContent(data.scope)
          $("#choScope").html(data.scope)
          $("#choContent").html(data.content)
        }).fail(function() {
          $.alert("Error !!");
        })
        subjectTopicList()
        resourceList();
      })
    })

    function copoMap(id) {
      // $.alert("In CO-PO Map" + id);
      $.post("coaSql.php", {
        id: id,
        action: "copoMap"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data)
        var copoCard = '';
        var count = 1;
        $.each(data, function(key, value) {
          $.each(this, function(value, co) {
            var co_id = co.co_id;
            copoCard += '<tr>';
            copoCard += '<td>' + co.co + '</td>';
            var arrayLength = co.po.length
            for (i = 0; i < arrayLength; i++)
              copoCard += '<td class="click"><a class="under-process topBarText updateScale" data-co="' + co_id + '" data-po="' + co.po_id[i] + '" id="co' + co_id + 'po' + co.po_id[i] + '">' + co.po[i] + '</a></td>';
            copoCard += '</tr>';
          })
        })
        $("#copoTable").find("tr:gt(0)").remove();
        $("#copoTable").append(copoCard);

        var copoCard = '';
        var count = 1;
        $.each(data, function(key, value) {
          $.each(this, function(value, co) {
            var co_id = co.co_id;
            copoCard += '<tr>';
            copoCard += '<td>' + co.co + '</td>';
            var arrayLength = co.po.length
            for (i = 0; i < arrayLength; i++)
              copoCard += '<td>' + co.po[i] + '</td>';
            copoCard += '</tr>';
          })
        })
        $("#choCOPOTable").find("tr:gt(0)").remove();
        $("#choCOPOTable").append(copoCard);

      })
    }

    // Scope Block

    $(document).on("submit", "#scopeForm", function() {
      event.preventDefault(this);
      if ($("#scope_sub").val() > 0) {
        var formData = $(this).serialize();
        // $.alert("Form Submitted " + formData)
        $.post("coaSql.php", formData, function() {}, "text").done(function(data, success) {
          $.alert(data)
        })
      } else $.alert(" Please select a Subject !!")
    });

    // Content Block

    $(document).on("submit", "#contentForm", function() {
      event.preventDefault(this);
      if ($("#content_sub").val() > 0) {
        var formData = $(this).serialize();
        // $.alert("Form Submitted " + formData)
        $.post("coaSql.php", formData, function() {}, "text").done(function(data, success) {
          // $.alert(data)
        })
      } else $.alert(" Please select a Subject !!")
    });

    $(document).on('click', '#submit_sbt', function() {
      var subject_id = $("#content_sub").val()
      var sbt_syllabus = $("input[name='sbt_syllabus']:checked").val();
      var sbt_name = $("#sbt_name").val();
      var sbt_weight = $("#sbt_weight").val();
      var sbt_slot = $("#sbt_slot").val();
      var sbt_unit = $("#sbt_unit").val();
      var sbt_type = $("#sbt_type").val();
      $.alert("Name " + sbt_name + " Subject " + subject_id);
      $.post("coaSql.php", {
        subject_id: subject_id,
        sbt_name: sbt_name,
        sbt_weight: sbt_weight,
        sbt_slot: sbt_slot,
        sbt_unit: sbt_unit,
        sbt_syllabus: sbt_syllabus,
        sbt_type: "L",
        action: "addST"
      }, function() {}, "text").done(function(data, status) {
        $.alert("Success " + data);
        subjectTopicList()
      }).fail(function(data, status) {
        $.alert(" Error !! ");
      })
    });

    $(document).on('click', '.showSubjectTopic', function() {
      $(".subjectCoverage").hide();
      $(".subjectResource").hide();
      $(".studentList").hide();
      // $.alert("Show Subject Topic");
      subjectTopicList();
      $(".subjectTopics").show();

    });

    function subjectTopicList() {
      var subject_id = $("#content_sub").val()
      //$.alert("In List Function" + tlId);
      $.post("coaSql.php", {
        subject_id: subject_id,
        action: "stList"
      }, function() {}, "text").done(function(data, status) {
        $('#subjectTopicList').html(data)
      }).fail(function() {
        $.alert("Error !!");
      })
    }

    // Resources

    $(document).on('click', '#submit_sbResource', function() {
      var subject_id = $("#content_sub").val()
      var sbr_type = $("input[name='sbr_type']:checked").val();
      var sbr_name = $("#sbr_name").val();
      var sbr_url = $("#sbr_url").val();
      var mn_id = $("#sel_mn").val();
      // $.alert("Name " + sbr_name + " subject_id " + subject_id + " url " + sbr_url + " mn " + mn_id + " sbr_type " + sbr_type);
      $.post("coaSql.php", {
        subject_id: subject_id,
        sbr_name: sbr_name,
        sbr_url: sbr_url,
        sbr_type: sbr_type,
        mn_id: mn_id,
        action: "addRes"
      }, function() {}, "text").done(function(data, status) {
        $.alert("Success " + data);
        resourceList();
      }).fail(function() {
        $.alert("Error !!");
      })
    });

    function resourceList() {
      var subject_id = $("#content_sub").val()
      // $.alert("Subject Id - Resource Function" + subject_id);
      $.post("coaSql.php", {
        subject_id: subject_id,
        action: "resList"
      }, function() {}, "text").done(function(data, status) {
        // $.alert("Success " + data);
        $('#resourceList').html(data)
      }).fail(function() {
        $.alert("Error !!");
      })
    }

    $(document).on('click', '.srUpload', function() {
      var x = $(this).attr('data-sr');
      // $.alert("Inst " + x);
      $('#sr_idHidden').val(x);
      $('#srUploadModal').modal('show');
    });

    $(document).on('submit', '#srUploadModalForm', function(event) {
      event.preventDefault();
      var formData = $(this).serialize();
      $.alert(formData);
      // action and test_id are passed as hidden
      $.ajax({
        url: "uploadDocSql.php",
        method: "POST",
        data: new FormData(this),
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false
        success: function(data) {
          $.alert(data);
          $('#srUploadModal').modal('hide');
        }
      })
    });

    // Books and Journals
    $(document).on('click', '#submit_sbBook', function() {
      var subject_id = $("#content_sub").val()
      if (subject_id > 0) {
        var sbk_type = $("input[name='sbk_type']:checked").val();
        var sbk_name = $("#sbk_name").val();
        var sbk_publisher = $("#sbk_publisher").val();
        var sbk_author = $("#sbk_author").val();
        var sbk_isbn = $("#sbk_isbn").val();
        var sbk_doi = $("#sbk_doi").val();
        var sbk_edition = $("#sbk_edition").val();
        $.alert(" subject_id in Book " + subject_id + " DOI " + sbk_doi);
        $.post("coaSql.php", {
          subject_id: subject_id,
          sbk_type: sbk_type,
          sbk_name: sbk_name,
          sbk_publisher: sbk_publisher,
          sbk_author: sbk_author,
          sbk_isbn: sbk_isbn,
          sbk_doi: sbk_doi,
          sbk_edition: sbk_edition,
          action: "addBook"
        }, function() {}, "text").done(function(data, status) {
          $.alert(data);
          // bookList();
        }).fail(function() {
          $.alert("Error !!");
        })
      } else $.alert("Subject Not Selected !!")
    });

    $(document).on('click', "#bookList", function() {
      var bookListClass = $(this).attr("class")
      // $.alert(bookListClass)
      if ($(this).hasClass("fa-eye")) bookList()

      $(this).toggleClass("fa-eye fa-eye-slash"); //you can list several class names 

    });

    function bookList() {
      var subject_id = $("#content_sub").val()
      // $.alert("Subject Id - Book Function" + subject_id);
      $.post("coaSql.php", {
        subject_id: subject_id,
        action: "bookList"
      }, function() {}, "text").done(function(data, status) {
        // $.alert("Success " + data);
        $('#subjectBooks').html(data)
      }).fail(function() {
        $.alert("Error !!");
      })
    }
    // Template Block

    $(document).on('submit', '#atmpForm', function(event) {
      event.preventDefault(this);
      var formData = $(this).serialize();
      //$.alert(formData);
      $.post("coaSql.php", formData, () => {}, "text").done(function(data, status) {
        //$.alert("List Updtaed" + data);
        atmpList();
        selectTemplate();
      })
    });

    atmpList();

    function atmpList() {
      //$.alert("In List Function" + grid);
      $.post("coaSql.php", {
        action: "atmpList"
      }, function() {}, "text").done(function(data, status) {
        //$.alert(data);
        $("#atmpList").html(data);
      }).fail(function() {
        $.alert("Error !!");
      })
    }

    selectTemplate();

    function selectTemplate() {
      //$.alert("In List Function");
      $.post("coaSql.php", {
        action: "selectTemplate"
      }, function() {}, "text").done(function(data, status) {
        //$.alert(data);
        $("#selectTemplate").html(data);
      }).fail(function() {
        $.alert("Error !!");
      })
    }

    checkTemplate();
    // CheckList Function
    function checkTemplate() {
      var subject_id = $("#subject_id").val();
      // $.alert(" Subject  Id " + subject_id);
      if (subject_id == 0) {
        $("#subjectStatus").removeClass('fa fa-check')
        $("#subjectStatus").addClass('fa fa-times')
      } else {
        $("#subjectStatus").removeClass('fa fa-times')
        $("#subjectStatus").addClass('fa fa-check')
        $.post("coaSql.php", {
          subject_id: subject_id,
          action: "checkTemplate"
        }, () => {}, "json").done(function(data, status) {
          // $.alert(data.sat_id)
          if (data.sat_id > 0) {
            $("#templateStatus").removeClass('fa fa-times')
            $("#templateStatus").addClass('fa fa-check')
          } else {
            $("#templateStatus").removeClass('fa fa-check')
            $("#templateStatus").addClass('fa fa-times')
          }
        });
      }
    }

    function checkQuestionMarks() {
      var subject_id = $("#subject_id").val();
      // $.alert(" Subject  Id " + subject_id);
      $.post("coaSql.php", {
        subject_id: subject_id,
        action: "checkQuestionMarks"
      }, () => {}, "text").done(function(data, status) {
        // $.alert(data)
      });
    }

    // CO Scale Block - Sub-block of Assessment Pill
    $(document).on("click", ".coScale", function() {
      fetchCOScale()
    });
    $(document).on("submit", ".coScaleForm", function() {
      event.preventDefault();
      var subject_id = $("#subject_id").val();
      //$.alert("Subject Id " + subject_id)
      if (subject_id == 0) $.alert("<span class='warning'>Please select a Subject to Proceed!!</span>");
      else {
        $.post("coaSql.php", {
          cs_ha: $("#cs_ha").val(),
          cs_la: $("#cs_la").val(),
          cs_aa: $("#cs_aa").val(),
          cs_marks: $("#cs_marks").val(),
          subject_id: subject_id,
          action: "updateCOScale"
        }, function() {}, "text").done(function(data, status) {
          $.alert(data);
        })
      }
    });

    function fetchCOScale() {
      var subject_id = $("#subject_id").val();
      //$.alert("Subject Id " + subject_id)
      if (subject_id == 0) $.alert("<span class='warning'>Please select a Subject to Proceed!!</span>");
      else {
        $.post("coaSql.php", {
          subject_id: subject_id,
          action: "coScale"
        }, function() {}, "json").done(function(data, status) {
          // $.alert(data);
          // $.alert(data.cs_ha);
          $("#cs_ha").val(data.cs_ha)
          $("#cs_aa").val(data.cs_aa)
          $("#cs_la").val(data.cs_la)
        })
      }
    }

    // Task List
    $(document).on("click", "#tt", function() {
      taskList()
    });

    function taskList() {
      var subject_id = $("#subject_id").val()
      // $.alert("Assessment " + subject_id);
      $.post("coaSql.php", {
        subject_id: subject_id,
        action: "taskList",
      }, () => {}, "json").done(function(data, status) {
        var card = '';
        var count = 1;
        // $.alert(data);
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td class="text-center">' + count++ + '</td>';
          card += '<td class="text-center">' + value.atask_id + '</td>';
          card += '<td class="text-center">' + value.atmp_template + '</td>';
          card += '<td class="text-center">' + value.atask_sno + '</td>';
          card += '<td>' + value.atmp_internal + '</td>';
          card += '<td>' + value.text + '</td>';
          card += '<td><input type="text" class="form-control form-control-sm taskList" data-tag="atask_name" data-task="' + value.atask_id + '" id="n' + value.atask_id + '" value="' + value.atask_name + '"></td>';
          card += '<td><input type="number" min="1" class="form-control form-control-sm taskList" data-tag="atask_marks" data-task="' + value.atask_id + '" id="m' + value.atask_id + '" value="' + value.atask_marks + '"></td>';
          card += '<td><input type="number" min="1" class="form-control form-control-sm taskList" data-tag="atask_weight" data-task="' + value.atask_id + '" id="w' + value.atask_id + '" value="' + value.atask_weight + '"></td>';
          card += '<td><input type="number" min="1" class="form-control form-control-sm taskList" data-tag="atask_question" data-task="' + value.atask_id + '" id="q' + value.atask_id + '" value="' + value.atask_question + '"></td>';
          card += '<td><input type="date" class="form-control form-control-sm taskList" data-tag="atask_publish" data-task="' + value.atask_id + '" id="p' + value.atask_id + '" value="' + value.atask_publish + '"></td>';
          card += '<td><input type="date" class="form-control form-control-sm taskList" data-tag="atask_submission" data-task="' + value.atask_id + '" id="s' + value.atask_id + '" value="' + value.atask_submission + '"></td>';
          if (value.atask_status == '0') card += '<td><a class="fa fa-trash trashTask" data-task="' + value.atask_id + '" data-toggle="tooltip" data-placement="top" title="Remove Task from the List"></a></td>';
          else card += '<td><a class="fa fa-refresh resetTask" data-task="' + value.atask_id + '" data-toggle="tooltip" data-placement="top" title="Reset the Task"></a></td>';
          card += '</tr>';
        });
        $("#taskToolTable").find("tr:gt(0)").remove()
        $("#taskToolTable").append(card);

        var card = '';
        var count = 1;
        // $.alert(data);
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td class="text-center">' + count++ + '</td>';
          card += '<td class="text-center">' + value.atask_id + '</td>';
          card += '<td class="text-center">' + value.atmp_template + '</td>';
          card += '<td class="text-center">' + value.atask_sno + '</td>';
          card += '<td>' + value.atmp_internal + '</td>';
          card += '<td>' + value.atask_name + '</td>';
          card += '<td>' + value.atask_marks + '</td>';
          card += '<td>' + value.atask_weight + '</td>';
          card += '<td>' + value.atask_question + '</td>';
          card += '<td>' + value.atask_publish + '</td>';
          card += '<td>' + value.atask_submission + '</td>';
          card += '</tr>';
        });
        $("#choTaskToolTable").find("tr:gt(0)").remove()
        $("#choTaskToolTable").append(card);

      }).fail(function() {
        $.alert("Test is Not Responding");
      })
    }

    $(document).on("blur", ".taskList", function() {
      var atask_id = $(this).attr('data-task');
      var tag = $(this).attr("data-tag");
      if (tag == 'atask_marks') var value = $("#m" + atask_id).val();
      else if (tag == 'atask_weight') var value = $("#w" + atask_id).val();
      else if (tag == 'atask_publish') var value = $("#p" + atask_id).val();
      else if (tag == 'atask_question') var value = $("#q" + atask_id).val();
      else if (tag == 'atask_name') var value = $("#n" + atask_id).val();
      else var value = $("#s" + atask_id).val();
      // $.alert(" Task  " + atask_id + " Tag  " + tag + " Value " + value)
      $.post("coaSql.php", {
        atask_id: atask_id,
        tag: tag,
        value: value,
        action: "updateTask"
      }, function() {}, "text").done(function(data, status) {
        // $.alert(data);
      })
    });

    $(document).on("change", ".ataskTool", function() {
      var tag = $(this).attr("data-tag");
      var value = $("#" + tag).val()
      $.alert(" Tag  " + tag + " Value " + value)
      $.post("coaSql.php", {
        atask_id: tag,
        tag: "atask_tool",
        value: value,
        action: "updateTask"
      }, function() {}, "text").done(function(data, status) {
        // $.alert(data);
      })
    });

    $(document).on("click", ".trashTask", function() {
      var atask_id = $(this).attr("data-task");
      $.alert(' atask ' + atask_id);
      $.confirm({
        title: 'Please Confirm!',
        draggable: true,
        content: "<b><i>The Selected Task will be removed !!</i></b>",
        buttons: {
          confirm: {
            btnClass: 'btn-info',
            action: function() {
              $.post("coaSql.php", {
                atask_id: atask_id,
                action: "deleteTask"
              }, () => {}, "text").done(function(data, status) {
                // $.alert(data);
              })
              taskList()
            }
          },
          cancel: {
            btnClass: "btn-danger",
            action: function() {}
          },
        }
      });
    });

    // Assessment Task Dsign Block - Sub-block of Assessment Pill

    function ataskSelect() {
      //$.alert("In List Function");
      var subject_id = $("#subject_id").val();
      $.post("coaSql.php", {
        subject_id: subject_id,
        action: "ataskSelect"
      }, function() {}, "text").done(function(data, status) {
        // $.alert(data);
        $(".ataskSelect").html(data);
      }).fail(function() {
        $.alert("Error !!");
      })
    }

    $(document).on("click", ".refreshQuestionMap", function() {
      questionMap()
    })
    $(document).on("click", ".updateQuestionMap", function() {
      var atask_id = $("#sel_atask").val();
      var atq_sno = $("#atq_sno").val();
      var atq_marks = $("#atq_marks").val();
      var atq_level = $("#atq_level").val();
      var atq_bt = $("#atq_bt").val();
      // $.alert("Assessement Task Id " + atask_id + " Marks " + atq_marks + " Level " + atq_level);
      $.post("coaSql.php", {
        atask_id: atask_id,
        atq_sno: atq_sno,
        atq_marks: atq_marks,
        atq_level: atq_level,
        atq_bt: atq_bt,
        action: "updateQuestionMap"
      }, function() {}, "text").done(function(data, status) {
        // $.alert(data);
        questionMap()
      })
    });

    function questionMap() {
      var atask_id = $("#sel_atask").val();
      $.alert("Assessement Task Id " + atask_id);
      $.post("coaSql.php", {
        atask_id: atask_id,
        action: "questionMap",
      }, () => {}, "json").done(function(data, status) {
        var card = '';
        var count = 1;
        // $.alert(data);
        $.each(data, function(key, value) {
          $.each(this, function(value, question) {
            var atask_id = question.atask_id;
            card += '<tr>';
            card += '<td>' + question.atq_sno + '</td>';
            card += '<td>--</td>';
            card += '<td>' + question.atq_marks + '</td>';
            card += '<td>' + question.atq_level + '<br>' + question.atq_bt + '</td>';
            var arrayLength = question.weight.length
            card += '<td><table class="table list-table-xx"><tr>';
            cosno = 0;
            for (i = 0; i < arrayLength; i++) {
              cosno++;
              var atask_id = $("#sel_atask").val();
              card += '<td>CO' + question.co_sno[i] + '<input class="form-control form-control-sm updateWeight" value="' + question.weight[i] + '"  data-atask="' + atask_id + '" data-question="' + question.atq_sno + '" data-co="' + question.co_id[i] + '" id="t' + atask_id + 'q' + question.atq_sno + 'c' + question.co_id[i] + '" ></td>';
            }
            card += '</tr></table></td>'
            card += '<td><a class="fa fa-trash trashQuestion" data-atask="' + atask_id + '" data-question="' + question.atq_sno + '"> </a></td>';
            card += '</tr>';
          })
        })
        $("#questionTable").find("tr:gt(0)").remove()
        $("#questionTable").append(card);
      }).fail(function() {
        $("#questionTable").find("tr:gt(0)").remove()
        $.alert("No Question Found!!");
      })
    }

    $(document).on("click", ".ps", function() {
      var atask_id = $("#sel_atask").val();
      $.alert(" Task  " + atask_id)
      $.post("coaSql.php", {
        atask_id: atask_id,
        action: "fetchQMapSummary"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        console.log(data)
        // $.alert(data.question);
        var text = '';
        var count = 1;
        var errorFlag = 'DN';
        if (data.question == '0') {
          errorFlag = "UP";
          $(".qMapNote").html("No Question Added. Please Add the Question Map to Proceed")
        } else $(".qMapNote").html("Questions Added through Question Map : " + data.question)
        var questions = data.weight.length;
        text += '<table class="table list-table-xs">'
        text += '<tr class="text-center"><th>Question</th><th> CO Weightage </th><th> Marks </th><th> Remarks </th></tr>'
        for (i = 0; i < questions; i++) {
          text += '<tr>';
          text += '<td>' + count++ + '</td>';
          text += '<td>' + data.weight[i] + '</td>';
          text += '<td>' + data.marks[i] + '</td>';
          if (data.weight[i] == '100') text += '<td class="approve">OK</td>';
          else {
            text += '<td class="warning">Error</td>';
            errorFlag = "UP";
          }
          text += '</tr>';
        }
        text += '</table>';
        text += '<table class="table list-table-xs"><tr>';
        text += '<td><span class="largeText">Assessment Task Marks ' + data.taskMarks + '</span></td>';
        text += '<td><span class="largeText">Total Question Marks ' + data.totalQuestionMarks + '</span></td>';
        if (data.totalQuestionMarks == data.taskMarks) text += '<td class="approve">OK</td>';
        else {
          text += '<td class="warning">Error</td>';
          errorFlag = "UP";
        }
        text += '<tr></table>';

        $("#errorFlag").val(errorFlag);
        $("#qCOCheck").html(text)
      })
    });
    $(document).on("blur", ".updateWeight", function() {
      var task_id = $(this).attr('data-atask');
      var question = $(this).attr('data-question');
      var co_id = $(this).attr('data-co');
      var weight = $("#t" + task_id + "q" + question + "c" + co_id).val();
      // $.alert(" Task  " + task_id + " Question " + question + weight)
      $.post("coaSql.php", {
        atask_id: task_id,
        atq_sno: question,
        co_id: co_id,
        weight: weight,
        action: "updateQuestionCOMap"
      }, function() {}, "text").done(function(data, status) {
        // $.alert(data);
      })
    });

    $(document).on('click', '.uploadMarks', function() {
      var errorFlag = $("#errorFlag").val()
      if (errorFlag == 'UP') $.alert("Please Adjust the CO Weightage to Proceed!!")
      else {
        var atask_id = $("#sel_atask").val();
        var task_marks = $("#task_marks").val();
        var task_weight = $("#task_weight").val();
        // $.alert("Task Id " + atask_id + "Error Flag" + errorFlag);
        var message = "";
        if (atask_id == 0) message += '<li class="warning">Please Select the Assessment Task to Proceed!</li>';
        if (task_marks < 1) message += '<li class="warning">Please Save the Task Marks before you upload Question Marks !</li>';
        if (atask_id == 0 || task_marks < 1) $.alert(message)
        else {
          $('#uploadModal').modal('show');
          $('#modalTaskId').val(atask_id);
        }
      }
    });
    $(document).on('submit', '#upload_csvMarks', function(event) {
      event.preventDefault();
      var formData = $(this).serialize();
      //$('#subjectList').hide();
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
          $.alert(data);
          taskMarks();
        }
      })
      $("#upload_csvMarks")[0].reset;
      $('#uploadModal').modal('hide');
    });
    $(document).on("click", ".trashQuestion", function() {
      var atask_id = $(this).attr("data-atask")
      var atq_sno = $(this).attr("data-question")
      $.alert(' atask ' + atask_id + "atq_sno" + atq_sno);
      $.post("coaSql.php", {
        atask_id: atask_id,
        atq_sno: atq_sno,
        action: "deleteQuestion"
      }, () => {}, "text").done(function(data, status) {
        // $.alert(data);
        questionMap()
      })
    });

    $(document).on("click", ".trashColumn", function() {
      var atask_id = $("#sel_atask").val();
      var atq_sno = $(this).attr("data-question")
      // $.alert(' atask ' + atask_id + "atq_sno" + atq_sno);
      $.confirm({
        title: 'Please Confirm!',
        draggable: true,
        content: "<b><i>This will Delete Complete Column of Marks !!</i></b>",
        buttons: {
          confirm: {
            btnClass: 'btn-info',
            action: function() {
              $.post("coaSql.php", {
                atask_id: atask_id,
                atq_sno: atq_sno,
                action: "deleteMarks"
              }, () => {}, "text").done(function(data, status) {
                // $.alert(data);
              })
              taskMarks()
            }
          },
          cancel: {
            btnClass: "btn-danger",
            action: function() {}
          },
        }
      });
    });

    function taskMarks() {
      var atask_id = $("#sel_atask").val();
      // $.alert(' atask ' + atask_id);
      $.post("coaSql.php", {
        atask_id: atask_id,
        action: "taskMarksList"
      }, () => {}, "json").done(function(data, status) {
        // $.alert(data);
        var card = '';
        var count = 0;
        $.each(data, function(key, value) {
          if (count == 0) {
            card += '<tr>';
            card += '<td colspan="2" class=" text-right"><span class="warning">Delete Column Marks is Active </span></td>';
            var arrayLength = value.marks.length
            for (i = 0; i < arrayLength; i++)
              card += '<td>Q.' + value.qno[i] + ' <a class="fa fa-trash trashColumn" data-question="' + value.qno[i] + '" data-toggle="tooltip" data-placement="top" title="Tooltip on top"></a></td>';
            card += '</tr>';
            count++;
          }
          card += '<tr>';
          card += '<td>' + count++ + '</td>';
          card += '<td>' + value.student_rollno + '</td>';
          var arrayLength = value.marks.length
          for (i = 0; i < arrayLength; i++)
            card += '<td>' + value.marks[i] + '</td>';
          card += '</tr>';
        });
        $("#taskMarksTable").find("tr:gt(0)").remove()
        $("#taskMarksTable").append(card);
      }).fail(function() {
        $("#taskMarksTable").find("tr:gt(0)").remove()
        $.alert("Marks Not Found");
      })
    }

    // Assessment Pill
    $(document).on("click", ".assessments", function() {
      var subject_id = $("#subject_id").val();
      // $.alert(subject_id)
      if (subject_id == 0) $.alert("<span class='warning'>Please select a Subject to Proceed!!</span>");
      else assessmentComponentList();
    });
    $(document).on("click", ".increDecre", function() {
      var id = $(this).attr('data-id');
      var value = $(this).attr("data-value");
      var tag = $(this).attr("data-tag");
      // $.alert("Id " + id + " Value " + value + " Tag " + tag);
      $.post("coaSql.php", {
        id: id,
        value: value,
        tag: tag,
        action: "updateAssessmentNumber"
      }, function() {}, "text").done(function(data, status) {
        $.alert(data);
        assessmentComponentList();

      })
    });

    function assessmentComponentList() {
      // $.alert('hello');
      $.post("coaSql.php", {
        action: "fetchAssessmentTasks",
      }, () => {}, "json").done(function(data, status) {
        var card = '';
        var count = 1;
        // $.alert(data);
        $.each(data, function(key, value) {
          var assessments = value.sbas_assessments;
          var plusValue = parseInt(assessments) + 1;
          var minusValue = parseInt(assessments) - 1;
          if (minusValue == 0) minusValue = 1;
          card += '<tr>';
          card += '<td class="text-center">' + count++ + '</td>';
          card += '<td class="text-center">' + value.template_id++ + '</td>';
          card += '<td>' + value.atmp_internal + '</td>';
          card += '<td class="text-center">' + value.atmp_weightage + '</td>';
          card += '<td>';
          card += '<a href="#" class="increDecre" data-id="' + value.atmp_id + '" data-value="' + minusValue + '" data-tag="assessment"><i class="fa fa-angle-double-left"></i></a>';
          card += '<span>' + assessments + '</span>';
          card += '<a href="#" class="increDecre" data-id="' + value.atmp_id + '" data-value="' + plusValue + '"  data-tag="assessment"><i class="fa fa-angle-double-right"></i></a>';
          card += '</td>';
          card += '</tr>';
        });
        $("#assessmentTasksTable").find("tr:gt(0)").remove()
        $("#assessmentTasksTable").append(card);

        var card = '';
        var count = 1;
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td class="text-center">' + count++ + '</td>';
          card += '<td>' + value.atmp_internal + '</td>';
          card += '<td class="text-center">' + value.atmp_weightage + '</td>';
          card += '</tr>';
        });
        $("#choAssessmentTasksTable").find("tr:gt(0)").remove()
        $("#choAssessmentTasksTable").append(card);

      }).fail(function() {
        $.alert("Unable to fetch Assessment Components");
      })
    }

    $(document).on("click", ".radioAtmp", function() {
      var id = $(this).attr("data-id")
      // $.alert("Radio Atmp " + id);

      $.confirm({
        title: 'Confirm!',
        draggable: true,
        content: "Changing Template Remove All the Data Related with Previous Template !!<br> Think before you Proceed!! ",
        buttons: {
          confirm: {
            btnClass: 'btn-blue',
            action: function() {
              $.post("coaSql.php", {
                id: id,
                action: "setSubjectTemplate"
              }, function() {}, "text").done(function(data, status) {
                //$.alert(data);
              })
            }
          },
          cancel: {
            btnClass: "btn-danger",
            action: function() {}
          },
        }
      });
    });


    //Course Outcome
    $(document).on("click", ".trashCO", function() {
      var id = $("#subject_id").val();
      var co_id = $(this).attr("data-co")
      // $.alert(' CO  ' + co_id + " Sub id " + id);
      $.confirm({
        title: 'Please Confirm!',
        draggable: true,
        content: "<b><i>Are you sure to Delete CO !!</i></b>",
        buttons: {
          confirm: {
            btnClass: 'btn-info',
            action: function() {
              $.post("coaSql.php", {
                id: co_id,
                action: "deleteCO"
              }, () => {}, "text").done(function(data, status) {
                // $.alert(data);
              })
              coList(id)
            }
          },
          cancel: {
            btnClass: "btn-danger",
            action: function() {}
          },
        }
      });


    });

    $(document).on('click', '.addCO', function() {
      var id = $("#subject_id").val();
      var co_statement = $("#co_statement").val();
      var co_sno = $("#co_sno").val();
      var co_id = $("#co_id").val();
      var co_weight = $("#co_weight").val();
      if (co_sno > 0 && co_statement.length > 10 && id > 0) {
        // $.alert("Subject Id " + co_weight);
        $.post("coaSql.php", {
          id: id,
          co_sno: co_sno,
          co_id: co_id,
          co_weight: co_weight,
          co_statement: co_statement,
          action: "addCO"
        }, function() {}, "text").done(function(data, status) {
          $.alert(data);
          $("#co_id").val("0");
          $("#co_sno").val("");
          $("#co_statement").val("");
          $("#co_weight").val("");
          coList(id);
        })
      } else {
        $msg = '';
        if (co_sno < 1 || co_sno == null) $msg += "<b><i>CO SNo is missing!!</i></b><br>"
        if (co_statement.length < 10) $msg += "<b><i>CO Statement is not adequate!!</i></b><br>"
        if (id < 1) $msg += "<b><i>Subject is Not Selected!!</i></b>"
        $.alert($msg);
      }
    });
    $(document).on('click', '.editCO', function() {
      var id = $("#subject_id").val();
      var co_id = $(this).attr("data-co");
      $("#co_id").val(co_id);
      // $.alert("Subject Id " + id);
      $.post("coaSql.php", {
        subject_id: id,
        co_id: co_id,
        action: "fetchCO"
      }, function(mydata, mystatus) {
        //$.alert("List " + mydata);
      }, "json").done(function(data, status) {
        // $.alert(data);
        $("#co_weight").val(data.co_weight);
        $("#co_statement").val(data.co_statement);
        $("#co_sno").val(data.co_sno);
      })
    });

    $(document).on('click', '.updateScale', function() {
      var co_id = $(this).attr("data-co");
      var po_id = $(this).attr("data-po");
      var cellText = $(this).html();
      var newText = '-';
      if (cellText == '-') newText = "H"
      else if (cellText == 'H') newText = "M"
      else if (cellText == 'M') newText = "L"
      $("#co" + co_id + "po" + po_id).html(newText)
      //$.alert("CO Id " + co_id + " PO " + po_id + " Text " + cellText);
      $.post("coaSql.php", {
        po_id: po_id,
        co_id: co_id,
        copo_scale: newText,
        action: "copoScale"
      }, function() {}, "text").done(function(data, status) {
        // $.alert(data)
      })

    });

    function coList(id) {
      // $.alert("In CO " + id);
      $.post("coaSql.php", {
        id: id,
        action: "coList"
      }, function(mydata, mystatus) {
        //$.alert("List " + mydata);
      }, "json").done(function(data, status) {
        if (data.success == "0") {
          card += '<tr>';
          card += '<td colspan="5">No CO Found. Please add CO</td>';
          card += '</tr>';
          $("#coTable").find("tr:gt(0)").remove();
          $("#coTable").append(card);

        } else {
          var card = '';
          var count = 1;
          $.each(data, function(key, value) {
            var status = value.co_status
            if (status != null) {
              card += '<tr>';
              // card += '<td>-</td>';
              card += '<td><a href="#" class="editCO fa fa-pencil-alt mt-2" data-co="' + value.co_id + '"></a></td>';
              card += '<td>' + value.subject_code + '</td>';
              card += '<td>CO' + value.co_sno + '</td>';
              card += '<td>' + value.co_statement + '</td>';
              card += '<td>' + value.co_weight + '</td>';
              if (status == '0') card += '<td><a href="#" class="fa fa-trash trashCO mt-2" data-co="' + value.co_id + '" title="' + value.co_id + '"></a></td>';
              else card += '<td>-</td>';
              card += '</tr>';
            }
          })
          $("#coTable").find("tr:gt(0)").remove();
          $("#coTable").append(card);

          var card = '';
          var count = 1;
          $.each(data, function(key, value) {
            var status = value.co_status
            if (status != null) {
              card += '<tr>';
              card += '<td>CO' + value.co_sno + '</td>';
              card += '<td>' + value.co_statement + '</td>';
              card += '<td>' + value.co_weight + '</td>';
              card += '</tr>';
            }
          })
          $("#choCOTable").find("tr:gt(0)").remove();
          $("#choCOTable").append(card);

        }
      })
    }

    $(document).on('click', '.uploadCO', function() {
      var id = $(this).attr("data-id");
      $.alert("Subject From " + id);
      $('#modal_uploadTitle').html("Upload CO [<?php echo $myProgAbbri . '-' . $myBatchName . ']'; ?> ");
      $('#button_action').show().val('Update CO');
      $('#actionUpload').val('uploadCO');
      $('#uploadModalId').val(id);
      $('#uploadModal').modal('show');
      $(".uploadSubjectForm").hide()
      $(".uploadCOForm").show()
    });
  });
</script>
<!-- Modal Section-->
<div class="modal" id="uploadModal">
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" id="upload_csvMarks">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_uploadTitle"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->

        <!-- Modal body -->
        <div class="modal-body">
          <div class="uploadSubjectMarks">
            <div class="form-group">
              <div class="row">
                <div class="col-sm-5">
                  <input type="file" name="csv_upload" />
                  <p>&nbsp;</p>
                  <p class="warning">First Row is header row</p>
                  <p class="warning">Data from Row 2</p>
                </div>
                <div class="col-sm-7 smallerText">
                  <ul>
                    <li>Column A - SNo</li>
                    <li>Column B - Roll Number</li>
                    <li>Column C - Q1-Marks </li>
                    <li>Column D - Q2-Marks </li>
                    <li>Column E - Q3-Marks </li>
                    <li> so on... </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->
        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="" name="uploadModalId">
          <input type="hidden" id="modalTaskId" name="atask_id">
          <input type="hidden" name="action" id="actionUpload" value="uploadMarks">
          <input type="submit" name="button_action" id="button_action" class="btn btn-sm" value="Upload Marks" />
          <button type="button" class="btn btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div>

<!-- Modal Section-->
<div class="modal" id="srUploadModal">
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" id="srUploadModalForm">
      <div class="modal-content">
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
          <input type="hidden" name="action" value="srUpload">
          <input type="hidden" id="sr_idHidden" name="sr_id">
          <button type="submit" class="btn btn-success btn-sm">Submit</button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div>
<!-- Modal Closed-->

</html>