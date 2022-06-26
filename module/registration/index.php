<?php
require('../requireSubModule.php');
addActivity($conn, $myId, "Registration", $submit_ts)
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>ClassConnect : Registration</title>
  <?php require("../css.php"); ?>
</head>

<body>
  <?php require("../topBar.php");
  if($myId>3){
    if (!isset($_GET['tag'])) die("Illegal Attempt !! The token is Missing");
    elseif (!in_array($_GET['tag'], $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
    elseif (!in_array("39", $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
  }
   ?>
  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-1 p-0 m-0 pl-1 full-height">
        <h5 class="mt-3">Registration</h5>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active cr" id="list-cr-list" data-toggle="list" href="#list-cr" role="tab"> Class Registration </a>
          <a class="list-group-item list-group-item-action subReg" id="list-subReg-list" data-toggle="list" href="#list-subReg" role="tab"> Subject Reg </a>
          <a class="list-group-item list-group-item-action regMap" data-toggle="list" href="#regMap" role="tab"> Registration Map</a>
        </div>
        <?php
        $sql = "select * from class where session_id='$mySes' and program_id='$myProg'";
        selectList($conn, "", array(0, "class_id", "class_name", "class_section", "sel_class"), $sql)
        ?>
      </div>
      <div class="col-11 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane show active" id="list-cr" role="tabpanel">
            <div class="row">
              <div class="col-8">
                <div class="container card myCard">
                  <p id="sbpList"></p>
                </div>
                <div class="container card myCard mt-2">
                  <span style="font-size: 12px;">
                    <ul>
                      <li>The Students will be registered in the Class and Group.</li>
                      <li>These are the default classes and groups for all academic purposes.</li>
                      <li>The Class and Group can be changed for different Subjects.</li>
                      <li>The <i>Daily Class Attendance</i> and <i>Subject Marks Entry</i> will be entered for the Class they are registered for that Subject.</li>
                      <li>So, Class wise students list will consider Class Registration and the Subject wise data entry will consider Subject Registration.</li>
                    </ul>
                  </span>
                </div>
              </div>
              <div class="col-4">
                <h5>Update Class Registration</h5>
                <div class="card mt-4">
                  <div class="col-sm-3 p-0">
                    <input type="number" class="form-control form-control-sm" id="new_group" name="new_group" min='1' value="1">
                  </div>
                  <div class="col-sm-9 p-0">
                    <button class="btn btn-default btn-block m-0 updateRegistration" data-tag="rc_group">Update Group</button>
                  </div>
                </div>
                <div class="card mt-4 border">
                  <div class="col-sm-6 p-0">
                    <input type="date" class="form-control form-control-sm" id="new_dor" name="new_dor" value="<?php echo $submit_date; ?>">
                  </div>
                  <div class="col-sm-9 p-0">
                    <button class="btn btn-default btn-block m-0 updateRegistration" data-tag="rc_date">Update Reg. Date</button>
                  </div>
                </div>
                <div class="card mt-4">
                  <div class="col-sm-6 p-0">
                    <?php
                    $sql = "select * from class where session_id='$mySes' and program_id='$myProg'";
                    selectList($conn, "", array(0, "class_id", "class_name", "class_section", "new_class"), $sql)
                    ?>
                  </div>
                  <div class="col-sm-9 p-0">
                    <button class="btn btn-default btn-block m-0 updateRegistration" data-tag="class_id">Update Class</button>
                  </div>
                </div>
                <div class="card mt-4">
                  <div class="col-sm-6 p-0">
                    <input type="text" class="form-control form-control-sm" id="ur_remarks" name="ur_remarks" placeholder="Remarks">
                  </div>
                  <div class="col-sm-9 p-0">
                    <button class="btn btn-default btn-block m-0 updateRegistration" data-tag="rc_status">Unregister</button>
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col">
                    <b><i>Only Selected Registered Students will be affected by Update</b></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-subReg">
            <div class="row">
              <div class="col-7 mt-1 mb-1">
                <div class="container card myCard">
                  <p id="classList"></p>
                </div>
              </div>
              <div class="col-5 mt-1 mb-1">
                <div class="container card myCard">
                  <p id="classSubjectList"></p>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="regMap" role="tabpanel" aria-labelledby="list-regMap-list">
            <div class="text-center largeText text-secondary">
              Subject Registration Map for <span class="className"></span>
            </div>
            <table class="table table-bordered table-striped list-table-xs mt-4" id="regMapList">
            </table>
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
    $(function() {
      $(document).tooltip();
    });
    $(".topBarTitle").text("Registration");
    sbpList("25", "0");
    classSubject();

    $(document).on('click', '.regMap', function() {
      var class_id = $("#sel_class").val()
      // $.alert("Class " + class_id)
      var className = $("#sel_class :selected").text()
      $(".className").html(className)
      $.post("registrationSql.php", {
        class_id: class_id,
        action: "regMapList"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        console.log(data);
        var card = '';
        var count = 1;
        card += '<tr>'
        card += '<th>#</th><th>Id</th><th>RollNo</th><th>Name</th><th>UserId</th>'
        $.each(data.subject, function(key, value) {
          card += '<th><spam title="'+value.subject_name+'">' + value.subject_code + '<br>[' + value.subject_credit + ']' + value.tlg_type + '-' + value.tl_group + '</spam></th>';
        })
        card += '<th>Subject</th>'
        card += '</tr>'
        $.each(data.student, function(key, value) {
          card += '<tr>';
          card += '<td>' + count++ + '</td>';
          card += '<td>' + value.student_id + '</td>';
          card += '<td>' + value.user_id + '</td>';
          card += '<td>' + value.student_name + '</td>';
          card += '<td>' + value.student_rollno + '</td>';
          var registeredSubject = 0;
          $.each(value.regMap, function(key2, value2) {
            if (value2.registered == 1) {
              registeredSubject++
              card += '<td class="click text-center"><a href="#" class="stdSubReg" data-student="' + value.student_id + '" data-tl="' + value2.tl_id + '" data-value="0"><span class="std' + value.student_id + 'tl' + value2.tl_id + '""><i class="fa fa-check"></i></span></a></td>';
            } else card += '<td class="click text-center"><a href="#" class="stdSubReg" data-student="' + value.student_id + '" data-tl="' + value2.tl_id + '" data-value="1"><span class="std' + value.student_id + 'tl' + value2.tl_id + '""><i class="fa fa-times"></i></span></a></td>';
          })
          card += '<td class="text-center"><span class="subCount' + value.student_id + '">' + registeredSubject + '</span></td>';
          card += '</tr>';
        });
        $("#regMapList").html(card);

      }).fail(function() {
        $.alert("Error in Map Generation !!");
      })
    });

    $(document).on('click', '.stdSubReg', function() {
      var student_id = $(this).attr("data-student")
      var tl_id = $(this).attr("data-tl")
      var value = $(this).attr("data-value")
      var subCount = $(".subCount" + student_id).text()
      // $.alert(" Student Subject Registration " + tl_id + "Student " + student_id + " Value " + value + " Count " + subCount);

      $.post("registrationSql.php", {
        student_id: student_id,
        tl_id: tl_id,
        value: value,
        action: "stdSubReg"
      }, function() {}, "text").done(function(data, status) {
        // $.alert(data);
      }).fail(function() {
        $.alert("Fail");
      })

      if (value == "0") {
        $(".std" + student_id + "tl" + tl_id).html('<i class="fa fa-times"></i>')
        $(this).attr("data-value", 1)
        subCount--
        $(".subCount" + student_id).text(subCount)
      } else {
        $(".std" + student_id + "tl" + tl_id).html('<i class="fa fa-check"></i>')
        $(this).attr("data-value", 0)
        subCount++
        $(".subCount" + student_id).text(subCount)
      }
    });

    $(document).on('change', '#sel_class', function() {
      sbpList("25", "0");
      classSubject();
      classList("25", "0");
    });

    $(document).on('click', '.subReg', function() {
      //$.alert("Registration");
      classList("25", "0");
      classSubject();
    });

    $(document).on('click', '.cr', function() {
      //$.alert("Registration");
      sbpList("25", "0");
      classSubject();
    });

    $(document).on('click', '.register', function() {
      var classId = $("#sel_class").val();
      var class_group = $("#sel_cg").val();
      var rpp = $("#sbp_rpp").val();
      var startRecord = $("#currentRecord").text();
      var checkboxes_value = [];
      $('.sbp').each(function() {
        if (this.checked) {
          checkboxes_value.push($(this).val());
        }
      });
      $.alert("Register Pressed " + checkboxes_value + "Start " + startRecord + "CG " + class_group);
      $.post("registrationSql.php", {
        checkboxes_value: checkboxes_value,
        classId: classId,
        class_group: class_group,
        action: "register"

      }, function(data, status) {
        $.alert(data);
        sbpList(rpp, startRecord);
      }).fail(function() {
        $.alert("Fail");
      })
    });

    $(document).on('click', '.updateRegistration', function() {
      var tag = $(this).attr("data-tag");
      if (tag == "rc_group") var value = $("#new_group").val();
      else if (tag == "class_id") var value = $("#new_class").val();
      else if (tag == "rc_date") var value = $("#new_dor").val();
      else var value = '9';
      var rpp = $("#rpp").val();
      var startRecord = $("#currentRecord").text();
      var checkboxes_value = [];
      $('.sbp').each(function() {
        if (this.checked) {
          checkboxes_value.push($(this).val());
        }
      });
      //$.alert("Register Pressed " + checkboxes_value + "Start " + startRecord + "Value " + value + " tag " + tag);
      $.post("registrationSql.php", {
        checkboxes_value: checkboxes_value,
        value: value,
        tag: tag,
        action: "updateRegistration"

      }, function(data, status) {
        $.alert(data);
        sbpList(rpp, startRecord);
      }, "text").fail(function() {
        $.alert("Fail");
      })
    });

    $(document).on('click', '.subjectRegistration', function() {
      var checkboxes_value = [];
      $('.cl').each(function() {
        if (this.checked) {
          checkboxes_value.push($(this).val());
        }
      });
      var status = $(this).is(":checked");
      var tlId = $(this).val();
      // $.alert("Register Pressed " + status + tlId);

      $.post("registrationSql.php", {
        tl: tlId,
        checkboxes_value: checkboxes_value,
        status: status,
        action: "subjectRegistration"
      }, function(data, status) {
        //$.alert(data);
        // sbpList(rpp, startRecord);
      }, "text").fail(function() {
        $.alert("Fail");
      })

    });

    $(document).on('change', '.sbp_rpp, .cl_rpp', function() {
      var classId = $("#sel_class").val();
      var startRecord = $(this).attr('data-start');
      var tag = $(this).attr('data-tag');
      var rpp = $("#" + tag + "_rpp").val();
      //$.alert("rpp " + rpp + " Class " + classId + " Tag " + tag);
      if (tag == "sbp") sbpList(rpp, startRecord);
      else if (tag == "cl") classList(rpp, startRecord);
      else $.alert("Select a Class ");
    });

    $(document).on('click', '.pageLink', function() {
      var classId = $("#sel_class").val();
      var startRecord = $(this).attr('data-start');
      var tag = $(this).attr('data-tag');
      var rpp = $("#" + tag + "_rpp").val();
      if (tag == "sbp") var action = "sbpList";
      else var action = "classList";
      $.alert("rpp " + rpp + "Start " + startRecord + " Class " + classId + " Tag " + tag + " action " + action);
      $.post('registrationSql.php', {
        classId: classId,
        startRecord: startRecord,
        rpp: rpp,
        action: action
      }, function(data, status) {
        //$.alert("Success " + data);
        if (tag == "sbp") $("#sbpList").html(data);
        else $("#classList").html(data);
        $("#currentRecord").hide();
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });

    $(document).on('click', '.checkUnCheck', function() {
      var status = $(this).is(":checked");
      var tag = $(this).attr("data-tag");
      if (tag == "cl") {
        if (status == false) $('.cl').prop('checked', false); // Unchecks it
        else $('.cl').prop('checked', true); // Unchecks it
      } else {
        if (status == false) $('.sbp').prop('checked', false); // Unchecks it
        else $('.sbp').prop('checked', true); // Unchecks it
      }
    });

    $(document).on('click', '.studentSubjectButton', function() {
      var id = $('#sel_class').val();
      var stdId = $(this).attr("id");
      //$.alert("StdId" + stdId);
      studentSubject(stdId);
    });

    $(document).on('click', '.stdsubCheckbox', function() {
      var stdId = $(this).attr('data-std');
      var subId = $(this).val();
      var status = $(this).is(":checked");
      //$.alert("Subject Check Box StdId " + stdId + " Sub " + subId + " Status" + status);
      $.post('registrationSql.php', {
        action: "updateSub",
        stdId: stdId,
        subId: subId,
        status: status
      }, function(data, status) {
        //$.alert("Registration Updated !! " + data);
        studentSubject(stdId);

      }, "text")
    });

    function classList(y, z) {
      var x = $("#sel_class").val();
      //$.alert("In Class-Subject Function Class Id" + x);
      $.post("registrationSql.php", {
        classId: x,
        rpp: y,
        startRecord: z,
        action: "classList"
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#classList").html(data);
        $("#currentRecord").hide();
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function studentSubject(y) {
      // $.alert("In Student-Subject Function Student Id" + x);
      $.post("registrationSql.php", {
        action: "stdSub",
        stdId: y
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#classSubjectList").html(data);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function sbpList(y, z) {
      var x = $("#sel_class").val();
      //$.alert("In Class-Subject Function Class Id" + x);
      $.post("registrationSql.php", {
        classId: x,
        rpp: y,
        startRecord: z,
        action: "sbpList"
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#sbpList").html(data);
        $("#currentRecord").hide();
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function classSubject() {
      var x = $("#sel_class").val();
      //$.alert("In Class-Subject Function Class Id" + x);
      $.post("registrationSql.php", {
        action: "clSub",
        classId: x
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#classSubjectList").html(data);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }
  });
</script>

</html>