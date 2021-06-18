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
      <div class="col-2 p-0 m-0 pl-2 full-height">
          <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active am" id="list-am-list" data-toggle="list" href="#list-am" role="tab" aria-controls="am"> Assessment Master (DAA)</a>
            <a class="list-group-item list-group-item-action sa" id="list-sa-list" data-toggle="list" href="#list-sa" role="tab" aria-controls="sa"> Subject Assessment (SC) </a>
            <a class="list-group-item list-group-item-action da" id="list-da-list" data-toggle="list" href="#list-da" role="tab" aria-controls="da"> Design Assessment (SF/TF) </a>
          </div>
        </div>
        <div class="col-10 leftLinkBody">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane show active" id="list-am" role="tabpanel">
              <div class="row">
                <div class="col-8 mt-1 mb-1">
                  <div class="container card mt-2 myCard">
                    <h5 class="card-title p-2 mb-0"> Design Assessment Map </h5>
                    <form class="form-horizontal" id="amapForm">
                      <div class="row mt-2">
                        <div class="col-3">
                          <label> Grid </label>
                          <p id="selectGrid"></p>
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
                          <input type="hidden" id="action" name="action" value="addGrid">
                          <button type="submit" class="btn btn-sm amap">Next <i class="fa fa-angle-double-right"></i></button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="container card mt-2 myCard">
                    <h5 class="card-title p-2 mb-0"> Existing Assessment Grid </h5>
                    <p id="amapList"></p>
                  </div>
                </div>
                <div class="col-4 mt-1 mb-1" role="tabpanel">

                  <p id="tabList"></p>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="list-sa" role="tabpanel">
              <div class="row">
                <div class="col-7 mt-1 mb-1">
                  <div class="container card mt-2 myCard">
                    <h5 class="card-title p-2 mb-0">Manage Organization Form</h5>

                  </div>
                </div>
                <div class="col-5 mt-1 mb-1">
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
    <p>&nbsp;</p>
  <p>&nbsp;</p>
  <?php require("../bottom_bar.php");?>

  </div>
</body>

<?php require("../js.php"); ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
  $(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip();
    $(".topBarTitle").text("Academics");
    $("#rpAction").val("addRP")
    selectGrid();
    amapList();

    $(document).on('submit', '#amapForm', function(event) {
      event.preventDefault(this);
      var formData = $(this).serialize();
      //$.alert(formData);
      $.post("assessmentSql.php", formData, () => {}, "text").done(function(data, status) {
        //$.alert("List Updtaed" + data);
        amapList();
        selectGrid();
      })
    });

    function amapList() {
      //$.alert("In List Function" + grid);
      $.post("assessmentSql.php", {
        action: "amapList"
      }, function() {}, "text").done(function(data, status) {
        //$.alert(data);
        $("#amapList").html(data);
      }).fail(function() {
        $.alert("Error !!");
      })
    }

    function selectGrid() {
      //$.alert("In List Function");
      $.post("assessmentSql.php", {
        action: "selectGrid"
      }, function() {}, "text").done(function(data, status) {
        //$.alert(data);
        $("#selectGrid").html(data);
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