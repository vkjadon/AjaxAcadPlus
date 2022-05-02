<?php
require('../requireSubModule.php');
$phpFile = "userSql.php";
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
          <h5>Manage Users</h5>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <?php
          if (in_array("17", $myLinks)) echo '<a class="list-group-item active list-group-item-action aru" id="list-aru-list" data-toggle="list" href="#list-aru" role="tab" aria-controls="aru">User</a>';
          if (in_array("18", $myLinks)) echo '<a class="list-group-item list-group-item-action ml" id="list-ml-list" data-toggle="list" href="#list-ml" role="tab" aria-controls="ml">Responsibility Link</a>';
          if (in_array("19", $myLinks)) echo '<a class="list-group-item list-group-item-action ulr" id="list-ulr-list" data-toggle="list" href="#list-ulr" role="tab" aria-controls="ulr">User Log Report</a>';
          ?>
        </div>
      </div>
      <div class="col-11 leftLinkBody">
        <div class="row">
          <div class="col-4 pr-0">
            <div class="card border-info">
              <div class="card-body text-primary">
                <div class="row">
                  <div class="col-4 pr-0">
                    <input name="userId" id="userId" class="form-control form-control-sm" type="text" placeholder="Search User" aria-label="Search">
                  </div>
                  <div class="col-4 pl-1 pr-0">
                    <button type="button" class="btn btn-block btn-sm" id="searchStudent"><i class="fas fa-search"></i>Student</button>
                  </div>
                  <div class="col-4 pl-1">
                    <button type="button" class="btn btn-block btn-sm" id="searchStaff"><i class="fas fa-search"></i>Staff</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-4 pl-1 pr-0">
            <div class="card border-info">
              <div class="card-body">
                <div class="row">
                  <div class="col-12 py-1">
                    <span class="studentInfo">No Student Selected</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-4 pl-1">
            <div class="card border-danger">
              <div class="card-body">
                <div class="row">
                  <div class="col-12 py-1">
                    <span class="staffInfo">No Staff Selected</span>
                  </div>
                  <div class="col-12 py-1">
                    <div class="form-check-inline">
                      <input type="radio" class="form-check-input upr" id="faculty" name="up_code" value="0">Faculty
                    </div>
                    <div class="form-check-inline">
                      <input type="radio" class="form-check-input upr" id="staff" name="up_code" value="1">Staff
                    </div>
                    <div class="form-check-inline">
                      <input type="radio" class="form-check-input upr" id="admin" name="up_code" value="9">Admin
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane show active" id="list-aru" role="tabpanel" aria-labelledby="list-aru-list">
            <div class="row">
              <div class="col-10">
                <h4>Staff User</h4>
                <table class="table table-bordered table-striped list-table-xs mt-3" id="staffList">
                  <th class="text-center">#</th>
                  <th class="text-center">Id</th>
                  <th class="text-center">Name</th>
                  <th class="text-center">Mobile</th>
                  <th class="text-center">Staff Status</th>
                  <th class="text-center">User Status</th>
                  <th class="text-center">Privilege</th>
                  <th class="text-center">Last Login</th>
                </table>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-ml" role="tabpanel" aria-labelledby="list-ml-list">
            <div class="card mt-2 myCard">
              <div class="row m-1">
                <div class="col-md-2 pl-1">
                  <div class="card border-info">
                    <div class="card-body text-primary">
                      <?php
                      $curl = curl_init();
                      curl_setopt($curl, CURLOPT_URL, "https://classconnect.in/api/get_portal_group.php");
                      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                      $output = curl_exec($curl);
                      curl_close($curl);
                      $group = json_decode($output, true);
                      echo '<select class="form-control form-control-sm" name="sel_pg" id="sel_pg" required title="Select Link Group">';
                      echo '<option value="0" disabled>Select Group</option>';

                      for ($i = 0; $i < count($group["data"]); $i++) {
                        echo '<option value="' . $group["data"][$i]["id"] . '">' . $group["data"][$i]["id"] . '-' . $group["data"][$i]["name"] . '</option>';
                      }
                      echo '</select>';
                      ?>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <table class="table table-bordered list-table-xs mt-2" id="plList">
                    <thead>
                      <th>Id</th>
                      <th>Order</th>
                      <th>Link Name</th>
                      <th>Default</th>
                      <th>Responsibility-Link Status</th>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-ulr" role="tabpanel" aria-labelledby="list-ulr-list">
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
    $(function() {
      $(document).tooltip();
    });

    staffList();
    $(document).on('click', '.updateRL', function(event) {
      var pl = $(this).attr("data-pl");
      var mn = $(this).attr("data-mn");
      var tag = $(this).attr("data-tag");
      // $.alert("pl " + pl + " mn " + mn + " tag " + tag);
      $.post("userSql.php", {
        pl: pl,
        mn: mn,
        tag: tag,
        action: "updateRL",
      }, () => {}, "text").done(function(data) {
        // $.alert(data);
        groupLinks();

      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('change', '#sel_pg', function(event) {
      groupLinks();
    });

    function groupLinks() {
      var pg_id = $("#sel_pg").val();
      // $.alert(" Group Id " + pg_id);
      $.post("<?php echo $phpFile; ?>", {
        pg_id: pg_id,
        action: "groupLinkList",
      }, function() {}, "json").done(function(data, status) {
        console.log(data)
        // $.alert(data);
        var card = '';
        $.each(data.link, function(key, value) {
          card += '<tr>';
          card += '<td>' + value.pl_id + '</td>';
          card += '<td>' + value.pl_sno + '</td>';
          card += '<td>' + value.pl_name + '</td>';
          if (value.pl_type == "0") card += '<td>No</td>';
          else if (value.pl_type == "1") card += '<td class="warning">Yes</td>';
          else card += '<td>--</td>';
          card += '<td>' + value.text + '</td>';
          card += '</tr>';
        })
        $("#plList").find("tr:gt(0)").remove();
        $("#plList").append(card);

      }).fail(function() {
        $.alert("No Links Found ! Please try Other Group !");
      })
    }

    $(document).on('click', '#searchStudent', function(event) {
      var userId = $("#userId").val();
      $.alert(userId);
      $.post("userSql.php", {
        action: "fetchUser",
        userId: userId,
      }, () => {}, "json").done(function(data) {
        // $.alert(data);
        studentDisp();
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    function studentDisp() {
      var userId = $("#userId").val()
      // $.alert(" Student Display Functio  Id " + studentId);
      $.post("userSql.php", {
        userId: userId,
        action: "studentDisp"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var card = data.student_name + ' [' + data.user_id + ']';

        card += data.program_name + '[' + data.batch + ']';
        card += 'Mobile' + data.student_mobile;
        card += 'Email' + data.student_email;
        $(".studentInfo").html(card);

      }).fail(function() {
        $.alert("Could not Fetch Student Data!!");
      })
    }

    $(document).on('click', '#searchStaff', function(event) {
      var userId = $("#userId").val()
      $.alert(" Staff Display Function  Id " + userId);
      $.post("userSql.php", {
        userId: userId,
        action: "staffDisp"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var priv = data.up_code;
        var card = data.staff_name + ' [' + data.user_id + ']';
        card += ' Mobile ' + data.staff_mobile;
        card += 'Email ' + data.staff_email;

        if (priv == '0') {
          document.getElementById("faculty").checked = true;
        } else if (priv == '1') {
          document.getElementById("staff").checked = true;
        } else if (priv == '9') {
          document.getElementById("admin").checked = true;
        }

        $(".staffInfo").html(card);

      }).fail(function() {
        $.alert("Could not Fetch Student Data!!");
      })
    });

    $(document).on('click', '.upr', function(event) {
      var userId = $("#userId").val()
      var value = $(this).val()
      $.alert(" Value " + value + " Staff " + userId);
      $.post("userSql.php", {
        userId: userId,
        value: value,
        action: "updateUpr",
      }, () => {}, "text").done(function(data) {
        // $.alert(data);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });
    function staffList() {
      // $.alert("Batch");
      $.post("userSql.php", {
        action: "staffList",
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        // console.log(data);
        var card = '';
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td class="text-center">' + value.count + '</td>';
          card += '<td class="text-center">' + value.user_id + '</td>';
          card += '<td>' + value.staff_name + '</td>';
          card += '<td class="text-center">' + value.staff_mobile + '</td>';
          if(value.staff_status==0)card += '<td class="text-center">Active</td>';
          else card += '<td class="text-center text-danger">Left</td>';
          if(value.user_status==0)card += '<td class="text-center">User</td>';
          else card += '<td class="text-center text-danger">Not a User</td>';
          if(value.up_code==0)card += '<td class="text-center">Faculty</td>';
          else if(value.up_code==1)card += '<td class="text-center">Staff</td>';
          else if(value.up_code==9)card += '<td class="text-center text-large">Admin</td>';
          else card += '<td class="text-center text-danger">Not Set</td>';
          card += '<td class="text-center">' + value.last_login + '</td>';
          card += '</tr>';
        });
        $("#staffList").find("tr:gt(0)").remove();
        $("#staffList").append(card);

      }).fail(function() {
        $.alert("Error in Receipt!!");
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

</html>