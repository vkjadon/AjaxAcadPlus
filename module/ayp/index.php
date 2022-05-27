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
  <div class="content">

    <div class="container-fluid moduleBody">
      <div class="row">
        <div class="col-1 p-0 m-0 full-height">
          <h5 class="mt-3">AY Planner</h5>
          <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active bs" id="list-bs-list" data-toggle="list" href="#list-bs"> AY Activities </a>
            <a class="list-group-item list-group-item-action responsibility" id="list-responsibility-list" data-toggle="list" href="#list-responsibility"> Progress </a>
          </div>
        </div>
        <div class="col-11 leftLinkBody">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane show active" id="list-bs" role="tabpanel">
              <div class="row">
                <div class="col-sm-6">
                  <div class="mt-1 mb-1">
                    <h3>
                      <a class="fa fa-plus-circle p-0 addBatch"></a> Batch
                    </h3>
                  </div>
                  <div class="card myCard">
                    <p style="text-align: center;" id="batchShowList"></p>
                  </div>
                </div>
                <div class="col-6">
                  <div class="mt-1 mb-1">
                    <h3>
                      <a class="fa fa-plus-circle p-0 addSessionButton"></a> Session
                    </h3>
                  </div>

                  <div class="card myCard">
                    <input type="hidden" id="batchId" name="batchId">
                    <p id="batchSession"></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="list-responsibility" role="tabpanel">
              <div class="row">
                <div class="col-7 mt-1 mb-1">
                  <div class="container card mt-2 myCard">
                    <h5 class="p-2 mb-2">Assign Responsibilty</h5>
                    <div class="row">
                      <div class="col-3 pr-0">
                        <div class="form-group">
                          <label>Responsibility</label>
                          <?php
                          $sql_batch = "select * from master_name where mn_code='res' and mn_status='0' order by mn_name desc";
                          $result = $conn->query($sql_batch);
                          if ($result) {
                            echo '<select class="form-control form-control-sm" name="sel_resp" id="sel_resp" required>';
                            echo '<option selected disabled>Select Responsibility</option>';
                            while ($rows = $result->fetch_assoc()) {
                              $select_id = $rows['mn_id'];
                              $select_name = $rows['mn_name'];
                              echo '<option value="' . $select_id . '">' . $select_name . '[' . $rows['mn_abbri'] . ']</option>';
                            }
                            // echo '<option value="ALL">ALL</option>';
                            echo '</select>';
                          } else echo $conn->error;
                          if ($result->num_rows == 0) echo 'No Data Found';
                          ?>
                        </div>
                      </div>
                      <div class="col-3 pl-1 pr-0">
                        <div class="form-group">
                          <label class="selectLabel"></label>
                          <p class="selectList"></p>
                        </div>
                      </div>
                      <div class="col-3 pl-1 pr-0">
                        <div class="form-group">
                          <label>Staff</label>
                          <input type="text" class="form-control form-control-sm" id="staffSearch" name="staffSearch" placeholder="Search Staff" aria-label="Search">
                          <p class='list-group overlapList' id="staffAutoList"></p>
                        </div>
                      </div>
                      <div class="col-3 pl-1">
                        <div class="form-group">
                          <label>Office Order</label>
                          <input type="text" class="form-control form-control-sm" id="respOrder" name="respOrder">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-3 pr-0">
                        <div class="form-group">
                          <label>Scope</label>
                          <select class="form-control form-control-sm" name="sel_scope" id="sel_scope" required>
                            <option selected disabled>Select Scope</option>';
                            <option value="CLS">Class</option>
                            <option value="PRG">Programme</option>
                            <option value="DPT">Department</option>
                            <option value="INT">Institution</option>
                            <option value="GRP">Group</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-3 pl-1 pr-0">
                        <div class="form-group">
                          <label>Effective From</label>
                          <input type="date" class="form-control form-control-sm" id="respFrom" name="respFrom" value="<?php echo $submit_date; ?>">
                        </div>
                      </div>
                      <div class="col-3 pl-1 pr-0">
                        <div class="form-group">
                          <label>Effective Till</label>
                          <input type="date" class="form-control form-control-sm" id="respTo" name="respTo" value="<?php echo $submit_date; ?>">
                        </div>
                      </div>
                      <div class="col-3 pl-1">
                        <div class="form-group">
                          <label>Remarks</label>
                          <input type="text" class="form-control form-control-sm" id="respRemarks" name="respRemarks">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <input type="hidden" id="staffId" name="staffId">
                        <button type="submit" class="btn btn-sm respSubmit">Submit</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-5 mt-1 mb-1">
                  <p id="responsibilityList"></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require("../bottom_bar.php"); ?>
  </div>
  <h1>&nbsp;</h1>
