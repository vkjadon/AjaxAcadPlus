<?php
require('../requireSubModule.php');
addActivity($conn, $myId, "User", $submit_ts);
$phpFile = "userSql.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Outcome Based Education : AcadPlus</title>
  <?php require("../css.php"); ?>
</head>

<body>
  <?php require("../topBar.php");
  // print_r($myLinks);
  ?>
  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-1 p-0 m-0 pl-1 full-height">
        <div class="mt-3">
          <h5>Manage Users</h5>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item active list-group-item-action aru" id="list-aru-list" data-toggle="list" href="#list-aru" role="tab" aria-controls="aru">User</a>
          <a class="list-group-item list-group-item-action ml" id="list-ml-list" data-toggle="list" href="#list-ml" role="tab" aria-controls="ml">Responsibility Link</a>
          <a class="list-group-item list-group-item-action ul" data-toggle="list" href="#ul" role="tab" aria-controls="ul">Update Links</a>
          <a class="list-group-item list-group-item-action ulr" id="list-ulr-list" data-toggle="list" href="#list-ulr" role="tab" aria-controls="ulr">Log Report</a>
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
          <div class="col-4 pr-0 pl-1">
            <div class="card border-danger">
              <div class="card-body">
                <div class="row">
                  <div class="col-12 py-1">
                    <span class="staffInfo">No Staff Selected</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-4 pl-1">
            <div class="card border-primary">
              <div class="card-body">
                <div class="row">
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
                      $sql = "select * from portal_menu where pm_status='0' order by pm_sno";
                      $result = $conn->query($sql);
                      echo '<select class="form-control form-control-sm" name="sel_pm" id="sel_pm" required title="Select Link Menu">';
                      echo '<option value="0">Select Menu</option>';
                      while ($rowsMenu = $result->fetch_assoc()) {
                        echo '<option value="' . $rowsMenu["pm_id"] . '">' . $rowsMenu["pm_id"] . '-' . $rowsMenu["pm_name"] . '</option>';
                      }
                      echo '<option value="ALL">All</option>';
                      echo '</select>';
                      ?>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 pl-1">
                </div>
                <div class="col-md-2 pl-1 pr-0">
                  <div class="card border-info">
                    <div class="card-body text-primary">
                      <button type="button" class="btn btn-sm btn-block updateMenu">Update Menu</button>
                    </div>
                  </div>
                </div>
                <div class="col-md-2 pl-0">
                  <div class="card border-info">
                    <div class="card-body text-primary">
                      <button type="button" class="btn btn-sm btn-block updateGroup">Update Group</button>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <table class="table table-bordered list-table-xs mt-2" id="plList">
                    <thead>
                      <th>Id</th>
                      <th>Default</th>
                      <th>Menu</th>
                      <th>Group Name</th>
                      <th>Privileges</th>
                      <th>Portal Responsibility</th>
                      <th>Custom Responsibility</th>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="ul" role="tabpanel" aria-labelledby="ul">

          </div>
          <div class="tab-pane fade" id="list-ulr" role="tabpanel" aria-labelledby="list-ulr-list">
            <div class="row mt-3">
              <div class="col-md-2">
                <h4>User Activity Log </h4>
              </div>
              <div class="col-md-2">
                <input type="date" class="form-control form-control-sm" id="uaDate" value="<?php echo $today; ?>">
              </div>

              <div class="col-md-2">
                <a href="#" class="btn btn-sm previous" href="#">Prev</a>
                <a href="#" class="btn btn-sm next" href="#">Next</a>
              </div>

            </div>
            <div class="row">
              <div class="col-12">

                <table class="table table-bordered table-striped list-table-xs mt-3" id="uaLog">
                  <th class="text-center">#</th>
                  <th class="text-center">Id</th>
                  <th class="text-center">Name</th>
                  <th class="text-center">Privilege</th>
                  <th class="text-center">Activity</th>
                  <th class="text-center">Date(Local)</th>
                  <th class="text-center">Time(Local)</th>
                </table>
              </div>
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

