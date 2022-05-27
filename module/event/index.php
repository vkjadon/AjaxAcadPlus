<?php
require('../requireSubModule.php');

$sql = "select * from leave_duration";
$result = $conn->query($sql);
if ($result && $result->num_rows == 1) {
  $rowsArray = $result->fetch_assoc();
  $short_leave = $rowsArray['short_leave'];
  $half_day = $rowsArray['half_day'];
  $update_ts = $rowsArray['update_ts'];
  $update_id = $rowsArray['update_id'];
} elseif ($result && $result->num_rows == 0) {
  $short_leave = "2"; // hours
  $half_day = "4";    // hours
} else echo $conn->error;

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Event Module : ClassConnect</title>
  <?php require("../css.php"); ?>
</head>

<body>
  <?php require("../topBar.php"); ?>

  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-md-6">
        <div class="card p-3 myCard">
          <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="pill" href="#feDetails" role="tab" aria-controls="feDetails" aria-selected="true">Event Details</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="pill" href="#feSummary" role="tab" aria-controls="feSummary" aria-selected="true">Event Summary</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="pill" href="#facultyEvents" role="tab" aria-controls="facultyEvents" aria-selected="true">Faculty Events</a>
            </li>

            <li class="nav-item">
              <a class="nav-link announcement" data-toggle="pill" href="#announcement" role="tab" aria-controls="calendar" aria-selected="true">Student Awards</a>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent p-3">
            <span id="feSelected"><h3> No Event Selected </h3></span>
            <div class="tab-pane show active" id="feDetail" role="tabpanel" aria-labelledby="feDetail">
              
            </div>
            <div class="tab-pane" id="feSummary" role="tabpanel" aria-labelledby="feSummary">
            </div>
            <div class="tab-pane" id="facultyEvents" role="tabpanel" aria-labelledby="facultyEvents">
              <form class="form-horizontal" id="facultyEventsForm">
                <h4>Faculty Event</h4>
                <div class="facultyEventsForm">
                  <div class="row m-3">
                    <div class="col-6 py-1">
                      <div class="form-check-inline">
                        <input type="radio" class="form-check-input" id="offline" checked name="fe_mode" value="1">Offline
                      </div>
                      <div class="form-check-inline">
                        <input type="radio" class="form-check-input" id="online" name="fe_mode" value="2">Online
                      </div>
                      <div class="form-check-inline">
                        <input type="radio" class="form-check-input" id="hybrid" name="fe_mode" value="3">Hybrid
                      </div>
                    </div>
                    <div class="col-6 py-1">
                      <div class="form-check-inline">
                        <input type="radio" class="form-check-input" id="faculty" checked name="fe_participant" value="1">Faculty
                      </div>
                      <div class="form-check-inline">
                        <input type="radio" class="form-check-input" id="student" name="fe_participant" value="2">Student
                      </div>
                      <div class="form-check-inline">
                        <input type="radio" class="form-check-input" id="both" name="fe_participant" value="3">Both
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-3 pr-0">
                      <div class="form-group">
                        Type
                        <select class="form-control form-control-sm" id="fe_type" name="fe_type">
                          <option value="1">FDP [1]</option>
                          <option value="2">Workshop [2]</option>
                          <option value="3">Seminar [3] </option>
                          <option value="4">Conference</option>
                          <option value="5">Symposium</option>
                          <option value="7">Orientation Program/Induction Program</option>
                          <option value="9">Refreshers/Short Term Courses</option>
                          <option value="10">Sports/Cultural</option>
                          <option value="11">Coaching</option>
                          <option value="12">Career Counselling</option>
                          <option value="13">Extension and outreach programs</option>
                          <option value="14">Soft Skill</option>
                          <option value="15">Language and communication skills</option>
                          <option value="16">Life skills (Yoga, physical fitness, health and hygiene)</option>
                          <option value="17">Awareness of trends in technology</option>
                          <option value="18">Research methodology, Intellectual Property Rights (IPR),entrepreneurship, skill development </option>
                        </select>
                      </div>
                    </div>
                    <div class="col-7 pl-1 pr-0">
                      <div class="form-group">
                        Name
                        <input type="text" class="form-control form-control-sm" id="fe_name" name="fe_name" placeholder="Event Name" required>
                      </div>
                    </div>
                    <div class="col-2 pl-1">
                      <div class="form-group">
                        Abbri
                        <input type="text" class="form-control form-control-sm" id="fe_abbri" name="fe_abbri" placeholder="Abbri" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-3 pr-0">
                      <div class="form-group">
                        Date From
                        <input type="date" class="form-control form-control-sm" id="fe_date_from" name="fe_date_from" value="<?php echo $submit_date; ?>">
                      </div>
                    </div>
                    <div class="col-3 pl-1 pr-0">
                      <div class="form-group">
                        Time From
                        <input type="time" class="form-control form-control-sm" id="fe_time_from" name="fe_time_from" value="<?php echo date("h:i"); ?>">
                      </div>
                    </div>
                    <div class="col-3 pl-1 pr-0">
                      <div class="form-group">
                        Date To
                        <input type="date" class="form-control form-control-sm" id="fe_date_to" name="fe_date_to" value="<?php echo $submit_date; ?>">
                      </div>
                    </div>
                    <div class="col-3 pl-1">
                      <div class="form-group">
                        Time To
                        <input type="time" class="form-control form-control-sm" id="fe_time_to" name="fe_time_to" value="<?php echo date("h:i"); ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-4 pr-0">
                      <div class="form-group">
                        URL
                        <input type="text" class="form-control form-control-sm" id="fe_url" name="fe_url" placeholder="Webinar Link">
                      </div>
                    </div>
                    <div class="col-4 pl-1 pr-0">
                      <div class="form-group">
                        Rgistration Link
                        <input type="text" class="form-control form-control-sm" id="fe_registration_link" name="fe_registration_link" placeholder="Registration Link">
                      </div>
                    </div>
                    <div class="col-4 pl-1">
                      <div class="form-group">
                        Webinar Link
                        <input type="text" class="form-control form-control-sm" id="fe_webinar_link" name="fe_webinar_link" placeholder="Webinar Link">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-4 pr-0">
                      <div class="form-group">
                        <label>Institute/School</label>
                        <p id="schoolOption"></p>
                      </div>
                    </div>
                    <div class="col-4 pr-1 pr-0">
                      <div class="form-group">
                        <label>Department</label>
                        <p id="departmentOption">Select a Department</p>
                      </div>
                    </div>
                    <div class="col-4 pl-1">
                      <div class="form-group">
                        <label>SPOC</label>
                        <p id="staffOption">Select a SPOC</p>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        Remarks
                        <textarea class="form-control form-control-sm" rows="4" id="fe_remarks" name="fe_remarks" placeholder="Event Remarks"></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <input type="hidden" id="fe_id" name="fe_id" value="0">
                <input type="hidden" id="action" name="action" value="feUpdate">
                <button type="submit" class="btn btn-sm" id="submitForm">Save/Update</button>
              </form>
            </div>
            <div class="tab-pane" id="discussion" role="tabpanel" aria-labelledby="discussion">
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <table class="table table-bordered table-striped list-table-xs feTable">
          <th>#</th>
          <th>Date</th>
          <th>Type</th>
          <th>Event Name</th>
          <th>Actions</th>
        </table>
      </div>
    </div>
  </div>
  <?php require("../bottom_bar.php"); ?>
