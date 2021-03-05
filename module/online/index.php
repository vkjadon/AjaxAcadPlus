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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <link rel="stylesheet" href="../../table.css">
  <link rel="stylesheet" href="../../style.css">
</head>

<body>
  <?php require("../topBar.php"); ?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-2">
        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active mt" id="list-mt-list" data-toggle="list" href="#list-mt" role="tab" aria-controls="mt"> Manage Test </a>
          <a class="list-group-item list-group-item-action aq" id="list-aq-list" data-toggle="list" href="#list-aq" role="tab" aria-controls="aq"> Add Question </a>
          <a class="list-group-item list-group-item-action mu" id="list-mu-list" data-toggle="list" href="#list-mu" role="tab" aria-controls="mu"> Manage Users </a>
          <a class="list-group-item list-group-item-action at" id="list-at-list" data-toggle="list" href="#list-at" role="tab" aria-controls="at"> Announce Test </a>
          <a class="list-group-item list-group-item-action tr" id="list-tr-list" data-toggle="list" href="#list-tr" role="tab" aria-controls="tr"> Test Report</a>
        </div>
      </div>

      <div class="col-10">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane show active" id="list-mt" role="tabpanel" aria-labelledby="list-mt-list">
            <div class="row">
              <div class="col-6 mt-1 mb-1"><button class="btn btn-secondary btn-square-sm mt-1 addTestButton">New Test</button>
                <div class="card" id="addTestDiv">
                  <form id="addTestForm">
                    <div class="card-body bg-secondary">
                      <div class="row">
                        <div class="col-9">
                          <input type="text" name="test_name" id="test_name" data-toggle="tooltip" title="xyz" class="form-control form-control-sm" />
                        </div>
                        <div class="col-3">
                          <input type="hidden" id="action" name="action">
                          <button type="submit" class="btn btn-danger btn-sm submitAddTestForm">Submit</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <p id="testList"></p>
              </div>
              <div class="col-6 mt-1 mb-1" id="testRight">
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="list-aq" role="tabpanel" aria-labelledby="list-aq-list">
            <div class="row">
              <div class="col-6 mt-1 mb-1">
                <p id="testHeading"></p>
                <p id="instructionHeading"></p>
                <form class="instructionForm" id="instructionForm">
                  <div class="form-group row">
                    <div class="col-sm-12">
                      <textarea class="content" id="instruction" name="instruction"></textarea>
                    </div>
                  </div>
                  <input type="hidden" id="instructionId" name="instructionId">
                  <input type="hidden" id="testId" name="testId">
                  <input type="hidden" id="sectionId" name="sectionId">
                  <button class="btn btn-secondary btn-square-sm saveNotice">Save</button>
                </form>
              </div>
              <div class="col-6 mt-1 mb-1">
                <p id="questionList"></p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.tiny.cloud/1/xjvk0d07c7h90fry9yq9z0ljb019ujam91eo2jk8uhlun307/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: 'textarea',
    plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    toolbar_mode: 'floating',
    height: "220",
  });
</script>

