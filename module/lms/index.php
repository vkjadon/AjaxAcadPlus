<?php
require('../requireSubModule.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>ClassConnect:LMS </title>
  <?php require("../css.php"); ?>
</head>

<body>
  <?php require("../topBar.php"); ?>
  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-2 p-0 m-0 pl-2 full-height">
        <h5 class="mt-3">Teaching - Learning</h5>
        <span id="panelId"></span>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active at" id="list-at-list" data-toggle="list" href="#list-at" role="tab" aria-controls="at"> Academic Tasks </a>
          <a class="list-group-item list-group-item-action att" id="list-att-list" data-toggle="list" href="#list-att" role="tab" aria-controls="att"> Attendance </a>
          <a class="list-group-item list-group-item-action dc" id="list-dc-list" data-toggle="list" href="#list-dc" role="tab" aria-controls="dc"> Design a Course </a>
          <!-- <a class="list-group-item list-group-item-action de" id="list-de-list" data-toggle="list" href="#list-de" role="tab" aria-controls="de"> Design Assessment </a> -->
        </div>
      </div>
      <div class="col-10 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane show active" id="list-at" role="tabpanel" aria-labelledby="list-at-list">
            <div class="row">
              <div class="col-5 mt-1 mb-1">
                <div class="container card mt-2 myCard">
                  <!-- nav options -->
                  <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active showStudentList" data-toggle="pill" href="#pills_subject" role="tab" aria-controls="pills_subject" aria-selected="true">Subject</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link showSubjectTopic" data-toggle="pill" href="#pills_topics" role="tab" aria-controls="pills_topics" aria-selected="true">Topics</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link showResource" data-toggle="pill" href="#pills_resources" role="tab" aria-controls="pills_resources" aria-selected="true">Resources</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link showCoverage" data-toggle="pill" href="#pills_coverage" role="tab" aria-controls="pills_coverage" aria-selected="true">Coverage</a>
                    </li>
                  </ul> <!-- content -->
                  <div class="tab-content" id="pills-tabContent p-3">
                    <p id="mtlList"></p>
                    <div class="tab-pane fade show active" id="pills_subject" role="tabpanel" aria-labelledby="pills_subject">
                      <div class="col-12 border">
                        <span class="xsText">
                          <li>Subject Topics will be same for one Subject irrespective of the Class and Faculty.</li>
                          <li> It signifies the Syllabus.</li>
                          <li> You can add any additional topic.</li>
                        </span>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="pills_topics" role="tabpanel" aria-labelledby="pills_topic">
                      <div class="stForm border">
                        <div class="row p-2">
                          <div class="col-6 pr-1">
                            <div class="form-group">
                              <label>Topic Name</label>
                              <input type="text" class="form-control form-control-sm" id="sbt_name" name="sbt_name" placeholder="Topic">
                            </div>
                          </div>
                          <div class="col-2 pl-0 pr-1">
                            <div class="form-group">
                              <label>Wt (%)</label>
                              <input type="number" class="form-control form-control-sm" id="sbt_weight" name="sbt_weight" min="1" placeholder="Weight in %">
                            </div>
                          </div>
                          <div class="col-2 pl-0 pr-1">
                            <div class="form-group">
                              <label>CHr</label>
                              <input type="number" class="form-control form-control-sm" id="sbt_slot" name="sbt_slot" min="1" placeholder="Contact Hours Required">
                            </div>
                          </div>
                          <div class="col-2 pl-0">
                            <div class="form-group">
                              <label>Unit</label>
                              <input type="number" class="form-control form-control-sm" id="sbt_unit" name="sbt_unit" min="1" placeholder="Unit Number">
                            </div>
                          </div>
                        </div>
                        <div class="row p-2">
                          <div class="col">
                            <div class="form-check-inline">
                              <input type="radio" class="form-check-input" checked id="syllabus" name="sbt_syllabus" value="0">Syllabus
                            </div>
                            <div class="form-check-inline">
                              <input type="radio" class="form-check-input" id="additional" name="sbt_syllabus" value="1">Additional
                            </div>
                          </div>
                          <div class="col-6 pr-1">
                            <div class="form-group">
                              <button class="btn btn-sm submit_sbt" id="submit_sbt">Submit</button>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="pills_resources" role="tabpanel" aria-labelledby="pills_resources">
                      <div class="resForm border">
                        <div class="row p-1">
                          <div class="col-6 pr-1">
                            <div class="form-group">
                              Resource Title/Name
                              <input type="text" class="form-control form-control-sm" id="sbr_name" name="sbr_name" placeholder="Title of the Resource">
                            </div>
                          </div>
                          <div class="col-6 pl-0">
                            <div class="form-group">
                              URL
                              <input type="text" class="form-control form-control-sm" id="sbr_url" name="sbr_url" placeholder="Complete URL including http://">
                            </div>
                          </div>
                        </div>
                        <div class="row pl-1">
                          <div class="col-6 pr-1">
                            <div class="form-group">
                              <?php
                              $sql = "select * from master_name where mn_code='rt'";
                              selectList($conn, "", array("0", "mn_id", "mn_name", "", "sel_mn"), $sql);
                              ?>
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-check-inline">
                              <input type="radio" class="form-check-input" checked id="private" name="sbr_type" value="Private">
                              Private
                            </div>
                            <div class="form-check-inline">
                              <input type="radio" class="form-check-input" id="public" name="sbr_type" value="Public">Public
                            </div>
                          </div>
                        </div>
                        <div class="row pl-1">
                          <div class="col">
                            <div class="form-group">
                              <button class="btn btn-sm" id="submit_sbResource">Submit</button>
                            </div>
                          </div>
                          <div class="col-12">
                            <span class="xsText">Private will not allow other faculty to use and share your resource. Public resource will be available for others to share with their classes.</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="pills_coverage" role="tabpanel" aria-labelledby="pills_coverage">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-7 mt-1 mb-1">
                <div class="container card mt-2 myCard">
                  <div class="studentList">
                    <label>List of Students</label>
                    <table class="table list-table-xs" id="studentList">
                      <tr class="align-center">
                        <th><i class="fas fa-info-circle"></i></th>
                        <th>Name</th>
                        <th>Roll No</th>
                        <th>Mobile</th>
                        <th>PA</th>
                        <th>PM</th>
                      </tr>
                    </table>
                  </div>
                  <div class="subjectTopics">
                    <label>List of Topics</label>
                    <table class="table list-table-xs" id="subjectTopicList">
                      <tr class="align-center">
                        <th><i class="fas fa-edit"></i></th>
                        <th>Id</th>
                        <th width="70%">Topic</th>
                        <th>Wt</th>
                        <th>CHr</th>
                        <th><i class="fas fa-trash"></i></th>
                      </tr>
                    </table>
                    <span class="xsText">Syllabus Topics are not editable. These are as approved by BOS. The faculty can add additional Topics in the interest of students based on current trends and industry requirements.</span>
                  </div>
                  <div class="subjectResource">
                    <label>List of Resources</label>
                    <table class="table list-table-xs" id="resourceList">
                      <th>Id</th>
                      <th>Title</th>
                      <th>Link</th>
                      <th><i class="fa fa-upload"></i></th>
                      <th>Class</th>
                    </table>
                    <span class="xsText">You can edit the resource added by you but you can use the Resource (Public) of other and assign to classes you teach.</span>
                  </div>
                  <p class="subjectCoverage"></p>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-att" role="tabpanel" aria-labelledby="list-att-list">
            <div class="container card mt-2 myCard">
              <div class="m-2" id="showScheduleForm">
                <div class="row">
                  <div class="col-sm-2 pr-1">
                    <input type="date" class="form-control form-control-md" id="date_from" name="date_from" min="<?php echo $session_start; ?>" value="<?php echo date("Y-m-d", time()); ?>">
                  </div>
                  <div class="col-sm-2 pl-0 pr-1">
                    <input type="date" class="form-control form-control-md" id="date_to" name="date_to" max="<?php echo $session_end; ?>" value="<?php echo date("Y-m-d", time()); ?>">
                  </div>
                  <div class="col-sm-2 pl-0">
                    <input type="hidden" id="schedule_action" name="schedule_action">
                    <button class="btn btn-info btn-md m-0 scheduleButton"></button>
                  </div>
                </div>
              </div>
            </div>
            <div class="container card mt-2 myCard">
              <p class="mt-2" id="showSchedule"></p>
            </div>
            <div class="container card mt-2 myCard">
              <div class="mt-2" id="showAttendanceRegister"></div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-dc" role="tabpanel" aria-labelledby="list-dc-list">
          <div class="container card mt-2 myCard">
            Coming Soon...
          </div>
          </div>
          <div class="tab-pane fade" id="list-de" role="tabpanel" aria-labelledby="list-de-list">
            <div class="row">
              <div class="col-4 mt-1 mb-1">
                <p id="mySubjectList"></p>
              </div>
              <div class="col-8 mt-1 mb-1">
                <div id="assessmentList">
                </div>
              </div>
              <div class="col-12" id="stList"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require("../bottom_bar.php"); ?>
  </div>
</body>
<script>
  $(document).ready(function() {

    $(".subjectCoverage").hide();
    $(".subjectResource").hide();
    $(".subjectTopics").hide();

    mtlList();
    $('.selectPanel').hide()
    $('#topicList').hide()

    // Teaching Task 

    $(document).on('click', '.showStudentList', function() {
      $(".subjectCoverage").hide();
      $(".subjectResource").hide();
      $(".subjectTopics").hide();
      // $.alert("Show Subject Topic");
      $(".studentList").show();
    });
    $(document).on('click', '#submit_sbt', function() {
      var tlId = $("input[name='subject']:checked").val();
      var sbt_syllabus = $("input[name='sbt_syllabus']:checked").val();
      var sbt_name = $("#sbt_name").val();
      var sbt_weight = $("#sbt_weight").val();
      var sbt_slot = $("#sbt_slot").val();
      var sbt_unit = $("#sbt_unit").val();
      $.alert("Name " + sbt_name);
      $.post("lmsSql.php", {
        tlId: tlId,
        sbt_name: sbt_name,
        sbt_weight: sbt_weight,
        sbt_slot: sbt_slot,
        sbt_unit: sbt_unit,
        sbt_syllabus: sbt_syllabus,
        action: "addST"
      }, function(data, status) {
        $.alert("Success " + data);
        $('#subjectTopicList').html(data)
      }, "text").fail(function() {
        $.alert("Error !!");
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
      var tlId = $("input[name='subject']:checked").val();
      //$.alert("In List Function" + tlId);
      $.post("lmsSql.php", {
        action: "stList",
        tlId: tlId
      }, function(data, status) {
        //$.alert("Success " + data);
        $('#subjectTopicList').html(data)
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    $(document).on('click', '#submit_sbResource', function() {
      var tlId = $("input[name='subject']:checked").val();
      var sbr_name = $("#sbr_name").val();
      var sbr_url = $("#sbr_url").val();
      var mn_id = $("#sel_mn").val();
      var sbr_type = $("input[name='sbr_type']:checked").val();
      $.alert("Name " + sbr_name + " tlId " + tlId + " url " + sbr_url + " mn " + mn_id + " sbr_type " + sbr_type);
      $.post("lmsSql.php", {
        tlId: tlId,
        sbr_name: sbr_name,
        sbr_url: sbr_url,
        sbr_type: sbr_type,
        mn_id: mn_id,
        action: "addRes"
      }, function(data, status) {
        $.alert("Success " + data);
        resourceList();
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });
    $(document).on('click', '.showResource', function() {
      $(".subjectTopics").hide();
      $(".subjectCoverage").hide();
      $(".studentList").hide();
      // $.alert("ShowCoverage");
      resourceList();
      $(".subjectResource").show();
    });

    function resourceList() {
      var tlId = $("input[name='subject']:checked").val();
      // $.alert("In Resource List Function" + subjectId);
      $.post("lmsSql.php", {
        tlId: tlId,
        action: "resList"
      }, function(data, status) {
        //$.alert("Success " + data);
        $('#resourceList').html(data)
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function mtlList() {
      //$.alert("In List Function");
      $.post("lmsSql.php", {
        action: "mtlList"
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#mtlList").html(data);
      }, "text").done(function(data, staus) {
        // $.alert("dfdf");
      }).fail(function() {
        $.alert("Error !!");
      })
    }
    $(document).on('click', '.showCoverage', function() {
      $(".subjectTopics").hide();
      $(".subjectResource").hide();
      $(".studentList").hide();
      // $.alert("ShowCoverage");
      courseCoverage();
      $(".subjectCoverage").show();

    });

    function courseCoverage() {
      var tlId = $("input[name='subject']:checked").val();
      // $.alert("In List Function" + tlId);
      $.post("lmsSql.php", {
        action: "coverage",
        tlId: tlId
      }, function(data, status) {
        //$.alert("Success " + data);

        $('.subjectCoverage').html(data)
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    $(document).on('click', '.de', function() {
      $('.selectPanel').show()
      mySubjectList();
      mySubjectAssessmentList();
    });

    $(document).on('click', '.att', function() {
      $('#showScheduleForm').show();
      $('.scheduleButton').html("Show Schedule");
      $('#schedule_action').val("showSchedule");
    });

    $(document).on('click', '.lock', function() {
      var sasId = $(this).attr("data-sas");
      var checkboxST = $(".sasST").is(":checked");
      if (checkboxST == true) {
        $.alert(" sasId " + sasId + "ST CB " + checkboxST);
        $.post("attSql.php", {
          sasId: sasId,
          action: "lockAtt"
        }, function() {}, "text").done(function(data, status) {
          $.alert(data);
          $(".lock").html("Locked")
        }).fail(function() {
          $.alert("Error !!");
        })
      } else {
        $.alert(" Please Select at-least One Subject Topic to Lock the Attendance ");
      }
    });

    $(document).on('click', '.sasST', function() {
      var sasId = $(this).attr("data-sas");
      var stId = $(this).attr("data-sasST");
      var checkboxST = $(this).is(":checked");
      $.alert(" sasId " + sasId + "ST CB " + checkboxST + "ST" + stId);
      if (checkboxST == true) stAction = "add";
      else stAction = "delete";
      $.post("attSql.php", {
        sasId: sasId,
        stId: stId,
        stAction: stAction,
        action: "addST"
      }, function() {}, "html").done(function(data, status) {
        $.alert(data);
      }).fail(function() {
        $.alert("Error !!");
      })
    });

    $(document).on('click', '.markAttendance', function() {
      var sasId = $(this).attr("data-sas");
      var studentId = $(this).attr("data-std");
      var checkboxStatus = $(this).is(":checked");
      //$.alert(" sasId " + sasId + " Student " + studentId + checkboxStatus);
      $.post("attSql.php", {
        sasId: sasId,
        studentId: studentId,
        checkboxStatus: checkboxStatus,
        action: "markAttendance"
      }, function() {}, "html").done(function(data, status) {
        //$(".attStats").html();
        $("#attStats").html(data);
      }).fail(function() {
        $.alert("Error !!");
      })
    });

    $(document).on('click', '.showAttendanceList', function() {
      var sasId = $(this).attr("data-sas");
      var tlId = $(this).attr("data-tl");
      //$.alert(" Show Std List " + sasId + tlId);
      $("#showSchedule").hide()
      studentClassSubjectList(sasId);
    });

    $(document).on('click', '.scheduleButton', function() {
      var c = $('#ssClass').text();
      var action = $('#schedule_action').val();
      var scheduleFrom = $('#date_from').val();
      var scheduleTo = $('#date_to').val();
      //$.alert("Show Schedule Pressed  Action " + action + "<br>From " + scheduleFrom + " To " + scheduleTo);
      $("#showAttendanceRegister").hide()

      $.post("attSql.php", {
        action: action,
        scheduleFrom: scheduleFrom,
        scheduleTo: scheduleTo
      }, function() {}, "text").done(function(data, status) {
        $('#showSchedule').show();
        $('#showSchedule').html(data);
      }).fail(function() {
        $.alert("Fail");
      })
    });

    $(document).on('click', '.upload', function() {
      var x = $(this).attr('data-rsb');
      $.alert("Inst " + x);
      $('#rsb_idM').val(x);
      $('#uploadModal').modal('show');
    });

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

    $(document).on('click', '.resClass', function() {
      var classId = $(this).attr('data-resCl');
      var rsbId = $(this).attr('data-rsb');
      var checkboxStatus = $(this).is(":checked");
      $.alert("Id " + classId + " RSB " + rsbId + status);
      $.post("lmsSql.php", {
        action: "resClass",
        rsbId: rsbId,
        classId: classId,
        checkboxStatus: checkboxStatus
      }, function(data, status) {
        $.alert("Done ..." + data)
      }).fail(function() {
        $.alert("Failed !!")
      })
    });

    $(document).on('click', '.swapButton', function() {
      var id = $(this).attr('data-sbtId');
      var tlId = $(this).attr('data-tlId');
      var swap = $(this).attr('data-swap');
      //$.alert("Id " + id + swap);
      $.post("lmsSql.php", {
        action: "swap",
        swap: swap,
        sbtId: id
      }, function(data, status) {
        //$.alert(data)
      }, "text").done(function() {
        stList(tlId);
      })
    });

    $(document).on('click', '.downButton', function() {
      var id = $(this).attr('data-sbtId');
      $.alert("Id " + id);
    });

    $(document).on('click', '.editButton', function() {
      var id = $(this).attr('data-sbtId');
      $.alert("Id " + id);
    });

    $(document).on('submit', '#modalFormAD', function(event) {
      event.preventDefault(this);
      var action = $("#actionAD").val();
      //$.alert("Form Submitted " + action);
      var error = "NO";
      var error_msg = "";
      if (action == "addAD" || action == "updateAD") {
        if ($("#ad_name").val() === "" || $("#sel_subjectAD").val() === "" || $("#sel_at").val() === "") {
          error = "YES";
          error_msg = "Design Name/Subject/Technique cannot be blank";
        }
      } else if (action == "addAUCO" && $("#auco_weight").val() === "") {
        error = "YES";
        error_msg = "Value Cannot be blank";
      } else if (action == "addAUMarks" && $("#au_marks").val() === "") {
        error = "YES";
        error_msg = "AU/Q Marks Cannot be blank";
      }
      if (error == "NO") {
        var formData = $(this).serialize();
        $.alert(formData);
        $.post("obeSql.php", formData, () => {}, "text").done(function(data) {
          //$.alert(data);
          if (action == "addAD" || action == "updateAD") assessmentDesignList();
          else if (action == "addAUCO" || action == "addAUMarks") aucoMap();
          $('#firstModal').modal('hide');
          $('#modalFormAD')[0].reset();
        }, "text").done(function(mydata, mystatus) {
          //$.alert("Data" + mydata);
        }).fail(function() {
          $.alert("fail in place of error");
        })
      } else {
        $.alert(error_msg);
      }
    });

    $(document).on('click', '.addAssessment', function() {
      //$.alert("Assessment Design");
      $('#modal_titleAD').text("Assessment Design");
      $('#actionAD').val("addAD");
      $('#adModal').modal('show');
      $('.assessmentDesignForm').show();
      $('.aucoForm').hide();
      $('.auMarksForm').hide();
    });

    function studentClassSubjectList(sasId) {
      //$.alert("In List Function");
      $.post("attSql.php", {
        sasId: sasId,
        action: "studentClassSubjectList"
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#showAttendanceRegister").show()
        $("#showAttendanceRegister").html(data);
      }, "text").done(function(data, staus) {
        //$.alert("dfdf");
      }).fail(function() {
        $.alert("Error !!");
      })
    }

    function mySubjectList() {
      //$.alert("In List Function");
      $.post("evalSql.php", {
        action: "mySubjectList"
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#mySubjectList").html(data);
      }, "text").done(function(data, staus) {
        // $.alert("dfdf");
      }).fail(function() {
        $.alert("Error !!");
      })
    }

    function mySubjectAssessmentList() {
      //$.alert("In List Function");
      $.post("evalSql.php", {
        action: "mySubjectAssessmentList"
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#mySubjectAssessmentList").html(data);
      }, "text").done(function(data, staus) {
        // $.alert("dfdf");
      }).fail(function() {
        $.alert("Error !!");
      })
    }
  });
</script>
<!-- Modal Section-->
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

        </div> <!-- Modal Body Closed-->

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="action" name="action">
          <input type="hidden" id="modalId" name="modalId">
          <input type="hidden" id="modalTLId" name="tlId">
          <input type="hidden" id="modalSubId" name="subjectId">

          <button type="submit" class="btn btn-success btn-sm" id="submitModalForm"></button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->

    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

<!-- Modal Section-->
<div class="modal" id="uploadModal">
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" id="uploadModalForm">
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
          <input type="hidden" name="action" value="upload">
          <input type="hidden" id="rsb_idM" name="rsbId">
          <button type="submit" class="btn btn-success btn-sm">Submit</button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

<!-- Modal Section-->
<div class="modal" id="adModal">
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" id="modalFormAD">
      <div class="modal-content bg-secondary text-white">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_titleAD"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->

        <!-- Modal body -->
        <div class="modal-body">
          <div class="assessmentDesignForm">
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Assessment Name
                  <input type="text" class="form-control form-control-sm" id="ad_name" name="ad_name" placeholder="Name of Assessment">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  Technique
                  <?php
                  $sql = "select * from assessment_technique where at_status='0'";
                  selectList($conn, "Select Technique", array("0", "at_id", "at_name", "", "sel_at"), $sql);
                  ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-3">
                <div class="form-group">
                  Max Marks
                  <input type="number" class="form-control form-control-sm" id="ad_mm" name="ad_mm" placeholder="Max Marks">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Pass Marks
                  <input type="number" class="form-control form-control-sm" id="ad_pm" name="ad_pm" placeholder="Pass Marks">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Weight(%)
                  <input type="number" step="0.5" class="form-control form-control-sm" id="ad_weight" name="ad_weight" placeholder="Weight out of 100%">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  AU
                  <input type="number" class="form-control form-control-sm" id="ad_question" name="ad_question" placeholder="Question/Rubric in assessment">
                </div>
              </div>
            </div>
            <hr>
            <div class="form-group">
              <i>All assessments are to be considered for CO attainment. However, options may be given for grade calculations. Assessment Units (AU) may or may not be euqal to number of questions in the Assessment, eg, any assessment may have 10 questions but if all the questions are related to one CO, then AU=1. If 3 Questions are related to one CO and other seven to other CO, then AU=2. In the mixed case we should consider AU=1 and it should be mapped with different COs with appropriate weights.</i>
            </div>
          </div>
          <div class="aucoForm">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  Percentage Weight of CO
                  <input type="number" class="form-control form-control-sm" id="auco_weight" name="auco_weight" placeholder="Percent of CO mapped with Assessment">
                  <input type="hidden" id="ad_idM" name="ad_idM">
                  <input type="hidden" id="co_idM" name="co_idM">
                  <input type="hidden" id="au_snoM" name="au_snoM">
                </div>
              </div>
            </div>
            <hr>
            <div class="form-group">
              <i>The data filled here represents the percentage contribution of the Assessment Unit (AU)/Question to the CO Selected. We can set 100% if only one CO is mapped with one AU/Question</i>
            </div>
          </div>
          <div class="auMarksForm">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  Marks of the AU/Question
                  <input type="number" class="form-control form-control-sm" id="au_marks" name="au_marks" placeholder="AU Marks (absolute)">
                </div>
              </div>
            </div>
            <hr>
            <div class="form-group">
              <i>If more questions are grouped to form an Assessment Unit, total marks of the questions are to be added. The marks will be distributed proportionately to each CO in case more than one COs are mapped to AU/Q.</i>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->
        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="modalIdAD" name="modalIdAD">
          <input type="hidden" id="hiddenId" name="subjectId">
          <input type="hidden" id="actionAD" name="actionAD">
          <button type="submit" class="btn btn-success btn-sm" id="submitModalFormAD">Submit</button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

</html>