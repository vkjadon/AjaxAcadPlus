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
          <a class="list-group-item list-group-item-action ti" id="list-ti-list" data-toggle="list" href="#list-ti" role="tab" aria-controls="ti"> Test Instructions </a>
          <a class="list-group-item list-group-item-action aq" id="list-aq-list" data-toggle="list" href="#list-aq" role="tab" aria-controls="aq"> Add Question </a>
          <a class="list-group-item list-group-item-action pt" id="list-pt-list" data-toggle="list" href="#list-pt" role="tab" aria-controls="pt"> Preview Test </a>
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
          <div class="tab-pane fade" id="list-ti" role="tabpanel" aria-labelledby="list-ti-list">
            <div class="row">
              <div class="col-5 mt-1 mb-1">
                <p id="testHeading"></p>
              </div>
              <div class="col-7 mt-1 mb-1">
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
            </div>
          </div>
          <div class="tab-pane fade" id="list-aq" role="tabpanel" aria-labelledby="list-aq-list">
            <div class="row">
              <div class="col-6 mt-1 mb-1">
                <p id="questionHeading"></p>
                <h5>Section : <span id="selectedSection">1</span></h5>
                <textarea class="content" id="question" name="question"></textarea>
                <input type="hidden" id="actionCode" name="actionCode">
                <button class="btn btn-secondary btn-square-sm addQuestion">Save Question</button>
                <button class="btn btn-warning btn-square-sm addOption">Save Option</button>
              </div>
              <div class="col-6 mt-1 mb-1">
                <p class="showActiveQuestion"></p>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <p class="sectionQuestionList"></p>
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
    height: "320",
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
    $('[data-toggle="popover"]').popover();
    $('[data-toggle="tooltip"]').tooltip();
    $(".topBarTitle").text("Examination");
    $(".selectPanel").show();
    $("#panelId").hide();
    $("#addTestDiv").hide();
    //$("#questionForm").hide()
    testList();

    $(".ti").click(function() {
      //$.alert("Add Question");
      $("#instructionForm").hide()
      $("#questionForm").hide()
      testHeading()
    });
    $(".aq").click(function() {
      //$.alert("Add Question");
      $("#questionForm").show()
      $("#actionCode").val("add")
      questionHeading()
      sectionQuestionList()
      activeQuestion()
    });
    $(document).on("click", ".testQuestion", function() {
      var qb_id = $(this).attr("data-qb")
      var test_id = $(this).attr("data-test")
      var tag = $(this).attr("data-tag")
      $.alert("Id" + qb_id)
      $.post("sectionQuestionListSql.php", {
        qb_id: qb_id,
        test_id: test_id,
        tag: tag,
        action: "testQuestion"
      }, () => {}, "html").done(function(data, status) {
        $.alert(data);
        activeQuestion();
      })
    });
    $(document).on('click', '.trashCP, .trashOption', function() {
      var id = $(this).attr("data-qb");
      var sno = $(this).attr("data-sno");
      var tag = $(this).attr("data-tag");
      //$.alert(" QbId  " + id + " Sno " + sno + " Tag " + tag)
      $.confirm({
        title: 'Confirm!',
        draggable: true,
        content: "Please confirm to delete!! ",
        buttons: {
          confirm: {
            btnClass: 'btn-blue',
            action: function() {
              $.post("onlineSql.php", {
                id: id,
                sno: sno,
                tag: tag,
                action: "delete"
              }, function() {}, "text").done(function(data, status) {
                $.alert(data);
                activeQuestion()
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
    $(document).on('blur', '.checkPoint', function() {
      var qc_sno = $(this).attr("data-sno");
      var qb_id = $(this).attr("data-qb");
      var tag = $(this).attr("data-tag");
      var value = $(this).val();
      //Confirm Alert Plugin shows Alert Box twice
      //alert(" Parameter  " + qc_sno + " QB " + qb_id + " Value " + value + " Tag " + tag);
      $.post("onlineSql.php", {
        qb_id: qb_id,
        qc_sno: qc_sno,
        tag: tag,
        value: value,
        action: "updateCP"
      }, function(mydata, mystatus) {
        //$.alert("Updated!!");
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });
    $(document).on("click", ".updateCP", function() {
      var qb_id = $(this).attr("data-qb");
      var qc_sno = $(this).attr("data-sno");
      var value = $("#newCP").val();
      $.alert(" QbId  " + qb_id + " CP Sno " + qc_sno + " CP " + value)
      $.post("onlineSql.php", {
        qb_id: qb_id,
        qc_sno: qc_sno,
        qc_name: value,
        action: "updateCP"
      }, function() {
        //$.alert("Fecth" + mydata);
      }, "text").done(function(data, status) {
        $.alert(data);
        activeQuestion()
      }).fail(function() {
        $.alert("Error !!");
      })
    });
    $(document).on("click", ".addCheckPoint", function() {
      var qb_id = $(this).attr("data-qb");
      var qc_sno = $(this).attr("data-sno");
      var value = $("#newCP").val();
      var valueMarks = $("#newCPMarks").val();
      $.alert(" QbId  " + qb_id + " CP Sno " + qc_sno + " CP " + value)
      $.post("onlineSql.php", {
        qb_id: qb_id,
        qc_sno: qc_sno,
        qc_name: value,
        qc_marks: valueMarks,
        action: "addCP"
      }, function() {
        //$.alert("Fecth" + mydata);
      }, "text").done(function(data, status) {
        $.alert(data);
        activeQuestion()
      }).fail(function() {
        $.alert("Error !!");
      })
    });
    $(document).on('blur', '.parameter', function() {
      var qp_sno = $(this).attr("data-qp");
      var qb_id = $(this).attr("data-qb");
      var tag = $(this).attr("data-tag");
      var value = $(this).val();
      //Confirm Alert Plugin shows Alert Box twice
      //alert(" Parameter  " + qp_sno + " QB " + qb_id + " Value " + value + " Tag " + tag);
      $.post("onlineSql.php", {
        qb_id: qb_id,
        qp_sno: qp_sno,
        tag: tag,
        value: value,
        action: "updateParameter"
      }, function(mydata, mystatus) {
        //$.alert("Updated!!");
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    });

    $(document).on("click", ".changeOption", function() {
      var qb_id = $(this).attr('data-qb');
      var qo_code = $(this).attr('data-code');
      var change_code = $(this).attr('data-set');
      //$.alert("Qb  " + qb_id + " Code " + qo_code + " Change " + change_code)
      $.post("onlineSql.php", {
        qb_id: qb_id,
        qo_code: qo_code,
        change_code: change_code,
        action: "changeOption"
      }, function() {
        //$.alert("Fecth" + mydata);
      }, "text").done(function(data, status) {
        //$.alert(data);
        activeQuestion()
      }).fail(function() {
        $.alert("Error !!");
      })
    });
    $(document).on("click", ".updateOption", function() {
      var qb_id = $(this).attr("data-qb");
      var qo_code = $(this).attr("data-code");
      var qo_text = $("#option" + qo_code).val();
      if (qo_text === "") $.alert("Option Cannot be Blank!!")
      else {
        //$.alert("Qb  " + qb_id + " Code " + qo_code + " Text " + qo_text)
        $.post("onlineSql.php", {
          qb_id: qb_id,
          qo_code: qo_code,
          qo_text: qo_text,
          action: "updateOption"
        }, function() {
          //$.alert("Fecth" + mydata);
        }, "text").done(function(data, status) {
          $.alert(data);
          //sactiveQuestion()
        }).fail(function() {
          $.alert("Error !!");
        })
      }
    });
    $(document).on("click", ".activeQuestion", function() {
      var qb_id = $(this).attr('data-qb');
      //$.alert("Qb  " + qb_id)
      $.post("onlineSql.php", {
        qb_id: qb_id,
        action: "activeQuestion"
      }, function() {
        //$.alert("Fecth" + mydata);
      }, "text").done(function(data, status) {
        $.alert(data);
        activeQuestion()
      }).fail(function() {
        $.alert("Error !!");
      })
    });
    $(document).on("click", ".addOption", function() {
      var content = tinyMCE.get('question').getContent();
      $.alert("Option  " + content)
      $.post("onlineSql.php", {
        content: content,
        action: "addOption"
      }, function() {
        //$.alert("Fecth" + mydata);
      }, "text").done(function(data, status) {
        $.alert(data);
        activeQuestion()
      }).fail(function() {
        $.alert("Error !!");
      })
    });
    $(document).on("click", ".addQuestion", function() {
      var selectedSection = $("#selectedSection").text()
      var defaultMarks = $("#defaultMarks").val()
      var defaultNMarks = $("#defaultNMarks").val()
      var actionCode = $("#actionCode").val()
      var question = tinyMCE.get('question').getContent();
      $.alert("Section  " + selectedSection + "Question" + question)
      $.post("onlineSql.php", {
        sectionId: selectedSection,
        defaultMarks: defaultMarks,
        defaultNMarks: defaultNMarks,
        question: question,
        actionCode: actionCode,
        action: "addQuestion"
      }, function() {
        //$.alert("Fecth" + mydata);
      }, "text").done(function(data, status) {
        $.alert("Updated!!" + data);
        tinyMCE.get('question').setContent("")
        $("#actionCode").val("add")
        sectionQuestionList()
      }).fail(function() {
        $.alert("Error !!");
      })
    });
    $(document).on('click', '.editQuestion', function() {
      var qb_id = $(this).attr("data-qb")
      //$.alert("Question Id " + qb_id);
      var fileName="../../olat/text/ques-"+qb_id+".txt";
      $.get(fileName, function(data) {
        //$.alert(data)
        tinyMCE.get('question').setContent(data)
      }, 'text');
      $("#actionCode").val("edit")
    });

    $(document).on('click', '.defaultSection', function() {
      var id = $(this).attr('data-section');
      var value = $("#defaultSection" + id).text();
      //$.alert("Decrement " + id + "Value" + value);
      $("#selectedSection").text(value);
    });
    $(document).on('click', '.defaultMarks, .defaultNMarks', function() {
      var id = $(this).attr('id');
      var value = $("." + id).text();
      //$.alert("Decrement " + id + "Value" + value);
      var newValue = Number(value) + 1;
      if (newValue > 0) $("." + id).html(newValue);
      else $("." + id).html(value);
    });

    $(document).on('click', ".newQuestionButton", function() {
      //$.alert("New Question")
      $("#questionForm").toggle();
      var id = $(this).attr("data-test")
      var section = $(this).attr("data-section")
      $.alert("Fetch Question  " + id + " Section " + section);
      $.post("onlineSql.php", {
        testId: id,
        sectionId: section,
        action: "fetchQuestion"
      }, function() {
        //$.alert("Fecth" + mydata);
      }, "json").done(function(data, status) {
        tinyMCE.get('question').setContent(data.qb_text)
        //$.alert("Fecth" + data.content);
      }).fail(function() {
        $.alert("Error !!");
      })
      //$("#action").val("addTest")
    });
    $(document).on("submit", "#instructionForm", function() {
      event.preventDefault(this);
      var formData = $(this).serialize();
      $.alert("Form Submitted " + formData)
      $.post("onlineSql.php", formData, function() {}, "text").done(function(data, success) {
        $.alert(data)
      })
    });
    $(document).on('click', '.showTest', function() {
      var id = $(this).attr("data-test")
      //$.alert("Section Instruction " + id + " Section " + section);
      $.post("onlineSql.php", {
        testId: id,
        action: "showTest"
      }, function() {
        //$.alert("Fecth" + mydata);
      }, "text").done(function(data, status) {
        //$.alert("Fecth" + data.content);
      }).fail(function() {
        $.alert("Error !!");
      })
      $("#instructionHeading").html("<h5>Test Question List/Details</h5>")
      $("#instructionForm").hide()
      $("#questionForm").hide()

    });

    $(document).on('click', '.sectionInstruction', function() {
      var id = $(this).attr("data-test")
      var section = $(this).attr("data-section")
      //$.alert("Section Instruction " + id + " Section " + section);
      $.post("onlineSql.php", {
        testId: id,
        sectionId: section,
        action: "fetchInstruction"
      }, function() {
        //$.alert("Fecth" + mydata);
      }, "json").done(function(data, status) {
        tinyMCE.get('instruction').setContent(data.content)
        //$.alert("Fecth" + data.content);
      }).fail(function() {
        $.alert("Error !!");
      })

      $("#instructionHeading").html("<h5>Instructions : Section - " + section + "</h5>")
      $("#instructionId").val("S")
      $("#action").val("addInstruction")
      $("#instructionForm").show()
      //$("#questionForm").show()
      $("#testId").val(id)
      $("#testIdQuestion").val(id)
      $("#sectionId").val(section)
      $("#sectionIdQuestion").val(section)
      $("#actionQuestion").val("addQuestion")
      questionHeading(section)
    });

    $(document).on('click', '.testInstruction', function() {
      var id = $(this).attr("data-test")
      //$.alert("Test Instruction " + id);
      $.post("onlineSql.php", {
        testId: id,
        action: "fetchInstruction"
      }, function(data, status) {
        //$.alert("Fecth" + data.content);
        tinyMCE.get('instruction').setContent(data.content)
      }, "json").fail(function() {
        $.alert("Error !!");
      })
      $("#instructionForm").show()
      $("#instructionHeading").html("<h5>Instructions : Test </h5>")
      $("#instructionId").val("T")
      $("#testId").val(id)
      $("#questionForm").hide()
      $("#questionHeading").hide()
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

    function activeQuestion() {
      var selectedSection = $("#selectedSection").text()
      //$.alert("Section  " + selectedSection)
      $.post("sectionQuestionListSql.php", {
        sectionId: selectedSection,
        action: "activeQuestion"
      }, function() {
        //$.alert("Fecth" + mydata);
      }, "text").done(function(data, status) {
        //$.alert(data);
        $(".showActiveQuestion").html(data)
      }).fail(function() {
        $.alert("Error !!");
      })
    }

    function sectionQuestionList() {
      var selectedSection = $("#selectedSection").text()
      //$.alert("Section  " + selectedSection)
      $.post("sectionQuestionListSql.php", {
        sectionId: selectedSection,
        action: "sectionQuestionList"
      }, function() {
        //$.alert("Fecth" + mydata);
      }, "text").done(function(data, status) {
        //$.alert(data);
        $(".sectionQuestionList").html(data)
      }).fail(function() {
        $.alert("Error !!");
      })
    }

    function questionHeading(section) {
      //$.alert("In SAS Claim List");
      $.post("onlineSql.php", {
        action: "questionHeading"
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#questionHeading").show()
        $("#questionHeading").html(data);
      }, "text").fail(function() {
        $.alert("Error !!");
      })
    }

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
<script>
  $(document).on('click', '.upload', function() {
    var uploadId = $(this).attr("data-upload");
    $.alert("Upload Id" + uploadId);
    $("#uploadId").val(uploadId);
    $('#uploadModal').modal('show');

  });

  $(document).on('submit', '#uploadModalForm', function(event) {
    event.preventDefault();
    var formData = $(this).serialize();
    $.alert(formData);
    // action and uploadId are passed as hidden
    $.ajax({
      url: "uploadSql.php",
      method: "POST",
      data: new FormData(this),
      contentType: false, // The content type used when sending data to the server.  
      cache: false, // To unable request pages to be cached  
      processData: false, // To send DOMDocument or non processed data file it is set to false  
      success: function(data) {
        $.alert("List " + data);
        $('#uploadModal').modal('hide');
      }
    })
  });
</script>
<!-- Modal Section-->
<div class="modal" id="uploadModal">
  <div class="modal-dialog modal-md">
    <form class="form-horizontal" id="uploadModalForm">
      <div class="modal-content bg-secondary text-white">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Upload Document</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> <!-- Modal Header Closed-->

        <!-- Modal body -->
        <div class="modal-body">
          <div class="uploadForm">
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <input type="file" name="upload_file">
                </div>
              </div>
            </div>
          </div>
        </div> <!-- Modal Body Closed-->
        <!-- Modal footer -->
        <div class="modal-footer">
          <input type="hidden" name="action" value="upload">
          <input type="hidden" id="uploadId" name="uploadId">
          <button type="submit" class="btn btn-success btn-sm">Submit</button>
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div> <!-- Modal Footer Closed-->
      </div> <!-- Modal Conent Closed-->
    </form>
  </div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

</html>