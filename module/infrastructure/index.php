<?php
require('../requireSubModule.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Outcome Based Education : ClassConnect</title>
	<?php require("../css.php"); ?>
</head>

<body>
  <?php require("../topBar.php"); 
  if ($myId > 3) {
    if (!isset($_GET['tag'])) die("Illegal Attempt !! The token is Missing");
    elseif (!in_array($_GET['tag'], $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
    elseif (!in_array("13", $myLinks)) die("Illegal Attempt !! Incorrect Tocken Found !!");
  }
  ?>
  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-1 p-0 m-0 pl-1 full-height">
        <h5 class="pt-3 largeText">Infrastructure</h5>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action  show active mb" data-toggle="list" href="#mb" role="tab" aria-controls="mb"> Manage Block </a>
          <a class="list-group-item list-group-item-action mt" data-toggle="list" href="#mt" role="tab" aria-controls="mt"> Manage Transport </a>
        </div>
      </div>
      <div class="col-sm-11 p-0">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane show active" id="mb" role="tabpanel" aria-labelledby="mb">
            <div class="row m-1">
              <div class="col-md-5 pr-0">
                <div class="container card myCard p-2">
                  <p class="largeText">Manage Block</p>
                  <form class="form-horizontal" id="blockForm">
                    <div class="row">
                      <div class="col-4 pr-0">
                        <div class="form-group">
                          <label>Block Name</label>
                          <input type="text" class="form-control form-control-sm" id="block_name" name="block_name" required />
                        </div>
                      </div>
                      <div class="col-2 pl-1 pr-0">
                        <div class="form-group">
                          <label>Floors</label>
                          <input type="number" class="form-control form-control-sm" id="block_floors" name="block_floors" min="1" value="1" />
                        </div>
                      </div>
                      <div class="col-2 pl-1 pr-0">
                        <div class="form-group">
                          <label>Type</label>
                          <select class="form-control form-control-sm" id="block_type" name="block_type">
                            <option value="Academic">Academic</option>
                            <option value="Administrative">Administrative</option>
                            <option value="Hostel">Hostel</option>
                            <option value="Sports">Sports Complex</option>
                            <option value="Auditorium">Auditorium</option>
                            <option value="Food">Food Court</option>
                            <option value="Shopping">Shopping Complex</option>
                            <option value="Incubator">Incubator</option>
                            <option value="Residential">Residential</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-4 pl-1">
                        <div class="form-group">
                          <label>Default Dept</label>
                          <?php
                          $sql = "select * from department where dept_status='0' order by dept_name";
                          selectList($conn, 'Department', array('1', 'dept_id', 'dept_abbri',  'dept_name', 'sel_dept'), $sql);
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <input type="hidden" id="blockAction" name="action" value="updateBlock">
                      <!-- Test id is required 0 for insert and other to update -->
                      <input type="hidden" id="block_idHidden" name="block_id" value="0">
                      <button class="btn btn-sm">Submit</button>
                    </div>
                  </form>
                </div>
                <div class="container card myCard mt-2">
                  <table class="table table-bordered table-striped list-table-xs mt-3" id="blockList">
                    <tr>
                      <th><i class="fa fa-pencil-alt"></i></th>
                      <th>#</th>
                      <th>Block Name</th>
                      <th>Department</th>
                      <th>Block Type</th>
                      <th>Floors</th>
                    </tr>
                  </table>
                </div>
              </div>
              <div class="col-md-7 pl-1">
                <div class="container card myCard p-2">
                  <p class="largeText">Add Locations to Block</p>
                  <form class="form-horizontal" id="blForm">
                    <div class="row">
                      <div class="col-2 pr-0">
                        <div class="form-group">
                          <label>Name</label>
                          <input type="text" class="form-control form-control-sm" id="bl_name" name="bl_name" required />
                        </div>
                      </div>
                      <div class="col-1 pl-1 pr-0">
                        <div class="form-group">
                          <label>Code</label>
                          <input type="text" class="form-control form-control-sm" id="bl_code" name="bl_code" required />
                        </div>
                      </div>
                      <div class="col-2 pl-1 pr-0">
                        <div class="form-group">
                          <label>Type</label>
                          <select class="form-control form-control-sm" id="bl_type" name="bl_type">
                            <option value="Class Room">Class Room</option>
                            <option value="Laboratory">Laboratory</option>
                            <option value="Workshop">Workshop</option>
                            <option value="Center of Excellence">Center of Excellence</option>
                            <option value="Research Laboratory">Research Laboratory</option>
                            <option value="Facility">Facility</option>
                            <option value="Hostel Room">Hostel Room</option>
                            <option value="Residence">Residence</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-1 pl-1 pr-0">
                        <div class="form-group">
                          <label>Cap</label>
                          <input type="number" class="form-control form-control-sm" id="bl_capacity" name="bl_capacity" min="1" value="1" title="Capacity of the Room" />
                        </div>
                      </div>
                      <div class="col-1 pl-1 pr-0">
                        <div class="form-group">
                          <label>Rows</label>
                          <input type="number" class="form-control form-control-sm" id="bl_rows" name="bl_rows" min="1" value="1" />
                        </div>
                      </div>
                      <div class="col-1 pl-1 pr-0">
                        <div class="form-group">
                          <label>Cols</label>
                          <input type="number" class="form-control form-control-sm" id="bl_cols" name="bl_cols" min="1" value="1" />
                        </div>
                      </div>
                      <div class="col-1 pl-1 pr-0">
                        <div class="form-group">
                          <label>Floor</label>
                          <input type="number" class="form-control form-control-sm" id="bl_floor" name="bl_floor" min="1" value="1" />
                        </div>
                      </div>
                      <div class="col-3 pl-1">
                        <div class="form-group">
                          <label>Dept</label>
                          <?php
                          $sql = "select * from department where dept_status='0' order by dept_name";
                          selectList($conn, 'Department', array('1', 'dept_id', 'dept_abbri',  'dept_name', 'bl_dept'), $sql);
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <!-- bl_id is required:  0 for insert and other to update -->
                      <input type="hidden" id="blAction" name="action" value="blUpdate">
                      <input type="hidden" id="bl_block" name="block_id" value="0">
                      <input type="hidden" id="bl_idHidden" name="bl_id" value="0">
                      <button class="btn btn-sm">Submit</button>
                    </div>
                  </form>
                </div>
                <div class="container card myCard mt-2">
                  <table class="table table-bordered table-striped list-table-xs mt-3" id="blList">
                    <tr>
                      <th><i class="fa fa-pencil-alt"></i></th>
                      <th>#</th>
                      <th>Name</th>
                      <th>Code</th>
                      <th>Type</th>
                      <th>Cap</th>
                      <th>Rows</th>
                      <th>Cols</th>
                      <th>Floor</th>
                      <th>Dept</th>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="mt" role="tabpanel" aria-labelledby="mt">
            <div class="row m-1">
              <div class="col-md-5 pr-0">
                <div class="container card myCard p-2">
                  <p class="largeText">Manage Routes</p>
                  <form class="form-horizontal" id="routeForm">
                    <div class="row">
                      <div class="col-4 pr-0">
                        <div class="form-group">
                          <label>Route Name</label>
                          <input type="text" class="form-control form-control-sm" id="tr_name" name="tr_name" required />
                        </div>
                      </div>
                      <div class="col-2 pl-1 pr-0">
                        <div class="form-group">
                          <label>Code</label>
                          <input type="text" class="form-control form-control-sm" id="tr_code" name="tr_code" required />
                        </div>
                      </div>
                      <div class="col-3 pl-1 pr-0">
                        <div class="form-group">
                          <label>First Stop</label>
                          <input type="text" class="form-control form-control-sm" id="tr_start" name="tr_start" />
                        </div>
                      </div>
                      <div class="col-3 pl-1">
                        <div class="form-group">
                          <label>Last Stop</label>
                          <input type="text" class="form-control form-control-sm" id="tr_end" name="tr_end" />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <input type="hidden" id="routeAction" name="action" value="trUpdate">
                      <!-- Test id is required 0 for insert and other to update -->
                      <input type="hidden" id="tr_idHidden" name="tr_id" value="0">
                      <button class="btn btn-sm">Submit</button>
                    </div>
                  </form>
                </div>
                <div class="container card myCard mt-2">
                  <table class="table table-bordered table-striped list-table-xs mt-3" id="trList">
                    <tr>
                      <th><i class="fa fa-pencil-alt"></i></th>
                      <th>#</th>
                      <th>Route Name</th>
                      <th>Route Code</th>
                      <th>First Stop</th>
                      <th>Last Stop</th>
                    </tr>
                  </table>
                </div>
              </div>
              <div class="col-md-5 pl-1">
                <div class="container card myCard p-2">
                  <p class="largeText">Add Stops to Route</p>
                  <form class="form-horizontal" id="stopForm">
                    <div class="row">
                      <div class="col-4 pr-0">
                        <div class="form-group">
                          <label>Name</label>
                          <input type="text" class="form-control form-control-sm" id="ts_name" name="ts_name" required />
                        </div>
                      </div>
                      <div class="col-2 pl-1 pr-0">
                        <div class="form-group">
                          <label>No</label>
                          <input type="number" class="form-control form-control-sm" id="ts_sno" name="ts_sno" min="1" value="1" />
                        </div>
                      </div>
                      <div class="col-3 pl-1 pr-0">
                        <div class="form-group">
                          <label>Longitude</label>
                          <input type="text" class="form-control form-control-sm" id="ts_longitude" name="ts_longitude" />
                        </div>
                      </div>
                      <div class="col-3 pl-1">
                        <div class="form-group">
                          <label>Lattitude</label>
                          <input type="text" class="form-control form-control-sm" id="ts_lattitude" name="ts_lattitude" />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <!-- bl_id is required:  0 for insert and other to update -->
                      <input type="hidden" id="tsAction" name="action" value="tsUpdate">
                      <input type="hidden" id="ts_tr" name="tr_id" value="0">
                      <input type="hidden" id="ts_idHidden" name="ts_id" value="0">
                      <button class="btn btn-sm">Submit</button>
                    </div>
                  </form>
                </div>
                <div class="container card myCard mt-2">
                  <table class="table table-bordered table-striped list-table-xs mt-3" id="tsList">
                    <tr>
                      <th><i class="fa fa-pencil-alt"></i></th>
                      <th>#</th>
                      <th>StopNo</th>
                      <th>Name</th>
                      <th>Long</th>
                      <th>Latt</th>
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
<script>
  $(document).ready(function() {

    $(function() {
      $(document).tooltip();
    });

    // Manage Block - Block
    blockList();

    $(document).on('submit', '#blockForm', function(event) {
      event.preventDefault(this);
      var formData = $(this).serialize();
      // $.alert(formData);
      $.post("infrastructureSql.php", formData, () => {}, "text").done(function(data) {
        // $.alert("List Updtaed" + data);
        $("#blockForm")[0].reset();
        blockList();
        $("#block_idHidden").val("0");
        $("#bl_block").val("0");
      })
    });

    function blockList() {
      // $.alert('hello');
      $.post("infrastructureSql.php", {
        action: "blockList",
      }, () => {}, "json").done(function(data, status) {
        var card = '';
        var count = 1;
        // $.alert(data);
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td><a href="#" class="blockEdit fa fa-pencil-alt" data-block="' + value.block_id + '"></td>';
          card += '<td>' + count++ + '</td>';
          card += '<td>' + value.block_name + '</td>';
          card += '<td>' + value.dept_abbri + '</td>';
          card += '<td>' + value.block_type + '</td>';
          card += '<td>' + value.block_floors + '</td>';
          card += '</tr>';
        });
        $("#blockList").find("tr:gt(0)").remove()
        $("#blockList").append(card);
      }).fail(function() {
        $.alert("Block Not Responding");
      })
    }

    $(document).on("click", ".blockEdit", function() {
      var block_id = $(this).attr("data-block")
      // $().removeClass();
      $(".blockEdit").removeClass('fa-circle')
      $(".blockEdit").addClass('fa-pencil-alt')

      $(this).removeClass('fa-pencil-alt');
      $(this).addClass('fa-circle')

      // $.alert("Edit - Fetch " + rp_id);
      $.post("infrastructureSql.php", {
        block_id: block_id,
        action: "blockFetch"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        $("#block_name").val(data.block_name)
        $("#sel_dept").val(data.dept_id)
        $("#block_type").val(data.block_type)
        $("#block_floors").val(data.block_floors)
        $("#block_idHidden").val(data.block_id)
        $("#bl_block").val(data.block_id) // To be part of BlockLocation Form
        $("#bl_dept").val($("#sel_dept").val())

        locationList();
      })
    })

    // Manage Block Location - Block
    locationList();

    $(document).on('submit', '#blForm', function(event) {
      event.preventDefault(this);
      var block_id = $("#bl_block").val()
      if ($("#bl_code").val() == " ") $.alert("Code Missing !!")
      else if (block_id > 0) {
        var formData = $(this).serialize();
        // $.alert(formData);
        $.post("infrastructureSql.php", formData, () => {}, "text").done(function(data) {
          // $.alert("List Updtaed" + data);
          $("#blForm")[0].reset();
          locationList();
          $("#bl_idHidden").val("0");
          $("#bl_dept").val($("#sel_dept").val())
        })
      } else $.alert("Please select a Block to Proceed !!!");
    });

    function locationList() {
      var block_id = $("#bl_block").val()
      $.post("infrastructureSql.php", {
        block_id: block_id,
        action: "blList",
      }, () => {}, "json").done(function(data, status) {
        var card = '';
        var count = 1;
        // $.alert(data);
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td><a href="#" class="blEdit fa fa-pencil-alt" data-bl="' + value.bl_id + '"></td>';
          card += '<td>' + count++ + '</td>';
          card += '<td>' + value.bl_name + '</td>';
          card += '<td>' + value.bl_code + '</td>';
          card += '<td>' + value.bl_type + '</td>';
          card += '<td>' + value.bl_capacity + '</td>';
          card += '<td>' + value.bl_rows + '</td>';
          card += '<td>' + value.bl_cols + '</td>';
          card += '<td>' + value.bl_floor + '</td>';
          card += '<td>' + value.dept_abbri + '</td>';
          card += '</tr>';
        });
        $("#blList").find("tr:gt(0)").remove()
        $("#blList").append(card);
      }).fail(function() {
        $.alert("Block-Location Not Responding");
      })
    }

    $(document).on("click", ".blEdit", function() {
      var bl_id = $(this).attr("data-bl")
      // $().removeClass();
      $(".blEdit").removeClass('fa-circle')
      $(".blEdit").addClass('fa-pencil-alt')

      $(this).removeClass('fa-pencil-alt');
      $(this).addClass('fa-circle')

      // $.alert("Edit - Fetch " + rp_id);
      $.post("infrastructureSql.php", {
        bl_id: bl_id,
        action: "blFetch"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        $("#bl_name").val(data.bl_name)
        $("#bl_dept").val(data.dept_id)
        $("#bl_code").val(data.bl_code)
        $("#bl_type").val(data.bl_type)
        $("#bl_capacity").val(data.bl_capacity)
        $("#bl_rows").val(data.bl_rows)
        $("#bl_cols").val(data.bl_cols)
        $("#bl_idHidden").val(data.bl_id)
      })
    })

    // Manage Route
    trList()

    $(document).on('submit', '#routeForm', function(event) {
      event.preventDefault(this);
      var formData = $(this).serialize();
      // $.alert(formData);
      $.post("infrastructureSql.php", formData, () => {}, "text").done(function(data) {
        // $.alert(data);
        $("#routeForm")[0].reset();
        trList();
        $("#tr_idHidden").val("0");
        $("#ts_tr").val("0");
      })
    });

    function trList() {
      // $.alert('hello');
      $.post("infrastructureSql.php", {
        action: "trList",
      }, () => {}, "json").done(function(data, status) {
        var card = '';
        var count = 1;
        // $.alert(data);
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td><a href="#" class="trEdit fa fa-pencil-alt" data-tr="' + value.tr_id + '"></td>';
          card += '<td>' + count++ + '</td>';
          card += '<td>' + value.tr_name + '</td>';
          card += '<td>' + value.tr_code + '</td>';
          card += '<td>' + value.tr_strat + '</td>';
          card += '<td>' + value.tr_end + '</td>';
          card += '</tr>';
        });
        $("#trList").find("tr:gt(0)").remove()
        $("#trList").append(card);
      }).fail(function() {
        $.alert("Block Not Responding");
      })
    }

    $(document).on("click", ".trEdit", function() {
      var tr_id = $(this).attr("data-tr")
      // $().removeClass();
      $(".trEdit").removeClass('fa-circle')
      $(".trEdit").addClass('fa-pencil-alt')

      $(this).removeClass('fa-pencil-alt');
      $(this).addClass('fa-circle')

      // $.alert("Edit - Fetch " + rp_id);
      $.post("infrastructureSql.php", {
        tr_id: tr_id,
        action: "trFetch"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        $("#tr_name").val(data.tr_name)
        $("#tr_code").val(data.tr_code)
        $("#tr_start").val(data.tr_start)
        $("#tr_end").val(data.tr_end)
        $("#tr_idHidden").val(data.tr_id)
        $("#ts_tr").val(data.tr_id) // To be part of Route-Stop Form
        tsList();
      })
    })

    // Manage Route Stop - Block
    tsList();

    $(document).on('submit', '#stopForm', function(event) {
      event.preventDefault(this);
      var tr_id = $("#ts_tr").val()
      if ($("#ts_name").val() == " ") $.alert("Stop Missing !!")
      else if (tr_id > 0) {
        var formData = $(this).serialize();
        // $.alert(formData);
        $.post("infrastructureSql.php", formData, () => {}, "text").done(function(data) {
          // $.alert(data);
          $("#stopForm")[0].reset();
          tsList();
          $("#ts_idHidden").val("0");
        })
      } else $.alert("Please select a Block to Proceed !!!");
    });

    function tsList() {
      var tr_id = $("#ts_tr").val()
      // $.alert("Route " + tr_id)
      $.post("infrastructureSql.php", {
        tr_id: tr_id,
        action: "tsList",
      }, () => {}, "json").done(function(data, status) {
        var card = '';
        var count = 1;
        // $.alert(data);
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td><a href="#" class="tsEdit fa fa-pencil-alt" data-ts="' + value.ts_id + '"></td>';
          card += '<td>' + count++ + '</td>';
          card += '<td>' + value.ts_name + '</td>';
          card += '<td>' + value.ts_sno + '</td>';
          card += '<td>' + value.ts_longitude + '</td>';
          card += '<td>' + value.ts_lattitude + '</td>';
          card += '</tr>';
        });
        $("#tsList").find("tr:gt(0)").remove()
        $("#tsList").append(card);
      }).fail(function() {
        $.alert("Route Stop Not Responding");
      })
    }

    $(document).on("click", ".tsEdit", function() {
      var ts_id = $(this).attr("data-ts")
      $("#ts_idHidden").val(ts_id)

      // $().removeClass();
      $(".tsEdit").removeClass('fa-circle')
      $(".tsEdit").addClass('fa-pencil-alt')

      $(this).removeClass('fa-pencil-alt');
      $(this).addClass('fa-circle')

      // $.alert("Edit - Fetch " + rp_id);
      $.post("infrastructureSql.php", {
        ts_id: ts_id,
        action: "tsFetch"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        $("#ts_name").val(data.ts_name)
        $("#ts_sno").val(data.ts_sno)
        $("#ts_longitude").val(data.ts_longitude)
        $("#ts_lattitude").val(data.ts_lattitude)
      })
    })
  });
</script>
</html>