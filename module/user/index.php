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
          if (in_array("18", $myLinks)) echo '<a class="list-group-item list-group-item-action ml" id="list-ml-list" data-toggle="list" href="#list-ml" role="tab" aria-controls="ml">Links to Responsibility</a>';
          if (in_array("17", $myLinks)) echo '<a class="list-group-item list-group-item-action aru" id="list-aru-list" data-toggle="list" href="#list-aru" role="tab" aria-controls="aru">Add/Remove</a>';
          // if (in_array("19", $myLinks)) echo '<a class="list-group-item list-group-item-action ulr" id="list-ulr-list" data-toggle="list" href="#list-ulr" role="tab" aria-controls="ulr">User Log Report</a>';
          ?>
        </div>
      </div>
      <div class="col-11 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade" id="list-aru" role="tabpanel" aria-labelledby="list-aru-list">
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
          </div>
            <div class="row">
              <div class="col-6">
                <div class="container card mt-2 myCard">
                  <div class="row">
                    <div class="col-12">
                      <p class="applicationForm"></p>
                    </div>
                  </div>
                  <h4>User History</h4>
                </div>
              </div>
              <div class="col-6">
                <div class="container card mt-2 myCard">
                  <div class="row">
                    <div class="col-12">
                      <p class="text-center">
                      <h1>User Status : <span class="userStatus"></span> </h1>
                      </p>
                      <button class="btn btn-success">Create User</button>
                      <button class="btn">Suspend User</button>
                      <button class="btn btn-danger">Remove User</button>
                    </div>
                  </div>
                </div>
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
                      $group = json_decode($output, true);
                      echo '<select class="form-control form-control-sm" name="sel_pg" id="sel_pg" required title="Select Link Group">';
                      echo '<option value="0" disabled>Select Group</option>';

                      for ($i = 0; $i < count($group["data"]); $i++) {
                        echo '<option value="' . $group["data"][$i]["id"] . '">' . $group["data"][$i]["id"] . '-' . $group["data"][$i]["name"] . '</option>';
                      }
                      echo '</select>';
                      curl_close($curl);
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
        var card = '<h4>' + data.student_name + ' [' + data.user_id + ']</h4>';
        card += '<table class="table list-table-xs">';
        card += '<tr>';
        card += '<td> Program Name </td><td>' + data.program_name + '</td>';
        card += '<td> Batch </td><td>' + data.batch + '</td>';
        card += '</tr>';

        card += '<tr>';
        card += '<td> Mobile </td><td>' + data.student_mobile + '</td>';
        card += '<td> Email </td><td>' + data.student_email + '</td>';
        card += '</tr>';

        card += '<tr><td colspan="4"><h4>Parents Information</h4></td></tr>'

        card += '<tr>';
        card += '<td> Father Name </td><td>' + data.student_fname + '</td>';
        card += '<td>' + data.student_fmobile + '</td>';
        card += '<td>' + data.student_femail + '</td>';
        card += '</tr>';

        card += '</table>';
        $(".applicationForm").html(card);

      }).fail(function() {
        $.alert("Could not Fetch Student Data!!");
      })
    }

    $(document).on('click', '#searchStaff', function(event) {
      var userId = $("#userId").val();
      $.alert(userId);
      $.post("userSql.php", {
        action: "fetchStaff",
        userId: userId
      }, () => {}, "json").done(function(data) {
        // $.alert(data);
        staffDisp();
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    function staffDisp() {
      var userId = $("#userId").val()
      $.alert(" Staff Display Function  Id " + userId);
      $.post("userSql.php", {
        userId: userId,
        action: "staffDisp"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var card = '<h4>' + data.staff_name + ' [' + data.user_id + ']</h4>';
        card += '<table class="table list-table-xs">';
        card += '<tr>';
        card += '<td> Mobile </td><td>' + data.staff_mobile + '</td>';
        card += '</tr>';

        card += '<tr>';
        card += '<td> Email </td><td>' + data.staff_email + '</td>';
        card += '</tr>';
        card += '</table>';
        $(".applicationForm").html(card);

      }).fail(function() {
        $.alert("Could not Fetch Student Data!!");
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