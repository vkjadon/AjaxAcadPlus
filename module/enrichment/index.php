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
  <?php require("../topBar.php");
  if ($myId > 3) {
    if (!isset($_GET['tag'])) die("Illegal Attempt !! The token is Missing");
    elseif (!in_array($_GET['tag'], $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
    elseif (!in_array("28", $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
  }
  ?>
  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-1 p-0 m-0 full-height">
        <div class="mt-3 pl-1">
          <h5>Enrichment</h5>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active cce" id="list-cce-list" data-toggle="list" href="#list-cce" role="tab" aria-controls="cce"> CC Activity </a>
          <a class="list-group-item list-group-item-action rp" id="list-rp-list" data-toggle="list" href="#list-rp" role="tab" aria-controls="rp"> Resource Person </a>
          <a class="list-group-item list-group-item-action org" id="list-org-list" data-toggle="list" href="#list-org" role="tab" aria-controls="org"> Organization </a>
        </div>
      </div>
      <div class="col-11">
        <div class="tab-content" id="nav-tabContent">
          <div class="row">
            <div class="col-md-12">
              <div class="card myCard p-2">
                <div class="row">
                  <div class="col-md-2">
                    <span class="footNote text-secondary" id="activity_type"></span><br>
                    <span class="footNote text-primary" id="activity_name"><span class="text-danger"> Please Select an Activity </span> </span>
                  </div>
                  <div class="col-md-3">
                    From <span id="activity_from_date"></span> @ <span id="activity_from_time"></span><br>
                    To <span id="activity_to_date"></span> @ <span id="activity_to_time"></span>
                  </div>
                  <div class="col-md-6">
                    Participants: <span id="activity_participants"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane show active" id="list-cce" role="tabpanel">
            <div class="row">
              <div class="col-4 mt-1 mb-1 pr-0">
                <div class="container card mt-2 myCard">
                  <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="pill" href="#pills_ea" role="tab">Activity</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link ear" data-toggle="pill" href="#pills_ear" role="tab">Resourcses</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link eap" data-toggle="pill" href="#pills_eap" role="tab">Participants</a>
                    </li>
                  </ul>
                  <!-- content -->
                  <div class="tab-content" id="pills-tabContent p-3">
                    <div class="tab-pane fade show active" id="pills_ea" role="tabpanel">
                      <form class="form-horizontal" id="eaForm">
                        <div class="row">
                          <div class="col-5 pr-0">
                            <div class="form-group">
                              <label>Activity Type</label>
                              <?php
                              $sql = "select * from master_name where mn_code='cca' and mn_status='0' order by mn_name";
                              selectList($conn, "Select Activity Type", array("1", "mn_id", "mn_name", "", "sel_cca"), $sql);
                              ?>
                            </div>
                          </div>
                          <div class="col-5 pl-1 pr-0">
                            <div class="form-group">
                              <label>Activity Name</label>
                              <input type="text" class="form-control form-control-sm" id="ea_name" name="ea_name">
                            </div>
                          </div>
                          <div class="col-2 pl-1">
                            <div class="form-group">
                              <label>ExAttd</label>
                              <input type="number" min="1" class="form-control form-control-sm" id="ea_extra_attendance" name="ea_extra_attendance">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-4 pr-0">
                            <div class="form-group">
                              <label>From</label>
                              <input type="date" class="form-control form-control-sm" id="ea_from_date" name="ea_from_date" value="<?php echo date("Y-m-d", time()); ?>">
                            </div>
                          </div>
                          <div class="col-2 pl-1 pr-0">
                            <div class="form-group">
                              <label>Time</label>
                              <input type="time" class="form-control form-control-sm" id="ea_from_time" name="ea_from_time" value="<?php echo date("H:i", time()); ?>">
                            </div>
                          </div>
                          <div class="col-4 pl-1 pr-0">
                            <div class="form-group">
                              <label>To</label>
                              <input type="date" class="form-control form-control-sm" id="ea_to_date" name="ea_to_date" value="<?php echo date("Y-m-d", time()); ?>">
                            </div>
                          </div>
                          <div class="col-2 pl-1">
                            <div class="form-group">
                              <label>Time</label>
                              <input type="time" class="form-control form-control-sm" id="ea_to_time" name="ea_to_time" value="<?php echo date("H:i", time()); ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>About the Activity</label>
                              <textarea class="form-control form-control-sm" rows="6" id="ea_about" name="ea_about"></textarea>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <input type="hidden" id="ea_idHidden" name="ea_id" value="0">
                            <input type="hidden" id="eaAction" name="action" value="addEA">
                            <button type="submit" class="btn btn-sm">Submit</i></button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="tab-pane fade" id="pills_ear" role="tabpanel">
                      <div class="row">
                        <div class="col-md-6 pr-0">
                          <p class="rpList"></p>
                        </div>
                        <div class="col-md-6 pl-1">
                          <p class="orgList"></p>
                        </div>
                      </div>
                      <p class="ear_rpList"></p>
                      <p class="ear_orgList"></p>
                    </div>
                    <div class="tab-pane fade" id="pills_eap" role="tabpanel">
                      <div class="row">
                        <div class="col">Class List
                          <p id="deptClass"></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-8 mt-1 mb-1 pl-1" role="tabpanel">
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
            </div>
          </div>
          <div class="tab-pane" id="list-rp" role="tabpanel">
            <div class="row">
              <div class="col-4 pr-1">
                <div class="container card mt-2 myCard">
                  <h5 class="card-title">Manage Resource Person Form</h5>
                  <form class="form-horizontal" id="resourcePersonForm">
                    <div class="row mt-2">
                      <div class="col-md-6 pr-0">
                        <div class="form-group">
                          <label>Name</label>
                          <input type="text" class="form-control form-control-sm" id="rp_name" name="rp_name" required>
                        </div>
                      </div>
                      <div class="col-md-6 pl-1">
                        <div class="form-group">
                          <label>Designation</label>
                          <input type="text" class="form-control form-control-sm" id="rp_designation" name="rp_designation" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 pr-0">
                        <div class="form-group">
                          <label>Contact</label>
                          <input type="text" class="form-control form-control-sm" id="rp_mobile" name="rp_mobile" placeholder="10 Digits only">
                        </div>
                      </div>
                      <div class="col-md-6 pl-1">
                        <div class="form-group">
                          <label>Email</label>
                          <input type="text" class="form-control form-control-sm" id="rp_email" name="rp_email" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Affiliation and Address</label>
                          <textarea class="form-control form-control-sm" rows="3" id="rp_address" name="rp_address" required></textarea>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>About</label>
                          <textarea class="form-control form-control-sm" rows="6" id="rp_about" name="rp_about"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <input type="hidden" id="rp_idHidden" name="rp_id" value="0">
                        <input type="hidden" id="rpAction" name="action" value="addRP">
                        <button type="submit" class="btn btn-sm">Submit</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-8 pl-1">
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
                      <th>About</th>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="list-org" role="tabpanel">
            <div class="row">
              <div class="col-md-4 pr-0">
                <div class="container card mt-2 myCard">
                  <h5 class="card-title">Manage Organization Form</h5>
                  <form class="form-horizontal" id="organizationForm">
                    <div class="row mt-2">
                      <div class="col-md-6 pr-0">
                        <div class="form-group">
                          <label>Organization Name</label>
                          <input type="text" class="form-control form-control-sm" id="org_name" name="org_name">
                        </div>
                      </div>
                      <div class="col-md-6 pl-1">
                        <div class="form-group">
                          <label>URL</label>
                          <input type="text" class="form-control form-control-sm" id="org_url" name="org_url">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 pr-0">
                        <div class="form-group">
                          <label>Org Contact</label>
                          <input type="text" class="form-control form-control-sm" id="org_mobile" name="org_mobile" placeholder="10 Digits only">
                        </div>
                      </div>
                      <div class="col-md-6 pl-1">
                        <div class="form-group">
                          <label>Org Email</label>
                          <input type="text" class="form-control form-control-sm" id="org_email" name="org_email">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Contact Person Details</label>
                          <textarea class="form-control form-control-sm" rows="2" id="org_contact" name="org_contact"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Org Address</label>
                          <textarea class="form-control form-control-sm" rows="4" id="org_address" name="org_address"></textarea>
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
                        <input type="hidden" id="org_idHidden" name="org_id" value="0">
                        <input type="hidden" id="orgAction" name="action" value="addOrg">
                        <button type="submit" class="btn btn-sm">Submit</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-md-8 pl-1">
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
        </div>
      </div>
    </div>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <?php require("../bottom_bar.php"); ?>
  </div>
</body>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
  $(document).ready(function() {

    $(function() {
      $(document).tooltip();
    });

    resourcePersonList();

    // Resource Person Block
    $(document).on('submit', '#resourcePersonForm', function(event) {
      event.preventDefault(this);
      var formData = $(this).serialize();
      // $.alert(formData);
      $.post("enrichmentSql.php", formData, () => {}, "text").done(function(data) {
        // $.alert("List Updtaed" + data);
        resourcePersonList();
        $('#resourcePersonForm').each(function() {
          this.reset();
        });
      })
    });

    function resourcePersonList() {
      // $.alert("In List Function");
      $.post("enrichmentSql.php", {
        action: "resourcePersonList"
      }, function() {}, "json").done(function(data, status) {
        var card = '';
        var count = 1;
        //$.alert(data);
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td><a href="#" class="editRP fa fa-pencil-alt" data-rp="' + value.rp_id + '"></td>';
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

    $(document).on("click", ".editRP", function() {
      var rp_id = $(this).attr("data-rp")
      // $().removeClass();
      $(".editRP").removeClass('fa-circle')
      $(".editRP").addClass('fa-pencil-alt')

      $(this).removeClass('fa-pencil-alt');
      $(this).addClass('fa-circle')

      // $.alert("Edit - Fetch " + rp_id);
      $.post("enrichmentSql.php", {
        rp_id: rp_id,
        action: "fetchRP"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data.rp_id);
        $("#rp_name").val(data.rp_name)
        $("#rp_designation").val(data.rp_designation)
        $("#rp_mobile").val(data.rp_mobile)
        $("#rp_email").val(data.rp_email)
        $("#rp_address").val(data.rp_address)
        $("#rp_about").val(data.rp_about)
        $("#rp_idHidden").val(data.rp_id)
      })
    })

    organizationList();

    // Organization Block
    $(document).on('submit', '#organizationForm', function(event) {
      event.preventDefault(this);
      var formData = $(this).serialize();
      // $.alert(formData);
      $.post("enrichmentSql.php", formData, () => {}, "text").done(function(data) {
        // $.alert("List Updtaed" + data);
        $('#organizationForm').each(function() {
          this.reset();
        });
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
          card += '<td><a href="#" class="editOrg fa fa-pencil-alt" data-org="' + value.org_id + '"></td>';
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

    $(document).on("click", ".editOrg", function() {
      var org_id = $(this).attr("data-org")

      $(".editOrg").removeClass('fa-circle')
      $(".editOrg").addClass('fa-pencil-alt')

      $(this).removeClass('fa-pencil-alt');
      $(this).addClass('fa-circle')

      // $.alert("Edit - Fetch " + org_id);
      $.post("enrichmentSql.php", {
        org_id: org_id,
        action: "fetchOrg"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        $("#org_name").val(data.org_name)
        $("#org_url").val(data.org_url)
        $("#org_mobile").val(data.org_mobile)
        $("#org_email").val(data.org_email)
        $("#org_address").val(data.org_address)
        $("#org_contact").val(data.org_contact)
        $("#org_about").val(data.org_about)
        $("#org_idHidden").val(data.org_id)
      })
    })

    selectList("rp");

    //Cocurricular Activities Block
    eaList();

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

    $(document).on('submit', '#eaForm', function(event) {
      event.preventDefault(this);
      var formData = $(this).serialize();
      // $.alert(formData);
      $.post("enrichmentSql.php", formData, () => {}, "text").done(function(data) {
        // $.alert("List Updtaed" + data);
        $("#eaForm")[0].reset();
        eaList();
        $("#ea_idHidden").val("0");
      })
    });

    $(document).on("click", ".editEA", function() {
      var ea_id = $(this).attr("data-ea")
      $("#ea_idHidden").val(ea_id)

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
        $("#sel_cca").val(data.mn_id)
        $("#ea_name").val(data.ea_name)
        $("#ea_from_date").val(data.ea_from_date)
        $("#ea_from_time").val(data.ea_from_time)
        $("#ea_to_date").val(data.ea_to_date)
        $("#ea_to_time").val(data.ea_to_time)
        $("#ea_about").val(data.ea_about)
        $("#ea_extra_attendance").val(data.ea_extra_attendance)

        // Notice Data

        $("#activity_type").html(data.mn_name)
        $("#activity_name").html(data.ea_name)
        $("#activity_from_date").html(getFormattedDate(data.ea_from_date, "dmY"))
        $("#activity_from_time").html(data.ea_from_time)
        $("#activity_to_date").html(getFormattedDate(data.ea_to_date, "dmY"))
        $("#activity_to_time").html(data.ea_to_time)
        deptClassList();
        ear_rpList()
        ear_orgList()
      })

    })

    $(document).on("click", ".ear", function() {
      selectList("rp");
      selectList("org");
      ear_rpList()
    })
    
    // Add Resource to Activity - Resource Person
    
    $(document).on("change", "#sel_rp", function() {
      var rp_id = $("#sel_rp").val()
      var ea_id = $("#ea_idHidden").val()
      // $.alert(" rp_id " + rp_id + " EA " + ea_id)
      $.post("enrichmentSql.php", {
        ea_id: ea_id,
        rp_id: rp_id,
        action: "ear_rp"
      }, function() {}, "text").done(function(data, status) {
        // $.alert(data)
        ear_rpList()
      })
    })

    function ear_rpList() {
      var ea_id = $("#ea_idHidden").val()
      // $.alert(" EAR_RP " + ea_id)
      $.post("enrichmentSql.php", {
        ea_id: ea_id,
        action: "ear_rpList"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data)
        console.log(data)
        var card = '';
        var count = 1;
        // $.alert(data);
        $.each(data, function(key, value) {
          card += '<div class="border mt-2">';
          card += '<div class="row mt-2">';
          card += '<div class="col-sm-10">';
          card += '[ID : ' + value.rp_id
          card += '] ' + value.rp_name
          card += '</div>'
          card += '<div class="col-sm-2 text-right">';
          card += ' <a href="#" class="largeText ear_rpDelete fa fa-times-circle" data-ea="' + value.ea_id + '" data-rp="' + value.rp_id + '" ></a>';
          card += '</div>'
          card += '</div>'
          card += '<div class="row">';
          card += '<div class="col-sm-12">';
          card += '<input type="text" class="form-control form-control-sm ear_rpUpdate" title="Title of the Talk (task_name)" name="ear_task_name" data-tag="ear_task_name" data-rp="' + value.rp_id + '" id="ear_task_name' + value.rp_id + '" value="' + value.ear_task_name + '">';
          card += '</div>'
          card += '</div>'

          card += '<div class="row mt-1">';
          card += '<div class="col-sm-12">';
          card += '<textarea class="form-control form-control-sm ear_rpUpdate" rows="3" title="A brief about of the Talk (task_about)" name="ear_task_about" data-tag="ear_task_about"  data-rp="' + value.rp_id + '" id="ear_task_about' + value.rp_id + '">' + value.ear_task_about + '</textarea>';
          card += '</div>';
          card += '</div>'
          card += '</div>'
        });
        $(".ear_rpList").html(card);
      }).fail(function() {
        $.alert("EAR RP Not Responding");
      })
    }

    $(document).on("click", ".ear_rpDelete", function() {
      var ea_id = $("#ea_idHidden").val()
      var rp_id = $(this).attr('data-rp');
      // $.alert(" ea_id " + ea_id + " RP " + rp_id)
      
      $.confirm({
        title: 'Please Confirm!',
        draggable: true,
        content: "<b><i>This will Delete Complete Information about the Task !!</i></b>",
        buttons: {
          confirm: {
            btnClass: 'btn-info',
            action: function() {
              $.post("enrichmentSql.php", {
                rp_id: rp_id,
                ea_id: ea_id,
                action: "ear_rpDelete"
              }, () => {}, "text").done(function(data, status) {
                // $.alert(data);
              })
              ear_rpList()
            }
          },
          cancel: {
            btnClass: "btn-danger",
            action: function() {}
          },
        }
      });
    })

    $(document).on("blur", ".ear_rpUpdate", function() {
      var ea_id = $("#ea_idHidden").val()
      var rp_id = $(this).attr('data-rp');
      var tag = $(this).attr('data-tag');

      if (tag == 'ear_task_name') var value = $("#ear_task_name" + rp_id).val();
      else if (tag == 'ear_task_about') var value = $("#ear_task_about" + rp_id).val();

      // $.alert(" Tag  " + tag + " ea_id " + ea_id + " RP " + rp_id + " value " + value)

      $.post("enrichmentSql.php", {
        tag: tag,
        value: value,
        rp_id: rp_id,
        ea_id: ea_id,
        action: "ear_rpUpdate"
      }, function() {}, "text").done(function(data, status) {
        // $.alert(data);
      })
    });

    // Add Resource to Activity - Resource Industry

    $(document).on("change", "#sel_org", function() {
      var org_id = $("#sel_org").val()
      var ea_id = $("#ea_idHidden").val()
      // $.alert(" rp_id " + rp_id + " EA " + ea_id)
      $.post("enrichmentSql.php", {
        ea_id: ea_id,
        org_id: org_id,
        action: "ear_org"
      }, function() {}, "text").done(function(data, status) {
        // $.alert(data)
        ear_orgList()
      })
    })

    function ear_orgList() {
      var ea_id = $("#ea_idHidden").val()
      // $.alert(" EAR_RP " + ea_id)
      $.post("enrichmentSql.php", {
        ea_id: ea_id,
        action: "ear_orgList"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data)
        console.log(data)
        var card = '';
        var count = 1;
        // $.alert(data);
        $.each(data, function(key, value) {
          card += '<div class="border mt-2">';
          card += '<div class="row mt-2">';
          card += '<div class="col-sm-10">';
          card += '[ID : ' + value.org_id
          card += '] ' + value.org_name
          card += '</div>'
          card += '<div class="col-sm-2 text-right">';
          card += ' <a href="#" class="largeText ear_orgDelete fa fa-times-circle" data-ea="' + value.ea_id + '" data-org="' + value.org_id + '" ></a>';
          card += '</div>'
          card += '</div>'
          card += '<div class="row">';
          card += '<div class="col-sm-12">';
          card += '<input type="text" class="form-control form-control-sm ear_orgUpdate" title="Title of the Talk (task_name)" name="ear_task_name" data-tag="ear_task_name" data-org="' + value.org_id + '" id="ear_task_name' + value.org_id + '" value="' + value.ear_task_name + '">';
          card += '</div>'
          card += '</div>'

          card += '<div class="row mt-1">';
          card += '<div class="col-sm-12">';
          card += '<textarea class="form-control form-control-sm ear_orgUpdate" rows="3" title="A brief about of the Talk (task_about)" name="ear_task_about" data-tag="ear_task_about"  data-org="' + value.org_id + '" id="ear_task_about' + value.org_id + '">' + value.ear_task_about + '</textarea>';
          card += '</div>';
          card += '</div>'
          card += '</div>'
        });
        $(".ear_orgList").html(card);
      }).fail(function() {
        $.alert("EAR Org Not Responding");
      })
    }

    $(document).on("click", ".ear_orgDelete", function() {
      var ea_id = $("#ea_idHidden").val()
      var org_id = $(this).attr('data-org');
      // $.alert(" ea_id " + ea_id + " RP " + org_id)
      
      $.confirm({
        title: 'Please Confirm!',
        draggable: true,
        content: "<b><i>This will Delete Complete Information about the Task !!</i></b>",
        buttons: {
          confirm: {
            btnClass: 'btn-info',
            action: function() {
              $.post("enrichmentSql.php", {
                org_id: org_id,
                ea_id: ea_id,
                action: "ear_orgDelete"
              }, () => {}, "text").done(function(data, status) {
                // $.alert(data);
              })
              ear_orgList()
            }
          },
          cancel: {
            btnClass: "btn-danger",
            action: function() {}
          },
        }
      });
    })

    $(document).on("blur", ".ear_orgUpdate", function() {
      var ea_id = $("#ea_idHidden").val()
      var org_id = $(this).attr('data-org');
      var tag = $(this).attr('data-tag');

      if (tag == 'ear_task_name') var value = $("#ear_task_name" + org_id).val();
      else if (tag == 'ear_task_about') var value = $("#ear_task_about" + org_id).val();

      // $.alert(" Tag  " + tag + " ea_id " + ea_id + " RP " + org_id + " value " + value)

      $.post("enrichmentSql.php", {
        tag: tag,
        value: value,
        org_id: org_id,
        ea_id: ea_id,
        action: "ear_orgUpdate"
      }, function() {}, "text").done(function(data, status) {
        // $.alert(data);
      })
    });

    // Participant Classes
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

    $(document).on("click", ".eapClass", function() {
      var classId = $(this).attr("data-class")
      var status = $(this).is(":checked");
      // $.alert("Participant Class Id " + classId + status);
      $.post("enrichmentSql.php", {
        classId: classId,
        status: status,
        action: "participant"
      }, function() {}, "text").done(function(data, status) {
        // $.alert(data)
      })
    })

    function selectList(tag) {
      //$.alert("In List Function");
      // if (tag == "department") tag = "dept";
      $.post("enrichmentSql.php", {
        tag: tag,
        action: "selectList"
      }, function() {}, "text").done(function(data, status) {
        //$.alert(data);
        if (tag == "rp") $(".rpList").html(data);
        else $(".orgList").html(data);
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