</body>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    batchList();
    //Auto Search Block
    $('#staffSearch').keyup(function() {
      var searchString = $(this).val();
      //$.alert(searchString);
      if (searchString != '') {
        $.ajax({
          url: "aaSql.php",
          method: "POST",
          data: {
            action: "searchStaff",
            searchString: searchString
          },
          success: function(data) {
            //$.alert("List - " + data)
            $('#staffAutoList').fadeIn();
            $('#staffAutoList').html(data);
          }
        });
      } else {
        $('#staffAutoList').fadeOut();
        $('#staffAutoList').html("");
      }
    });

    $(document).on('click', '.staffAutoList', function() {
      $('#staffSearch').val($(this).text());
      var staffId = $(this).attr("data-staff");
      $('#staffId').val(staffId);
      $('#staffAutoList').fadeOut();
    });

    // Left Panel Block
    $(document).on('click', '.bs', function() {
      batchList();
    });

    $(document).on('change', '#sel_resp', function(event) {
      var mn_id = $("#sel_resp").val();
      // $.alert(" Resp " + mn_id);
      $.post("aaSql.php", {
        mn_id: mn_id,
        action: "respList"
      }, function() {}, "text").done(function(data, status) {
        // respNameList();
        selectList(mn_id);
        respList()
        //$.alert("List " + data);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.respName', function(event) {
      var respName = $("input[name='respName']:checked").val();
      $(".selectLabel").text(respName);
      //$.alert(" Pressed" + respName);

      $.post("aaSql.php", {
        respName: respName,
        action: "respList"
      }, function() {}, "text").done(function(data, status) {
        // respNameList();
        selectList(respName);
        respList()
        //$.alert("List " + data);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.respSubmit', function(event) {
      var mn_id = $("#sel_resp").val();
      var staffId = $("#staffId").val();
      var selectId = $("#selectId").val();
      var sel_scope = $("#sel_scope").val();
      var respRemarks = $("#respRemarks").val();
      var respFrom = $("#respFrom").val();
      var respTo = $("#respTo").val();
      var respOrder = $("#respOrder").val();
      // $.alert(" Staff " + staffId + " SelId " + selectId);
      $.post("aaSql.php", {
        selectId: selectId,
        sel_scope: sel_scope,
        mn_id: mn_id,
        respFrom: respFrom,
        respTo: respTo,
        respOrder: respOrder,
        respRemarks: respRemarks,
        staffId: staffId,
        action: "respName"
      }, function(data, status) {}, "text").done(function(data) {
        // $.alert("List " + data);
        respList()

      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    function respList() {
      var mn_id = $("#sel_resp").val();
      // $.alert(" Pressed" + mn_id);
      $.post("aaSql.php", {
        mn_id: mn_id,
        action: "respList"
      }, function() {}, "text").done(function(data, status) {
        $("#responsibilityList").html(data);
        //$.alert("Updated");
      }).fail(function() {
        $.alert("Error !!");
      })
    }
    

    $(document).on('submit', '#modalForm', function(event) {
      event.preventDefault(this);
      var action = $("#action").val();
      var batch = $("#newBatch").val();
      var selBatch = $("#batchId").val();
      var poc = $("#poCode").val();
      var poS = $("#poStatemnt").val();

      var sessionName = $("#session_name").val();

      var error = "NO";
      var error_msg = "";
      if (action == "addSession" || action == "updateSession") {
        if ($("#session_name").val() == "") {
          error = "YES";
          error_msg = "Session cannot be Blank!!";
        }
      } else if (action == "addBatch" || action == "updateBatch") {
        if ($("#newBatch").val() == "") {
          error = "YES";
          error_msg = "Batch is empty";
        }
      } 
      if (error == "NO") {
        var formData = $(this).serialize();
        $('#firstModal').modal('hide');
        // $.alert(" Pressed" + formData);
        $.post("aaSql.php", formData, () => {}, "text").done(function(data) {
          $.alert("List " + data);
          if (action == "addBatch" || action == "updateBatch") {
            batchList();
          } else if (action == "addSession" || action == "updateSession") {
            batchSession(selBatch);
          }
          $("#modalForm")[0].reset();
        }, "text").fail(function() {
          $.alert("fail in place of error");
        })
      } else {
        $.alert(error_msg);
      }
    });

    // Manage Session
    $(document).on('click', '.session_idD', function() {
      $.alert("Disabled");
    });
    $(document).on('click', '.addSessionButton', function(event) {
      var selBatch = $("#batchId").val();
      $.alert("New Session ");
      $('#modal_title').text("Add Session" + selBatch);
      $('#batchIdModal').val(selBatch);
      $('#action').val("addSession");
      $("#firstModal").modal('show');
      $(".batchForm").hide();
      $(".poForm").hide();
      $(".coForm").hide();
      $(".subjectForm").hide();
      $(".sessionForm").show();
    });
    $(document).on('click', '.batch_idSession', function() {
      var id = $(this).attr('data-id');
      //$.alert("Process Id " + id);
      batchSession(id);
    });
    $(document).on('click', '.session_idE', function() {
      var id = $(this).attr('data-id');
      $.alert("Id " + id);
      $.post("aaSql.php", {
        action: "fetchSession",
        sessionId: id
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.batch);
        $("#session_name").val(data.session_name);
        $("#session_remarks").val(data.session_remarks);
        $("#session_start").val(data.session_start);
        $("#session_end").val(data.session_end);
        $('#modal_title').text("Update Session [" + id + "]");
        $('#action').val("updateSession");
        $('#modalId').val(id);

        $(".batchForm").hide();
        $(".poForm").hide();
        $(".coForm").hide();
        $(".subjectForm").hide();
        $(".sessionForm").show();

        $('#submitModalForm').html("Submit");
        $('#firstModal').modal().show;


      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    // Manage Batch
    $(document).on('click', '.addBatch', function() {
      $('#modal_title').text("Add Batch");
      $('#action').val("addBatch");
      $('#firstModal').modal('show');
      $('.batchForm').show();
      $('.sessionForm').hide();
    });
    $(document).on('click', '.batch_idD', function() {
      $.alert("Disabled");
    });
    $(document).on('click', '.batch_idE', function() {
      var id = $(this).attr('id');
      //$.alert("Id " + id);
      $.post("aaSql.php", {
        action: "fetchBatch",
        batchId: id
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.batch);
        $("#newBatch").val(data.batch);
        $('#modal_title').text("Update Batch [" + id + "]");
        $('#action').val("updateBatch");
        $('#modalId').val(id);
        $(".batchForm").show();
        $(".poForm").hide();
        $(".coForm").hide();
        $(".subjectForm").hide();
        $(".sessionForm").hide();
        $('#submitModalForm').html("Submit");
        $('#firstModal').modal().show;


      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    // Functions
    function selectTemplate() {
      //$.alert("In List Function");
      $.post("aaSql.php", {
        action: "selectTemplate"
      }, function() {}, "text").done(function(data, status) {
        //$.alert(data);
        $("#selectTemplate").html(data);
      }).fail(function() {
        $.alert("Error !!");
      })
    }

    function selectList(tag) {
      // $.alert( "Select " + tag);
      $.post("aaSql.php", {
        tag: tag,
        action: "selectList"
      }, function() {}, "text").done(function(data, status) {
        //$.alert(data);
        $(".selectList").html(data);
      }).fail(function() {
        $.alert("Error !!");
      })
    }

    function batchSession(x) {
      //$.alert("Batch " + x);
      $.post("aaSql.php", {
        action: "batchSession",
        batchId: x
      }, function(data, status) {
        //$.alert("Data" + data)
        $("#batchSession").html(data);
        $("#batchId").val(x);
      }, "text").fail(function() {
        $.alert("Error in BatchSession Function");
      })
    }

    function batchList() {
      //$.alert("In List Function"+ x + y);
      $.post("aaSql.php", {
        action: "batchList"
      }, function(mydata, mystatus) {
        $("#batchShowList").show();
        //$.alert("List " + mydata);
        $("#batchShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function programSelectList() {
      var x = $("#sel_school").val();
      var y = $("#sel_batch").val();
      //$.alert("In Program Select List Function" + x);
      $.post("aaSql.php", {
        actionSession: "programSelectList",
        schoolId: x,
        batchId: y
      }, function(mydata, mystatus) {
        $("#programShowList").show();
        //$.alert("List " + mydata);
        $("#programShowList").html(mydata);
      }, "text").fail(function() {
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
<!-- Modal Section-->
<div class="modal" id="firstModal">
  <div class="modal-dialog">
    <form class="form-horizontal" id="modalForm">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->
        <!-- Modal body -->
        <div class="modal-body">
          <div class="batchForm">
            <div class="form-horizontal">
              <div class="form-group">
                <div class="row">
                  <div class="col-sm-4">
                    Batch<input type="text" class="form-control form-control-sm" id="newBatch" name="newBatch" placeholder="Batch">
                  </div>
                  <div class="col-sm-4">
                    Academic Year<input type="text" class="form-control form-control-sm" id="ay" name="ay" placeholder="Academic Year">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="sessionForm">
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Session Name
                  <input type="text" class="form-control form-control-sm" id="session_name" name="session_name" placeholder="Session Name">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  Session Remarks
                  <input type="text" class="form-control form-control-sm" id="session_remarks" name="session_remarks" placeholder="Remarks">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                Start Date
                <input type="date" class="form-control form-control-sm" id="session_start" name="session_start" placeholder="Strat Date" value="<?php echo $submit_date; ?>">
              </div>
              <div class="col-6">
                End Date
                <input type="date" class="form-control form-control-sm" id="session_end" name="session_end" placeholder="Strat Date" value="<?php echo $submit_date; ?>">
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->
        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="modalId" name="modalId">
          <input type="hidden" id="action" name="action">
          <input type="hidden" id="batchIdModal" name="batchIdModal">
          <button type="submit" class="btn btn-secondary" id="submitModalForm">Submit</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->

    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

</html>