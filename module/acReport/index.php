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
          <a class="list-group-item list-group-item-action attRep" data-toggle="list" href="#attRep" role="tab" aria-controls="attRep"> Attendance Report</a>
          <a class="list-group-item list-group-item-action marksRep" data-toggle="list" href="#marksRep" role="tab" aria-controls="marksRep"> Marks Report</a>
        </div>
      </div>
      <div class="col-11 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <p id="progClassList"></p>
          <div class="tab-pane show active" id="attRep" role="tabpanel" aria-labelledby="list-attReg-list">
            <div class="card mt-2 myCard">
              <div class="row m-2">
                <div class="col-12">
                  <div class="header"></div>
                  <div class="record overflow-auto"></div>
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

    pclList();
    //attRegHeaderFooter();
    //attRecord();
    // Subject Attendance Register
    $(document).on('click', '.attRep, .sel_class', function() {
      attRepHeaderFooter();
      attRecord();
    });

    function attRepHeaderFooter() {
      var class_id = $("input[name='class']:checked").val();
      // $.alert("In List Function" + class_id);
      $.post("acRepSql.php", {
        class_id: class_id,
        action: "fetchAttRepHeaderFooter"
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
        header += '</div>';
        $(".header").html(header)

      })
    }

    function attRecord() {
      var class_id = $("input[name='class']:checked").val();
      // $.alert("In List Function" + class_id);
      $.post("acRepSql.php", {
        class_id: class_id,
        action: "attRecord"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        console.log(data)
        var count = 1;
        var text = '';
        var text = '<table class="table list-table-xs" style="white-space: nowrap;">';
        text += '<tr>';
        text += '<td>#</td><td>Student Name </td><td>RNo</td><td>DoR</td>';
        for (var i = 0; i < data.subject_code.length; i++) {
          text += '<td>' + data.subject_code[i] + '</td>';
        }
        text += '</tr>';

        $.each(data.records, function(key, value) {
          text += '<tr>';
          text += '<td class="text-center">' + count++ + '</td>';
          text += '<td>' + value.student_name + '</td>';
          text += '<td>' + value.student_rollno + '</td>';
          text += '<td>' + getFormattedDate(value.rc_date, "dmY") + '</td>';
          for (var i = 0; i < value.scheduled.length; i++) {
            text += '<td>' + value.scheduled[i] + '</td>';
          }
          text += '</tr>';
        });
        text += '</table>';
        $(".record").html(text)
      })
    }

    function pclList() {
      //$.alert("In List Function");
      $.post("acRepSql.php", {
        action: "pclList"
      }, function() {}, "text").done(function(data, staus) {
        $("#progClassList").html(data);
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

</html>