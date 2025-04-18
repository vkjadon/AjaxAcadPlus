<?php
require('../requireSubModule.php');
addActivity($conn, $myId, "Academic Setting", $submit_ts);

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
        <div class="col-1 p-0 m-0 pl-1 full-height">
          <h5 class="pt-3 text-center">Academics</h5>
          <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active bs" id="list-bs-list" data-toggle="list" href="#list-bs"> Batch/Session </a>
            <a class="list-group-item list-group-item-action responsibility" id="list-responsibility-list" data-toggle="list" href="#list-responsibility"> Responsibility </a>
            <a class="list-group-item list-group-item-action  master" id="list-master-list" data-toggle="list" href="#list-master"> Master Data </a>
            <a class="list-group-item list-group-item-action astmp" data-toggle="list" href="#astmp"> Ass Template</a>
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
                <div class="col-9 mt-1 mb-1">
                  <div class="container card myCard">
                    <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab">
                      <li class="nav-item">
                        <a class="nav-link active tabLink" data-toggle="pill" href="#resp" data-tag="resp">Responsibility</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link tabLink" data-toggle="pill" href="#hod" data-tag="hod">HOD</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link tabLink" data-toggle="pill" href="#director" data-tag="director">Director</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link tabLink" data-toggle="pill" href="#gd" data-tag="gd">Group Director</a>
                      </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent p-3">
                      <div class="row m-1 border">
                        <div class="col-md-3 pr-0">
                          <div class="form-group">
                            <label>Staff</label>
                            <input type="text" class="form-control form-control-sm" id="staffSearch" name="staffSearch" placeholder="Search Staff" aria-label="Search">
                            <p class='list-group overlapList' id="staffAutoList"></p>
                            <input type="hidden" id="staffId" name="staffId">
                          </div>
                        </div>
                        <div class="col-md-2 pl-1 pr-0">
                          <div class="form-group">
                            <label>Effective From</label>
                            <input type="date" class="form-control form-control-sm" id="respFrom" name="respFrom" value="<?php echo $submit_date; ?>">
                          </div>
                        </div>
                        <div class="col-md-2 pl-1 pr-0">
                          <div class="form-group">
                            <label>Effective Till</label>
                            <input type="date" class="form-control form-control-sm" id="respTo" name="respTo" value="<?php echo $submit_date; ?>">
                          </div>
                        </div>
                        <div class="col-md-2 pl-1 pr-0">
                          <div class="form-group">
                            <label>Office Order</label>
                            <input type="text" class="form-control form-control-sm" id="respOrder" name="respOrder">
                          </div>
                        </div>
                        <div class="col-md-3 pl-1">
                          <div class="form-group">
                            <label>Remarks</label>
                            <input type="text" class="form-control form-control-sm" id="respRemarks" name="respRemarks">
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane show active" id="resp">
                        <div class="row m-1 border">
                          <div class="col-md-4 border">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label>Responsibility</label>
                                  <?php
                                  $sql = "select * from master_name where mn_code='res' and mn_status='0' order by mn_name desc";
                                  $result = $conn->query($sql);
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
                            </div>
                            <div class="row">
                              <div class="col">
                                <button type="submit" class="btn btn-sm respSubmit" data-tag="respName">Submit</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="hod">
                        <div class="row m-1 border">
                          <div class="col-md-4 border">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label>Select a Department</label>
                                  <?php
                                  $sql = "select * from department where dept_status='0' order by dept_name";
                                  $result = $conn->query($sql);
                                  if ($result) {
                                    echo '<select class="form-control form-control-sm" name="sel_dept" id="sel_dept" required>';
                                    echo '<option selected disabled>Select Department</option>';
                                    while ($rows = $result->fetch_assoc()) {
                                      $select_id = $rows['dept_id'];
                                      $select_name = $rows['dept_name'];
                                      echo '<option value="' . $select_id . '">' . $select_name . '[' . $rows['dept_abbri'] . ']</option>';
                                    }
                                    // echo '<option value="ALL">ALL</option>';
                                    echo '</select>';
                                  } else echo $conn->error;
                                  if ($result->num_rows == 0) echo 'No Data Found';
                                  ?>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col">
                                <button type="submit" class="btn btn-sm respSubmit" data-tag="hod">Submit</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="director">
                        <div class="row m-1 border">
                          <div class="col-md-4 border">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label>Select an Institution</label>
                                  <?php
                                  $sql = "select * from school where school_status='0' order by school_name";
                                  $result = $conn->query($sql);
                                  if ($result) {
                                    echo '<select class="form-control form-control-sm" name="sel_school" id="sel_school" required>';
                                    echo '<option selected disabled>Select Institution</option>';
                                    while ($rows = $result->fetch_assoc()) {
                                      $select_id = $rows['school_id'];
                                      $select_name = $rows['school_name'];
                                      echo '<option value="' . $select_id . '">' . $select_name . '[' . $rows['dept_abbri'] . ']</option>';
                                    }
                                    // echo '<option value="ALL">ALL</option>';
                                    echo '</select>';
                                  } else echo $conn->error;
                                  if ($result->num_rows == 0) echo 'No Data Found';
                                  ?>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col">
                                <button type="submit" class="btn btn-sm respSubmit" data-tag="dir">Submit</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="gd">
                        <div class="row m-1 border">
                          <div class="col-md-4 border">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label>Select Group</label>
                                  <?php
                                  $sql = "select * from institution where inst_status='0' order by inst_name";
                                  $result = $conn->query($sql);
                                  if ($result) {
                                    echo '<select class="form-control form-control-sm" name="sel_inst" id="sel_inst" required>';
                                    while ($rows = $result->fetch_assoc()) {
                                      $select_id = $rows['inst_id'];
                                      $select_name = $rows['inst_name'];
                                      echo '<option value="' . $select_id . '">' . $select_name . '[' . $rows['dept_abbri'] . ']</option>';
                                    }
                                    // echo '<option value="ALL">ALL</option>';
                                    echo '</select>';
                                  } else echo $conn->error;
                                  if ($result->num_rows == 0) echo 'No Data Found';
                                  ?>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col">
                                <button type="submit" class="btn btn-sm respSubmit" data-tag="gd">Submit</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-10 mt-1 mb-1">
                      <p id="responsibilityList"></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="list-master" role="tabpanel">
              <div class="row">
                <div class="col-7 mt-1 mb-1">
                  <div class="container card shadow d-flex justify-content-center mt-2 myCard">
                    <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab">
                      <li class="nav-item">
                        <a class="nav-link active tabLink" data-toggle="pill" href="#nr" data-tag="nr">Name-Remarks</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link tabLink" data-toggle="pill" href="#res" data-tag="res">New Tab</a>
                      </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent p-3">
                      <div class="tab-pane show active" id="nr">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <input type="radio" checked class="headName" id="rt" name="headName" value="rt">
                              Resource(rt)
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <input type="radio" class="headName" id="fbt" name="headName" value="fbt">
                              Feedback(fbt)
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <input type="radio" class="headName" id="cst" name="headName" value="cst">
                              Caste(cst)
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <input type="radio" class="headName" id="qt" name="headName" value="qt">
                              Qualification(qt)
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <input type="radio" class="headName" id="dg" name="headName" value="dg">
                              Designation(dg)
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <input type="radio" class="headName" id="bg" name="headName" value="bg">
                              Blood Group(bg)
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <input type="radio" class="headName" id="am" name="headName" value="am">
                              Assess. Method(am)
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <input type="radio" class="headName" id="at" name="headName" value="at">
                              Assess. Tool(at)
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <input type="radio" class="headName" id="ac" name="headName" value="ac">
                              Assess. Components(ac)
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <input type="radio" class="headName" id="ft" name="headName" value="ft">
                              Fee Type(ft)
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <input type="radio" class="headName" id="fc" name="headName" value="fc">
                              Fee Components(fc)
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <input type="radio" class="headName" id="fcg" name="headName" value="fcg">
                              Fee Category(fcg)
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <input type="radio" class="headName" id="fm" name="headName" value="fm">
                              Transaction Mode(fm)
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <input type="radio" class="headName" id="ph" name="headName" value="ph">
                              Payment Head (ph)
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <input type="radio" class="headName" id="sts" name="headName" value="sts">
                              Student Status(sts)
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <input type="radio" class="headName" id="ss" name="headName" value="ss">
                              Specialization(ss)
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <input type="radio" class="headName" id="cca" name="headName" value="cca">
                              Cocurricular Activity(cca)
                            </div>
                          </div>

                          <div class="col">
                            <div class="form-group">
                              <input type="radio" class="headName" id="eca" name="headName" value="eca">
                              Extra Curricular(eca)
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <input type="radio" class="headName" id="rel" name="headName" value="rel">
                              Religion(rel)
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <input type="radio" class="headName" id="dse" name="headName" value="dse">
                              Delete Std Entry(dse)
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <div class="form-group">
                                <input type="radio" class="headName" id="res" name="headName" value="res">
                                Responsibility(res)
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <input type="radio" class="headName" id="adc" name="headName" value="adc">
                              Admission Category(adc)
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <input type="radio" class="headName" id="scl" name="headName" value="scl">
                              Scholarships (scl)
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <input type="radio" class="headName" id="doc" name="headName" value="doc">
                              Documents (doc)
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <input type="radio" class="headName" id="salcmp" name="headName" value="slc">
                              Salary Component(slc)
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <input type="radio" class="headName" id="salddc" name="headName" value="sld">
                              Salary Deduction (sld)
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <input type="radio" class="headName" id="ect" name="headName" value="ect">
                              Event Type (ect)
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-4 pr-1">
                            <div class="form-group">
                              <label>Name</label>
                              <input type="text" class="form-control form-control-sm" id="name" name="name">
                            </div>
                          </div>
                          <div class="col-2 pl-0 pr-1">
                            <div class="form-group">
                              <label>Abbri</label>
                              <input type="text" class="form-control form-control-sm" id="abbri" name="abbri">
                            </div>
                          </div>
                          <div class="col-6 pl-0">
                            <div class="form-group">
                              <label>Remarks</label>
                              <input type="text" class="form-control form-control-sm" id="remarks" name="remarks">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <input type="hidden" id="mn_id" value="0">
                            <button type="submit" class="btn btn-sm nrSubmit">Submit</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-5 mt-1 mb-1">
                  <h4>List of Components </h4>
                  <p id="masterNameList"></p>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="astmp" role="tabpanel">
              <div class="row">
                <div class="col-md-6 mt-1 mb-1">
                  <div class="container card mt-2 myCard">
                    <h5 class="card-title"> Design Assessment Template </h5>
                    <form class="form-horizontal" id="atmpForm">
                      <div class="row mt-2">
                        <div class="col-md-3 pr-0">
                          <label> Template </label>
                          <p id="selectTemplate"></p>
                        </div>
                        <div class="col-md-2 pl-1 pr-0">
                          <div class="form-group">
                            <label> Weightage</label>
                            <input class="form-control form-control-sm" id="weightage" name="weightage" required>
                          </div>
                        </div>
                        <div class="col-md-5 pl-1 pr-0">
                          <div class="form-group">
                            <label> Assessment Component </label><br>
                            <input type="radio" id="cie" checked name="internal" value="1"> CIE(Internal)
                            <input type="radio" id="see" name="internal" value="0"> SEE(External)
                          </div>
                        </div>
                        <div class="col-md-2 pl-1">
                          <input type="hidden" id="actionTmp" name="action" value="addTemplate"><br>
                          <button type="submit" class="btn btn-sm atmp">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <p id="atmpList"></p>
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
    masterNameList();
    selectTemplate();
    atmpList();
    selectList("sch");
    batchSession(<?php echo $myBatch; ?>)

    function selectList(tag) {
      // $.alert("Select " + tag);
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

    // Update Master Data
    $(document).on('click', '.updateMasterData', function(event) {
      $.alert("Updating Master Data ");
      $.post("aaSql.php", {
        action: "updateMasterData",
      }, () => {}, "text").done(function(data, status) {
        $.alert(data);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('change', '#sel_resp', function(event) {
      var mn_id = $("#sel_resp").val();
      // $.alert(" Resp " + mn_id);
      $.post("aaSql.php", {
        mn_id: mn_id,
        action: "respList"
      }, function() {}, "text").done(function(data, status) {
        // respNameList();
        // selectList(mn_id);
        respList()
        //$.alert("List " + data);
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

    $(document).on('click', '.respSubmit', function(event) {
      var action = $(this).attr("data-tag");
      if (action == "hod") var mn_id = $("#sel_dept").val();
      else if (action == "dir") var mn_id = $("#sel_school").val();
      else if (action == "gd") var mn_id = $("#sel_inst").val();
      else var mn_id = $("#sel_resp").val();
      var staffId = $("#staffId").val();
      var respRemarks = $("#respRemarks").val();
      var respFrom = $("#respFrom").val();
      var respTo = $("#respTo").val();
      var respOrder = $("#respOrder").val();
      // $.alert(" Staff " + staffId + " action " + action);
      $.post("aaSql.php", {
        mn_id: mn_id,
        respFrom: respFrom,
        respTo: respTo,
        respOrder: respOrder,
        respRemarks: respRemarks,
        staffId: staffId,
        action: action
      }, "text").done(function(data) {
        // $.alert("List " + data);
        if (action == "respName") respList()
        else headList(mn_id, action)
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('change', '#sel_dept', function(event) {
      var unit_id = $("#sel_dept").val();
      // $.alert(" Resp " + unit_id);
      headList(unit_id, "hod")
    });

    $(document).on('change', '#sel_school', function(event) {
      var unit_id = $("#sel_school").val();
      // $.alert(" Schhol " + unit_id);
      headList(unit_id, "dir")
    });

    function headList(unit_id, head) {
      // $.alert(" Pressed" + mn_id);
      $.post("aaSql.php", {
        unit_id: unit_id,
        head: head,
        action: "headList"
      }, function() {}, "text").done(function(data, status) {
        $("#responsibilityList").html(data);
        //$.alert("Updated");
      }).fail(function() {
        $.alert("Error !!");
      })
    }

    $(document).on('click', '.headName', function(event) {
      var headName = $("input[name='headName']:checked").val();
      // $.alert(" Pressed" + headName);
      $.post("aaSql.php", {
        headName: headName,
        action: "masterList"
      }, function() {}, "text").done(function(data, status) {
        masterNameList();
        //$.alert("List " + data);
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.nrSubmit', function(event) {
      var headName = $("input[name='headName']:checked").val();
      var name = $("#name").val();
      var abbri = $("#abbri").val();
      var remarks = $("#remarks").val();
      var id = $("#mn_id").val();
      // $.alert(" Pressed" + headName + name + remarks + id);
      $.post("aaSql.php", {
        name: name,
        abbri: abbri,
        remarks: remarks,
        mn_id: id,
        headName: headName,
        action: "headName"
      }, function(data, status) {}, "text").done(function(data) {
        $.alert(data);
        $("#name").val("")
        $("#abbri").val("")
        $("#remarks").val("")
        $("#mn_id").val("0")
        masterNameList();
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.mn_idE', function() {
      var id = $(this).attr('data-id');
      // $.alert("Id " + id);
      $.post("aaSql.php", {
        action: "mnFetch",
        mn_id: id
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.batch);
        $("#name").val(data.mn_name)
        $("#abbri").val(data.mn_abbri)
        $("#remarks").val(data.mn_remarks)
        $("#mn_id").val(data.mn_id)
      }).fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.mnUpdate', function() {
      var id = $(this).attr('data-id');
      var tag = $(this).attr('data-tag');
      // $.alert("Process Id " + id);
      $.post("aaSql.php", {
        mn_id: id,
        tag: tag,
        action: "mnUpdate"
      }, function() {}, "text").done(function(data) {
        $.alert("Updated !");
        masterNameList();
      }).fail(function() {
        $.alert("fail in place of error");
      })

    });

    $(document).on('submit', '#atmpForm', function(event) {
      event.preventDefault(this);
      var formData = $(this).serialize();
      // $.alert(formData);
      $.post("aaSql.php", formData, () => {}, "text").done(function(data, status) {
        // $.alert("List Updtaed" + data);
        atmpList();
        selectTemplate();
      })
    });

    function atmpList() {
      //$.alert("In List Function" + grid);
      $.post("aaSql.php", {
        action: "atmpList"
      }, function() {}, "text").done(function(data, status) {
        //$.alert(data);
        $("#atmpList").html(data);
      }).fail(function() {
        $.alert("Error !!");
      })
    }

    function masterNameList() {
      var headName = $("input[name='headName']:checked").val();
      //$.alert("Master Name " + headName);

      $.post("aaSql.php", {
        headName: headName,
        action: "masterNameList"
      }, function() {}, "text").done(function(data, status) {
        $("#masterNameList").html(data);
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