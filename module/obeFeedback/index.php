<?php
require('../requireSubModule.php');

?>
<!DOCTYPE html>
<html lang="en">

<style>
  input[type=text] {
    border: none;
    border-bottom: 2px solid;
    word-wrap: break-word;
  }
</style>

<head>
  <title>Outcome Based Education : ClassConnect</title>
  <?php require("../css.php"); ?>
  
</head>

<body>
<?php require("../topBar.php");?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-2">
        <div class="selectPanel">
          <p class="selectPanel m-1 p-0" id="selectPanelTitle"></p>
          <div class="col">
            <div class="row" id="selectPanel">
            </div>
          </div>
        </div>
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active pofDesign" id="list-pof-list" data-toggle="list" href="#list-pof" role="tab" aria-controls="pof"> Design PO Feedback </a>

          <a class="list-group-item list-group-item-action ar" id="list-ar-list" data-toggle="list" href="#list-ar" role="tab" aria-controls="ar"> Assign Respondents </a>

          <a class="list-group-item list-group-item-action sf" id="list-sf-list" data-toggle="list" href="#list-sf" role="tab" aria-controls="sf"> Schedule Feedback </a>

        </div>
      </div>
      <div class="col-10">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane" id="list-ar" role="tabpanel" aria-labelledby="list-ar-list">
            <button class="btn btn-warning btn-round-sm mt-1 mb-2" id="addStudentButton"> Students </button>
            <button class="btn btn-warning btn-round-sm mt-1 mb-2" id="addAlumnitButton"> Alumni </button>
            <button class="btn btn-warning btn-round-sm mt-1 mb-2" id="addFacultyButton"> Faculty </button>
            <button class="btn btn-warning btn-round-sm mt-1 mb-2" id="addEmployerButton"> Employer </button>
            <div id="arStudentShowPanel"></div>
            <div id="arAlumniShowPanel"></div>
            <div id="arFacultyShowPanel"></div>
            <div id="arEmployerShowPanel"></div>
          </div>

          <div class="tab-pane show active" id="list-pof" role="tabpanel" aria-labelledby="list-pof-list">
            <button class="btn btn-warning btn-round-sm mt-1" id="pofbButton">Show/Refresh</button>
            <button class="btn btn-primary btn-round-sm mt-1" id="hfButton">Header/Footer</button>
            <div id="poShowFB"></div>
            <div id="poShowHf"></div>
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


<script>
  $(document).ready(function() {

    $('[data-toggle="popover"]').popover();
    $('[data-toggle="tooltip"]').tooltip();
    $(".topBarTitle").text("Feedback");
    $(document).on('click', '.pofDesign', function() {
      //$.alert("Alumni PO FB ");
      pofFeedbackSelectPlanel("pof");
    });

    $(document).on('click', '#addStudentButton', function() {
      $.alert("Add Student PO FB ");
      pofFeedbackSelectPlanel("dept");
    });

    $(document).on('click', '.tlp', function() {
      //$.alert("TLP FB ");
      pofFeedbackSelectPlanel("TLP");
    });

    $(document).on('click', '.poScaleCopy', function() {
      var x = $("#sel_pf").val();
      if (x === "") $.alert("Please select PO Feedback from Select Panel");
      else {
        var pqId = $(this).attr('data-pq');
        //$.alert(" pqId " + pqId);
        $.post("feedbackSql.php", {
          action: "poCopy",
          pfId: x,
          pqId: pqId
        }, function(mydata, mystatus) {
          //$.alert("- Updated -" + mydata);
          poFeedback(x);
        }, "text").fail(function() {
          $.alert("Error !!");
        })

      }
    });

    $(document).on('click', '#hfButton', function() {
      var x = $("#sel_pf").val();
      if (x === "") $.alert("Please select PO Feedback from Select Panel");
      else hfFeedback(x);
    });

    $(document).on('click', '#pofbButton', function() {
      var x = $("#sel_pf").val();
      if (x === "") $.alert("Please select PO Feedback from Select Panel");
      else poFeedback(x);
    });

    $(document).on('click', '.fbOption', function() {
      var scale = $(this).attr('data-scale');
      var pqId = $(this).attr('data-pq');
      //Confirm Alert Plugin shows Alert Box twice
      $.alert(" PQ " + pqId + "Selected Scale " + scale);
      /*$.post("feedbackSql.php", {
        action: "poOption",
        pqId: pqId,
        scale: scale,
        poOption: value
      }, function(mydata, mystatus) {
        //alert("- Updated -" + mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })*/
    });

    $(document).on('blur', '.poOption', function() {
      var scale = $(this).attr('data-scale');
      var pqId = $(this).attr('data-pq');
      var value = $(this).val();
      //Confirm Alert Plugin shows Alert Box twice
      //alert(" PQ " + pqId + " Scale " + scale + " Entered Value " + value );
      $.post("feedbackSql.php", {
        action: "poOption",
        pqId: pqId,
        scale: scale,
        poOption: value
      }, function(mydata, mystatus) {
        //alert("- Updated -" + mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });

    $(document).on('blur', '.poId', function() {
      var poId = $(this).attr('data-po');
      var pfId = $(this).attr('data-pf');
      var value = $(this).val();
      //Confirm Alert Plugin shows Alert Box twice
      //alert(" Po " + poId + "Pf" + pfId + " Entered Value " + value );
      $.post("feedbackSql.php", {
        action: "pfQuestion",
        poId: poId,
        pfId: pfId,
        pfQuestion: value
      }, function(mydata, mystatus) {
        //alert("- Updated -" + mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });

    function hfFeedback(x) {
      //$.alert("PF " + x );
      $.post("feedbackSql.php", {
        action: "hfFb",
        pfId: x
      }, function(mydata, mystatus) {
        $("#poShowFB").hide();
        $("#poShowHf").show();
        //$.alert("List " + mydata);
        $("#poShowHf").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function poFeedback(x) {
      //$.alert("PF " + x );
      $.post("feedbackSql.php", {
        action: "poFb",
        pfId: x
      }, function(mydata, mystatus) {
        $("#poShowHfB").hide();
        $("#poShowFB").show();
        //$.alert("List " + mydata);
        $("#poShowFB").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function pofFeedbackSelectPlanel(x) {
      //$.alert("POF Function");
      $.post("feedbackSql.php", {
        action: x,
      }, function(mydata, mystatus) {
        $("#selectPanel").show();
        //$.alert("List " + mydata);
        if (x == "pof") $("#selectPanelTitle").text("PO Select Panel");
        else if (x == "TLP") $("#selectPanelTitle").text("TLP Select Panel");
        else if (x == "dept") $("#selectPanelTitle").text("Department Select Panel");
        $("#selectPanel").html(mydata);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

  });
</script>

</html>