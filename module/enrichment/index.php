<?php
require('../requireSubModule.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Outcome Based Education : ClassConnect</title>
  <?php require('../css.php'); ?>

</head>

<body>
  <?php require("../topBar.php"); ?>

  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-2 p-0 m-0 pl-2 full-height">
        <div class="mt-3">
          <h5>Enrichment</h5>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active rp" id="list-rp-list" data-toggle="list" href="#list-rp" role="tab" aria-controls="rp"> Resource Person </a>
          <a class="list-group-item list-group-item-action org" id="list-org-list" data-toggle="list" href="#list-org" role="tab" aria-controls="org"> Organization </a>
          <a class="list-group-item list-group-item-action cce" id="list-cce-list" data-toggle="list" href="#list-cce" role="tab" aria-controls="cce"> Co-curricular Activity </a>
        </div>
      </div>
      <div class="col-10 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane show active" id="list-rp" role="tabpanel">
            <div class="row">
              <div class="col-6 pr-1">
                <div class="container card mt-2 myCard">
                  <h5 class="card-title p-2 mb-0">Manage Resource Person Form</h5>
                  <form class="form-horizontal" id="resourcePersonForm">
                    <div class="row mt-2">
                      <div class="col-6">
                        <div class="form-group">
                          <label>Name</label>
                          <input type="text" class="form-control form-control-sm" id="rp_name" name="rp_name" required>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label>Designation</label>
                          <input type="text" class="form-control form-control-sm" id="rp_designation" name="rp_designation" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <label>Contact</label>
                          <input type="text" class="form-control form-control-sm" id="rp_mobile" name="rp_mobile" placeholder="10 Digits only">
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label>Email</label>
                          <input type="text" class="form-control form-control-sm" id="rp_email" name="rp_email" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <label>Affiliation and Address</label>
                          <textarea class="form-control form-control-sm" rows="5" id="rp_address" name="rp_address" required></textarea>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label>About</label>
                          <textarea class="form-control form-control-sm" rows="5" id="rp_about" name="rp_about"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <a class="atag basicInfoShowForm">Basic Info</a>
                      </div>
                      <div class="col">
                        <input type="hidden" id="rpAction" name="action">
                        <button type="submit" class="btn btn-sm">Submit</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-6 pl-1">
                <div class="container card mt-2 myCard">
                  <table class="table table-bordered table-striped list-table-xs mt-3" id="resourcePersonList">
                    <tr>
                      <th><i class="fa fa-pencil-alt"></i></th>
                      <th>#</th>
                      <th>Name</th>
                      <th>Desig</th>
                      <th>Mobile</th>
                      <th>Email</th>
                      <th>Address</th>
                    </tr>
                  </table>

                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="list-org" role="tabpanel">
            <div class="row">
              <div class="col-6 pr-1">
                <div class="container card mt-2 myCard">
                  <h5 class="card-title p-2 mb-0">Manage Organization Form</h5>
                  <form class="form-horizontal" id="organizationForm">
                    <div class="row mt-2">
                      <div class="col-6">
                        <div class="form-group">
                          <label>Organization Name</label>
                          <input type="text" class="form-control form-control-sm" id="org_name" name="org_name">
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label>URL</label>
                          <input type="text" class="form-control form-control-sm" id="org_url" name="org_url">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <label>Org Contact</label>
                          <input type="text" class="form-control form-control-sm" id="org_mobile" name="org_mobile" placeholder="10 Digits only">
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label>Org Email</label>
                          <input type="text" class="form-control form-control-sm" id="org_email" name="org_email">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <label>Contact Person Details</label>
                          <textarea class="form-control form-control-sm" rows="5" id="org_contact" name="org_contact"></textarea>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label>Org Address</label>
                          <textarea class="form-control form-control-sm" rows="5" id="org_address" name="org_address"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label>About</label>
                          <textarea class="form-control form-control-sm" rows="5" id="org_about" name="org_about"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                      </div>
                      <div class="col">
                        <input type="hidden" id="orgAction" name="action">
                        <button type="submit" class="btn btn-sm">Submit</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-6 pl-1">
                <div class="container card mt-2 myCard">
                  <table class="table table-bordered table-striped list-table-xs mt-3" id="organList">
                    <tr>
                      <th><i class="fa fa-pencil-alt"></i></th>
                      <th>#</th>
                      <th>Name</th>
                      <th>URL</th>
                      <th>Phone</th>
                      <th>eMail</th>
                      <th>Contact Person</th>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="list-cce" role="tabpanel">
            <div class="row">
              <div class="col-6 mt-1 mb-1">
                <div class="container card mt-2 myCard">
                  <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="pill" href="#pills_ea" role="tab">Activity</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link eap" data-toggle="pill" href="#pills_eap" role="tab">Participants</a>
                    </li>
                  </ul>
                  <!-- content -->
                  <div class="tab-content" id="pills-tabContent p-3">
                    <div class="tab-pane fade show active" id="pills_ea" role="tabpanel">
                      <form class="form-horizontal" id="eaForm">
                        <div class="row mt-2">
                          <div class="col-6 pr-0">
                            <div class="form-group">
                              <label>Activity Type</label>
                              <?php
                              $sql = "select * from master_name where mn_code='cca' and mn_status='0' order by mn_name";
                              selectList($conn, "Select Activity Type", array("1", "mn_id", "mn_name", "", "sel_cca"), $sql);
                              ?>
                            </div>
                          </div>
                          <div class="col-6 pl-1">
                            <div class="form-group">
                              <label>Activity Name</label>
                              <input type="text" class="form-control form-control-sm" id="ea_name" name="ea_name">
                            </div>
                          </div>
                          <div class="col-4 pr-1">
                            <div class="form-group">
                              <label>From</label>
                              <input type="date" class="form-control form-control-sm" id="ea_from_date" name="ea_from_date" value="<?php echo date("Y-m-d", time()); ?>">
                            </div>
                          </div>
                          <div class="col-2 pl-0 pr-1">
                            <div class="form-group">
                              <label>Time</label>
                              <input type="time" class="form-control form-control-sm" id="ea_from_time" name="ea_from_time" value="<?php echo date("H:i", time()); ?>">
                            </div>
                          </div>
                          <div class="col-4 pl-0 pr-1">
                            <div class="form-group">
                              <label>To</label>
                              <input type="date" class="form-control form-control-sm" id="ea_to_date" name="ea_to_date" value="<?php echo date("Y-m-d", time()); ?>">
                            </div>
                          </div>
                          <div class="col-2 pl-0">
                            <div class="form-group">
                              <label>Time</label>
                              <input type="time" class="form-control form-control-sm" id="ea_to_time" name="ea_to_time" value="<?php echo date("H:i", time()); ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <input type="hidden" id="ea_id" name="ea_id" value="0">
                            <input type="hidden" id="eaAction" name="action" value="addEA">
                            <button type="submit" class="btn btn-sm">Submit</i></button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="tab-pane fade" id="pills_eap" role="tabpanel">
                      <div class="row">
                        <div class="col">
                          <p id="deptClass"></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="container card mt-2 myCard">
                  <table class="table table-bordered table-striped list-table-xs mt-3" id="eaTable">
                    <tr>
                      <th><i class="fa fa-pencil-alt"></i></th>
                      <th>#</th>
                      <th>Type</th>
                      <th>Dept</th>
                      <th>Activity</th>
                      <th>From</th>
                      <th>Start</th>
                      <th>To</th>
                      <th>End</th>
                    </tr>
                  </table>
                </div>
              </div>
              <div class="col-6 mt-1 mb-1" role="tabpanel">
                <div class="container card mt-2 myCard">
                  <h5 class="text-center mt-2">Notice</h5>
                  <p><?php echo $dept_header; ?></p>
                  <p>It is for the information of all concern that the department is organizing an activity as per following schedule:</p>
                  <div class="container col-12">
                    <table class="table list-table-xs">
                      <tr>
                        <th>Activity Type</th>
                        <th id="activity_type"></th>
                      </tr>
                      <tr>
                        <th>Activity Name</th>
                        <th><span id="activity_name"></span></th>
                      </tr>
                      <tr>
                        <th>From </th>
                        <th><span id="activity_from_date"></span> <span id="activity_from_time"></span></th>
                      </tr>
                      <tr>
                        <th>To </th>
                        <th><span id="activity_to_date"></span> <span id="activity_to_time"></span></th>
                      </tr>
                      <tr>
                        <th>Participants</th>
                        <th><span id="activity_participants"></span></th>
                      </tr>
                    </table>
                  </div>
                  <p>All are requested to attend.</p>
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

<?php require("../js.php"); ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
  $(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip();
    $(".topBarTitle").text("Academics");
    $("#rpAction").val("addRP")
    $("#orgAction").val("addOrg")
    resourcePersonList();
    organizationList();
    $(".selectLabel").text("Resource Person");
    selectList("rp");
    eaList();


    //Co cur Block
    $(document).on('click', '.actName', function(event) {
      var actName = $("input[name='actName']:checked").val();
      if (actName == 'rp') $(".selectLabel").text("Resource Person");
      else $(".selectLabel").text("Organization");
      // $.alert("Pressed" + actName);

      $.post("enrichmentSql.php", {
        actName: actName,
      }, function() {}, "text").done(function(data, status) {
        // respNameList();
        selectList(actName);
        //$.alert("List " + data);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });
    $(document).on("click", ".editEA", function() {
      var ea_id = $(this).attr("data-ea")
      // $().removeClass();
      $(".editEA").removeClass('fa-circle')
      $(".editEA").addClass('fa-pencil-alt')

      $(this).removeClass('fa-pencil-alt');
      $(this).addClass('fa-circle')

      // $.alert("Edit - Fetch " + ea_id);
      $.post("enrichmentSql.php", {
        ea_id: ea_id,
        action: "fetchEA"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(" Update " + feedback_id);
        $("#ea_id").val(data.ea_id)
        $("#sel_cca").val(data.mn_id)
        $("#ea_name").val(data.ea_name)
        $("#ea_from_date").val(data.ea_from_date)
        $("#ea_from_time").val(data.ea_from_time)
        $("#ea_to_date").val(data.ea_to_date)
        $("#ea_to_time").val(data.ea_to_time)

        // Notice Data

        $("#activity_type").html(data.mn_name)
        $("#activity_name").html(data.ea_name)
        $("#activity_from_date").html(getFormattedDate(data.ea_from_date, "dmY"))
        $("#activity_from_time").html(data.ea_from_time)
        $("#activity_from_date").html(getFormattedDate(data.ea_to_date, "dmY"))
        $("#activity_to_time").html(data.ea_to_time)
        deptClassList();
      })

    })
    $(document).on('submit', '#eaForm', function(event) {
      event.preventDefault(this);
      var formData = $(this).serialize();
      $.alert(formData);
      $.post("enrichmentSql.php", formData, () => {}, "text").done(function(data) {
        $.alert("List Updtaed" + data);
        $("#ed_id").val("0");
        $("#eaForm")[0].reset();
        eaList();
      })
    });
    $(document).on("click", ".eapClass", function() {
      var classId = $(this).attr("data-class")
      var status = $(this).is(":checked");
      // $.alert("Participant Class Id " + classId + status);
      $.post("enrichmentSql.php", {
        classId: classId,
        status: status,
        action: "participant"
      }, function() {}, "text").done(function(data, status) {
        $.alert(data)
      })
    })
    $(document).on("click", ".eap", function() {
      deptClassList();
    })

    function deptClassList() {
      // $.alert("Class List ");
      $.post("enrichmentSql.php", {
        action: "deptClassList"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data)
        var card = '';
        var count = 1;
        $.each(data, function(key, value) {
          var check = value.check;
          card += '<div class="row m-1">';
          card += '<div class="col">';
          if (check == '1') card += '<input type="checkbox" class="eapClass" checked data-class="' + value.class_id + '"> ' + value.class_name;
          else card += '<input type="checkbox" class="eapClass" data-class="' + value.class_id + '"> ' + value.class_name;
          card += ' [' + value.class_section + '] ';
          // card += ' [' + check + '] ';
          card += '</div>';
          card += '</div>';
        })
        // $("#programClassTable").find("tr:gt(0)").remove();
        $("#deptClass").html(card);
      })
    }

    function eaList() {
      // $.alert('hello');
      $.post("enrichmentSql.php", {
        action: "eaList",
      }, () => {}, "json").done(function(data, status) {
        var card = '';
        var count = 1;
        // $.alert(data);
        $.each(data, function(key, value) {
          status = value.ea_status;
          card += '<tr>';
          if (status == "0") card += '<td><a href="#" class="editEA fa fa-circle" data-ea="' + value.ea_id + '"></td>';
          else card += '<td><a href="#" class="editEA fa fa-pencil-alt" data-ea="' + value.ea_id + '"></td>';
          card += '<td>' + count++ + '</td>';
          card += '<td>' + value.mn_name + '</td>';
          card += '<td>' + value.dept_abbri + '</td>';
          card += '<td>' + value.ea_name + '</td>';
          card += '<td>' + getFormattedDate(value.ea_from_date, "dmY") + '</td>';
          card += '<td>' + value.ea_from_time + '</td>';
          card += '<td>' + getFormattedDate(value.ea_to_date, "dmY") + '</td>';
          card += '<td>' + value.ea_to_time + '</td>';
          card += '</tr>';
        });
        $("#eaTable").find("tr:gt(0)").remove()
        $("#eaTable").append(card);
      }).fail(function() {
        $.alert("EA Not Responding");
      })
    }
    // Resource Person Block
    $(document).on('submit', '#resourcePersonForm', function(event) {
      event.preventDefault(this);
      var formData = $(this).serialize();
      $.alert(formData);
      $.post("enrichmentSql.php", formData, () => {}, "text").done(function(data) {
        $.alert("List Updtaed" + data);
        resourcePersonList();
      })
    });

    function resourcePersonList() {
      // $.alert("In List Function");
      $.post("enrichmentSql.php", {
        action: "resourcePersonList"
      }, function() {}, "json").done(function(data, status) {
        var card = '';
        var count = 1;
        // $.alert(data);
        //$.alert(data);
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td><a href="#" class="editFeedback fa fa-pencil-alt" data-fb="' + value.rp_id + '"></td>';
          card += '<td>' + count++ + '</td>';
          card += '<td>' + value.rp_name + '</td>';
          card += '<td>' + value.rp_designation + '</td>';
          card += '<td>' + value.rp_mobile + '</td>';
          card += '<td>' + value.rp_email + '</td>';
          card += '<td>' + value.rp_address + '</td>';
          card += '</tr>';
        });
        $("#resourcePersonList").find("tr:gt(0)").remove()
        $("#resourcePersonList").append(card);

      }).fail(function() {
        $.alert("Error !!");
      })
    }

    // Organization Block
    $(document).on('submit', '#organizationForm', function(event) {
      event.preventDefault(this);
      var formData = $(this).serialize();
      $.alert(formData);
      $.post("enrichmentSql.php", formData, () => {}, "text").done(function(data) {
        $.alert("List Updtaed" + data);
        organizationList();
      })
    });

    function organizationList() {
      // $.alert('hello');
      $.post("enrichmentSql.php", {
        action: "orgList",
      }, () => {}, "json").done(function(data, status) {
        var card = '';
        var count = 1;
        // $.alert(data);
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td><a href="#" class="editFeedback fa fa-pencil-alt" data-fb="' + value.org_id + '"></td>';
          card += '<td>' + count++ + '</td>';
          card += '<td>' + value.org_name + '</td>';
          card += '<td>' + value.org_url + '</td>';
          card += '<td>' + value.org_mobile + '</td>';
          card += '<td>' + value.org_email + '</td>';
          card += '<td>' + value.org_contact + '</td>';
          card += '</tr>';
        });
        $("#organList").find("tr:gt(0)").remove()
        $("#organList").append(card);
      }).fail(function() {
        $.alert("Organization Not Responding");
      })
    }

    function selectList(tag) {
      //$.alert("In List Function");
      // if (tag == "department") tag = "dept";
      $.post("enrichmentSql.php", {
        tag: tag,
        action: "selectList"
      }, function() {}, "text").done(function(data, status) {
        //$.alert(data);
        $(".selectList").html(data);
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
      var dateYmd = year + '-' + month + '-' + day;
      if (fmt == "dmY") return date;
      else return dateYmd;
    }
  });
</script>

</html>