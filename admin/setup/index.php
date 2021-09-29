<?php
session_start();
require("config_database.php");
require("../../php_function.php");
$phpFile = "setupSql.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>AcadPlus</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="../../css/table.css">
  <link rel="stylesheet" href="../../css/card.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

  <!-- Plugins -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

</head>

<body>
  <h1 class="display-3"> ClassConnect-Admin </h1>
  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-2 p-0 m-0 pl-2 full-height">
        <div class="mt-3">
          <h5>Manage <?php echo $db; ?></h5>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action show active ml" data-toggle="list" href="#ml" role="tab" aria-controls="ml">Manage Links</a>
          <a class="list-group-item list-group-item-action mt" data-toggle="list" href="#mt" role="tab" aria-controls="mt">Manage Tables</a>
          <a class="atag" href="../logout.php" role="tab" aria-controls="lo"> <i class="fa fa-sign-out-alt"></i> LogOut</a>
        </div>
      </div>
      <div class="col-10 leftLinkBody">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane show active" id="ml" role="tabpanel" aria-labelledby="list-ml-list">
            <div class="row">
              <div class="col-8">
                <div class="container card myCard">
                  <!-- nav options -->
                  <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="pill" href="#pml" role="tab" aria-controls="pml" aria-selected="true">Portal Menu Links</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="pill" id="pgPill" href="#pgl" role="tab" aria-controls="pgl" aria-selected="true">Portal Group Links</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="pill" id="plPill" href="#pl" role="tab" aria-controls="pl" aria-selected="true">Portal Links</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="pills-tabContent p-3">
                    <div class="tab-pane show active" id="pml" role="tabpanel" aria-labelledby="pml">
                      <div class="row">
                        <div class="col-md-12">
                          <form id="pmForm">
                            <div class="row">
                              <div class="col-md-3 pr-0">
                                <div class="form-group">
                                  <label>Menu Name</label>
                                  <input type="text" class="form-control form-control-sm" id="pm_name" name="pm_name">
                                </div>
                              </div>
                              <div class="col-md-1 pl-1 pr-0">
                                <div class="form-group">
                                  <label>SNo.</label>
                                  <input type="number" min="1" class="form-control form-control-sm" id="pm_sno" name="pm_sno" value="1">
                                </div>
                              </div>
                              <div class="col-md-2 pl-0">
                                <div class="form-group mt-3">
                                  <input type="hidden" id="pm_hidden" name="pm_hidden" value="0">
                                  <input type="hidden" name="action" value="addUpdateMenu">
                                  <input type="submit" class="btn btn-sm" value="Save/Update">
                                </div>
                              </div>
                            </div>
                          </form>
                          <table class="table table-bordered list-table-xs" id="pmList">
                            <thead>
                              <th><i class="fa fa-pencil-alt" aria-hidden="true"></i></th>
                              <th>Id</th>
                              <th>Order</th>
                              <th>Menu Name</th>
                              <th><i class="fas fa-trash"></i></th>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="pgl" role="tabpanel" aria-labelledby="pgl">
                      <div class="row">
                        <div class="col-md-12">
                          <form id="pgForm">
                            <div class="row">
                              <div class="col-md-3 pr-0">
                                <div class="form-group">
                                  <label>Menu Name</label>
                                  <?php
                                  $sql = "select * from portal_menu where pm_status='0'";
                                  $result = $conn->query($sql);
                                  if ($result) {
                                    echo '<select class="form-control form-control-sm" name="sel_pm" id="sel_pm">';
                                    while ($rows = $result->fetch_assoc()) {
                                      echo '<option value="' . $rows["pm_id"] . '">' . $rows["pm_name"] . '</option>';
                                    }
                                    echo '</select>';
                                  }
                                  ?>
                                </div>
                              </div>
                              <div class="col-md-3 pl-1 pr-0">
                                <div class="form-group">
                                  <label>Group Name</label>
                                  <input type="text" class="form-control form-control-sm" id="pg_name" name="pg_name">
                                </div>
                              </div>
                              <div class="col-md-1 pl-1 pr-0">
                                <div class="form-group">
                                  <label>SNo.</label>
                                  <input type="number" min="1" class="form-control form-control-sm" id="pg_sno" name="pg_sno" value="1">
                                </div>
                              </div>
                              <div class="col-md-2 pl-0">
                                <div class="form-group mt-3">
                                  <input type="hidden" id="pg_hidden" name="pg_hidden" value="0">
                                  <input type="hidden" name="action" value="addUpdateGroup">
                                  <input type="submit" class="btn btn-sm" value="Save/Update">
                                </div>
                              </div>
                            </div>
                          </form>
                          <table class="table table-bordered list-table-xs" id="pgList">
                            <thead>
                              <th><i class="fa fa-pencil-alt" aria-hidden="true"></i></th>
                              <th>Id</th>
                              <th>Order</th>
                              <th>Menu Name</th>
                              <th><i class="fas fa-trash"></i></th>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="pl" role="tabpanel" aria-labelledby="pl">
                      <div class="row">
                        <div class="col-md-12">
                          <form id="plForm">
                            <div class="row">
                              <div class="col-md-3 pr-0">
                                <div class="form-group">
                                  <label>Group Name</label>
                                  <?php
                                  $sql = "select * from portal_group where pg_status='0'";
                                  $result = $conn->query($sql);
                                  if ($result) {
                                    echo '<select class="form-control form-control-sm" name="sel_pg" id="sel_pg">';
                                    while ($rows = $result->fetch_assoc()) {
                                      echo '<option value="' . $rows["pg_id"] . '">' . $rows["pg_name"] . '</option>';
                                    }
                                    echo '</select>';
                                  }
                                  ?>
                                </div>
                              </div>
                              <div class="col-md-3 pl-1 pr-0">
                                <div class="form-group">
                                  <label>Link Name</label>
                                  <input type="text" class="form-control form-control-sm" id="pl_name" name="pl_name">
                                </div>
                              </div>
                              <div class="col-md-1 pl-1 pr-0">
                                <div class="form-group">
                                  <label>SNo.</label>
                                  <input type="number" min="1" class="form-control form-control-sm" id="pl_sno" name="pl_sno" value="1">
                                </div>
                              </div>
                              <div class="col-md-1 pl-1 pr-0">
                                <div class="form-group">
                                  <label>Default</label>
                                  <select class="form-control form-control-sm" id="pl_default" name="pl_default">
                                    <option value="0">Yes</option>
                                    <option value="1">No</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-2 pl-0">
                                <div class="form-group mt-3">
                                  <input type="hidden" id="pl_hidden" name="pl_hidden" value="0">
                                  <input type="hidden" name="action" value="addUpdateLink">
                                  <input type="submit" class="btn btn-sm" value="Save/Update">
                                </div>
                              </div>
                            </div>
                          </form>
                          <table class="table table-bordered list-table-xs" id="plList">
                            <thead>
                              <th><i class="fa fa-pencil-alt" aria-hidden="true"></i></th>
                              <th>Id</th>
                              <th>Order</th>
                              <th>Link Name</th>
                              <th><i class="fas fa-trash"></i></th>
                            </thead>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="mt" role="tabpanel" aria-labelledby="list-mt-list">
            <div class="row">
              <div class="col-sm-4">
                <div class="card myCard">
                  <div class="card-body">
                    <h3>MCE</h3>
                    <div class="row">
                      <div class="col">
                        <button class="btn btn-sm adminSetup" data-tag="mce">Admin Setup</button>
                        <button class="btn btn-sm createTable" data-tag="mce">Create SetUp Tables</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card myCard mt-2">
                  <div class="card-body">
                    <h3>Aryans</h3>
                    <div class="row">
                      <div class="col">
                        <button class="btn btn-sm adminSetup" data-tag="aryan">Admin Setup</button>
                        <button class="btn btn-sm createTable" data-tag="aryan">Create SetUp Tables</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
  </div>


  <script>
    $(document).ready(function() {

      $(document).on('submit', '#pmForm, #pgForm, #plForm', function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        // $.alert(formData);
        $.post("<?php echo $phpFile; ?>", formData, () => {}, "text").done(function(data) {
          // $.alert(data);
          // $("#pmForm").reset[0]
          $('#pmForm')[0].reset();
          $('#pgForm')[0].reset();
          $('#plForm')[0].reset();
          pmList()
          pgList()
          plList()
        }).fail(function() {
          $.alert("fail in place of error");
        })
      });

      $(document).on('click', '#plPill', function() {
        plList();
      });

      $(document).on('change', '#sel_pg', function() {
        plList();
      });

      $(document).on('click', '#pgPill', function() {
        pgList();
      });
      $(document).on('click', '.editPl', function() {
        var pl_id = $(this).attr("data-pl")
        // $.alert(" Pl " + pl_id)
        $.post("<?php echo $phpFile; ?>", {
          pl_id: pl_id,
          action: "fetchLink"
        }, function() {}, "json").done(function(data, status) {
          // $.alert(data.pm_name);
          $("#pl_name").val(data.pl_name);
          $("#pl_sno").val(data.pl_sno);
          $("#pl_hidden").val(data.pl_id);
        }).fail(function() {
          $.alert("Error !!");
        })
      });

      function plList() {
        var pg_id = $("#sel_pg").val();
        // $.alert("Group Link " + pg_id);
        $.post("<?php echo $phpFile; ?>", {
          pg_id: pg_id,
          action: "plList"
        }, function() {}, "json").done(function(data, status) {
          // $.alert(data);
          console.log(data);
          var card = '';
          var count = 1;
          $.each(data, function(key, value) {
            card += '<tr>';
            card += '<td><a href="#" class="fa fa-edit editPl" data-pl="' + value.pl_id + '"></a></td>';
            card += '<td>' + value.pl_sno + '</td>';
            card += '<td>' + value.pl_id + '</td>';
            card += '<td>' + value.pl_name + '</td>';
            card += '<td><a href="#" class="fa fa-trash trashPl" data-pl="' + value.pl_id + '"></a></td>';
            card += '</tr>';
          });
          $("#plList").find("tr:gt(0)").remove();
          $("#plList").append(card);

        }).fail(function() {
          $.alert("Error !!");
        })
      }

      $(document).on('change', '#sel_pm', function() {
        pgList();
      });

      $(document).on('click', '.editPg', function() {
        var pg_id = $(this).attr("data-pg")
        $.alert(" Pg " + pg_id)
        $.post("<?php echo $phpFile; ?>", {
          pg_id: pg_id,
          action: "fetchGroup"
        }, function() {}, "json").done(function(data, status) {
          // $.alert(data.pm_name);
          $("#pg_name").val(data.pg_name);
          $("#pg_sno").val(data.pg_sno);
          $("#pg_hidden").val(data.pg_id);
        }).fail(function() {
          $.alert("Error !!");
        })
      });

      function pgList() {
        var pm_id = $("#sel_pm").val();
        // $.alert("Group Link " + pm_id);
        $.post("<?php echo $phpFile; ?>", {
          pm_id: pm_id,
          action: "pgList"
        }, function() {}, "json").done(function(data, status) {
          // $.alert(data);
          console.log(data);
          var card = '';
          var count = 1;
          $.each(data, function(key, value) {
            card += '<tr>';
            card += '<td><a href="#" class="fa fa-edit editPg" data-pg="' + value.pg_id + '"></a></td>';
            card += '<td>' + value.pg_id + '</td>';
            card += '<td>' + value.pg_sno + '</td>';
            card += '<td>' + value.pg_name + '</td>';
            card += '<td><a href="#" class="fa fa-trash trashPg" data-pg="' + value.pg_id + '"></a></td>';
            card += '</tr>';
          });
          $("#pgList").find("tr:gt(0)").remove();
          $("#pgList").append(card);

        }).fail(function() {
          $.alert("Error !!");
        })

      }
      pmList();
      $(document).on('click', '.editMl', function() {
        var pm_id = $(this).attr("data-pm")
        // $.alert(" Pm " + pm_id)
        $.post("<?php echo $phpFile; ?>", {
          pm_id: pm_id,
          action: "fetchMenu"
        }, function() {}, "json").done(function(data, status) {
          // $.alert(data.pm_name);
          $("#pm_name").val(data.pm_name);
          $("#pm_sno").val(data.pm_sno);
          $("#pm_hidden").val(data.pm_id);
        }).fail(function() {
          $.alert("Error !!");
        })
      });

      function pmList() {
        // $.alert("Menu Link");
        $.post("<?php echo $phpFile; ?>", {
          action: "pmList"
        }, function() {}, "json").done(function(data, status) {
          // $.alert(data);
          // console.log(data);
          var card = '';
          var count = 1;
          $.each(data, function(key, value) {
            card += '<tr>';
            card += '<td><a href="#" class="fa fa-edit editMl" data-pm="' + value.pm_id + '"></a></td>';
            card += '<td>' + count++ + '</td>';
            card += '<td>' + value.pm_sno + '</td>';
            card += '<td>' + value.pm_name + '</td>';
            card += '<td><a href="#" class="fa fa-trash trashMl" data-pm="' + value.pm_id + '"></a></td>';
            card += '</tr>';
          });
          $("#pmList").find("tr:gt(0)").remove();
          $("#pmList").append(card);

        }).fail(function() {
          $.alert("Error !!");
        })
      }

      $('.createTable').click(function(event) {
        $.alert("Craete Tables ");
        $.post("createTables.php", {}, function() {}, "text").done(function(data, status) {
          $.alert(data);
        }).fail(function() {
          alert("fail in place of error");
        })
      });
    });
  </script>

</body>

</html>