</body>
<script>
  $(document).ready(function() {

    fe_type_array = ["", "FDP", "Workshop", "Seminar", "Conference", "Symposium", "Orientation Program/Induction Program", "Refreshers/Short Term Courses", "Sports/Cultural", "Coaching", "Career Counselling", "Extension and outreach programs", "Soft Skill", "Language and communication skills", "Life skills (Yoga, physical fitness, health and hygiene)", "Awareness of trends in technology", "Research methodology, Intellectual Property Rights (IPR),entrepreneurship, skill development "];

    schoolOption();
    departmentOption();
    staffOption();

    feList();

    function schoolOption() {
      // $.alert("Department ");
      $.post("eventSql.php", {
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

    $(document).on('change', '#sel_school', function() {
      departmentOption();
    });

    function departmentOption() {
      var schoolId = $("#sel_school").val()
      // $.alert("School " + schoolId);
      $.post("eventSql.php", {
        schoolId: schoolId,
        action: "departmentOption"
      }, function() {}, "json").done(function(data, status) {
        // $.alert("List " + data);
        var list = '';
        list += '<select class="form-control form-control-sm" name="sel_dept" id="sel_dept">';
        list += '<option value="0">Select a Department</option>'
        $.each(data, function(key, value) {
          list += '<option value=' + value.dept_id + '>' + value.dept_name + '</option>';
        });
        list += '</select>';
        $("#departmentOption").html(list);

      }).fail(function() {
        $.alert("Error !!");
      })

    }

    $(document).on('change', '#sel_dept', function() {
      staffOption();
    });

    function staffOption() {
      var schoolId = $("#sel_school").val()
      var deptId = $("#sel_dept").val()
      // $.alert("School " + schoolId);
      $.post("eventSql.php", {
        schoolId: schoolId,
        deptId: deptId,
        action: "staffOption"
      }, function() {}, "json").done(function(data, status) {
        // $.alert("List " + data);
        var list = '';
        list += '<select class="form-control form-control-sm" name="sel_staff" id="sel_staff">';
        list += '<option value="0">Select a SPOC</option>'
        $.each(data, function(key, value) {
          list += '<option value=' + value.staff_id + '>' + value.staff_name + '[' + value.user_id + ']</option>';
        });
        list += '</select>';
        $("#staffOption").html(list);

      }).fail(function() {
        $.alert("Error !!");
      })
    }

    $(document).on('submit', '#facultyEventsForm', function(event) {
      event.preventDefault(this);
      var formData = $(this).serialize();
      // $.alert(formData);
      $.post("eventSql.php", formData, () => {}, "text").done(function(data, status) {
        // $.alert("List Updtaed" + data);
        $("#facultyEventsForm")[0].reset();
        feList();
      })
    });

    function feList() {
      // $.alert("sd");
      $.post("eventSql.php", {
        action: "feList"
      }, () => {}, "json").done(function(data, status) {
        // $.alert(data);
        var card = '';
        var count = 1;
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td>' + count++;
          card += '<a href="#" class="fa fa-pencil-alt feEdit" data-id="' + value.fe_id + '" title="Edit the meeting"></a>';
          card += '</td>';
          card += '<td>' + getFormattedDate(value.fe_date_from, "dmY") + '</td>';
          card += '<td>' + fe_type_array[value.fe_type] + '</td>';
          card += '<td>';
          card += '<span>' + value.fe_name + ' [' + value.fe_abbri + ']</span>';
          card += '</td>';
          card += '<td>';
          if (value.fe_status == '1') card += '<a href="#" class="scheduleApprove" data-id="' + value.fe_id + '" title="Retrieve to the List"><i class="fa fa-refresh approve"></i></a>';
          else card += '<a href="#" class="scheduleRemove" data-sdl="' + value.fe_id + '" title="Remove from the List"><i class="fa fa-times warning"></i></a>';
          card += '</td>';
          card += '</tr>';
        })
        $(".feTable").find("tr:gt(0)").remove();
        $(".feTable").append(card);
      })
    }

    $(document).on('click', '.feEdit', function() {
      var fe_id = $(this).attr("data-id");
      $("#fe_id").val(fe_id)
      // $.alert("Event " + fe_id);
      $.post("eventSql.php", {
        fe_id: fe_id,
        action: "feFetch"
      }, () => {}, "json").done(function(data, status) {
        // $.alert(data);
        if (data.fe_mode == '1') $("#offline").prop("checked", true);
        else if (data.fe_mode == '2') $("#online").prop("checked", true);
        else $("#hybrid").prop("checked", true);

        if (data.fe_participant == '1') $("#faculty").prop("checked", true);
        else if (data.fe_participant == '2') $("#student").prop("checked", true);
        else $("#both").prop("checked", true);

        $("#fe_name").val(data.fe_name)
        $("#fe_abbri").val(data.fe_abbri)
        $("#fe_date_from").val(data.fe_date_from)
        $("#fe_time_from").val(data.fe_time_from)
        $("#fe_time_to").val(data.fe_time_to)
        $("#registration_link").val(data.registration_link)
        $("#webinar_ink").val(data.webinar_ink)
        $("#fe_remarks").val(data.fe_remarks)
        $("#sel_staff").val(data.staff_id)
      })
    })

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

</html>