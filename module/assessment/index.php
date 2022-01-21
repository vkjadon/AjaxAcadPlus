<?php
require('../requireSubModule.php');
require('../../phpFunction/teachingLoadFunction.php');
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
        <div class="col-2 p-0 m-0 pl-2 full-height">
          <h5 class="mt-3">Assessment</h5>
          <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active am" id="list-am-list" data-toggle="list" href="#list-am" role="tab" aria-controls="am"> Assessment Master (DAA)</a>
            <a class="list-group-item list-group-item-action ap" id="list-ap-list" data-toggle="list" href="#list-ap" role="tab" aria-controls="ap"> Assessment Plan </a>
            <a class="list-group-item list-group-item-action da" id="list-da-list" data-toggle="list" href="#list-da" role="tab" aria-controls="da"> Design Assessment (SF/TF) </a>
          </div>
        </div>
        <div class="col-10 leftLinkBody">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane show active" id="list-am" role="tabpanel">
              <div class="row">
                <div class="col-9 mt-1 mb-1">
                  <div class="container card mt-2 myCard">
                    <h5 class="card-title"> Design Assessment Template </h5>
                    <form class="form-horizontal" id="atmpForm">
                      <div class="row mt-2">
                        <div class="col-3">
                          <label> Template </label>
                          <p id="selectTemplate"></p>
                        </div>
                        <div class="col-3">
                          <div class="form-group">
                            <label>Component</label>
                            <?php
                            $sql = "select * from master_name where mn_code='ac' and mn_status='0' order by mn_name";
                            $result = $conn->query($sql);
                            echo '<select class="form-control form-control-sm" name="sel_ac">';
                            while ($rowCCE = $result->fetch_assoc()) {
                              echo '<option value="' . $rowCCE["mn_id"] . '">' . $rowCCE["mn_name"] . '</option>';
                            }
                            echo '</select>';
                            ?>
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="form-group">
                            <label>Technique</label>
                            <?php
                            $sql = "select * from master_name where mn_code='at' and mn_status='0' order by mn_name";
                            $result = $conn->query($sql);
                            echo '<select class="form-control form-control-sm" name="sel_at">';
                            while ($rowCCE = $result->fetch_assoc()) {
                              echo '<option value="' . $rowCCE["mn_id"] . '">' . $rowCCE["mn_name"] . '</option>';
                            }
                            echo '</select>';
                            ?>
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="form-group">
                            <label> Weightage</label>
                            <input class="form-control form-control-sm" id="weightage" name="weightage" required>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <input type="radio" id="internal" checked name="internal" value="internal"> Internal
                          <input type="radio" id="external" name="internal" value="external"> External
                        </div>

                        <div class="col">
                          <input type="hidden" id="action" name="action" value="addTemplate">
                          <button type="submit" class="btn btn-sm atmp">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="container card mt-2 myCard">
                    <h5 class="card-title"> Existing Assessment Template </h5>
                    <p id="atmpList"></p>
                  </div>
                </div>
                <div class="col-4 mt-1 mb-1" role="tabpanel">
                  <p id="tabList"></p>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="list-ap" role="tabpanel">
              <div class="row">
                <div class="col-6 mt-1 mb-1">
                  <div class="container card mt-2 myCard">
                    <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#pills_template" role="tab">Template</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link assessments" data-toggle="pill" href="#pills_assessments" role="tab">Assessments</a>
                      </li>
                    </ul>
                    <!-- content -->
                    <div class="tab-content" id="pills-tabContent p-3">
                      <div class="tab-pane fade show active" id="pills_template" role="tabpanel">
                        <table class="table table-bordered table-striped list-table-xs" id="subjectTemplate">
                          <tr>
                            <th>Template</th>
                            <th>Components</th>
                          </tr>
                        </table>
                      </div>
                      <div class="tab-pane fade" id="pills_assessments" role="tabpanel">
                        <label>Template-<span id="saTemplate"></span></label>
                        <table class="table table-bordered table-striped list-table-xs" id="assessmentComponentTable">
                          <tr>
                            <th>#</th>
                            <th>Components</th>
                            <th>Weightage (%)</th>
                            <th>Assessments</th>
                            <th>Consider</th>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="container card mt-2 myCard">
                    <table class="table table-bordered table-striped list-table-xs mt-3" id="myLoadTable">
                      <tr>
                        <th><i class="fa fa-pencil-alt"></i></th>
                        <th>#</th>
                        <th>Class</th>
                        <th>Grp</th>
                        <th>Code</th>
                        <th>Name</th>
                      </tr>
                    </table>
                  </div>
                </div>
                <div class="col-5 mt-1 mb-1">Assessment Summary
                </div>
              </div>
            </div>
            <div class="tab-pane" id="list-da" role="tabpanel">
              <div class="row">
                <div class="col-7 mt-1 mb-1">
                  <div class="container card mt-2 myCard">
                    <h5 class="card-title p-2 mb-0"> Co-Curricular Activity Form</h5>

                  </div>
                </div>
                <div class="col-5 mt-1 mb-1" role="tabpanel">
                  <p id="tabList"></p>
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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  $(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip();
    $(".topBarTitle").text("Academics");
    $("#rpAction").val("addRP")
    selectTemplate();
    atmpList();
    myLoadList();

    $(document).on("click", ".assessments", function() {
      // $.alert("Assessement ");
      assessmentComponentList();
    });

    $(document).on("click", ".increDecre", function() {
      var id = $(this).attr('data-id');
      var value = $(this).attr("data-value");
      var tag = $(this).attr("data-tag");
      // $.alert("Id " + id + " Value " + value + " Tag " + tag);
      $.post("assessmentSql.php", {
        id: id,
        value: value,
        tag: tag,
        action: "updateAssessmentNumber"
      }, function() {}, "text").done(function(data, status) {
        // $.alert(data);
        assessmentComponentList();

      })
    });

    function assessmentComponentList() {
      // $.alert('hello');
      $.post("assessmentSql.php", {
        action: "fetchAssessmentComponent",
      }, () => {}, "json").done(function(data, status) {
        var card = '';
        var count = 1;
        // $.alert(data);
        $.each(data, function(key, value) {
          var assessments = value.sbas_assessments;
          var plusValue = parseInt(assessments) + 1;
          var minusValue = parseInt(assessments) - 1;
          if (minusValue == 0) minusValue = 1;
          card += '<tr>';
          card += '<td class="text-center">' + count++ + '</td>';
          card += '<td>' + value.mn_name + '</td>';
          card += '<td class="text-center">' + value.atmp_weightage + '</td>';
          card += '<td>';
          card += '<a href="#" class="increDecre" data-id="' + value.atmp_id + '" data-value="' + minusValue + '" data-tag="assessment"><i class="fa fa-angle-double-left"></i></a>';
          card += '<span>' + assessments + '</span>';
          card += '<a href="#" class="increDecre" data-id="' + value.atmp_id + '" data-value="' + plusValue + '"  data-tag="assessment"><i class="fa fa-angle-double-right"></i></a>';
          card += '</td>';
          var consider = value.sbas_consider;
          var plusValue = parseInt(consider) + 1;
          var minusValue = parseInt(consider) - 1;
          if (minusValue == 0) minusValue = 1;

          card += '<td>';
          card += '<a href="#" class="increDecre" data-id="' + value.atmp_id + '" data-value="' + minusValue + '" data-tag="consider"><i class="fa fa-angle-double-left"></i></a>';
          card += '<span>' + consider + '</span>';
          card += '<a href="#" class="increDecre" data-id="' + value.atmp_id + '" data-value="' + plusValue + '" data-tag="consider"><i class="fa fa-angle-double-right"></i></a>';
          card += '</td>';
          card += '</tr>';
        });
        $("#assessmentComponentTable").find("tr:gt(0)").remove()
        $("#assessmentComponentTable").append(card);
      }).fail(function() {
        $.alert("Test is Not Responding");
      })
    }

    $(document).on("click", ".radioAtmp", function() {
      var id = $(this).attr("data-id")
      // $.alert("Radio Atmp " + id);

      $.confirm({
        title: 'Confirm!',
        draggable: true,
        content: "Changing Template Remove All the Data Related with Previous Template !!<br> Think before you Proceed!! ",
        buttons: {
          confirm: {
            btnClass: 'btn-blue',
            action: function() {
              $.post("assessmentSql.php", {
                id: id,
                action: "setSubjectTemplate"
              }, function() {}, "text").done(function(data, status) {
                //$.alert(data);
              })
            }
          },
          cancel: {
            btnClass: "btn-danger",
            action: function() {}
          },
        }
      });
    });

    $(document).on("click", ".editTL", function() {
      var id = $(this).attr("data-id")
      // $().removeClass();
      $(".editTL").removeClass('fa-circle')
      $(".editTL").addClass('fa-pencil-alt')

      $(this).removeClass('fa-pencil-alt');
      $(this).addClass('fa-circle')
      // $.alert("Edit - Fetch " + id);

      $.post("assessmentSql.php", {
        id: id,
        action: "fetchSubjectTemplate"
      }, function() {}, "json").done(function(data, status) {
        // $.alert(data);
        var card = '';
        var count = 1;
        // $.alert(data.check);
        $.each(data, function(key, value) {
          var check = value.check;
          card += '<tr>';
          if (check == '1') card += '<td><input type="radio" class="radioAtmp" checked data-id="' + value.atmp_template + '" name="radioAtmp">';
          else card += '<td><input type="radio" class="radioAtmp" data-id="' + value.atmp_template + '" name="radioAtmp">';
          card += ' Template-' + value.atmp_template;
          card += '</td>';
          card += '<td>' + value.text + '</td>';
          card += '</tr>';
        });
        $("#subjectTemplate").find("tr:gt(0)").remove()
        $("#subjectTemplate").append(card);
        assessmentComponentList();
      })
    })

    function myLoadList() {
      // $.alert('hello');
      $.post("assessmentSql.php", {
        action: "myLoadList",
      }, () => {}, "json").done(function(data, status) {
        var card = '';
        var count = 1;
        // $.alert(data);
        $.each(data, function(key, value) {
          card += '<tr>';
          card += '<td><a href="#" class="editTL fa fa-pencil-alt" data-id="' + value.tl_id + '"></td>';
          card += '<td>' + count++ + '</td>';
          // card += '<td>' + value.tl_id + '</td>';
          card += '<td>' + value.class_name + '[' + value.class_section + ']</td>';
          card += '<td>' + value.load_type + 'G-' + value.tl_group + '</td>';
          card += '<td>' + value.subject_code + '</td>';
          card += '<td>' + value.subject_name + '</td>';
          card += '</tr>';
        });
        $("#myLoadTable").find("tr:gt(0)").remove()
        $("#myLoadTable").append(card);
      }).fail(function() {
        $.alert("Test is Not Responding");
      })
    }

    // Template Block

    $(document).on('submit', '#atmpForm', function(event) {
      event.preventDefault(this);
      var formData = $(this).serialize();
      //$.alert(formData);
      $.post("assessmentSql.php", formData, () => {}, "text").done(function(data, status) {
        //$.alert("List Updtaed" + data);
        atmpList();
        selectTemplate();
      })
    });

    function atmpList() {
      //$.alert("In List Function" + grid);
      $.post("assessmentSql.php", {
        action: "atmpList"
      }, function() {}, "text").done(function(data, status) {
        //$.alert(data);
        $("#atmpList").html(data);
      }).fail(function() {
        $.alert("Error !!");
      })
    }

    function selectTemplate() {
      //$.alert("In List Function");
      $.post("assessmentSql.php", {
        action: "selectTemplate"
      }, function() {}, "text").done(function(data, status) {
        //$.alert(data);
        $("#selectTemplate").html(data);
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