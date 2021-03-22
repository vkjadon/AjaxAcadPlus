<?php
session_start();
require("../config_database.php");
require('../php_function.php');
include('../phpFunction/onlineFunction.php');
$id = $_GET['id'];
$json = get_testQuestionListJson($conn, $id, "");
//echo $json;
$array = json_decode($json, true);
$totalQuestions = count($array["data"]);
//echo $totalQuestions;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Outcome Based Education : ClassConnect</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <link rel="stylesheet" href="../table.css">
  <link rel="stylesheet" href="../style.css">
</head>

<body>
  <div class="container-fluid">
    <table style="background-color:crimson;" width="100%">
      <tr>
        <td width="10%">
          <div class="digital-clock">00:00:00</div>
        </td>
        <td width="65%">
          <h5></h5>
        </td>
        <td class="text-white">
          <h5><?php echo 'Questions in the Test : ' . $totalQuestions; ?></h5>
        </td>
        <td>
          <form method="post">
            <button type="submit" class="btn btn-light btn-square-sm">ReTest</button>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
          </form>
        </td>
      </tr>
    </table>
    <?php
    if ($totalQuestions > 0) {
      for ($i = 0; $i < $totalQuestions; $i++) {
        $qb[$i] = $array["data"][$i]["qb_id"];
        //echo $qb[$i];
      }
      $currentQuestion = $qb[rand(0, ($totalQuestions - 1))]; //set first question for the test
    } else {
      die("Not a Valid Test Id");
    }
    ?>
    <div class="row">
      <div class="col-sm-2">

        <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active ti" id="list-ti-list" data-toggle="list" href="#list-ti" role="tab"> Test Instructions </a>
          <a class="list-group-item list-group-item-action tq" id="list-tq-list" data-toggle="list" href="#list-tq" role="tab"> Test Question </a>
          <a class="list-group-item list-group-item-action st" id="list-st-list" data-toggle="list" href="#list-st" role="tab"> Start Test </a>
          <a class="list-group-item list-group-item-action tr" id="list-tr-list" data-toggle="list" href="#list-tr" role="tab" aria-controls="tr"> Test Report</a>
        </div>
      </div>

      <div class="col-sm-10">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane show active" id="list-ti" role="tabpanel" aria-labelledby="list-ti-list">
            <div class="row">
              <div class="col-sm-5 mt-1 mb-1">
                <p id="testHeading"></p>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-tq" role="tabpanel" aria-labelledby="list-tq-list">
            <div class="row">
              <div class="col-sm-12">
                <p class="testQuestionList"></p>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-st" role="tabpanel" aria-labelledby="list-st-list">
            <div class="row">
              <div class="col-sm-8  p-0">
                <p class="showQuestion"></p>
              </div>
              <div class="col-sm-4">
                <div class="row">
                  <div class="col-sm-6 p-0">
                    <div class="card-header">
                      Start Time
                      <div id="startTime">
                        <h6><?php echo date("h:i:s", time()); ?></h6>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 pl-0">
                    <div class="card-header">
                      Time Used
                      <div id="stopWatch">0</div>
                    </div>
                  </div>
                </div>
                <span id="currentQuestionId"><?php echo $currentQuestion; ?></span>
                <span id="remainingQuestions"></span>
                <p class="pallete"></p>
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
  // Storing data:

  $(document).ready(function() {
    clockUpdate();
    setInterval(clockUpdate, 1000);
    var response_value = [];
    var qbArray = <?php echo json_encode($qb); ?>;

    $("#instructionForm").hide()
    $("#questionForm").hide()
    testHeading()
    $(".ti").click(function() {
      testHeading()
    });
    $(".tq").click(function() {
      testQuestionList()
    });
    $(".st").click(function() {
      //$.alert("Question ");
      $("#remainingQuestions").html(qbArray);
      getQuestion();
      //pallete();
      var i = 1;
      setInterval(function() {
        var m = Math.floor(i / 60);
        var s = i - m * 60;
        $("#stopWatch").html("<h6>" + m + " min " + s + " Sec</h6>");
        i++;
      }, 1000);
    });

    $(document).on("click", ".nextQuestion", function() {
      var qb_id = $(this).attr("data-qb");
      //$.alert("Get Question " + qb_id + " Response " + response_value)
      const index = qbArray.indexOf(qb_id)+1;
      $.alert("df"+index + " Length " + qbArray.length);
      response_value = [];
      var currentQuestionId = qbArray[index];
      $("#currentQuestionId").html(currentQuestionId);
      getQuestion();
    })

    $(document).on("click", ".submitOption", function() {
      var qb_id = $(this).attr("data-qb");
      var qo_code = $(this).attr("data-code");
      //$.alert("Get Question " + qb_id + " Code " + qo_code + " Response " + response_value)
      $.post("openTestOlatSql.php", {
        response_value: response_value,
        qb_id: qb_id,
        qo_code: qo_code,
        action: "submitOption"
      }, function() {}, "text").done(function(data, status) {
        //$.alert(" Result " + data);
        if (data == "Correct") {
          $.alert("Congratulations!!");
          const index = qbArray.indexOf(qb_id);
          if (index > -1) {
            qbArray.splice(index, 1);
          }
          $("#remainingQuestions").html(qbArray);
          response_value = [];
          var currentQuestionId = qbArray[Math.floor(Math.random() * qbArray.length)];
          //$.alert("JS Array " + qbArray + " Current " + currentQuestionId);
          $("#currentQuestionId").html(currentQuestionId);
          getQuestion();
        } else $.alert("Please Try Again");
      }).fail(function(data) {
        $.alert("Error!!");
      })
    })

    $(document).on("click", ".markOption", function() {
      var qb_id = $(this).attr("data-qb");
      var qo_code = $(this).attr("data-code");
      var status = $("#" + qo_code).html();
      if (status == "") {
        response_value.push(qo_code);
        $("#" + qo_code).html('<i class="fa fa-check"></i>');
      } else {
        $("#" + qo_code).html("");
        const index = response_value.indexOf(qo_code);
        if (index > -1) {
          response_value.splice(index, 1);
        }
      }
      //$.alert(" Response Array " + response_value)
    })


    function getQuestion() {
      var qb_id = $("#currentQuestionId").html();
      //$.alert("Get Question Function  " + qb_id)
      $.post("openTestOlatSql.php", {
        test_id: <?php echo $id ?>,
        qb_id: qb_id,
        action: "getQuestion"
      }, function() {
        //$.alert("Fecth" + mydata);
      }, "text").done(function(data, status) {
        //$.alert(data);
        $(".showQuestion").html(data)
      }).fail(function(data) {
        $.alert("Error!!");
      })
    }

    function testQuestionList() {
      //$.alert("Section  " + selectedSection)
      $.post("openTestOlatSql.php", {
        test_id: <?php echo $id ?>,
        action: "testQuestionList"
      }, function() {
        //$.alert("Fecth" + mydata);
      }, "text").done(function(data, status) {
        //$.alert(data);
        $(".testQuestionList").html(data)
      }).fail(function(data) {
        $.alert("Error www !!");
      })
    }

    function testHeading() {
      //$.alert("In SAS Claim List");
      $.post("openTestOlatSql.php", {
        test_id: <?php echo $id ?>,
        action: "testHeading"
      }, function(data, status) {
        //$.alert("Success " + data);
        $("#testHeading").html(data);
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

    function clockUpdate() {
      var date = new Date();
      $('.digital-clock').css({
        'color': '#fff',
        'text-shadow': '0 0 6px #ff0'
      });

      var h = addZero(twelveHour(date.getHours()));
      var m = addZero(date.getMinutes());
      var s = addZero(date.getSeconds());

      $('.digital-clock').text(h + ':' + m + ':' + s)

      function addZero(x) {
        if (x < 10) {
          return x = '0' + x;
        } else {
          return x;
        }
      }

      function twelveHour(x) {
        if (x > 12) {
          return x = x - 12;
        } else if (x == 0) {
          return x = 12;
        } else {
          return x;
        }
      }
    }
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