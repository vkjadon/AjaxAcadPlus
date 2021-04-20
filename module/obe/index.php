<?php
session_start();
require("../../config_database.php");
require('../../config_variable.php');
require('../../php_function.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Outcome Based Education : ClassConnect</title>
  <?php require("../css.php"); ?>

</head>

<body>
  <?php require("../topBar.php"); ?>
  <div class="container-fluid moduleBody">
    <div class="row">
      <div class="col-2">
        <div class="list-group list-group-mine" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active as" id="list-as-list" data-toggle="list" href="#list-as" role="tab" aria-controls="as"> Assessment Strategy </a>
          <a class="list-group-item list-group-item-action coa" id="list-coa-list" data-toggle="list" href="#list-coa" role="tab" aria-controls="coa"> CO Attainment </a>
          <a class="list-group-item list-group-item-action poa" id="list-poa-list" data-toggle="list" href="#list-poa" role="tab" aria-controls="poa"> PO Attainment </a>
        </div>
      </div>
      <div class="col-10">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="list-as" role="tabpanel" aria-labelledby="list-as-list">
            <div class="col">
              <!-- Nav tabs -->
              <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link tabLink active" id="assessmentMethodPanel" data-toggle="tab" href="#showMethodPanel">Assessment Method </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link tabLink" data-toggle="tab" href="#showATPanel">Assessment Technique</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link tabLink poScale" data-toggle="tab" href="#showScalePanel">PO Scale</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link pof" data-toggle="tab" href="#showPOFPanel">PO Feedback</a>
                </li>
              </ul>
              <!-- Tab panes -->
              <div class="tab-content">
                <div class="tab-pane container show active p-0 m-0" id="showMethodPanel">
                  <button class="btn btn-info btn-square-sm mt-1 addMethod">Add New</button>
                  <div class="col p-0 m-0">
                    <p id="assessmentMethodShowList"></p>
                  </div>
                </div>
                <div class="tab-pane fade" id="showATPanel">
                  <button class="btn btn-info btn-square-sm mt-1 addAT">Add New</button>
                  <div class="col p-0 m-0">
                    <div id="assessmentTechniqueShowList"></div>
                  </div>
                </div>
                <div class="tab-pane fade" id="showScalePanel">
                  <button class="btn btn-info btn-square-sm mt-1" id="poScaleButton">Show PO Scale</button>
                  <div class="p-0 m-0" id="poShowScale"></div>
                </div>
                <div class="tab-pane fade" id="showPOFPanel">
                  <button class="btn btn-info btn-square-sm mt-1 addPOF">Add PO Feedback</button>
                  <div class="col p-0 m-0">
                    <p id="pofShowList"></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-coa" role="tabpanel" aria-labelledby="list-coa-list">
            <div class="col">
              <!-- Nav tabs -->
              <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active" id="assessmentDesignPanel" data-toggle="tab" href="#showDesignPanel">Design Assessment</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#showAUCOMap">AU-CO Map</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link coa" data-toggle="tab" href="#showUploadPanel">CO Assessment</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#showCOScalePanel">CO Scale</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#showCOAPanel">CO Attainment</a>
                </li>
              </ul>
              <!-- Tab panes -->
              <div class="tab-content">
                <div class="tab-pane active" id="showDesignPanel">
                  <button class="btn btn-info btn-square-sm mt-1 addDesign">Design CO Assessment</button>
                  <div class="col p-0 m-0">
                    <div id="assessmentDesignShowList"></div>
                  </div>
                </div>
                <div class="tab-pane container fade" id="showAUCOMap">
                  <br>
                  <div class="row">
                    <div class="col-3">
                      <h5>AU-CO Mapping</h5>
                    </div>
                    <div class="col-3">
                      <div class="form-group">
                        <?php
                        $sql = "select ad.*, sb.subject_code from assessment_design ad, subject sb where sb.subject_id=ad.subject_id and ad.submit_id='$myId' and sb.subject_status='0' and ad.ad_status='0'";
                        selectList($conn, 'Select Assessment', array('0', 'ad_id', 'ad_name', 'subject_code', 'sel_ad'), $sql);
                        ?>
                      </div>
                    </div>
                  </div>
                  <p id="aucoShowMap"></p>

                </div>
                <div class="tab-pane container fade" id="showUploadPanel">
                  <br>
                  <div class="row">
                    <div class="col-3">
                      <h5>Upload Assessment</h5>
                    </div>
                    <div class="col-3">
                      <div class="form-group">
                        <?php
                        $sql = "select ad.*, sb.subject_code from assessment_design ad, subject sb where sb.subject_id=ad.subject_id and sb.program_id='$myProg' and sb.batch_id='$myBatch' and sb.subject_status='0' and ad.ad_status='0'";
                        selectList($conn, 'Select Assessment', array('0', 'ad_id', 'ad_name', 'subject_code', 'sel_adUA'), $sql);
                        ?>
                      </div>
                    </div>
                  </div>
                  <p id="uaShowTable"></p>
                </div>
                <div class="tab-pane container fade" id="showCOScalePanel">
                  <br>
                  <div class="row">
                    <div class="col-3">
                      <h5>CO Attainment Scale</h5>
                    </div>
                  </div>
                  <p id="coShowScale"></p>
                </div>
                <div class="tab-pane container fade" id="showCOAPanel">
                  <br>
                  <div class="row">
                    <div class="col-12 text-center">
                      <h5>CO Attainment</h5>
                    </div>
                  </div>
                  <p id="coMMTable">Please Select Subject to Show Attainment</p>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-poa" role="tabpanel" aria-labelledby="list-poa-list">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#showCOPOPanel">CO-PO Map</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active poMap" data-toggle="tab" href="#showPOMapPanel">POA Direct</a>
              </li>
              <li class="nav-item">
                <a class="nav-link poAssess" data-toggle="tab" href="#showPOAssessmentPanel">PO Assessment</a>
              </li>
              <li class="nav-item">
                <a class="nav-link poAttainment" data-toggle="tab" href="#showPOAttainmentPanel">PO Attainment</a>
              </li>

            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
              <div class="tab-pane container" id="showCOPOPanel">
                <br>
                <h5>CO-PO Mapping</h5>
                <p id="copoShowMap">Select Subject from Select Panel</p>
              </div>
              <div class="tab-pane container show active fade" id="showPOMapPanel">
                <div class="row">
                  <div class="col-3">
                    <div class="form-group">
                      <button class="btn btn-primary btn-sm" id="poMapButton">Show PO Map</button>
                    </div>
                  </div>
                </div>
                <div id="poShowMap"></div>
              </div>
              <div class="tab-pane container fade" id="showPOAssessmentPanel">
                <button class="btn btn-primary btn-sm" id="pofButton">Show POF Assessment</button>
                <div class="pofShowTable" id="pofShowTable"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

<?php require("../js.php"); ?>


<script>
  $(document).ready(function() {

    $('[data-toggle="popover"]').popover();
    $('[data-toggle="tooltip"]').tooltip();
    assessmentMethodList();
    assessmentTechniqueList();
    assessmentDesignList();
    $(".topBarTitle").text("OBE");
    $(document).on('change', '#sel_subject', function() {
      //$.alert("Subject Changed ");
      copoMap();
      coScale();
      coMMTable();
    });

    $(document).on('click', '.as', function() {
      assessmentMethodList();
    });

    $(document).on('click', '.poAssess', function() {
      var x = $("#sel_program").val();
      var y = $("#sel_batch").val();
      if (x === "" || y === "") $.alert("Please select Program and Batch from Select Panel to Show List");
      else pofSelect(x, y);
    });

    $(document).on('click', '.pof', function() {
      var x = $("#sel_program").val();
      var y = $("#sel_batch").val();
      if (x === "" || y === "") $.alert("Please select Program and Batch from Select Panel to Show List");
      else pofList();
    });

    $(document).on('click', '.poScaleCopy', function() {
      var x = $("#sel_program").val();
      var y = $("#sel_batch").val();
      if (x === "" || y === "") $.alert("Please select Program and Batch from Select Panel");
      else {
        var poId = $(this).attr('data-po');
        alert(" poId " + poId);
        $.post("obeSql.php", {
          action: "psCopy",
          programId: x,
          batchId: y,
          poId: poId
        }, function(mydata, mystatus) {
          alert("- Updated -" + mydata);
          poScale(x, y);
        }, "text").fail(function() {
          $.alert("Error !!");
        })

      }
    });

    $(document).on('click', '#poScaleButton', function() {
      var x = $("#sel_program").val();
      var y = $("#sel_batch").val();
      if (x === "" || y === "") $.alert("Please select Program and Batch from Select Panel");
      else poScale(x, y);
    });

    $(document).on('click', '.auMarks', function() {
      var adId = $("#sel_ad").val();
      var auSno = $(this).attr('data-sno');
      var cellScale = $(this).closest("td");
      var cellValue = cellScale.text();
      $.alert(" Text of the Clicked Cell " + cellValue + " auSno " + auSno);
      $('#modal_title').text("Add AU Marks");
      $('#action').val("addAUMarks");
      $('#ad_idM').val(adId);
      $('#au_snoM').val(auSno);
      $('#au_marks').val(cellValue);
      $('#firstModal').modal('show');
      $('.assessmentMethodForm').hide();
      $('.assessmentTechniqueForm').hide();
      $('.assessmentDesignForm').hide();
      $('.aucoForm').hide();
      $('.auMarksForm').show();
      $('.POFForm').hide();
    });

    $(document).on('click', '.aucoMap', function() {
      var adId = $("#sel_ad").val();
      var auSno = $(this).attr('data-au');
      var coId = $(this).attr('data-co');
      var cellScale = $(this).closest("td");
      var cellValue = cellScale.text();
      //$.alert(" Text of the Clicked Cell " + cellValue + " auSno " + auSno + "coId " + coId);
      $('#modal_title').text("AU-CO Map Value");
      $('#action').val("addAUCO");
      $('#ad_idM').val(adId);
      $('#co_idM').val(coId);
      $('#au_snoM').val(auSno);
      $('#auco_weight').val(cellValue);
      $('#firstModal').modal('show');
      $('.assessmentMethodForm').hide();
      $('.assessmentTechniqueForm').hide();
      $('.assessmentDesignForm').hide();
      $('.aucoForm').show();
      $('.auMarksForm').hide();
      $('.POFForm').hide();

    });

    $(document).on('click', '.ad_idE', function() {
      var id = $(this).attr('id');
      //$.alert("Id " + id);
      $.post("obeSql.php", {
        adId: id,
        action: "fetchAD"
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.am_name);
        console.log(data);
        $('#modal_title').text("Update Assessment Design [" + id + "]");
        $('#ad_name').val(data.ad_name);
        $('#ad_mm').val(data.ad_mm);
        $('#ad_pm').val(data.ad_pm);
        $('#ad_weight').val(data.ad_weight);
        $('#ad_question').val(data.ad_question);

        $('#action').val("updateAD");
        $('#modalId').val(id);

        var atId = data.at_id;
        $("#sel_at option[value='" + atId + "']").attr("selected", "selected");
        var subId = data.subject_id;
        $("#sel_subjectAD option[value='" + subId + "']").attr("selected", "selected");

        $('.assessmentMethodForm').hide();
        $('.assessmentTechniqueForm').hide();
        $('.assessmentDesignForm').show();
        $('.aucoForm').hide();
        $('.auMarksForm').hide();
        $('.POFForm').hide();
        $('#firstModal').modal('show');

      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.addDesign', function() {
      //$.alert("Assessment Design");
      $('#modal_title').text("Assessment Design");
      $('#action').val("addAD");
      $('#firstModal').modal('show');
      $('.assessmentMethodForm').hide();
      $('.assessmentTechniqueForm').hide();
      $('.assessmentDesignForm').show();
      $('.aucoForm').hide();
      $('.auMarksForm').hide();
      $('.POFForm').hide();
    });

    $(document).on('click', '.at_idE', function() {
      var id = $(this).attr('id');
      $.alert("Id " + id);
      $.post("obeSql.php", {
        atId: id,
        action: "fetchAT"
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.am_name);
        console.log(data);
        $('#modal_title').text("Update Assessment Technique [" + id + "]");
        $('#at_name').val(data.at_name);

        $('#action').val("updateAT");
        $('#modalId').val(id);

        var atType = data.at_type;
        if (atType == 'Fixed') {
          document.getElementById("atFixed").checked = true;
        } else if (atType == 'Flexible') {
          document.getElementById("atFlexible").checked = true;
        }

        var atOut = data.at_outcome;
        if (atOut == 'CO') {
          document.getElementById("atCO").checked = true;
        } else if (atOut == 'PO') {
          document.getElementById("atPO").checked = true;
        }

        var amId = data.am_id;
        //$.alert("amId " + amId);
        $("#sel_am option[value='" + amId + "']").attr("selected", "selected");

        $('.assessmentMethodForm').hide();
        $('.assessmentDesignForm').hide();
        $('.assessmentTechniqueForm').show();
        $('.aucoForm').hide();
        $('.auMarksForm').hide();
        $('.POFForm').hide();
        $('#firstModal').modal('show');

      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.addAT', function() {
      $.alert("Add Assessment Technique");
      $('#modal_title').text("Add Assessment Technique");
      $('#action').val("addAT");
      $('#firstModal').modal('show');
      $('.assessmentMethodForm').hide();
      $('.assessmentTechniqueForm').show();
      $('.assessmentDesignForm').hide();
      $('.aucoForm').hide();
      $('.auMarksForm').hide();
      $('.POFForm').hide();

    });

    $(document).on('click', '.pf_idE', function() {
      var id = $(this).attr('id');
      var programId = $("#sel_program").val();
      var batchId = $("#sel_batch").val();
      $.alert("Id " + id);
      $.post("obeSql.php", {
        pfId: id,
        programId: programId,
        batchId: batchId,
        action: "fetchPOF"
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.am_name);
        console.log(data);
        $('#modal_title').text("Update PO Feedback [" + id + "]");
        $('#pf_name').val(data.pf_name);
        $('#pf_mm').val(data.pf_mm);
        $('#pf_weight').val(data.pf_weight);
        $('#pf_question').val(data.pf_question);

        $('#action').val("updatePOF");
        $('#modalId').val(id);

        $('.assessmentMethodForm').hide();
        $('.assessmentTechniqueForm').hide();
        $('.assessmentDesignForm').hide();
        $('.aucoForm').hide();
        $('.auMarksForm').hide();
        $('.POFForm').show();
        $('#firstModal').modal('show');

      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('click', '.addPOF', function() {
      //$.alert("Add PO Feedback");
      var x = $("#sel_program").val();
      var y = $("#sel_batch").val();
      if (x === "" || y === "") $.alert("Please select Program and Batch from Select Panel");
      else {
        $('#modal_title').text("PO Feedback");
        $('#action').val("addPOF");
        $('#modalProgram').val(x);
        $('#modalBatch').val(y);
        $('#firstModal').modal('show');
        $('.assessmentMethodForm').hide();
        $('.assessmentTechniqueForm').hide();
        $('.assessmentDesignForm').hide();
        $('.aucoForm').hide();
        $('.auMarksForm').hide();
        $('.POFForm').show();
      }
    });

    $(document).on('click', '.am_idE', function() {
      var id = $(this).attr('id');
      $.alert("Id " + id);
      $.post("obeSql.php", {
        amId: id,
        action: "fetchAM"
      }, () => {}, "json").done(function(data) {
        //$.alert("List " + data.am_name);
        console.log(data);
        $('#modal_title').text("Update Assessment Method [" + id + "]");
        $('#am_nameM').val(data.am_name);
        $('#am_weight').val(data.am_weight);
        $('#am_weight_po').val(data.am_weight_po);

        $('#action').val("updateAM");
        $('#modalId').val(id);

        var amType = data.am_type;
        if (amType == 'Fixed') {
          document.getElementById("amFixed").checked = true;
        } else if (amType == 'Flexible') {
          document.getElementById("amFlexible").checked = true;
        }

        var amCode = data.am_code;
        if (amCode == 'Direct') {
          document.getElementById("amDirect").checked = true;
        } else if (amCode == 'Indirect') {
          document.getElementById("amIndirect").checked = true;
        }

        $('.assessmentMethodForm').show();
        $('.assessmentTechniqueForm').hide();
        $('.assessmentDesignForm').hide();
        $('.aucoForm').hide();
        $('.auMarksForm').hide();
        $('.POFForm').hide();

        $('#firstModal').modal('show');
      }, "text").fail(function() {
        $.alert("fail in place of error");
      })
    });

    $(document).on('submit', '#modalForm', function(event) {
      event.preventDefault(this);
      var action = $("#action").val();
      //$.alert("Form Submitted " + action);
      var error = "NO";
      var error_msg = "";
      if (action == "addAssessmentMethod" || action == "updateAM") {
        if ($('#am_nameM').val() === "") {
          error = "YES";
          error_msg = "Method name cannot be blank";
        }
      } else if (action == "addAT" || action == "updateAT") {
        if ($('#at_name').val() === "") {
          error = "YES";
          error_msg = "Technique Name cannot be blank";
        }
      } else if (action == "addPOF" || action == "updatePOF") {
        if ($('#pof_name').val() === "") {
          error = "YES";
          error_msg = "PO Feedback Name cannot be blank";
        }
      } else if (action == "addAD" || action == "updateAD") {
        if ($("#ad_name").val() === "" || $("#sel_subjectAD").val() === "" || $("#sel_at").val() === "") {
          error = "YES";
          error_msg = "Design Name/Subject/Technique cannot be blank";
        }
      } else if (action == "addAUCO" && $("#auco_weight").val() === "") {
        error = "YES";
        error_msg = "Value Cannot be blank";
      } else if (action == "addAUMarks" && $("#au_marks").val() === "") {
        error = "YES";
        error_msg = "AU/Q Marks Cannot be blank";
      }
      if (error == "NO") {
        var formData = $(this).serialize();
        //$.alert(formData);
        $.post("obeSql.php", formData, () => {}, "text").done(function(data) {
          //$.alert(data);
          if (action == "addAssessmentMethod" || action == "updateAM") assessmentMethodList();
          else if (action == "addAT" || action == "updateAT") assessmentTechniqueList();
          else if (action == "addAD" || action == "updateAD") assessmentDesignList();
          else if (action == "addAUCO" || action == "addAUMarks") aucoMap();
          else if (action == "addPOF" || action == "updatePOF") pofList();
          $('#firstModal').modal('hide');
          $('#modalForm')[0].reset();
        }, "text").done(function(mydata, mystatus) {
          //$.alert("Data" + mydata);
        }).fail(function() {
          $.alert("fail in place of error");
        })
      } else {
        $.alert(error_msg);
      }
    });

    $(document).on('click', '.addMethod', function() {
      $.alert("Add Assessment Method");
      $('#modal_title').text("Add Assessment Method");
      $('#action').val("addAssessmentMethod");
      $('#firstModal').modal('show');
      $('.assessmentMethodForm').show();
      $('.assessmentTechniqueForm').hide();
      $('.assessmentDesignForm').hide();
      $('.aucoForm').hide();
      $('.auMarksForm').hide();
      $('.POFForm').hide();
    });

    $(document).on('mouseover', '.co', function() {
      var id = $(this).attr('id');
      $("#" + id).css("background-color", "yellow");
    });

    $(document).on('mouseout', '.co', function() {
      var id = $(this).attr('id');
      $("#" + id).css("background-color", "white");
    });

    $(document).on('blur', '.coScale', function() {
      var csScale = $(this).attr('data-coScale');
      var coId = $(this).attr('data-co');
      var tag = $(this).attr('data-tag');
      var value = $(this).val();
      //Confirm Alert Plugin shows Alert Box twice
      //alert(" csScale " + csScale + " Co " + coId + "Entered Value " + value + "Tag" + tag);
      $.post("obeSql.php", {
        action: "csScale",
        coId: coId,
        tag: tag,
        csScale: csScale,
        csValue: value
      }, function(mydata, mystatus) {
        //alert("- Updated -" + mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });

    $(document).on('blur', '.poScale', function() {
      var psScale = $(this).attr('data-poScale');
      var poId = $(this).attr('data-po');
      var tag = $(this).attr('data-tag');
      var value = $(this).val();
      //Confirm Alert Plugin shows Alert Box twice
      //alert(" psScale " + psScale + " Po " + poId + "Entered Value " + value + "Tag" + tag);
      $.post("obeSql.php", {
        action: "psScale",
        poId: poId,
        tag: tag,
        psScale: psScale,
        psValue: value
      }, function(mydata, mystatus) {
        //alert("- Updated -" + mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });

    $(document).on('blur', '.uaTable', function() {
      var adId = $("#sel_adUA").val();
      var uaSno = $(this).attr('data-ua');
      var stdId = $(this).attr('data-std');
      var value = $(this).val();
      //Confirm Alert Plugin shows Alert Box twice
      //alert(" Ad " + adId + " uaSno " + uaSno + "Student" + stdId + "Entered Value " + value);
      $.post("obeSql.php", {
        action: "uaMarks",
        studentId: stdId,
        adId: adId,
        uaSno: uaSno,
        uaMarks: value
      }, function(mydata, mystatus) {
        //alert("- Updated -" + mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });

    $(document).on('click', '#poMapButton', function() {
      var batchId = $("#sel_batch").val();
      var programId = $("#sel_program").val();
      if (batchId === "" || programId === "") $.alert("Please select Batch and Program to Proceed");
      else poMap(programId, batchId);
    });

    $(document).on('click', '.copoMap', function() {
      var id = $(this).attr('id');
      var coId = $(this).attr('data-co');
      var poId = $(this).attr('data-po');
      var cellScale = $(this).closest("td");
      //$.alert(" Cell Clicked " + id + " Text of the Clicked Cell " + cellScale.text()+ "coId " + coId + "poId " + poId);
      if (cellScale.text() == "--") {
        x = "H";
        $("#" + id).html('<a href="#" style="display:block;  width:100%; text-decoration: none;">H</a>');
      } else if (cellScale.text() == "H") {
        x = "M";
        $("#" + id).html('<a href="#" style="display:block;  width:100%; text-decoration: none;">M</a>');
      } else if (cellScale.text() == "M") {
        x = "L";
        $("#" + id).html('<a href="#" style="display:block;  width:100%; text-decoration: none;">L</a>');
      } else if (cellScale.text() == "L") {
        x = "--";
        $("#" + id).html('<a href="#" style="display:block;  width:100%; text-decoration: none;">--</a>');
      }
      $.post("obeMapSql.php", {
        actionMap: "copoScale",
        scale: x,
        coId: coId,
        poId: poId
      }, function(mydata, mystatus) {
        //$.alert("Updated" + mydata + mystatus.success);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });

    $(document).on('change', '#sel_ad', function() {
      //$.alert("Assessment Changed ");
      aucoMap();
    });

    $(document).on('change', '#sel_adUA', function() {
      //$.alert("Assessment Changed ");
      uaTable();
    });

    $(document).on('blur', '.pfTable', function() {
      var pfId = $("#sel_pf").val();
      var poId = $(this).attr('data-pf');
      var stdId = $(this).attr('data-std');
      var value = $(this).val();
      //Confirm Alert Plugin shows Alert Box twice
      //alert(" Ad " + pfId + " uaSno " + poId + "Student" + stdId + "Entered Value " + value);
      $.post("obeSql.php", {
        action: "pfMarks",
        studentId: stdId,
        pfId: pfId,
        poId: poId,
        pfMarks: value
      }, function(mydata, mystatus) {
        //alert("- Updated -" + mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });

    $(document).on('click', '#pofButton', function() {
      //$.alert("POF Button Pressed ");
      $("#pofShowTable").hide();
      var x = $("#sel_pf").val();
      if (x === "") $.alert("Please Select the PO Feedback");
      else pofTable();
    });

    function poScale(x, y) {
      $.alert("Progran and Batch Id in PO Scale " + x + " and " + y);
      $.post("obeMapSql.php", {
        actionMap: "poScale",
        programId: x,
        batchId: y
      }, function(mydata, mystatus) {
        $("#poShowScale").show();
        //$.alert("List " + mydata);
        $("#poShowScale").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function coMMTable() {
      var x = $("#sel_subject").val();
      //$.alert("Subject Id in CO MM " + x);
      $.post("obeMapSql.php", {
        actionMap: "coMM",
        subjectId: x
      }, function(mydata, mystatus) {
        $("#coMMTable").show();
        //$.alert("List " + mydata);
        $("#coMMTable").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function coScale() {
      var x = $("#sel_subject").val();
      //$.alert("Subject Id in CO Scale " + x);
      $.post("obeMapSql.php", {
        actionMap: "coScale",
        subjectId: x
      }, function(mydata, mystatus) {
        $("#coShowScale").show();
        //$.alert("List " + mydata);
        $("#coShowScale").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function uaTable() {
      var x = $("#sel_adUA").val();
      //$.alert("Assessment Id in Upload Assessment" + x);
      $.post("obeMapSql.php", {
        actionMap: "uaTable",
        adId: x
      }, function(mydata, mystatus) {
        $("#uaShowTable").show();
        //$.alert("List " + mydata);
        $("#uaShowTable").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function assessmentMethodList() {
      //$.alert("Assessment List Function");
      $.post("obeSql.php", {
        action: "assessmentMethodList"
      }, function(mydata, mystatus) {
        $("#assessmentMethodShowList").hide();
        //$.alert("List " + mydata);
        $("#assessmentMethodShowList").html(mydata);
        $("#assessmentMethodShowList").show();
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function assessmentTechniqueList() {
      //$.alert("AT List Function");
      $.post("obeSql.php", {
        action: "assessmentTechniqueList"
      }, function(mydata, mystatus) {
        $("#assessmentTechniqueShowList").show();
        //$.alert("List " + mydata);
        $("#assessmentTechniqueShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function assessmentDesignList() {
      //$.alert("AD List Function");
      $.post("obeSql.php", {
        action: "assessmentDesignList"
      }, function(mydata, mystatus) {
        $("#assessmentDesignShowList").show();
        //$.alert("List " + mydata);
        $("#assessmentDesignShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function pofList() {
      //$.alert("POF List Function");
      $.post("obeSql.php", {
        action: "pofList"
      }, function(mydata, mystatus) {
        $("#pofShowList").show();
        //$.alert("List " + mydata);
        $("#pofShowList").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function pofSelect(x, y) {
      //$.alert("POF List Function");
      $.post("obeSql.php", {
        action: "pofSelect",
        programId: x,
        batchId: y
      }, function(mydata, mystatus) {
        $("#pofSelect").show();
        //$.alert("List " + mydata);
        $("#pofSelect").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function pofTable() {
      var x = $("#sel_pf").val();
      if (x === "") $.alert("Please Select the PO Feedback");
      else {
        $.post("obeMapSql.php", {
          actionMap: "pofTable",
          programId: $("#sel_program").val(),
          batchId: $("#sel_batch").val(),
          pfId: x
        }, function(mydata, mystatus) {
          $("#pofShowTable").show();
          //$.alert("List " + mydata);
          $("#pofShowTable").html(mydata);
        }, "text").fail(function() {
          $.alert("Error !!");
        })
      }
    }

    function poMap(x, y) {
      //$.alert("poMap Function");
      $.post("obeMapSql.php", {
        actionMap: "poMap",
        programId: x,
        batchId: y
      }, function(mydata, mystatus) {
        $("#poShowMap").show();
        //$.alert("List " + mydata);
        $("#poShowMap").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function aucoMap() {
      var x = $("#sel_ad").val();
      //$.alert("Assessment Id " + x);
      $.post("obeMapSql.php", {
        actionMap: "aucoMap",
        adId: x
      }, function(mydata, mystatus) {
        $("#aucoShowMap").show();
        //$.alert("List " + mydata);
        $("#aucoShowMap").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function copoMap() {
      var x = $("#sel_subject").val();
      //$.alert("Subject C" + x);
      $.post("obeMapSql.php", {
        actionMap: "copoMap",
        subjectId: x
      }, function(mydata, mystatus) {
        $("#copoShowMap").show();
        //$.alert("List " + mydata);
        $("#copoShowMap").html(mydata);
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
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" id="modalForm">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title" id="modal_title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->

        <!-- Modal body -->
        <div class="modal-body">
          <div class="assessmentMethodForm">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  Assessment Method Name
                  <input type="text" class="form-control form-control-sm" id="am_nameM" name="am_name" placeholder="Name of Assessment Method">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  CO Weight (%)
                  <input type="number" class="form-control form-control-sm" id="am_weight" name="am_weight" placeholder="CO Weight in %">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  PO Weight (%)
                  <input type="number" class="form-control form-control-sm" id="am_weight_po" name="am_weight_po" placeholder="PO Weight in %">
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col">
                <div class="form-check-inline"> Method Type </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" checked id="amDirect" name="am_code" value="Direct">Direct
                </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" id="amIndirect" name="am_code" value="Indirect">Indirect
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col">
                <div class="form-check-inline"> Weightage Type </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" checked id="amFixed" name="am_type" value="Fixed">Fixed
                </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" id="amFlexible" name="am_type" value="Flexible">Flexible
                </div>
              </div>
            </div>
            <hr>
            <div class="form-group">
              <i>Assessment Method is generally Direct Method and Indirect Method. The weightage can be adjusted. The weightage provided here is the default Weightage. If Weight Type is fixed Faculty cannot Change the weightage and if it is flexible, faculty can adjust it.</i>
            </div>
          </div>
          <div class="assessmentTechniqueForm">
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Technique Name
                  <input type="text" class="form-control form-control-sm" id="at_name" name="at_name" placeholder="Name of Assessment Technique">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  Method
                  <?php
                  $sql = "select * from assessment_method where am_status='0'";
                  $data = array("0", "am_id", "am_name", "", "sel_am");
                  selectList($conn, "Select Method", $data, $sql);
                  ?>
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col">
                <div class="form-check-inline"> Outcome </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" checked id="atCO" name="at_outcome" value="CO">CO
                </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" id="atPO" name="at_outcome" value="PO">PO
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col">
                <div class="form-check-inline"> Assessment Technique Type </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" checked id="atFixed" name="at_type" value="Fixed">Fixed
                </div>
                <div class="form-check-inline">
                  <input type="radio" class="form-check-input" id="atFlexible" name="at_type" value="Flexible">Flexible
                </div>
              </div>
            </div>
            <hr>
            <div class="form-group">
              <i>Assessment Techniques are generally Examination, Submissive, Feedback/Survey, Rubric based. Each Technique is essentially attached to Assessment Method. If Technique Type is fixed Faculty cannot Change the Assessment Method attached to it and if it is flexible, faculty can change it.</i>
            </div>
          </div>
          <div class="assessmentDesignForm">
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Assessment Name
                  <input type="text" class="form-control form-control-sm" id="ad_name" name="ad_name" placeholder="Name of Assessment">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  Subject
                  <?php
                  $sql = "select sb.* from subject sb where sb.batch_id='$myBatch' and sb.program_id='$myProg' and sb.subject_status='0'";
                  selectList($conn, "Select subject", array("0", "subject_id", "subject_name", "", "sel_subjectAD"), $sql);
                  ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  Technique
                  <?php
                  $sql = "select * from assessment_technique where at_status='0'";
                  selectList($conn, "Select Technique", array("0", "at_id", "at_name", "", "sel_at"), $sql);
                  ?>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  Max Marks
                  <input type="number" class="form-control form-control-sm" id="ad_mm" name="ad_mm" placeholder="Max Marks">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <div class="form-group">
                  Pass Marks
                  <input type="number" class="form-control form-control-sm" id="ad_pm" name="ad_pm" placeholder="Pass Marks">
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  Weight Percent
                  <input type="number" step="0.5" class="form-control form-control-sm" id="ad_weight" name="ad_weight" placeholder="Weight out of 100%">
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  Assessment Units
                  <input type="number" class="form-control form-control-sm" id="ad_question" name="ad_question" placeholder="Question/Rubric in assessment">
                </div>
              </div>
            </div>
            <hr>
            <div class="form-group">
              <i>All assessments are to be considered for CO attainment. However, options may be given for grade calculations. Assessment Units (AU) may or may not be euqal to number of questions in the Assessment, eg, any assessment may have 10 questions but if all the questions are related to one CO, then AU=1. If 3 Questions are related to one CO and other seven to other CO, then AU=2. In the mixed case we should consider AU=1 and it should be mapped with different COs with appropriate weights.</i>
            </div>
          </div>
          <div class="aucoForm">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  Percentage Weight of CO
                  <input type="number" class="form-control form-control-sm" id="auco_weight" name="auco_weight" placeholder="Percent of CO mapped with Assessment">
                  <input type="hidden" id="ad_idM" name="ad_idM">
                  <input type="hidden" id="co_idM" name="co_idM">
                  <input type="hidden" id="au_snoM" name="au_snoM">
                </div>
              </div>
            </div>
            <hr>
            <div class="form-group">
              <i>The data filled here represents the percentage contribution of the Assessment Unit (AU)/Question to the CO Selected. We can set 100% if only one CO is mapped with one AU/Question</i>
            </div>
          </div>
          <div class="auMarksForm">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  Marks of the AU/Question
                  <input type="number" class="form-control form-control-sm" id="au_marks" name="au_marks" placeholder="AU Marks (absolute)">
                </div>
              </div>
            </div>
            <hr>
            <div class="form-group">
              <i>If more questions are grouped to form an Assessment Unit, total marks of the questions are to be added. The marks will be distributed proportionately to each CO in case more than one COs are mapped to AU/Q.</i>
            </div>
          </div>
          <div class="POFForm">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  PO Feedback Name
                  <input type="text" class="form-control form-control-sm" id="pf_name" name="pf_name" placeholder="Name of PO Feedback">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <div class="form-group">
                  Ques
                  <input type="number" class="form-control form-control-sm" id="pf_question" name="pf_question" placeholder="Question">
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  MM
                  <input type="number" class="form-control form-control-sm" id="pf_mm" name="pf_mm" placeholder="Max Marks">
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  Weight(%)
                  <input type="number" step="0.5" class="form-control form-control-sm" id="pf_weight" name="pf_weight" placeholder="Weight out of 100%">
                </div>
              </div>
            </div>
            <hr>
            <div class="form-group">
              <i>The Feedbacks are taken from Alumni, Employer, and Graduating Students. These are part of indirect method of calculating PO attainment.</i>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->
        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" id="modalId" name="modalId">
          <input type="hidden" id="modalProgram" name="modalProgram">
          <input type="hidden" id="modalBatch" name="modalBatch">
          <input type="hidden" id="action" name="action">
          <button type="submit" class="btn btn-success btn-sm" id="submitModalForm">Submit</button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

</html>