<script>
  $(document).ready(function() {
    $(document).on('click', '.checkAll', function() {
      var id = $("#panelId").text();
      //$.alert("Panel Id" + id);
      if (id == "CS") $('.sclCS').prop('checked', true); // Checks it
      else $('.scb').prop('checked', true); // Checks it

    });

    $(document).on('click', '.uncheckAll', function() {
      var id = $("#panelId").text();
      //$.alert("Panel Id" + id);
      if (id == "CS") $('.sclCS').prop('checked', false);
      else $('.scb').prop('checked', false);

    });
    //$('[data-toggle="popover"]').popover();

    $(".topBarTitle").text("Examination");
    $(".selectPanel").show();
    $("#panelId").hide();
    $("#addTestDiv").hide();
    testList();

    $(".aq").click(function() {
      //$.alert("Add Question");
      $("#instructionForm").hide()
      testHeading()
    });

    $(document).on("submit", "#instructionForm", function() {
      event.preventDefault(this);
      var formData = $(this).serialize();
      $.alert("Form Submitted " + formData)
      $.post("onlineSql.php", formData, function() {}, "text").done(function(data, success) {
        $.alert(data)
      })
    });

    $(document).on('click', '.sectionInstruction', function() {
      var id = $(this).attr("data-test")
      var section = $(this).attr("data-section")
      $.alert("Section Instruction " + id + " Section " + section);
      $.post("onlineSql.php", {
        testId: id,
        sectionId : section,
        action: "fetchInstruction"
      }, function() {
        //$.alert("Fecth" + mydata);
      }, "text").done(function(data,status) {
        //tinyMCE.get('content').setContent(data.content)
        $.alert("Fecth" + data);
      }).fail(function() {
        $.alert("Error !!");
      })

      $("#instructionHeading").html("<h5>Instructions : Section - " + section + "</h5>")
      $("#instructionId").val("S")
      $("#action").val("addInstruction")
      $("#instructionForm").show()
      $("#testId").val(id)
      $("#sectionId").val(section)

    });

    $(document).on('click', '.testInstruction', function() {
      var id = $(this).attr("data-test")
      var section = $(this).attr("data-section")
      $.alert("Section Instruction " + id + " Section " + section);
      $.post("onlineSql.php", {
        testId: id,
        sectionId : section,
        action: "fetchInstruction"
      }, function() {
        //$.alert("Fecth" + mydata);
      }, "text").done(function(data,status) {
        //tinyMCE.get('content').setContent(data.content)
        $.alert("Fecth" + data);
      }).fail(function() {
        $.alert("Error !!");
      })
      $("#instructionForm").show()
      $("#instructionHeading").html("<h5>Instructions : Test </h5>")
      $("#instructionId").val("T")
      $("#testId").val(id)
      $("#sectionId").val("-")
    });

    $(".addTestButton").click(function() {
      $("#addTestDiv").toggle();
      $("#action").val("addTest")
    });

    $(document).on("click", ".setActiveButton", function() {
      var id = $(this).attr("data-test")
      //$.alert("Id" + id)
      $.post("onlineSql.php", {
        id: id,
        action: "setActive"
      }, () => {}, "html").done(function(data, status) {
        $.alert(data);
        testList();
      })
    });

    $(document).on("click", ".addQuestionButton", function() {
      var id = $(this).attr("data-test")
      $.alert("Id " + id);
      $.post("onlineSql.php", {
        action: "addQuestion"
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#testRight").html(data);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });

    $(document).on("click", ".removeTestButton", function() {
      var id = $(this).attr("data-test")
      //$.alert("Id" + id)
      $.post("onlineSql.php", {
        id: id,
        action: "removeTest"
      }, () => {}, "html").done(function(data, status) {
        $.alert(data);
        testList();
      })
    });

    $(document).on("submit", "#addTestForm", function() {
      event.preventDefault(this);
      var formData = $(this).serialize();
      $.alert("Form Submitted " + formData)
      $.post("onlineSql.php", formData, function() {}, "text").done(function(data, success) {
        $.alert(data)
        $('#addTestForm')[0].reset();
        $("#addTestDiv").hide();
        testList()
      })
    });

    $(document).on('click', '.decrement', function() {
      var id = $(this).attr('id');
      var value = $("." + id).text();
      //$.alert("Decrement " + id + "Value" + value);
      $.post('onlineSql.php', {
        action: "decrement",
        id: id,
        value: value
      }, function(data, status) {
        var newValue = Number(value) - 1;
        if (newValue > 0) $("." + id).html(newValue);
        else $("." + id).html(value);
        //$.alert("Updated !! " + data);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });

    $(document).on('click', '.increment', function() {
      var id = $(this).attr('id');
      var value = $("." + id).text();
      //$.alert("Increment " + id + "Value" + value);
      $.post('onlineSql.php', {
        action: "increment",
        id: id,
        value: value
      }, function(data, status) {
        var newValue = Number(value) + 1;
        $("." + id).html(newValue);
        //$.alert("Updated !! " + data);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });

    function testHeading() {
      //$.alert("In SAS Claim List");
      $.post("onlineSql.php", {
        action: "testHeading"
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#testHeading").html(data);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function testQuestionList() {
      //$.alert("In SAS Claim List");
      $.post("onlineSql.php", {
        action: "testQuestionList"
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#testRight").html(data);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

    function testList() {
      //$.alert("In SAS Claim List");
      $.post("onlineSql.php", {
        action: "testList"
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#testList").html(data);
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

</html>