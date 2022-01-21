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
      <div class="col-1 p-0 m-0 full-height">
        <div class="mt-3 pl-1">
          <h5>LMS</h5>
        </div>
        <span id="panelId"></span>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active at" id="list-at-list" data-toggle="list" href="#list-at" role="tab" aria-controls="at"> Academic Tasks </a>
          <a class="list-group-item list-group-item-action att" id="list-att-list" data-toggle="list" href="#list-att" role="tab" aria-controls="att"> Attendance </a>
          <a class="list-group-item list-group-item-action attReg" id="list-attReg-list" data-toggle="list" href="#attReg" role="tab" aria-controls="attReg"> Register</a>
        </div>
      </div>
      <div class="col-11 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <p id="mtlList"></p>
          <div class="tab-pane show active" id="list-at" role="tabpanel" aria-labelledby="list-at-list">
            <div class="card myCard">
              <div class="card-body">
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
                  <div class="tab-pane fade show active" id="pills_subject" role="tabpanel" aria-labelledby="pills_subject">
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
                  </div>
                  <div class="tab-pane fade" id="pills_topics" role="tabpanel" aria-labelledby="pills_topic">
                    <div class="stForm border">
                      <div class="row p-2">
                        <div class="col-8">
                          <div class="row">
                            <div class="col-5 pr-1">
                              <div class="form-group">
                                <label>Topic Name</label>
                                <input type="text" class="form-control form-control-sm" id="sbt_name" name="sbt_name" placeholder="Topic">
                              </div>
                            </div>
                            <div class="col-1 pl-0 pr-1">
                              <div class="form-group">
                                <label>Wt (%)</label>
                                <input type="number" class="form-control form-control-sm" id="sbt_weight" name="sbt_weight" min="1" placeholder="Weight in %" value="1">
                              </div>
                            </div>
                            <div class="col-1 pl-0 pr-1">
                              <div class="form-group">
                                <label>CHr</label>
                                <input type="number" class="form-control form-control-sm" id="sbt_slot" name="sbt_slot" min="1" placeholder="Contact Hours Required" value="1">
                              </div>
                            </div>
                            <div class="col-1 pl-0">
                              <div class="form-group">
                                <label>Unit</label>
                                <input type="number" class="form-control form-control-sm" id="sbt_unit" name="sbt_unit" min="1" placeholder="Unit Number" value="1">
                              </div>
                            </div>
                            <div class="col-3">
                              <div class="form-check-inline">
                                <input type="radio" class="form-check-input" checked id="syllabus" name="sbt_syllabus" value="0">Syllabus
                              </div>
                              <div class="form-check-inline">
                                <input type="radio" class="form-check-input" id="additional" name="sbt_syllabus" value="1">Additional
                              </div>
                            </div>
                            <div class="col-1 pl-1">
                              <div class="form-group">
                                <button class="btn btn-sm submit_sbt" id="submit_sbt">Submit</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-4">
                          <span class="xsText">
                            <li>Subject Topics will be same for one Subject irrespective of the Class and Faculty.</li>
                            <li> It signifies the Syllabus.</li>
                            <li> You can add any additional topic.</li>
                          </span>
                        </div>
                      </div>
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
                  </div>
                  <div class="tab-pane fade" id="pills_resources" role="tabpanel" aria-labelledby="pills_resources">
                    <div class="resForm border">
                      <div class="row p-1">
                        <div class="col-3 pr-1">
                          <div class="form-group">
                            Resource Title/Name
                            <input type="text" class="form-control form-control-sm" id="sbr_name" name="sbr_name" placeholder="Title of the Resource">
                          </div>
                        </div>
                        <div class="col-3 pl-0">
                          <div class="form-group">
                            URL
                            <input type="text" class="form-control form-control-sm" id="sbr_url" name="sbr_url" placeholder="Complete URL including http://">
                          </div>
                        </div>
                        <div class="col-2 pr-1">
                          <div class="form-group">
                            <label>Resourse Type</label>
                            <?php
                            $sql = "select * from master_name where mn_code='rt'";
                            selectList($conn, "", array("0", "mn_id", "mn_name", "", "sel_mn"), $sql);
                            ?>
                          </div>
                        </div>
                        <div class="col-2">
                          <label>Resourse Status</label>
                          <div class="form-check">
                            <input type="radio" class="form-check-input" checked id="private" name="sbr_type" value="Private">
                            Private
                          </div>
                          <div class="form-check-inline">
                            <input type="radio" class="form-check-input" id="public" name="sbr_type" value="Public">Public
                          </div>
                        </div>
                      
                        <div class="col-1">
                          <div class="form-group">
                            <button class="btn btn-sm" id="submit_sbResource">Submit</button>
                          </div>
                        </div>
                        <div class="col-12">
                          <span class="xsText">Private will not allow other faculty to use and share your resource. Public resource will be available for others to share with their classes.</span>
                        </div>
                      </div>
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
                  </div>
                  <div class="tab-pane fade" id="pills_coverage" role="tabpanel" aria-labelledby="pills_coverage">
                    <p class="subjectCoverage"></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-att" role="tabpanel" aria-labelledby="list-att-list">
            <div class="card mt-2 myCard">
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
                <div class="row">
                  <div class="col-sm-12">
                    <p class="mt-4" id="showSchedule"></p>
                    <p class="mt-4" id="showAttendanceRegister"></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="attReg" role="tabpanel" aria-labelledby="list-attReg-list">
            <div class="card mt-2 myCard">
              <p class="header"></p>
              <p class="record overflow-auto"></p>
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

    mtlList();
    $('.selectPanel').hide()
    $('#topicList').hide()

    // Subject Attendance Register
    $(document).on('click', '.attReg, .sel_subject', function() {
      attRegHeaderFooter();
      attRecord();
      subjectTopicList();

    });

    function attRegHeaderFooter() {
      var tlId = $("input[name='subject']:checked").val();
      // $.alert("In List Function" + tlId);
      $.post("attSql.php", {
        tlId: tlId,
        action: "fetchAttRegHeaderFooter"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var header = '';
        header += '<div class="row m-2">';
        header += '<div class="col-md-12">';
        header += '<div class="text-center"><h3> Attendance Register<h3></div>';
        header += '</div>';
        header += '<div class="col-md-6">';
        header += '<h4> Class : ' + data.class_name + '[' + data.class_section + ']</h4>';
        header += '</div>';
        header += '<div class="col-md-6">';
        header += '<h4>' + data.subject_name + ' [' + data.subject_code + ']</h4>';
        header += '</div>';
        header += '</div>';
        $(".header").html(header)

      })
    }

    $(document).on('click', '.updateAttendance', function() {
      var student_id = $(this).attr("data-std");
      var sas_id = $(this).attr("data-sas");
      var tlId = $("input[name='subject']:checked").val();
      // $("#std" + student_id + "sas" + sas_id).removeClass("warning")
      var cellText = $(this).html();
      var newText = '-';
      if (cellText == 'P') {
        newText = "A"
      } else if (cellText == 'A') newText = "P"
      $("#std" + student_id + "sas" + sas_id).html(newText)
      // $.alert("student_id Id " + student_id + " sas_id " + sas_id + " Text " + cellText);
      $.post("attSql.php", {
        student_id: student_id,
        sas_id: sas_id,
        tlId: tlId,
        attendance: newText,
        action: "updateAttendance"
      }, function() {}, "text").done(function(data, status) {
        // $.alert(data)
        $("#per" + student_id).html(data)
      })
    });

    function attRecord() {
      var tlId = $("input[name='subject']:checked").val();
      // $.alert("In List Function" + tlId);
      $.post("attSql.php", {
        tlId: tlId,
        action: "attRecord"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        console.log(data)
        var count = 1;
        var text = '';
        var text = '<table class="table list-table-xs" style="white-space: nowrap;">';
        text += '<tr>';
        text += '<td>#</td><td>Student Name </td><td>RNo</td><td>DoR</td>';
        for (var i = 0; i < data.dates.length; i++) {
          text += '<td>' + getFormattedDate(data.dates[i], "dm") + '</td>';
        }
        text += '</tr>';

        $.each(data.records, function(key, value) {
          text += '<tr>';
          text += '<td class="text-center">' + count++ + '</td>';
          text += '<td>' + value.student_name + '</td>';
          text += '<td>' + value.student_rollno + '</td>';
          text += '<td>' + getFormattedDate(value.rs_date, "dmY") + '</td>';
          for (var i = 0; i < value.sa_attendance.length; i++) {
            if (value.sa_attendance[i] == 'A') text += '<td class="click"><a class="topBarText updateAttendance warning" data-std="' + value.student_id + '" data-sas="' + data.sas_id[i] + '" id="std' + value.student_id + 'sas' + data.sas_id[i] + '">A</a></td>';
            else if (value.sa_attendance[i] == 'P') text += '<td class="click"><a class="topBarText updateAttendance approve" data-std="' + value.student_id + '" data-sas="' + data.sas_id[i] + '" id="std' + value.student_id + 'sas' + data.sas_id[i] + '">P</a></td>';
            else text += '<td>-</td>';
          }
          text += '<td id="per' + value.student_id + '">' + value.presents + '</td>';
          text += '</tr>';
        });
        text += '</table>';
        $(".record").html(text)
      })
    }

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
      var x = $(this).attr('data-sr');
      $.alert("Inst " + x);
      $('#sr_id').val(x);
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
      var srId = $(this).attr('data-sr');
      var checkboxStatus = $(this).is(":checked");
      $.alert("Id " + classId + " sr " + srId + status);
      $.post("lmsSql.php", {
        action: "resClass",
        srId: srId,
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

    function getFormattedDate(ts, fmt) {
      var a = new Date(ts);
      var day = a.getDate();
      var month = a.getMonth() + 1;
      var year = a.getFullYear();
      var date = day + '-' + month + '-' + year;
      var dateDM = day + '-' + month;
      var dateYmd = year + '-' + month + '-' + day;
      if (fmt == "dmY") return date;
      else if (fmt == "dm") return dateDM;
      else return dateYmd;
    }
  });
</script>
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
          <input type="hidden" id="sr_id" name="sr_id">
          <button type="submit" class="btn btn-success btn-sm">Submit</button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->


</html>