</html>
<script>
  $(document).ready(function() {
    $(function() {
      $(document).tooltip();
    });

    var page = 1,
      page_limit = 20,
      totalRecord = 0;

    staffList();
    uaLog();

    function uaLog() {
      // $.alert("Batch");
      var ua_date = $("#uaDate").val()
      $.post("userSql.php", {
        page: page,
        page_limit: page_limit,
        ua_date: ua_date,
        action: "uaLog",
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        console.log(data);
        totalRecord = data.totalRecord;
        var card = '';
        $.each(data.data, function(key, value) {
          card += '<tr>';
          card += '<td class="text-center">' + value.count + '</td>';
          card += '<td class="text-center">' + value.user_id + '</td>';
          card += '<td>' + value.staff_name + '</td>';
          card += '<td class="text-center">' + value.staff_mobile + '</td>';
          card += '<td class="text-center">' + value.ua_name + '</td>';
          card += '<td class="text-center">' + value.ua_date + '</td>';
          card += '<td class="text-center">' + value.ua_time + '</td>';
          card += '</tr>';
        });
        $("#uaLog").find("tr:gt(0)").remove();
        $("#uaLog").append(card);
      }).fail(function() {
        $.alert("Error in loading User Activity Log !!");
      })

    }

    $(document).on('click', '.previous', function(event) {
      if (page > 1) page--
      uaLog()
    });

    $(document).on('click', '.next', function(event) {
      if (page * page_limit < totalRecord) page++
      uaLog()
    });

    $(document).on('change', '#uaDate', function(event) {
      // $.alert("Changed");
      uaLog()
    });

    $(document).on('click', '.updateRL', function(event) {
      var pg = $(this).attr("data-pg");
      var mn = $(this).attr("data-mn");
      var tag = $(this).attr("data-tag");
      // $.alert("pl " + pl + " mn " + mn + " tag " + tag);
      $.post("userSql.php", {
        pg: pg,
        mn: mn,
        tag: tag,
        action: "updateRL",
      }, () => {}, "text").done(function(data) {
        // $.alert(data);
        menuGroups();
        // groupLinks();

      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.updatePriv', function(event) {
      var pg = $(this).attr("data-pg");
      var priv = $(this).attr("data-up");
      var tag = $(this).attr("data-tag");
      // $.alert("pg " + pg + " priv " + priv + " tag " + tag);
      $.post("userSql.php", {
        pg: pg,
        priv: priv,
        tag: tag,
        action: "updatePriv",
      }, () => {}, "text").done(function(data) {
        // $.alert(data);
        menuGroups();
        // groupLinks();

      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.updatePR', function(event) {
      var pg = $(this).attr("data-pg");
      var pr = $(this).attr("data-pr");
      var tag = $(this).attr("data-tag");
      // $.alert("pg " + pg + " pr " + pr + " tag " + tag);
      $.post("userSql.php", {
        pg: pg,
        pr: pr,
        tag: tag,
        action: "updatePR",
      }, "text").done(function(data) {
        // $.alert(data);
        menuGroups();
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('change', '#sel_pm', function(event) {
      // groupLinks();
      menuGroups();
    });

    function groupLinks() {
      var pg_id = $("#sel_pm").val();
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

    function menuGroups() {
      var pm_id = $("#sel_pm").val();
      // $.alert(" Menu Id " + pm_id);
      $.post("<?php echo $phpFile; ?>", {
        pm_id: pm_id,
        action: "menuGroupList",
      }, function() {}, "json").done(function(data, status) {
        console.log(data)
        // $.alert(data);
        var card = '';
        $.each(data.link, function(key, value) {
          card += '<tr>';
          card += '<td>' + value.pg_id + '</td>';
          if (value.pg_type == "0") card += '<td class="click text-center"><a href="#" class="default" data-pg="' + value.pg_id + '" data-value="1"><i class="fa fa-times"></i></a></td>';
          else if (value.pg_type == "1") card += '<td class="click text-center"><a href="#" class="default" data-pg="' + value.pg_id + '" data-value="0"><i class="fa fa-check"></i></a></td>';
          else card += '<td>--</td>';
          card += '<td>' + value.pm_name + '</td>';
          card += '<td>' + value.pg_name + '</td>';
          card += '<td>' + value.pg + '</td>';
          card += '<td>' + value.portalResponsibility + '</td>';
          card += '<td>' + value.text + '</td>';
          card += '</tr>';
        })
        $("#plList").find("tr:gt(0)").remove();
        $("#plList").append(card);

      }).fail(function() {
        $.alert("No Links Found ! Please try Other Group !");
      })
    }

    $(document).on('click', '.default', function(event) {
      var pg = $(this).attr("data-pg");
      var value = $(this).attr("data-value");
      // $.alert("pg " + pg + " value " + value);
      $.post("userSql.php", {
        pg: pg,
        value: value,
        action: "updateDefault",
      }, () => {}, "text").done(function(data) {
        // $.alert(data);
        menuGroups();
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

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
          if (value.staff_status == 0) card += '<td class="text-center">Active</td>';
          else card += '<td class="text-center text-danger">Left</td>';
          if (value.user_status == 0) card += '<td class="text-center">User</td>';
          else card += '<td class="text-center text-danger">Not a User</td>';
          if (value.up_code == 0) card += '<td class="text-center">Faculty</td>';
          else if (value.up_code == 1) card += '<td class="text-center">Staff</td>';
          else if (value.up_code == 9) card += '<td class="text-center text-large">Admin</td>';
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

    $(document).on('click', '.updateMenu', function(event) {
      $.alert("Updating Menu ");
      $.post("userSql.php", {
        action: "updateMenu",
      }, () => {}, "text").done(function(data, status) {
        $.alert(data);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });
    $(document).on('click', '.updateGroup', function(event) {
      $.alert("Updating Menu ");
      $.post("userSql.php", {
        action: "updateGroup",
      }, () => {}, "text").done(function(data, status) {
        $.alert(data);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

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