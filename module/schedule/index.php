<?php
require('../requireSubModule.php');

$session_start = getField($conn, $mySes, "session", "session_id", "session_start");
$session_end = getField($conn, $mySes, "session", "session_id", "session_end");
addActivity($conn, $myId, "Schedule");

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Outcome Based Education : ClassConnect</title>
  <?php require("../css.php"); ?>

</head>

<body>
  <?php require("../topBar.php"); ?>
  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-2 p-0 m-0 pl-2 full-height">
        <h5 class="pt-3">Schedule</h5>
        <span id="panelId"></span>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action show active tt" id="list-tt-list" data-toggle="list" href="#list-tt" role="tab" aria-controls="tt"> Time Table </a>
          <a class="list-group-item list-group-item-action stt" id="list-stt-list" data-toggle="list" href="#list-stt" role="tab" aria-controls="stt"> Show Time-Table </a>
          <a class="list-group-item list-group-item-action cs" id="list-cs-list" data-toggle="list" href="#list-cs" role="tab" aria-controls="cs"> Create Schedule </a>
        </div>
        <div class="mr-2">
          <?php
          $sql = "select * from class where session_id='$mySes' and program_id='$myProg' order by class_semester";
          selectList($conn, "", array(0, "class_id", "class_name", "class_section", "sel_class"), $sql);
          ?>
        </div>
      </div>
      <div class="col-10 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane show active" id="list-tt" role="tabpanel" aria-labelledby="list-tt-list">
            <div class="container card myCard p-2 mb-2">
              <div id="dayList"></div>
            </div>
            <div class="container card myCard p-2">
              <div class="waiting">Please click action button to load...
                <img src="../../images/wating2.gif" width="40%">
              </div>
              <div id="mondayList"></div>
              <div id="tuesdayList"></div>
              <div id="wednesdayList"></div>
              <div id="thursdayList"></div>
              <div id="fridayList"></div>
              <div id="saturdayList"></div>
              <div id="sundayList"></div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-stt" role="tabpanel" aria-labelledby="list-stt-list">
            <div class="container card myCard p-2 mb-2">
              <div id="sessionClassListSTT"></div>
            </div>
            <div class="container card myCard p-2">
              <div class="waiting">Please click action button to load...
                <img src="../../images/wating2.gif" width="40%">
              </div>
              <p id="showTimeTable"></p>
            </div>
          </div>
          <div class="tab-pane fade" id="list-cs" role="tabpanel" aria-labelledby="list-cs-list">
            <div class="container card myCard p-2 mb-2" id="showScheduleForm">
              <div class="row">
                <div class="col-3 pr-0">
                  <div class="form-group">
                    <label>Schedule Start Date</label>
                    <input type="date" class="form-control form-control-sm" id="schedule_from" name="schedule_from" min="<?php echo $session_start; ?>" value="<?php echo date("Y-m-d", time()); ?>">
                  </div>
                </div>
                <div class="col-3 pl-1 pr-0">
                  <div class="form-group">
                    <label>Schedule Last Date</label>
                    <input type="date" class="form-control form-control-sm" id="schedule_to" name="schedule_to" max="<?php echo $session_end; ?>" value="<?php echo date("Y-m-d", time()); ?>">
                  </div>
                </div>
                <div class="col-2 pl-1 pr-0 mt-4">
                  <div class="form-group">
                    <button class="btn btn-sm btn-block createScheduleButton">Create Schedule</button>
                  </div>
                </div>
                <div class="col-2 pl-1 pr-0 mt-4">
                  <div class="form-group">
                    <button class="btn btn-sm btn-block showScheduleButton">Show Schedule</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 mt-1 mb-1">
                <div class="container card myCard p-2 mb-2">
                  <div id="waiting">Please click action button to load...
                    <img src="../../images/wating2.gif" width="40%">
                  </div>
                  <p id="createScheduleOutput"></p>
                  <p id="showSchedule"></p>
                </div>
              </div>
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
    $(".topBarTitle").text("Schedule");
    $("#panelId").hide();
    var classId = $("#sel_class").val();
    ttList();

    $(document).on('click', '.stt', function() {
      $("#panelId").html("STT");
      sessionClass();
    });

    $(document).on('click', '.cs', function() {
      //$.alert("TL");
      $("#selectPanelTitle").text("Create Schedule");
      $("#panelId").html("CS");
    });

    $(document).on('click', '.tt', function() {
      $("#panelId").html("TT");
      var classId = $("#sel_class").val();
      // $.alert("TL" + classId);
      ttList();
    });

    $(document).on('blur', '.periodTime', function() {
      var periodTime = $(this).val();
      var classId = $(this).attr("data-class");
      var day = $(this).attr("data-day");
      var period = $(this).attr("data-period");
      //Confirm Alert Plugin shows Alert Box twice
      //alert(" Time " + periodTime);
      $.post("scheduleSql.php", {
        ttTime: periodTime,
        classId: classId,
        day: day,
        period: period,
        action: "ttTime"
      }, function() {}, "text").done(function(mydata, mystatus) {
        //alert(mydata);
      })
    });

    $(document).on('click', '.sclSTT', function() {
      var checkboxes_value = [];
      $('.sclSTT').each(function() {
        if (this.checked) {
          checkboxes_value.push($(this).val());
        }
      });
      $.alert("Class STT " + checkboxes_value);
      if (checkboxes_value == "") {
        $.alert("Please Select atleast One Class");
        $('#showTimeTable').hide();
      } else {
        $.post("createScheduleSql.php", {
          action: "showTimeTable",
          checkboxes_value: checkboxes_value
        }, function(data, status) {
          $('#showTimeTable').show();
          $('#showTimeTable').html(data);
        }, "text").fail(function() {
          $.alert("Fail");
        })
      }
    });

    $(document).on('submit', '#modalFormSub', function(event) {
      event.preventDefault(this);
      var action = $("#actionSub").val();
      //$.alert("Form Submitted " + action);
      var formData = $(this).serialize();
      //$.alert(formData);
      $.post("createScheduleSql.php", formData, () => {}, "text").done(function(data) {
        // $.alert("Form Submitted " + data);
        $('#substituteModal').modal('hide');
        $('#modalFormSub')[0].reset();
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.substituteSchedule', function() {
      var sasDate = $(this).attr("data-date");
      var sasPeriod = $(this).attr("data-period");
      var classId = $(this).attr("data-class");
      // $.alert("Substitute Pressed " + sasDate + " Period " + sasPeriod + " Class " + classId);
      $.post("createScheduleSql.php", {
        action: "tlDataSub",
        classId: classId,
        sasDate: sasDate,
        sasPeriod: sasPeriod
      }, function(data, status) {
        subDate = getFormattedDate(sasDate, "dmY");
        $('#modal_title').text("Substitute Schedule");
        $('#actionSub').val("subSchedule");
        $('#tlDataSub').html(data);
        $('#subDetailsM').html("Substituting for " + sasDate + " Period " + sasPeriod);
        $('#subDateM').val(sasDate);
        $('#subPeriodM').val(sasPeriod);
        $('#subClassM').val(classId);
        $('.subStaffForm').hide();
        $('.subTLForm').show();
        $('#substituteModal').modal('show');
      }).fail(function() {
        $.alert("Failed");
      })
    });

    $(document).on('click', '.substituteStaff', function() {
      var sasId = $(this).attr("data-sas");
      //var classId = $(this).attr("data-class");
      $.alert("Substitute Pressed SASID" + sasId);
      $.post("createScheduleSql.php", {
        action: "subStaffForm",
        //classId: classId,
        sasId: sasId
      }, function(data, status) {
        $('#modal_title').text("Substitute Staff");
        $('#actionSub').val("subStaff");
        $('#modalIdSub').val(sasId);
        $('#subStaffM').html(data);
        $('#sasIdM').val(sasId);
        $('.subStaffForm').show();
        $('.subTLForm').hide();
        $('#substituteModal').modal('show');
      }).fail(function() {
        $.alert("Failed");
      })
    });

    $(document).on('click', '.dropSchedule', function() {
      var sasId = $(this).attr("data-sas");
      // $.alert("Drop Schedule Pressed " + sasId);

      $.post("createScheduleSql.php", {
        action: "dropSchedule",
        sasId: sasId
      }, function(data, status) {
        //$.alert(data + sasId);
        $('#sas' + sasId).html(data);
      }, "text").fail(function() {
        $.alert("Fail");
      })
    });

    $(document).on('click', '.sclCS, .checkAll, .uncheckAll', function() {
      var checkboxes_value = [];
      $('.sclCS').each(function() {
        if (this.checked) {
          checkboxes_value.push($(this).val());
        }
      });
      $.alert("Register Pressed " + checkboxes_value);
      if (checkboxes_value == "") {
        $.alert("Please Select atleast One Class");
        $('#createScheduleForm').hide();
        $('#createScheduleOutput').hide();
      } else {
        $.post("createScheduleSql.php", {
          action: "createScheduleForm",
          checkboxes_value: checkboxes_value
        }, function(data, status) {
          $('#createScheduleForm').show();
          $('#createScheduleOutput').show();
          $('#createScheduleForm').html(data);
        }, "text").fail(function() {
          $.alert("Fail");
        })
      }
    });

    $(document).on('click', '.createScheduleButton', function() {
      var classId = $('#sel_class').val();
      var scheduleFrom = $('#schedule_from').val();
      var scheduleTo = $('#schedule_to').val();
      $.alert("Class " + classId + " From " + scheduleFrom + " To " + scheduleTo);
      $.post("createScheduleSql.php", {
        classId: classId,
        scheduleFrom: scheduleFrom,
        scheduleTo: scheduleTo,
        action: "createSchedule"
      }, function(data, status) {
        $('#createScheduleForm').show();
        $('#createScheduleOutput').html(data);
        $("#waiting").html("");
      }, "text").fail(function() {
        $.alert("Fail");
      })
    });
    $(document).on('click', '.showScheduleButton', function() {
      var classId = $('#sel_class').val();
      var scheduleFrom = $('#schedule_from').val();
      var scheduleTo = $('#schedule_to').val();
      $.alert("Class " + classId + " From " + scheduleFrom + " To " + scheduleTo);
      $.post("createScheduleSql.php", {
        classId: classId,
        scheduleFrom: scheduleFrom,
        scheduleTo: scheduleTo,
        action: "showSchedule"
      }, function(data, status) {
        $('#createScheduleForm').show();
        $('#createScheduleOutput').html(data);
        $("#waiting").html("");
      }, "text").fail(function() {
        $.alert("Fail");
      })
    });

    $(document).on('click', '.increDecre', function() {
      var id = $(this).attr('id');
      var value = $(this).attr("data-value");
      $.alert("Id " + id + "Value" + value);
      $.post('scheduleSql.php', {
        id: id,
        value: value,
        action: "increDecre"

      }, function(data, status) {
        classList();
        //$.alert("Updated !! " + data);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });

    $(document).on('click', '.dayName', function() {
      var classId = $("#sel_class").val();
      var classPeriod = $("#classPeriod").val();
      var id = $(this).attr('id');
      var status = $(this).is(":checked");
      // $(".waiting").show();
      //$.alert("DayName " + id + "Status" + status);
      if (status == true) {
        $.post("scheduleSql.php", {
          action: "day",
          classId: classId,
          classPeriod: classPeriod,
          dayId: id,
          dayStatus: status
        }, function(data, status) {
          //$.alert(data);
          if (id == "Mon") {
            $('#mondayList').html(data);
            $('#mondayList').show();
          } else if (id == "Tue") {
            $('#tuesdayList').html(data);
            $('#tuesdayList').show();
          } else if (id == "Wed") {
            $('#wednesdayList').html(data);
            $('#wednesdayList').show();
          } else if (id == "Thu") {
            $('#thursdayList').html(data);
            $('#thursdayList').show();
          } else if (id == "Fri") {
            $('#fridayList').html(data);
            $('#fridayList').show();
          } else if (id == "Sat") {
            $('#saturdayList').html(data);
            $('#saturdayList').show();
          } else if (id == "Sun") {
            $('#sundayList').html(data);
            $('#sundayList').show();
          }
          $(".waiting").hide();
        }, "text").fail(function() {
          $.alert("Failed !!");
        })
      } else {
        if (id == "Mon") $('#mondayList').hide();
        else if (id == "Tue") $('#tuesdayList').hide();
        else if (id == "Wed") $('#wednesdayList').hide();
        else if (id == "Thu") $('#thursdayList').hide();
        else if (id == "Fri") $('#fridayList').hide();
        else if (id == "Sat") $('#saturdayList').hide();
        else if (id == "Sun") $('#sundayList').hide();
      }
    });

    $(document).on("click", ".openModalAssignStaff", function() {
      var tlg_id = $(this).attr('id');
      var group = $(this).attr('data-group');
      var subject = $(this).attr('data-subject');
      var type = $(this).attr('data-type');
      //$.alert("tlg " + tlg_id + " Group " + group + " Subject " + subject);
      $('#modal_title').text("Assign Staff");
      $('#action').val("assignStaff");
      $('#submitModalForm').show();
      $('#submitModalForm').html("Submit");

      $('#subjectName').html(subject);
      $('#loadType').html(type);
      $('#tlg_idM').val(tlg_id);
      $('#tl_groupM').val(group);
      if (type == "L") $('#loadGroup').html("LG-" + group);
      else if (type == "T") $('#loadGroup').html("TG-" + group);
      else $('#loadGroup').html("PG-" + group);


      $(".classForm").hide()
      $(".uploadTTForm").hide()
      $(".clashForm").hide()

      $(".assignStaff").show()
      $('#firstModal').modal('show');

    });

    $(document).on("click", ".dropClashButton", function() {
      var classId = $('#sel_class').val();
      var tlId = $(this).attr('data-tlDrop');
      var day = $(this).attr('data-dayDrop');
      var period = $(this).attr('data-periodDrop');
      $.alert(" Class  " + classId + " TLID " + tlId + " Day " + day + " Period " + period);
      $.post("scheduleSql.php", {
        action: "dropSlot",
        tlId: tlId,
        classId: classId,
        day: day,
        period: period
      }, function(data, status) {
        //$.alert("Day " + day + " Period " + period + " Data " + data);
        $('#' + day + period).html(data);
      }).fail(function() {
        $.alert("Error!!");
      })
    });

    $(document).on("click", ".addSlot", function() {
      var classId = $('#sel_class').val();
      var tlId = $(this).attr('id');
      var day = $(this).attr('data-day');
      var period = $(this).attr('data-period');
      //$.alert(" Class  " + classId + " TLID " + tlId + " Day " + day + " Period " + period);
      $.post("scheduleSql.php", {
        action: "addSlot",
        tlId: tlId,
        classId: classId,
        day: day,
        period: period
      }, function(data, status) {
        //$.alert("Day " + day + " Period " + period + " Data " + data);
        $('#' + day + period).html(data);
      }).fail(function() {
        $.alert("Error!!");
      })
    });

    $(document).on("click", ".uploadTTLink", function() {
      var classId = $('#sel_class').val();
      var type = $(this).attr('data-type');
      var day = $(this).attr('data-day');
      var period = $(this).attr('data-period');
      //$.alert(" Class  " + classId + " Day " + day + " Period " + period);
      $.post("scheduleSql.php", {
        action: "tlData",
        tlgType: type,
        classId: classId,
        day: day,
        period: period
      }, function(data, status) {
        //$.alert("done");
        $('#tlData').html(data);
        $('#modal_title').text("Assign Time Slot ");
        $('#action').val("timeSlot");
        $('#submitModalForm').hide();

        $('#dayNameM').html(day);
        $('#periodM').html(period);

        $(".classForm").hide();
        $(".assignStaff").hide();
        $(".clashForm").hide();

        $(".uploadTTForm").show();
        $('#firstModal').modal('show');
      }).fail(function() {
        $.alert("Error!!");
      })
    });

    $(document).on("click", ".resolveClashButton", function() {
      var classId = $('#sel_class').val();
      var dayId = $(this).attr('data-day');
      var tlId = $(this).attr('data-tlId');
      var period = $(this).attr('data-period');
      //var displayString = $(this).attr('data-string');
      $.alert(" TlId  " + tlId + " Day " + dayId + " Period " + period);
      $.post("scheduleSql.php", {
        action: "clashForm",
        classId: classId,
        dayId: dayId,
        tlId: tlId,
        period: period
      }, function(data, status) {
        //$.alert("done");
        $('#modal_titleClass').text("Resolve Clashes from Time Table");
        //$('#action').val("dropSlot");
        $('#clashData').html(data);

        $('#tlIdM').val(tlId);
        $('#dayM').val(dayId);
        $('#classIdM').val(classId);
        $('#dropPeriodM').val(period);

        $('#submitModalForm').hide();

        $(".classForm").hide();
        $(".assignStaff").hide();
        $(".uploadTTForm").hide();

        $(".clashForm").show()

        $('#firstModal').modal('show');
      })
    });

    $(document).on('submit', '#modalForm', function(event) {
      event.preventDefault(this);
      var action = $("#action").val();
      //$.alert("Form Submitted " + action);
      var error = "NO";
      var error_msg = "";
      if (action == "addClass" || action == "updateClass") {
        if ($('#class_name').val() === "" || $('#sel_batch').val() === "") {
          error = "YES";
          error_msg = "Class/Batch cannot be blank";
        }
      } else if (action == "assignStaff" || action == "updateStaff") {
        if ($('#sel_staff').val() === "") {
          error = "YES";
          error_msg = "Select Staff to Assign Staff for the Selected Load";
        }
      }
      if (error == "NO") {
        var formData = $(this).serialize();
        $.alert(formData);
        $.post("scheduleSql.php", formData, () => {}, "text").done(function(data) {
          //$.alert(data);
          if (action == "addClass" || action == "updateClass") {
            var x = $("#sel_program").val();
            classList(x);
          } else if (action == "assignStaff" || action == "updateStaff") {
            var classId = $("#sel_class").val();
            if (classId > 0) tlList(classId);
            else $.alert(" Select Class ");
          }
          $('#firstModal').modal('hide');
          $('#modalForm')[0].reset();
        }).fail(function() {
          $.alert("fail in place of error");
        })
      } else {
        $.alert(error_msg);
      }
    });

    function tlList(x) {
      //$.alert("Class " + x);
      $.post("scheduleSql.php", {
        classId: x,
        action: "tl"
      }, function(mydata, mystatus) {
        $("#tlList").show();
        //$.alert("List " + mydata);
        $("#tlList").html(mydata);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    }

    function ttList() {
      //$.alert("Class " + x);
      var classId = $("#sel_class").val();
      $.post("scheduleSql.php", {
        classId: classId,
        action: "tt"
      }, function(mydata, mystatus) {
        //$("#ttList").show();
        //$.alert("List " + mydata);
        $("#dayList").html(mydata);
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    }

    function classList(programId) {
      //$.alert("In List Function" + programId);
      $.post("scheduleSql.php", {
        action: "clList",
        programId: programId
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#clList").html(data);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function sessionClass() {
      var panelId = $('#panelId').text();
      if (panelId == "STT") var actionText = 'sessionClassListSTT';
      else var actionText = 'sessionClassList';
      $.alert("In List Function " + actionText + "Panel " + panelId);
      $.post("createScheduleSql.php", {
        action: actionText
      }, function(data, status) {
        //$.alert("Success " + data);
        if (panelId == "STT") $("#sessionClassListSTT").html(data);
        else $("#sessionClassList").html(data);
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
<div class="modal" id="substituteModal">
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" id="modalFormSub">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->

        <!-- Modal body -->
        <div class="modal-body">

          <div class="subTLForm">
            <div class="row">
              <div class="col" id="subDetailsM"></div>
            </div>
            <div class="row">
              <div class="col-12" id="tlDataSub"></div>
            </div>
          </div>

          <div class="subStaffForm">
            <div class="row">
              <div class="col" id="subStaffM"></div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="modalIdSub" name="modalIdSub">
          <input type="hidden" id="actionSub" name="action">
          <input type="hidden" id="subDateM" name="subDateM">
          <input type="hidden" id="subPeriodM" name="subPeriodM">
          <input type="hidden" id="subClassM" name="subClassM">
          <button type="submit" class="btn btn-success btn-sm" id="submitModalFormSub">Submit</button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->

    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

<!-- Modal Section-->
<div class="modal" id="firstModal">
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" id="modalForm">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_titleClass"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->

        <!-- Modal body -->
        <div class="modal-body">
          <div class="classForm">
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Class Name
                  <input type="text" class="form-control form-control-sm" id="class_name" name="class_name" placeholder="Class Name">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Semester
                  <input type="number" class="form-control form-control-sm" id="class_semester" name="class_semester" placeholder="semester">
                </div>
              </div>
              <div class="col-3">
                <div class="form-group">
                  Section
                  <input type="text" class="form-control form-control-sm" id="class_section" name="class_section" placeholder="Section">
                </div>
              </div>
            </div>
            <div class="row">

              <div class="col">
                <div class="form-check-inline"> Class Shift </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" checked id="morning" name="class_shift" value="Morning">Morning
                </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" id="evening" name="class_shift" value="Evening">Evening
                </div>
              </div>
            </div>
          </div>
          <div class="uploadTTForm">
            <div class="row">
              <label class="col-md-3 text-right"><b>Day</b></label>
              <div class="col-md-3" id="dayNameM"></div>
              <label class="col-md-3 text-right"><b>Period</b></label>
              <div class="col-md-3" id="periodM"></div>
            </div>
            <div class="row">
              <div class="col-12" id="tlData"></div>
            </div>
          </div>
          <div class="clashForm">
            <div class="row">
              <div class="col-md-12" id="clashId"></div>
            </div>
            <div class="row">
              <div class="col-12" id="clashData"></div>
            </div>
          </div>

          <div class="assignStaff">
            <div class="row">
              <label class="col-md-3 text-right"><b>Subject</b></label>
              <div class="col-md-8" id="subjectName"></div>
            </div>
            <div class="row">
              <label class="col-md-3 text-right"><b>Type</b></label>
              <div class="col-md-3" id="loadType"></div>
              <label class="col-md-3 text-right"><b>Group</b></label>
              <div class="col-md-3" id="loadGroup"></div>
            </div>
            <div class="row">
              <label class="col-md-3 text-right"><b>Staff</b></label>
              <div class="col-md-9">
                <?php
                $sql = "select s.* from staff s where s.staff_status='0' order by staff_name";
                selectList($conn, "Select Staff", array("0", "staff_id", "staff_name", "staff_id", "sel_staff"), $sql);
                ?>
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->

        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="modalId" name="modalId">
          <input type="hidden" id="action" name="action">
          <input type="hidden" id="tlg_idM" name="tlg_idM">
          <input type="hidden" id="tl_groupM" name="tl_groupM">
          <input type="hidden" id="tlIdM" name="tlIdM">
          <input type="hidden" id="dayM" name="dayM">
          <input type="hidden" id="dropPeriodM" name="dropPeriodM">
          <input type="hidden" id="classIdM" name="classIdM">

          <button type="submit" class="btn btn-success btn-sm" id="submitModalForm"></button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->

    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

</html>